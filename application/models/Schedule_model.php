<?php

class Schedule_model extends CI_Model
{
    public $table = 'schedule';

    function get_schedule()
    {
        return $this->db->get($this->table)->result();
    }

    function get_one($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }

    function create_schedule($dataSchedule)
    {
        return $this->db->insert($this->table, $dataSchedule);
    }

    function update_schedule($dataSchedule, $where)
    {
        return $this->db->update($this->table, $dataSchedule, $where);
    }

    function delete_schedule($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
?>