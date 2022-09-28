<?php

class Transaksi_model extends CI_Model
{
    public $table = "transaksi";

    function get_transaksi()
    {
        return $this->db->get($this->table)->result();
    }
    function create_transaksi($dataTransaksi)
    {
        return $this->db->insert($this->table, $dataTransaksi);
    }

    function get_all_data()
    {
        $this->db->select(
            "t_date, 
            r_date, 
            r_weight, 
            r_notes, 
            r_pickup_date,
            fk_role,
            t.fk_auth,
            n_name,
            n_contact,
            n_address, 
            j_name, 
            j_price, 
            satuan, 
            k_name"
        );
        $this->db->join('request_sampah as r', "fk_request = r._id");
        $this->db->join('auth as a', "t.fk_auth = a.email");
        $this->db->join('nasabah as n', "r.fk_nasabah = n._id");
        $this->db->join('jenis_sampah as j', "r.fk_garbage = j._id");
        $this->db->join('kategori_sampah as k', "j.fk_kategori = k._id");
        $this->db->order_by('t_date',"DESC");
        return $this->db->get("$this->table as t")->result();
    }

    function get_data_transaksi($where, $date, $date2, $status)
    {
        $this->db->select("j.j_name, r.r_weight, j.satuan, j.j_price");
        $this->db->from($this->table);
        $this->db->join("request_sampah as r", "fk_request = r._id");
        $this->db->join("jenis_sampah as j", "r.fk_garbage = j._id");
        $this->db->where("t_date >=", $date);
        $this->db->where("t_date <=", $date2);
        if ($status != "Semua") {
            $this->db->where('j.fk_kategori', $status);
        }
        $this->db->where($where);
        $data = $this->db->get_compiled_select();

        $this->db->select("a.j_name, sum(a.r_weight) as berat_total, a.satuan, sum(a.r_weight * a.j_price) as harga_total");
        $this->db->group_by("a.j_name, a.satuan");
        return $this->db->get("($data) as a")->result();

        // select js.j_name, rs.r_weight as berat_total,
        // from transaksi t
        // join request_sampah rs on rs._id = t.fk_request
        // join jenis_sampah js on js._id = rs.fk_garbage
        // where t.t_date like "2020-11%"
        // group by js.j_name
    }

    function get_data()
    {
        $this->db->select("j.j_name, r.r_weight, j.satuan, j.j_price");
        $this->db->from($this->table);
        $this->db->join("request_sampah as r", "transaksi.fk_request = r._id");
        $this->db->join("jenis_sampah as j", "r.fk_garbage = j._id");
        $data = $this->db->get_compiled_select();

        $this->db->select("a.j_name, sum(a.r_weight) as berat_total, a.satuan, sum(a.r_weight * a.j_price) as harga_total");
        $this->db->group_by("a.j_name");
        $this->db->group_by("a.satuan");
        $this->db->order_by("a.j_name", "ASC");
        return $this->db->get("($data) as a")->result();
    }

    function get_data_transaksi_kategori($date, $date2, $status)
    {
        $this->db->select("k.*");
        $this->db->join("request_sampah as r", "fk_request = r._id");
        $this->db->join("jenis_sampah as j", "r.fk_garbage = j._id");
        $this->db->join("kategori_sampah as k", "j.fk_kategori = k._id");
        $this->db->where("t_date >=", $date);
        $this->db->where("t_date <=", $date2);
        if ($status != "Semua") {
            $this->db->where('j.fk_kategori', $status);
        }
        $this->db->group_by("k._id");
        $this->db->order_by("k.k_name", "ASC");
        return $this->db->get($this->table)->result();
        // SELECT k.* FROM transaksi t
        // JOIN request_sampah r on t.fk_request = r._id
        // JOIN jenis_sampah j on r.fk_garbage = j._id
        // JOIN kategori_sampah k on j.fk_kategori = k._id
        // group by k.k_name
        // order by k.k_name
    }

    function get_omset($fk_auth)
    {
        $this->db->select("sum(pm.pm_total) as pemasukan");
        $pm = $this->db->get_where("pemasukan as pm", ["fk_auth" => $fk_auth])->row()->pemasukan;

        $this->db->select("sum(pk.pk_total) as pengeluaran");
        $pk = $this->db->get_where("pengeluaran as pk", ["fk_auth" => $fk_auth])->row()->pengeluaran;

        $this->db->select("r.r_weight, j.j_price");
        $this->db->from($this->table);
        $this->db->join("request_sampah as r", "fk_request = r._id");
        $this->db->join("jenis_sampah as j", "r.fk_garbage = j._id");
        $this->db->where(["fk_auth" => $fk_auth]);
        $data = $this->db->get_compiled_select();

        $this->db->select("sum(a.r_weight * a.j_price) as transaksi");
        $harga = $this->db->get("($data) as a")->row()->transaksi;
        return ($pm - $harga - $pk);
    }
}
