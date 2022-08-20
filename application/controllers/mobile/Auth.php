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
        $status_code = 200;
        if($userAuth){
            if($userAuth->isActive == 1){
                $isPasswordValid = password_verify($password, $userAuth->password);
                if($isPasswordValid){
                    $tokenData['email'] = $userAuth->email;                    
                    $tokenData['role'] = $userAuth->fk_role;
                    $data['message'] = "Berhasil masuk";
                    $data['data'] = $tokenData;
                    $status_code = 200;
                } else {
                    $data['message'] = "Password Salah";
                    $status_code = 401;
                }
            } else{
                $data['message'] = "Email belum di aktivasi";
                $status_code = 401;
            }
            
        } else{
            $data['message'] = "Email Salah";
            $status_code = 401;
        }
        $token = _encodeToken($this, $data);
        $data['token'] = $token;
        echo json_encode(array('status' => $status_code, 'data' => $data));
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
        if(!$userAuth){
            $insertAuth = $this->Auth_model->create_admin_auth($dataAuth);
            $status_code = 200;
            if($insertAuth){
                $tokenData['message'] = "Berhasil menginsert admin auth nasabah";
                $status_code = 200;
                $dataNasabah = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                ];
                $insertNasabah = $this->Nasabah_model->create_nasabah($dataNasabah);
                if($insertNasabah){
                    $tokenData['message'] = "Berhasil menginsert auth dan nasabah";
                    $status_code = 200;
                }
                else{
                    $deleteDataAuth = [
                        "email" => $email
                    ];
                    $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                    $tokenData['message'] = "Gagal menginsert nasabah";
                    $status_code = 401;
                }
            }
            else{
                $tokenData['message'] = "Gagal menginsert admin auth nasabah";
                $status_code = 401;
            }
        }
        else{
            $tokenData['message'] = "Email sudah dipakai";
            $status_code = 401;
        }
        $token = _encodeToken($this, $tokenData);
        $tokenData['token'] = $token;
        echo json_encode(array('status' => $status_code, 'data' => $tokenData));
    }
}