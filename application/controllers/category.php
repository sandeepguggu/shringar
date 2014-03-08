<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Category extends CI_Controller
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
        $this->load->model('Category_Model', 'category');
        $this->load->model('Class_Model', 'class');
        $this->load->model('User', 'user');
        $this->load->model('Attribute_Model', 'attribute');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        $this->load->database();
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array("ID" => "a.id as id", "NAME" => "a.name as name", "VAT %" => "a.vat_percentage as vat_percentage", "PARENT" => "b.name as parent_name");
        $table = " category a, category b ";
        $where = " where a.parent_id = b.id AND a.id > 0 AND a.deleted = '0' ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('category/edit?ajax=1'), "css" => "btn btn-primary action-btn fancybox"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#'.site_url('category/delete?ajax=1'), "css" => "btn btn-danger action-btn")
        );
        $order_by = " order by `a`.`name` ASC";
        $p = array();
        $p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $order_by, 10, 1);
        $this->_my_output('index', $p);
    }

    public function add()
    {
        $p = array();
        $p['category'] = $this->category->getAll();
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
        $r = $this->category->getById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p['id'] = $r['id'];
        $p['name'] = $r['name'];
        $p['category'] = $this->category->getAll();
        $p['vat_percentage'] = $r['vat_percentage'];
        $p['selected_parent_id'] = $r['parent_id'];
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
        $r = $this->category->deleteById($id);
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
        $parent_id = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : 0;
        $vat_percentage = isset($_REQUEST['vat_percentage']) ? $_REQUEST['vat_percentage'] : 0;
        if ($name == '') {
            $p['failed'] = "Name Required";
            $this->_my_output('add', $p);
            return;
        }
        $id = $this->category->add($name, $parent_id, $vat_percentage, $this->user->loggedInUserId());
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Successfully added! - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Category name is already exist!";
        }
        echo json_encode($p);
    }

    public function update_to_db()
    {
        $p = array();
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $name = isset($_REQUEST['name']) ? $_REQUEST['name'] : '';
        $parent_id = isset($_REQUEST['parent_id']) ? $_REQUEST['parent_id'] : '';
        $vat_percentage = isset($_REQUEST['vat_percentage']) ? $_REQUEST['vat_percentage'] : '';
        log_message('debug', 'parent-id : ' . $parent_id);
        if ($id == '' || $name == '' || $parent_id == '' || $vat_percentage == '') {
            $p['status'] = 'error';
            $p['msg'] = "Missing Params";
            $this->_my_output('error', $p);
            return;
        }
        if ($this->category->update($id, $name, $parent_id, $vat_percentage)) {
            $p['status'] = 'success';
            $p['msg'] = "Updated - ID:" . $id;
        } else {
            $p['msg'] = "Error: Category Name is already Exists or No changes to current one!";
            $p['status'] = 'error';
        }
        $p['autoclose'] = true;
        echo json_encode($p);
    }

    public function _my_output($file = 'category', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "manage_category";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('category/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}
/*END OF FILE*/