<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url', 'html'));
        $this->load->library('calendar');
        $this->load->database();
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            redirect('login?error_msg' . urlencode('Please Login'));
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
        $this->load->model("Customer_Model", "customer");
    }

    public function add()
    {
        $p = array();
        $this->_my_output('add', $p);
    }

    public function add_to_db()
    {
        $c = array();
        $c['fname'] = isset($_REQUEST['customer_fname']) ? $_REQUEST['customer_fname'] : '';
        $c['lname'] = isset($_REQUEST['customer_lname']) ? $_REQUEST['customer_lname'] : '';
        $c['phone'] = isset($_REQUEST['customer_phone']) ? $_REQUEST['customer_phone'] : '';
        $c['dob'] = isset($_REQUEST['customer_dob']) ? $_REQUEST['customer_dob'] : '';
        $c['email'] = isset($_REQUEST['customer_email']) ? $_REQUEST['customer_email'] : '';
        $c['building'] = isset($_REQUEST['customer_building']) ? $_REQUEST['customer_building'] : '';
        $c['street'] = isset($_REQUEST['customer_street']) ? $_REQUEST['customer_street'] : '';
        $c['area'] = isset($_REQUEST['customer_area']) ? $_REQUEST['customer_area'] : '';
        $c['city'] = isset($_REQUEST['customer_city']) ? $_REQUEST['customer_city'] : '';
        $c['pin'] = isset($_REQUEST['customer_pin']) ? $_REQUEST['customer_pin'] : '';
        $c['state'] = isset($_REQUEST['customer_state']) ? $_REQUEST['customer_state'] : '';
        $c['sex'] = isset($_REQUEST['customer_sex']) ? $_REQUEST['customer_sex'] : '';
        $c['sms'] = isset($_REQUEST['customer_sms']) ? $_REQUEST['customer_sms'] : '';
        $customer = $this->customer->getCustomerByPhone($c['phone']);
        if (isset($customer['id'])) {
            $c['id'] = $customer['id'];
            $this->customer->update($c['id'], $c['fname'], $c['lname'], $c['dob'], $c['sex'], $c['phone'], $c['email'], $c['sms'], $c['building'], $c['street'], $c['area'], $c['city'], $c['pin'], $c['state']);
            $c['status'] = 'success';
            $c['msg'] = 'Customer details are successfully Updated';
        } else {
            $c_id = $this->customer->add($c['fname'], $c['lname'], $c['dob'], $c['sex'], $c['phone'], $c['email'], $c['sms'], $c['building'], $c['street'], $c['area'], $c['city'], $c['pin'], $c['state'], $this->user->loggedInUserId());
            if ($c_id > 0) {
                $c['id'] = $c_id;
                $c['status'] = 'success';
                $c['msg'] = 'Customer is successfully Created';
            } else {
                $c['status'] = 'error';
                $c['msg'] = 'Failed to create Customer';
            }
        }
//        $output = $this->load->view('billing/suggest_customer', $c, true);
//        $c['output'] = $output;
        $this->_my_output('add', $c);
    }

    public function suggest_customer()
    {
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        if ($term == '') {
            $this->_my_output('', array());
            return;
        }
        $params = array();
        $rs = $this->customer->suggest($term);
        if (is_array($rs) && count($rs) > 0) {
            foreach ($rs as $r) {
                $tmp = array();
                $tmp['id'] = $r['id'];
                $tmp['label'] = $r['fname'] . ' ' . $r['lname'] . ' ( ' . $r['phone'] . ' ) ';
                $tmp['value'] = $r['fname'] . ' ' . $r['lname'] . ' ( ' . $r['phone'] . ' ) ';
                $tmp['html'] = $this->load->view('customer/suggest_customer', $r, true);
                $params[] = $tmp;
            }
        }
        $this->_my_output('', $params);
    }

    public function suggest()
    {
        $term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
        if ($term == '') {
            $this->_my_output('', array());
            return;
        }
        $params = array();
        $rs = $this->customer->suggest($term);
        if (is_array($rs) && count($rs) > 0) {
            foreach ($rs as $r) {
                $tmp = array();
                $tmp['id'] = $r['id'];
                $tmp['label'] = $r['fname'] . ' ' . $r['lname'] . ' ( ' . $r['phone'] . ' ) ';
                $tmp['value'] = $r['fname'] . ' ' . $r['lname'] . ' ( ' . $r['phone'] . ' ) ';
                $tmp['customer'] = $r;
                $params[] = $tmp;
            }
        }
        $this->_my_output('', $params);
    }

    public function get_loyalty_amount($customer_id)
    {
        //$amount = 100;
        //echo json_encode($amount);
        $amount = $this->customer->getLoyaltyAmount($customer_id);
        echo json_encode($amount);
    }
    public function _my_output($file = 'brand', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $this->load->view('customer/' . $file, $params);
    }
 
}

?>
