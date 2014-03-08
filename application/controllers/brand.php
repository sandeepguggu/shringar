<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Brand extends CI_Controller
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
        $this->load->model('brand_Model', 'brand');
        $this->load->model('User', 'user');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        // debugbreak();
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "id", "NAME" => "name");
        $table = " `brand` ";
        $where = " WHERE `deleted` = '0' ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('brand/edit?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#' . site_url('brand/delete?ajax=1'), "css" => "btn btn-danger dialog-confirm action-btn")
        );
        $orderby = " order by `name` ASC";
        $p = array();
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $orderby, 10, 1);
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
        $r = $this->brand->getById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['id'] = $r['id'];
        $p['name'] = $r['name'];
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
        $r = $this->brand->deleteById($id);
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
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        if ($name == '') {
            $p['status'] = 'error';
            $p['msg'] = "Name Required";
            echo json_encode($p);
            return;
        }
        $id = $this->brand->add($name, $this->user->loggedInUserId(), $description);
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully added! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Brand already Exists or Failed to Register the Brand!";
        }
        echo json_encode($p);
    }

    public function update_to_db()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $description = isset($_REQUEST['description']) ? $_REQUEST['description'] : '';
        if ($id == '' || $name == '') {
            $p['status'] = 'error';
            $p['msg'] = "Missing Params";
            echo json_encode($p);
            return;
        }
        if ($this->brand->update($id, $name, $description)) {
            $p['status'] = 'success';
            $p['msg'] = "Updated - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Error: You Changes affecting the other Brand Names or no changes to the current Brand Name!";
        }
        $p['autoclose'] = true;
        echo json_encode($p);
    }

    public function suggest_brand()
    {
        $term = $_REQUEST['term'];
        //$p = array();
        $params = array();
        $p['brands'] = $this->brand->suggest($term);
        foreach ($p['brands'] as $brand) {
            $brand['label'] = $brand['name'];
            $params[] = $brand;
        }
        echo json_encode($params);
        return;
    }

    public function _my_output($file = 'brand', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "manage_brands";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('brand/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}

?>