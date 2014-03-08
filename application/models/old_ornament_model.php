<?php
class Old_ornament_model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
	/* mysql> desc old_ornament;
+-------------------+--------------+------+-----+---------+----------------+
| Field             | Type         | Null | Key | Default | Extra          |
+-------------------+--------------+------+-----+---------+----------------+
| id                | int(11)      | NO   | PRI | NULL    | auto_increment |
| name              | varchar(200) | NO   |     | NULL    |                |
| weight            | float        | NO   |     | NULL    |                |
| metal_id          | int(11)      | NO   |     | NULL    |                |
| deterioration_app | float        | NO   |     | NULL    |                |
| metal_wt          | float        | NO   |     | NULL    |                |
| stone_wt          | float        | NO   |     | NULL    |                |
| stone_cost        | float        | NO   |     | NULL    |                |
| stone_details     | varchar(200) | NO   |     | NULL    |                |
| deleted           | tinyint(4)   | NO   |     | 0       |                |
+-------------------+--------------+------+-----+---------+----------------+
	*/
	public function add($name, $weight, $metal_id, $deterioration_app, $metal_wt, $stone_wt, $stone_cost){
		if($name=='' || $metal_wt == '' || $metal_id == '' ){
			return false;
		}
		//barcode is to be added later
		/* 		if($barcode != '') {
			$q = $this->db->query("SELECT * FROM `old_ornament` WHERE `mfg_barcode` =  ?", array($barcode));
		if($q->num_rows() == 1) {
		$res = $q->row_array();
		if($res['deleted'] == '1') {
		$q = $this->db->query("UPDATE `old_ornament` SET `deleted` = '0', `name` = ?, `sell_price` = ?, `category_id` = ?, `brand_id` = ?, `mfg_barcode` = ? WHERE `id` = ?", array($name, $sell_price, $category_id, $brand_id, $barcode, $res['id']));
		if($this->db->affected_rows() > 0)
		return $res['id'];
		else
		return false;
		} else
		return false;
		}
		} */
		$this->db->trans_begin();
		$q = $this->db->query("insert into `old_ornament` (`name`, `weight`, `metal_id`,`deterioration_app`,`metal_wt`,`stone_wt`,`stone_cost`)".
						"values (?,?,?,?,?,?,?)",array($name, $weight, $metal_id, $deterioration_app, $metal_wt, $stone_wt, $stone_cost));
		$id = $this->db->insert_id();
		//barcode to be added later
		//$barcode = sprintf('%s%010s','4',$id);
		//$q = $this->db->query("UPDATE `old_ornament` SET `custom_barcode` = ? WHERE `id` = ? ", array($barcode, $id));

		if($this->db->affected_rows() <= 0) {
			$this->db->rollback();
			return false;
		}
		$this->db->trans_commit();
		return $id;
	}

	public function update($id, $weight, $name, $metal_id, $deterioration_app, $metal_wt, $stone_wt, $stone_cost){
		if($name=='' || $category_id == '' || $weight == '' || $metal_id == '' ){
			return false;
		}
		/* 		if($barcode != '') {
			$q = $this->db->query("SELECT * FROM `old_ornament` WHERE `mfg_barcode` =  ?", array($barcode));
		if($q->num_rows() == 1) {
		$res = $q->row_array();
		if($res['id'] != $id)
		return false;
		}
		} */
		$q = $this->db->query("update `old_ornament` set `name` = ?, `weight`=?, `metal_id` = ?, `deterioration_app`=?, `stone_wt` = ?, `stone_cost` = ?".
								" WHERE `id` = ? ",array($name, $weight, $metal_id, $deterioration_app, $metal_wt, $stone_wt, $stone_cost, $id));
		if($this->db->affected_rows() <= 0){
			return false;
		}
		return true;
	}

	public function suggest_old_ornament($term){
		if($term == ''){
			return false;
		}
		$sql = "select * where `name` like '%".($term)."%' AND p.`deleted` = '0'";

		$q = $this->db->query($sql);
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}

	/* 	public function getProductByBarcode($barcode) {
		if($barcode == '') {
	return false;
	}
	$bar = substr($barcode, 0, 11);
	log_message('debug','wnated - '.$bar);
	$sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `old_ornament` p, `category` c where p.category_id = c.id AND (p.`mfg_barcode` = '{$barcode}' OR p.`custom_barcode` = '{$bar}')";

	$q = $this->db->query($sql);
	if($q->num_rows() > 0) {
	return $q->row_array();
	}
	return false;
	}
	*/
	public function getById($id){
		if($id == ''){
			return false;
		}
		$q = $this->db->query("select * from `old_ornament` where `id` = ?", array($id));
		return $q->row_array();
	}

	public function deleteById($id){
		// Test of old_ornament, if no old_ornament then only allow deleting
		$r = $this->getById($id);
		if(isset($r['id'])){
			$q = $this->db->query("UPDATE `old_ornament` SET `deleted` = '1' where `id` = ?", array($r['id']));
			if($this->db->affected_rows() <= 0){
				return false;
			}
		}
		return $r;
	}
	public function suggestItem($term){
		if($term == ''){
			return false;
		}
		$sql = "select o.*,o.`name` as `value` from `old_ornament` o where o.`name` like '%".($term)."%' AND o.`deleted` = '0'";
	
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}

}