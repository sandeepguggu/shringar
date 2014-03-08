
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
class Rent_Components_Model extends CI_Model {
    
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
    public function getAllComponents() {
        
        $result = array();
        $q = $this->db->query("select * from `rent_components` WHERE `id` > 0 AND `status` = 1 ORDER BY `name` ASC");
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
                        'name'  => $data['name'],
                        'rent_price'    => $data['rent_price'],
                        'quantity'      => $data['quantity']);
        $this->db->where('id', $data['id']);
        return $this->db->update('rent_components', $insert_array);
        
    } //end: function update
    
    
        /**
     *
     * @param String $key
     * @return array $returnValue 
     */
    public function getNameByKey($key) {
        
        $returnValue = array();
        
        if ($key != '') {
            
            $sql    = "select * FROM `rent_components` WHERE `name` 
                      like '%" . ($key) . "%' AND `status` = 1";
            $q      = $this->db->query($sql);
            if ($q->num_rows() > 0) {
                $returnValue = $q->result_array();
            }
            return $returnValue;
        }
        
        
    } //end: function getNameByKey()
    
    /**
     * Function to delete the product from the rent_product table
     * 
     * @param integer $id
     * @return boolean 
     */
    public function deleteById($id) {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {

            $q = $this->db->query("UPDATE `rent_components` SET `status` = '0' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }
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
        $q      = $this->db->query("select * from `rent_components` where `id` = ?", array($id));
        $result =  $q->row_array();
        
        return $result;
    } //end: function getById()

     /**
     * Function to fetch the data from the rent_product table using the primary key $id
     * 
     * @param type $id
     * @access public
     * @return array $result 
     */
    public function getByName($name) {
        if ($name == '') {
            return false;
        }
        $product_result     = array();
        $category_result    = array();
        
        $q      = $this->db->query("SELECT
                                        a.id, sum(b.rent_price) as rent_price, 
                                        a.quantity,
                                        a.product_name as name
                                    FROM    
                                        `rent_product` a, 
                                        `rent_product_component` b
                                    WHERE
                                        a.product_name = ?  
                                    AND
                                        a.id = b.rent_product_id", array($name));
        if ($q->num_rows() > 0)
            $product_result =  $q->row_array();
        $q      = $this->db->query("select id as cid, rent_price, quantity,name from `rent_product_component` where `name` = ?", array($name));
        if ($q->num_rows() > 0)
            $category_result =  $q->row_array();

        return array_merge($product_result, $category_result);
    } //end: function getByName
    

            
} //end: class Rent_Product_Model

?>
