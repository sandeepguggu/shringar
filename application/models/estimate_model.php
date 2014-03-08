<?php
class Estimate_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function create($user_id, $paid_cash, $paid_card, $paid_scheme,$customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount, $status, $full_json){
        $sql = "insert into `estimate` (`user_id`, `paid_by_cash`, `paid_by_card`, `paid_by_scheme`, `customer_id`, `discount_type`, `discount_value`, `vat_amount`, `total_amount`, `final_amount`, `status`, `full_json`)".
            " values (?,?,?,?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $paid_cash, $paid_card, $paid_scheme, $customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount, $status, $full_json));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function add_item($estimate_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount){

        $sql = "insert into `estimate_items`(`estimate_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`, `price`, `vat`, `discount`, `final_amount`) values (?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($estimate_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function getById($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `estimate` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getItems($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `estimate_items` where `estimate_id` = ?", array($id));
        return $q->result_array();
    }

    public function getByItemID($id) {
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `estimate_items` where `id` = ?", array($id));
        return $q->row_array();
    }
    public function deleteById($id){
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if(isset($r['id'])){
            $q = $this->db->query("delete from `estimate` where `id` = ?", array($r['id']));
            if($this->db->affected_rows() <= 0){
                return false;
            }
        }
        return $r;
    }

    public function getAll(){
        $q = $this->db->query("select * from `estimate`");
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function suggest($term){
        if($term <= 0 || $term == ''){
            return false;
        }

        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `estimate` b 
			WHERE  
				`c`.`id` = `b`.`customer_id` 
			AND 
				(
				`c`.`fname` like '%".$term."%' 
				OR `b`.`id` like '%".$term."%' 
				OR `c`.`lname` like '%".$term."%' 
				OR `c`.`phone` like '%".$term."%'
				)
			";
        $q = $this->db->query($sql);
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function createCreditNote($estimate_id, $user_id, $amount=0, $parent_id=0) {

        $sql = "INSERT INTO credit_note (user_id, refund_estimate_id, amount, parent_id)
                        VALUES ('{$user_id}', '{$estimate_id}', '{$amount}', '{$parent_id}')";
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }

    }

    public function useCreditNote($id, $estimate_id, $amount) {
        $sql = "UPDATE credit_note SET used='1', used_estimate_id='{$estimate_id}', used_amount='{$amount}'
                    WHERE id='{$id}'";
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function updateItemCreditNote($estimate_id, $item_id, $credit_note_id) {
        $sql = "UPDATE estimate_items SET credit_note_id='{$credit_note_id}' 
                    WHERE id='{$item_id}' AND estimate_id='{$estimate_id}'";
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDetailsByCreditID($credit_note_id) {
        $sql = "SELECT * 
                    FROM  credit_note
                    LEFT JOIN estimate ON credit_note.refund_estimate_id = estimate.id
                    WHERE credit_note.id = '{$credit_note_id}'
                    LIMIT 0 , 30";
        $res = $this->db->query($sql);

        if($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }
}