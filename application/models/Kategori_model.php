<?php
class Kategori_model extends CI_Model
{
    private $table = "kategori_artikel";

    function get_kategori()
    {
        return $this->db->get($this->table)->result();
    }

    function get_kategori_by_id($id)
    {
        $this->db->where("_id",$id);
        return $this->db->get($this->table)->row();
    }

    function get_kategori_with_count()
    {
        $this->db->select('k_name, count("*") as total');
        $this->db->join('artikel as a','a.fk_kategori = kategori_artikel._id');
        $this->db->group_by('k_name');
        return $this->db->get($this->table)->result();
    }

    function create_kategori($dataKategori)
    {
        return $this->db->insert($this->table, $dataKategori);
    }

    function update_kategori($dataKategori, $where)
    {
        return $this->db->update($this->table, $dataKategori, $where);
    }

    function delete_kategori($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
?>
