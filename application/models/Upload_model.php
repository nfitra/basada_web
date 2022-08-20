<?php

class Upload_model extends CI_Model
{
    public $table = 'upload';

    function get_upload()
    {
        $this->db->order_by('file_type','INC');
        return $this->db->get($this->table)->result();
    }
    
    function get_one($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }
    
    function check_tutorial($type)
    {
        $this->db->where('file_type',$type);
        $check = $this->db->get($this->table)->num_rows();
        return $check == 0 ? true : false;
    }

    function create_upload($dataUpload)
    {
        return $this->db->insert($this->table, $dataUpload);
    }

    function update_upload($dataUpload, $where)
    {
        return $this->db->update($this->table, $dataUpload, $where);
    }
    function delete_upload($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
?>