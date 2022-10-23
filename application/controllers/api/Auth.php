<?php

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Auth_model');
        $this->load->model('Nasabah_model');
        _checkInput();
        header('Content-Type: application/json');
    }

    public function login()
    {
        $formdata = json_decode(file_get_contents('php://input'), true);
        $email = $formdata['email'];
        $password = $formdata['password'];
        $userAuth = $this->Auth_model->cek_nasabah($email);
        $statusCode = 200;
        if ($userAuth) {
            // var_dump($userAuth);
            if ($userAuth->isActive == 1) {
                $isPasswordValid = password_verify($password, $userAuth->password);
                if ($isPasswordValid) {
                    $data['email'] = $userAuth->email;
                    $data['role'] = "Nasabah";
                    $message = "Berhasil masuk";
                    $statusCode = 200;
                    $token = _encodeToken($this, $data);
                    $data['token'] = $token;
                } else {
                    $data['message'] = "Password Salah";
                    $statusCode = 401;
                }
            } else {
                $data['message'] = "Email belum di aktivasi";
                $statusCode = 401;
            }
        } else {
            $userAuth = $this->Auth_model->cek_admin($email);
            // var_dump($this->db->last_query());
            if ($userAuth) {
                // var_dump($userAuth);
                if ($userAuth->isActive == 1) {
                    $isPasswordValid = password_verify($password, $userAuth->password);
                    if ($isPasswordValid) {
                        $data['email'] = $userAuth->email;
                        $data['role'] = $userAuth->role;
                        $message = "Berhasil masuk";
                        $statusCode = 200;
                        $token = _encodeToken($this, $data);
                        $data['token'] = $token;
                    } else {
                        $message = "Password Salah";
                        $statusCode = 401;
                    }
                } else {
                    $message = "Email belum di aktivasi";
                    $statusCode = 401;
                }
            } else {
                $message = "Email Salah";
                $statusCode = 401;
            }
        }
        echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $data));
    }

    public function signup()
    {
        $formdata = json_decode(file_get_contents('php://input'), true);
        $email = xss_input($formdata['email']);
        $password = xss_input($formdata['password']);
        $dataAuth = [
            "email" => $email,
            "password" => password_hash($password, PASSWORD_BCRYPT),
            "fk_role" => "4ea170807728f752a1a91cb4502855ce",
            "isActive" => 1
        ];
        $userAuth = $this->Auth_model->cek_nasabah($email);
        if (!$userAuth) {
            $insertAuth = $this->Auth_model->create_auth($dataAuth);
            $statusCode = 200;
            if ($insertAuth) {
                // $tokenData['message'] = "Berhasil menginsert admin auth nasabah";
                // $statusCode = 200;
                $dataNasabah = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                ];
                $insertNasabah = $this->Nasabah_model->create_nasabah($dataNasabah);
                if ($insertNasabah) {
                    $data['email'] = $email;
                    $data['role'] = 'Nasabah';
                    $message = "Berhasil membuat akun nasabah";
                    $statusCode = 200;
                    $token = _encodeToken($this, $data);
                    $data['token'] = $token;
                } else {
                    $deleteDataAuth = [
                        "email" => $email
                    ];
                    $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                    $message = "Gagal membuat akun nasabah";
                    $statusCode = 401;
                }
            } else {
                $message = "Gagal membuat akun nasabah";
                $statusCode = 401;
            }
        } else {
            $message = "Email sudah dipakai";
            $statusCode = 401;
        }
        echo json_encode(array(
            'status' => $statusCode, 'message' => $message, 'data' => $data
        ));
    }
}
