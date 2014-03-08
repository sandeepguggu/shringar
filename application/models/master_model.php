<?php
/**
 * File Name: Master_Model.php
 * Author: Rajat
 * Date: 3/13/12
 * Time: 12:14 AM
 */
// this class will deal with the configuration of master input field provided on every page
class Master_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->barcode_id = '4';
        $this->barcode_length = 10;
        $this->item_entity_id_start = 1;
        $this->item_entity_id_end = 2;
        $this->item_entity_id_length = $this->item_entity_id_end - $this->item_entity_id_start + 1;
        $this->item_specific_id_start = $this->item_entity_id_end + 1;
        $this->item_specific_id_end = $this->barcode_length - 1;
        $this->item_specific_id_length = $this->item_specific_id_end - $this->item_specific_id_start + 1;
    }

    public function loadConfig()
    {
        // TODO - think on this
    }

    public function getArrayByBarcode($barcode)
    {
        if (strlen($barcode) != $this->barcode_length) {
            return False;
        }
        //die();
        if (substr($barcode, 0, $this->item_entity_id_start) != $this->barcode_id) {
            return False;
        }
        $result = array();
        $result['item_entity_id'] = intval(substr($barcode, $this->item_entity_id_start, $this->item_entity_id_end + 1 - $this->item_entity_id_start));
        $result['item_specific_id'] = intval(substr($barcode, $this->item_specific_id_start, $this->item_specific_id_end + 1 - $this->item_specific_id_start));
        return $result;
    }

    public function isCustomBarcode($barcode)
    {
        if (strlen($barcode) != $this->barcode_length) {
            return False;
        }
        if (substr($barcode, 0, $this->item_entity_id_start) != $this->barcode_id) {
            return False;
        }
        return True;
    }

    public function getConfiguration()
    {
        $config = array('id' => $this->barcode_id, 'item_entity_id_length' => $this->item_entity_id_length, 'item_specific_id_length' => $this->item_specific_id_length);
        return $config;
    }

    public function getBarcode($item_entity_id, $item_specific_id, $extra = array())
    {
        $barcode = $this->barcode_id;
        $barcode .= str_pad($item_entity_id, $this->item_entity_id_length, '0', STR_PAD_LEFT);
        $barcode .= str_pad($item_specific_id, $this->item_specific_id_length, '0', STR_PAD_LEFT);
        return $barcode;
    }
}

?>