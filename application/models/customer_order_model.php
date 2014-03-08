<?php
class Customer_order_Model extends CI_Model{
    public function __construct(){
        $this->load->database();
    }

    public function create($user_id, $delivery_date, $paid_cash, $paid_card, $paid_scheme, $rate_type, $customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount,$branch_id ,$status, $full_json){
        $sql = "insert into `customer_order` (`user_id`, `delivery_date`,`paid_by_cash`, `paid_by_card`, `paid_by_scheme`, `rate_type`, `customer_id`, `discount_type`, ".
            "`discount_value`, `vat_amount`, `total_amount`, `final_amount`, `branch_id`,`status`, `full_json`)".
            " values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $delivery_date, $paid_cash, $paid_card, $paid_scheme, $rate_type, $customer_id, $discount_type, $discount_value, $vat_amount, $total_amount, $final_amount,$branch_id ,$status, $full_json));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function addItem($customer_order_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount){

        $sql = "insert into `customer_order_items`(`customer_order_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`, `price`, `vat`, `discount`, `final_amount`) values (?,?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($customer_order_id, $item_entity_id, $item_specific_id, $quantity, $weight, $price, $vat, $discount, $final_amount));
        if($this->db->affected_rows() > 0){
            return $this->db->insert_id();
        }
        return false;
    }

    public function getById($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `customer_order` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getItems($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `customer_order_items` where `customer_order_id` = ?", array($id));
        return $q->result_array();
    }

    public function getByItemID($id) {
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select * from `customer_order_items` where `id` = ?", array($id));
        return $q->row_array();
    }
    public function deleteById($id){
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if(isset($r['id'])){
            $q = $this->db->query("delete from `customer_order` where `id` = ?", array($r['id']));
            if($this->db->affected_rows() <= 0){
                return false;
            }
        }
        return $r;
    }

    public function getAll(){
        $q = $this->db->query("select * from `customer_order`");
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return false;
    }

    public function getAdvancePaid($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select `paid_by_cash`, `paid_by_scheme`, `paid_by_card` from `customer_order` where `id` = ?", array($id));
        $a  = $q->row_array();
        return $a['paid_by_cash']+ $a['paid_by_card'] + $a['paid_by_scheme'];
    }

    public function suggest($term){
        if($term <= 0 || $term == ''){
            return false;
        }

        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `customer_order` b
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
}
?>