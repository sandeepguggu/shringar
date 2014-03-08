<?php
class Vendor_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	
	public function add_person($vendor_id, $name, $phone){
		if($vendor_id > 0){
			$sql = "insert into vendor_person(`vendor_id`, `contact_name`, `contact_phone`) values (?, ?, ?)";
			$this->db->query($sql, array($vendor_id, $name, $phone));	
			return $this->db->insert_id();
		}
		return false;
	}
	
	public function add($company_name,$main_person_name, $phone1, $address,$city, $pin, $phone2, $mobile, $comments, $user_id){
		if($company_name=='' || $user_id == ''){
			return false;
		}
                $q = $this->db->query("SELECT * FROM `vendors` WHERE `company_name` = ?", array($company_name));
                if($q->num_rows() == 1) {
                    $res = $q->row_array();
                    if($res['deleted'] == '1') {
                        $q = $this->db->query("UPDATE `vendors` 
                        SET 
                            `deleted` = '0',
                            `company_name` = ?,
                            `main_person_name` = ?,
                            `phone1` = ?,
                            `address` = ?,
                            `city` = ?,
                            `pin` = ?,
                            `phone2` = ?,
                            `mobile` = ?,
                            `comments` = ?
                        WHERE `id` = ?", array($company_name, $main_person_name, $phone1, $address, $city, $pin, $phone2, $mobile, $comments, $res['id']));
                        if($this->db->affected_rows() > 0)
                            return $res['id'];
                        else
                            return false;
                    } else
                        return false;
                }
		$q = $this->db->query("insert into `vendors` (`company_name`,`main_person_name`,`phone1`,`address`,`city`,`pin`,`phone2`,`mobile`,`comments`,`user_id`) values (?,?,?,?,?,?,?,?,?,?)",array($company_name,$main_person_name, $phone1, $address,$city, $pin, $phone2, $mobile, $comments, $user_id));
		return $this->db->insert_id();
	}
	
	public function update($id, $company_name,$main_person_name, $phone1, $address,$city, $pin, $phone2, $mobile, $comments){
		if($id=='' || $company_name==''){
			return false;
		}
                $q = $this->db->query("SELECT * FROM `vendors` WHERE `company_name` = ?", array($company_name));
                if($q->num_rows() == 1) {
                    $res = $q->row_array();
                    if($id != $res['id'])
                        return false;
                }
		$q = $this->db->query("update `vendors` 
		set 
			`company_name` = ?,
			`main_person_name` = ?,
			`phone1` = ?,
			`address` = ?,
			`city` = ?,
			`pin` = ?,
			`phone2` = ?,
			`mobile` = ?,
			`comments` = ?
		 WHERE `id` = ? ",array($company_name, $main_person_name, $phone1, $address, $city, $pin, $phone2, $mobile, $comments, $id));
		if($this->db->affected_rows() <= 0){
			return false;
		}
		return true;
	}
	
	public function getById($id){
		if($id == ''){
			return false;
		}
		$q = $this->db->query("select * from `vendors` where `id` = ?", array($id));
		return $q->row_array();
	}
	
	public function suggest_person($term, $vendor_id){
		if($term == '' || $vendor_id <= 0){
			return false;
		}
		$sql = "select * from `vendor_person` where `vendor_id` = ? AND `contact_name` like '%".$term."%' OR `contact_phone` like '%".$term."%'";
		$q = $this->db->query($sql, array($vendor_id));
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
	
	public function suggest_vendors($term){
		if($term == ''){
			return false;
		}
		$sql = "select *,`company_name` as `value` from `vendors` where `company_name` like '%".($term)."%'";
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
	
	public function deleteById($id){
		// Test of products, if no products then only allow deleting
		$r = $this->getById($id);
		if(isset($r['id'])){
			$q = $this->db->query("UPDATE `vendors` SET `deleted` = '1' where `id` = ?", array($r['id']));
			if($this->db->affected_rows() <= 0){
				return false;
			}
		}
		return $r;
	}
	
	public function getAll(){
		$q = $this->db->query("select * from `vendors`");
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}
}