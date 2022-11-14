<?php

class Device extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->user = _checkUser($this);
        $this->load->model('Device_model');
        header('Content-Type: application/json');
    }

    public function add()
    {
        if ($this->input->post()) {
            $data['registration_id'] = $this->input->post('registration_id');
            $data['fk_auth'] = $this->user->email;
            $insert = $this->Device_model->insert($data);
            if ($insert) {
                $tokenData['id_device'] = $this->Device_model->lastInsertedId($data);
                $tokenData['message'] = "Berhasil menambahkan device";
                $statusCode = 200;
                http_response_code('200');
            } else {
                $tokenData['message'] = "Gagal menambahkan device";
                $tokenData['error_message'] = $insert;
                $statusCode = 500;
                http_response_code('500');
            }
        } else {
            $tokenData['message'] = "Tidak ada inputan";
            $statusCode = 400;
            http_response_code('400');
        }
        echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
    }

    public function delete($id)
    {
        $delete = $this->Device_model->delete($id);
        if ($delete) {
            $tokenData['message'] = "Berhasil menghapus device";
            $statusCode = 200;
            http_response_code('200');
        } else {
            $tokenData['message'] = "Gagal menghapus sampah";
            $tokenData['error_message'] = $delete;
            $statusCode = 500;
            http_response_code('500');
        }
        echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
    }
}