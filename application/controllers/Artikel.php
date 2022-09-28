<?php

class Artikel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Artikel_model');
        // _checkNasabah($this);
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Artikel_model');
        $this->load->model('Kategori_model');
        // header('Content-Type: application/json');
    }

    function index()
    {
        $data = array(
            'title' => 'Artikel',
            'active' => 'Artikel',
            'user' => _get_user($this),
            'listArtikel' => $this->Artikel_model->get_artikel(),
            'listKategori' => $this->Kategori_model->get_kategori()
        );
        wrapper_templates($this, "artikel/index", $data);
    }

    public function get_all_artikel()
    {
        _checkNasabah($this);
        header('Content-Type: application/json');
        $listArtikel = $this->Artikel_model->get_artikel();
        echo json_encode($listArtikel);
    }

    public function get_limit_artikel($limit, $page)
    {
        header('Content-Type: application/json');
        _checkNasabah($this);
        $page = $page - 1;
        $listArtikel = $this->Artikel_model->get_artikel_list($limit, $page);
        echo json_encode($listArtikel);
    }

    public function get_artikel_by_id($id)
    {
        header('Content-Type: application/json');
        _checkNasabah($this);
        $artikel = $this->Artikel_model->get_artikel_by_id($id);
        echo json_encode($artikel);
    }
}