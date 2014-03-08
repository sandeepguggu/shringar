<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Product extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url'));
        $this->load->database();
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
        if ($this->json === true) {
            $this->ajax = true;
        }
        /*        if ($this->ajax === false) {
              redirect('purchases');
          }*/
        $this->load->model('Item_entity_Model', 'item_entity');
        $this->load->model('Category_Model', 'category');
        $this->load->model('Class_Model', 'class');
        $this->load->model('brand_Model', 'brand');
        $this->load->model('User', 'user');
        $this->load->model('metal_model', 'metal');
        $this->load->model('stone_model', 'stone');
        $this->load->model('ornament_model', 'ornament');
        $this->load->model('old_ornament_model', 'old_ornament');
        $this->load->model('rate_model', 'rate');
        $this->load->model('product_header_model', 'product_header');
        $this->load->library('productLib', array());
        $this->load->model('Attribute_Model', 'attribute');
        $this->load->model('inventory_Model', 'inventory');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $p = array();
        if ($this->user->isAccessAllowed('product') == FALSE) {
            $p['access'] = "Access Denied";
        }
        $p['entities'] = $this->item_entity->getAllItemEntities();
        $p['brands'] = $this->brand->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        if ($p['entities'] == FALSE) {
            $p['error_msg'] = "Entity List is Empty";
            $this->_my_output('index', $p);
            return;
        }
        $pt = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '25';
        $this->displayProduct($pt, $p);
    }

    public function displayProduct($product_type = '25', $p = array())
    {
        $this->load->library('datagrid', array('db' => &$this->db));
        switch ($product_type) {
            case 1:
                $this->display_metals($p);
                break;
            case 2:
                $this->display_stones($p);
                break;
            case 3:
                $this->display_ornaments($p);
                break;
            case 4:
                $this->display_old_ornaments($p);
                break;
            case 25:
                $this->display_products($p);
                break;
            default:
                $this->display_products($p);
                break;
        }
    }

    public function display_products($p = array())
    {
        $fields = array('ID' => "p.id as id", 'NAME' => "pd.name",
            'TAX CT' => "ct.name as category_name", 'CLASS' => "cl.name as class_name");
        $table = "product_header p , products_description pd , category ct, class cl ";
        $actions = array(
            '<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('product/view_product_header?ajax=1'), "css" => "btn btn-success fancybox action-btn"),
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('product/edit_product_header?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            //		            "Print" => array("url" => "#", "css" => "btn success"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#' . site_url('product/delete_product_header?ajax=1'), "css" => "btn btn-danger action-btn")
        );
        $where = 'where p.tax_category_id=ct.id AND p.class_id=cl.id AND pd.id=p.product_desc_id AND p.deleted = 0';
        if (isset($_REQUEST['brand_id']) && trim($_REQUEST['brand_id']) != '' && $_REQUEST['brand_id'] != 0) {
            $where .= ' AND p.brand_id =' . $_REQUEST['brand_id'];
        }
        //TODO - this needs to be changed after adding multiple class thing in place -- Important
        if (isset($_REQUEST['class_id']) && trim($_REQUEST['class_id']) != '' && $_REQUEST['class_id'] != 0) {
            //if multiple classes is to be considered, get all the classes a product falls into, and match against the classes-subclasses array
            $sub_classes = $this->class->getAllSubClasses(trim($_REQUEST['class_id']), 0);
            $sub_classes_string = implode(',', $sub_classes);
            $sub_classes_string = '(' . $sub_classes_string . ')';
            $where .= ' AND p.class_id IN ' . $sub_classes_string;
        }
        if (isset($_REQUEST['category_id']) && trim($_REQUEST['category_id']) != '' && $_REQUEST['category_id'] != 0) {
            $where .= ' AND p.category_id =' . $_REQUEST['category_id'];
        }
        if (isset($_REQUEST['search']) && trim($_REQUEST['search']) != '') {
            $where .= ' AND pd.name like ' . "'%" . $this->db->escape_like_str($_REQUEST['search']) . "%'";
        }
        if (isset($_REQUEST['sort']) && $_REQUEST['sort'] != '') {
            $sort = trim($_REQUEST['sort']);
            $sort = explode(' ', $sort);
            $sort = $sort[0];
        } else {
            $sort = 'pd.name';
        }
        if (isset($_REQUEST['order']) && $_REQUEST['order'] = 1) {
            $order = 'DESC';
        } else {
            $order = 'ASC';
        }
        $orderby = " order by {$sort} {$order}";
        $config = array('sortable' => 1);
        $config['checkbox'] = 0;
        $config['count_distinct'] = '';
        $config['excel'] = 0;
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 50, 1,$config);
        $this->_my_output('index', $p);
    }

    public function display_ornaments($p = array())
    {
        $fields = array("ID" => "o.id as id", "NAME" => "o.name as name",
            // 		"Category" => "c.name as Category",
            // 		"Category<br />VAT (%)" => "c.vat_percentage as Vat",
            "Weight (g)" => "o.weight as weight",
            //   "Metal" => "m.name as metal",
            //   "Metal Weight (g)" => "o.metal_wt",
            //		 "Stone Weight (g)" => "o.stone_wt",
            //    "Stone Cost (Rs.)" => "o.stone_cost",
            "Wastage Cost (%)" => "o.wastage_percent",
            "Making Cost (%)" => "o.making_cost_percent");
        $table = " `ornament` o ";
        $where = " where o.deleted = 0 ";
        $actions = array(
            "EDIT" => array("url" => site_url('product/edit_ornament?ajax=1'), "css" => "btn primary fancybox"),
            //		            "Print" => array("url" => "#", "css" => "btn success"),
            "DELETE" => array("url" => site_url('product/delete_ornament?ajax=1'), "css" => "btn danger fancybox")
        );
        $orderby = " order by o.`id` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 50, 1);
        $this->_my_output('index', $p);
    }

    public function display_old_ornaments($p = array())
    {
        $fields = array("ID" => "o.id as id", "NAME" => "o.name as name",
            // 		"Category" => "c.name as Category",
            // 		"Category<br />VAT (%)" => "c.vat_percentage as Vat",
            "Weight (g)" => "o.weight as weight",
            "Metal" => "m.name as metal",
            "Metal Weight (g)" => "o.metal_wt",
            //		 "Stone Weight (g)" => "o.stone_wt",
            "Stone Cost (Rs.)" => "o.stone_cost",
            //	"Making Cost (%)"=>"o.making_cost_percent"
        );
        $table = " `old_ornament` o , `metal` m";
        $where = " where o.metal_id = m.id AND o.deleted = 0 ";
        $actions = array(
            "EDIT" => array("url" => site_url('product/edit_ornament?ajax=1'), "css" => "btn primary fancybox"),
            //		            "Print" => array("url" => "#", "css" => "btn success"),
            "DELETE" => array("url" => site_url('product/delete_ornament?ajax=1'), "css" => "btn danger fancybox")
        );
        $orderby = " order by o.`name` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('index', $p);
    }

    public function display_metals($p = array())
    {
        $fields = array("ID" => "m.id as id", "NAME" => "m.name as name",
            "Fineness" => "m.fineness",
            "Karats" => "m.karat"
        );
        $table = "`metal` m";
        $where = "where 1=1";
        $actions = array(
            "EDIT" => array("url" => site_url('product/edit_metal?ajax=1'), "css" => "btn primary fancybox"),
            //		            "Print" => array("url" => "#", "css" => "btn success"),
            "DELETE" => array("url" => site_url('product/delete_metal?ajax=1'), "css" => "btn danger fancybox")
        );
        $orderby = " order by m.`name` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('index', $p);
    }

    public function display_stones($p = array())
    {
        //$fields = array("ID" => "p.id as id", "NAME" => "p.name as name", "Category" => "c.name as Category", "Brand" => "b.name as Brand", "Sell Price" => "p.sell_price as SellPrice", "Category<br />VAT (%)" => "c.vat_percentage as Vat");
        //$table = " `products` p , `category` c, `brand` b ";
        //$where = " where p.category_id = c.id and p.brand_id = b.id and p.deleted = '0' ";
        $fields = array("ID" => "s.id", "NAME" => "s.name",
            "Category" => "c.name as Category",
            "VAT(%)" => "c.vat_percentage as Vat"
        );
        $table = "`stone` s, `category` c";
        $where = " where s.category_id = c.id AND s.deleted = 0";
        $actions = array(
            "EDIT" => array("url" => site_url('product/edit_stone?ajax=1'), "css" => "btn primary fancybox"),
            //		            "Print" => array("url" => "#", "css" => "btn success"),
            "DELETE" => array("url" => site_url('product/delete_stone?ajax=1'), "css" => "btn danger fancybox")
        );
        $orderby = " order by s.`name` ASC";
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
        $this->_my_output('index', $p);
    }

    public function add()
    {
        $p = array();
        if ($this->user->isAccessAllowed('product') === FALSE) {
            $p['access'] = "Access Denied";
        }
        $pt = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : '';
        $name = $this->item_entity->getNameById($pt);
        $name = 'add_' . $name;
        $this->{$name}();
    }

    public function add_metal()
    {
        $p = array();
        $this->_my_output('add_metal', $p);
    }

    /**
     * Edit Metal
     */
    public function edit_metal()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['status'] = false;
            $p['msg'] = 'The Metal ID is Invalid';
            $this->_my_output('edit_metal', $p);
            return;
        }
        $metal = $this->metal->getMetalByID($id);
        if ($metal == false) {
            $p['status'] = false;
            $p['msg'] = 'The Metal ID you passed is not associated with any Metal';
            $this->_my_output('edit_metal', $p);
            return;
        }
        $p = $metal;
        $this->_my_output('edit_metal', $p);
        return;
    }

    /*
       *  Add Metal to Databse
      */
    public function add_metal_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['metal-name']) ? $_REQUEST['metal-name'] : '';
        $karat = isset($_REQUEST['metal-karat']) ? $_REQUEST['metal-karat'] : '';
        $fineness = isset($_REQUEST['metal-fineness']) ? $_REQUEST['metal-fineness'] : '';
        $type = isset($_REQUEST['metal-type']) ? $_REQUEST['metal-type'] : '';
        $category_id = isset($_REQUEST['metal-category']) ? $_REQUEST['metal-category'] : '';
        $is_old = isset($_REQUEST['metal-old']) ? isset($_REQUEST['metal-old']) : 0;
        if ($name == '' || $karat == '' || $fineness == '' || $type == '' || $category_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Errors in parameters transmission';
            $this->_my_output('add_metal', $p);
            return;
        }
        $add_status = $this->metal->add($name, $karat, $fineness, 'g', $type, $category_id, $is_old);
        $p['status'] = $add_status['status'];
        $p['msg'] = $add_status['msg'];
        $this->_my_output('add_metal', $p);
    }

    /*
       *  Update Metal to Databse
      */
    public function update_metal_to_db()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = isset($_REQUEST['metal-name']) ? $_REQUEST['metal-name'] : '';
        $carat = isset($_REQUEST['metal-purity-carat']) ? $_REQUEST['metal-purity-carat'] : '';
        $percent = isset($_REQUEST['metal-purity-percent']) ? $_REQUEST['metal-purity-percent'] : '';
        if ($name == '' || $carat == '' || $percent == '' || $id == '') {
            $p['status'] = false;
            $p['msg'] = 'Errors in parameters transmission';
            $this->_my_output('add_metal', $p);
            return;
        }
        $add_status = $this->metal->update($id, $name, $carat, $percent, 'g');
        $p['status'] = $add_status['status'];
        $p['msg'] = $add_status['msg'];
        $this->_my_output('add_metal', $p);
    }

    public function delete_metal()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this - _my_output('error', $p);
            return;
        }
        $r = $this->metal->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['msg'] = "Successfully Deleted, Metal Id " . $r['id'];
        $this->_my_output('success', $p);
    }

    public function add_stone()
    {
        $p = array();
        $this->_my_output('add_stone', $p);
    }

    public function add_stone_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['stone-name']) ? $_REQUEST['stone-name'] : '';
        $type = isset($_REQUEST['stone-type']) ? $_REQUEST['stone-type'] : '';
        $category_id = isset($_REQUEST['stone-category']) ? $_REQUEST['stone-category'] : '';
        if ($name == '' || $type == '' || $category_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Errors in parameters transmission';
            $this->_my_output('add_stone', $p);
            return;
        }
        $add_status = $this->stone->add($name, $type, $category_id);
        $p['status'] = $add_status['status'];
        $p['msg'] = $add_status['msg'];
        $this->_my_output('add_stone', $p);
    }

    public function add_ornament()
    {
        $p = array();
        $p['entities'] = $this->item_entity->getAllItemEntities();
        $p['metals'] = $this->metal->getAll();
        $this->_my_output('add_ornament', $p);
    }

    public function add_ornament_to_db()
    {
        // debugbreak();
        $p = array();
        $name = isset($_REQUEST['ornament-name']) ? $_REQUEST['ornament-name'] : '';
        $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        $weight = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : '';
        $comments = isset($_REQUEST['comments']) ? $_REQUEST['comments'] : '';
        //$metal_id = isset($_REQUEST['metal_id']) ? $_REQUEST['metal_id'] : '';
        //$metal_wt = isset($_REQUEST['metal-weight']) ? $_REQUEST['metal-weight'] : '';
        //$stone_cost = isset($_REQUEST['stone-cost']) ? $_REQUEST['stone-cost'] : '';
        //$stone_wt = isset($_REQUEST['stone-weight']) ? $_REQUEST['stone-weight'] : '';
        $making_cost = isset($_REQUEST['making-cost']) ? $_REQUEST['making-cost'] : '';
        $wastage_cost = isset($_REQUEST['wastage-cost']) ? $_REQUEST['wastage-cost'] : '';
        $making_cost_type = isset($_REQUEST['making-cost-type']) ? $_REQUEST['making-cost-type'] : '';
        $wastage_cost_type = isset($_REQUEST['wastage-cost-type']) ? $_REQUEST['wastage-cost-type'] : '';
        if ($name == '' || $category_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Errors in parameters transmission';
            $this->_my_output('add_metal', $p);
            return;
        }
        if ($wastage_cost_type == 'percent') {
            $wastage_cost_percent = $wastage_cost;
            $wastage_cost_fixed = 0;
        } else {
            $wastage_cost_fixed = $wastage_cost;
            $wastage_cost_percent = 0;
        }
        if ($making_cost_type == 'percent') {
            $making_cost_percent = $making_cost;
            $making_cost_fixed = 0;
        } else {
            $making_cost_fixed = $making_cost;
            $making_cost_percent = 0;
        }
        $items = array();
        foreach ($_REQUEST['item_id'] as $item_id) {
            $item_id_array = explode('_', $item_id);
            $item_entity_id = $item_id_array[0];
            $item_specific_id = $item_id_array[1];
            $quantity = 0;
            $items[] = array('item_entity_id' => $item_entity_id, 'item_specific_id' => $item_specific_id, 'quantity' => $quantity);
        }
        $add_status = $this->ornament->addOrnament($name, $category_id, $weight, $making_cost_percent, $wastage_cost_percent, $items, $comments);
        //$add_status = $this->ornament->add($name, $category_id, $weight, $metal_id, $metal_wt, $stone_wt, $stone_cost, $making_cost_percent, $making_cost_fixed, $wastage_cost_percent, $wastage_cost_fixed);
        $p['status'] = $add_status['status'];
        $p['msg'] = $add_status['msg'];
        $this->_my_output('add_ornament', $p);
    }

    public function add_old_ornament()
    {
        $p = array();
        $p['metals'] = $this->metal->getAll();
        $this->_my_output('add_old_ornament', $p);
    }

    public function add_old_ornament_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['old_ornament-name']) ? $_REQUEST['old_ornament-name'] : '';
        //$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '';
        $weight = isset($_REQUEST['weight']) ? $_REQUEST['weight'] : '';
        $metal_id = isset($_REQUEST['metal_id']) ? $_REQUEST['metal_id'] : '';
        $metal_wt = isset($_REQUEST['metal-weight']) ? $_REQUEST['metal-weight'] : '';
        $stone_cost = isset($_REQUEST['stone-cost']) ? $_REQUEST['stone-cost'] : '';
        $stone_wt = isset($_REQUEST['stone-weight']) ? $_REQUEST['stone-weight'] : '';
        //$making_cost = isset($_REQUEST['making-cost']) ? $_REQUEST['making-cost'] : '';
        //$wastage_cost = isset($_REQUEST['wastage-cost']) ? $_REQUEST['wastage-cost'] : '';
        //$making_cost_type = isset($_REQUEST['making-cost-type']) ? $_REQUEST['making-cost-type'] : '';
        //$wastage_cost_type = isset($_REQUEST['wastage-cost-type']) ? $_REQUEST['wastage-cost-type'] : '';
        $deterioration = isset($_REQUEST['deterioration']) ? $_REQUEST['deterioration'] : '';
        if ($name == '' || $weight == '' || $metal_id == '') {
            $p['status'] = false;
            $p['msg'] = 'Errors in parameters transmission';
            $this->_my_output('add_old_ornament', $p);
            return;
        }
        $add_status = $this->old_ornament->add($name, $weight, $metal_id, $deterioration, $metal_wt, $stone_wt, $stone_cost);
        $p['status'] = $add_status['status'];
        $p['msg'] = $add_status['msg'];
        $this->_my_output('add_old_ornament', $p);
    }

    public function add_product_header()
    {
        $p = array();
        //$p['products'] = $this->product_header->getAll();
        $p['categories'] = $this->category->getAll();
        $p['classes'] = $this->class->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        $this->_my_output('add_product_header', $p);
    }

    public function add_product_header_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        if (isset($_REQUEST['brand_id'])) {
            $brand_id = $_REQUEST['brand_id'];
        } else {
            $brand_id = $this->brand->add($name);
        }
        $mfg_barcode = isset($_REQUEST['mfg_barcode']) ? $_REQUEST['mfg_barcode'] : '';
        $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
        $class_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $attributes = array();
        if ($name == '') {
            $p['status'] = 'error';
            $p['msg'] = "Name Required";
            echo json_encode($p);
            return;
        }
        //this loop is for creating attributes array
        foreach ($_REQUEST['attribute_row'] as $row) {
            $attribute = array();
            $attribute['id'] = $_REQUEST['attribute_id_' . $row];
            $attribute['name'] = $_REQUEST['attribute_name_' . $row];
            $attribute['level'] = $_REQUEST['attribute_level_' . $row];
            $attribute['value'] = isset($_REQUEST['attribute_value_' . $row]) ? $_REQUEST['attribute_value_' . $row] : '';
            $attribute['sku'] = (!isset($_REQUEST['attribute_checked_' . $row]) || $_REQUEST['attribute_checked_' . $row] == '') ? 0 : 1;
            $attribute['state'] = (isset($_REQUEST['attribute_state_' . $row])) ? $_REQUEST['attribute_state_' . $row] : 0;
            if ($attribute['state'] == 1) {
                if ($attribute['id'] == -3) {
                    //attribute needs to be added to database
                    $attribute['level'] = 2;
                    $attribute['id'] = $this->attribute->add($attribute['name'], $attribute['level']);
                } else if ($attribute['id'] == -1) {
                    $attribute['level'] = 1;
                    $attribute['id'] = $this->attribute->add($attribute['name'], $attribute['level']);
                }
                $attributes[] = $attribute;
            }
        }
        $id = $this->product_header->add($name, $description, $category_id, $class_id, $brand_id, $this->user->getUserId(), $attributes, $mfg_barcode);
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully added! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Failed to add Product Header";
        }
        echo json_encode($p);
    }

    public function edit_product_header()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['status'] = false;
            $p['msg'] = 'The Product ID is Invalid';
            $this->_my_output('edit_product_header', $p);
            return;
        }
        $product = $this->product_header->getById($id);
        if ($product == false) {
            $p['status'] = false;
            $p['msg'] = 'The Product ID you passed is not associated with any Product';
            $this->_my_output('edit_product_header', $p);
            return;
        }
        $p['output'] = $product;
        $p['class'] = $this->class->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        $this->_my_output('edit_product_header', $p);
        return;
    }

    public function update_product_header()
    {
        $p = array();
        $product_header_id = isset($_REQUEST['product_header_id']) ? $_REQUEST['product_header_id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        if (isset($_REQUEST['brand_id'])) {
            $brand_id = $_REQUEST['brand_id'];
        } else {
            $brand_id = $this->brand->add($name);
        }
        $category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : 0;
        $class_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        $description_id = isset($_REQUEST['description_id']) ? $_REQUEST['description_id'] : '';
        $mfg_barcode = isset($_REQUEST['mfg_barcode']) ? $_REQUEST['mfg_barcode'] : '';
        $attributes = array();
        $removeAttr = array();
        $updateAttributes = array();
        if ($name == '') {
            $p['failed'] = "Name Required";
            $this->_my_output('add_product_header', $p);
            return;
        }
        //this loop is for creating attributes array
        foreach ($_REQUEST['attribute_row'] as $row) {
            $attribute = array();
            $attribute['id'] = $_REQUEST['attribute_id_' . $row];
            $attribute['name'] = $_REQUEST['attribute_name_' . $row];
            $attribute['level'] = $_REQUEST['attribute_level_' . $row];
            $attribute['value'] = isset($_REQUEST['attribute_value_' . $row]) ? $_REQUEST['attribute_value_' . $row] : '';
            $attribute['sku'] = (!isset($_REQUEST['attribute_checked_' . $row]) || $_REQUEST['attribute_checked_' . $row] == '') ? 0 : 1;
            $attribute['state'] = (isset($_REQUEST['attribute_state_' . $row])) ? $_REQUEST['attribute_state_' . $row] : 0;
            if ($attribute['state'] == 0) {
                $updateAttributes[] = $attribute;
            }
            if ($attribute['state'] == 1) {
                if ($attribute['id'] == -3) {
                    //attribute needs to be added to database
                    $attribute['level'] = 2;
                    $attribute['id'] = $this->attribute->add($attribute['name'], $attribute['level']);
                } else if ($attribute['id'] == -1) {
                    $attribute['level'] = 1;
                    $attribute['id'] = $this->attribute->add($attribute['name'], $attribute['level']);
                }
                $attributes[] = $attribute;
            }
            if ($attribute['state'] == -1) {
                $removeAttr[] = $attribute;
            }
        }
        $id = $this->product_header->update($product_header_id, $name, $description, $category_id, $class_id, $brand_id, $this->user->getUserId(),
            $attributes, $removeAttr, $updateAttributes, $mfg_barcode, $description_id);
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully Updated! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Error while updating! Please try again.";
        }
        echo json_encode($p);
    }

    public function view_product_header($print = 0)
    {
        $product_header_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($product_header_id == '') {
            redirect();
        } else {
            $product_header = $this->product_header->getById($product_header_id);
            $p = array();
            $p['output'] = $product_header;
            if ($print == 0) {
                $p['print'] = 0;
                $this->_my_output('product_header', $p);
                return;
            } else {
                $p['print'] = 1;
                $this->load->view('header_print', array());
                $this->load->view('product/product_header', $p);
                $this->load->view('footer_print', array());
            }
        }
    }

    public function delete_product_header($product_header_id = '')
    {
        if ($product_header_id == '') {
            $product_header_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        }
        $p = array();
        if ($product_header_id == '') {
            redirect();
        } else {
            $deleted_id = $this->product_header->delete($product_header_id);
            if ($deleted_id && $deleted_id > 0) {
                $p['status'] = 'success';
                $p['msg'] = 'Successfully Deleted Product Header ID : ' . $deleted_id;
            } else {
                $p['status'] = 'error';
                $p['msg'] = 'Unable to delete this Product Header : ' . $deleted_id;
            }
            echo json_encode($p);
        }
    }

    public function suggest_items($item_entity_id)
    {
        $params = array();
        $from = isset($_REQUEST['from']) ? $_REQUEST['from'] : 'grn';
        if (isset($_REQUEST['term'])) {
            $entity = $this->item_entity->getEntityById($item_entity_id);
            $name = $entity['name'];
            $p = $this->{$name}->suggestItem($_REQUEST['term']);
            if (isset($p) && is_array($p)) {
                foreach ($p as $v) {
                    $v['item_entity_id'] = $item_entity_id;
                    //This section should be replaced by using library code
                    if ($from != 'billing') {
                        //this if block is a patch, needs to be fixed , but it will need views to be changed, so will fix later :: Rajat Garg
                        $v['rate'] = $this->getRate($item_entity_id, $v['id']);
                        $category = $this->category->getById($v['category_id']);
                        $v['vat_rate'] = $category['vat_percentage'];
                        if ($item_entity_id == 3) {
                            //$v['metal_weight'] = $this->{$name}->getWeightByItemEntityId($v['id'], 1);
                            $items = $this->{$name}->getComponentsById($v['id']);
                            $man_items = array();
                            foreach ($items as $item_k => $item) {
                                $entity_comp = $this->item_entity->getEntityById($item['item_entity_id']);
                                foreach ($item as $k => $val) {
                                    $man_item[$k] = $val;
                                }
                                $man_item['type'] = $entity_comp['display_name'];
                                $item_specific = $this->{$entity_comp['name']}->getById($item['item_specific_id']);
                                $man_item['name'] = $item_specific['name'];
                                $man_items[] = $man_item;
                                //$item_k = $man_items;
                            }
                            //log_message('error', "IN HERE: ARRAY::" . print_r($man_items, 1));
                            //$v['itemsss'] = array();
                            $v['items'] = $man_items;
                        }
                    } else {
                        $v = $this->productlib->getProductDetails($item_entity_id, $v['id']);
                    }
                    // TODO - this thing to be uncommented after changing all relevent views
                    //$v = $this->productlib->getProductDetails($item_entity_id, $v['id']);
                    $a = $v;
                    //$a['id'] = $v['id'];
                    //$a['label'] = $v['name'];
                    //$a['value'] = $v['name'];
                    if ($from == "grn") {
                        $a['html'] = $this->load->view('grn/grn_' . $name, $v, true);
                    } else if ($from == "po") {
                        $a['html'] = $this->load->view('po/po_' . $name, $v, true);
                    } else if ($from == "ornament") {
                        $a['html'] = $this->load->view('product/ornament_' . $name, $v, true);
                    } else if ($from = 'co') {
                        $a['html'] = $this->load->view('billing/co_' . $name, $v, true);
                    }
                    $params[] = $a;
                }
            }
        } else {
            $params[] = array("id" => "No Record!", "label" => "No Record!", "value" => "No Record!");
        }
        $this->_my_output('', $params);
    }

    public function suggest_product()
    {
    //   debugbreak();
        $term = isset($_REQUEST['term']) ? trim($_REQUEST['term']) : '';
        $details = isset($_REQUEST['details']) ? trim($_REQUEST['details']) : 1;
        $stock = isset($_REQUEST['stock']) ? trim($_REQUEST['stock']) : 0;
        if ($term == '') {
            return;
        }
        $products = array();
        $term = mysql_real_escape_string($term);
        $products = $this->product_header->suggest($term, $details);
        $item_entity_id = $this->item_entity->getEntityId('product_header');
        foreach ($products as &$product) {
            if ($stock == 1) {
                $temp = $this->inventory->getStockValueByItem($item_entity_id, $product['id']);
                $product['stock'] = $temp['stock'];
                $product['mrp_value'] = $temp['value'];
                unset($temp);
            }
            $product['label'] = $product['name'];
            $product['value'] = '';
        }
        echo json_encode($products);
    }

    public function getRate($item_entity_id = 1, $item_specific_id, $composite = false)
    {
        if ($item_entity_id == 3) {
            $items = $this->ornament->getComponentsById($item_specific_id);
            //log_message('error', "RAJAT:".$items[0][0]);
            //log_message('error', 'IN getRate::'.$item_entity_id);
            return $this->getCompositeRate($items);
        }
        if ($item_entity_id == 2) {
            //stone cost for now being returned as zero
            //log_message('error', 'IN getRate::'.$item_entity_id);
            return 0;
        }
        //log_message('error', 'IN getRate::'.$item_entity_id);
        return $this->rate->getRate($item_entity_id, $item_specific_id);
    }

    public function getCompositeRate($items)
    {
        //$items = {'id' , 'item_entity_id', 'item_specific_id', 'quantity'}
        $composite_rate = 0;
        //log_message('error', "Before Foreach::" . $items);
        foreach ($items as $item) {
            $per_unit_price = $this->getRate($item['item_entity_id'], $item['item_specific_id']);
            //log_message('error', 'IN FOREACH: '.$item['item_entity_id'].'and'.$item['item_specific_id']);
            $composite_rate += $per_unit_price * $item['quantity'];
        }
        return $composite_rate;
    }

    public function print_barcode($barcode)
    {
        // debugbreak();
        $params = array('barcode' => $barcode);
        $this->load->view('header_print');
        $this->load->view('product/print_barcode', $params);
        $this->load->view('footer_print');
    }

    public function setRate($item_entity_id, $item_specific_id, $price, $unit = 'g')
    {
        return $this->rate->setRate($item_entity_id, $item_specific_id, $price, $unit);
    }

    function grn_report($json = '', $date = '')
    {
        if (!empty($date)) {
            $repdate = $this->split_date($date);
            $data['report'] = $this->bill->invoiceReport($repdate);
            $p['html'] = $this->load->view("billing/invoice_report_view", $data, true);
            echo json_encode($p['html']);
        } else {
            $p = array();
            $this->_my_output('invoice_report', $p);
        }
    }

    function split_date($date)
    {
        $reportdate = explode("To", urldecode($date));
        if (!empty($reportdate[1])) {
            $frm = $reportdate[0];
            $to = $reportdate[1];
        } else {
            $frm = $reportdate[0];
            $to = date('Y-m-d', strtotime('+1 day', strtotime($date)));
        }
        return array($frm, $to);
    }

    public function barcodeImage() {
        $this->load->library('barcode/BarcodeBase', 'barcodeBase');
    }

    public function _my_output($file = 'product', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $params['category'] = $this->category->getAll();
        $p['tab'] = "manage_products";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('product/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
/*END OF FILE*/