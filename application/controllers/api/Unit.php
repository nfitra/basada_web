<?php

class Unit extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->load->model('Unit_model');
        $this->load->model('Auth_model');
        header('Content-Type: application/json');
    }

    public function get_unit()
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Unit_model->get_unit();
        echo json_encode($data);
    }

    public function get_unit_by_status($status)
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Unit_model->get_where(['un_status' => ucfirst($status)]);
        echo json_encode($data);
    }

    public function profile()
    {
        $this->user = _checkUser($this);
        $data = $this->Unit_model->profile($this->user->email);
        echo json_encode($data);
    }

    public function update_unit()
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
        $dataUnit = [
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
        $cekTabelUnit = $this->Unit_model->check_email($email);
        if ($cekTabelUnit) {
            $updateAdmin = $this->Unit_model->update_unit($dataUnit, $where);
            if ($updateAdmin) {
                $data = $this->Unit_model->profile($email);
                $message = "Berhasil mengupdate data unit";
                $statusCode = 200;
                http_response_code('200');
            } else {
                $message = "Gagal mengupdate data unit";
                $statusCode = 500;
                http_response_code('500');
            }
        } else {
            $cekTabelAuth = $this->Auth_model->cek_admin($email);
            if ($cekTabelAuth) {
                $dataUnit = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                ];
                $updateAdmin = $this->Unit_model->create_unit($dataUnit, $where);
                if ($updateAdmin) {
                    $data = $this->Unit_model->profile($email);
                    $message = "Berhasil mengupdate data admin";
                    $statusCode = 200;
                    http_response_code('200');
                } else {
                    $message = "Gagal mengupdate data admin";
                    $statusCode = 500;
                    http_response_code('500');
                }
            } else {
                $message = "Tidak ada admin dengan email ini";
                $statusCode = 401;
                http_response_code('401');
            }
        }
        echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $data));
    }
}
