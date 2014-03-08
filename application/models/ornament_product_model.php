<?php
/**
 * File Name: ornament_product_model.php
 * Author: Rajat
 * Date: 3/15/12
 * Time: 8:45 PM
 */
class Ornament_product_Model extends CI_Model
{
    public function __construct(){
        $this->load->database();
    }

    public function add($ornament_id, $weight, $items= array(), $comments=''){
        $this->db->trans_begin();
        $q = $this->db->query("insert into `ornament_product` (`ornament_header_id`,`weight`, `comment` )".
            "values (?,?,?)",array($ornament_id, $weight, $comments));
        $id = $this->db->insert_id();
        //barcode to be added later
        //$barcode = sprintf('%s%010s','4',$id);
        //$q = $this->db->query("UPDATE `ornament` SET `custom_barcode` = ? WHERE `id` = ? ", array($barcode, $id));
        foreach ($items as $item){
            //$item = {'ornament_items_id' => 23, 'quantity'=> 22.03}
            $this->addItemToOrnamentProduct($id, $item['item_entity_id'], $item['item_specific_id'], $item['quantity'], $item['weight']);
        }
        if($this->db->affected_rows() <= 0) {
            $this->db->rollback();
            return false;
        }
        $this->db->trans_commit();
        return $id;
    }

    public function addItemToOrnamentProduct($ornament_product_id, $item_entity_id, $item_specific_id, $quantity=1, $weight = 0){
        $q = $this->db->query("insert into `ornament_product_items` (`ornament_product_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`) ".
            "values (?,?,?,?,?)",array($ornament_product_id, $item_entity_id, $item_specific_id, $quantity, $weight));
        $id = $this->db->insert_id();
        return $id;
    }

    public function getById($id){
        if($id == ''){
            return false;
        }
        $q = $this->db->query("select op.`id`, op.`ornament_header_id` as header_id, op.`weight` as weight, ".
            "oh.`name` as name, oh.`category_id` , oh.`making_cost_percent` , oh.wastage_percent,".
            " c.vat_percentage as vat from `ornament` oh,`category` c, `ornament_product` op  where oh.`category_id` = c.`id`  AND op.`ornament_header_id` = oh.`id` AND op.`id` = ?", array(intval($id)));
        return $q->row_array();
    }

    public function getComponentsById($id){
        //id here is basically item specific id
        $sql = "SELECT * FROM `ornament_product_items` WHERE `ornament_product_id` = ? ORDER BY `id` LIMIT 0, 50";
        $q = $this->db->query($sql, array($id));
        if($q->num_rows() > 0){
            return $q->result_array();
        }
        return False;
    }


    public function getByBarcode(){

    }
}
