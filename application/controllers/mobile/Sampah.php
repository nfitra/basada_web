<?php

class Sampah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Sampah_model');
        $this->load->model('KategoriSampah_model');
        $this->load->model('Schedule_model');
        _checkUser($this);
        header('Content-Type: application/json');
    }

    public function get_sampah()
    {
        $listSampah = $this->Sampah_model->get_all();
        echo json_encode(['data'=>$listSampah]);
    }

    public function get_kategori()
    {
        $listKategori = $this->KategoriSampah_model->get_kategori();
        echo json_encode(['data'=>$listKategori]);
    }

    public function get_sampah_by_kategori($fk_kategori)
    {
        $listSampah = $this->Sampah_model->get_sampah_by_kategori($fk_kategori);
        echo json_encode(['data'=>$listSampah]);
    }
}