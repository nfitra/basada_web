<?php

class Jadwal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Schedule_model');
        header('Content-Type: application/json');
    }

    public function get_jadwal()
    {
        $data = $this->Schedule_model->get_schedule();
        echo json_encode($data);
    }
}
