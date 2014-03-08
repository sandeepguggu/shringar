<?php
	/**
	* File Name: invoice.php
	* Author: Rajat
	* Date: 5/21/12
	* Time: 12:38 PM
	*/
	if (!defined('BASEPATH'))
		exit('No direct script access allowed');
	class Invoice extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->helper(array('url', 'form', 'html'));
			$this->load->library('calendar');
			$this->load->library('productLib', array());
			$this->load->library('barcode', array());
			if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
				log_message('debug', 'Log in problem ');
				redirect('login?error_msg=' . urlencode("Please  Login"));
			}
			$this->ajax = false;
			$this->json = false;
			if ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 1) || isset($_REQUEST['tabs']) && $_REQUEST['tabs'] == 1) {
				$this->ajax = true;
			}
			if (isset($_REQUEST['json']) && $_REQUEST['json'] == 1) {
				$this->json = true;
			}
			$this->load->model("Customer_Model", "customer");
			$this->load->model("Bill_Model", "bill");
			$this->load->model('estimate_model', 'estimate');
			$this->load->model('product_Model', 'product');
			$this->load->model('user', 'user');
			$this->load->model('rate_model', 'rate');
			$this->load->model('item_entity_model', 'item_entity');
			$this->load->model('ornament_model', 'ornament');
			$this->load->model('ornament_product_model', 'ornament_product');
			$this->load->model('inventory_model', 'inventory');
			$this->load->model('metal_model', 'metal');
			$this->load->model('old_purchase_bill_model', 'old_purchase_bill');
			$this->load->model('scheme_model', 'scheme');
			$this->load->model('customer_order_model', 'customer_order');
			$this->load->model('stone_model', 'stone');
			$this->load->model('cart_model', 'cart');
			$this->load->model('manage_users_model', 'manageUsers');
		}

		public function index()
		{
			$this->new_invoice();
			//$this->_my_output('index', $params);
		}

		public function search()
		{
			$p = array();
			$p['tab'] = 'search_invoice';
			$this->_my_output('search', $p);
		}

		/* public function latest_invoices() {
		$data = $this->bill->latestInvoices();
		if(!$data)
		$output = "No Records";
		else {
		$output = $this->load->view('billing/latest_invoices',array('data' => $data),TRUE);
		}

		echo $output;
		return;
		}   SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `bill` b
		WHERE `c`.`id` = `b`.`customer_id` ORDER BY b.created_at DESC LIMIT 0, 20  */
		public function latest_invoices($count =''){
			$from = !empty($_GET['from_date']) ? date("Y-m-d H:i:s",strtotime(trim($_GET['from_date']))) : '';
			$to = !empty($_GET['to_date']) ? date("Y-m-d H:i:s",strtotime(trim($_GET['to_date']))) : '';

			$this->load->library('datagrid', array('db' => &$this->db));
			$fields = array("ID" => "b.id as id", "AMOUNT" => "b.final_amount AS Amount", 'STATUS' => 'b.status as status', "NAME" => "CONCAT(c.fname,' ' ,c.lname) AS name","PHONE"=>"c.phone as c_phone");
			$table = " `bill` b, `customers` c ";
			$where = " WHERE b.customer_id = c.id";
			if(!empty($from))
			{
				$where.=" and b.created_at >= '".$from."'"; 
			}
			if(!empty($to))
			{
				$where.=" and b.created_at <= '".$to."'"; 
			}
			$actions = array(
				'<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('invoice/print_invoice?ajax=1'), "css" => "btn btn-success action-btn"),
				'<i class=" icon-info-sign icon-user"></i>' => array("url" => site_url('invoice/split_amount?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
			);
			$order_by = " ORDER BY b.id DESC";
			$config = array();
			$config['checkbox'] = 0;
			$config['count_distinct'] = '';
			$config['countlimit'] = !empty($count) ? $count : '';
			// $config['excel'] = 1;
			$p['from'] = $from;
			$p['to'] = $to;
			$p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $order_by, 20, 1, $config);
			//  debugbreak();
			if( !isset($_GET['page']) &&   (isset($_GET['date'])))
			{
				echo $p['grid'];
			} else{
				$p['tab'] = 'new_invoice';
				$this->_my_output('search', $p);
			}
		}
		public function split_amount()
		{
			$p = array();
			$id = $_GET['id'];
			//      debugbreak();
			$p['id'] = $id;
			$p['amount'] =    $this->bill->getAmountPaidforBill($id);
			$this->_my_output('split_bill', $p);

		}
		public function submit_split_bill()
		{
			//  debugbreak();
			$id = $_REQUEST['id'];
			$card = floatval($_REQUEST['card']);
			$cash =  floatval($_REQUEST['cash']);
			$result = $this->bill->submitSplitBill($id , $card , $cash);
			echo true;
		}
		public function new_invoice($credit_note_id = -1)
		{
			$p = array();
			$output = array();
			$output['entities'] = $this->item_entity->getAllItemEntities();
			// TODO - access control to be fixed properly
			if ($this->manageUsers->isAccessAllowed('new_invoice') === FALSE) {
				$p['access'] = "Access Denied";
			}
			$output['credit_note_id'] = $credit_note_id;
			if ($credit_note_id != -1) {
				$details = $this->bill->getDetailsByCreditID($credit_note_id);
				$c = json_decode($details['full_json'], true);
				$output['c'] = $c['c'];
			}
			$p['output'] = $output;
			$p['tab'] = 'new_invoice';
			$p['bill_id'] = $this->bill->getlatestbillid();
			$walkin = $this->customer->get_walkin_customer();
			$p['customer_id'] = $walkin['id'];
			$p['customer_name'] = $walkin['fname'];
			$this->_my_output('invoice', $p);
		}

		public function estimate_bill()
		{
			// TODO - this function will generate exact bill copy/with estimate header
			$customer_id = $_REQUEST['customer-id'];
			$products = array();
			$vat_amount = 0;
			$bill_final_amount = 0;
			$discount_amount = 0;
			foreach ($_REQUEST['item_id'] as $item_id) {
				$product_id_array = explode('_', $item_id);
				$product['item_entity_id'] = $product_id_array[0];
				$product['item_specific_id'] = $product_id_array[1];
				$product['row_count'] = $product_id_array[2];
				$product['discount'] = $_REQUEST['discount_' . $item_id];
				$product['quantity'] = isset($_REQUEST['quantity_' . $item_id]) ? $_REQUEST['quantity_' . $item_id] : 1;
				/*            foreach($_REQUEST['sub_item_id_'.$product['row_count']] as $sub_item_id){
				$sub_id_array = explode('_', $sub_item_id);
				$product['items'][] = array('item_entity_id' => $sub_id_array[0], 'item_specific_id' => $sub_id_array[1],
				'rate' => $_REQUEST['sub_rate_'.$sub_id_array[0].'_'.$sub_id_array[1].'_'.$product['row_count']]);
				} */
				//log_message('error', "product".print_r($product['rate'], 1));
				$product_lib_result = $this->productlib->getProductDetails($product['item_entity_id'], $product['item_specific_id']);
				//log_message('error', 'IN BILLING::details_before edit'.print_r($product_lib_result, 1));
				//remove vat and making/wastage depending on scheme things
				$product_lib_result['rate'] = $product_lib_result['rate'] + $product_lib_result['rate'] * ($product_lib_result['wastage_percent'] + $product_lib_result['making_cost_percent']) / 100;
				//log_message('error', 'IN BILLING::details_before edit-sftermcwc'.print_r($product_lib_result['rate'], 1));
				$product['price_initial'] = $product_lib_result['rate'];
				$product['discount'] = $product_lib_result['rate'] * $product['discount'] / 100;
				$discount_amount += $product['discount'];
				$product_lib_result['rate'] -= $product['discount'];
				//log_message('error', 'IN BILLING::details_before edit-afterdiscount'.print_r($product_lib_result['rate'], 1));
				$product['vat_amount'] = $product_lib_result['rate'] * $product_lib_result['vat'] / 100;
				$vat_amount += $product['vat_amount'];
				$product_lib_result['rate'] += $product['vat_amount'];
				$bill_final_amount += $product_lib_result['rate'];
				$product = array_merge($product, $product_lib_result);
				$products[] = $product;
				//log_message('error', 'IN BILLING::details' . print_r($product, 1));
			}
			$payment_cash = $_REQUEST['payment-cash'];
			$payment_card = $_REQUEST['payment-card'];
			$payment_scheme = 0;
			// TODO - get from scheme model and add the amount here
			$paid_amount = $payment_card + $payment_cash;
			if ($paid_amount >= $bill_final_amount) {
				$status = 'paid';
			} else {
				$status = 'unpaid';
			}
			$bill_array = array('bill_id' => 0, 'bill_amount' => $bill_final_amount, 'vat_amount' => $vat_amount, 'discount' => $discount_amount, 'products' => $products, 'status' => $status);
			$bill_array['date'] = date('d-m-Y');
			$this->db->trans_begin();
			$bill_id = $this->estimate->create($this->user->loggedInUserId(), $payment_cash, $payment_card, $payment_scheme, $customer_id, 'percentage', $discount_amount, $vat_amount, $bill_final_amount, $paid_amount, $status, json_encode($bill_array));
			foreach ($products as $product) {
				$this->estimate->add_item($bill_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'], $product['price_initial'], $product['vat_amount'], $product['discount'], $product['rate']);
			}
			if ($this->db->trans_status() === FALSE) {
				$p['success'] = false;
				$this->db->trans_rollback();
			} else {
				$p['success'] = true;
				$this->db->trans_commit();
			}
			$bill_array['bill_id'] = $bill_id;
			$item_entity_id = $this->bill->getItemEntityId();
			$bill_array['barcode'] = $this->barcode->getBarcode($item_entity_id, $bill_id);
			redirect(site_url('/billing/print_estimate/' . $bill_id), 'refresh', 302);
			//$params = array('output' => $bill_array, 'tab' => 'invoice');
			//$this->_my_output('bill_estimate', $params);
		}

		/**
		* Invoice - Payment
		*/
		public function payment()
		{
			$c = $this->customer->getById($_REQUEST['customer_id']);
			$count = 1;
			$products = '';
			$product_total_amount = 0;
			foreach ($_REQUEST['selected_products'] as $p) {
				$product = $this->product->getById($p);
				$product_price = $_REQUEST['qnt_' . $p] * ($product['sell_price'] + (($product['sell_price'] / 100) * $product['vat']));
				$products .= '<tr>
				<td>' . $count++ . '</td>
				<td>' . $product['name'] . '</td>
				<td>' . $_REQUEST['qnt_' . $p] . '</td>
				<td>' . $product['sell_price'] . '</td>
				<td>' . $product['vat'] . '</td>
				<td class="product_total">' . $product_price . '</td>
				</tr>';
				$product_total_amount += $product_price;
			}
			$p = array();
			$p['customer_id'] = $_REQUEST['customer_id'];
			$p['tab'] = "invoice";
			$p['c'] = $c;
			$p['products'] = $products;
			$p['product_total_amount'] = $product_total_amount;
			$p['discount_option'] = isset($_REQUEST['discount_option']) ? $_REQUEST['discount_option'] : '';
			$p['discount_value'] = isset($_REQUEST['discount_value']) ? $_REQUEST['discount_value'] : 0;
			$p['customer_type'] = isset($_REQUEST['customer_type']) ? $_REQUEST['customer_type'] : '';
			$p['pay_amount'] = $product_total_amount;
			if ($p['discount_option'] == "percentage") {
				$p['pay_amount'] = $product_total_amount - (($product_total_amount / 100) * $p['discount_value']);
			} else if ($p['discount_option'] == "amount") {
				$p['pay_amount'] -= $p['discount_value'];
			}
			$credit_note_id = $_REQUEST['credit_note_id'];
			$p['credit_note_id'] = $credit_note_id;
			if ($credit_note_id != -1) {
				$details = $this->bill->getDetailsByCreditID($credit_note_id);
				$p['credit_note_amount'] = $details['amount'];
			}
			$this->_my_output('payment', $p);
		}

		private function process_payment($customer_id)
		{
			$payments = array();
			if (isset($_REQUEST['invoice_cash_amt'])) {
				//cash handling block
				$cash = array();
				$cash['amount'] = $_REQUEST['invoice_cash_amt'];
				$payments['cash'] = $cash;
			}
			if (isset($_REQUEST['invoice_loyalty_amt'])) {
				//loyalty points
				$loyalty_points = array();
				$loyalty_points['amount'] = $_REQUEST['invoice_loyalty_amt'];
				if ($loyalty_points['amount'] > 0) {
					if (!$this->customer->redeemLoyaltyAmount($customer_id, $loyalty_points['amount'])) {
						$this->failInvoice(530, 'loyalty point redemption failed');
					}
				}
				$payments['loyalty_points'] = $loyalty_points;
			}
			if (isset($_REQUEST['invoice_card_amt'])) {
				//card array
				$cards = array();
				$cards['amount'] = 0;
				for ($i = 0; $i < count($_REQUEST['invoice_card_amt']); $i++) {
					$card = array();
					$card['amount'] = $_REQUEST['invoice_card_amt'][$i];
					$card['bank_name'] = $_REQUEST['invoice_card_bank_name'][$i];
					$card['approval_code'] = $_REQUEST['invoice_card_bank_approval'][$i];
					$card['last_digits'] = $_REQUEST['invoice_card_last_digits'][$i];
					$cards[] = $card;
					$cards['amount'] += $card['amount'];
				}
				$payments['cards'] = $cards;
			}
			if (isset($_REQUEST['invoice_cheque_amt'])) {
				//cheques array
				$cheques = array();
				$cheques['amount'] = 0;
				for ($i = 0; $i < count($_REQUEST['invoice_cheque_amt']); $i++) {
					$cheque = array();
					$cheque['amount'] = $_REQUEST['invoice_cheque_amt'][$i];
					$cheque['bank_name'] = $_REQUEST['invoice_cheque_bank_name'][$i];
					$cheque['number'] = $_REQUEST['invoice_cheque_no'][$i];
					$cheques[] = $cheque;
					$cheques['amount'] += $cheque['amount'];
				}
				$payments['cheques'] = $cheques;
			}
			if (isset($_REQUEST['invoice_scheme_amt'])) {
				//schemes array
				$schemes = $this->create_scheme_array();
				$payments['scheme'] = $schemes;
			}
			if (isset($_REQUEST['invoice_old_purchase_bill_amt'])) {
				//old purchase bill
				$old_purchase_bills = array();
				$old_purchase_bills['amount'] = 0;
				for ($i = 0; $i < count($_REQUEST['invoice_old_purchase_bill_amt']); $i++) {
					$old_purchase_bill = array();
					$old_purchase_bill['amount'] = $_REQUEST['invoice_old_purchase_bill_amt'][$i];
					$old_purchase_bill['number'] = $_REQUEST['invoice_old_purchase_id'][$i];
					if (!$this->old_purchase_bill->redeemAmount($old_purchase_bill['number'], $old_purchase_bill['amount'])) {
						$this->failInvoice(566, print_r($old_purchase_bill, 1));
					}
					$old_purchase_bills[] = $old_purchase_bill;
					$old_purchase_bills['amount'] += $old_purchase_bill['amount'];
				}
				$payments['old_purchase_bills'] = $old_purchase_bills;
			}
			if (isset($_REQUEST['invoice_customer_order_id'])) {
				//customer order array
				$customer_order = array();
				$customer_order['id'] = $_REQUEST['invoice_customer_order_id'];
				$customer_order['amount'] = $_REQUEST['invoice_customer_advance_amt'];
				if ($customer_order['amount'] > 0) {
					if (!$this->customer_order->redeemAmount($customer_order['id'], $customer_order['amount'])) {
						$this->failInvoice(588, 'amount customer order cannot be redeemed');
					}
				}
				$payments['customer_order'] = $customer_order;
			}
			return $payments;
		}

		private function failInvoice($line_no = 0, $print_params = '')
		{
			$this->db->trans_rollback();
			log_message('error', "Failed in billing {$line_no}::" . $print_params);
			redirect(site_url('/invoice/print_invoice/failed'), 'refresh', 302);
		}

		private function getInvoiceTaxes($subtotal)
		{
			$excise_duty = .35;
			if ($subtotal >= 200000) {
				$wealth_tax = 2;
			} else {
				$wealth_tax = 0;
			}
			$return = array();
			$return['subtotal'] = $subtotal;
			$return['excise_duty'] = ($subtotal * $excise_duty) / 100;
			$return['wealth_tax'] = ($subtotal * $wealth_tax) / 100;
			$return['total'] = $return['subtotal'] + $return['excise_duty'] + $return['wealth_tax'];
			return $return;
		}

		public function generate_bill($bill = 1, $estimate = 0, $cart = 0)
		{
			 //debugbreak();
			//log_message('error', "REQUEST to bill" . print_r($_REQUEST, 1));
			// customer details retrieval
			
			$invoice = array();
			$customer_id = $_REQUEST['customer-id'];
			$customer = $this->customer->getById($customer_id);
			$invoice['customer'] = $customer;
			$products = array();
			$vat_amount = 0;
			$bill_total_amount = 0;
			$bill_final_amount = 0;
			$discount_amount = 0;
			$branch_id = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();
			$invoice['discount_percent'] = isset($_REQUEST['discount_percentage']) ? $_REQUEST['discount_percentage'] : 0;
			$this->db->trans_begin();
			foreach ($_REQUEST['item_id'] as $item_id) {
				$product_id_array = explode('_', $item_id);
				$product['item_entity_id'] = $product_id_array[0];
				$product['item_specific_id'] = $product_id_array[1];
				$product['row_count'] = $product_id_array[2];
				$product['discount'] = isset($_REQUEST['discount_' . $item_id]) ? $_REQUEST['discount_' . $item_id] : $invoice['discount_percent'];
				$product['extratax'] = isset($_REQUEST['extratax_' . $item_id]) ? $_REQUEST['extratax_' . $item_id] : $invoice['extratax'];

				$product['quantity'] = isset($_REQUEST['quantity_' . $item_id]) ? $_REQUEST['quantity_' . $item_id] : 1;
				$product_lib_result = $this->productlib->getProductDetails($product['item_entity_id'], $product['item_specific_id']);
				$product_lib_result['vat_percentage'];
				//log_message('error', 'IN BILLING::detalis_before edit' . print_r($product_lib_result, 1));
				$product['price_initial'] = $product_lib_result['rate'];
				$bill_total_amount += $product['price_initial'] * $product['quantity'];
				$product['discount_amount'] = $product_lib_result['rate'] * $product['discount'] / 100;
				$discount_amount += $product['discount_amount'];
				$product_lib_result['rate'] -= $product['discount_amount'];
				//TODO there can be two different calculations, make it configurable later
				//$product['vat_amount'] = $product_lib_result['rate'] * (isset($product_lib_result['vat']) ? $product_lib_result['vat'] : $product_lib_result['vat_percentage']) / 100;
				$product['price_without_vat'] = ($product_lib_result['rate'] * 100) / (100 + (isset($product_lib_result['vat']) ? $product_lib_result['vat'] : $product_lib_result['vat_percentage']));
				$product['vat_amount'] = ($product_lib_result['rate'] - $product['price_without_vat']) * $product['quantity'];
				$vat_amount += $product['vat_amount'];
				if(isset($product['extratax']))
				{
					$vat_amount += $product['price_without_vat'] * ($product['extratax'] / 100);
				}
				//$product_lib_result['rate'] += $product['vat_amount'];
				$product_lib_result['final_amount'] = $product_lib_result['rate'] * $product['quantity'];
				$bill_final_amount += $product_lib_result['final_amount'];
				if(isset($product['extratax']))
				{
					$bill_final_amount += $product['price_without_vat'] * ($product['extratax'] / 100);
				}
				$product = array_merge($product, $product_lib_result);
				$products[] = $product;
				//log_message('error', 'IN BILLING::details' . print_r($product, 1));
			}
			$received_total_amount = $_REQUEST['total_bill_amount'];
			$payment = array();
			$new_payment = array();
			$status = 'unpaid';
			if ($bill == 1 || $estimate == 1) {
				log_message('error', 'TOTAL BILL BACKEND' . $bill_final_amount);
				log_message('error', 'TOTAL BILL Frontend' . $received_total_amount);
				//customer order redemption should be done here
				$payment = $this->process_payment($customer_id);
				$payment_cash = isset($payment['cash']['amount']) ? $payment['cash']['amount'] : 0;
				$payment_card = isset($payment['cards']['amount']) ? $payment['cards']['amount'] : 0;
				if (isset($_REQUEST['invoice_card_amt'])) {
					foreach ($_REQUEST['invoice_card_amt'] as $payment_card_local) {
						$payment_card += $payment_card_local;
					}
				}
				if (isset($_REQUEST['purchase_bill_id']) && $_REQUEST['purchase_bill_id'] > 0) {
					if (!$this->old_purchase_bill->redeemAmount(trim($_REQUEST['purchase_bill_id']), trim($_REQUEST['purchase_bill_amount']))) {
						redirect(site_url('/billing/print_invoice/failed'), 'refresh', 302);
					}
					$payment_old_bill = array('id' => $_REQUEST['purchase_bill_id'], 'amount' => $_REQUEST['purchase_bill_amount']);
				} else {
					$payment_old_bill = array('id' => 0, 'amount' => 0);
				}
				if (isset($payment['loyalty_points']['amount']) && $payment['loyalty_points']['amount'] > 0) {
					$payment_loyalty = $payment['loyalty_points']['amount'];
				} else {
					$payment_loyalty = 0;
				}
				$paid_amount = $payment_card + $payment_cash + $payment_loyalty + $payment_old_bill['amount'];
				$new_payment = $payment;
				$payment_scheme = 0;
				$payment = array('cash' => $payment_cash, 'card' => $payment_card, 'scheme' => $payment_scheme, 'loyalty' => $payment_loyalty,
					'purchase_bill_amt' => $payment_old_bill['amount'], 'order_advance' => 'not applied');
				if ($paid_amount - $bill_final_amount > -1) {
					$status = 'paid';
				} else {
					$status = 'unpaid';
				}
			}
			$bill_array = array('bill_id' => 0, 'customer' => $customer, 'bill_subtotal' => $bill_total_amount, 'bill_amount' => $bill_final_amount,
				'vat_amount' => $vat_amount, 'discount' => $discount_amount, 'products' => $products,
				'payment' => $payment, 'new_payment' => $new_payment, 'status' => $status);
			$bill_array['date'] = date('d-m-Y');
			//for bill this is happening - stock reduction
			if ($bill == 1) {
				$bill_id = $this->bill->create($this->user->getUserId(), $payment_cash, $payment_card, 0, $customer_id, 'percentage', $discount_amount, $vat_amount, $bill_total_amount, $bill_final_amount, $status, json_encode($bill_array));
				$item_entity_id = $this->item_entity->getEntityId('bill');
				$bill_barcode = $this->barcode->getBarcode($item_entity_id, $bill_id);
				foreach ($products as $product) {
					if (!isset($product['weight'])) {
						$product['weight'] = 0;
					}
					$this->bill->add_item($bill_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'],
						$product['price_initial'], $product['vat_amount'], $product['discount_amount'], $product['final_amount']);
					$add_inventory_response = $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, (-1) * $product['quantity'],
						(-1) * $product['weight'], 0, '', $this->user->loggedInUserId(), $bill_barcode);
					if (isset($add_inventory_response['status']) && !$add_inventory_response['status']) {
						$this->failInvoice(399, 'add item returned false');
						break;
					}
					$this->cart->emptyCartByCustomerId($customer_id);
					//$item_entity_id, $item_specific_id, $branch_id, $quantity, $weight, $force_new = 0, $additional = '', $user_id = 0, $reference_id = 0
				}
			} elseif ($estimate == 1) {
				//estimate code goes here
				$bill_id = $this->estimate->create($this->user->getUserId(), $payment_cash, $payment_card, 0, $customer_id, 'percentage', $discount_amount, $vat_amount, $bill_total_amount, $bill_final_amount, $status, json_encode($bill_array));
				$item_entity_id = $this->item_entity->getEntityId('estimate');
				$bill_barcode = $this->barcode->getBarcode($item_entity_id, $bill_id);
				foreach ($products as $product) {
					$product['weight'] = isset($product['weight']) ? $product['weight'] : 1;
					$this->estimate->add_item($bill_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'],
						$product['price_initial'], $product['vat_amount'], $product['discount_amount'], $product['rate']);
					/* $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, (-1) * $product['quantity'],
					(-1) * $product['weight'], 0, '', $this->user->loggedInUserId(), $bill_barcode);*/
				}
				if ($this->db->trans_status() === FALSE) {
					$p['success'] = false;
					$this->db->trans_rollback();
				} else {
					$p['success'] = true;
					$this->db->trans_commit();
				}
				redirect(site_url('/invoice/print_estimate/' . $bill_id), 'refresh', 302);
			} elseif ($cart == 1) {
				//cart code goes here
				//status is not being decided on yet
				$cart_id = $this->cart->create($this->user->getUserId(), $customer_id, $branch_id);
				$item_entity_id = $this->item_entity->getEntityId('cart');
				$bill_barcode = $this->barcode->getBarcode($item_entity_id, $cart_id);
				$items_added = array();
				foreach ($products as $product) {
					//$cart_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount
					$items_added[] = $this->cart->add_item($cart_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'],
						$product['price_initial'], $product['vat_amount'], $product['discount_amount'], $product['rate'], $this->user->getBranch());
					//TODO - Something to lock product sku here for some time
					//                $this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, (-1) * $product['quantity'],
					//                    (-1) * $product['weight'], 0, '', $this->user->loggedInUserId(), $bill_barcode);
				}
				if ($this->db->trans_status() === FALSE) {
					$p['status'] = 'error';
					$p['msg'] = 'There was some problem in saving the cart, please try again!';
					$this->db->trans_rollback();
				} else {
					$p['status'] = 'success';
					$p['msg'] = count($items_added) . ' item(s) successfully added to cart!';
					$this->db->trans_commit();
				}
				echo json_encode($p);
				return;
			} else {
				log_message('error', "INVALID REQUEST in invoice generate bill controller");
			}
			if ($this->db->trans_status() === FALSE) {
				$p['success'] = false;
				$this->db->trans_rollback();
			} else {
				$p['success'] = true;
				$this->db->trans_commit();
			}
			redirect(site_url('/invoice/print_invoice/' . $bill_id), 'refresh', 302);
		}

		public function print_invoice($invoice_id = '', $print = 0)
		{
			//debugbreak();
			if ($invoice_id == '') {
				$invoice_id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
			}
			//this function is to be used to display invoices/estimates
			$params = array();
			$params['tab'] = 'invoice';
			if ($invoice_id == 0 || $invoice_id == 'failed' || $invoice_id == '') {
				$params['status'] = False;
				$params['msg'] = 'Invoice generation failed.';
				$this->_my_output('print_invoice', $params);
				return;
			}
			$bill_full = $this->bill->getById($invoice_id);
			if (!$bill_full || is_null($bill_full) || !is_array($bill_full) || count($bill_full) < 1) {
				$params['status'] = False;
				$params['msg'] = 'No invoice was found associated with this ID';
				$this->_my_output('print_invoice', $params);
				return;
			}
			$p = json_decode($bill_full['full_json'], TRUE);
			//log_message('error', 'BILL_JSON'.print_r($p, 1));
			$p['bill_id'] = $invoice_id;
			$item_entity_id = $this->item_entity->getEntityId('bill');
			$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $invoice_id);
			$p['print'] = intval($print);
			//log_message('error', "print_invoice" . print_r($print, 1));
			$params = array('status' => True, 'output' => $p, 'tab' => 'new_invoice');
			if (!$print) {
				$this->_my_output('print_invoice', $params);
			} else {
				$this->load->view('header_print', array());
				$this->load->view('billing/print_invoice', $params);
				$this->load->view('footer_print', array());
			}
		}

		public function print_estimate($invoice_id, $print = 0)
		{
			//this function is to be used to display invoices/estimates
			$bill_full = $this->estimate->getById($invoice_id);
			$p = json_decode($bill_full['full_json'], TRUE);
			$p['bill_id'] = $invoice_id;
			// TODO - create real barcode tonight
			$p['print'] = intval($print);
			$item_entity_id = $this->item_entity->getEntityId('estimate');
			$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $invoice_id);
			$params = array('output' => $p, 'tab' => 'new_invoice');
			if (!$print) {
				$this->_my_output('print_estimate', $params);
			} else {
				$this->load->view('header_print', array());
				$this->load->view('invoice/print_estimate', $params);
				$this->load->view('footer_print', array());
			}
		}

		public function load_cart($customer_id = '', $cart_id = '')
		{
			if ($cart_id == '') {
				//load by customer_id
				$cart = $this->cart->getByCustomerId($customer_id);
				if (!$cart) {
					$p = array();
					echo json_encode($p);
					return;
				}
				foreach ($cart['items'] as &$item) {
					$product_lib_result = $this->productlib->getProductDetails($item['item_entity_id'], $item['item_specific_id']);
					$item = array_merge($item, $product_lib_result);
				}
			} else {
				//load by cart_id
				$cart = $this->cart->getById($cart_id);
				foreach ($cart['items'] as &$item) {
					$product_lib_result = $this->productlib->getProductDetails($item['item_entity_id'], $item['item_specific_id']);
					$item = array_merge($item, $product_lib_result);
				}
			}
			echo json_encode($cart);
		}

		public function save_to_cart($customer_id = '', $cart_id = '')
		{
		}

		/**
		*  Credit Note AJAX
		*/
		public function credit_note_ajax()
		{
			$id = $_REQUEST['id'];
			$details = $this->bill->getDetailsByCreditID($id);
			$p = array();
			if (is_array($details)) {
				$p['amount'] = $details['amount'];
				$p['customer_id'] = $details['customer_id'];
				$p['used'] = $details['used'];
			}
			$_SESSION[] = '';
			$this->_my_output('', $p);
		}

		/**
		* Exchange (Search and select the bill you want to exchange)
		*/
		public function exchange()
		{
			//debugbreak();
			$p = array();
			if ($this->user->isAccessAllowed('exchange') === FALSE) {
				$p['access'] = "Access Denied";
			}
			$p['tab'] = 'sales_return';
			$this->_my_output('exchange', $p);
		}

		/**
		* Exchange (Select bill items you want to exchange)
		*/
		public function exchange_bill()
		{
			// debugbreak();
			$p = array();
			$p['tab'] = 'sales_return';
			$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
			if ($bill_id <= 0) {
				redirect("/invoice/exchange");
				return false;
			}
			$p['bill'] = $this->bill->getById($bill_id);
			$date1 = date_create(date('Y-m-d H:i:s'));
			$date2 = date_create($p['bill']['created_at']);
			$interval = date_diff($date1 , $date2);
			if($interval->days < 20)
			{
				$p['bill_items'] = $this->bill->getItems($bill_id);
				$p['json'] = json_decode($p['bill']['full_json'], true);
				$p['products'] = $p['json']['products'];
				$p['customer'] = $p['json']['customer'];
				$p['bill']['full_json'] = '';
				$this->_my_output('exchange_bill', $p);
			}else{
				$p['bill_id'] = $bill_id;
				$p['status'] = -1;
				$p['msg']  = "The bill is older than 20 days and hence cannot be exchanged";
				$this->_my_output('exchange' , $p);
			}
		}

		/**
		*  Exchange - Refund Confirmation
		*/
		public function refund()
		{
			$p = array();
			$p['tab'] = 'exchange';
			$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
			if ($bill_id <= 0 || !isset($_REQUEST['item_id'])) {
				redirect("/invoice/exchange");
				return false;
			}
			$p['bill'] = $this->bill->getById($bill_id);
			$p['bill_items'] = $this->bill->getItems($bill_id);
			$p['json'] = json_decode($p['bill']['full_json'], true);
			$p['products'] = $p['json']['products'];
			$p['customer'] = $p['json']['customer'];
			$p['selected_products'] = array();
			foreach ($_REQUEST['item_id'] as $item_id) {
				if (!$_REQUEST['exchange_' . $item_id] || $_REQUEST['exchange_' . $item_id] != 'on') {
					break;
				}
				$item = array();
				$id_array = explode('_', $item_id);
				$item['item_entity_id'] = $id_array[0];
				$item['item_specific'] = $id_array[1];
				$item['bill_item_id'] = $_REQUEST['bill_item_id_' . $item_id];
				$item['quantity'] = $_REQUEST['quantity_' . $item_id];
				$p['selected_products']['bill_item_id'] = $item;
			}
			$total_credit_note = 0;
			/*        foreach ($p['selected_products'] as $selected_products) {
			$total_credit_note += $p['bill_items']['']
			}*/
			$p['bill']['full_json'] = '';
			$this->_my_output('exchange_review', $p);
		}

		/**
		* Exchange - Refund and update database
		*/
		public function confirm_refund()
		{
			$p = array();
			$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
			if ($bill_id <= 0) {
				redirect("/invoice/exchange");
				return false;
			}
			$this->db->trans_begin();
			$p = array();
			$p['tab'] = 'exchange';
			$p['bill'] = $this->bill->getById($bill_id);
			$p['bill_items'] = $this->bill->getItems($bill_id);
			$p['json'] = json_decode($p['bill']['full_json'], true);
			$p['products'] = $p['json']['products'];
			$p['customer'] = $p['json']['customer'];
			$p['selected_products'] = array();
			foreach ($_REQUEST['item_id'] as $item_id) {
				if (!isset($_REQUEST['exchange_' . $item_id]) || $_REQUEST['exchange_' . $item_id] != 'on') {
					continue;
				}
				$item = array();
				$id_array = explode('_', $item_id);
				$item['item_entity_id'] = $id_array[0];
				$item['item_specific_id'] = $id_array[1];
				$item['bill_item_id'] = $_REQUEST['bill_item_id_' . $item_id];
				$item['quantity'] = $_REQUEST['quantity_' . $item_id];
				$item['weight'] = isset($_REQUEST['weight_' . $item_id]) ? $_REQUEST['weight_' . $item_id] : 0;
				$item['price'] = isset($_REQUEST['price_' . $item_id]) ? $_REQUEST['price_' . $item_id] : 0;
				$item['name'] = isset($_REQUEST['name_' . $item_id]) ? $_REQUEST['name_' . $item_id] : 0;
				$item['discount'] = isset($_REQUEST['discount_' . $item_id]) ? $_REQUEST['discount_' . $item_id] : 0;
				$item['vat_percentage'] = isset($_REQUEST['vat_percentage_' . $item_id]) ? $_REQUEST['vat_percentage_' . $item_id] : 0;
				$p['selected_products'][$item['bill_item_id']] = $item;
			}
			unset($p['json']);
			$total_credit_note = 0;
			$credit_note_id = $this->bill->createCreditNote($bill_id, $this->user->getUserId(), 0, 0, mysql_real_escape_string(json_encode($p)));
			$item_entity_id = $this->item_entity->getEntityId('credit_note');
			$credit_note_barcode = $this->barcode->getBarcode($item_entity_id, $credit_note_id);
			foreach ($p['bill_items'] as $item) {
				//back end validation
				if (isset($item['id']) && isset($p['selected_products'][$item['id']])) {
					if ($p['selected_products'][$item['id']]['quantity'] > $item['quantity'] - $item['returned_qty']) {
						$this->db->trans_rollback();
						redirect('invoice/print_credit_note/0/0/quantity_excess');
					}
					$item_final_amount = ($item['final_amount'] / $item['quantity']) * $p['selected_products'][$item['id']]['quantity'];
					$p['selected_products'][$item['id']]['final_amount'] = $item_final_amount;
					$total_credit_note += $item_final_amount;
					if ($this->bill->addItemToCreditNote($credit_note_id, $item['item_entity_id'], $item['item_specific_id'], $p['selected_products'][$item['id']]['quantity'], $item['price'], $item['vat'], $item['discount'], $item_final_amount)) {
						$this->bill->updateItemCreditNote($bill_id, $item['id'], $p['selected_products'][$item['id']]['quantity']);
						$this->inventory->add($p['selected_products'][$item['id']]['item_entity_id'], $p['selected_products'][$item['id']]['item_specific_id'], $this->user->getBranch(), $p['selected_products'][$item['id']]['quantity'], $p['selected_products'][$item['id']]['weight'], 0, '', $this->user->getUserId(), $credit_note_barcode);
						}
				}
			}
			unset($p['bill']);
			unset($p['products']);
			$p['total_credit_note'] = $total_credit_note;
			$this->bill->finalizeCreditNote($credit_note_id, $total_credit_note, $this->user->getUserId(), json_encode($p));
			$p['bill']['full_json'] = '';
			if ($this->db->trans_status() === FALSE) {
				$p['success'] = false;
				$this->db->trans_rollback();
			} else {
				$p['success'] = true;
				$this->db->trans_commit();
			}
			redirect('invoice/print_credit_note/' . $credit_note_id . '/0');
		}

		/**
		* Exchange - Credit Note Status
		*/
		public function print_credit_note($credit_note_id, $print = 0)
		{
			//this function is to be used to display credit_notes
			$params = array();
			$params['tab'] = 'sales_return';
			if ($credit_note_id == 0 || $credit_note_id == 'failed') {
				$params['status'] = False;
				$params['msg'] = 'Credit Note generation failed.';
				$this->_my_output('print_credit_note', $params);
				return;
			}
			$bill_full = $this->bill->getCreditNote($credit_note_id);
			if (!$bill_full || is_null($bill_full) || !is_array($bill_full) || count($bill_full) < 1) {
				$params['status'] = False;
				$params['msg'] = 'No credit_note was found associated with this ID';
				$this->_my_output('print_credit_note', $params);
				return;
			}
			$p = json_decode($bill_full['full_json'], TRUE);
			//log_message('error', 'BILL_JSON'.print_r($p, 1));
			$p['credit_note_id'] = $credit_note_id;
			$p['date'] = $bill_full['created_at'];
			$item_entity_id = $this->item_entity->getEntityId('credit_note');
			$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $credit_note_id);
			$p['print'] = intval($print);
			//log_message('error', "print_credit_note" . print_r($print, 1));
			$params = array('status' => True, 'output' => $p, 'tab' => 'sales_return');
			if (!$print) {
				$this->_my_output('print_credit_note', $params);
			} else {
				$this->load->view('header_print', array());
				$this->load->view('billing/print_credit_note', $params);
				$this->load->view('footer_print', array());
			}
		}

		public function get_product()
		{
			$barcode = isset($_REQUEST['product_barcode']) ? $_REQUEST['product_barcode'] : '';
			if ($barcode == '') {
				$this->_my_output('', array());
				return;
			}
			$params = array();
			$p = $this->product->getProductByBarcode($_REQUEST['product_barcode']);
			if (isset($p) && is_array($p)) {
				$a = array();
				$a['id'] = $p['id'];
				$a['label'] = $p['name'];
				$a['value'] = $p['name'];
				$a['html'] = $this->load->view('invoice/suggest_product', $p, true);
				$params[] = $a;
			}
			$this->_my_output('', $params);
		}

		public function get_product_by_barcode($barcode, $html = 1)
		{
			$html = trim($html);
			$entity_array = $this->barcode->decomposeBarcode($barcode);
			//after creating proper barcode system, need to change this stuff TODO
			//$item_entity_id = substr($barcode, 0, 3);
			//$item_specific_id = substr($barcode, 3, 3);
			if (!$entity_array) {
				$params['status'] = False;
				$params['msg'] = 'No Product Found!';
				$this->_my_output('', $params);
				return;
			}
			$params['status'] = True;
			$o = array();
			$o = $this->productlib->getProductDetails($entity_array['item_entity_id'], $entity_array['item_specific_id']);
			if ($html == 1) {
				$params['output'] = $o;
				$params['html'] = $this->load->view('invoice/billing_ornament', $params, true);
				$this->_my_output('', $params);
				return;
			} else {
				echo json_encode($o);
			}
		}

		public function suggest()
		{
			// debugbreak();
			$html = isset($_REQUEST['html']) ? $_REQUEST['html'] : 0;
			$term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
			$from = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';
			if ($term == '') {
				$this->_my_output('', array());
				return;
			}
			if ($html == 0 || $from == '') {
				$params = array();
				$rs = $this->bill->suggest($term);
				if (is_array($rs) && count($rs) > 0) {
					foreach ($rs as $r) {
						$tmp = array();
						$tmp['id'] = $r['id'];
						$tmp['label'] = "Bill:" . $r['id'] . " | " . $r['c_name'] . ' ( ' . $r['c_phone'] . ' ) ';
						$tmp['value'] = $r['id'];
						$params[] = $tmp;
					}
				}
				$this->_my_output('', $params);
			} else {
				$html_data = '';
				$params = array();
				$rs = $this->bill->suggest($term);
				if (is_array($rs) && count($rs) > 0) {
					$html_data .= '<table class="table table-bordered table-striped">';
					$html_data .= '<tr><th>Id</th><th>Amount</th><th>Status</th><th width="50%">Customer Name</th><th>Phone</th><th colspan="2">Action</th></tr>';
					foreach ($rs as $r) {
						$html_data .= '<tr><td>' . $r['id'] . '</td><td class="text-right">' . $r['final_amount'] . '</td><td>' . $r['status'] . '</td><td>' . $r['c_name'] . '</td><td>' . $r['c_phone'] . '</td>';
						if ($from == "exchange") {
							$html_data .= '<td><a href="' . site_url('/invoice/exchange_bill?bill_id=' . $r['id']) . '" class="btn btn-danger action-btn">Exchange</a></td>';
						}
						$html_data .= '<td>';
						$html_data .= '&nbsp;&nbsp;<a href="' . site_url('/invoice/print_invoice/' . $r['id']) . '" class="btn btn-success action-btn"><i class=" icon-info-sign icon-white"></i></a>';
						$html_data .= '</td>';
						$html_data .= '</tr>';
					}
					$html_data .= '</table>';
				} else {
					$html_data .= 'No Records!';
				}
				echo $html_data;
			}
		}

		function invoice_reports($json = '', $date = '')
		{
			$from = !empty($_GET['from_date']) ? date("Y-m-d H:i:s",strtotime(trim($_GET['from_date']))) : '';
			$to = !empty($_GET['to_date']) ? date("Y-m-d H:i:s",strtotime(trim($_GET['to_date']))) : '';

			$barcode_config = $this->barcode->getConfiguration();
			$id = $barcode_config['id'];
			$item_specific_id_length = $barcode_config['item_specific_id_length'];
			$item_entity_id_length = $barcode_config['item_entity_id_length'];
			$item_entity_id = $this->item_entity->getEntityId('bill');
			$this->load->library('datagrid', array('db' => &$this->db));
			$fields = array("ID" => "b.id as id", "NAME" => "CONCAT(c.fname,' ' ,c.lname) AS name", "AMOUNT" => "b.final_amount AS Amount", "VAT" => "b.vat_amount as vat_amount",
				"BARCODE" => 'CONCAT("' . $id . '", RIGHT(CONCAT("000000", ' . $item_entity_id . ') , ' . $item_entity_id_length . '),RIGHT(CONCAT("0000000000000000", b.id) , ' . $item_specific_id_length . ')) as barcode', 'PAID AMOUNT' => ' b.paid_by_cash+b.paid_by_card+b.paid_by_scheme+b.paid_by_old_purchase_bill as total_paid', 'CASH' => 'b.paid_by_cash as cash', 'STATUS' => 'b.status as status');
			$table = " `bill` b, `customers` c ";
			$where = " WHERE b.customer_id = c.id";
			if(!empty($from))
			{
				$where.=" and b.created_at >= '".$from."'"; 
			}
			if(!empty($to))
			{
				$where.=" and b.created_at <= '".$to."'"; 
			}
			$actions = array(
				'<i class=" icon-info-sign icon-white"></i>' => array("url" => site_url('invoice/print_invoice?ajax=1'), "css" => "btn btn-primary fancybox action-btn")
			);
			$order_by = " ORDER BY b.id ASC";
			$config = array();
			$config['checkbox'] = 0;
			$config['count_distinct'] = '';
			$config['excel'] = 1;
			$p['from'] = $from;
			$p['to'] = $to;
			$p['grid'] = $this->datagrid->gridDisplay($fields, $table, $actions, $where, $order_by, 20, 1, $config);
			if( !isset($_GET['page']) &&   (isset($_GET['date'])))
			{
				echo $p['grid'];
			} else{
				$p['tab'] = 'new_invoice';
				$this->_my_output('invoice_reports', $p);
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

		public function _my_output($file = 'billing', $params = array())
		{
			if ($this->json == true) {
				//log_message('error', "bill params". print_r($params , 1));
				echo json_encode($params);
				//log_message('error', "COMING Bill");
				return;
			}
			$p = array();
			$p['output'] = $this->load->view('billing/' . $file, $params, true);
			$p['tab'] = isset($params['tab']) ? $params['tab'] : $file;
			$p['ajax'] = $this->ajax;
			$p['menu'] = $this->manageUsers->getUserMenu($p['tab']);
			if ($this->ajax === false) {
				$this->load->view('template', $p);
			} else {
				echo $p['output'];
			}
		}
	}
	/*END OF FILE*/