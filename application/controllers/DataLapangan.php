<?php

defined('BASEPATH') or exit('No direct script access allowed');

class DataLapangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
    }

    function index()
    {
        $id = $this->Admin_model->get_id_by_email($this->session->userdata['email']);
        $where = [
            'fk_admin' => $id->_id,
            'r_name' => "Admin Lapangan"
        ];
        $data = array(
            'title' => 'Admin Lapangan',
            'active' => 'Admin Lapangan',
            'user' => _get_user($this),
            'listLapangan' => $this->Unit_model->get_where($where)
        );
        wrapper_templates($this, "lapangan/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Tambah Admin Lapangan',
            'active' => 'Admin Lapangan',
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
            ]
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "unit/create", $data);
        } else {
            $email = xss_input($this->input->post('email', true));
            $password = xss_input($this->input->post('password', true));
            $dataAuth = [
                "email" => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "fk_role" => "698544b464b4c7d9030861bce41436b7",
                "isActive" => 1
            ];
            $insertAuth = $this->Auth_model->create_auth($dataAuth);
            if ($insertAuth) {
                $un_name = xss_input($this->input->post('un_name', true));
                $un_est = xss_input($this->input->post('un_est', true));
                $un_sk = xss_input($this->input->post('un_sk', true));
                $un_status = xss_input($this->input->post('un_status', true));
                $un_address = xss_input($this->input->post('un_address', true));
                $un_location = xss_input($this->input->post('un_location', true));
                $un_district = xss_input($this->input->post('un_district', true));
                $un_employees = xss_input($this->input->post('un_employees', true));
                $un_manager = xss_input($this->input->post('un_manager', true));
                $un_contact = xss_input($this->input->post('un_contact', true));
                $id = $this->Admin_model->get_id_by_email($this->session->userdata['email']);
                $dataUnit = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                    "fk_admin" => $id->_id,
                    "un_name" => $un_name,
                    "un_est" => $un_est,
                    "un_sk" => $un_sk,
                    "un_status" => $un_status,
                    "un_address" => $un_address,
                    "un_location" => $un_location,
                    "un_district" => $un_district,
                    "un_employees" => $un_employees,
                    "un_manager" => $un_manager,
                    "un_contact" => $un_contact
                ];

                $insertUnit = $this->Unit_model->create_unit($dataUnit);
                if ($insertUnit) {
                    _set_flashdata($this, 'message', 'success', 'Tambah unit berhasil', 'dataLapangan');
                } else {
                    $deleteDataAuth = [
                        "email" => $email
                    ];
                    $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                    _set_flashdata($this, 'message', 'danger', 'Tambah unit gagal', 'dataLapangan');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Tambah data auth gagal', 'dataLapangan');
            }
        }
    }

    function update($id = "")
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'dataLapangan');
        } else {
            $data = array(
                'title' => 'Update Data Lapangan',
                'active' => 'Admin Lapangan',
                'user' => _get_user($this),
                'unit' => $this->Unit_model->get_where(["unit._id" => $id])[0]
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

            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "lapangan/update", $data);
            } else {
                $email = xss_input($this->input->post('email', true));
                $password = xss_input($this->input->post('password', true));
                $dataAuth = [
                    "password" => password_hash($password, PASSWORD_BCRYPT)
                ];
                $updateAuth = $this->Auth_model->update_auth($dataAuth, ['email' => $email]);
                if ($updateAuth) {
                    $un_name = xss_input($this->input->post('un_name', true));
                    $un_est = xss_input($this->input->post('un_est', true));
                    $un_sk = xss_input($this->input->post('un_sk', true));
                    $un_status = xss_input($this->input->post('un_status', true));
                    $un_address = xss_input($this->input->post('un_address', true));
                    $un_location = xss_input($this->input->post('un_location', true));
                    $un_district = xss_input($this->input->post('un_district', true));
                    $un_employees = xss_input($this->input->post('un_employees', true));
                    $un_manager = xss_input($this->input->post('un_manager', true));
                    $un_contact = xss_input($this->input->post('un_contact', true));
                    $dataUnit = [
                        "un_name" => $un_name,
                        "un_est" => $un_est,
                        "un_sk" => $un_sk,
                        "un_status" => $un_status,
                        "un_address" => $un_address,
                        "un_location" => $un_location,
                        "un_district" => $un_district,
                        "un_employees" => $un_employees,
                        "un_manager" => $un_manager,
                        "un_contact" => $un_contact
                    ];

                    $updateUnit = $this->Unit_model->update_unit($dataUnit, ['_id' => $id]);
                    if ($updateUnit) {
                        _set_flashdata($this, 'message', 'success', 'Ubah data lapangan berhasil', 'dataLapangan');
                    } else {
                        $deleteDataAuth = [
                            "email" => $email
                        ];
                        $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                        _set_flashdata($this, 'message', 'danger', 'Ubah data lapangan gagal', 'dataLapangan');
                    }
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Ubah data auth gagal', 'dataLapangan');
                }
            }
        }
    }

    function updateAuth($id = "")
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'dataLapangan');
        } else {
            $data = array(
                'title' => 'Update Data Lapangan',
                'active' => 'Admin Lapangan',
                'user' => _get_user($this),
                'unit' => $this->Unit_model->get_where(["_id" => $id])[0]
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
                ]
            ];

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "lapangan/update", $data);
            } else {
                $email = xss_input($this->input->post('email', true));
                $password = xss_input($this->input->post('password', true));
                $dataAuth = [
                    "password" => password_hash($password, PASSWORD_BCRYPT)
                ];
                $updateAuth = $this->Auth_model->update_auth($dataAuth, ['email' => $email]);
                if ($updateAuth) {
                    _set_flashdata($this, 'message', 'success', 'Ubah data auth berhasil', 'dataLapangan');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Ubah data auth gagal', 'dataLapangan');
                }
            }
        }
    }

    function delete($id = "")
    {
        if ($id) {
            $where = ["_id" => $id];
            $delete = $this->Unit_model->delete_unit($where);
            if ($delete) {
                _set_flashdata($this, 'message', 'success', 'Hapus Unit berhasil', 'dataLapangan');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Hapus Unit Gagal', 'dataLapangan');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Silahkan masukkan ID yang valid', 'dataLapangan');
        }
    }
}
