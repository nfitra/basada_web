<?php


class Menu_model extends CI_Model
{
    private $table = "menus";

    function get_menu()
    {
        $this->db->select("_id, m_name, m_order");
        return $this->db->order_by('m_order', 'ASC')->get($this->table)->result();
    }
    
    function get_menu_by_id($id)
    {
        $where = [
            "_id" => $id
        ];

        return $this->_get_where($where)[0];
    }

    function _get_where($where)
    {
        $this->db->select("_id, m_name, m_order");
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_menu($dataMenu)
    {
        return $this->db->insert($this->table, $dataMenu);
    }

    function update_menu($dataMenu, $where)
    {
        return $this->db->update($this->table, $dataMenu, $where);
    }
}
?>