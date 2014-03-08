<?php
/**
 * File Name: grn_model.php
 * Author: Rajat
 * Date: 3/15/12
 * Time: 7:08 PM
 */
class Grn_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function create($po_id, $user_id, $vendor_id, $dated, $full_json = 0)
    {
        if ($vendor_id <= 0 || $vendor_id == '') {
            return false;
        }
        $sql = "insert into `product_receive_note` (`purchase_order_id`, `user_id`, `vendor_id`, `dated`, `extra_json`) values (?, ?, ?, ?, ?)";
        $this->db->query($sql, array($po_id, $user_id, $vendor_id, $dated, $full_json));
        return $this->db->insert_id();
    }

    public function addItem($grn_id, $item_entity_id, $item_specific_id, $quantity, $weight, $purchase_price, $rate = 0, $branch_id = 1)
    {
        if ($grn_id <= 0 || $grn_id == '') {
            return false;
        }
        if ($rate == 0) {
            $rate = $purchase_price;
        }
        $sql = "insert into `product_receive_note_items` (`product_receive_note_id`, `item_entity_id`, `item_specific_id`, `quantity`, `weight`, `rate`, `purchase_price`, `branch_id`) values (?,?, ?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, array($grn_id, $item_entity_id, $item_specific_id, $quantity, $weight, $rate, $purchase_price, $branch_id));
        return $this->db->insert_id();
    }

    public function getById($id, $items = 0)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `product_receive_note` where `id` = ?", array($id));
        $grn = $q->row_array();
        $grn['items'] = array();
        if ($items == 1) {
            $grn['items'] = $this->getItems($id);
        }
        return $grn;
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("delete from `product_receive_note` where `id` = ?", array($r['id']));
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
        $q = $this->db->query("SELECT * FROM `product_receive_note_items` WHERE `product_receive_note_id` = ?", array($id));
        if ($q->num_rows() > 0) {
            $grn_items = $q->result_array();
        }
        return $grn_items;
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `product_receive_note`");
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
                                   `product_receive_note` po, `vendors` v
                                   WHERE po.`id` = '{$id}' AND po.`vendor_id` = v.`id` ");
        if ($q->num_rows() <= 0) {
            return false;
        }
        return $q->row_array();
    }

    public function createPurchaseReturn($user_id, $grn_id = 0, $amount = 0, $full_json = '')
    {
        //returns purchase return ID
        $created_at = date('Y-m-d H:i:s');
        $sql = "INSERT INTO purchase_return (user_id, refund_grn_id, created_at, amount, full_json)
						VALUES ('{$user_id}', '{$grn_id}','{$created_at}','{$amount}', '{$full_json}')";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function addItemToPurchaseReturn($purchase_return_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $final_amount, $branch_id)
    {
        // returns true(ID) on success, false on failure
        $sql = "insert into `purchase_return_item`(`purchase_return_id`, `item_entity_id`, `item_specific_id`, `quantity`, `price`, `vat`, `final_amount`, `branch_id`) values (?,?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($purchase_return_id, $item_entity_id, $item_specific_id, $quantity, $price, $vat, $final_amount, $branch_id));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function usePurchaseReturnAmount($id, $grn_id, $amount)
    {
        $sql = "UPDATE purchase_return SET used='1', used_grn_id='{$grn_id}', used_amount='{$amount}'
					WHERE id='{$id}'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function redeemPurchaseReturn($purchase_return_id, $grn_id)
    {
        $amount = $this->getCreditNoteAmount($purchase_return_id);
        if ($amount > 0) {
            $this->useCreditNote($purchase_return_id, $grn_id, $amount);
        }
        return $amount;
    }

    public function getPurchaseReturnAmount($purchase_return_id)
    {
        $this->db->select('amount, used_amount');
        $amount = $this->db->get_where('purchase_return', array('id' => $purchase_return_id))->row_array();
        $amount = $amount['amount'] - $amount['used_amount'];
        return $amount;
    }

    public function updateItemPurchaseReturn($grn_id, $item_id, $returned_qty = 0)
    {
        $sql = "UPDATE product_receive_note_items SET `quantity_returned` = {$returned_qty}
					WHERE id='{$item_id}' AND bill_id='{$grn_id}'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function getDetailsByPurchaseReturnId($purchase_return_id)
    {
        $sql = "SELECT *
					FROM  purchase_return
					LEFT JOIN product_receive_note ON purchase_return.refund_grn_id = product_receive_note.id
					WHERE purchase_return.id = '{$purchase_return_id}'
					LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function getPurchaseReturn($purchase_return_id)
    {
        $sql = "SELECT *
					FROM  purchase_return
					WHERE purchase_return.id = '{$purchase_return_id}'
					LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function finalizePurchaseReturn($id, $amount, $full_json = '')
    {
        $update_data = compact('amount', 'full_json');
        $this->db->where('id', $id);
        $this->db->update('purchase_return', $update_data);
        return $id;
    }
}
