<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Purchase_returns extends CI_Controller
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
        $this->load->model('user', 'user');
        $this->load->model('manage_users_model', 'manageUsers');
        $this->load->model('item_entity_model', 'item_entity');
        $this->load->model('grn_model', 'grn');
        $this->load->model('inventory_model', 'inventory');
        $this->load->library('barcode', array());
    }

    public function index()
    {
        $p = array();
        if ($this->user->isAccessAllowed('purchase_returns') === FALSE) {
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

    public function confirm_purchase_return()
    {
        //create
        //add items
        //price-update quantity in grn/purchase return
        //finalize
        //$this->grn->createPurchaseReturn($user_id, $grn_id = 0, $amount = 0, $full_json = '');
        //$this->addItemToPurchaseReturn($purchase_return_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $final_amount, $branch_id);
        $p = array();
        $grn_id = isset($_REQUEST['grn_id']) ? $_REQUEST['grn_id'] : 0;
        $this->db->trans_begin();
        $p = array();
        $p['tab'] = 'purchase_return';
        $p['selected_products'] = array();
        foreach ($_REQUEST['item_id'] as $item_id) {
            $item = array();
            $id_array = explode('_', $item_id);
            $item['item_entity_id'] = $id_array[0];
            $item['item_specific_id'] = $id_array[1];
            $item['grn_item_id'] = $_REQUEST['grn_item_id_' . $item_id];
            $item['quantity'] = isset($_REQUEST['quantity_' . $item_id]) ? $_REQUEST['quantity_' . $item_id] : 1;
            $item['weight'] = isset($_REQUEST['weight_' . $item_id]) ? $_REQUEST['weight_' . $item_id] : 0;
            $item['price'] = isset($_REQUEST['price_' . $item_id]) ? $_REQUEST['price_' . $item_id] : 0;
            $item['name'] = isset($_REQUEST['name_' . $item_id]) ? $_REQUEST['name_' . $item_id] : 0;
            $item['vat_percentage'] = isset($_REQUEST['vat_percentage_' . $item_id]) ? $_REQUEST['vat_percentage_' . $item_id] : 0;
            //TODO - make this calculation correct consul sagar bhai, clients etc
            $item['vat'] = $item['price'] * $item['vat_percentage'] / 100;
            $item['final_amount'] = ($item['price'] + $item['vat']) * $item['quantity'];
            $p['selected_products'][] = $item;
        }
        $total_purchase_return = 0;
        $purchase_return_id = $this->grn->createPurchaseReturn($this->user->getUserId(), $grn_id, 0, json_encode($p));
        $item_entity_id = $this->item_entity->getEntityId('purchase_return');
        $purchase_return_barcode = $this->barcode->getBarcode($item_entity_id, $purchase_return_id);
        foreach ($p['selected_products'] as $item) {
            $item_final_amount = $item['quantity'] * $item['price'];
            $total_purchase_return += $item_final_amount;
            if ($this->grn->addItemToPurchaseReturn($purchase_return_id, $item['item_entity_id'], $item['item_specific_id'], $item['quantity'], $item['price'], $item['vat'], $item['final_amount'], $this->user->getBranch())) {
                if ($grn_id > 0) {
                    $this->grn->updateItemPurchaseReturn($grn_id, $item['grn_item_id'], $item['quantity']);
                }
                $this->inventory->add($item['item_entity_id'], $item['item_specific_id'], $this->user->getBranch(), $item['quantity'], $item['weight'], 0, '', $this->user->getUserId(), $purchase_return_barcode);
            }
        }
        $p['total_purchase_return'] = $total_purchase_return;
        $this->grn->finalizePurchaseReturn($purchase_return_id, $total_purchase_return, json_encode($p));
        $p['grn']['full_json'] = '';
        if ($this->db->trans_status() === FALSE) {
            $p['success'] = false;
            $this->db->trans_rollback();
        } else {
            $p['success'] = true;
            $this->db->trans_commit();
        }
        redirect('purchase_returns/print_purchase_return/' . $purchase_return_id . '/0');
    }

    public function print_purchase_return($purchase_return_id, $print = 0)
    {
        //print purchase return page - for reference (no accounting use)
        if ($purchase_return_id == '') {
            if (!isset($_REQUEST['id']) || $_REQUEST['id'] == '') {
                redirect('grn');
            }
            $purchase_return_id = $_REQUEST['id'];
        }
        if ($purchase_return_id == 0) {
            $params['status'] = $purchase_return_id;
        } else {
            $params['status'] = 1;
        }
        $purchase_return_full = $this->grn->getPurchaseReturn($purchase_return_id);
        if (!$purchase_return_full || !is_array($purchase_return_full) || count($purchase_return_full) < 1) {
            $params['status'] = 0;
            $params['error_msg'] = 'No Purchase Return associated with this ID!';
            $this->_my_output('print_purchase_return', $params);
            return;
        }
        $p = json_decode($purchase_return_full['full_json'], TRUE);
        //log_message('error', 'GRN JSON::' . print_r($p, 1));
        foreach ($p['selected_products'] as $product) {
        }
        $p['print'] = $print;
        $p['purchase_return_id'] = $purchase_return_id;
        $p['date'] = $purchase_return_full['created_at'];
        $item_entity_id = $this->item_entity->getEntityId('purchase_return');
        $p['barcode'] = $this->barcode->getBarcode($item_entity_id, $purchase_return_id);
        //log_message('error', "IN GRN".print_r($p, 1));
        //$p['print'] = intval($print);
        $params += array('output' => $p, 'tab' => 'purchase_return');
        if (!$print) {
            $this->_my_output('print_purchase_return', $params);
        } else {
            $this->load->view('header_print', array());
            $this->load->view('grn/print_purchase_return', $params);
            $this->load->view('footer_print', array());
        }
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

    public function _my_output($file = 'index', $params = array())
    {
        if ($this->json === true) {
            echo json_encode($params);
            return;
        }
        $p['tab'] = "purchase_returns";
        $p['ajax'] = $this->ajax;
        $p['output'] = $this->load->view('purchase_returns/' . $file, $params, true);
        $p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
        $this->load->view('template', $p);
    }
}

?>