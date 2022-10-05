<?php

class Admin extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Auth_model');
        header('Content-Type: application/json');
    }

    public function profile()
    {
        $this->user = _checkUser($this);
        $data = $this->Admin_model->profile($this->user->email);
        echo json_encode($data);
    }

    public function update_admin()
    {
        _checkInput();
        $this->user = _checkUser($this);
        $formdata = json_decode(file_get_contents('php://input'), true);
        $email = $this->user->email;
        $name = $formdata['nama'];
        $est = $formdata['est'];
        $sk = $formdata['sk'];
        $status = $formdata['status'];
        $address = $formdata['alamat'];
        $location = $formdata['lokasi'];
        $district = $formdata['kecamatan'];
        $employee = $formdata['employees'];
        $manager = $formdata['manager'];
        $contact = $formdata['no_hp'];
        $dataAdmin = [
            "un_name" => $name,
            "un_est" => $est,
            "un_sk" => $sk,
            "un_status" => $status,
            "un_address" => $address,
            "un_location" => $location,
            "un_district" => $district,
            "un_employees" => $employee,
            "un_manager" => $manager,
            "un_contact" => $contact
        ];
        $where = ['fk_auth' => $email];
        $cekTabelAdmin = $this->Admin_model->check_email($email);
        if ($cekTabelAdmin) {
            $updateAdmin = $this->Admin_model->update_admin($dataAdmin, $where);
            if ($updateAdmin) {
                $tokenData['data'] = $this->Admin_model->profile($email);
                $tokenData['message'] = "Berhasil mengupdate data admin";
                $statusCode = 200;
                http_response_code('200');
            } else {
                $tokenData['message'] = "Gagal mengupdate data admin";
                $statusCode = 500;
                http_response_code('500');
            }
        } else {
            $cekTabelAuth = $this->Auth_model->cek_admin($email);
            if ($cekTabelAuth) {
                $dataAdmin = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                ];
                $updateAdmin = $this->Admin_model->create_admin($dataAdmin, $where);
                if ($updateAdmin) {
                    $tokenData['data'] = $this->Admin_model->profile($email);
                    $tokenData['message'] = "Berhasil mengupdate data admin";
                    $statusCode = 200;
                    http_response_code('200');
                } else {
                    $tokenData['message'] = "Gagal mengupdate data admin";
                    $statusCode = 500;
                    http_response_code('500');
                }
            } else {
                $tokenData['message'] = "Tidak ada admin dengan email ini";
                $statusCode = 401;
                http_response_code('401');
            }
        }
        echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
    }
}
