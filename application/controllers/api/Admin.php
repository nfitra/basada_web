<?php

class Admin extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->load->model('Admin_model');
        header('Content-Type: application/json');
    }

    public function profile()
    {
        $this->user = _checkUser($this);
        $data = $this->Admin_model->profile($this->user->email);
        echo json_encode($data);
    }
}
