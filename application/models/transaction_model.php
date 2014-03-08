<?php


class Transaction_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}


	public function getById($id){
		if($id == ''){
			return false;
		}
		$q = $this->db->query("select central_stock_id, item_specific_id as id from `transaction` t, `central_stock` c  where t.id = ? and central_stock_id = c.id", array($id));
		return $q->row_array();
	}

}