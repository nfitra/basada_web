<?php

class Admin_model extends CI_Model
{
    private $table = "admin";

    function check_email($email)
    {
        $where = array('fk_auth' => $email);
        return $this->db->get_where($this->table, $where)->num_rows();
    }

    function profile($email)
    {
        $where = array('fk_auth' => $email);
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_where($where)
    {
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_admin_by_email($email)
    {
        $where = array('fk_auth' => $email);
        return $this->_get_where($where)[0];
    }

    function get_id_by_email($email)
    {
        $this->db->select('_id');
        $this->db->where('fk_auth', $email);
        return $this->db->get($this->table)->row();
    }

    function get_admin_by_id($id)
    {
        $where = array('admin._id' => $id);
        return $this->_get_where($where)[0];
    }

    function _get_where($where)
    {
        $this->db->join('auth', ' auth.email = admin.fk_auth');
        $this->db->join('roles', ' roles._id = auth.fk_role');
        $this->db->where("auth.isActive = 1");
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_admin()
    {
        $this->db->select("un_name, fk_auth, _id, a.isActive");
        $this->db->join("auth as a", "a.email=fk_auth");
        $this->db->where("a.isActive = 1");
        $this->db->where("a.fk_role = 'cee6de74c28ff53dcdf3da10f3ee1c05'");
        return $this->db->get($this->table)->result();
    }

    function create_admin($dataAdmin)
    {
        return $this->db->insert($this->table, $dataAdmin);
    }

    function update_admin($dataAdmin, $where)
    {
        return $this->db->update($this->table, $dataAdmin, $where);
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
