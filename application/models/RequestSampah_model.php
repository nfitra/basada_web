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
        $this->db->select('request_sampah.*, 
        n._id as id_nasabah, 
        n.n_contact, n.n_name, 
        j.j_name, 
        s._id as id_jadwal, 
        s.s_day, 
        s.s_time, 
        s.s_weather, 
        (request_sampah.r_weight * j.j_price) as harga');
        $this->db->join('jenis_sampah as j', "fk_garbage = j._id");
        $this->db->join('nasabah as n', "fk_nasabah = n._id");
        $this->db->join('schedule as s', "fk_jadwal = s._id");
        $this->db->where($r_status, 2);
        $this->db->where("r_status !=", -1);
        $this->db->order_by('r_date', "DESC");
        return $this->db->get($this->table)->result();
    }

    function get_all_item_by_admin($admin, $status = "")
    {
        $r_status = $status != 2 ? 'r_status !=' : "r_status";
        $this->db->select('request_sampah.*, 
        n._id as id_nasabah, 
        n.n_contact, 
        n.n_name, 
        j.j_name, 
        s._id as id_jadwal, 
        s.s_day, 
        s.s_time, 
        s.s_weather, 
        (request_sampah.r_weight * j.j_price) as harga')
            ->join('jenis_sampah as j', "fk_garbage = j._id")
            ->join('nasabah as n', "fk_nasabah = n._id")
            ->join('schedule as s', "fk_jadwal = s._id")
            ->join('admin as a', "fk_admin = a._id")
            ->join('auth as au', "a.fk_auth = au.email")
            ->where($r_status, 2)
            // $this->db->where("r_status !=", -1);
            ->where("a.fk_auth", $admin);
        // var_dump($this->db->last_query());
        $this->db->order_by('r_date', "DESC");
        return $this->db->get($this->table)->result();
    }

    function get_one($where)
    {
        return $this->db->get_where($this->table, $where)->row();
    }

    function get_by_nasabah($where)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_notes,
        request_sampah.r_status,
        request_sampah.r_pickup_date,
        ST_AsGeoJSON(r_location) as location, 
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE request_sampah.fk_nasabah = '" . $where . "'
        ORDER BY request_sampah.r_date ASC;";
        return $this->db->query($sql)->result();
    }

    function get_by_id_admin_n_jadwal($idAdmin, $idJadwal)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_notes,
        request_sampah.r_status,
        request_sampah.r_pickup_date,
        ST_AsGeoJSON(r_location) as location, 
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE request_sampah.fk_admin = '" . $idAdmin . "'
        AND request_sampah.fk_jadwal = '" . $idJadwal . "'
        ORDER BY request_sampah.r_date ASC;";
        return $this->db->query($sql)->result();
    }

    function get_by_email_admin_n_jadwal($emailAdmin, $idJadwal)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_notes,
        request_sampah.r_status,
        request_sampah.r_pickup_date,
        ST_AsGeoJSON(r_location) as location, 
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE admin.fk_auth = '" . $emailAdmin . "'
        AND request_sampah.fk_jadwal = '" . $idJadwal . "'
        ORDER BY request_sampah.r_date ASC;";
        return $this->db->query($sql)->result();
    }

    function get_detail($id)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        request_sampah.fk_garbage,
        request_sampah.fk_nasabah,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_notes,
        request_sampah.r_status,
        request_sampah.r_pickup_date,
        ST_AsGeoJSON(r_location) as location, 
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE request_sampah._id = '" . $id . "';";
        return $this->db->query($sql)->row();
    }

    function get_by_id_admin($id)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_status,
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE request_sampah.fk_admin = '" . $id . "';";
        return $this->db->query($sql)->result();
    }

    function get_by_email_admin($email)
    {
        $sql = "SELECT request_sampah._id,
        request_sampah.r_date,
        jenis_sampah.j_name as jenis_sampah, 
        admin.un_name as nama_admin, 
        nasabah.n_name as nama_nasabah,
        request_sampah.r_weight,
        request_sampah.r_image,
        request_sampah.r_status,
        CONCAT(schedule.s_day, ' ',schedule.s_time) as jadwal_jemput,
        (request_sampah.r_weight * jenis_sampah.j_price) as harga
        FROM request_sampah 
        JOIN admin ON request_sampah.fk_admin = admin._id
        JOIN jenis_sampah ON request_sampah.fk_garbage = jenis_sampah._id
        JOIN nasabah ON request_sampah.fk_nasabah = nasabah._id
        JOIN schedule on request_sampah.fk_jadwal = schedule._id
        WHERE admin.fk_auth = '" . $email . "';";
        return $this->db->query($sql)->result();
    }

    function create_request($dataRequest)
    {
        $this->db->set('r_location', "ST_GeomFromText('" . $dataRequest['r_location'] . "')", false);
        unset($dataRequest['r_location']);
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
