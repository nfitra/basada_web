<?php

class RequestSampah_model extends CI_Model
{
    public $table = 'request_sampah';

    function get_request()
    {
        return $this->db->get($this->table)->result();
    }

    function get_all_item($status = "")
    {
        $r_status = $status != 2 ? 'r_status !=' : "r_status";
        $this->db->select('request_sampah.*, n._id as id_nasabah, n.n_contact, n.n_name, j.j_name, s._id as id_jadwal, s.s_day, s.s_time, s.s_weather, (request_sampah.r_weight * j.j_price) as harga');
        $this->db->join('jenis_sampah as j', "fk_garbage = j._id");
        $this->db->join('nasabah as n', "fk_nasabah = n._id");
        $this->db->join('schedule as s', "fk_jadwal = s._id");
        $this->db->where($r_status, 2);
        $this->db->where("r_status !=", -1);
        $this->db->order_by('r_date',"DESC");
        return $this->db->get($this->table)->result();
    }

    function get_all_item_by_admin($admin, $status = "") {
        $r_status = $status != 2 ? 'r_status !=' : "r_status";
        $this->db->select('request_sampah.*, n._id as id_nasabah, n.n_contact, n.n_name, j.j_name, s._id as id_jadwal, s.s_day, s.s_time, s.s_weather, (request_sampah.r_weight * j.j_price) as harga');
        $this->db->join('jenis_sampah as j', "fk_garbage = j._id");
        $this->db->join('nasabah as n', "fk_nasabah = n._id");
        $this->db->join('schedule as s', "fk_jadwal = s._id");
        $this->db->join('admin as a', "fk_admin = a._id");
        $this->db->join('auth as au', "a.fk_auth = au.email");
        $this->db->where($r_status, 2);
        // $this->db->where("r_status !=", -1);
        $this->db->where("a.fk_auth", $admin);
        $this->db->order_by('r_date',"DESC");
        return $this->db->get($this->table)->result();
    }

    function get_one($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_where($where)
    {
        $this->db->order_by("r_status", "asc");
        $this->db->order_by("r_date", "desc");
        return $this->db->get_where($this->table, $where)->result();
    }

    function create_request($dataRequest)
    {
        return $this->db->insert($this->table, $dataRequest);
    }

    function update_request($dataRequest, $where)
    {
        return $this->db->update($this->table, $dataRequest, $where);
    }

    function delete_request($where)
    {
        return $this->db->delete($this->table, $where);
    }
}
