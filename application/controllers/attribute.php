<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class attribute extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url', 'form', 'html'));
        $this->load->library('calendar');
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
        /*			if($this->ajax === false){
            redirect('purchases');
        }*/
        $this->load->model('attribute_Model', 'attribute');
        $this->load->model('User', 'user');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "id", "NAME" => "name");
        $table = " `attribute` ";
        $where = " WHERE `deleted` = '0' ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('attribute/edit?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#' . site_url('attribute/delete?ajax=1'), "css" => "btn btn-danger dialog-confirm action-btn")
        );
        $order_by = " order by `name` ASC";
        $p = array();
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $order_by, 50, 1);
        $this->_my_output('index', $p);
    }

    public function add()
    {
        $p = array();
        $this->_my_output('add', $p);
    }

    public function edit()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['msg'] = "Missing Id";
            $this->_my_output('error', $p);
            return;
        }
        $p = $this->attribute->getById($id);
        if (!isset($p['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $this->_my_output('edit', $p);
    }

    public function delete()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($id == '') {
            $p['status'] = 'error';
            $p['msg'] = "Missing Id";
            echo json_encode($p);
            return;
        }
        $r = $this->attribute->deleteById($id);
        if (!isset($r['id'])) {
            $p['status'] = 'error';
            $p['msg'] = "Invalid Id";
            echo json_encode($p);
            return;
        }
        $p['status'] = 'success';
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        echo json_encode($p);
    }

    public function add_to_db()
    {
        $p = array();
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $level = '';
        $multiplier = isset($_REQUEST['multiplier']) ? $_REQUEST['multiplier'] : '';
        $minimum_value = isset($_REQUEST['minimum_value']) ? $_REQUEST['minimum_value'] : '';
        $maximum_value = isset($_REQUEST['maximum_value']) ? $_REQUEST['maximum_value'] : '';
        $default_value = isset($_REQUEST['default_value']) ? $_REQUEST['default_value'] : '';
        $value_letter_type = isset($_REQUEST['value_letter_type']) ? $_REQUEST['value_letter_type'] : '';
        $value_set_editable = isset($_REQUEST['value_set_editable']) ? $_REQUEST['value_set_editable'] : '';
        $value_set_values = isset($_REQUEST['value_set_values']) ? $_REQUEST['value_set_values'] : '';
        $display_name = isset($_REQUEST['display_name']) ? $_REQUEST['display_name'] : '';
        $criticality = isset($_REQUEST['criticality']) ? $_REQUEST['criticality'] : '';
        $availability = isset($_REQUEST['availability']) ? $_REQUEST['availability'] : '';
        $value_type = isset($_REQUEST['value_type']) ? $_REQUEST['value_type'] : '';
        $value_special = isset($_REQUEST['value_special']) ? $_REQUEST['value_special'] : '';
        $value_number = isset($_REQUEST['value_number']) ? $_REQUEST['value_number'] : '';
        if ($name == '') {
            $p['failed'] = "Name Required";
            $this->_my_output('add', $p);
            return;
        }
        if ($value_type == 'set') {
            if ($value_set_editable == 'yes') {
                $value_type = 'enum_fixed';
            } else {
                $value_type = 'enum_editable';
            }
        } elseif ($value_type == 'text') {
            if ($value_special == 'special') {
                $character_set = 3;
            } elseif ($value_number == 'numeric') {
                $character_set = 2;
            } else {
                $character_set = 1;
            }
        }
        /*        if ($value_letter_type == 'caps') {
        $value_letter_type = 'caps';
        }*/
        if (1) {
        }
        $id = $this->attribute->add($name, $level, $display_name, $availability, $value_type, $criticality, $value_set_values, $value_letter_type, $minimum_value, $maximum_value, $character_set, $default_value);
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully added! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "attribute already Exists or Failed to Register the attribute!";
        }
        echo json_encode($p);
    }

    public function update_to_db()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        if ($id == '' || $name == '') {
            $p['msg'] = "Missing Params";
            $this->_my_output('error', $p);
            return;
        }
        if ($this->attribute->update($id, $name)) {
            $p['status'] = 'success';
            $p['msg'] = "Updated - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Error: You Changes affecting the other attribute Names or no changes to the current attribute Name!";
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
            $params[] = $attribute;
        }
        echo json_encode($params);
        return;
    }

    public function _my_output($file = 'attributes', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "manage_attributes";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('attributes/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
/*END OF FILE*/