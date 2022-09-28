<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataInduk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Data Admin Induk',
            'active' => 'Data Admin Induk',
            'user' => _get_user($this),
            'listAdmin' => $this->Admin_model->get_admin()
        );
        wrapper_templates($this, "admin/induk/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Tambah Data Admin Induk',
            'active' => 'Data Admin Induk',
            'user' => _get_user($this)
        );

        $config = [
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|trim|valid_email|is_unique[auth.email]',
                'errors' => [
                    'required' => '%s wajib diisi',
                    'valid_email' => 'Format %s harus benar',
                    'is_unique' => '%s sudah digunakan.'
                ]
            ],
            [
                'field' => 'un_name',
                'label' => 'Nama Lengkap',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
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

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "admin/induk/create", $data);
        } else {
            $email = xss_input($this->input->post('email', true));
            $password = xss_input($this->input->post('password', true));
            $dataAuth = [
                "email" => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "fk_role" => "cee6de74c28ff53dcdf3da10f3ee1c05",
                "isActive" => 1
            ];
            $insertAuth = $this->Auth_model->create_admin_auth($dataAuth);
            if ($insertAuth) {
                $dataAdmin = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
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

                $insertAdmin = $this->Admin_model->create_admin($dataAdmin);
                if ($insertAdmin) {
                    _set_flashdata($this, 'message', 'success', 'Berhasil membuat induk', 'dataInduk');
                } else {
                    $deleteDataAuth = [
                        "email" => $email
                    ];
                    $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                    _set_flashdata($this, 'message', 'danger', 'Gagal membuat induk', 'dataInduk');
                }
            }
        }
    }

    function update($id)
    {
        $data = array(
            'title' => 'Update Admin Induk',
            'active' => 'Data Admin Induk',
            'user' => _get_user($this),
            'dataAdmin' => $this->Admin_model->get_admin_by_id($id)
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
            wrapper_templates($this, "admin/induk/update", $data);
        } else {
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

            $where = [
                "_id" => $id
            ];

            $update = $this->Admin_model->update_admin($dataUpdate, $where);
            if ($update) {
                _set_flashdata($this, 'message', 'success', 'Update data berhasil', 'dataInduk');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Update data gagal', 'dataInduk');
            }
        }
    }

    function update_auth($id)
    {
        $admin = $this->Admin_model->get_admin_by_id($id);
        $data = array(
            'title' => 'Update Admin Induk',
            'active' => 'Data Admin Induk',
            'user' => _get_user($this),
            'dataAdmin' => $admin
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
            wrapper_templates($this, "admin/induk/update", $data);
        } else {

            $dataUpdate = [
                "password" => xss_input(password_hash($this->input->post('password', true), PASSWORD_BCRYPT))
            ];

            $where = [
                "email" => $admin->fk_auth
            ];

            $update = $this->Auth_model->update_auth($dataUpdate, $where);
            if ($update) {
                _set_flashdata($this, 'message', 'success', 'Update data berhasil', 'dataInduk');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Update data gagal', 'dataInduk');
            }
        }
    }

    function delete($id)
    {
        $email = $this->Admin_model->get_admin_by_id($id);

        $dataAuth = [
            "isActive" => 0,
        ];

        $where = [
            "email" => $email->fk_auth
        ];

        $delete = $this->Auth_model->update_auth($dataAuth, $where);
        if ($delete) {
            _set_flashdata($this, 'message', 'success', 'Delete data berhasil', 'dataInduk');
        } else {
            _set_flashdata($this, 'message', 'danger', 'Delete data gagal', 'dataInduk');
        }
    }
}
