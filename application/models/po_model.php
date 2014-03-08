<?php
class Po_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function create($user_id, $vendor_id, $vendor_person_id, $total_amount, $payment_term, $payment_days, $payment_date, $po_date, $delivery_date, $full_json)
    {
        if ($vendor_id <= 0 || $vendor_id == '') {
            return false;
        }
        $sql = "insert into `purchase_order` (`user_id`, `vendor_id`, `vendor_person_id`, `total_amount`, `payment_term`, `payment_days`, `payment_date`, `po_date`, `delivery_date`, `full_json`) values (?, ?, ?, ?, ?, ?, STR_TO_DATE('$payment_date', '%m/%d/%Y'), STR_TO_DATE('$po_date', '%m/%d/%Y'), STR_TO_DATE('$delivery_date', '%m/%d/%Y'), ?)";
        $this->db->query($sql, array($user_id, $vendor_id, $vendor_person_id, $total_amount, $payment_term, $payment_days, $full_json));
        return $this->db->insert_id();
    }

    public function addItem($po_id, $item_type, $item_specific_id, $quantity, $price, $price_type = 'grn_date', $branch_id = 1, $full_jason = '', $weight = 0, $attributes = array())
    {
        if ($po_id <= 0 || $po_id == '') {
            return false;
        }
        $sql = "insert into `purchase_order_items` (`purchase_order_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`,`price`, `price_type`, `branch_id`, `full_json`) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, array($po_id, $item_type, $item_specific_id, $quantity, $weight, $price, $price_type, $branch_id, $full_jason));
        $po_item_id = $this->db->insert_id();
        $this->addPOProductAttributes($po_item_id, $attributes);
        return $po_item_id;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `purchase_order` where `id` = ?", array($id));
        return $q->row_array();
    }

    private function addPOProductAttributes($po_item_id, $attributes = array())
    {
        // add attributes to po_product_attribute
        foreach ($attributes as $attribute) {
            if ($attribute['read_only'] == 0) {
                $attribute_id = $attribute['id'];
                $attribute_name = $attribute['name'];
                $value = $attribute['value'];
                $level = $attribute['level'];
                $this->addPOProductAttribute($po_item_id, $attribute_id, $attribute_name, $value, $level);
            }
        }
        return;
    }

    private function addPOProductAttribute($purchase_order_items_id, $attribute_id, $attribute_name, $value, $level, $attribute_unit_id = 0, $criticality = 2)
    {
        $created_at = date('Y-m-d H:i:s');
        $insert_array = compact("purchase_order_items_id", "attribute_id", "value", "attribute_unit_id", "created_at");
        $q = $this->db->insert('po_product_attribute', $insert_array);
        return $this->db->insert_id();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("delete from `purchase_order` where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getItems($id)
    {
        if ($id == '') {
            return false;
        }
        $po_items = array();
        $q = $this->db->query("SELECT * FROM `purchase_order_items` WHERE `purchase_order_id` = ?", array($id));
        if ($q->num_rows() > 0) {
            $po_items = $q->result_array();
        }
        foreach ($po_items as &$po_item) {
            $po_item['attributes'] = $this->getPOProductAttributes($po_item['id']);
        }
        return $po_items;
    }

    private function getPOProductAttributes($po_item_id)
    {
        $this->db->select('ppa.attribute_id as id, a.name as name, a.display_name as display_name, ppa.value as value, a.criticality as criticality, a.level as level');
        $this->db->join("attribute a", "ppa.attribute_id = a.id");
        $q = $this->db->get_where('po_product_attribute ppa', array('purchase_order_items_id' => $po_item_id));
        return $q->result_array();
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `purchase_order`");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function getVendorByID($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("SELECT v.`id`, v.`company_name`, v.`address`, v.`main_person_name`, v.`mobile`, v.`phone1`, v.`phone2` FROM
                                   `purchase_order` po, `vendors` v 
                                   WHERE po.`id` = '{$id}' AND po.`vendor_id` = v.`id` ");
        if ($q->num_rows() <= 0) {
            return false;
        }
        return $q->row_array();
    }
}