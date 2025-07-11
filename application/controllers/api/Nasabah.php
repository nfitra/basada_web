<?php

class Nasabah extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Nasabah_model');
        $this->nasabah = _checkNasabah($this);
        header('Content-Type: application/json');
    }

    public function get_nasabah()
    {
        echo json_encode($this->nasabah);
    }

    public function get_saldo()
    {
        $email = $this->nasabah->fk_auth;
        $nasabah = $this->Nasabah_model->get_where(["fk_auth" => $email])[0];
        $tokenData = [
            "email" => $email,
            "balance" => intval($nasabah->n_balance),
        ];
        echo json_encode(['status' => 200, 'data' => $tokenData]);
    }

    public function update_nasabah()
    {
        _checkInput();
        $formdata = json_decode(file_get_contents('php://input'), true);
        $email = $this->nasabah->fk_auth;
        $n_name = $formdata['nama'];
        $n_dob = $formdata['tanggal_lahir'];
        $n_address = $formdata['alamat'];
        $n_province = $formdata['provinsi'];
        $n_city = $formdata['kota'];
        $n_postcode = $formdata['kode_pos'];
        $n_contact = $formdata['telepon'];
        $dataNasabah = [
            "n_name" => $n_name,
            "n_dob" => $n_dob,
            "n_address" => $n_address,
            "n_province" => $n_province,
            "n_city" => $n_city,
            "n_postcode" => $n_postcode,
            "n_contact" => $n_contact,
            "isExist" => 1,
        ];
        $where = ['fk_auth' => $email];
        $userAuth = $this->Nasabah_model->cek_email($email);
        if ($userAuth) {
            $updateNasabah = $this->Nasabah_model->update_nasabah($dataNasabah, $where);
            $statusCode = 200;
            if ($updateNasabah) {
                $data = $this->Nasabah_model->profile($email);
                $message = "Berhasil mengupdate data nasabah";
                $statusCode = 200;
                http_response_code('200');
            } else {
                $message = "Gagal mengupdate data nasabah";
                $statusCode = 401;
                http_response_code('401');
            }
        } else {
            $message = "Tidak ada nasabah dengan email ini";
            $statusCode = 401;
            http_response_code('401');
        }
        echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $data));
    }

    public function change_password()
    {
        _checkInput();
        $formdata = json_decode(file_get_contents('php://input'), true);
        $old_password = xss_input($formdata['old_password']);
        $new_password = xss_input($formdata['new_password']);
        $password = $this->Auth_model->get_where(["email" => $this->nasabah->fk_auth])[0]->password;
        $isPasswordValid = password_verify($old_password, $password);
        if ($isPasswordValid) {
            $dataPass = [
                "password" => password_hash($new_password, PASSWORD_BCRYPT),
            ];
            $statusCode = 200;
            $where = ['email' => $this->nasabah->fk_auth];
            $changePassword = $this->Auth_model->update_auth($dataPass, $where);
            if ($changePassword) {
                $message = "Berhasil mengubah password";
                $statusCode = 200;
            } else {
                $message = "Gagal mengubah password";
                $statusCode = 401;
            }
        } else {
            $message = "Password Salah";
            $statusCode = 401;
        }
        // $token = _encodeToken($this, $tokenData);
        // $tokenData['token'] = $token;
        echo json_encode(array('status' => $statusCode, 'message' => $message));
    }

    public function conv_token()
    {
        $formdata = json_decode(file_get_contents('php://input'), true);
        $token = _encodeToken($this, $formdata);
        echo json_encode(['Token' => $token, 'data' => $formdata]);
    }
}
