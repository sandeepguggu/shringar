
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
class Rent_Product_Component_Model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }// end: function __construct
    

   
    /**
     * Function to add component for each product in the rent_component table
     * 
     * @access public
     * @return void
     *  
     */
    public function add($data) {


        $q = $this->db->query("INSERT INTO `rent_product_component` (
                                    `name`,
                                    `rent_product_id`,
                                    `quantity`,
                                    `rent_price`,
                                    `status`)
                                VALUES (?,?,?,?,?)", 
                                array(
                                     $data['name'],
                                     $data['rent_product_id'],
                                     $data['quantity'],
                                     $data['rent_price'],
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
     * Function to update the component data if records exists otherwise add new 
     * record
     * 
     * @access public
     * @return void 
     */
    public function update($data) {
        if(count($this->getById($data['component_id'])) != 0) {

            $insert_array = array(
                            'name'              => $data['name'],
                            'rent_product_id'   => $data['rent_product_id'],
                            'quantity'             => $data['quantity'],
                            'rent_price'             => $data['rent_price'],
                            'status'            => 1);
            $this->db->where('id', $data['component_id']);
            return $this->db->update('rent_product_component', $insert_array);
        } else {
            return $this->add($data);
        } //end:if
            
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
        $q      = $this->db->query("select * from `rent_product_component` where `id` = ?", array($id));
        $result =  $q->row_array();
        
        return $result;
    }

    //put your code here
} //end: class Rent_Product_Model

?>
