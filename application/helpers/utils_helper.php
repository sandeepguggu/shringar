<?php
/**
 * File Name: utils.php
 * Author: Rajat
 * Date: 7/12/12
 * Time: 3:33 PM
 */
function formatAttributes($attributes_array)
{
    //multidimensional attribute array to key value pair
    $return = array();
    foreach ($attributes_array as $att) {
        $attribute = array();
        if (isset($att['value']) && !is_null($att['value']) && $att['value'] != '' && $att['value'] != -99) {
            $attribute[$att['name']] = $att['value'];
            $attribute['name'] = $att['name'];
            if (isset($att['display_name']) && !is_null($att['display_name']) && $att['display_name'] != '') {
                $attribute['display_name'] = $att['display_name'];
            }
            if (isset($att['level']) && !is_null($att['level']) && $att['level'] != '') {
                $attribute['level'] = $att['level'];
            }
            if (isset($att['sku']) && !is_null($att['sku']) && $att['sku'] != '') {
                $attribute['sku'] = $att['sku'];
            }
            if (isset($att['id']) && !is_null($att['id']) && $att['id'] != '') {
                $attribute['id'] = $att['id'];
            }
            $attribute['value'] = $att['value'];
        } else if (isset($att['value']) && !is_null($att['value']) && $att['value'] != '' && $att['value'] == -99) {
            //do nothing for now...will decide on this later
            $attribute[$att['name']] = $att['value'];
            $attribute['name'] = $att['name'];
            if (isset($att['display_name']) && !is_null($att['display_name']) && $att['display_name'] != '') {
                $attribute['display_name'] = $att['display_name'];
            }
            if (isset($att['id']) && !is_null($att['id']) && $att['id'] != '') {
                $attribute['id'] = $att['id'];
            }
            if (isset($att['level']) && !is_null($att['level']) && $att['level'] != '') {
                $attribute['level'] = $att['level'];
            }
            if (isset($att['sku']) && !is_null($att['sku']) && $att['sku'] != '') {
                $attribute['sku'] = $att['sku'];
            }
            $attribute['value'] = '';
            $attribute['sku'] = 1;
        }
        $return[] = $attribute;
    }
    return $return;
    //return $attributes_array;
}

function mergeHeaderSKUAttributes($header_attributes = array(), $sku_attributes = array())
{
    $return = array();
    foreach ($header_attributes as $ha) {
        if ($ha['value'] != -99 && $ha['sku'] == 0) {
            $return[] = $ha;
        }
    }
    foreach ($sku_attributes as $sa) {
        if ($sa['value'] != -99) {
            $return[] = $sa;
        }
    }
}