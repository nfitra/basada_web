<?php

class Nasabah_model extends CI_Model
{
    public $table = 'nasabah';

    function cek_email($email)
    {
        $where = array('fk_auth' => $email);
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_nasabah()
    {
        $this->db->where("isExist", "1");
        $this->db->order_by("n_created_at","DESC");
        return $this->db->get($this->table)->result();
    }

    function get_data($date, $date2, $status)
    {
        $this->db->where('n_created_at >=', $date);
        $this->db->where('n_created_at <=', $date2);
        $this->db->where("isExist", "1");
        $this->db->order_by('n_created_at',"DESC");
        if ($status != "Semua")
            $this->db->where('n_status', $status);
        return $this->db->get($this->table)->result();
    }

    function balance($amount, $where, $op)
    {
        if ($op == "+")
            $this->db->set("n_balance", "n_balance + $amount", FALSE);
        else
            $this->db->set("n_balance", "n_balance - $amount", FALSE);
        $this->db->where($where);
        return $this->db->update($this->table);
    }

    function cek_balance($where)
    {
        $this->db->select("n_balance");
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_list_nasabah()
    {
        $this->db->order_by("n_name", "ASC");
        $this->db->where("isExist", "1");
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        $this->db->where("isExist", "1");
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_nasabah($dataNasabah)
    {
        return $this->db->insert($this->table, $dataNasabah);
    }

    function update_nasabah($dataNasabah, $where)
    {
        return $this->db->update($this->table, $dataNasabah, $where);
    }

    function delete_nasabah($where)
    {
        return $this->db->delete($this->table, $where);
    }

    function get_total()
    {
        return $this->db->get($this->table)->num_rows();
    }
}
