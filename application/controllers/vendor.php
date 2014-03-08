<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Vendor extends CI_Controller
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
        if ($this->json === true) {
            $this->ajax = true;
        }
        $this->load->model('vendor_Model', 'vendor');
        $this->load->model('User', 'user');
        $this->load->model('manage_users_model', 'manageUsers');
    }

    public function index()
    {
        //$GLOBALS['debug'] = 1;
        $this->load->library('datagrid', array('db' => &$this->db));
        $fields = array(
            "ID" => "id",
            "Company Name" => "company_name",
            "Contact Person" => "main_person_name",
            "Address" => "address",
            "City" => "city",
            "Mobile" => "mobile",
            "Comments" => "comments"
        );
        $table = " `vendors` ";
        $where = " WHERE `deleted` = '0' ";
        $actions = array(
            '<i class="icon-pencil icon-white"></i>' => array("url" => site_url('vendor/edit?ajax=1'), "css" => "btn btn-primary fancybox action-btn"),
            '<i class="icon-trash icon-white" onclick="deleteConfirmation(this)"></i>' => array("url" => '#' . site_url('vendor/delete?ajax=1'), "css" => "btn btn-danger action-btn")
        );
        $orderby = " order by `company_name` ASC";
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
        $r = $this->vendor->getById($id);
        if (!isset($r['id'])) {
            $p['msg'] = "Invalid Id";
            $this->_my_output('error', $p);
            return;
        }
        $p = $r;
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
        $r = $this->vendor->deleteById($id);
        if (!isset($r['id'])) {
            $p['status'] = 'error';
            $p['msg'] = "Invalid Id";
            echo json_encode($p);
            return;
        }
        $p['status'] = 'success';
        $p['msg'] = "Successfully Deleted, Record Id " . $r['id'];
        echo json_encode($p);
        return;
    }

    public function suggest_person()
    {
        $params = array();
        if (isset($_REQUEST['term']) && isset($_REQUEST['vendor_id']) && $_REQUEST['vendor_id'] > 0) {
            $p = $this->vendor->suggest_person($_REQUEST['term'], $_REQUEST['vendor_id']);
            if (isset($p) && is_array($p)) {
                foreach ($p as $v) {
                    $a = array();
                    $a['id'] = $v['id'];
                    $a['label'] = $v['contact_name'] . " ( " . $v['contact_phone'] . " )";
                    $a['value'] = $v['contact_name'];
                    $a['row'] = $v;
                    $params[] = $a;
                }
            }
        } else {
            $params[] = array("id" => "No Record!", "label" => "No Record!", "value" => "No Record!");
        }
        $this->_my_output('', $params);
    }

    public function suggest_vendors()
    {
        $params = array();
        $from = isset($_REQUEST['from']) ? $_REQUEST['from'] : 'grn';
        if (isset($_REQUEST['term'])) {
            $p = $this->vendor->suggest_vendors(mysql_real_escape_string($_REQUEST['term']));
            if (isset($p) && is_array($p)) {
                foreach ($p as $v) {
                    $a = array();
                    $a['id'] = $v['id'];
                    $a['label'] = $v['company_name'];
                    $a['value'] = $v['company_name'];
                    if ($from == "grn") {
                        //$a['html'] = $this->load->view('grn/grn_vendor', $v, true);
                    } else if ($from == "po") {
                        //$a['html'] = $this->load->view('po/po_vendor', $v, true);
                    }
                    $params[] = $a;
                }
            }
        } else {
            $params[] = array("id" => "No Record!", "label" => "No Record!", "value" => "No Record!");
        }
        $this->_my_output('', $params);
    }

    public function add_to_db()
    {
        $p = array();
        $company_name = isset($_REQUEST['company_name']) ? $_REQUEST['company_name'] : '';
        $main_person_name = isset($_REQUEST['main_person_name']) ? $_REQUEST['main_person_name'] : '';
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $pin = isset($_REQUEST['pin']) ? $_REQUEST['pin'] : '';
        $phone1 = isset($_REQUEST['phone1']) ? $_REQUEST['phone1'] : '';
        $phone2 = isset($_REQUEST['phone2']) ? $_REQUEST['phone2'] : '';
        $mobile = isset($_REQUEST['mobile']) ? $_REQUEST['mobile'] : '';
        $comments = isset($_REQUEST['comments']) ? $_REQUEST['comments'] : '';
        if ($company_name == '') {
            $p['status'] = 'error';
            $p['msg'] = "Missing Company Name";
            echo json_encode($p);
            return;
        }
        $id = $this->vendor->add($company_name, $main_person_name, $phone1, $address, $city, $pin, $phone2, $mobile, $comments, $this->user->loggedInUserId());
        if ($id !== false) {
            $p['status'] = 'success';
            $p['msg'] = "Vendor is successfully added to the application system database - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Vendor is already exists or no changes to vendor Details!";
        }
        echo json_encode($p);
        return;
    }

    public function update_to_db()
    {
        $p = array();
        $company_name = isset($_REQUEST['company_name']) ? $_REQUEST['company_name'] : '';
        $main_person_name = isset($_REQUEST['main_person_name']) ? $_REQUEST['main_person_name'] : '';
        $address = isset($_REQUEST['address']) ? $_REQUEST['address'] : '';
        $city = isset($_REQUEST['city']) ? $_REQUEST['city'] : '';
        $pin = isset($_REQUEST['pin']) ? $_REQUEST['pin'] : '';
        $phone1 = isset($_REQUEST['phone1']) ? $_REQUEST['phone1'] : '';
        $phone2 = isset($_REQUEST['phone2']) ? $_REQUEST['phone2'] : '';
        $mobile = isset($_REQUEST['mobile']) ? $_REQUEST['mobile'] : '';
        $comments = isset($_REQUEST['comments']) ? $_REQUEST['comments'] : '';
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
        if ($company_name == '' || $address == '' || $main_person_name == '' || $id == '') {
            $p['status'] = 'error';
            $p['msg'] = "Missing Params";
            echo json_encode($p);
            return;
        }
        if ($this->vendor->update($id, $company_name, $main_person_name, $phone1, $address, $city, $pin, $phone2, $mobile, $comments)) {
            $p['status'] = 'success';
            $p['msg'] = "Updated - ID:" . $id;
        } else {
            $p['status'] = 'error';
            $p['msg'] = "Vendor is already exists or no changes to vendor Details!";
        }
        $p['autoclose'] = true;
        echo json_encode($p);
        return;
    }

    public function _my_output($file = 'index', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "manage_vendors";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('vendor/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        if ($this->ajax === false) {
            $this->load->view('template', $p);
        } else {
            echo $p['output'];
        }
    }
}

?>