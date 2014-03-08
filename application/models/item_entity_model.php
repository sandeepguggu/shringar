<?php
/**
 * Enter description here ...
 * @author Appu
 *
 */
class Item_entity_Model extends CI_Model
{
	public function __construct()
	{
		$this->load->database();
	}

	public function getAllItemEntities()
	{
		//used in getting product entities
		$q = "SELECT * FROM `item_entity` WHERE `barcode_only` = 0 AND `is_subtype` = 0 AND `deleted` = 0 LIMIT 10";
		$r = $this->db->query($q);
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->result_array();
	}
	public function getStockEntities()
	{
		//used in getting product entities
		$q = "SELECT * FROM `item_entity` WHERE `barcode_only` = 0  AND `deleted` = 0 LIMIT 10";
		$r = $this->db->query($q);
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->result_array();
	}
   
	public function getEntityById($id)
	{
		$q = "SELECT * FROM `item_entity` WHERE `id`=?";
		$r = $this->db->query($q, array($id));
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->row_array();
	}

    public function getNameById($id){
        $q = "SELECT `name` FROM `item_entity` WHERE `id`=?";
        $r = $this->db->query($q, array($id));
        if ($r->num_rows() <= 0) {
            return FALSE;
        }
        $entity_array =  $r->row_array();
        return $entity_array['name'];

    }

	public function getHeaderEntity($id){
		$this->db->select("id, name");
		$where = "is_header = 1 AND product_entity_id =".$id;
		$this->db->where($where);
		$data = $this->db->get('item_entity')->row_array();
		return $data;
	}
	public function getEntityId($name)
	{
		$q = "SELECT `id` FROM `item_entity` WHERE `name`=? LIMIT 1";
		$r = $this->db->query($q, array($name));
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		$a = $r->row_array();
		return $a['id'];
	}

	public function getEntityByName($name){
		$q = "SELECT * FROM `item_entity` WHERE `name`=? LIMIT 1";
		$r = $this->db->query($q, array($name));
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		$a = $r->row_array();
		return $a;
	}
	public function getById($id)
	{
		$q = "SELECT * FROM `item_entity` WHERE `id`=?";
		$r = $this->db->query($q, array($id));
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->row_array();
	}

	public function getAllEntitiesForBarcode()
	{
		//used in getting product entities
		$q = "SELECT * FROM `item_entity` LIMIT 100";
		$r = $this->db->query($q);
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->result_array();
	}

	public function getMfgBarcodeEntities()
	{
		$q = "SELECT * FROM `item_entity` WHERE `mfg_barcode` = 1 LIMIT 10";
		$r = $this->db->query($q);
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->result_array();
	}

	public function getOldItemEntities(){
		$q = "SELECT * FROM `item_entity` WHERE `old_purchase` = 1 LIMIT 10";
		$r = $this->db->query($q);
		if ($r->num_rows() <= 0) {
			return FALSE;
		}
		return $r->result_array();
	}
  public function getItemSpecifics($item_entity_id,$item_specific_id='')
  {
	  $entity = $this->db->query("SELECT id,name,display_name from item_entity where id=?",$item_entity_id)->row_array();
	  $tbl = $entity['name'];
	 
	  if(empty($item_specific_id)) { $this->db->query("SELECT * from $tbl where id=?",$item_specific_id)->result_array();}
	  else 
	  {
		   $specifics = $this->db->query("SELECT * from $tbl where id=?",$item_specific_id)->row_array();
	  }
	  return array($entity,$specifics);
  }
public function getEntitySpecificName($item_entity_id,$item_specific_id)
{
	 $tbl_name = $this->db->query("select name from item_entity where id =?",$item_entity_id)->row_array();
	 $specific_name = $this->db->query("select name from ".$tbl_name['name']." where id = ?",$item_specific_id)->row_array();
	$data = array("entity_name"=>$tbl_name['name'],"specific_name"=>$specific_name['name']);
	return $data;
}
}