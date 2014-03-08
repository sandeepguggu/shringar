<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Stock_admin extends CI_Controller
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
        $this->load->model('inventory_model', 'inventory');
        $this->load->model('item_entity_model', 'item_entity');
        $this->load->model('rate_model', 'rate');
        $this->load->helper('form');
        $this->load->library('barcode', array());
        $this->load->model('class_Model', 'class');
        $this->load->model('category_Model', 'category');
        $this->load->model('Product_header_Model', 'product_header');
        $this->load->model('product_sku_model', 'product_sku');
        $this->load->model('brand_model', 'brand');
        $this->load->library('productLib', array());
        $this->load->model('manage_users_model', 'manageUsers');
        //$this->load->helper(array('dompdf', 'file'));
    }

    public function index()
    {
        $d = array('output' => print_r($_SESSION, true));
        //$this->_my_output('index', $d);
        $this->display_stock_outward();
    }

    public function opening_stock()
    {
        $params = array();
        $params['tab'] = 'opening_stock';
        $this->_my_output('opening_stock', $params);
    }

    public function submit_opening_stock()
    {
        $params = array();
        $branch_id = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();
        $products = array();
        foreach ($_REQUEST['item_id'] as $p) {
            $item_entity_id_array = explode('_', $p);
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
            $tmp['price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
            $category = $this->category->getProductCategoryById($tmp['category_id']);
            $tmp['vat_rate'] = $category['vat_percentage'];
            $tmp['sub_total'] = $tmp['price'] * $tmp['quantity'] * $tmp['weight'];
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
                        $attribute['display_name'] = trim($_REQUEST['attribute_display_name_' . $p . '_' . $attribute_id]);
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
            $products[$p] = $tmp;
        }
        $po_products = array();
        $params = array();
        $params['date'] = date('d-m-Y');
        foreach ($products as &$product) {
            if (!isset($product['rate'])) {
                $product['rate'] = $product['price'];
            }
            if (isset($product['header_product']) && !is_null($product['header_product']) && $product['header_product'] != '') {
                $item_specific_id = false;
                if (!$item_specific_id) {
                    //add($header_id,  $vendor_id, $user_id,$max_discount = 100, $attributes = array(), $image_path = '', $tracking_level = '', $mfg_barcode = '')
                    $item_specific_id = $this->{$product['header_product']}->add($product['item_specific_id'], -1, $this->user->getUserId(), $product['max_discount'], $product['attributes']);
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
        foreach ($products as &$product) {
            if (isset($product['items']) && count($product['items']) > 0 && isset($product['header_product'])) {
                $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], 1, '', $this->user->loggedInUserId(), 'O.S.E.');
            } else {
                $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, $product['quantity'], $product['weight'], '', '', $this->user->loggedInUserId(), 'O.S.E.');
            }
        }
        if ($this->db->trans_status() === FALSE) {
            $params['msg'] = "Failed!";
            $params['status'] = 'error';
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $params['msg'] = 'Added Successfully!!';
            $params['status'] = 'success';
        }
        echo json_encode($params);
    }

    public function stock_outward()
    {
        $p['tab'] = 'stock_outward';
        $this->_my_output('create_stock_outward', $p);
    }

    public function confirm_stock_outward()
    {
    }

    public function display_stock_outward()
    {
        $params = array();
        $params['tab'] = 'stock_outward';
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "id", "NAME" => "name", "ISSUE ON" => "issued_at", "STATUS" => 'status');
        $table = " `stock_outward` ";
        $where = " WHERE `deleted` = '0' ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('stock_admin/edit?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#' . site_url('stock_admin/delete?ajax=1'), "css" => "btn btn-danger dialog-confirm action-btn")
        );
        $orderby = " order by `name` ASC";

        $params['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('display_stock_outward', $params);
    }

    public function print_stock_outward()
    {
    }

    public function _my_output($file = 'inventory', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = isset($params['tab']) ? $params['tab'] : '';
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('stock_admin/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}

/*END OF FILE*/