<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Billing extends CI_Controller {

	function __construct() {
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
		$this->load->model('category_Model', 'category');
	}

	public function index() {
		$params = array('output' => print_r($_SESSION, true));

		
		$this->_my_output('index', $params);
	}

	public function search() {
		$this->_my_output('search');
	}

	/**
	 * Invoice - New Invoice
	 */
	public function invoice($credit_note_id = -1) {
		$p = array();
		$output = array();
		$output['entities'] = $this->item_entity->getAllItemEntities();
		// TODO - access control to be fixed properly
		if ($this->user->isAccessAllowed('invoice') === FALSE) {
			$p['access'] = "Access Denied";
		}
		$output['credit_note_id'] = $credit_note_id;
		if ($credit_note_id != -1) {
			$details = $this->bill->getDetailsByCreditID($credit_note_id);
			$c = json_decode($details['full_json'], true);
			$output['c'] = $c['c'];
		}
		$p['output'] = $output;
        $p['tab'] = 'invoice';
		$this->_my_output('invoice', $p);
	}

	public function get_bill_items_by_id($html = 1) {		        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';        
        if ($id == '') {
            return False;
        }       

        $result = $this->bill->getBillItemsByBillId($id);
        if ($html == 1) {
            $this->load->view('billing/view_bill_items', array('output' => $result));
        } else {
            echo json_encode($result);
        }	
	}

	public function get_bill_items_by_id2($html = 1) {		        
        $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';        
        if ($id == '') {
            return False;
        }       

        $result = $this->bill->getBillItemsByBillId2($id);
        if ($html == 1) {
            $this->load->view('billing/view_bill_items', array('output' => $result));
        } else {
            echo json_encode($result);
        }	
	}

	public function get_bill_items_info($html = 1) {
		$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';        
        if ($id == '') {
            return False;
        } 

         // get distinct vat_percentages as an array 
        $result = $this->category->getAllvatpercentages();
        $vat_percentages = array();
        foreach($result as $record) {
            array_push($vat_percentages, $record['vat_percentage']);
        }  

        $bill_items = $this->bill->getBillItemsInfo($id);

        foreach($bill_items as $i => $bill_item) {
            foreach($vat_percentages as $vat) {
            	if($bill_item['vat_percentage'] == $vat) {
            		$bill_item['gross sales @ '.$vat] = $bill_item['gross_sale'];
                	$bill_item['vat @ '.$vat] = $bill_item['vat'] ;            		
            	} else {
                	$bill_item['gross sales @ '.$vat] = 0.00;
                	$bill_item['vat @ '.$vat] = 0.00;   
            	}
            }    
           
            unset($bill_item['vat_percentage']);
            unset($bill_item['vat']);
            unset($bill_item['gross_sale']);
            $bill_items[$i] = $bill_item;                    
        } 
       
        if ($html == 1) {
            $this->load->view('billing/view_bill_items_info', array('output' => $bill_items, 'vat_percentages' => $vat_percentages));
        } else {
            echo json_encode($result);
        }
	}

	public function purchase_bill() {
		//this method is to create purchase bill for old ornaments
		$p = array();
		$output = array();
		$output['entities'] = $this->item_entity->getAllItemEntities();
		if ($this->user->isAccessAllowed('invoice') === FALSE) {
			$p['access'] = "Access Denied";
		}
		$old_items = $this->item_entity->getOldItemEntities();
		$output['entities'] = $old_items;
		$p['output'] = $output;
		$this->_my_output('old_purchase', $p);
	}

	public function review_purchase_bill() {
		//this function will receive the forma data from purchase bill, like ornament details etc..
		//this function will show the review screen
	}

	public function confirm_purchase_bill() {
		$old_bill = array();
		$old_bill['branch_id'] = 1;
		$old_bill['customer_id'] = $_REQUEST['customer-id'];
		$old_bill['customer'] = $this->customer->getById($old_bill['customer_id']);
		$old_bill['total'] = $_REQUEST['total_amount'];
		$old_bill['paid_amount'] = isset($_REQUEST['cash_paid']) ? $_REQUEST['cash_paid'] : 0;
		$old_bill['use_later'] = $_REQUEST['paid_amount'] == 'later' ? 1 : 0;
		$amount_due = $old_bill['total'] - $old_bill['paid_amount'];
		if ($amount_due != 0) {
			$old_bill['status'] = 'unpaid';
		} else {
			$old_bill['status'] = 'paid';
		}
		$old_bill['date'] = date('d-m-Y');
		$old_bill['items'] = array();
		foreach ($_REQUEST['item_id'] as $id) {
			$id_array = explode('_', $id);
			$item['item_entity_id'] = $id_array[0];
			$item['item_specific_id'] = $id_array[1];
			$item['net_weight'] = isset($_REQUEST['net_weight_' . $id]) ? $_REQUEST['net_weight_' . $id] : 1;
			$item['gross_weight'] = isset($_REQUEST['gross_weight_' . $id]) ? $_REQUEST['gross_weight_' . $id] : 1;
			$item['rate'] = $_REQUEST['rate_' . $id];
			$item['quantity'] = isset($_REQUEST['quantity_' . $id]) ? $_REQUEST['quantity_' . $id] : 1;
			$item['price'] = $item['rate'] * $item['net_weight'] * $item['quantity'];
			$item['fineness'] = isset($_REQUEST['fineness_' . $id]) ? $_REQUEST['fineness_' . $id] : 91;
			list($item_entity_array, $item_specific_array) = $this->item_entity->getItemSpecifics($item['item_entity_id'], $item['item_specific_id']);
			$this->inventory->add($item['item_entity_id'], $item['item_specific_id'], $old_bill['branch_id'], $item['quantity'], $item['net_weight'], '', '', $user_id = $this->user->loggedInUserId());
			$item = array_merge($item_specific_array, $item);
			$old_bill['items'][] = $item;
		}
		$old_bill['id'] = $this->old_purchase_bill->create($this->user->loggedInUserId(), $old_bill['customer_id'], $old_bill['total'], $amount_due, $old_bill['status'], json_encode($old_bill));
		foreach ($old_bill['items'] as $item) {
			$this->old_purchase_bill->addItem($old_bill['id'], $item['item_entity_id'], $item['item_specific_id'], $item['quantity'], $item['net_weight'], $item['rate'], $item['price']);
		}
		redirect(site_url('/billing/print_purchase_bill/' . $old_bill['id']), 'refresh', 302);
	}

	public function print_purchase_bill($purchase_bill_id, $print = 0) {
		$bill_full = $this->old_purchase_bill->getById($purchase_bill_id);
		$p = json_decode($bill_full['full_json'], TRUE);
		$p['bill_id'] = $purchase_bill_id;
		$p['amount_due'] = $bill_full['amount_due'];
		$p['print'] = intval($print);
		$item_entity_id = $this->item_entity->getEntityId('old_purchase_bill');
		$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $purchase_bill_id);

		$params = array('output' => $p, 'tab' => 'purchase_bill');
		if (!$print) {
			$this->_my_output('print_old_purchase', $params);
		} else {
			$this->load->view('header_print', array());
			$this->load->view('billing/print_old_purchase', $params);
			$this->load->view('footer_print', array());
		}
	}

	public function get_purchase_bill_amount($purchase_bill_barcode, $customer_id) {
		$id_array = $this->barcode->decomposeBarcode($purchase_bill_barcode);
		$amount_due = $this->old_purchase_bill->getAmountById($id_array['item_specific_id']);
		echo json_encode($amount_due);
	}

	public function estimate_bill() {
		// TODO - this function will generate exact bill copy/with estimate header
		$customer_id = $_REQUEST['customer-id'];
		$products = array();
		$vat_amount = 0;
		$bill_total_amount = 0;
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
			$bill_total_amount += $product_lib_result['rate'];
			$product = array_merge($product, $product_lib_result);
			$products[] = $product;

			log_message('error', 'IN BILLING::details' . print_r($product, 1));
		}
		$payment_cash = $_REQUEST['payment-cash'];
		$payment_card = $_REQUEST['payment-card'];
		$payment_scheme = 0;
		// TODO - get from scheme model and add the amount here
		$paid_amount = $payment_card + $payment_cash;

		if ($paid_amount >= $bill_total_amount) {
			$status = 'paid';
		} else {
			$status = 'unpaid';
		}
		$bill_array = array('bill_id' => 0, 'bill_amount' => $bill_total_amount, 'vat_amount' => $vat_amount, 'discount' => $discount_amount, 'products' => $products, 'status' => $status);
		$bill_array['date'] = date('d-m-Y');
		$this->db->trans_begin();
		$bill_id = $this->estimate->create($this->user->loggedInUserId(), $payment_cash, $payment_card, $payment_scheme, $customer_id, 'percentage', $discount_amount, $vat_amount, $bill_total_amount, $paid_amount, $status, json_encode($bill_array));
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

	public function customer_order() {
		//this function is index view of the customer order page
		$p = array();
		$output = array();
		$output['entities'] = $this->item_entity->getAllItemEntities();
		if ($this->user->isAccessAllowed('invoice') === FALSE) {
			$p['access'] = "Access Denied";
		}
		$p['output'] = $output;
		$this->_my_output('customer_order', $p);
	}

	public function order() {
		// TODO - this function to be used in new order , think same invoice can be used as order also
		log_message('error', 'Request to order function in billing::' . print_r($_REQUEST, 1));
		if (count($_REQUEST) == 0)
			redirect('customer_order');
		$customer_id = isset($_REQUEST['customer-id']) ? $_REQUEST['customer-id'] : '';
		$customer = $this->customer->getById($customer_id);
		$total_amount = 0;
		$total_vat = 0;
		$final_amount = 0;
		$products = array();
		foreach ($_REQUEST['item_id'] as $p) {
			$item_entity_id_array = explode('_', $p);
			//log_message('error', "in request thing::Item ID ARRAY::".print_r($item_entity_id_array, 1));
			//row count will be used in case of multiple ornaments of same header
			$row_count = isset($item_entity_id_array[2]) ? $item_entity_id_array[2] : '0';
			$item_entity_id_absolute = $item_entity_id_array[0];
			$id = $item_entity_id_array[1];
			$entity = $this->item_entity->getEntityById($item_entity_id_absolute);
			$name = $entity['name'];
			$tmp = $this->{$name}->getById($id);
			//$tmp['po_box'] = isset($_REQUEST['no_of_box_' . $p]) ? $_REQUEST['no_of_box_' . $p] : 1;
			$tmp['quantity'] = isset($_REQUEST['quantity_' . $p]) ? $_REQUEST['quantity_' . $p] : 1;
			$tmp['weight'] = isset($_REQUEST['weight_' . $p]) ? $_REQUEST['weight_' . $p] : 1;
			$tmp['item_entity_id'] = $item_entity_id_absolute;
			$tmp['item_specific_id'] = $id;
			$tmp['price'] = isset($_REQUEST['price_' . $p]) ? $_REQUEST['price_' . $p] : 0;
			if ($row_count > 0) {
				foreach ($_REQUEST['sub_item_id_' . $row_count] as $sub_item_id) {
					$sub_id_array = explode('_', $sub_item_id);
					$sub_item_entity_id = $sub_id_array[0];
					$sub_item_specific_id = $sub_id_array[1];
					$sub_item_quantity = isset($_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_quantity_' . $sub_item_id . '_' . $row_count] : 1;
					$sub_weight = isset($_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_weight_' . $sub_item_id . '_' . $row_count] : 0;
					$sub_rate = isset($_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count]) ? $_REQUEST['sub_rate_' . $sub_item_id . '_' . $row_count] : 0;
					$sub_price = $sub_weight * $sub_rate * $sub_item_quantity;
					$tmp['price']+= $sub_price;
					$sub_entity = $this->item_entity->getEntityById($sub_item_entity_id);
					$type = $sub_entity['display_name'];
					$sub_item_specific_details = $this->{$sub_entity['name']}->getById($sub_item_specific_id);
					$tmp['items'][] = array('sub_entity_id' => $sub_item_entity_id, 'sub_specific_id' => $sub_item_specific_id, 'type' => $type, 'name' => $sub_item_specific_details['name'],
						'row_count' => $row_count, 'sub_quantity' => $sub_item_quantity, 'sub_weight' => $sub_weight, 'sub_rate' => $sub_rate, 'sub_price' => $sub_price);
				}
			}
			$total_amount += $tmp['price'];
			$tmp['vat'] = isset($_REQUEST['vat_' . $p]) ? $_REQUEST['vat_' . $p] : 0;
			$tmp['vat_amount'] = ($tmp['price'] * $tmp['vat'] / 100);
			$total_vat += $tmp['vat_amount'];
			$tmp['final_price'] = $tmp['price'] + $tmp['vat_amount'];
			$final_amount += $tmp['final_price'];
			$products[$p] = $tmp;
		}

		$co_products = array();

		$params = array();
		$params['co'] = isset($_REQUEST['co']) ? $_REQUEST['co'] : '';
		$params['co_products'] = $co_products;
		$params['selected_products'] = $products;
		$params['customer'] = $customer;
		$params['co_date'] = isset($_REQUEST['co_date']) ? $_REQUEST['co_date'] : date('d-m-Y');
		$params['delivery_date'] = isset($_REQUEST['delivery_date']) ? $_REQUEST['delivery_date'] : '';
		$params['paid_cash'] = isset($_REQUEST['paid-cash']) ? $_REQUEST['paid-cash'] : 0;
		$params['paid_card'] = isset($_REQUEST['paid-card']) ? $_REQUEST['paid-card'] : 0;
		$params['card_digits'] = isset($_REQUEST['card-digits']) ? $_REQUEST['card-digits'] : 0000;
		$params['paid_scheme'] = isset($_REQUEST['paid-scheme']) ? $_REQUEST['paid-scheme'] : 0;
		$params['discount_type'] = isset($_REQUEST['discount-type']) ? $_REQUEST['discount-type'] : 0;
		$params['discount_value'] = isset($_REQUEST['discount-value']) ? $_REQUEST['discount-value'] : 0;
		//TODO calculate the discount amount depending on the discount type and value
		$params['discount_amount'] = 0;
		$params['vat_amount'] = $total_vat;
		$params['total_amount'] = $total_amount;
		$params['final_amount'] = $final_amount;
		$params['payment_terms'] = isset($_REQUEST['payment_terms']) ? $_REQUEST['payment_terms'] : '';
		$params['pay_on_date'] = isset($_REQUEST['pay_on_date']) ? $_REQUEST['pay_on_date'] : '';
		$params['branch_id'] = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();
		$params['paid_cash'] = $params['advance'] = isset($_REQUEST['customer_advance']) ? $_REQUEST['customer_advance'] : 0;
		$rate_type = 0;
		//TODO - rate type is to be modified here according to the request/amount ratio
		//rate type 0 means delivery date rate will be considered and this is an approximation
		if (isset($_REQUEST['rate_type']) && $_REQUEST['rate_type'] == 'now') {
			$rate_type = 1;
		}
		$params['rate_type'] = $rate_type;
		$co_id = $this->customer_order->create($this->user->loggedInUserId(), $params['delivery_date'], $params['paid_cash'], $params['paid_card'], $params['paid_scheme'], $rate_type, $customer_id, $params['discount_type'], $params['discount_value'], $params['vat_amount'], $params['total_amount'], $params['final_amount'], $params['branch_id'], 'unpaid', json_encode($params));

		foreach ($products as $product) {
			$this->customer_order->addItem($co_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'], $product['price'], $product['vat'], 0, $product['final_price']);
		}

		$pout = array();
		if ($this->db->trans_status() === FALSE) {
			$pout['output'] = "failed";
			$this->db->trans_rollback();
		} else {
			$pout['output'] = "success";
			$this->db->trans_commit();
		}
		//print_r($params);
		redirect('billing/print_order/' . $co_id);
	}

	public function print_order($id, $print = 0) {
		$bill_full = $this->customer_order->getById($id);
		$p = json_decode($bill_full['full_json'], TRUE);
		$p['order_id'] = $id;
		//$p['amount_due'] = $bill_full['amount_due'];
		$p['print'] = intval($print);
		$item_entity_id = $this->item_entity->getEntityId('customer_order');
		$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $id);

		$params = array('output' => $p, 'tab' => 'customer_order');
		if (!$print) {
			$this->_my_output('print_order', $params);
		} else {
			$this->load->view('header_print', array());
			$this->load->view('billing/print_order', $params);
			$this->load->view('footer_print', array());
		}
	}

	public function get_customer_order_advance($barcode) {
		$id_array = $this->barcode->decomposeBarcode($barcode);
		$amount_due = $this->customer_order->getAdvancePaid($id_array['item_specific_id']);
		echo json_encode($amount_due);
	}

	/**
	 * Invoice - Payment
	 */
	public function payment() {

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

	public function generate_bill($estimate = 0) {

		//log_message('error', "REQUEST to bill" . print_r($_REQUEST, 1));
		// customer details retrieval
		$invoice = array();
		$customer_id = $_REQUEST['customer-id'];
		$customer = $this->customer->getById($customer_id);
		$invoice['customer'] = $customer;
		$products = array();
		$vat_amount = 0;
		$bill_total_amount = 0;
		$discount_amount = 0;
		$branch_id = isset($_REQUEST['branch_id']) ? $_REQUEST['branch_id'] : $this->user->getBranch();

		$invoice['discount_percent'] = isset($_REQUEST['discount_percentage']) ? $_REQUEST['discount_percentage'] : 0;
		$payment_scheme = 0;
		// TODO - get from scheme model and add the amount here
		//TODO - most important to make everything here in transaction {MUST BE DONE}
		//Scheme application code goes here
		$scheme = array();
		//TODO initialize all the scheme array variables to zero here
		$scheme_user_id = isset($_REQUEST['scheme_user_id']) ? $_REQUEST['scheme_user_id'] : 0;
		if ($scheme_user_id != 0) {
			//scheme is applied
			$scheme = $this->scheme->getSchemesByCustomer($scheme_user_id);
			if ($scheme['scheme_status'] == 'matured' || $scheme['scheme_status'] == 1) {
				// scheme is matured
				if (trim($scheme['rate_adv']) == 'Yes' || $scheme['rate_adv'] == 1) {
					//Avg rate scheme applicablett
					if ($scheme['accumulated_quantity'] > 0) {
						$scheme['rate'] = $scheme['accumulated_amount'] / $scheme['accumulated_quantity'];
					} else {
						log_message('error', 'accumulated quantity is not greater than zero, though rate adv is one, CHECK!!');
					}

					if ($scheme['making_cost_disc']) {
						log_message('error', 'SCHEME With Making cost adv');
					}
				} else {
					//scheme doesn't have rate advantage
					//net_amount to be used in invoice
					log_message('error', 'SCHEME Without rate_adv');
				}
			} else {
				//scheme is not matured can not be used
				$scheme = array();
			}
		}
		//setting all scheme indices to 0 if they are not set in order to avoid warning
		if (!isset($scheme) || !is_array($scheme) || count($scheme) == 0) {
			$scheme['accumulated_quantity'] = 0;
		}
		if (!isset($scheme['rate_adv'])) {
			$scheme['rate_adv'] = 0;
		}
		if (!isset($scheme['net_amount'])) {
			$scheme['net_amount'] = 0;
		}
		//log_message('error', "SCHEME DETAILS in generate bill : " . print_r($scheme, 1));
		//scheme code ends here
		$scheme_metal_weight_remaining = $scheme['accumulated_quantity'];
		$required_scheme_weight = 0;
		$required_scheme_acc_amount = 0;
		$required_scheme_net_amount = 0;
		$required_scheme_vat_discount = 0;
		$required_scheme_value_addition = 0;

		$scheme['items'] = array();
		$scheme['redeemed_weight'] = 0;
		$this->db->trans_begin();
		foreach ($_REQUEST['item_id'] as $item_id) {
			$product_id_array = explode('_', $item_id);
			$product['item_entity_id'] = $product_id_array[0];
			$product['item_specific_id'] = $product_id_array[1];
			$product['row_count'] = $product_id_array[2];
			//$product['discount'] = isset($_REQUEST['discount_' . $item_id]) ? $_REQUEST['discount_' . $item_id] : 0;
			//for this moment, the discount is fixed for all the items in invoice so
			$product['discount'] = $invoice['discount_percent'];
			$product['quantity'] = isset($_REQUEST['quantity_' . $item_id]) ? $_REQUEST['quantity_' . $item_id] : 1;
			/*            foreach($_REQUEST['sub_item_id_'.$product['row_count']] as $sub_item_id){
			  $sub_id_array = explode('_', $sub_item_id);
			  $product['items'][] = array('item_entity_id' => $sub_id_array[0], 'item_specific_id' => $sub_id_array[1],
			  'rate' => $_REQUEST['sub_rate_'.$sub_id_array[0].'_'.$sub_id_array[1].'_'.$product['row_count']]);
			  } */
			//log_message('error', "product".print_r($product['rate'], 1));
			$product_lib_result = $this->productlib->getProductDetails($product['item_entity_id'], $product['item_specific_id']);
			log_message('error', 'IN BILLING::detalis_before edit' . print_r($product_lib_result, 1));
			//remove vat and making/wastage depending on scheme things
			$product['val_adn'] = 0;
			$scheme['val_adn'] = 0;
			$scheme_redeemed_weight = 0;
			//$product_lib_result['rate'] = $product_lib_result['rate'] + $product_lib_result['rate'] * ($product_lib_result['wastage_percent'] + $product_lib_result['making_cost_percent']) / 100;
			//log_message('error', "IETMS::". print_r($product_lib_result['items'], 1));
			if (isset($product_lib_result['items']) && is_array($product_lib_result['items']) && count($product_lib_result['items']) > 0) {
				foreach ($product_lib_result['items'] as &$item) {
					//Apply scheme here

					if (trim($scheme['rate_adv']) == 'Yes' && $scheme['rate_item_entity_id'] == $item['item_entity_id'] &&
							$scheme['rate_item_specific_id'] == $item['item_specific_id'] && $scheme_metal_weight_remaining > 0 && !isset($item['composite_id'])
					) {
						$scheme_sub_item = $item;
						$scheme_sub_item['composite_id'] = $item_id;
						//log_message('error','BILLING 526'. print_r($scheme_sub_item, 1));
						if ($item['weight'] - $scheme_metal_weight_remaining >= 0) {
							$scheme_sub_item['weight'] = $scheme_metal_weight_remaining;
							$item['weight'] -= $scheme_metal_weight_remaining;
							$scheme_redeemed_weight += $scheme_metal_weight_remaining;
							$required_scheme_weight += $scheme_metal_weight_remaining;
							$scheme_metal_weight_remaining = 0;
						} else {
							$scheme_metal_weight_remaining -= $item['weight'];
							$scheme_sub_item['weight'] = $item['weight'];
							$scheme_redeemed_weight += $item['weight'];
							$required_scheme_weight += $item['weight'];
							$item['weight'] = 0;
						}
						if ($scheme['making_cost_disc']) {
							if ($scheme['making_cost_disc_limit'] > $product_lib_result['making_cost_percent']) {
								$scheme_sub_item['making_cost_percent'] = 0;
							} else {
								$scheme_sub_item['making_cost_percent'] = $product_lib_result['making_cost_percent'] - $scheme['making_cost_disc_limit'];
							}
						}
						if ($scheme['wastage_cost_disc']) {
							if ($scheme['wastage_cost_disc_limit'] > $product_lib_result['wastage_percent']) {
								$scheme_sub_item['wastage_percent'] = 0;
							} else {
								$scheme_sub_item['wastage_percent'] = $product_lib_result['wastage_percent'] - $scheme['wastage_cost_disc_limit'];
							}
							//scheme_sub_item rate is not correct, we need to use scheme rate here, actually better to update scheme sub item rate as scheme rate
						   $scheme_sub_item['rate'] = $scheme['rate'];
							$scheme_sub_item['val_adn'] = $scheme_sub_item['weight'] * $scheme_sub_item['rate'] * ($scheme_sub_item['making_cost_percent'] + $scheme_sub_item['wastage_percent']) / 100;
							$scheme['val_adn'] += $scheme_sub_item['val_adn'];
							$required_scheme_value_addition += $scheme_sub_item['val_adn'];
							$scheme_sub_item['price'] = ($scheme_sub_item['weight'] * $scheme_sub_item['rate']) + $scheme_sub_item['val_adn'];

							//if scheme gives vat advantage
							if ($scheme['vat_discount']) {
								$scheme_sub_item['vat'] = $scheme_sub_item['price'] * $product_lib_result['vat']/100;
								$required_scheme_vat_discount += $scheme_sub_item['vat'];
							}
							//$scheme['items'][] = $scheme_sub_item;
							$product_lib_result['items'][] = $scheme_sub_item;
						}
					}

					if ($item['item_entity_id'] == 1 && !isset($item['composite_id'])) {
						$product['val_adn'] += ($item['rate'] * $item['weight'] * $item['quantity']) * (($product_lib_result['wastage_percent'] + $product_lib_result['making_cost_percent']) / 100);
						//log_message('error', 'value addition processing'.print_r($product['val_adn'], 1));
					}
				}
			}
			// TODO redeem $scheme_redeemed_weight from scheme here and put the if condition accordingly

			$product_lib_result['rate'] -= ($this->rate->getRate($scheme['rate_item_entity_id'], $scheme['rate_item_specific_id']) * $scheme_redeemed_weight);
			$product_lib_result['rate'] += $scheme_redeemed_weight * $scheme['rate'];
			$product['val_adn'] += $scheme['val_adn'];
			$product_lib_result['rate'] += $product['val_adn'];
			//log_message('error', 'IN BILLING::details_before edit-sftermcwc' . print_r($product_lib_result['rate'], 1));
			$product['price_initial'] = $product_lib_result['rate'];
			//deducting the amount of the metal that has been redeemed via scheme
			$product['discount_amount'] = $product_lib_result['rate'] * $product['discount'] / 100;
			$discount_amount += $product['discount_amount'];
			$product_lib_result['rate'] -= $product['discount_amount'];
			//log_message('error', 'IN BILLING::details_before edit-afterdiscount'.print_r($product_lib_result['rate'], 1));
			$product['vat_amount'] = $product_lib_result['rate'] * $product_lib_result['vat'] / 100;
			$vat_amount += $product['vat_amount'];


			if ($scheme['vat_discount']) {
				//this part is wrong, if scheme is already used and all
				//$vat_discount = $vat_amount;
			}


			$product_lib_result['rate'] += $product['vat_amount'];
			//vat discount subtract
			//$product_lib_result['rate'] += $vat_discount;
			$bill_total_amount += $product_lib_result['rate'];
			$product = array_merge($product, $product_lib_result);
			$products[] = $product;
			//log_message('error', 'IN BILLING::details' . print_r($product, 1));
		}

		$received_total_amount = $_REQUEST['total_bill_amount'];
		log_message('error', 'TOTAL BILL BACKEND' . $bill_total_amount);
		log_message('error', 'TOTAL BILL Frontend' . $received_total_amount);


		//redemption should be done here

		if (!$this->scheme->redeemQuantity($scheme_user_id, $required_scheme_weight)) {
			log_message('error', "Failed in billing 609::" . $scheme_user_id . '::' . $required_scheme_weight);
			redirect(site_url('/billing/print_invoice/failed'), 'refresh', 302);
		}
		//$required_scheme_acc_amount = $required_scheme_weight * $scheme['rate'];
		$required_scheme_net_amount = $scheme['net_amount'];
		if ($scheme['net_amount'] > 0) {
			//$scheme_redeemed_amount = $bill_total_amount - $paid_amount;
			//this redemption is not working properly
			if ($this->scheme->redeemAmount($scheme_user_id, $required_scheme_net_amount)) {
				$payment_scheme = $required_scheme_net_amount;
			}
		}

		//customer order redemption should be done here
		$payment_cash = $_REQUEST['payment-cash'];
		$payment_card = $_REQUEST['payment-card'];
		if (isset($_REQUEST['purchase_bill_id']) && $_REQUEST['purchase_bill_id'] > 0) {
			if (!$this->old_purchase_bill->redeemAmount(trim($_REQUEST['purchase_bill_id']), trim($_REQUEST['purchase_bill_amount']))) {
				redirect(site_url('/billing/print_invoice/failed'), 'refresh', 302);
			}
			$payment_old_bill = array('id' => $_REQUEST['purchase_bill_id'], 'amount' => $_REQUEST['purchase_bill_amount']);
		} else {
			$payment_old_bill = array('id' => 0, 'amount' => 0);
		}
		if (isset($_REQUEST['customer_loyalty_set']) && $_REQUEST['customer_loyalty_set'] > 0) {
			$payment_loyalty = $this->customer->redeemLoyaltyAmount($customer_id);
		} else {
			$payment_loyalty = 0;
		}
		// TODO : LATER STAGE :: create a function to redeem any amount of any entity from invoice / to use at a different rate
		$paid_amount = $payment_card + $payment_cash + $payment_loyalty + $payment_old_bill['amount'];
		$paid_amount += $payment_scheme;

		$payment = array('cash' => $payment_cash, 'card' => $payment_card, 'scheme' => $payment_scheme, 'loyalty' => $payment_loyalty,
						'purchase_bill_amt' => $payment_old_bill['amount'], 'order_advance' => 'not applied');
		if ($paid_amount >= $bill_total_amount) {
			$status = 'paid';
		} else {
			$status = 'unpaid';
		}
		$bill_array = array('bill_id' => 0, 'customer' => $customer, 'bill_amount' => $bill_total_amount,
			'vat_amount' => $vat_amount, 'vat_discount' => $required_scheme_vat_discount, 'discount' => $discount_amount, 'products' => $products,
			'payment' => $payment,
			'scheme' => $scheme, 'status' => $status);
		$bill_array['date'] = date('d-m-Y');
		//log_message('error', "IN BILLING - saved invoice". print_r($bill_array, 1));
		//$this->db->trans_begin();
		$bill_id = $this->bill->create($this->user->loggedInUserId(), $payment_cash, $payment_card, $payment_scheme, $customer_id, 'percentage', $discount_amount, $vat_amount, $bill_total_amount, $paid_amount, $status, json_encode($bill_array));
		$item_entity_id = $this->item_entity->getEntityId('bill');
		$bill_barcode= $this->barcode->getBarcode($item_entity_id, $bill_id);
		foreach ($products as $product) {
			$this->bill->add_item($bill_id, $product['item_entity_id'], $product['item_specific_id'], $product['quantity'], $product['weight'],
								$product['price_initial'], $product['vat_amount'], $product['discount_amount'], $product['rate']);
			$this->inventory->add($product['item_entity_id'], $product['item_specific_id'], $branch_id, (-1) * $product['quantity'],
								(-1) * $product['weight'], 0, '', $this->user->loggedInUserId(), $bill_barcode);
		}
		if ($this->db->trans_status() === FALSE) {
			$p['success'] = false;
			$this->db->trans_rollback();
		} else {
			$p['success'] = true;
			$this->db->trans_commit();
		}
		redirect(site_url('/billing/print_invoice/' . $bill_id), 'refresh', 302);
	}

	public function print_invoice($invoice_id, $print = 0) {
		//this function is to be used to display invoices/estimates
		$params = array();
		if ($invoice_id == 0) {
			$params['status'] = False;
			$params['msg'] = 'Invoice generation failed.';
			$this->_my_output('print_invoice', $params);
			return;
		}
		$bill_full = $this->bill->getById($invoice_id);
		$p = json_decode($bill_full['full_json'], TRUE);
		//log_message('error', 'BILL_JSON'.print_r($p, 1));
		$p['bill_id'] = $invoice_id;
		$item_entity_id = $this->item_entity->getEntityId('bill');
		$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $invoice_id);
		$p['print'] = intval($print);
		//log_message('error', "print_invoice" . print_r($print, 1));
		$params = array('status' => True, 'output' => $p, 'tab' => 'invoice');
		if (!$print) {
			$this->_my_output('print_invoice', $params);
		} else {
			$this->load->view('header_print', array());
			$this->load->view('billing/print_invoice', $params);
			$this->load->view('footer_print', array());
		}
	}

	public function print_estimate($invoice_id, $print = 0) {
		//this function is to be used to display invoices/estimates
		$bill_full = $this->estimate->getById($invoice_id);
		$p = json_decode($bill_full['full_json'], TRUE);
		$p['bill_id'] = $invoice_id;
		// TODO - create real barcode tonight
		$p['print'] = intval($print);
		$item_entity_id = $this->item_entity->getEntityId('estimate');
		$p['barcode'] = $this->barcode->getBarcode($item_entity_id, $invoice_id);

		$params = array('output' => $p, 'tab' => 'invoice');
		if (!$print) {
			$this->_my_output('print_estimate', $params);
		} else {
			$this->load->view('header_print', array());
			$this->load->view('billing/print_estimate', $params);
			$this->load->view('footer_print', array());
		}
	}

	public function bill_calculation() {
		//this function will be used to remove the duplicate code in bill and estimate things, rigth now I dont really have time
	}

	/**
	 *  Credit Note AJAX
	 */
	public function credit_note_ajax() {
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
	public function exchange() {
		$p = array();
		if ($this->user->isAccessAllowed('exchange') === FALSE) {
			$p['access'] = "Access Denied";
		}
		$this->_my_output('exchange', $p);
	}

	/**
	 * Exchange (Select bill items you want to exchange)
	 */
	public function exchange_bill() {

		$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
		if ($bill_id <= 0) {
			redirect("/billing/exchange");
			return false;
		}

		$bill = $this->bill->getById($bill_id);
		$bill_items = $this->bill->getItems($bill_id);

		$c = json_decode($bill['full_json'], true);
		$c = isset($c['c']) ? $c['c'] : $this->customer->getById($bill['customer_id']);

		$products = '';
		$product_total_amount = 0;

		if (is_array($bill_items)) {
			$i = 1;
			$print_status = FALSE;

			foreach ($bill_items as $item) {
				if ($item['credit_note_id'] == 0) {
					$products .= '<tr>
										<td><input type="checkbox" name="selected_items" value="' . $item['id'] . '" /></td>
										<td>' . $i++ . '</td>
										<td>' . $item['product_id'] . '</td>
										<td>' . $item['price'] . '</td>
										<td>' . $item['vat'] . '</td>
										<td>' . $item['final_amount'] . '</td>
									  </tr>';
					$product_total_amount += $item['final_amount'];
					$print_status = TRUE;
				}
			}
		}

		$p = array();
		$p['tab'] = "exchange";
		$p['products'] = $products;
		$p['c'] = $c;
		$p['invoice_date'] = $bill['created_at'];
		$p['paid_amount'] = $bill['final_amount'];
		$p['discount_option'] = $bill['discount_type'];
		$p['discount_value'] = $bill['discount_value'];
		$p['product_total_amount'] = $product_total_amount;
		$p['pay_amount'] = $bill['total_amount'];
		$p['print_status'] = $print_status;

		$this->_my_output('exchange_bill', $p);
	}

	/**
	 *  Exchange - Refund Confirmation
	 */
	public function refund() {

		$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
		if ($bill_id <= 0) {
			redirect("/billing/exchange");
			return false;
		}

		$bill = $this->bill->getById($bill_id);
		$c = json_decode($bill['full_json'], true);
		$c = isset($c['c']) ? $c['c'] : $this->customer->getById($bill['customer_id']);

		$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
		$items = explode(':', $items);

		$bill_items = $this->bill->getItems($bill_id);

		$products = '';
		$product_total_amount = 0;

		if (is_array($bill_items)) {
			$i = 1;
			foreach ($bill_items as $item) {
				if ($item['credit_note_id'] == 0) {
					if (in_array($item['id'], $items)) {
						$products .= '<tr class="exchange-item">';
					} else {
						$products .= '<tr>';
					}
					$products .= '<td>' . $i++ . '</td>
										<td>' . $item['product_id'] . '</td>
										<td>' . $item['price'] . '</td>
										<td>' . $item['vat'] . '</td>
										<td>' . $item['final_amount'] . '</td>
									</tr>';
					if (in_array($item['id'], $items)) {
						$product_total_amount += $item['final_amount'];
					}
				}
			}
		}

		$p = array();
		$p['tab'] = "exchange";
		$p['products'] = $products;
		$p['c'] = $c;
		$p['invoice_date'] = $bill['created_at'];
		$p['paid_amount'] = $bill['final_amount'];
		$p['discount_option'] = $bill['discount_type'];
		$p['discount_value'] = $bill['discount_value'];
		$p['product_total_amount'] = $product_total_amount;
		if ($bill['discount_type'] == 'amount') {
			$p['pay_amount'] = $product_total_amount - $product_total_amount * $bill['discount_value'] / $bill['total_amount'];
		} else {
			$p['pay_amount'] = $product_total_amount - ($product_total_amount * $bill['discount_value'] / 100);
		}

		$this->_my_output('refund_bill', $p);
	}

	/**
	 * Exchange - Refund and update database
	 */
	public function confirm_refund() {

		$p = array();
		$bill_id = isset($_REQUEST['bill_id']) ? $_REQUEST['bill_id'] : -1;
		if ($bill_id <= 0) {
			redirect("/billing/exchange");
			return false;
		}

		$this->db->trans_begin();

		$items = isset($_REQUEST['items']) ? $_REQUEST['items'] : '';
		$p['items'] = $items;
		$items = explode(':', $items);

		$product_total_amount = 0;
		foreach ($items as $itemID) {
			$item = $this->bill->getByItemID($itemID);
			if ($item['credit_note_id'] == 0) {
				$product_total_amount += $item['final_amount'];
			}
		}

		$bill = $this->bill->getById($bill_id);
		$bill_items = $this->bill->getItems($bill_id);

		$c = json_decode($bill['full_json'], true);
		$c = isset($c['c']) ? $c['c'] : $this->customer->getById($bill['customer_id']);

		if ($bill['discount_type'] == 'amount') {
			$amount = $product_total_amount - $product_total_amount * $bill['discount_value'] / $bill['total_amount'];
		} else {
			$amount = $product_total_amount - ($product_total_amount * $bill['discount_value'] / 100);
		}

		$credit_note_id = $this->bill->createCreditNote($bill_id, $this->user->loggedInUserId(), $amount);

		if ($credit_note_id > 0) {
			if (is_array($bill_items)) {
				foreach ($bill_items as $item) {
					if ($item['credit_note_id'] == 0) {
						if (in_array($item['id'], $items)) {
							$this->bill->updateItemCreditNote($bill_id, $item['id'], $credit_note_id);
							$sqlt = "insert into `product_transactions` (`product_id`,`qnt`,`type`,`ref_id`) values ('{$item['product_id']}', '1', 'exchange','{$item['id']}')";
							$this->db->query($sqlt);
						}
					}
				}
			}
		}

		if ($this->db->trans_status() === FALSE) {
			$p['success'] = false;
			$this->db->trans_rollback();
		} else {
			$p['success'] = true;
			$this->db->trans_commit();
		}

		redirect('billing/credit_note/' . $bill_id . '/' . $p['items'] . '/' . $credit_note_id . '/' . $p['success']);
	}

	/**
	 * Exchange - Credit Note Status
	 */
	public function credit_note($bill_id = -1, $items, $credit_id = -1, $success) {

		if ($bill_id <= 0 || $credit_id <= 0) {
			redirect("/billing/exchange");
			return false;
		}
		$p = array();
		$p['success'] = $success;
		if ($success == 0) {
			$this->_my_output('refund_print', $p);
			return false;
		}

		$bill = $this->bill->getById($bill_id);
		$bill_items = $this->bill->getItems($bill_id);

		$c = json_decode($bill['full_json'], true);
		$c = isset($c['c']) ? $c['c'] : $this->customer->getById($bill['customer_id']);

		$items = explode(':', $items);

		$bill_items = $this->bill->getItems($bill_id);

		$products = '';
		$product_total_amount = 0;

		if (is_array($bill_items)) {
			$i = 1;
			foreach ($bill_items as $item) {
				if ($item['credit_note_id'] == $credit_id) {
					$products .= '<tr>
										<td>' . $i++ . '</td>
										<td>' . $item['product_id'] . '</td>
										<td>' . $item['qnt'] . '</td>
										<td>' . $item['price'] . '</td>
										<td>' . $item['vat'] . '</td>
										<td>' . $item['final_amount'] . '</td>
									</tr>';
					//log_message('debug', $item['final_amount']);
					$product_total_amount += $item['final_amount'];
				}
			}
		}
		//log_message('debug', $product_total_amount);
		$p['tab'] = "exchange";
		$p['products'] = $products;
		$p['c'] = $c;
		$p['invoice_date'] = $bill['created_at'];
		$p['paid_amount'] = $bill['final_amount'];
		$p['discount_option'] = $bill['discount_type'];
		$p['discount_value'] = $bill['discount_value'];
		$p['product_total_amount'] = $product_total_amount;
		if ($bill['discount_type'] == 'amount') {
			$p['pay_amount'] = $product_total_amount - $product_total_amount * $bill['discount_value'] / $bill['total_amount'];
		} else {
			$p['pay_amount'] = $product_total_amount - ($product_total_amount * $bill['discount_value'] / 100);
		}

		$p['credit_note'] = $credit_id;
		$p['refund_amount'] = $p['pay_amount'];
		$p['status'] = 'Not Used';
		$p['bill_id'] = $bill_id;

		$this->_my_output('refund_print', $p);
	}

	public function suggest_product() {
		$term = isset($_REQUEST['term']) ? $_REQUEST['term'] : '';
		if ($term == '') {
			$this->_my_output('', array());
			return;
		}

		$params = array();
		$p = $this->product->suggest_products($_REQUEST['term']);
		if (isset($p) && is_array($p)) {
			foreach ($p as $v) {
				$a = array();
				$a['id'] = $v['id'];
				$a['label'] = $v['name'];
				$a['value'] = $v['name'];
				$a['html'] = $this->load->view('billing/suggest_product', $v, true);
				$params[] = $a;
			}
		}

		$this->_my_output('', $params);
	}

	public function suggest_old_products($item_entity_id) {
		$term = $_REQUEST['term'];
		if ($term != '') {
			$entity = $this->item_entity->getEntityById($item_entity_id);
			$name = $entity['name'];
			$p = $this->{$name}->suggestOldItem($_REQUEST['term']);
			$params = array();
			if (is_array($p) && count($p) > 0) {
				foreach ($p as &$v) {
					$v['item_entity_id'] = $item_entity_id;
					$v['html'] = $this->load->view('billing/op_' . $name, $v, true);
				}

				$params[] = $v;
			} else {
				$params[] = array('status' => 'false', 'msg' => 'no product found');
			}
		} else {
			$params[] = array('status' => 'false', 'msg' => 'Specify Term');
		}
		$this->_my_output('', $params);
	}

	public function get_product() {
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
			$a['html'] = $this->load->view('billing/suggest_product', $p, true);
			$params[] = $a;
		}

		$this->_my_output('', $params);
	}

	public function get_product_by_barcode($barcode) {
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

		$o = $this->productlib->getProductDetails($entity_array['item_entity_id'], $entity_array['item_specific_id']);
		$params['output'] = $o;
		$params['html'] = $this->load->view('billing/billing_ornament', $params, true);
		$this->_my_output('', $params);
	}

	public function suggest_invoice() {
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
				$html_data .= '<table class="zebra-striped invoice_list">';
				$html_data .= '<tr><th>Invoice Id</th><th>Amount</th><th>Status</th><th>Customer Name</th><th>Phone</th><th>Action</th></tr>';
				foreach ($rs as $r) {
					$html_data .= '<tr><td>' . $r['id'] . '</td><td>' . $r['final_amount'] . '</td><td>' . $r['status'] . '</td><td>' . $r['c_name'] . '</td><td>' . $r['c_phone'] . '</td>';
					$html_data .= '<td>';
					if ($from == "exchange") {
						$html_data .= '<a href="' . site_url('/billing/exchange_bill/?bill_id=' . $r['id']) . '" class="btn danger">Exchange</a>';
					}
					$html_data .= '&nbsp;&nbsp;<a href="#view" class="btn primary">View</a>';
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

	public function suggest_customer() {
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
				$tmp['html'] = $this->load->view('billing/suggest_customer', $r, true);
				$params[] = $tmp;
			}
		}
		$this->_my_output('', $params);
	}

	public function _my_output($file = 'billing', $params = array()) {
		if ($this->json == true) {
			//log_message('error', "bill params". print_r($params , 1));
			echo json_encode($params);
			//log_message('error', "COMING Bill");
			return;
		}

		if ($this->ajax === false) {
			//$p =array();
			//$p['header'] = $this->rate->getHeader();
			$this->load->view('header');
		}

		//$this->load->view('billing/'.$file, $params);
		$p = array();
		$p['tab'] = isset($params['tab']) ? $params['tab'] : $file;
		$p['ajax'] = $this->ajax;
		$p['output'] = $this->load->view('billing/' . $file, $params, true);
		$this->load->view('billing/index', $p);

		if ($this->ajax === false) {
			$this->load->view('footer');
		}
	}
  function invoice_report($json='', $date='')
  {
	//debugbreak();
	  if(!empty($date))
	  {
		 $repdate  = $this->split_date($date);
		 $data['report'] = $this->bill->invoiceReport($repdate); 
		 $p['html'] = $this->load->view("billing/invoice_report_view",$data,true);
		 echo json_encode($p['html']);
	  }
   else {
	 $p = array();
	 $this->_my_output('invoice_report', $p);
	}
  }
 function split_date($date)
	{
		$reportdate = explode("To",urldecode($date));
		if(!empty($reportdate[1])) { $frm = $reportdate[0]; $to = $reportdate[1];}
		else {$frm = $reportdate[0]; $to = date ('Y-m-d' , strtotime ( '+1 day' , strtotime ( $date ) )); }
		return array($frm,$to);
	}
}

?>