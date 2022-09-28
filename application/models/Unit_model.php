<?php

class Unit_model extends CI_Model
{
    private $table = "unit";

    function get_unit()
    {
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        $this->db->join("auth", "auth.email = unit.fk_auth");
        $this->db->join("roles", "roles._id = auth.fk_role");
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_unit($dataUnit)
    {
        return $this->db->insert($this->table, $dataUnit);
    }

    function update_unit($dataUnit, $where)
    {
        return $this->db->update($this->table, $dataUnit, $where);
    }

    function get_total()
    {
        return $this->db->get($this->table)->num_rows();
    }

    function delete_unit($where)
    {
        return $this->db->delete($this->table, $where);
    }

    function get_unit_by_email($where)
    {
        $this->db->join('auth', ' auth.email = unit.fk_auth');
        $this->db->join('roles', ' roles._id = auth.fk_role');
        $this->db->where("auth.isActive = 1");
        return $this->db->get_where($this->table, $where)->result();
    }
}
