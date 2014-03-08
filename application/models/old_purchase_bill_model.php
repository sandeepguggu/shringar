<?php
/**
 * File Name: old_purchase_bill_model.php
 * Author: Rajat
 * Date: 3/27/12
 * Time: 7:37 PM
 */

/*Table: old_purchase_bill*/
/*----------------------------*/
/*
    Field        Type                 Collation          Null    Key     Default            Extra                        Privileges                       Comment
    -----------  -------------------  -----------------  ------  ------  -----------------  ---------------------------  -------------------------------  ---------
id           bigint(20) unsigned  (NULL)             NO      PRI     (NULL)             auto_increment               select,insert,update,references
created_at   timestamp            (NULL)             NO              CURRENT_TIMESTAMP  on update CURRENT_TIMESTAMP  select,insert,update,references
user_id      bigint(20)           (NULL)             NO              (NULL)                                          select,insert,update,references
customer_id  bigint(20)           (NULL)             NO              (NULL)                                          select,insert,update,references
status       varchar(20)          latin1_swedish_ci  YES             (NULL)                                          select,insert,update,references
amount       float                (NULL)             NO              (NULL)                                          select,insert,update,references
amount_due   float                (NULL)             YES             (NULL)                                          select,insert,update,references
full_json    longtext             latin1_swedish_ci  YES             (NULL)                                          select,insert,update,references           */

class Old_purchase_bill_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function create($user_id, $customer_id, $total_amount, $amount_due, $status, $full_json = ''){
        $sql = "insert into `old_purchase_bill` (`user_id`, `customer_id`, `amount`, `amount_due`, `status`, `full_json`)".
            " values (?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $customer_id, $total_amount, $amount_due, $status, $full_json));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function addItem($bill_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $final_amount){

        $sql = "insert into `old_purchase_bill_item`(`old_purchase_bill_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`, `rate`, `amount`) values (?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($bill_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $final_amount));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function getById($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `old_purchase_bill` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getItems($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `old_purchase_bill_item` where `old_purchase_bill_id` = ?", array($id));
        return $q->result_array();
    }

    public function getAmountById($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select `id` , `amount_due` from `old_purchase_bill` where `id` = ?", array($id));
        return $q->result_array();
        //return $a['amount_due'];
    }

    public function redeemAmount($id, $amount){
        if($id == '' || $amount == ''){
            return false;
        }
        $q = $this->db->query("UPDATE `old_purchase_bill` SET `amount_due` = (`amount_due` - ?) WHERE `id` = ?", array($amount, $id));
        if($this->db->affected_rows() > 0){
            return TRUE;
        }
        return false;
    }
    public function getByItemID($id) {
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `old_purchase_bill_item` where `id` = ?", array($id));
        return $q->row_array();
    }
    public function deleteById($id){
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if(isset($r['id'])){
            $q = $this->db->query("delete from `old_purchase_bill` where `id` = ?", array($r['id']));
            if($this->db->affected_rows() <= 0){
                return false;
            }
        }
        return $r;
    }

    public function getAll(){
        $q = $this->db->query("select * from `old_purchase_bill`");
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function suggest($term){
        if($term <= 0 || $term == ''){
            return false;
        }

        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `old_purchase_bill` b 
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

    public function createCreditNote($bill_id, $user_id, $amount=0, $parent_id=0) {

        $sql = "INSERT INTO credit_note (user_id, refund_bill_id, amount, parent_id)
                        VALUES ('{$user_id}', '{$bill_id}', '{$amount}', '{$parent_id}')";
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }

    }

    public function useCreditNote($id, $bill_id, $amount) {
        $sql = "UPDATE credit_note SET used='1', used_bill_id='{$bill_id}', used_amount='{$amount}'
                    WHERE id='{$id}'";
        $this->db->query($sql);
        if($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function updateItemCreditNote($bill_id, $item_id, $credit_note_id) {
        $sql = "UPDATE old_purchase_bill SET credit_note_id='{$credit_note_id}'
                    WHERE id='{$item_id}' AND bill_id='{$bill_id}'";
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
                    LEFT JOIN bill ON credit_note.refund_bill_id = bill.id
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