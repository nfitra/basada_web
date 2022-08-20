<?php

class Pengeluaran_model extends CI_Model
{
    private $table = "pengeluaran";

    function get_pengeluaran()
    {
        $this->db->order_by('pk_bulan',"DESC");
        return $this->db->get($this->table)->result();
    }

    function get_data($date, $date2)
    {
        $this->db->join('unit as u','u.fk_auth = pengeluaran.fk_admin', 'left');
        $this->db->where('pk_bulan >=', $date);
        $this->db->where('pk_bulan <=', $date2);
        $this->db->order_by('pk_bulan',"DESC");
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        $this->db->order_by('pk_bulan',"DESC");
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_unit($where)
    {
        $this->db->select('pengeluaran.*, u.un_name');
        $this->db->join('unit as u','u.fk_auth = pengeluaran.fk_admin');
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_pengeluaran($dataUnit)
    {
        return $this->db->insert($this->table, $dataUnit);
    }

    function update_pengeluaran($dataUnit, $where)
    {
        return $this->db->update($this->table, $dataUnit, $where);
    }

    function delete_pengeluaran($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
