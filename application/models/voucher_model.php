<?php
class Voucher_Model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function add($user_id, $name, $min_value, $max_value, $multiple_of, $description, $value_set = '')
    {
        //$value_set = json_encode($value_set);
        $sql = "insert into `voucher_config` (`user_id`,  `name`, `min_value`, `max_value`, `multiple_of`, `description`, `value_set`)" .
            " values (?,?,?,?,?,?,?)";
        $r = $this->db->query($sql, array($user_id, $name, $min_value, $max_value, $multiple_of, $description, $value_set));
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        }
        return false;
    }

    public function update($id, $user_id, $name, $min_value, $max_value, $multiple_of, $description, $value_set = '')
    {
        //$value_set = json_encode($value_set);
        $sql = "UPDATE `voucher_config` SET (`user_id`,  `name`, `min_value`, `max_value`, `multiple_of`, `description`, `value_set`)" .
            " values (?,?,?,?,?,?,?) WHERE `id` = ?";
        $r = $this->db->query($sql, array($user_id, $name, $min_value, $max_value, $multiple_of, $description, $value_set, $id));
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function getById($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `voucher_config` where `id` = ?", array($id));
        return $q->row_array();
    }

    public function getItems($id)
    {
        if ($id == '') {
            return false;
        }
        $q = $this->db->query("select * from `voucher` where `voucher_config_id` = ?", array($id));
        return $q->result_array();
    }

    public function deleteById($id)
    {
        // Test of products, if no products then only allow deleting
        $r = $this->getById($id);
        if (isset($r['id'])) {
            $q = $this->db->query("UPDATE voucher_config SET `deleted` = 1 where `id` = ?", array($r['id']));
            if ($this->db->affected_rows() <= 0) {
                return false;
            }
        }
        return $r;
    }

    public function getAll()
    {
        $q = $this->db->query("select * from `voucher_config`");
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function suggest($term)
    {
        if ($term == '') {
            return false;
        }
        $sql = "SELECT b.*, CONCAT(`c`.`fname`,' ', `c`.`lname`) c_name , `c`.`phone` c_phone from `customers` c, `voucher` b
			WHERE  
				`c`.`id` = `b`.`customer_id` 
			AND 
				(
				`c`.`fname` like '%" . $term . "%'
				OR `b`.`id` like '%" . $term . "%'
				OR `c`.`lname` like '%" . $term . "%'
				OR `c`.`phone` like '%" . $term . "%'
				)
			";
        $q = $this->db->query($sql);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return false;
    }

    public function createVoucher($voucher_config_id, $user_id, $amount = 0, $manager_user_id = 0, $comment = '')
    {
// code = md5('rajat.biz' . mt_rand(9999999999, mt_getrandmax()));
        $code = md5('rajat.biz' . mt_rand(10000, mt_getrandmax()) . microtime());
        $sql = "INSERT INTO voucher (user_id, code, voucher_config_id, amount, manager_user_id, comment)
						VALUES ('{$user_id}', '{$code}', '{$voucher_config_id}', '{$amount}', '{$manager_user_id}', '{$comment}')";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return -1;
        }
    }

    public function useVoucher($id, $bill_id, $amount)
    {
        $sql = "UPDATE voucher SET used='1', used_bill_id='{$bill_id}', used_amount='{$amount}'
					WHERE id='{$id}'";
        $this->db->query($sql);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function redeemVoucher($voucher_id, $bill_id)
    {
        $amount = $this->getCreditNoteAmount($voucher_id);
        if ($amount > 0) {
            $this->useCreditNote($voucher_id, $bill_id, $amount);
        }
        return $amount;
    }

    public function getVoucherAmount($voucher_id)
    {
        $this->db->select('amount, used_amount');
        $amount = $this->db->get_where('voucher', array('id' => $voucher_id))->row_array();
        $amount = $amount['amount'] - $amount['used_amount'];
        return $amount;
    }

    public function getDetailsByVoucherId($voucher_id)
    {
        $sql = "SELECT *
					FROM  credit_note
					LEFT JOIN voucher ON credit_note.refund_voucher_id = voucher.id
					WHERE credit_note.id = '{$voucher_id}'
					LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function getVoucher($voucher_id)
    {
        $sql = "SELECT *
					FROM  voucher
					WHERE voucher.id = '{$voucher_id}'
					LIMIT 0 , 30";
        $res = $this->db->query($sql);
        if ($res->num_rows() > 0) {
            return $res->row_array();
        } else {
            return '';
        }
    }

    public function finalizeVoucher($id, $amount, $manager_user_id = 0, $comment = '')
    {
        $update_data = compact('amount', 'manager_user_id', 'comment');
        $this->db->where('id', $id);
        $this->db->update('voucher', $update_data);
        return $id;
    }
}