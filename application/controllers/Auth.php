<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Access_model');
    }

    function index()
    {
        $this->_sign_in();
    }

    function sign_in()
    {
        $this->_sign_in();
    }

    function sign_out()
    {
        // session_destroy();
        $dataSession = ["email", "fk_role"];
        $this->session->unset_userdata($dataSession);
        _set_flashdata($this, 'message', 'success', 'Logout Berhasil !', 'auth');
    }

    function _sign_in()
    {
        $data = array(
            'title' => 'Login'
        );

        $config = array(
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email'
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[5]|trim'
            )
        );

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates_public($this, "auth/login", $data);
            // wrapper_auth($this, 'auth/login', $data);
        } else {
            $email = xss_input($this->input->post('email', true));
            $password = xss_input($this->input->post('password', true));
            $userAuth = $this->Auth_model->cek_email($email);
            if ($userAuth) {
                // $isValid
                if ($userAuth->isActive == 1) {
                    $isPasswordValid = password_verify($password, $userAuth->password);
                    if ($isPasswordValid) {
                        $dataSession = [
                            'email' => $userAuth->email,
                            'role_id' => $userAuth->fk_role
                        ];
                        $this->session->set_userdata($dataSession);
                        $this->check_redirect($userAuth->fk_role);
                    } else {
                        // $this->session->set_flashdata('error', '<div class="alert alert-danger" role="alert"> Email atau password salah </div>');
                        // redirect('auth');
                        _set_flashdata($this, 'message', 'danger', 'Email atau password salah', 'auth');
                    }
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Email belum di aktivasi', 'auth');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Error', 'auth');
            }
        }
    }

    function redirect_now()
    {
        $role_id = $this->session->userdata('role_id');
        $this->check_redirect($role_id);
        // var_dump();
    }

    function check_redirect($role_id)
    {
        // $idAdmin = "37a0b01c4c89bdbd2324609c80a71054";
        // $idInduk = "cee6de74c28ff53dcdf3da10f3ee1c05";
        // $idUnit = "d2a8121514a7d77f7d8518bdf45e56d5";
        // if($role_id === $idAdmin || $role_id === $idInduk){
        //     redirect('admin');
        // } else {
        //     redirect('auth');
        // }
        $where = ["fk_role" => $role_id];
        $accesses = $this->Access_model->get_access_by_role($where);
        if (count($accesses) === 0) {
            redirect('auth');
        } else {
            // var_dump($accesses);die;
            redirect($accesses[0]->sm_url);
        }
        // var_dump($accesses);
    }

    function blocked()
    {
        $data = array(
            'title' => 'Forbidden Access',
        );

        $this->load->view("error/403", $data);
    }
}
