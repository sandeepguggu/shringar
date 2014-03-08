<?php
/**
 * File Name: Barcode.php
 * Author: Rajat
 * Date: 3/20/12
 * Time: 2:07 AM
 */
class Barcode
{
    public function __construct($config = array())
    {
    }

    public function getByBarcode($barcode)
    {
        $CI =& get_instance();
        $CI->load->model('Master_Model', 'master');
        $entity_array = $CI->master->getArrayByBarcode($barcode);
        $CI->load->model('Item_entity_Model', 'item_entity');
        $item_entity_array = $CI->item_entity->getById($entity_array['item_entity_id']);
        $CI->load->model($item_entity_array['name'] . '_Model', $item_entity_array['name']);
        $entity_specific_details = $CI->{$item_entity_array['name']}->getById($entity_array['item_specific_id']);
        $entity_specific_details = array_merge($entity_array, $entity_specific_details);
    }

    public function getBarcode($item_entity_id, $item_specific_id)
    {
        $CI =& get_instance();
        $CI->load->model('Master_Model', 'master');
        $barcode = $CI->master->getBarcode($item_entity_id, $item_specific_id);
        return $barcode;
    }

    public function isValidBarcode($barcode)
    {
        $CI =& get_instance();
        $CI->load->model('Master_Model', 'master');
        return $CI->master->isCustomBarcode($barcode);
    }

    public function decomposeBarcode($barcode)
    {
        $CI =& get_instance();
        $CI->load->model('Master_Model', 'master');
        $entity_array = $CI->master->getArrayByBarcode($barcode);
        //print_r($entity_array);
        //die();
        //result is = ['item_entity_id' = 3, 'item_specific_id' =6 ]
        return $entity_array;
    }

    public function getConfiguration()
    {
        $CI =& get_instance();
        $CI->load->model('Master_Model', 'master');
        return $CI->master->getConfiguration();
    }
}

?>