<?php

class Artikel extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Artikel_model');
        _checkUser($this);
        header('Content-Type: application/json');
    }

    public function get_all_artikel()
    {
        $listArtikel = $this->Artikel_model->get_artikel();
        echo json_encode(['data' => $listArtikel]);
    }

    public function get_limit_artikel($limit, $page)
    {
        $page = $page - 1;
        $listArtikel = $this->Artikel_model->get_artikel_list($limit, $page);
        echo json_encode(['data' => $listArtikel]);
    }

    public function get_artikel_by_id($id)
    {
        $artikel = $this->Artikel_model->get_artikel_by_id($id);
        echo json_encode(['data' => $artikel]);
    }
}