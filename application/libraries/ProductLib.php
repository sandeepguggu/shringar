<?php
/**
 * File Name: Product.php
 * Author: Rajat
 * Date: 3/13/12
 * Time: 5:05 PM
 */
class ProductLib
{
    public function __construct($config = array())
    {
    }

    public function getProductDetails($item_entity_id, $item_specific_id)
    {
        if ($item_entity_id == '' || $item_specific_id == '') {
            return False;
        } else {
            $item_entity_id = intval($item_entity_id);
            $item_specific_id = intval($item_specific_id);
        }
        $CI =& get_instance();
        $CI->load->model('Item_entity_Model', 'item_entity');
        $CI->load->model('Category_Model', 'category');
        $CI->load->model('brand_Model', 'brand');
        $CI->load->model('User', 'user');
        $CI->load->model('metal_model', 'metal');
        $CI->load->model('stone_model', 'stone');
        $CI->load->model('ornament_model', 'ornament');
        $CI->load->model('old_ornament_model', 'old_ornament');
        $CI->load->model('rate_model', 'rate');
        $CI->load->model('inventory_model', 'inventory');
        $entity = $CI->item_entity->getEntityById($item_entity_id);
        $name = $entity['name'];
        $model_full_name = $name . '_model';
        $CI->load->model($model_full_name, $name);
        $item_specific_details = $CI->{$name}->getById($item_specific_id);
        $item_specific_details['item_entity_id'] = $item_entity_id;
        $item_specific_details['item_specific_id'] = $item_specific_id;
        $item_specific_details['model_name'] = $name;
        if ($entity['is_composite']) {
            $sub_items = $CI->{$name}->getComponentsById($item_specific_id);
            foreach ($sub_items as &$sub_item) {
                $sub_item_details = $this->getProductDetails($sub_item['item_entity_id'], $sub_item['item_specific_id']);
                $sub_item = array_merge($sub_item, $sub_item_details);
            }
        } else {
            $sub_items = array();
        }
        $item_specific_details['items'] = $sub_items;
        if (!isset($item_specific_details['price']) && !isset($item_specific_details['rate']) && !isset($item_specific_details['attributes']['price'])) {
            $rate_temp = $this->getRate($item_entity_id, $item_specific_id, $name, count($sub_items));
            if ($rate_temp) {
                $item_specific_details['rate'] = $rate_temp;
            } else {
                $item_specific_details['rate'] = '';
            }
        }
        if (isset($item_specific_details['price']) && !is_null($item_specific_details['price']) && $item_specific_details['price'] != '') {
            $item_specific_details['rate'] = $item_specific_details['price'];
        } elseif (isset($item_specific_details['attributes']['price']) && !is_null($item_specific_details['attributes']['price']) && $item_specific_details['attributes']['price'] != '') {
            $item_specific_details['rate'] = $item_specific_details['price'] = $item_specific_details['attributes']['price'];
        } else {
            $item_specific_details['price'] = $item_specific_details['rate'];
        }
        $temp = $CI->inventory->getStockValueByItem($item_entity_id, $item_specific_id, $CI->user->getBranch());
        $item_specific_details['stock'] = $temp['stock'];
        $item_specific_details['mrp_value'] = $temp['value'];
        unset($temp);
        $item_specific_details = array_merge($item_specific_details, $CI->category->getProductCategoryById($item_specific_details['category_id']));
        return $item_specific_details;
    }

    public function getRate($item_entity_id = 1, $item_specific_id, $name = 'ornament', $composite = false)
    {
        $CI =& get_instance();
        $CI->load->model('Item_entity_Model', 'item_entity');
        $CI->load->model('Category_Model', 'category');
        $CI->load->model('brand_Model', 'brand');
        $CI->load->model('User', 'user');
        $CI->load->model('metal_model', 'metal');
        $CI->load->model('stone_model', 'stone');
        $CI->load->model('ornament_model', 'ornament');
        $CI->load->model('old_ornament_model', 'old_ornament');
        $CI->load->model('rate_model', 'rate');
        if ($composite) {
            $items = $CI->{$name}->getComponentsById($item_specific_id);
            //log_message('error', "RAJAT:".$items[0][0]);
            //log_message('error', 'IN getRate::'.$item_entity_id);
            return $this->getCompositeRate($items);
        }
        /*        if ($item_entity_id == 2) {
            //stone cost for now being returned as zero
            //log_message('error', 'IN getRate::'.$item_entity_id);
            return 0;
        }*/
        //log_message('error', 'IN getRate::'.$item_entity_id);
        return $CI->rate->getRate($item_entity_id, $item_specific_id);
    }

    public function getCompositeRate($items)
    {
        $CI =& get_instance();
        $CI->load->model('Item_entity_Model', 'item_entity');
        $CI->load->model('Category_Model', 'category');
        $CI->load->model('brand_Model', 'brand');
        $CI->load->model('User', 'user');
        $CI->load->model('metal_model', 'metal');
        $CI->load->model('stone_model', 'stone');
        $CI->load->model('ornament_model', 'ornament');
        $CI->load->model('old_ornament_model', 'old_ornament');
        $CI->load->model('rate_model', 'rate');
        //$items = {'id' , 'item_entity_id', 'item_specific_id', 'quantity'}
        $composite_rate = 0;
        //log_message('error', "Before Foreach::" . $items);
        foreach ($items as $item) {
            $per_unit_price = $this->getRate($item['item_entity_id'], $item['item_specific_id']);
            log_message("error", "GET RATE:: " . print_r($item, 1) . 'AND ' . $per_unit_price);
            //log_message('error', 'IN FOREACH: '.$item['item_entity_id'].'and'.$item['item_specific_id']);
            $composite_rate += ($per_unit_price * $item['quantity'] * $item['weight']);
        }
        return $composite_rate;
    }
}

?>