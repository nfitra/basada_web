<?php

class Device_model extends CI_Model
{
    public $table = 'device';

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where("id", $id);
        return $this->db->delete($this->table);
    }

    public function get_by_auth($email)
    {
        return $this->db->get_where($this->table, ['fk_auth' => $email]);
    }
}
