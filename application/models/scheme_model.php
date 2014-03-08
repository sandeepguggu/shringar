<?php

/**
 * Description of scheme_model
 *
 * @author Sandeep
 */
class Scheme_Model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('scheme_invoice', 'si');
		$this->load->model('customer_model');
		$this->load->model('item_entity_model', 'item_entity');
	}

	function getschemes_dropdown($id = '') {
		$this->db->select("*");
		if (!empty($id)) {
			$where = "id ='" . $id . "'";
			$this->db->where($where);
			$data = $this->db->get("scheme")->row_array();
		} else {
			$data = $this->db->get("scheme")->result_array();
		}
		return $data;
	}

	public function add($data) {
		$p = array();
		$res = $this->db->query("select * from scheme where name=?", $data['name']);
		if ($res->num_rows() > 0) {
			$p['status'] = false;
			$p['msg'] = 'Duplicate Scheme Name';
			return $p;
		}
		$scheme = array(
			"name" => $data['name'], "min_installment" => $data['min_installment'], "terms" => $data['terms'],
			"duration_months" => $data['duration_months'], "adv_type" => $data['adv_type'], "flexible" => $data['flexible'], "bonus_installments" => $data['bonus_installments'],
			"making_cost_disc" => $data['making_cost_disc'], "making_cost_disc_limit" => $data['making_cost_disc_limit'], "wastage_cost_disc" => $data['wastage_cost_disc'],
			"wastage_cost_disc_limit" => $data['wastage_cost_disc_limit'], "vat_discount" => $data['vat_discount'], "vat_discount_limit" => $data['vat_discount_limit'],
			"referal_bonus_percent" => $data['referal_bonus_percent'], "Comments" => $data['Comments'], "rate_adv" => $data['rate_adv'],
		);
		if (!empty($data['item_type']) && !empty($data['item_name'])) {
			$scheme['rate_item_entity_id'] = $data['item_type'];
			$scheme['rate_item_specific_id'] = $data['item_name'];
		}
		$this->db->insert('scheme', $scheme);
		if ($this->db->affected_rows() <= 0) {
			$p['staus'] = FALSE;
			$p['msg'] = 'Error in Databse Operation';
			return $p;
		}
		$p['status'] = true;
		$p['msg'] = 'Scheme is successfully added to Database';
		return $p;
	}

	public function edit($id, $name, $min_installment, $terms, $duration_months, $advantage_type, $flexible, $bonus_installments, $making_cost_disc, $making_cost_disc_limit, $wastage_cost_disc, $wastage_cost_limit, $vat_discount, $vat_discount_limit, $comments) {
		$p = array();
		$sql = "SELECET * FROM `scheme` WHERE `name`=? AND `id` != ?";
		$res = $this->db->query($sql, array($name, $id));
		if ($res->num_rows() > 0) {
			$p['status'] = false;
			$p['msg'] = 'The Scheme name you entered is already in the database';
			return $p;
		}

		$sql = "UPDATE `scheme` SET `name`=?, `min_installment`=?, `terms`=?, `duration_months`=?, `adv_type`=?, `flexible`=?, `bonus_installments`=?, `making_cost_disc`=?, `making_cost_disc_limit`=?, `wastage_cost_disc`=?, `wastage_cost_disc_limit`=?, `vat_disc`=?, `vat_discount_limit`=?, `comments`=? WHERE `id`=?";
		$this->db->query($sql, array($name, $min_installment, $terms, $duration_months, $advantage_type, $flexible, $bonus_installments, $making_cost_disc, $making_cost_disc_limit, $wastage_cost_disc, $wastage_cost_limit, $vat_discount, $vat_discount_limit, $comments, $id));
		$p['status'] = true;
		$p['msg'] = 'Changes in Scheme saved Successfully';
		return $p;
	}

	public function subscribe($data) {
		// debugbreak();
		$schemedata = array(
			"customer_id" => $data['customer-id'],
			"scheme_id" => $data['scheme_id'],
			"start_date" => date("Y-m-d"),
			"start_amount" => $data['start_amount'],
			"last_paid_date" => date("Y-m-d"),
			"next_payment_date" => date('Y-m-d', strtotime("+30 days")),
			"installments_paid" => 1,
			"paid_amount" => $data['first_instmt'],
			"accumulated_amount" => $data['first_instmt'],
			"updated_at" => date("Y-m-d"),
			"status" => "active",
			"net_amount" => $data['first_instmt'],
		);
		if (!empty($data['referal_id'])) {
			$refered = array(
				"customer_id" => $data['referal_id'],
				"amount" => ($data['referal_percent'] * $data['first_instmt']) / 100,
			);
			$this->db->insert('scheme_referal', $refered);
			$id = $this->db->insert_id();
			$schemedata["scheme_referal_id"] = $id;
		}
		if (!empty($data['per_gram_rate'])) {
			$schemedata['accumulated_quantity'] = round($schemedata['paid_amount'] / $data['per_gram_rate'], 2);
			$schemedata['net_amount'] = 0;
		}
		$this->db->insert('scheme_user', $schemedata);
		$scheme_user_id = $this->db->insert_id();
		$customerdata = $this->customer_model->getById($data['customer-id']);
		$scheme = $this->db->query("Select name from scheme where id = ?", $data['scheme_id'])->row_array();
		$receipt = array("customer_id" => $data['customer-id'],
			"name" => $customerdata['fname'] . " " . $customerdata['lname'],
			"scheme" => $scheme['name'],
			"amt_paid" => $data['first_instmt'],
			"due_date" => $schemedata['next_payment_date'],
			"total" => $data['first_instmt'],
			"installment" => $schemedata['installments_paid'],
			"scheme_user_id" => $scheme_user_id,
		);
		// debugbreak();
		$this->si->submitTransaction($scheme_user_id, array("amt_cash" => $data['first_instmt']), $data['customer-id'], $schemedata['installments_paid'], $data['first_instmt']);
		return $receipt;
	}

	public function get_enrolled_customers($id) {
		$sql = "SELECT a.id,a.customer_id,b.duration_months,b.referal_bonus_percent,c.fname, c.lname, b.name, a.start_date, a.start_amount, a.last_paid_date, a.installments_paid, a.next_payment_date, a.paid_amount, a.accumulated_amount, a.updated_at, a.status
			  FROM scheme_user a
			  LEFT JOIN scheme b ON a.scheme_id = b.id
			  LEFT JOIN customers c ON c.id = a.customer_id
			  WHERE a.scheme_id =?";
		$data = $this->db->query($sql, $id)->result_array();
		return $data;
	}

	public function getById($id) {
		$data = $this->db->query("SELECT a.id,a.customer_id,a.accumulated_quantity,b.duration_months,b.rate_adv,b.rate_item_entity_id,b.rate_item_specific_id,b.min_installment," .
						"b.terms,c.fname, c.lname, b.name,a.start_date,a.start_amount, a.last_paid_date, a.installments_paid, a.next_payment_date, a.paid_amount, a.accumulated_amount, a.updated_at, a.status
			  FROM scheme_user a
			  LEFT JOIN scheme b ON a.scheme_id = b.id
			  LEFT JOIN customers c ON c.id = a.customer_id
			  WHERE a.id =?", $id)->row_array();
		return $data;
	}

	public function getAmountRedeemable($customer_id) {
		$status = "matured";
		$result = $this->db->query("SELECT a.accumulated_amount,a.accumulated_quantity,b.rate_adv,b.rate_item_entity_id,b.rate_item_specific_id from scheme_users a INNER JOIN scheme b on a.scheme_id = b.id where a.customer_id=? ", $status);
		if ($result->num_rows() > 0) {
			$data = $result->row_array();
		} else {
			$data['msg'] = "No Records Found";
		}
		return $data;
	}

	public function getSchemesByCustomer($scheme_id = '', $customer_id = '') {
		// $data['status'] = true;
		$where = '';
		if (!empty($customer_id)) {
			$where = "u.customer_id =" . $customer_id;
			if (!empty($scheme_id)) {
				$where .= " and ";
			}
		}
		if (!empty($scheme_id)) {
			$where .= "u.id =" . $scheme_id;
		}
		$this->db->select("u.id as scheme_user_id, u.scheme_id, s.*, u.accumulated_amount,u.accumulated_quantity, u.net_amount, u.status as scheme_status");
		$this->db->join("scheme s", "s.id = u.scheme_id", "left");
		if (!empty($where)) {
			$this->db->where($where);
		}
		$result = $this->db->get("scheme_user u");
		if (!empty($scheme_id)) {
			$data = $result->row_array();
			$data['status'] = true;
		}
		if (!empty($customer_id) && empty($scheme_id)) {
			$data = $result->result_array();
			$data['status'] = true;
		}
		if ($result->num_rows() < 1) {
			$data['status'] = "false";
			$data['msg'] = "Invalid Scheme Id";
		}
		return $data;
	}

	public function getPaymentDue($customer_id) {
		//this function will return the payment due date and amount in an associative array as {'amount'=> 2000, 'date' => '24/12/2012'}
	}

	public function redeemAmount($scheme_user_id, $amount) {
		//debugbreak();
		if ($amount == 0) {
			return True;
		}
		//this function will be used to redeem amount and will return true/scheme_id if success and false on failure
		//this should reduce the net_amount
		$status = $this->db->query("update scheme_user set net_amount = net_amount - ? where net_amount >= ? and id = ?", array($amount, $amount, $scheme_user_id));
		return $status;
	}

	public function redeemQuantity($scheme_user_id, $quantity) {
		//debugbreak();
		if ($quantity == 0) {
			return True;
		}
		//this function will be used to redeem quantity from schemes, this has to reduce accumulated_amount and quantity both
		$data = $this->db->query("select accumulated_amount,accumulated_quantity from scheme_user where id=? ", array($scheme_user_id))->row_array();

		if (!is_array($data) || count($data) < 1) {
			log_message('error', "IN SCHEME MODEL IF condition:LN::208" . print_r($data, 1));
			return False;
		}
		if (!isset($data['accumulated_quantity']) || $data['accumulated_quantity'] == 0) {
			log_message('error', "IN SCHEME MODEL IF condition:::212" . print_r($data, 1));
			return False;
		}
		$price_per_gram = $data['accumulated_amount'] / $data['accumulated_quantity'];
		$reducable_amt = $price_per_gram * $quantity;
		$status = $this->db->query("update scheme_user set accumulated_quantity = accumulated_quantity - ?, accumulated_amount = accumulated_amount - ?  where id =?", array($quantity, $reducable_amt, $scheme_user_id));
		return $status;
	}

	public function submitPayment($scheme_user_id, $last_paid_date, $installments_paid, $next_payment_date, $paid_amount, $terms, $formdata, $per_gram_rate, $accumulated_quantity, $total_installments)    {
		//debugbreak();
		$totalamt = $formdata['amt_cash'] + $formdata['amt_card'];
		$cardno = (!empty($formdata['card_no'])) ? $formdata['card_no'] : 0;
		$data = array(
			"installments_paid" => $installments_paid + 1,
			"paid_amount" => $paid_amount + $totalamt,
			"accumulated_amount" => $paid_amount + $totalamt,
			"net_amount" => $paid_amount + $totalamt,
			"last_paid_date" => date("Y-m-d"),
			"updated_at" => date("Y-m-d")
		);
		if (!empty($per_gram_rate)) {
			$data['accumulated_quantity'] = $accumulated_quantity + round(($totalamt / $per_gram_rate), 2);
			$data['net_amount'] = 0;
		}
		if ($installments_paid + 1 >= $total_installments) {

			$data['status'] = "matured";
		} else {
			$data['status'] = "active";
			$data['next_payment_date'] = date('Y-m-d', strtotime("+30 days"));
		}
		$this->db->where('id', $scheme_user_id);
		$this->db->update('scheme_user', $data);
		return $data['paid_amount'];
		// $this->db->query("UPDATE scheme_user set next_payment_date=DATE_ADD('" . $data['last_paid_date'] . "',INTERVAL " . $terms . " MONTH) where id=?", $scheme_user_id);
	}

	public function getReport($date,$num='',$offset='') {
		if (!empty($date)) {
			$where = "c.updated_at >='".$date[0]."' and c.updated_at <'".$date[1]."'";
		}
		$this->db->select("a.scheme_user_id,a.amount,a.by_cash,a.by_card,a.card_last_digits,b.name as scheme_name,c.customer_id,c.scheme_id,c.last_paid_date,a.installment_number,c.next_payment_date,a.paid_amount,d.fname,d.lname");
		$this->db->join("scheme_user c", "c.id=a.scheme_user_id", "LEFT");
		$this->db->join("scheme b", "b.id=c.scheme_id", "LEFT");
		$this->db->join("customers d", "d.id=c.customer_id", "LEFT");
		$this->db->where($where);
	if(!empty($num))	$this->db->limit($num,$offset);
		$data = $this->db->get("scheme_transaction a")->result_array();
		// $test = $data->result_array();
		return $data;
	}
 public function getReceiptData($scheme_user_id)
 {
	 $data = $this->db->query("select a.name as scheme_name,b.fname,b.lname,c.* from scheme_user c LEFT JOIN scheme a on c.scheme_id = a.id LEFT JOIN customers b on b.id = c.customer_id where c.id=?",$scheme_user_id)->row_array();
	return $data; 
	 
 }
}

?>
