<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
        $this->load->model('Role_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Update Data Profile',
            'active' => 'Profile',
            'user' => _get_user($this)
        );

        $config = [
            [
                'field' => 'un_name',
                'label' => 'Nama Lengkap',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            wrapper_templates($this, "profile/profileUnit", $data);
        } else {
            $where = [
                "fk_auth" => $this->session->userdata('email')
            ];
            $dataUpdate = [
                "un_name" => xss_input($this->input->post('un_name', true)),
                "un_est" => xss_input($this->input->post('un_est', true)),
                "un_sk" => xss_input($this->input->post('un_sk', true)),
                "un_status" => xss_input($this->input->post('un_status', true)),
                "un_address" => xss_input($this->input->post('un_address', true)),
                "un_location" => xss_input($this->input->post('un_location', true)),
                "un_district" => xss_input($this->input->post('un_district', true)),
                "un_employees" => xss_input($this->input->post('un_employees', true)),
                "un_manager" => xss_input($this->input->post('un_manager', true)),
                "un_contact" => xss_input($this->input->post('un_contact', true)),
            ];
            if ($this->Admin_model->check_admin($this->session->userdata('email'))) {
                $update = $this->Admin_model->update_admin($dataUpdate, $where);
            } else {
                $update = $this->Unit_model->update_unit($dataUpdate, $where);
            }
            if ($update) {
                _set_flashdata($this, 'message', 'success', 'Update data berhasil', 'profile');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Update data gagal', 'profile');
            }
        }
    }

    function update_auth($id)
    {
        $data = array(
            'title' => 'Update Data Profile',
            'active' => 'Data Profile',
            'user' => _get_user($this),
        );

        $config = [
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|trim|min_length[5]',
                'errors' => [
                    'required' => '%s wajib diisi',
                    'min_length' => 'Panjang %s minimal 5 karakter',
                ]
            ],
            [
                'field' => 'confPass',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|trim|min_length[5]|matches[password]',
                'errors' => [
                    'required' => '%s wajib diisi',
                    'min_length' => 'Panjang %s minimal 5 karakter',
                    'matches' => '%s tidak sama'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            wrapper_templates($this, "s", $data);
        } else {

            $dataUpdate = [
                "password" => xss_input(password_hash($this->input->post('password', true), PASSWORD_BCRYPT))
            ];

            $where = [
                "email" => $this->session->userdata('email')
            ];

            $update = $this->Auth_model->update_auth($dataUpdate, $where);
            if ($update) {
                _set_flashdata($this, 'message', 'success', 'Update data berhasil', 'profile');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Update data gagal', 'profile');
            }
        }
    }
}
