<?php

class Mutasi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mutasi_model');
        $this->nasabah = _checkUser($this);
        header('Content-Type: application/json');
    }

    public function get_mutasi()
    {
        $listMutasi = $this->Mutasi_model->get_where(["fk_nasabah"=>$this->nasabah->_id]);
        echo json_encode(['data'=>$listMutasi]);
    }
}