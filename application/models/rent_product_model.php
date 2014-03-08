
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
class Rent_Product_Model extends CI_Model {
    
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
    public function getAllProducts() {
        
        $result = array();
        $q = $this->db->query("select * from `rent_product` WHERE `id` > 0 AND `status` = 1 ORDER BY `product_name` ASC");
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

        $q = $this->db->query("SELECT * FROM `rent_product` WHERE `product_name` = ?", array($data['product_name']));
        if ($q->num_rows() == 1) {
            $res = $q->row_array();
            if ($res['status'] == '0') {
                $q = $this->db->query("UPDATE `rent_product` 
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
        $q = $this->db->query("INSERT INTO `rent_product` (
                                    `product_name`,
                                    `description`,
                                    `rent_price`,
                                    `quantity`,
                                    `category_id`,
                                    `status`)
                                VALUES (?,?,?,?,?,?)", 
                                array(
                                     $data['product_name'],
                                     $data['description'],
                                     $data['rent_price'],
                                     $data['quantity'],
                                     $data['category_id'],
                                     1));
        $insertedId = $this->db->insert_id();
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
                        'product_name'  => $data['product_name'],
                        'description'   => $data['description'],
                        'rent_price'    => $data['rent_price'],
                        'category_id'   => $data['category_id']);
        $this->db->where('id', $data['id']);
        return $this->db->update('rent_product', $insert_array);
        
    } //end: function update
    
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
            $q = $this->db->query("UPDATE `rent_product` SET `status` = '0' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
            $q = $this->db->query("UPDATE `rent_product_component` SET `status` = '0' where `rent_product_id` = ?", array($r['id']));
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
        $q      = $this->db->query("select * from `rent_product` where `id` = ?", array($id));
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
       /* if ($name == '') {
            return false;
        }
        $resultSet['products']     = array();
        $resultSet['components']    = array();
        
        $q      = $this->db->query("SELECT
                                        a.id, sum(b.rent_price) as rent_price, 
                                        a.product_name as name
                                    FROM    
                                        `rent_product` a, 
                                        `rent_components` b,
                                        `rent_product_component_relation` c
                                    WHERE
                                        a.product_name = ?  
                                    AND
                                        a.id = c.product_id
                                    AND 
                                        c.component_id = b.id", array($name));
        if ($q->num_rows() > 0)
            $resultSet['products'] =  $q->row_array();
        $q      = $this->db->query("SELECT
                                        id as cid, 
                                        rent_price, 
                                        quantity,
                                        name 
                                    FROM
                                        `rent_components` 
                                    WHERE
                                        `name` = ?", array($name));
        if ($q->num_rows() > 0)
            $resultSet['components'] =  $q->row_array();

        return $resultSet;

        */

        if ($name == '') {
            return false;
        }
        $resultSet['products']     = array();
        $resultSet['components']    = array();
        
        $q      = $this->db->query("SELECT id, rent_price, product_name as name
                                    FROM    
                                        `rent_product` 
                                    WHERE
                                        product_name = ?  ", array($name));
        if ($q->num_rows() > 0)
            $resultSet['products'] =  $q->row_array();
        $q      = $this->db->query("SELECT
                                        b.id, b.name
                                    FROM    
                                        `rent_product` a, 
                                        `rent_components` b,
                                        `rent_product_component_relation` c
                                    WHERE
                                        a.product_name = ?  
                                    AND 
                                        b.id = c.component_id
                                    AND
                                        a.id = c.product_id", array($name));
        if ($q->num_rows() > 0)
            $resultSet['components'] =  $q->result_array();

        return $resultSet;
    } //end: function getByName
    
    /**
     *
     * @param String $key
     * @return array $returnValue 
     */

    public function getNameByKey($key) {
        
        //$returnValue2 = $returnValue1 = array();
        $returnValue = array();
        
        if ($key != '') {
            
            $sql    = "select `id` , `product_name` as name FROM `rent_product` WHERE `product_name` 
                      like '%" . ($key) . "%' AND `status` = 1";
            $q      = $this->db->query($sql);
            if ($q->num_rows() > 0) {
                $returnValue = $q->result_array();
            }
            
            /*$sql    = "select `name` as name FROM `rent_components` WHERE `name` 
                      like '%" . ($key) . "%' AND `status` = 1";
            $q      = $this->db->query($sql);
            if ($q->num_rows() > 0) {
                $returnValue2 = $q->result_array();
            }
            return array_merge($returnValue1, $returnValue2);

            return $returnValue1;*/
            return $returnValue;
        }

             /*$returnValue = array();
        
        if ($key != '') {
            
            $sql    = "select * FROM `rent_product` WHERE `product_name` 
                      like '%" . ($key) . "%' AND `status` = 1";
            $q      = $this->db->query($sql);
            if ($q->num_rows() > 0) {
                $returnValue = $q->result_array();
            }
            return $returnValue;
        }*/
        
        
    } //end: function getNameByKey()

    public function getIdByName($name)
    {

        if ($name == '') {
            return false;
        }

        $resultSet = array();

        $sql    = "select `id` FROM `rent_product` WHERE `product_name` = '$name'";
            $q      = $this->db->query($sql);
            if ($q->num_rows() > 0) {
                $resultSet = $q->result_array();

        return $resultSet;

        }
    }
            
} //end: class Rent_Product_Model

?>
