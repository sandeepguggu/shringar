<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Grn extends CI_Controller
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
        $this->load->model('Vendor_Model', 'vendor');
        $this->load->model('po_model', 'po');
        $this->load->model('item_entity_model', 'item_entity');
        $this->load->model('metal_model', 'metal');
        $this->load->model('stone_model', 'stone');
        $this->load->model('ornament_model', 'ornament');
        $this->load->model('category_model', 'category');
        $this->load->model('ornament_product_model', 'ornament_product');
        $this->load->model('grn_model', 'grn');
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('product_header_model', 'product_header');
        $this->load->model('product_sku_model', 'product_sku');
        $this->load->library('productLib', array());
        $this->load->library('barcode', array());
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $p = array();
        if ($this->user->isAccessAllowed('grn') === FALSE) {
            $p['access'] = "Access Denied";
        }
        if (isset($_REQUEST['load_from']) && $_REQUEST['load_from'] = 'review') {
            $p['po'] = isset($_REQUEST['po']) ? $_REQUEST['po'] : 0;
            $p['grn_date'] = isset($_REQUEST['grn_date']) ? $_REQUEST['grn_date'] : '01/01/2000';
            $p['vendor_id'] = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : 0;
            if ($p['vendor_id'] > 0) {
                $v_details = $this->vendor->getById($p['vendor_id']);
                if (isset($v_details) && is_array($v_details)) {
                    $p['vendor_html'] = $this->load->view('grn/grn_vendor', $v_details, TRUE);
                    //log_message('debug', $p['vendor_html']);
                } else {
                    $p['vendor_html'] = '';
                }
            }
            $p['product_html'] = '';
            foreach ($_REQUEST['selected_product_id'] as $sp) {
                $row = array();
                $row['name'] = '';
                $row['id'] = $sp;
                $row['box'] = $_REQUEST['no_of_box_' . $sp];
                $row['qnt'] = $_REQUEST['qnt_' . $sp];
                $row['price'] = $_REQUEST['purchase_price_' . $sp];
                $p['product_html'] .= $this->load->view('grn/grn_product', $row, true);
            }
        }
        $p['entities'] = $this->item_entity->getAllItemEntities();
        $this->_my_output('index', $p);
    }

    public function review()
    {
        $vendor_id = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : '';
        $vendor = $this->vendor->getById($vendor_id);
        $vendor['grn_date'] = isset($_REQUEST['delivery_date']) ? $_REQUEST['delivery_date'] : '';
        $vendor['po_date'] = isset($_REQUEST['po_date']) ? $_REQUEST['po_date'] : '';
        $total_grn_price = 0;
        $products = array();
        foreach ($_REQUEST['item_id'] as $p) {
            $item_entity_id_array = explode('_', $p);
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
            $category = $this->category->getProductCategoryById($tmp['category_id']);
            $tmp['vat_rate'] = $category['vat_percentage'];
            $tmp['sub_total'] = $tmp['price'] * $tmp['quantity'] * $tmp['weight'];
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
                        $sub_rate = isset($_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_price = $sub_item_quantity * $sub_weight * $sub_rate;
                        $sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
                        $type = $sub_entity['display_name'];
                        $tmp['sub_total'] += $sub_price;
                        $sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
                        $tmp['items'][] = array('sub_entity_id' => $sub_item_entity_id, 'sub_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'],
                            'row_count' => $row_count, 'sub_quantity' => $sub_item_quantity, 'sub_weight' => $sub_weight, 'sub_price' => $sub_price, 'sub_rate' => $sub_rate);
                    }
                }
                $tmp['attributes'] = array();
                if (isset($_REQUEST['attribute_id_' . $p])) {
                    foreach ($_REQUEST['attribute_id_' . $p] as $attribute_id) {
                        $attribute['id'] = $attribute_id;
                        $attribute['name'] = trim($_REQUEST['attribute_name_' . $p . '_' . $attribute_id]);
                        $attribute['value'] = trim($_REQUEST['attribute_value_' . $p . '_' . $attribute_id]);
                        $attribute['level'] = isset($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) : '';
                        if ($attribute['level'] == '') {
                            //calculate the level and set here
                        }
                        $tmp['attributes'][] = $attribute;
                    }
                }
            }
            //$tmp['sub_total'] += $tmp['sub_total'] * $tmp['vat_rate'] / 100;
            $total_grn_price += $tmp['sub_total'];
            $products[$p] = $tmp;
        }
        $po_products = array();
        $params = array();
        $params['total_grn_price'] = $total_grn_price;
        $params['po'] = isset($_REQUEST['po']) ? $_REQUEST['po'] : '';
        $params['po_products'] = $po_products;
        $params['selected_products'] = $products;
        $params['vendor'] = $vendor;
        //$params['vendor'] = $this->load->view('grn/grn_vendor', $vendor, true);
        log_message('error', "IN GRN PARAMS::" . print_r($params, 1));
        $params['output'] = $params;
        $this->_my_output('review', $params);
    }

    public function confirmed()
    {
        $params = array();
        $vendor_id = isset($_REQUEST['vendor_id']) ? $_REQUEST['vendor_id'] : '';
        $vendor = $this->vendor->getById($vendor_id);
        $vendor['grn_date'] = isset($_REQUEST['delivery_date']) ? $_REQUEST['delivery_date'] : '';
        $vendor['po_date'] = isset($_REQUEST['po_date']) ? $_REQUEST['po_date'] : '';
        $total_grn_price = 0;
        $branch_id = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();
        $products = array();
        $params['vendor'] = $vendor;
        foreach ($_REQUEST['item_id'] as $p) {
            $item_entity_id_array = explode('_', $p);
            //row count will be used in case of multiple ornaments of same header
            $row_count = isset($item_entity_id_array[2]) ? $item_entity_id_array[2] : '0';
            $item_entity_id_absolute = $item_entity_id_array[0];
            $id = $item_entity_id_array[1];
            $entity = $this->item_entity->getEntityById($item_entity_id_absolute);
            $name = $entity['name'];
            $tmp = $this->{$name}->getById($id);
            $tmp['model_name'] = $name;
            //$tmp['po_box'] = isset($_REQUEST['no_of_box_' . $p]) ? $_REQUEST['no_of_box_' . $p] : 1;
            $tmp['quantity'] = isset($_REQUEST['quantity_' . $p]) ? $_REQUEST['quantity_' . $p] : 1;
            $tmp['weight'] = isset($_REQUEST['weight_' . $p]) ? $_REQUEST['weight_' . $p] : 1;
            $tmp['max_discount'] = isset($_REQUEST['max_discount_' . $p]) ? $_REQUEST['max_discount_' . $p] : 100;
            $tmp['purchase_price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
            $category = $this->category->getProductCategoryById($tmp['category_id']);
            $tmp['vat_rate'] = $category['vat_percentage'];
            $tmp['sub_total'] = $tmp['purchase_price'] * $tmp['quantity'] * $tmp['weight'];
            $tmp['item_entity_id'] = $item_entity_id_absolute;
            $tmp['item_specific_id'] = $id;
            if (isset($entity['is_header']) && $entity['is_header']) {
                $tmp['header_product_id'] = $entity['product_entity_id'];
                $header_entity_array = $this->item_entity->getEntityById($tmp['header_product_id']);
                $tmp['header_product'] = $header_entity_array['name'];
            }
            if ($row_count > 0) {
                if (isset($_REQUEST['sub_item_id_' . $row_count]) && is_array($_REQUEST['sub_item_id_' . $row_count])) {
                    foreach ($_REQUEST['sub_item_id_' . $row_count] as $sub_item_id) {
                        $sub_id_array = explode('_', $sub_item_id);
                        $sub_item_entity_id = $sub_id_array[0];
                        $sub_item_specific_id = $sub_id_array[1];
                        $sub_item_quantity = isset($_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count] : 1;
                        $sub_weight = isset($_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_rate = isset($_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count] : 0;
                        $sub_price = $sub_item_quantity * $sub_weight * $sub_rate;
                        $sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
                        $type = $sub_entity['display_name'];
                        $tmp['sub_total'] += $sub_price;
                        $sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
                        $tmp['items'][] = array('item_entity_id' => $sub_item_entity_id, 'item_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'],
                            'row_count' => $row_count, 'quantity' => $sub_item_quantity, 'weight' => $sub_weight, 'price' => $sub_price, 'rate' => $sub_rate);
                    }
                }
                $tmp['attributes'] = array();
                if (isset($_REQUEST['attribute_id_' . $p])) {
                    foreach ($_REQUEST['attribute_id_' . $p] as $attribute_id) {
                        $attribute['read_only'] = isset($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_type_' . $p . '_' . $attribute_id]) : 0;
                        if ($attribute['read_only'] == 1) {
                            continue;
                        }
                        $attribute['id'] = $attribute_id;
                        $attribute['name'] = trim($_REQUEST['attribute_name_' . $p . '_' . $attribute_id]);
                        $attribute['value'] = trim($_REQUEST['attribute_value_' . $p . '_' . $attribute_id]);
                        $attribute['level'] = isset($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) ? trim($_REQUEST['attribute_level_' . $p . '_' . $attribute_id]) : '';
                        if ($attribute['level'] == '' || is_null($attribute['level']) || $attribute['level'] == 'null') {
                            //calculate the level and set here
                            if ($attribute_id < 0) {
                                $attribute['level'] = 1;
                            } else {
                                $attribute['level'] = 2;
                            }
                        }
                        $tmp['attributes'][] = $attribute;
                    }
                }
            }
            //$tmp['sub_total'] += $tmp['sub_total'] * $tmp['vat_rate'] / 100;
            $total_grn_price += $tmp['sub_total'];
            $products[$p] = $tmp;
        }
        $po_products = array();
        //$params = array();
        $params['total_grn_price'] = $total_grn_price;
        $params['po'] = isset($_REQUEST['po']) ? $_REQUEST['po'] : '';
        $params['po_products'] = $po_products;
        $params['date'] = date('d-m-Y');
        foreach ($products as &$product) {
            if (!isset($product['rate'])) {
                $product['rate'] = 0;
            }
            if (isset($product['header_product']) && !is_null($product['header_product']) && $product['header_product'] != '') {
                //create product_sku first
                //insert the product into grn_items
                $item_specific_id = false;
                if (!$item_specific_id) {
                    //add($header_id,  $vendor_id, $user_id,$max_discount = 100, $attributes = array(), $image_path = '', $tracking_level = '', $mfg_barcode = '')
                    $item_specific_id = $this->{$product['header_product']}->add($product['item_specific_id'], $vendor_id, $this->user->getUserId(), $product['max_discount'], $product['attributes']);
                }
                if (!$item_specific_id) {
                    $item_specific_id = $this->{$product['header_product']}->add($product['item_specific_id'], $product['weight'], $product['items']);
                }
                $product['item_specific_id'] = $item_specific_id;
                $product['item_entity_id'] = $product['header_product_id'];
            }
            $product['barcode'] = $this->barcode->getBarcode($product['item_entity_id'], $product['item_specific_id']);
        }
        $params['selected_products'] = $products;
        $this->db->trans_begin();
        $grn_json = json_encode($params);
        $prn_id = $this->grn->create($params['po'], $this->user->loggedInUserId(), $vendor_id, date('Y-m-d H:i:s', strtotime($vendor['grn_date'])), $grn_json);
        if ($prn_id > 0) {
            foreach ($products as &$product) {
                if (isset($product['items']) && count($product['items']) > 0 && isset($product['header_product'])) {
                    $this->grn->addItem($prn_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'], $product['purchase_price'], $product['rate'], $branch_id);
                    $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], 1, '', $this->user->loggedInUserId());
                } else {
                    $this->grn->addItem($prn_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'], $product['purchase_price'], $product['rate'], $branch_id);
                    $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], '', '', $this->user->loggedInUserId());
                }
            }
        }
        $pout = array();
        if ($this->db->trans_status() === FALSE) {
            $pout['output'] = "Failed!";
            $this->db->trans_rollback();
        } else {
            $pout['output'] = $grn_json = $params;
            $this->db->trans_commit();
        }
        //$this->_my_output('confirmed', $pout);
        redirect(site_url('/grn/print_grn/' . $prn_id), 'refresh', 302);
    }

    public function print_grn($grn_id = '', $print = 0)
    {
        if ($grn_id == '') {
            if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
                redirect('grn');
            }
            $grn_id = $_REQUEST['id'];
        }
        if ($grn_id == 0) {
            $params['status'] = $grn_id;
        } else {
            $params['status'] = 1;
        }
        $grn_full = $this->grn->getById($grn_id, 1);
        if (!$grn_full || !is_array($grn_full) || count($grn_full) < 1) {
            $params['status'] = 0;
            $params['error_msg'] = 'No GRN associated with this ID!';
            $this->_my_output('print_grn', $params);
            return;
        }
        $p = json_decode($grn_full['extra_json'], TRUE);
        //log_message('error', 'GRN JSON::' . print_r($p, 1));
        foreach ($grn_full['items'] as &$grn_item) {
            $product_lib_result = $this->productlib->getProductDetails($grn_item['item_entity_id'], $grn_item['item_specific_id']);
            $grn_item['barcode'] = $this->barcode->getBarcode($product_lib_result['item_entity_id'], $product_lib_result['item_specific_id']);
            $grn_item = array_merge($grn_item, $product_lib_result);
        }
        $p['grn_items'] = $grn_full['items'];
        $p['print'] = $print;
        $p['grn_id'] = $grn_id;
        $item_entity_id = $this->item_entity->getEntityId('grn');
        $p['barcode'] = $this->barcode->getBarcode($item_entity_id, $grn_id);
        //log_message('error', "IN GRN".print_r($p, 1));
        //$p['print'] = intval($print);
        $params += array('output' => $p, 'tab' => 'grn');
        if (!$print) {
            $this->_my_output('print_grn', $params);
        } else {
            $this->load->view('header_print', array());
            $this->load->view('grn/print_grn', $params);
            $this->load->view('footer_print', array());
        }
    }

    public function load_po($id = '')
    {
        if ($id == '') {
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        }
        if ($id == '') {
            redirect('grn');
        }
        $params = array();
        $po = $this->po->getById($id);
        $po['items'] = $this->po->getItems($id);
        $html = array();
        $row_count_array = array();
        $row_count = 1;
        $product_header_array = array();
        foreach ($po['items'] as &$item) {
            // load product and attributes to pass to view/as ajax response
            $entity_name = $this->item_entity->getName($item['item_entity_id']);
            $product_header = $this->{$entity_name}->getById($item['item_specific_id']);
            // get entity name
            //get by ID
            $product_header_array[] = $product_header;
        }
        $v_details = $this->po->getVendorByID($id);
        $v_details['po_date'] = $po['po_date'];
        if (isset($v_details) && is_array($v_details)) {
            $html['vendor'] = $this->load->view('grn/grn_vendor', $v_details, TRUE);
            $p['vendor_name'] = $v_details['company_name'];
            $p['total_row_count'] = $row_count_array;
        } else {
            $p['success'] = 0;
            $this->_my_output('', $p);
            return;
        }
        $p['html'] = $html;
        $params['po'] = $p;
        $params['success'] = 1;
        $this->_my_output('', $params);
    }

    public function saved()
    {
        $p = array();
        /*if ($this->user->isAccessAllowed('grn') === FALSE) {
            $p['access'] = "Access Denied";
        }*/
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "grn.id as id", "PO ID" => "grn.purchase_order_id", "Vendor Name" => "v.company_name as company_name",
            "Address" => "v.address as address", "City" => "v.city as city",
            "Created By" => "u.name as name", "grn Date" => "grn.dated as grn_date",
            "Delivery Date" => "grn.created_at as delivery_date");
        $table = " `product_receive_note` grn, `vendors` v, `users` u ";
        $where = " WHERE grn.vendor_id = v.id AND grn.user_id = u.id and grn.deleted = '0' ";
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('grn/print_grn/'), "css" => "btn btn-primary action-btn")
        );
        $orderby = " ORDER BY grn.created_at ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('saved', $p);
    }

    public function load_po_by_id($id)
    {
        if ($id == '') {
            redirect('grn');
        }
        if (isset($_REQUEST['view']) && $_REQUEST['view'] == 0) {
            $view = 0;
        } else {
            $view = 1;
        }
        $params = array();
        $po = $this->po->getById($id);
        $p = $po;
        if (!$po || $po == '' || !is_array($po) || count($po) < 1) {
            $params['po'] = $p;
            $params['success'] = 0;
            $params['msg'] = 'Invalid Purchase Order ID/Barcode.';
            $this->_my_output('', $params);
            return;
        }
        $po['items'] = $this->po->getItems($id);
        $html = array();
        $row_count_array = array();
        $row_count = 1;
        $product_array = array();
        foreach ($po['items'] as &$item) {
            $item['cost_price'] = $item['price'];
            $product_lib_result = $this->productlib->getProductDetails($item['item_entity_id'], $item['item_specific_id']);
            if (!isset($product_lib_result['attributes']) || !is_array($product_lib_result['attributes'])) {
                $product_lib_result['attributes'] = array();
            }
            if (!isset($item['attributes']) || !is_array($item['attributes'])) {
                $item['attributes'] = array();
            }
            $formatted_attributes = array();
            foreach ($product_lib_result['attributes'] as $key => $value) {
                $formatted_attributes[$value['name']] = $value;
            }
            foreach ($item['attributes'] as $key => $value) {
                $formatted_attributes[$value['name']] = $value;
            }
            $product_lib_result = array_merge($item, $product_lib_result);
            $product_lib_result['attributes'] = $formatted_attributes;
            if (!isset($row_count_array[$product_lib_result['model_name']])) {
                $row_count_array[$product_lib_result['model_name']] = 0;
            }
            $row_count_array[$product_lib_result['model_name']]++;
            $product_lib_result['row_count'] = $row_count++;
            if ($view == 1) {
                if (!isset($html[$product_lib_result['model_name']])) {
                    $html[$product_lib_result['model_name']] = '';
                }
                $html[$product_lib_result['model_name']] .= $this->load->view('grn/grn_' . $product_lib_result['model_name'], $product_lib_result, TRUE);
            } else {
                $product_array[] = $product_lib_result;
            }
        }
        $v_details = $this->po->getVendorByID($id);
        $v_details['po_date'] = $po['po_date'];
        if (isset($v_details) && is_array($v_details)) {
            if ($view == 1) {
                $html['vendor'] = $this->load->view('grn/grn_vendor', $v_details, TRUE);
                $p['total_row_count'] = $row_count_array;
            }
            $p['vendor_name'] = $v_details['company_name'];
        } else {
            $p['success'] = 0;
            $this->_my_output('', $p);
            return;
        }
        $p['html'] = $html;
        if ($view == 0) {
            $params['vendor_details'] = $v_details;
            $params['product_array'] = $product_array;
        }
        $params['po'] = $p;
        $params['success'] = 1;
        $this->_my_output('', $params);
    }

    public function get_by_id($id = '')
    {
        $p = array();
        if ($id == '') {
            $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        }
        if ($id == '') {
            $p['status'] = 'error';
            $p['msg'] = 'GRN ID not supplied';
        } else {
            $grn = $this->grn->getById($id, 1);
            //TODO - think about this
            /*            foreach ($grn['items'] as &$item) {
                $product_lib_result = $this->productlib->getProductDetails($item['item_entity_id'], $item['item_specific_id']);
                $item = array_merge($item, $product_lib_result);
            }*/
            // second argument passed here is specifying the details
            if (is_array($grn) && count($grn) > 0) {
                $p['status'] = 'success';
                $p['grn'] = $grn;
                $p['vendor'] = $this->vendor->getById($grn['vendor_id']);
                log_message('error', print_r($p, true));
            } else {
                $p['status'] = 'error';
                $p['msg'] = 'GRN ID not found!';
            }
        }
        echo json_encode($p);
        return;
    }

    public function _my_output($file = 'grn', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "goods_recieved_note";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('grn/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
/*END OF FILE*/