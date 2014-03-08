<?php
/**
 * Enter description here ...
 * @author Appu
 *
 */
class Product_Model extends CI_Model{
	public function __construct(){
		$this->load->database();
	}

	public function add($name, $sell_price, $category_id, $brand_id, $barcode, $user_id){
	 if($name=='' || $category_id == '' || $brand_id == '' || $user_id == ''){
	 	return false;
	 }
	 if($barcode != '') {
	 	$q = $this->db->query("SELECT * FROM `products` WHERE `mfg_barcode` =  ?", array($barcode));
	 	if($q->num_rows() == 1) {
	 		$res = $q->row_array();
	 		if($res['deleted'] == '1') {
	 			$q = $this->db->query("UPDATE `products` SET `deleted` = '0', `name` = ?, `sell_price` = ?, `category_id` = ?, `brand_id` = ?, `mfg_barcode` = ? WHERE `id` = ?", array($name, $sell_price, $category_id, $brand_id, $barcode, $res['id']));
	 			if($this->db->affected_rows() > 0)
	 			return $res['id'];
	 			else
	 			return false;
	 		} else
	 		return false;
	 	}
	 }
	 $this->db->trans_begin();

	 $q = $this->db->query("insert into `products` (`name`,`sell_price`, `category_id`,`brand_id`, `user_id`) values (?,?,?,?,?)",array($name, $sell_price, $category_id, $brand_id, $user_id));
	 $id = $this->db->insert_id();

	 $barcode = sprintf('%s%010s','4',$id);
	 $q = $this->db->query("UPDATE `products` SET `custom_barcode` = ? WHERE `id` = ? ", array($barcode, $id));

	 if($this->db->affected_rows() <= 0) {
	 	$this->db->rollback();
	 	return false;
	 }
	 $this->db->trans_commit();
	 return $id;
	}

	public function update($id, $name, $sell_price, $category_id, $brand_id, $barcode){
		if($id=='' || $name=='' || $category_id == '' || $brand_id == ''){
			return false;
		}
		if($barcode != '') {
			$q = $this->db->query("SELECT * FROM `products` WHERE `mfg_barcode` =  ?", array($barcode));
			if($q->num_rows() == 1) {
				$res = $q->row_array();
				if($res['id'] != $id)
				return false;
			}
		}
		$q = $this->db->query("update `products` set `name` = ?, `sell_price` = ?, `category_id` = ?, `brand_id` = ? WHERE `id` = ? ",array($name, $sell_price, $category_id, $brand_id, $id));
		if($this->db->affected_rows() <= 0){
			return false;
		}
		return true;
	}

	public function suggest_products($term){
		if($term == ''){
			return false;
		}
		$sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `products` p, `category` c where p.category_id = c.id AND p.`name` like '%".($term)."%' AND p.`deleted` = '0'";

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
		$sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `products` p, `category` c where p.category_id = c.id AND (p.`mfg_barcode` = '{$barcode}' OR p.`custom_barcode` = '{$bar}')";

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
		$q = $this->db->query("select p.*,c.vat_percentage as vat from `products` p,`category` c  where p.category_id = c.id AND p.`id` = ?", array($id));
		return $q->row_array();
	}

	public function deleteById($id){
		// Test of products, if no products then only allow deleting
		$r = $this->getById($id);
		if(isset($r['id'])){
			$q = $this->db->query("UPDATE `products` SET `deleted` = '1' where `id` = ?", array($r['id']));
			if($this->db->affected_rows() <= 0){
				return false;
			}
		}
		return $r;
	}

    public function getComponentsById($id){
        return array();
    }
  public function getProdCount($class_id)
  {
    $data =   $this->db->query("SELECT sum( a.quantity ) as prod_count , d.name AS branch_name, sum( c.price ) AS total_value
                                FROM central_stock a
                                LEFT JOIN product_sku c ON a.item_specific_id = c.id
                                LEFT JOIN product_header b ON b.id = c.header_id
                                LEFT JOIN branch d ON a.branch_id = d.id
                                WHERE b.class_id = ?
                                GROUP BY b.class_id",$class_id)->row_array();
   return $data;
  }
}