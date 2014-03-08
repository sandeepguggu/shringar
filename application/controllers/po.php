<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Po extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            redirect('login?error_msg=' . urlencode("Please Login"));
        }
        $this->ajax = false;
        $this->json = false;
        if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) || isset($_REQUEST['tabs']) && $_REQUEST['tabs'] == 1) {
            $this->ajax = true;
        }
        if (isset($_REQUEST['json']) && $_REQUEST['json'] == 1) {
            $this->json = true;
        }
        $this->load->model('User', 'user');
        $this->load->model('Product_Model', 'product');
        $this->load->model('Product_header_Model', 'product_header');
        $this->load->model('Vendor_Model', 'vendor');
        $this->load->model('Po_Model', 'po');
        $this->load->model('Item_entity_Model', 'item_entity');
        $this->load->model('metal_model', 'metal');
        $this->load->model('stone_model', 'stone');
        $this->load->model('ornament_model', 'ornament');
        $this->load->library('barcode', 'barcode');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $p = array();
        if ($this->manageUsers->isAccessAllowed('purchase_order') === FALSE) {
            $p['access'] = "Access Denied";
        }
        $this->load->model('item_entity_model', 'item_entity');
        $p = array();
        if ($this->input->post('load_from') == 'review') {
            $p = $this->input->post(NULL, TRUE);
        }
        $p['entities'] = $this->item_entity->getAllItemEntities();
        $p['branch'] = $this->user->getBranch();
        $this->_my_output('index', $p);
    }

    public function saved()
    {
        $p = array();
        if ($this->manageUsers->isAccessAllowed('purchase_order') === FALSE) {
            $p['access'] = "Access Denied";
        }
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "po.id as id", "Vendor Name" => "v.company_name as company_name",
            "Address" => "v.address as address", "City" => "v.city as city",
            "Created By" => "u.name as name", "PO Date" => "po.po_date as po_date",
            "Delivery Date" => "po.delivery_date as delivery_date");
        $table = " `purchase_order` po, `vendors` v, `users` u ";
        $where = " WHERE po.vendor_id = v.id AND po.user_id = u.id and po.deleted = '0' ";
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('po/printpo/'), "css" => "btn btn-primary action-btn")
        );
        $orderby = " ORDER BY po.created_at ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('saved', $p);
    }

    public function review()
    {
        if (count($_REQUEST) == 0)
            redirect('po');
        //print_r($_REQUEST);
        $vendor_id = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : '';
        $vendor = $this->vendor->getById($vendor_id);
        $request_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
        //$request_id = '25_'.$request_id;
        $products = array();
        $total_po_price = 0;
        foreach ($_REQUEST['item_id'] as $p) {
            //$id = $_REQUEST['item_specific_id_'.$p];
            $item_entity_id_array = explode('_', $p);
            //log_message('error', "in request thing::Item ID ARRAY::".print_r($item_entity_id_array, 1));
            //row count will be used in case of multiple ornaments of same header
            $row_count = isset($item_entity_id_array[2]) ? $item_entity_id_array[2] : '0';
            $item_entity_id_absolute = $item_entity_id_array[0];
            $id = $item_entity_id_array[1];
            $entity = $this->item_entity->getEntityById($item_entity_id_absolute);
            $name = $entity['name'];
            $tmp = $this->{$name}->getById($id);
            //$tmp['po_box'] = isset($_REQUEST['no_of_box_' . $p]) ? $_REQUEST['no_of_box_' . $p] : 1;
            $tmp['quantity'] = isset($_REQUEST['quantity_' . $p]) ? $_REQUEST['quantity_' . $p] : 1;
            $tmp['weight'] = isset($_REQUEST['weight_' . $p]) ? $_REQUEST['weight_' . $p] : 1;
            $tmp['price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
            $tmp['sub_total'] = $tmp['quantity'] * $tmp['price'];
            $total_po_price += $tmp['sub_total'];
            $tmp['name'] = isset($_REQUEST['name_' . $p]) ? $_REQUEST['name_' . $p] : 0;
            $tmp['item_entity_id'] = $item_entity_id_absolute;
            $tmp['item_specific_id'] = $id;
            if ($row_count > 0) {
                if (isset($_REQUEST['sub_item_id_' . $row_count]) && is_array($_REQUEST['sub_item_id_' . $row_count])) {
                    foreach ($_REQUEST['sub_item_id_' . $row_count] as $sub_item_id) {
                        $sub_id_array = explode('_', $sub_item_id);
                        $sub_item_entity_id = $sub_id_array[0];
                        $sub_item_specific_id = $sub_id_array[1];
                        $sub_item_quantity = isset($_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count] : 1;
                        $sub_weight = isset($_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
                        $type = $sub_entity['display_name'];
                        $sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
                        $tmp['items'][] = array('sub_entity_id' => $sub_item_entity_id, 'sub_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'], 'row_count' => $row_count, 'sub_quantity' => $sub_item_quantity, 'sub_weight' => $sub_weight);
                    }
                }
                $tmp['attributes'] = array();
                if (isset($_REQUEST['attribute_id_' . $p])) {
                    foreach ($_REQUEST['attribute_id_' . $p] as $attribute_id) {
                        $attribute['id'] = $attribute_id;
                        $attribute['name'] = trim($_REQUEST['attribute_name_' . $p . '_' . $attribute_id]);
                        $attribute['display_name'] = trim($_REQUEST['attribute_display_name_' . $p . '_' . $attribute_id]);
                        $attribute['value'] = trim($_REQUEST['attribute_value_' . $p . '_' . $attribute_id]);
                        $tmp['attributes'][] = $attribute;
                    }
                }
            }
            $products[$p] = $tmp;
        }
        $po_products = array();
        $params = array();
        $params['po'] = isset($_REQUEST['po']) ? $_REQUEST['po'] : '';
        $params['po_products'] = $po_products;
        $params['selected_products'] = $products;
        $params['vendor'] = $vendor;
        $params['po_date'] = isset($_REQUEST['po_date']) ? $_REQUEST['po_date'] : '';
        $params['delivery_date'] = isset($_REQUEST['delivery_date']) ? $_REQUEST['delivery_date'] : '';
        $params['vendor_contact_person_name'] = isset($_REQUEST['vendor_contact_person_name']) ? $_REQUEST['vendor_contact_person_name'] : '';
        $params['vendor_contact_person_phone'] = isset($_REQUEST['vendor_contact_person_phone']) ? $_REQUEST['vendor_contact_person_phone'] : '';
        $params['vendor_contact_person_update_db'] = isset($_REQUEST['vendor_contact_person_update_db']) ? $_REQUEST['vendor_contact_person_update_db'] : 0;
        $params['payment_terms'] = isset($_REQUEST['payment_terms']) ? $_REQUEST['payment_terms'] : '';
        $params['pay_days'] = isset($_REQUEST['pay_days']) ? $_REQUEST['pay_days'] : '';
        $params['pay_on_date'] = isset($_REQUEST['pay_on_date']) ? $_REQUEST['pay_on_date'] : '';
        $params['vendor_person_id'] = isset($_REQUEST['vendor_person_id']) ? $_REQUEST['vendor_person_id'] : '';
        $params['total_po_price'] = $total_po_price;
        $params['output'] = $params;
        $this->_my_output('review', $params);
    }

    public function confirmed()
    {
        if (count($_REQUEST) == 0)
            redirect('po');
        //print_r($_REQUEST);
        $vendor_id = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : '';
        $vendor = $this->vendor->getById($vendor_id);
        $request_id = isset($_REQUEST['item_id']) ? $_REQUEST['item_id'] : '';
        //$request_id = '25_'.$request_id;
        $products = array();
        $total_po_price = 0;
        foreach ($_REQUEST['item_id'] as $p) {
            //$id = $_REQUEST['item_specific_id_'.$p];
            $item_entity_id_array = explode('_', $p);
            //log_message('error', "in request thing::Item ID ARRAY::".print_r($item_entity_id_array, 1));
            //row count will be used in case of multiple ornaments of same header
            $row_count = isset($item_entity_id_array[2]) ? $item_entity_id_array[2] : '0';
            $item_entity_id_absolute = $item_entity_id_array[0];
            $id = $item_entity_id_array[1];
            $entity = $this->item_entity->getEntityById($item_entity_id_absolute);
            $name = $entity['name'];
            $tmp = $this->{$name}->getById($id);
            //$tmp['po_box'] = isset($_REQUEST['no_of_box_' . $p]) ? $_REQUEST['no_of_box_' . $p] : 1;
            $tmp['quantity'] = isset($_REQUEST['quantity_' . $p]) ? $_REQUEST['quantity_' . $p] : 1;
            $tmp['weight'] = isset($_REQUEST['weight_' . $p]) ? $_REQUEST['weight_' . $p] : 1;
            $tmp['price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
            $tmp['sub_total'] = $tmp['quantity'] * $tmp['price'];
            $total_po_price += $tmp['sub_total'];
            $tmp['name'] = isset($_REQUEST['name_' . $p]) ? $_REQUEST['name_' . $p] : 0;
            $tmp['item_entity_id'] = $item_entity_id_absolute;
            $tmp['item_specific_id'] = $id;
            if ($row_count > 0) {
                if (isset($_REQUEST['sub_item_id_' . $row_count]) && is_array($_REQUEST['sub_item_id_' . $row_count])) {
                    foreach ($_REQUEST['sub_item_id_' . $row_count] as $sub_item_id) {
                        $sub_id_array = explode('_', $sub_item_id);
                        $sub_item_entity_id = $sub_id_array[0];
                        $sub_item_specific_id = $sub_id_array[1];
                        $sub_item_quantity = isset($_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count] : 1;
                        $sub_weight = isset($_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
                        $type = $sub_entity['display_name'];
                        $sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
                        $tmp['items'][] = array('sub_entity_id' => $sub_item_entity_id, 'sub_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'], 'row_count' => $row_count, 'sub_quantity' => $sub_item_quantity, 'sub_weight' => $sub_weight);
                    }
                }
                $tmp['attributes'] = array();
                if (isset($_REQUEST['attribute_id_' . $p])) {
                    foreach ($_REQUEST['attribute_id_' . $p] as $attribute_id) {
                        $attribute['id'] = $attribute_id;
                        $attribute['name'] = trim($_REQUEST['attribute_name_' . $p . '_' . $attribute_id]);
                        $attribute['display_name'] = trim($_REQUEST['attribute_display_name_' . $p . '_' . $attribute_id]);
                        $attribute['level'] = trim($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]);
                        if ($attribute['level'] == '' || is_null($attribute['level']) || $attribute['level'] == 'null') {
                            //calculate the level and set here
                            if ($attribute_id < 0) {
                                $attribute['level'] = 1;
                            } else {
                                $attribute['level'] = 2;
                            }
                        }
                        $attribute['value'] = trim($_REQUEST['attribute_value_' . $p . '_' . $attribute_id]);
                        $attribute['read_only'] = isset($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) : 0;
                        // product belongs to SKU so add to attribute
                        $tmp['attributes'][] = $attribute;
                    }
                }
            }
            $products[$p] = $tmp;
        }
        $po_products = array();
        $params = array();
        $params['po'] = isset($_REQUEST['po']) ? $_REQUEST['po'] : '';
        $params['po_products'] = $po_products;
        $params['selected_products'] = $products;
        //$params['vendor'] = $this->load->view('po/po_vendor', $vendor, true);
        $params['vendor'] = $vendor;
        $params['po_date'] = isset($_REQUEST['po_date']) ? $_REQUEST['po_date'] : '';
        $params['delivery_date'] = isset($_REQUEST['delivery_date']) ? $_REQUEST['delivery_date'] : '';
        $params['vendor_contact_person_name'] = isset($_REQUEST['vendor_contact_person_name']) ? $_REQUEST['vendor_contact_person_name'] : '';
        $params['vendor_contact_person_phone'] = isset($_REQUEST['vendor_contact_person_phone']) ? $_REQUEST['vendor_contact_person_phone'] : '';
        $params['vendor_contact_person_update_db'] = isset($_REQUEST['vendor_contact_person_update_db']) ? $_REQUEST['vendor_contact_person_update_db'] : 0;
        $params['payment_terms'] = isset($_REQUEST['payment_terms']) ? $_REQUEST['payment_terms'] : '';
        $params['pay_days'] = isset($_REQUEST['pay_days']) ? $_REQUEST['pay_days'] : '';
        $params['pay_on_date'] = isset($_REQUEST['pay_on_date']) ? $_REQUEST['pay_on_date'] : '';
        $params['vendor_person_id'] = isset($_REQUEST['vendor_person_id']) ? $_REQUEST['vendor_person_id'] : '';
        $params['total_po_price'] = $total_po_price;
        $params['branch_id'] = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : 1;
        if ($params['vendor_contact_person_update_db'] == 1) {
            $vendor_person_id = $this->vendor->add_person($vendor_id, $params['vendor_contact_person_name'], $params['vendor_contact_person_phone']);
        } else {
            $vendor_person_id = $params['vendor_person_id'];
        }
        //TODO - modify this add statements to match with current scenario
        $po_id = $this->po->create($this->user->loggedInUserId(), $vendor_id, $vendor_person_id, $total_amount = 0, $params['payment_terms'], $params['pay_days'], $params['pay_on_date'], $params['po_date'], $params['delivery_date'], json_encode($params));
        foreach ($products as $product) {
            $this->po->addItem($po_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['price'], 'grn_date', $params['branch_id'], json_encode($product), $product['weight'], $product['attributes']);
        }
        $pout = array();
        if ($this->db->trans_status() === FALSE) {
            $po_id = 0;
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        //print_r($params);
        redirect('po/printpo/' . $po_id);
    }

    public function printpo($id = '', $print = 0)
    {
        if ($id == '') {
            if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
                redirect('po');
            }
            $id = $_REQUEST['id'];
        }
        $params = array();
        if ($id == 0) {
            $params['status'] = $id;
            $this->_my_output('printpo', $params);
            return;
        } else {
            $params['status'] = 1;
            $po_full = $this->po->getById($id);
            if (!$po_full || !is_array($po_full) || count($po_full) < 1) {
                $params['status'] = 0;
                $params['error_msg'] = 'No PO associated with this ID!';
                $this->_my_output('printpo', $params);
                return;
            }
            $p = json_decode($po_full['full_json'], TRUE);
            $p['po_id'] = $id;
            $item_entity_id = $this->item_entity->getEntityId('po');
            $p['barcode'] = $this->barcode->getBarcode($item_entity_id, $id);
            $p['print'] = $print;
        }
        $params['output'] = $p;
        if (!$print) {
            $this->_my_output('printpo', $params);
        } else {
            $this->load->view('header_print', array());
            $this->load->view('po/printpo', $params);
            $this->load->view('footer_print', array());
        }
    }

    public function _my_output($file = 'po', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "purchase_order";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('po/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
/*END OF FILE*/