<?php
/**
 * File Name: product_header_model.php
 * Author: Rajat
 * Date: 4/16/12
 * Time: 6:53 PM
 */
/*idbigint(20) unsigned NOT NULL
product_desc_idbigint(20) unsigned NULL
modelvarchar(50) NULL
sizevarchar(10) NULL
colorvarchar(20) NULL
volumedecimal(5,3) NULL
volume_unitenum('ml','l') NULL
weightdecimal(5,3) NULL
weight_unitenum('g','kg') NULL
brand_idint(11) NULL
variantvarchar(30) NULL
designvarchar(30) NULL
genderenum('M','F','U') NULL
date_addeddatetime NULL
tax_category_idint(11) NULL
class_idint(11) NULL
extra_attr_apptinyint(1) NULL
extra_jsontext NULL
mfg_barcodevarchar(50) NULL
deletedtinyint(1) NULL*/
/******************************************
//IMPORTANT ::  To make any attribute move_to_sku, its value will be -99 , '-99'
 ***********************************************/
class Product_header_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->attributes = array('model', 'size', 'color', 'volume', 'volume_unit', 'weight', 'weight_unit', 'variant', 'design', 'gender', 'price');
        $this->load->model('Attribute_Model', 'attribute');
        $this->load->helper('utils');
    }

    public function add($name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes = array(), $mfg_barcode = '', $product_desc_id = '')
    {
        if ($name == '' || $tax_category_id == '' || $brand_id == '' || $user_id == '') {
            return false;
        }
        $this->db->trans_begin();
        if (trim($mfg_barcode) != '') {
            $q = $this->db->query("SELECT * FROM `product_header` WHERE `mfg_barcode` = ?", array($mfg_barcode));
            if ($q->num_rows() > 0) {
                $res = $q->row_array();
                if ($res['deleted'] == 0) {
                    log_message('error', 'MFG BARCODE Duplication not allowed!!');
                    return false;
                } else {
                    $this->delete($res['id']);
                    return $this->add($name, $description, $tax_category_id, $class_id, $brand_id, $user_id, $attributes, $mfg_barcode, $product_desc_id);
                }
            }
        }
        if ($product_desc_id == '') {
            //insert into product description first
            $product_desc_id = $this->addDescription($name, $description);
        }
        //foreach attributes, needs to be done
        $level_3_att = array();
        $level_1_att_names = array();
        foreach ($attributes as &$attribute_for_loop) {
            if ($attribute_for_loop['level'] == 1) {
                if ($attribute_for_loop['sku'] == 1) {
                    ${$attribute_for_loop['name']} = -99;
                } else {
                    ${$attribute_for_loop['name']} = $attribute_for_loop['value'];
                }
                $level_1_att_names[] = $attribute_for_loop['name'];
                //TODO this is to fix the weight unit, volume unit things for now, need to do it properly later with binding/grouping of attributes
                if ($attribute_for_loop['name'] == 'weight' && !in_array('weight_unit', $level_1_att_names)) {
                    $level_1_att_names[] = 'weight_unit';
                    $weight_unit = 'g';
                } elseif ($attribute_for_loop['name'] == 'volume' && !in_array('volume_unit', $level_1_att_names)) {
                    $level_1_att_names[] = 'volume_unit';
                    $volume_unit = 'ml';
                }
            } elseif ($attribute_for_loop['level'] == 3) {
                $level_3_att[$attribute_for_loop['name']] = $attribute_for_loop['value'];
            } else {
                $extra_attr_app = 1;
            }
        }
        $date_added = date('Y-m-d H:i:s');
        $extra_json = json_encode($level_3_att);
        //insert product header, with level 3 attributes if any
        $temp_array = array('extra_json', 'product_desc_id', 'brand_id', 'class_id', 'tax_category_id', 'user_id', 'mfg_barcode', 'extra_attr_app', 'date_added');
        $insert_array = compact(array_merge($temp_array, $level_1_att_names));
        $this->db->insert('product_header', $insert_array);
        $product_id = $this->db->insert_id();
        //insert into product attribute then with the above id
        foreach ($attributes as $attribute) {
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

    public function addProductAttribute($product_id, $attribute)
    {
        $insert_array = array('attribute_id' => $attribute['id'],
            'product_header_id' => $product_id,
            'sku' => $attribute['sku'],
            'value' => $attribute['value'],
            'created_at' => date('Y-m-d H:i:s'));
        $this->db->insert('product_attribute', $insert_array);
        return $this->db->insert_id();
    }

    public function deleteProductAttribute($product_header_id, $attribute_id)
    {
        //delete from product attribute
        $this->db->delete('product_attribute', array('product_header_id' => $product_header_id, 'attribute_id' => $attribute_id));
        if ($this->db->affected_rows() <= 0) {
            //if not found, then set in product header null
            $attribute = $this->attribute->getById($attribute_id);
            return $this->deletePrimaryAttribute($product_header_id, $attribute);
        }
    }

    private function deletePrimaryAttribute($product_header_id, $attribute)
    {
        $update_array = array($attribute['name'] => NULL);
        $this->db->where('id', $product_header_id);
        $this->db->update('product_header', $update_array);
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
            'product_header_id' => $product_id,
            'sku' => $attribute['sku'],
            'value' => $attribute['value'],
            'created_at' => date('Y-m-d H:i:s'));
        $this->db->where('product_header_id', $product_id, 'attribute_id', $attribute['id']);
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
        //create total update array - $update_array
        //update primary_attributes
        //update class/category/brand/name/description
        $this->db->where('id', $id);
        $result = $this->db->update('product_header', $update_array);
        if ($result) {
            return $id;
        } else {
            return false;
        }
        //update secondary attributes
        //add attributes
        //remove removeAttributes
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

    public function suggest($term, $details = 1)
    {
        if ($term == '') {
            return false;
        }
      
        if ($details === 0) {
            $product_headers = $this->suggest_min($term);
            return $product_headers;
        }
        $product_headers = array();
        $suggested_desc_array = $this->getSuggestDescriptionId($term);
        //debugbreak();
        foreach ($suggested_desc_array as $desc_id_array) {
            $product_headers = array_merge($product_headers, $this->getByDescriptionId($desc_id_array['id']));
        }

        return $product_headers;
    }

    public function suggest_min($term)
    {
       //die($term);
       $where = "";
       $limit = 10;
       if(!empty($term))
       {
           $where.="pd.name like '".$term."%'";
       }
        $this->db->select('ph.id as id, pd.name as name, pd.description as description');        
        $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');       
        if(!empty($where))
        {
            $this->db->where($where);
        }
        $this->db->limit($limit);
        $query = $this->db->get('product_header ph');       
        $result = array();
        if ($query->num_rows > 0) {
            $result = $query->result_array();
        }
        
        return $result;
    }

    private function getHeaderIdsByDescId($product_desc_id)
    {
        $this->db->select('id');
        $q = $this->db->get_where('product_header', array('product_desc_id' => $product_desc_id));
        return $q->result_array();
    }

    private function getByDescriptionId($desc_id)
    {
       //debugbreak();
        if ($desc_id == '') {
            return array();
        }
        $product_headers = $this->getAbstractProductHeader('', $desc_id);
        foreach ($product_headers as &$product_header) {
            $product_header['attributes'] = $this->getAttributesById($product_header['id']);
        }
        return $product_headers;
    }

    private function getSuggestDescriptionId($term)
    {
        $where = "";
        $limit = 10;
        if(!empty($term))
        {
            $where.="name LIKE '$term%'";
        }
        $this->db->select('id');
        //$this->db->like('name', $term);
        if(!empty($where))
        {
            $this->db->where($where);
        }
       //debugbreak();
        $this->db->limit($limit);
        $q = $this->db->get('products_description');
        return $q->result_array();
    }

    private function getSuggestDescription($term)
    {
        $this->db->select('id, name, description');
        $this->db->like('name', $term);
        $q = $this->db->get('products_description');
        return $q->result_array();
    }

    public function getByMfgBarcode($barcode, $formatted = 0)
    {
        if ($barcode == '') {
            return false;
        }
        $product_header = $this->getAbstractProductHeader('', '', $barcode);
        //TODO this shouldn't ideally happen, but in case some business allows products to have same barcode , this part needs to be developed to handle that
        if (is_array($product_header) && count($product_header) > 0) {
            $product_header = $product_header[0];
            $product_header['attributes'] = ($formatted == 1) ? formatAttributes($this->getAttributesById($product_header['id'])) : $this->getAttributesById($product_header['id']);
        }
        return $product_header;
    }

    public function getById($id, $formatted = 0)
    {
        if ($id == '') {
            return false;
        }
        $product_header = $this->getAbstractProductHeader($id);
        $product_header['attributes'] = ($formatted == 1) ? formatAttributes($this->getAttributesById($id)) : $this->getAttributesById($id);
        return $product_header;
    }

    public function getAbstractProductHeader($id = '', $desc_id = '', $mfg_barcode = '')
    {
        if ($id != '') {
            $this->db->select('ph.id as id, pd.name as name, pd.id as desc_id,  pd.description as description, b.id as brand_id,' .
                ' b.name as brand, c.name as tax_category, c.id as category_id, c.vat_percentage as vat_percentage, cl.id as class_id, cl.name as class, extra_json as details, ph.mfg_barcode as header_mfg_barcode');
            //$this->db->from('product_header ph');
            $this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
            $this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
            $this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
            $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
            $query = $this->db->get_where('product_header ph', array('ph.id' => $id, 'ph.deleted' => 0));
            $result = $query->row_array();
            return $result;
        } elseif ($desc_id != '') {
            $this->db->select('ph.id as id, pd.name as name, pd.id as desc_id,  pd.description as description, b.id as brand_id,' .
                ' b.name as brand, c.name as tax_category, c.id as category_id, c.vat_percentage as vat_percentage, cl.id as class_id, cl.name as class, extra_json as details, ph.mfg_barcode as header_mfg_barcode');
            //$this->db->from('product_header ph');
            $this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
            $this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
            $this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
            $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
            //$this->db->like('pd.name', $term);
            $query = $this->db->get_where('product_header ph', array('ph.product_desc_id' => $desc_id, 'ph.deleted' => 0));
            $result = $query->result_array();
            return $result;
        } elseif ($mfg_barcode != '') {
            $this->db->select('ph.id as id, pd.name as name, pd.id as desc_id,  pd.description as description, b.id as brand_id,' .
                ' b.name as brand, c.name as tax_category, c.id as category_id, c.vat_percentage as vat_percentage, cl.id as class_id, cl.name as class, extra_json as details, ph.mfg_barcode as header_mfg_barcode');
            //$this->db->from('product_header ph');
            $this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
            $this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
            $this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
            $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
            //$this->db->like('ph.mfg_barode', $mfg_barcode);
            $query = $this->db->get_where('product_header ph', array('ph.mfg_barcode' => $mfg_barcode, 'ph.deleted' => 0));
            $result = $query->result_array();
            if ($query->num_rows() == 0) {
                if (substr($mfg_barcode, 0, 1) == '0') {
                    $result = $this->getAbstractProductHeader('', '', substr($mfg_barcode, 1));
                }
            }
            return $result;
        } else {
            return False;
        }
    }

    public function getProductHeaderDetails($id)
    {
        // this function will return tax percentage and all
        $this->db->select('ph.id as id, pd.name as name, pd.description as description, b.name as brand, c.name as tax_category, cl.name as class, extra_json as details');
        //$this->db->from('product_header ph');
        $this->db->join('brand b', 'b.id = ph.brand_id', 'LEFT');
        $this->db->join('class cl', 'cl.id = ph.class_id', 'LEFT');
        $this->db->join('category c', 'c.id = ph.tax_category_id', 'LEFT');
        $this->db->join('products_description pd', 'pd.id = ph.product_desc_id', 'LEFT');
        $query = $this->db->get_where('product_header ph', array('ph.id' => $id));
        $result = $query->row_array();
        return $result;
    }

    public function deleteById($id)
    {
        // Test of product_header, if no product_header then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE `product_header` SET `deleted` = '1' where `id` = ?", array($r['id']));
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
        $attributes_array = $this->attribute->getPrimaryAttributes();
        /*     if any processing required in this array, do it in this loop
           foreach ($attributes_array as &$attribute_name) {
            //$attribute = array();
            //$attribute['id'] = -1;
            //$attribute['name'] = $attribute_name;
            //$attribute['level'] = 1;
            //$attributes[] = $attribute;
        }*/
        return $attributes_array;
    }

    public function addDescription($name, $description, $url = '', $language_id = 1)
    {
        $description = trim($description);
        $q = $this->db->query("SELECT * FROM `products_description` WHERE `name` = ? AND `description` = ?", array($name, $description));
        if ($q->num_rows() > 0) {
            $res = $q->row_array();
            return $res['id'];
        }
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
        $detailed_primary_attributes = $this->attribute->getAllPrimaryAttributes(0);
        $p_attributes = array();
        foreach ($detailed_primary_attributes as $p) {
            $p_attributes[] = $p['name'];
        }
        $this->db->select($p_attributes);
        $query = $this->db->get_where('product_header', array('id' => $id));
        $product_primary_attributes = $query->row_array();
        $product_attributes = array();
        // extracting primary attributes
        $temporary_id = -1;
        foreach ($detailed_primary_attributes as $p) {
            $attribute_row = array();
            if ((!isset($product_primary_attributes[$p['name']])) || $product_primary_attributes[$p['name']] == '' || is_null($product_primary_attributes[$p['name']])) {
                continue;
            } elseif ($product_primary_attributes[$p['name']] == '-99' || $product_primary_attributes[$p['name']] == -99 || $product_primary_attributes[$p['name']] == 'sku') {
                $attribute_row['sku'] = 1;
            } else {
                $attribute_row['sku'] = 0;
            }
            $attribute_row['id'] = $p['id'];
            $attribute_row['name'] = $p['name'];
            $attribute_row['level'] = 1;
            $attribute_row['display_name'] = $p['display_name'];
            $attribute_row['value'] = $product_primary_attributes[$p['name']];
            $product_attributes[] = $attribute_row;
        }
        /******************************* previous code before using display names
         *         foreach ($product_primary_attributes as $name => $attribute) {
        $attribute_row = array();
        if ((!isset($attribute)) || $attribute == '' || is_null($attribute)) {
        continue;
        } elseif ($attribute == '-99' || $attribute == -99 || $attribute == 'sku') {
        $attribute_row['sku'] = 1;
        } else {
        $attribute_row['sku'] = 0;
        }
        //because of attributes being primary, the id will be set to -1
        $attribute_row['id'] = $temporary_id--;
        $attribute_row['name'] = $name;
        $attribute_row['level'] = 1;
        $attribute_row['value'] = $attribute;
        $product_attributes[] = $attribute_row;
        }*/
        //extracting secondary attributes
        $sec_attributes = $this->getSecondaryAttributes($id);
        $product_attributes = array_merge($product_attributes, $sec_attributes);
        return $product_attributes;
    }

    private function getSecondaryAttributes($id)
    {
        $this->db->select('pa.sku AS sku, pa.product_sku_id AS sku_id, pa.value AS value, a.name as name, a.level as level, a.id as id, a.display_name as display_name');
        //$this->db->from("product_attribute pa");
        $this->db->join("attribute a", "pa.attribute_id = a.id");
        $query = $this->db->get_where('product_attribute pa', array('product_header_id' => $id));
        $result = $query->result_array();
        return $result;
    }

    public function getTrackingLevel($id)
    {
        $this->db->select('tracking_level');
        $q = $this->db->get_where('product_header', array('id' => $id));
        $row = $q->row_array();
        return $row['tracking_level'];
        // tracking level configuration to be implemented later, right now
        // level 1 means basic product (No attribute tracking, no printed MRP)
        /*level 2 means attribute level tracking , no tracking of vendors and all*/
        //level 3 means custom barcode, detailed tracking
    }

    public function delete($id)
    {
        //start transaction
        $this->db->trans_begin();
        //TODO check for product sku entries
        //delete product header table row
        $this->db->delete('product_header', array('id' => $id));
        //delete product attribute row
        $this->db->delete('product_attribute', array('product_header_id' => $id));
        //end transaction
        /*        if ($this->db->affected_rows() <= 0) {
            $this->db->rollback();
            return false;
        }*/
        $this->db->trans_commit();
        return $id;
    }
    public function getNamebyId($id)
    {
      $data  = array();
      $data = $this->db->query("SELECT pd.name from product_header ph LEFT JOIN products_description pd on pd.id = ph.product_desc_id where ph.id = ?",array($id))->row_array();
      return $data['name'];
    }
}
