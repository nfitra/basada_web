<?php

class Pemasukan_model extends CI_Model
{
    private $table = "pemasukan";

    function get_pemasukan()
    {
        $this->db->select('pemasukan.*, j_name');
        $this->db->join('jenis_sampah as j', 'fk_garbage = j._id');
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        $this->db->select('pemasukan.*, j_name, p.p_nama');
        $this->db->join('jenis_sampah as j', 'fk_garbage = j._id');
        $this->db->join('pelapak as p', 'fk_pelapak = p._id');
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_data($date, $date2)
    {
        $this->db->select('pemasukan.*, j.j_name');
        $this->db->join('jenis_sampah as j', 'fk_garbage = j._id', 'left');
        $this->db->where("pm_created_at >= ", $date);
        $this->db->where("pm_created_at <= ", $date2);
        $this->db->order_by("pm_created_at","DESC");
        return $this->db->get($this->table)->result();
    }

    function get_transaksi()
    {
        $this->db->join('jenis_sampah as j', 'fk_garbage = j._id');
        $this->db->join('pelapak as p', 'fk_pelapak = p._id');
        return $this->db->get($this->table)->result();
    }

    function create_pemasukan($dataUnit)
    {
        return $this->db->insert($this->table, $dataUnit);
    }

    function update_pemasukan($dataUnit, $where)
    {
        return $this->db->update($this->table, $dataUnit, $where);
    }

    function delete_pemasukan($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
