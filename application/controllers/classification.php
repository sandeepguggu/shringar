<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Classification extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('calendar');
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
        //$this->load->model('Category_Model', 'category');
        $this->load->model('Class_Model', 'class');
        $this->load->model('User', 'user');
        $this->load->model('Attribute_Model', 'attribute');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $this->load->database();
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "a.id as id", "NAME" => "a.name as name", "PARENT" => "b.name as parent_name");
        $table = " class a, class b ";
        $where = " where a.parent_id = b.id AND a.id > 0 AND a.deleted = 0 ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('classification/edit_class?ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
            '<i class="icon-trash icon-white"></i>' => array("url" => site_url('classification/delete_class?ajax=1'), "css" => "btn btn-danger action-btn fancybox")
        );
        $order_by = " order by `a`.`sort_order` ASC";
        $p['class_grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $order_by, 25, 1);
        $p['class_tree'] = $this->class->getClassTree();
        $this->_my_output('index', $p);
    }

    public function add_class()
    {
        $p = array();
        $p['class'] = $this->class->getAll();
        $p['class_tree'] = $this->class->getClassTree();
        $this->load->view('class/add_class', $p);
    }

    // TODO sorting of classes needs to be created.. and images also
    public function add_class_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $parent_id = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0;
        $p['class_tree'] = $this->class->getClassTree();
        $sort_order = isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : 0;
        $attributes = array();
        if ($name == '') {
            $p['status'] = 'error';
            $p['msg'] = "Name Required";
            echo json_encode($p);
            return;
        }
        //add class function from model needs to be called
        //this loop is for creating attributes array
        $row_array = isset($_REQUEST['attribute_row']) ? $_REQUEST['attribute_row'] : array();
        foreach ($row_array as $row) {
            $attribute = array();
            $attribute['id'] = $_REQUEST['attribute_id_' . $row];
            $attribute['name'] = $_REQUEST['attribute_name_' . $row];
            $attribute['level'] = $_REQUEST['attribute_level_' . $row];
            $attribute['state'] = isset($_REQUEST['attribute_state_' . $row]) ? $_REQUEST['attribute_state_' . $row] : NULL;
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
        $id = $this->class->add($name, $parent_id, $sort_order, $this->user->loggedInUserId(), $attributes);
        if ($id != false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully added! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Class name is already exist!";
        }
        echo json_encode($p);
        return;
    }

    public function edit_class()
    {
   //  debugbreak();
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }
        $r = $this->class->getById($id);
        $p['attributes'] = $r['attributes'];
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['parentClass'] = array();
        $p['class'] = $this->class->getAll();
         foreach($p['class']  as  $cl)
         {
             $p['parentClass'][$cl['id']] =   $cl['name'];
         }
        $p['class_tree'] = $this->class->getClassTree();
        $p['id'] = $r['id'];
        $p['name'] = $r['name'];
        $p['sort_order'] = $r['sort_order'];
        $p['selected_parent_id'] = $r['parent_id'];
        $p['html'] = '';
        $rowcount = 0;
        foreach ($p['attributes'] as &$attribute) {
            $attribute['row_count'] = $rowcount++;
            $p['html'] .= $this->load->view('class/edit_display_attribute', $attribute, true);
            $p['row_total'] = $rowcount;
        }
        $this->_my_output('edit_class', $p);
    }

    public function view($class_id = '')
    {
        $p = array();
        if ($class_id == '') {
        }
        $r = $this->class->getById($class_id);
        $r['output'] = $r;
        $p['html'] = $this->load->view('class/view_class', $r, true);
        echo json_encode($p);
    }

    public function delete_class()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }
        $r = $this->class->deleteById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['status'] = 'success';
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        echo json_encode($p);
    }

    public function update_class_to_db()
    {
      // debugbreak();
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $parent_id = isset($_REQUEST['parent_class']) ? $_REQUEST['parent_class'] : '';
        $sort_order = isset($_REQUEST['sort_order']) ? $_REQUEST['sort_order'] : $id;
        $attributes = array();
        $removeAttr = array();
        foreach ($_REQUEST['attribute_row'] as $row) {
            $attribute = array();
            $attribute['id'] = $_REQUEST['attribute_id_' . $row];
            $attribute['name'] = $_REQUEST['attribute_name_' . $row];
            $attribute['level'] = $_REQUEST['attribute_level_' . $row];
            $attribute['state'] = isset($_REQUEST['attribute_state_' . $row]) ? $_REQUEST['attribute_state_' . $row] : NULL;
            if ($attribute['state'] == 0) {
                continue;
            }
            if ($attribute['state'] == 1) {
                if ($attribute['id'] == -3) {
                    $attribute['level'] = 2;
                    $attribute['id'] = $this->attribute->add($attribute['name'], $attribute['level']);
                }
                $attributes[] = $attribute;
            }
            if ($attribute['state'] == -1) {
                $removeAttr[] = $attribute;
            }
        }
        if ($id == '' || $name == '' || $parent_id == '' || $sort_order == '') {
            $p['msg'] = "Missing Params";
            $this->_my_output('error', $p);
            return;
        }
        if ($this->class->update($id, $name, $parent_id, $sort_order, $attributes, $removeAttr)) {
            $p['status'] = 'success';
            $p['msg'] = "Updated - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Error: Category Name is already Exists or No changes to current one!";
        }
        $p['autoclose'] = true;
        echo json_encode($p);
    }

    public function suggest_attribute()
    {
        $term = $_REQUEST['term'];
        //$p = array();
        $params = array();
        $p['attributes'] = $this->attribute->suggest($term);
        foreach ($p['attributes'] as $attribute) {
            $attribute['label'] = $attribute['name'];
            if (trim($_REQUEST['from']) == 'class') {
                $view_name = 'class/attribute';
                $attribute['newAdded'] = 'yes';
            } else {
                $view_name = 'class/product_attribute';
            }
            $attribute['html'] = $this->load->view($view_name, $attribute, true);
            $params[] = $attribute;
        }
        echo json_encode($params);
        return;
    }

    public function get_attributes_by_class($class_id)
    {
        $p = array();
        $p['class_id'] = $class_id;
        $p['html'] = '';
        $p['attributes'] = $this->class->getAttributes($class_id);
        if (is_array($p['attributes'])) {
            $row_count = count($p['attributes']);
        } else {
            $row_count = 0;
        }
        /*        foreach ($p['attributes'] as &$attribute) {
            $attribute['row_count'] = $row_count++;
            //$p['html'] .= $this->load->view('class/product_attribute', $attribute, true);

        }*/
        $p['row_total'] = $row_count;
        echo json_encode($p);
    }

    public function get_class_tree()
    {
        $tree = array();
        $tree = $this->class->getClassTree();
        print_r($tree);
//        echo json_encode($tree);
    }

    public function get_class_stock_tree($class_id = 0, $item_entity_id = 26)
    {
        //this function will return class tree with stock count
        $sub_classes = $this->class->getAllSubClasses($class_id);
        foreach ($sub_classes as &$sub_class) {
            $sub_class['stock'] = $this->inventory->getClassSpecificStock($class_id, $item_entity_id);
        }
        //foreach, get stock from inventory model
        //create accumulated count for stock
        $stocked_classes = $this->class->accumulateStock($sub_classes, 'ASC');
        //create tree for the stocked classes
        $stocked_tree = $this->class->getClassTree($class_id, $stocked_classes);
        echo json_encode($stocked_tree);
    }

    public function _my_output($file = 'class', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "manage_classification";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('class/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}


/*END OF FILE*/