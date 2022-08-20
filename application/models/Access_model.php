<?php

class Access_model extends CI_Model
{
    private $table = "role_access_menu";

    function get_all()
    {
        $this->db->select("r.r_name, sm.sm_title, ram._id, sm.sm_url");
        $this->db->join('sub_menu as sm', 'sm._id = ram.fk_subMenu');
        $this->db->join("roles as r", "r._id = ram.fk_role");
        $this->db->order_by('r.r_name','asc');
        return $this->db->get("$this->table as ram")->result();
    }

    function get_access_byID($id)
    {
        $where = ["ram._id"=>$id];
        $this->db->select("r.r_name, sm.sm_title, ram._id, r._id as role_id");
        $this->db->join('sub_menu as sm', 'sm._id = ram.fk_subMenu');
        $this->db->join("roles as r", "r._id = ram.fk_role");
        $this->db->order_by('r.r_name','asc');
        return $this->db->get_where("$this->table as ram", $where)->row();
    }

    function get_access_by_role($where)
    {
        $this->db->select("r.r_name, sm.sm_title, ram._id, r._id as role_id, sm.sm_url, m.m_order, sm.sm_order");
        $this->db->join('sub_menu as sm', 'sm._id = ram.fk_subMenu');
        $this->db->join('menus as m', 'm._id = sm.fk_menu');
        $this->db->join("roles as r", "r._id = ram.fk_role");
        $this->db->order_by('m.m_order','asc');
        $this->db->order_by('sm.sm_order','asc');
        $this->db->order_by('r.r_name','asc');
        return $this->db->get_where("$this->table as ram", $where)->result();
    }

    function _get_where_many($where)
    {
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_by_fk_role($fk_role)
    {
        $where = ["fk_role"=>$fk_role];
        return $this->_get_where_many($where);
    }

    function create_access($dataAccess)
    {
        return $this->db->insert($this->table, $dataAccess);
    }

    function update($dataUpdate, $where)
    {
        return $this->db->update($this->table, $dataUpdate, $where);
    }

    function delete($id)
    {
        $this->db->where("_id", $id);
        return $this->db->delete($this->table);
    }
}
?>