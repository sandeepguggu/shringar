<?php
class Ornament_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}
/* mysql> desc ornament;
+---------------------+--------------+------+-----+---------+----------------+
| Field               | Type         | Null | Key | Default | Extra          |
+---------------------+--------------+------+-----+---------+----------------+
| id                  | int(11)      | NO   | PRI | NULL    | auto_increment |
| name                | varchar(100) | NO   |     | NULL    |                |
| category_id         | int(11)      | NO   |     | NULL    |                |
| weight              | float        | NO   |     | NULL    |                |
| metal_id            | int(11)      | NO   |     | NULL    |                |
| metal_wt            | float        | NO   |     | NULL    |                |
| stone_wt            | float        | NO   |     | NULL    |                |
| stone_details       | varchar(400) | YES  |     | NULL    |                |
| stone_cost          | varchar(50)  | YES  |     | NULL    |                |
| making_cost_percent | float        | YES  |     | NULL    |                |
| making_cost_fixed   | float        | YES  |     | NULL    |                |
| wastage_percent     | float        | YES  |     | NULL    |                |
| wastage_cost_fixed  | float        | YES  |     | NULL    |                |
| comments            | text         | YES  |     | NULL    |                |
| deleted             | tinyint(4)   | NO   |     | 0       |                |
+---------------------+--------------+------+-----+---------+----------------+
 */
	public function add($name, $category_id, $weight, $metal_id, $metal_wt, $stone_wt, $stone_cost, $making_cost_percent, $making_cost_fixed, $wastage_percent, $wastage_cost_fixed, $comments='', $barcode=''){
		if($name=='' || $category_id == '' || $weight == '' || $metal_id == '' ){
			return false;
		}
		//barcode is to be added later
		/* 		if($barcode != '') {
			$q = $this->db->query("SELECT * FROM `ornament` WHERE `mfg_barcode` =  ?", array($barcode));
		if($q->num_rows() == 1) {
		$res = $q->row_array();
		if($res['deleted'] == '1') {
		$q = $this->db->query("UPDATE `ornament` SET `deleted` = '0', `name` = ?, `sell_price` = ?, `category_id` = ?, `brand_id` = ?, `mfg_barcode` = ? WHERE `id` = ?", array($name, $sell_price, $category_id, $brand_id, $barcode, $res['id']));
		if($this->db->affected_rows() > 0)
		return $res['id'];
		else
		return false;
		} else
		return false;
		}
		} */
		$this->db->trans_begin();
		$q = $this->db->query("insert into `ornament` (`name`, `category_id`,`weight`,`metal_id`,`metal_wt`,`stone_wt`,`stone_cost`,`making_cost_percent`,`making_cost_fixed`,`wastage_percent`,`wastage_cost_fixed`, `comments`)".
						"values (?,?,?,?,?,?,?,?,?,?,?,?)",array($name, $category_id, $weight, $metal_id, $metal_wt, $stone_wt, $stone_cost, $making_cost_percent, $making_cost_fixed, $wastage_percent, $wastage_cost_fixed, $comments));
		$id = $this->db->insert_id();
		//barcode to be added later
		//$barcode = sprintf('%s%010s','4',$id);
		//$q = $this->db->query("UPDATE `ornament` SET `custom_barcode` = ? WHERE `id` = ? ", array($barcode, $id));

		if($this->db->affected_rows() <= 0) {
			$this->db->rollback();
			return false;
		}
		$this->db->trans_commit();
		return $id;
	}

    public function addOrnament($name, $category_id, $weight, $making_cost_percent, $wastage_percent, $items = array(), $comments='', $barcode=''){
		if($name=='' || $category_id == ''){
			return false;
		}
		$this->db->trans_begin();
		$q = $this->db->query("insert into `ornament` (`name`, `category_id`,`weight`,`making_cost_percent`,`wastage_percent`,`comments`)".
								"values (?,?,?,?,?,?)",array($name, $category_id, $weight, $making_cost_percent, $wastage_percent, $comments));
		$id = $this->db->insert_id();
		foreach ($items as $item){
			//$item  = ('item_entity_id' => 2, 'item_specific_id' => 2 ,'weight' => 3.4 , $quantity => 12)
			$this->addItemToOrnament($id, $item['item_entity_id'], $item['item_specific_id'], 1 , $item['quantity']);
		}
		if($this->db->affected_rows() <= 0) {
			$this->db->rollback();
			return false;
		}
		$this->db->trans_commit();
		return $id;
	}
	
	public function addItemToOrnament($ornament_id, $item_entity_id, $item_specific_id, $weight, $quantity = 1){
		if($ornament_id == '' || $item_entity_id == '' || $item_specific_id == ''){
			return False;
		}
		//$this->db->trans_begin();
		// only quantity is being used (as weight in grams for metal and number for stones)
		$q = $this->db->query("insert into `ornament_items` (`ornament_id`, `item_entity_id`, `item_specific_id`, `weight`,`quantity`) ".
										"values (?,?,?,?,?)",array($ornament_id, $item_entity_id, $item_specific_id, $weight, $quantity));
		$id = $this->db->insert_id();
		return $id;
	}
	
	public function update($id, $name, $category_id, $weight, $metal_id, $metal_wt, $stone_wt, $stone_cost, $making_cost_percent, $making_cost_fixed, $wastage_percent, $wastage_cost_fixed, $comments='', $barcode=''){
		if($name=='' || $category_id == '' || $weight == '' || $metal_id == '' ){
			return false;
		}
		if($barcode != '') {
			$q = $this->db->query("SELECT * FROM `ornament` WHERE `mfg_barcode` =  ?", array($barcode));
			if($q->num_rows() == 1) {
				$res = $q->row_array();
				if($res['id'] != $id)
				return false;
			}
		}
		$q = $this->db->query("update `ornament` set `name` = ?, `category_id` = ?, `weight` = ?, `metal_id` = ?, `stone_wt` = ?, `stone_cost` = ?, `making_cost_percent` = ?, `wastage_percent` = ?, `wastage_cost_fixed`=?, `comments`=?".
								" WHERE `id` = ? ",array($name, $category_id, $weight, $metal_id, $metal_wt, $stone_wt, $stone_cost, $making_cost_percent, $making_cost_fixed, $wastage_percent, $wastage_cost_fixed, $comments, $id));
		if($this->db->affected_rows() <= 0){
			return false;
		}
		return true;
	}

	public function suggest_ornament($term){
		if($term == ''){
			return false;
		}
		$sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `ornament` p, `category` c where p.category_id = c.id AND p.`name` like '%".($term)."%' AND p.`deleted` = '0'";

		$q = $this->db->query($sql);
		if($q->num_rows() > 0){
			return $q->result_array();
		}
		return false;
	}

	public function getProductByBarcode($barcode) {
		if($barcode == '') {
			return false;
		}
		$bar = substr($barcode, 0, 11);
		log_message('debug','wnated - '.$bar);
		$sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `ornament` p, `category` c where p.category_id = c.id AND (p.`mfg_barcode` = '{$barcode}' OR p.`custom_barcode` = '{$bar}')";

		$q = $this->db->query($sql);
		if($q->num_rows() > 0) {
			return $q->row_array();
		}
		return false;
	}

	public function getById($id){
		if($id == ''){
			return false;
		}
		$q = $this->db->query("select o.*,c.vat_percentage as vat from `ornament` o,`category` c  where o.category_id = c.id AND o.`id` = ?", array($id));
		return $q->row_array();
	}

	public function deleteById($id){
		// Test of ornament, if no ornament then only allow deleting
		$r = $this->getById($id);
		if(isset($r['id'])){
			$q = $this->db->query("UPDATE `ornament` SET `deleted` = '1' where `id` = ?", array($r['id']));
			if($this->db->affected_rows() <= 0){
				return false;
			}
		}
		return $r;
	}
	
	public function getComponentsById($id){
		//id here is basically item specific id
		$sql = "SELECT * FROM `ornament_items` WHERE `ornament_id` = ? ORDER BY `id` LIMIT 0, 50";
		$q = $this->db->query($sql, array($id));
		if($q->num_rows() > 0){
		return $q->result_array();
		}
		return False;
	}
	
	public function getWeightByItemEntityId($id, $item_entity_id=1){
		// default item_entity_id 1 for metal weight
		//log_message('error', "PARAMS::".$id."NAD".$item_entity_id);
		$sql = "SELECT SUM(`quantity`) AS `metal_weight` FROM `ornament_items` WHERE `ornament_id` = ? AND `item_entity_id` = ?";
		$q = $this->db->query($sql, array($id, $item_entity_id));
		if($q->num_rows() > 0){
			$metal_weight =  $q->row_array();
			//log_message('error', "ORNAMENT::".$metal_weight);
			return $metal_weight['metal_weight'];
		}
		return False;
	}
	
	public function suggestItem($term){
		if($term == ''){
			return false;
		}
		$sql = "select o.*,o.`name` as `value`,c.vat_percentage as vat from `ornament` o, `category` c where o.category_id = c.id AND o.`name` like '%".($term)."%' AND o.`deleted` = '0'";
	
		$q = $this->db->query($sql);
		if($q->num_rows() > 0){
			$ornaments = $q->result_array();
			return $ornaments;
		}
		return false;
	}

}