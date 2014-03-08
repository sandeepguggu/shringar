
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
class Rent_Product_Component_Relation_Model extends CI_Model {
    
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
    public function getAllByProductId($id) {
        
        $result = array();
        $q = $this->db->query("SELECT a.id as rid, a.component_id as component_id,
                                      a.product_id product_id, b.* 
                               FROM
                                    `rent_product_component_relation` as a, 
                                     rent_components as b 
                               WHERE a.`product_id` =".$id." 
                               AND   a.component_id = b.id ");
        if ($q->num_rows() > 0) {
            foreach($q->result_array() as $r){
                $result[] = $r;
            } //end:foreach
            return $result;
                    
        } //end:if 
        return false;
    } //end: function getAllData()
   
    /**
     * Function to add component for each product in the rent_component table
     * 
     * @access public
     * @return void
     *  
     */
    public function add($data) {


        $q = $this->db->query("INSERT INTO `rent_product_component_relation` (
                                    `product_id`,
                                    `component_id`)
                                VALUES (?,?)", 
                                array(
                                     $data['product_id'],
                                     $data['component_id']));
        $insertedId = $this->db->insert_id();

        return $insertedId;
    } //end: function add
    
    
    /**
     * Function to update the component data if records exists otherwise add new 
     * record
     * 
     * @access public
     * @return void 
     */
    public function update($data) {
            $insert_array = array(
                            'product_id'   => $data['product_id']);
            $this->db->where('component_id', $data['component_id']);
            return $this->db->update('rent_product_component_relation', $insert_array);
            
    } //end: function update
    
    
    /**
     * Function to fetch the data from the rent_product table using the primary key $id
     * 
     * @param type $id
     * @access public
     * @return array $result 
     */
    public function getById($id) {
        if ($id == '') {
            return false;
        }
        $q      = $this->db->query("select * from `rent_product_component_relation` where `id` = ?", array($id));
        $result =  $q->row_array();
        
        return $result;
    }
    
    public function deleteById($id){
        if ($id == '') {
            return false;
        }
        $q      = $this->db->query("DELETE from `rent_product_component_relation` where `id` = ?", array($id));
        if($this->db->affected_rows() <= 0){
            return false;
        }

    }

    public function getByComponentId($id) {
        if ($id == '') {
            return false;
        }
       // $q      = $this->db->query("select * from `rent_product_component_relation` where `component_id` = ?", array($id));
        
       // $result =  $q->row_array();
        
        //return $result;

        $q      = $this->db->query("SELECT
                                        a.product_name as product_name
                                    FROM    
                                        `rent_product` a, 
                                        `rent_product_component_relation` b
                                    WHERE                                   
                                        b.component_id = '$id'                                             
                                    AND 
                                        a.id = b.product_id
                                        ");

        $result =  $q->row_array();
        
        return $result;
    }

} //end: class Rent_Product_Model

?>
