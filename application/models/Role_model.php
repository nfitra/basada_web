<?php
class Role_model extends CI_Model
{
    private $table = "roles";

    function get_role()
    {
        $this->db->select("r_name, _id");
        return $this->db->get($this->table)->result();
    }

    function get_where($where){
        return $this->db->get_where($this->table,$where)->result();
    }
}
?>
