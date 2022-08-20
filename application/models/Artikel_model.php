<?php

class Artikel_model extends CI_Model
{
    private $table = "artikel";

    function get_artikel()
    {
        $this->db->select("artikel._id, a_title, a_content, k.k_name, a_file, a_file_type");
        $this->db->join("kategori_artikel k", "k._id = fk_kategori");
        return $this->db->get($this->table)->result();
    }

    function get_artikel_by_id($id)
    {
        $this->db->where("_id",$id);
        return $this->db->get($this->table)->row();
    }
    function get_artikel_limit($limit)
    {
        $this->db->limit($limit);
        $this->db->order_by('_id','DESC');
        return $this->db->get($this->table)->result();
    }

    function get_artikel_list($limit, $start)
    {
        return $this->db->get($this->table, $limit, $start)->result();
    }
    function get_count()
    {
        return $this->db->get($this->table)->num_rows();
    }

    function get_artikel_by_kategori($kategori)
    {
        $this->db->where("fk_kategori",$kategori);
        return $this->db->get($this->table)->result();
    }

    function create_artikel($dataArtikel)
    {
        return $this->db->insert($this->table, $dataArtikel);
    }

    function update_artikel($dataArtikel, $where)
    {
        return $this->db->update($this->table, $dataArtikel, $where);
    }
    function update_gambar($gambar, $where)
    {
        return $this->db->update($this->table, $gambar, $where);
    }

    function delete_artikel($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
?>