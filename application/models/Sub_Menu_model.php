<?php


class Sub_Menu_model extends CI_Model
{
    private $table = "sub_menu";


    function get_sub_menu()
    {
        $this->db->select("sm._id, m.m_name, sm.sm_title, sm.sm_url, sm.sm_icon, sm.sm_isActive, sm.sm_order");
        $this->db->join('menus as m', 'm._id = sm.fk_menu ');
        return $this->db->order_by('m.m_name ASC, sm.sm_order ASC')->get("$this->table as sm")->result();
    }

    function get_sub_menu_by_id($id)
    {
        $where = [
            "sm._id" => $id
        ];

        return $this->_get_sub_where($where)[0];
    }

    function get_not_in($listId=[])
    {   
        if(count($listId)==0){
            
        } else{
            $this->db->where_not_in("_id", $listId);
        }
        return $this->db->get("$this->table")->result();
    }
    function _get_sub_where($where)
    {
        $this->db->select("sm._id, m.m_name, sm.sm_title, sm.sm_url, sm.sm_icon, sm.sm_isActive, sm.sm_order, sm.fk_menu");
        $this->db->join('menus as m', 'm._id = sm.fk_menu ');
        return $this->db->get_where("$this->table as sm", $where)->result();
    }

    function create_sub_menu($dataSubMenu)
    {
        return $this->db->insert($this->table, $dataSubMenu);
    }

    function update_sub_menu($dataSubMenu, $where)
    {
        return $this->db->update($this->table, $dataSubMenu, $where);
    }
}
?>