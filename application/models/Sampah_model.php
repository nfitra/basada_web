<?php

class Sampah_model extends CI_Model
{
    private $table = "jenis_sampah";

    function get_all()
    {
        $this->db->select('jenis_sampah.*, k_name');
        $this->db->join('kategori_sampah as k',"k._id = fk_kategori");
        return $this->db->get($this->table)->result();
    }

    function get_where($where)
    {
        return $this->db->get_where($this->table, $where)->result();
    }

    function get_one($where)
    {
        $this->db->select('jenis_sampah.*, k_name');
        $this->db->join('kategori_sampah as k',"k._id = fk_kategori");
        return $this->db->get_where($this->table,$where)->row();
    }

    function get_sampah_by_kategori($kategori)
    {
        $this->db->where("fk_kategori",$kategori);
        return $this->db->get($this->table)->result();
    }

    function get_kategori_group($search)
    {
        $this->db->join('kategori_sampah as k',"k._id = fk_kategori");
        $this->db->like('j_name',$search);
        $this->db->group_by("k.k_name");
        return $this->db->get($this->table)->result();
    }

    function get_kategori_group_with_kategori($kategori, $search)
    {
        $this->db->join('kategori_sampah as k',"k._id = fk_kategori");
        $this->db->where('fk_kategori',$kategori);
        $this->db->like('j_name',$search);
        $this->db->group_by("k.k_name");
        return $this->db->get($this->table)->result();
    }

    function get_sampah_with_search($search)
    {
        $this->db->like('j_name',$search);
        return $this->db->get($this->table)->result();
    }

    function get_sampah_with_search_and_kategori($kategori, $search)
    {
        $this->db->where('fk_kategori',$kategori);
        $this->db->like('j_name',$search);
        return $this->db->get($this->table)->result();
    }

    function create_sampah($data)
    {
        return $this->db->insert($this->table, $data);
    }

    function delete_sampah($where)
    {
        return $this->db->delete($this->table, $where);
    }

    function update_sampah($data, $where)
    {
        return $this->db->update($this->table, $data, $where);
    }
}
?>