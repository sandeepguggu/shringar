
<?php
/**
 * Rent Product Model class to handle all the database operations related to 
 * rented products 
 * 
 * @package Models
 * @author  Ram <ramac@langoor.net>
 * @version 0.1.0
 * @copyright Langoor Biz
 */
 

/**
 * Description of rent_product_model
 *
 * @author langoor
 */
class Rent_Component_Stock_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }// end: function __construct
    
    /**
     * Function to fetch all the records of the Rent_Product table and returns 
     * in an array
     * 
     * @access public
     * @return Array $result 
     */
    public function getAllByComponentsId($id) {
        
        $result = array();
        $q = $this->db->query("select * from `rent_component_stock` WHERE `rent_component_id` = ".$id);
        if ($q->num_rows() > 0) {
            foreach($q->result_array() as $r){
                $result[] = $r;
            } //end:foreach
            return $result;
                    
        } //end:if 
        return false;
    } //end: function getAllData()
   
    /**
     * Function to add product details the rent_product table
     * 
     * @access public
     * @return void 
     */
    public function add($data) {

        $q = $this->db->query("SELECT * FROM `rent_components` WHERE `name` = ?", array($data['name']));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($res['status'] == '0') {
                $q = $this->db->query("UPDATE `rent_components` 
                                            SET `status` = '1', 
                                                `product_name` = ?, 
                                                `category_id` = ?  WHERE `id` = ?", array($data['produc_name'], $data['category_id'], $res['id']));
                if ($this->db->affected_rows() > 0)
                    return $res['id'];
                else
                    return false;
            } else
                return false;
        }
        $q = $this->db->query("INSERT INTO `rent_components` (
                                    `name`,
                                    `rent_price`,
                                    `quantity`,
                                    `status`)
                                VALUES (?,?,?,?)", 
                                array(
                                     $data['name'],
                                     $data['rent_price'],
                                     $data['quantity'],
                                     1));
        $insertedId = $this->db->insert_id();
        if( $insertedId != '' && $data['quantity'] !='' ) {
            $q = $this->db->query("INSERT INTO `rent_component_stock` (
                                        `rent_component_id`,
                                        `quantity`)
                                    VALUES (?,?)", 
                                    array(
                                        $this->db->insert_id(),
                                        $data['quantity']));
        }

        return $insertedId;
    } //end: function add
    
    /**
     * Function to update the product data
     * 
     * @access public
     * @return void 
     */
    public function update($data) {
        
        $insert_array = array(
                        'rent_component_id' => $data['rent_component_id'],
                        'quantity'          => $data['quantity']);
        $this->db->where('id', $data['id']);
        return $this->db->update('rent_component_stock', $insert_array);
        
    } //end: function update
    
    
     

            
} //end: class Rent_Product_Model

?>
