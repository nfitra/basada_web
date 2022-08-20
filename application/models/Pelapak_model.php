<?php

class Pelapak_model extends CI_Model
{
    public $table = 'pelapak';

    function get_pelapak()
    {
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_pelapak($dataPelapak)
    {
        return $this->db->insert($this->table, $dataPelapak);
    }

    function update_pelapak($dataPelapak, $where)
    {
        return $this->db->update($this->table, $dataPelapak, $where);
    }

    function delete_pelapak($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
