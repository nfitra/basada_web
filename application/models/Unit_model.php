<?php

class Unit_model extends CI_Model
{
    private $table = "unit";

    function check_email($email)
    {
        $where = array('fk_auth' => $email);
        return $this->db->get_where($this->table, $where)->num_rows();
    }
    
    function get_unit()
    {
        return $this->db->get($this->table)->result();
    }

    function profile($email)
    {
        $where = array('fk_auth' => $email);
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_where($where)
    {
        $this->db->join("auth", "auth.email = unit.fk_auth");
        $this->db->join("roles", "roles._id = auth.fk_role");
        $this->db->select("unit.*");
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

    function get_unit_by_id($id)
    {
        $where = array('unit._id' => $id);
        return $this->_get_where($where)[0];
    }

    function _get_where($where)
    {
        $this->db->join('auth', ' auth.email = unit.fk_auth');
        $this->db->join('roles', ' roles._id = auth.fk_role');
        $this->db->where("auth.isActive = 1");
        return $this->db->get_where($this->table, $where)->result();
    }

    function decrementQuota($id)
    {
        $this->db->set('un_daily_quota', 'un_daily_quota-1', FALSE);
        $this->db->where('_id', $id);
        return $this->db->update($this->table);
    }

    function incrementQuota($id)
    {
        $this->db->set('un_daily_quota', 'un_daily_quota+1', FALSE);
        $this->db->where('_id', $id);
        return $this->db->update($this->table);
    }
}
