<?php
/**
 * File Name: product_sku_model.php
 * Author: Rajat
 * Date: 4/16/12
 * Time: 6:53 PM
 */
/**********************************************************
CREATE TABLE `product_sku` (
`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`header_id` bigint(20) unsigned DEFAULT NULL,
`size` varchar(10) DEFAULT NULL,
`weight` decimal(5,3) DEFAULT NULL,
`weight_unit` enum('g','kg') DEFAULT NULL,
`volume` decimal(5,3) DEFAULT NULL,
`volume_unit` enum('ml','l') DEFAULT NULL,
`color` varchar(20) DEFAULT NULL,
`variant` varchar(30) DEFAULT NULL,
`design` varchar(30) DEFAULT NULL,
`price` decimal(6,2) DEFAULT NULL,
`max_discount` decimal(3,2) DEFAULT NULL,
`image_path` varchar(200) DEFAULT NULL,
`image` blob,
`date_updated` datetime DEFAULT NULL,
`vendor_id` int(11) DEFAULT NULL,
`user_id` int(11) DEFAULT NULL,
`status` tinyint(1) DEFAULT NULL,
`batch_no` varchar(20) DEFAULT NULL,
`mfg_pkg_date` date DEFAULT NULL,
`exp_date` date DEFAULT NULL,
`extra_attr` tinyint(1) DEFAULT NULL,
`extra_json` text,
`deleted` tinyint(1) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
 ***********************************************************/
/******************************************
//IMPORTANT ::  To make any attribute move_to_header, its value will be -99 , '-99'
 ***********************************************/
