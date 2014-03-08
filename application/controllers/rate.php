<?php
/**
 * Description of rate
 *
 * @author Sandeep
 */
class rate extends CI_Controller {
    
    public function __construct() {
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

        if ($this->ajax === false) {
            redirect('purchases');
        }
        $this->load->model('metal_model', 'metal');
        $this->load->model('rate_model', 'rate');
    }
    
    public function add() {
        $p = array();
        $p['metals'] = $this->metal->getAll();
        if($p['metals'] == false) {
            $p['status'] = false;
            $p['msg'] = 'No Metals are Added to Databse Yet.';
            $this->_my_output('add', $p);
            return;
        }
        
        $this->_my_output('add', $p);
    }
    
    public function add_to_db() {
        $p = array();
        $id = isset($_REQUEST['metal-id']) ? $_REQUEST['metal-id'] : '';
        $price = isset($_REQUEST['metal-rate']) ? $_REQUEST['metal-rate'] : '';
        if($id == '' || $price == '') {
            $p['status'] = false;
            $p['msg'] = 'Error in parameters transmission';
            $this->_my_output('add', $p);
            return;
        }
        
        $rate_status = $this->rate->addMetalRate($id, $price);
        $p['status'] = $rate_status['status'];
        $p['msg'] = $rate_status['msg'];

        $this->_my_output('add', $p);
    }
    
    public function _my_output($file = 'product', $params = array()) {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $this->load->view('rate/' . $file, $params);
    }
}

?>
