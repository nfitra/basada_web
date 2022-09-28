<?php

class Mutasi_model extends CI_Model
{
    public $table = "mutasi";

    function create_mutasi($dataMutasi)
    {
        return $this->db->insert($this->table, $dataMutasi);
    }
    
    function update_mutasi($dataMutasi, $where)
    {
        return $this->db->update($this->table, $dataMutasi, $where);
    }
    
    function get_mutasi()
    {
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        return $this->db->get_where($this->table,$where)->result();
    }
}
?>