class Product_sku_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->model('Product_header_Model', 'product_header');
        $this->load->model('attribute_Model', 'attribute');
        $this->load->helper('utils');
        //TODO weight/volume are to be coupled with units
        //'model', 'size', 'color', 'volume', 'volume_unit', 'weight', 'weight_unit', 'variant', 'design', 'gender', 'price'
        $this->attributes = $this->attribute->getPrimaryAttributesName(1);
        //$this->attributes = array('size', 'mfg_pkg_date', 'exp_date', 'color', 'volume', 'volume_unit', 'weight', 'weight_unit', 'variant', 'design', 'price');
        $this->details = array('id', 'header_id', 'price', 'status', 'mfg_barcode', 'extra_attr_app');
    }

    public function add($header_id, $vendor_id, $user_id, $max_discount = 100, $attributes = array(), $image_path = '', $tracking_level = '', $mfg_barcode = '')
    {
        if ($header_id == '' || $max_discount == '' || $user_id == '' || $vendor_id == '') {
            return false;
        }
        $this->db->trans_begin();
        //foreach attributes, needs to be done
        $matched_sku = $this->getMatchedSKU($header_id, $vendor_id, $user_id, $attributes, $tracking_level);
        if ($matched_sku && $matched_sku > 0) {
            return $matched_sku;
        }
        $level_3_att = array();
        $level_1_att_names = array();
        $level_2_attributes = array();
        foreach ($attributes as &$attribute_for_loop) {
            if ($attribute_for_loop['level'] == 1) {
                if (isset($attribute_for_loop['sku']) && $attribute_for_loop['sku'] == 1) {
                    log_message('error', 'IN SKU Model : #62 - attribute SKU = 1');
//                    ${$attribute_for_loop['name']} = -99;
                }
                if (isset($attribute_for_loop['read_only']) && $attribute_for_loop['read_only'] == 1) {
                    log_message('error', 'IN SKU Model : #65 - read_only');
                } else {
                    ${$attribute_for_loop['name']} = $attribute_for_loop['value'];
                }
                $level_1_att_names[] = $attribute_for_loop['name'];
            } elseif ($attribute_for_loop['level'] == 3) {
                $level_3_att[$attribute_for_loop['name']] = $attribute_for_loop['value'];
            } else {
                $extra_attr_app = 1;
                if (!isset($attribute_for_loop['level'])) {
                    $attribute_for_loop['level'] = 2;
                }
                $level_2_attributes[] = $attribute_for_loop;
            }
        }
        $date_updated = date('Y-m-d H:i:s');
        $extra_json = json_encode($level_3_att);
        //insert product header, with level 3 attributes if any
        $temp_array = array('header_id', 'vendor_id', 'image_path', 'extra_json', 'user_id', 'mfg_barcode', 'extra_attr_app', 'date_updated');
        $insert_array = compact(array_merge($temp_array, $level_1_att_names));
        $this->db->insert('product_sku', $insert_array);
        $product_id = $this->db->insert_id();
        //insert into product attribute then with the above id
        foreach ($level_2_attributes as $attribute) {
            if ($attribute['level'] == 2) {
                $this->addProductAttribute($product_id, $attribute);
            }
        }
        if ($this->db->affected_rows() <= 0) {
            $this->db->rollback();
            return false;
        }
        $this->db->trans_commit();
        return $product_id;
    }

    public function getMatchedSKU($header_id, $vendor_id, $user_id, $attributes = array(), $tracking_level = '')
    {
        if ($tracking_level == '') {
            $tracking_level = $this->product_header->getTrackingLevel($header_id);
        }
        if ($tracking_level >= 4) {
            return False;
        }
        $primary_attributes = array();
        $secondary_attributes = array();
        $conditional_array = array('header_id' => $header_id);
        if ($tracking_level <= 3) {
            if ($tracking_level == 2) {
                foreach ($attributes as $attribute) {
                    if ($attribute['level'] == 1 && $attribute['value'] != '' && !is_null($attribute['value'])) {
                        $primary_attributes[] = $attribute;
                        $conditional_array[$attribute['name']] = $attribute['value'];
                    } elseif ($attribute['level'] == 2 && $attribute['value'] != '' && !is_null($attribute['value'])) {
                        $secondary_attributes[$attribute['id']] = $attribute['value'];
                    } else {
                        log_message('error', 'PRODUCT SKU Model : #125' . print_r($attribute, 1));
                    }
                }
            } elseif ($tracking_level == 3) {
            }
            //matching algorithm goes here
            //get primary attributes with sku from attributes array
            $this->db->select('ps.id as id, ps.header_id as header_id, ps.extra_attr_app as extra_attr_app');
            $q = $this->db->get_where('product_sku ps', $conditional_array);
            $count_rows = $q->num_rows();
            if ($count_rows < 1) {
                return False;
            } else {
                if ($tracking_level == 1) {
                    $sku_result_array = $q->row_array();
                    return $sku_result_array['id'];
                }
                $sku_result_array = $q->result_array();
                foreach ($sku_result_array as $sku_result) {
                    $flag = TRUE;
                    //get all secondary attributes
                    $attributes_exist = $this->getSecondaryAttributes($sku_result['id'], 0);
                    $key_val_attr_existing = array();
                    foreach ($attributes_exist as $attribute_exist) {
                        //just to make matching simple (could have been done in a single loop also)
                        $key_val_attr_existing[$attribute_exist['id']] = $attribute_exist['value'];
                    }
                    foreach ($secondary_attributes as $secondary_attribute_id => $sec_value) {
                        if (!isset($key_val_attr_existing[$secondary_attribute_id]) || $key_val_attr_existing[$secondary_attribute_id] != $sec_value) {
                            $flag = False;
                            break;
                        }
                    }
                    //match name+value , id+value, of attributes with current secondary attributes array
                    //if all matches, return the id
                    if ($flag == TRUE) {
                        return $sku_result['id'];
                    }
                    //if mismatch found, break
                }
                return False;
            } // select from sku where header_id = header_id and primary attributes
        }
    }

    public function addProductAttribute($product_sku_id, $attribute)
    {
        $insert_array = array('attribute_id' => $attribute['id'],
            'product_sku_id' => $product_sku_id,
            'sku' => (isset($attribute['sku'])) ? $attribute['sku'] : 1,
            'value' => $attribute['value'],
            'created_at' => date('Y-m-d H:i:s'));
        $this->db->insert('product_attribute', $insert_array);
        return $this->db->insert_id();
    }

    public function deleteProductAttribute($product_sku_id, $attribute_id)
    {
        //delete from product attribute
        $this->db->delete('product_attribute', array('product_sku_id' => $product_sku_id, 'attribute_id' => $attribute_id));
        if ($this->db->affected_rows() <= 0) {
            //if not found, then set in product header null
            $attribute = $this->attribute->getById($attribute_id);
            return $this->deletePrimaryAttribute($product_sku_id, $attribute);
        }
    }

    private function deletePrimaryAttribute($product_sku_id, $attribute)
    {
        $update_array = array($attribute['name'] => NULL);
        $this->db->where('id', $product_sku_id);
        $this->db->update('product_sku', $update_array);
        if ($this->db->affected_rows() > 0) {
            return True;
        } else {
            return False;
        }
    }

    public function updateProductAttribute($product_id, $attribute)
    {
    }

    private function updateSecondaryAttribute($product_id, $attribute)
    {
        $insert_array = array('attribute_id' => $attribute['id'],
            'product_sku_id' => $product_id,
            'sku' => $attribute['sku'],
            'value' => $attribute['value'],
            'created_at' => date('Y-m-d H:i:s'));
        $this->db->where('product_sku_id', $product_id, 'attribute_id', $attribute['id']);
        return $this->db->update('product_attribute', $insert_array);
    }

    public function update($id, $name, $description, $tax_category_id, $class_id, $brand_id, $user_id,
                           $attributes = array(), $remove_attributes = array(), $updateAttributes = array(), $mfg_barcode = '', $product_desc_id = '')
    {
        //update product description
        $this->updateDescription($product_desc_id, $name, $description);
        $update_array = compact('product_desc_id', 'tax_category_id', 'class_id', 'brand_id', 'user_id', 'mfg_barcode');
        //create primary attribute update array
        foreach ($updateAttributes as $updateAttribute) {
            if ($updateAttribute['level'] == 1) {
                $update_array[$updateAttribute['name']] = $updateAttribute['value'];
                if ($updateAttribute['sku'] == 1) {
                    $update_array[$updateAttribute['name']] = -99;
                }
            } else {
                $this->updateSecondaryAttribute($id, $updateAttribute);
            }
        }
        foreach ($remove_attributes as $remove_attribute) {
            if ($remove_attribute['level'] == 1) {
                $update_array[$remove_attribute['name']] = NULL;
            } else {
                $this->deleteProductAttribute($id, $remove_attribute['id']);
            }
        }
        foreach ($attributes as $attribute) {
            if ($attribute['level'] == 1) {
                $update_array[$attribute['name']] = $attribute['value'];
            } else {
                $this->addProductAttribute($id, $attribute);
            }
        }
        $this->db->where('id', $id);
        return $this->db->update('product_sku', $update_array);
    }

    private function updateDescription($product_desc_id = -1, $name, $description, $language_id = 1, $url = '')
    {
        if ($name == '') {
            return False;
        }
        if ($product_desc_id == -1) {
            $data = array('name' => $name, 'description' => $description);
            //$this->db->where('');
            $this->db->insert();
            return $this->db->insert_id();
        }
        $update_array = compact('name', 'description', 'language_id', 'url');
        $this->db->where('id', $product_desc_id);
        return $this->db->update('products_description', $update_array);
    }

    public function suggest($term)
    {
        $this->db->select('ps.id as id, pd.name as name, pd.description as description');
        //$this->db->from('product_sku ph');
        //$this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
        //$this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
        //$this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
        $this->db->join('products_header ph', 'ps.header_id = ph.id', 'LEFT');
        $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
        $this->db->like('pd.name', $term);
        $query = $this->db->get('product_sku ps');
        if ($query->num_rows > 0) {
            $result = $query->result_array();
        }
        //enable this section or look for alternate loginc for approximate results
        /*else{
            $this->db->select('ph.id as id, pd.name as name, pd.description as description');
            //$this->db->from('product_sku ph');
            //$this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
            //$this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
            //$this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
            $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
            $this->db->like('pd.description', $term);
            $query = $this->db->get('product_sku ph');
        }*/
        return $result;
    }

    public function getProduct_skuByBarcode($barcode)
    {
        if ($barcode == '') {
            return false;
        }
        $bar = substr($barcode, 0, 11);
        log_message('debug', 'wnated - ' . $bar);
        $sql = "select p.*,p.`name` as `value`,c.vat_percentage as vat from `product_sku` p, `category` c where p.tax_category_id = c.id AND (p.`mfg_barcode` = '{$barcode}' OR p.`custom_barcode` = '{$bar}')";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->row_array();
        }
        return $q;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $product_sku = $this->getSKUSpecificDetails($id);
        $product_header = $this->product_header->getById($product_sku['header_id']);
        $product_header['attributes'] = formatAttributes($product_header['attributes']);
        $all_attributes = array_merge($product_header['attributes'], formatAttributes($this->getSecondaryAttributes($id)), $product_sku['attributes']);
        $product_sku = array_merge($product_sku, $product_header);
        $product_sku['id'] = $id;
        $product_sku['attributes'] = $all_attributes;
        foreach ($all_attributes as $all_att) {
            if ($all_att['name'] == 'price') {
                $product_sku['price'] = ($all_att['value'] != '' && $all_att['value'] >= 0) ? $all_att['value'] : $product_sku['price'];
            }
        }
        //$product_sku['price'] = isset($all_attributes['price']) ? $all_attributes['price'] : '';
        return $product_sku;
    }

    public function getByHeaderId($header_id)
    {
        $products_sku = $this->getSpecificDetailedSKUsByHeaderId($header_id);
        foreach ($products_sku as &$sku) {
            //log_message('error', '#337 in sku model:: -'.print_r($sku));
            if (isset($sku['attributes'])) {
                $sku['attributes'] += formatAttributes($this->getSecondaryAttributes($sku['id']));
            } else {
                $sku['attributes'] = formatAttributes($this->getSecondaryAttributes($sku['id']));
            }
        }
        return $products_sku;
    }

    public function getByAttribute($attribute, $value)
    {
        $products_sku = $this->getSpecificDetailedSKUsByAttribute($attribute, $value);
        foreach ($products_sku as &$sku) {
            //log_message('error', '#337 in sku model:: -'.print_r($sku));
            $sku['attributes'] += formatAttributes($this->getSecondaryAttributes($sku['id']));
        }
        return $products_sku;
    }

    public function deleteById($id)
    {
        // Test of product_sku, if no product_sku then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `product_sku` SET `deleted` = '1' where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getComponentsById($id)
    {
        return array();
    }

    public function getAttributes($term = '')
    {
        $attributes_array = $this->attributes;
        foreach ($attributes_array as $attribute_name) {
            $attribute = array();
            $attribute['id'] = -1;
            $attribute['name'] = $attribute_name;
            $attribute['level'] = 1;
            $attributes[] = $attribute;
        }
        return $attributes;
    }

    public function addDescription($name, $description, $url = '', $language_id = 1)
    {
        $insert_array = array(
            'language_id' => $language_id,
            'name' => $name,
            'description' => $description,
            'url' => $url
        );
        $this->db->insert('products_description', $insert_array);
        $id = $this->db->insert_id();
        return $id;
    }

    public function getAttributesById($id)
    {
        $product_attributes = $this->getPrimaryAttributes($id);
        //extracting secondary attributes
        $sec_attributes = $this->getSecondaryAttributes($id);
        $product_attributes = array_merge($product_attributes, $sec_attributes);
        return $product_attributes;
    }

    private function getPrimaryAttributes($id)
    {
        $this->db->select($this->attributes);
        $query = $this->db->get_where('product_sku', array('id' => $id));
        $product_primary_attributes = $query->row_array();
        return $this->formatPrimaryAttributes($product_primary_attributes);
    }

    private function getSecondaryAttributes($id, $name = 1)
    {
        //$this->db->from("product_attribute pa");
        if ($name == 1) {
            $this->db->select('pa.sku AS sku, pa.product_sku_id AS sku_id, pa.value AS value, a.name as name, a.level as level, a.id as id');
            $this->db->join("attribute a", "pa.attribute_id = a.id");
        } else {
            $this->db->select('pa.sku AS sku, pa.product_sku_id AS sku_id, pa.value AS value, pa.attribute_id as id');
        }
        $query = $this->db->get_where('product_attribute pa', array('product_sku_id' => $id));
        $result = $query->result_array();
        return $result;
    }

    public function getSKUSpecificDetails($id)
    {
        //$select_array = array_merge($this->attributes);
        $this->db->select(array_merge($this->attributes, $this->details));
        $query = $this->db->get_where('product_sku', array('id' => $id));
        $product_primary_attributes = $query->row_array();
        return $this->formatSKU($product_primary_attributes);
    }

    private function formatSKU($product_primary_attributes)
    {
        $product_sku = array();
        $product_sku['attributes'] = array();
        foreach ($this->details as $detail) {
            if (isset($product_primary_attributes[$detail]) && !is_null($product_primary_attributes[$detail]) && $product_primary_attributes[$detail] != '') {
                $product_sku[$detail] = $product_primary_attributes[$detail];
            }
        }
        foreach ($this->attributes as $detail) {
            if (isset($product_primary_attributes[$detail]) && !is_null($product_primary_attributes[$detail]) && $product_primary_attributes[$detail] != '') {
                $product_sku['attributes'][$detail] = $product_primary_attributes[$detail];
            }
        }
        $product_sku['attributes'] = $this->formatPrimaryAttributes($product_sku['attributes']);
        $product_sku['name'] =  isset($product_primary_attributes['prod_name']) ? $product_primary_attributes['prod_name'] : '';
        return $product_sku;
    }

    private function formatPrimaryAttributes($product_primary_attributes)
    {
        $product_attributes = array();
        // extracting primary attributes
        foreach ($product_primary_attributes as $name => $attribute) {
            //$attribute_row = array();
            $attribute_row = $this->attribute->getByName($name);
            if ((!isset($attribute)) || $attribute == '' || is_null($attribute)) {
                continue;
            } elseif ($attribute == '-99' || $attribute == -99 || $attribute == 'sku') {
                $attribute_row['sku'] = 1;
            } else {
                $attribute_row['sku'] = 0;
            }
            //because of attributes being primary, the id will be set to -1
            //$attribute_row['id'] = -1;
            //$attribute_row['name'] = $name;
            //$attribute_row['level'] = 1;
            $attribute_row['value'] = $attribute;
            $product_attributes[] = $attribute_row;
        }
        return $product_attributes;
    }

    private function getPrimaryAttributesName($attributes)
    {
        $primary_attribute_names = array();
        if ($attributes['level'] == 1) {
            $primary_attribute_names[] = $attributes['name'];
        }
    }

    private function getSpecificDetailedSKUsByHeaderId($header_id)
    {
      // debugbreak();
        $select_array = array_merge($this->attributes, $this->details); 
        $this->db->select($select_array);
        $query = $this->db->get_where('product_sku', array('header_id' => $header_id));
        $same_header_sku = $query->result_array();
        $return = array();
        foreach ($same_header_sku as &$single) {
           $single['prod_name'] = '';
            $single['prod_name'] = $this->product_header->getNamebyId($header_id);
            $return[] = $this->formatSKU($single);
        }
        return $return;
    }

    private function getSpecificDetailedSKUsByAttribute($name, $value)
    {
        $select_array = array_merge($this->attributes, $this->details);
        $this->db->select($select_array);
        $query = $this->db->get_where('product_sku', array($name => $value));
        $same_attribute_sku = $query->result_array();
        $return = array();
        foreach ($same_attribute_sku as $single) {
            $return[] = $this->formatSKU($single);
        }
        return $return;
    }

    public function delete($id)
    {
        $this->db->trans_begin();
        //TODO check for product sku entries
        $this->db->delete('product_sku', array('id' => $id));
        $this->db->delete('product_attribute', array('product_sku_id' => $id));
        /*        if ($this->db->affected_rows() <= 0) {
            $this->db->rollback();
            return false;
        }*/
        $this->db->trans_commit();
        return $id;
    }
}