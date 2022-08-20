<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Nasabah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Auth_model');
        $this->load->model('Role_model');
        $this->load->model('Unit_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Mutasi_model');
    }
    function index()
    {
        $user = _get_user($this);
        $data = array(
            'title' => $user->r_name == "Admin Induk" ? 'Data Nasabah' : "Balance Nasabah",
            'active' => 'Data Nasabah',
            'user' => $user,
            'listNasabah' => $this->Nasabah_model->get_nasabah()
        );
        wrapper_templates($this, "nasabah/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Tambah Nasabah',
            'active' => 'Data Nasabah',
            'user' => _get_user($this),
        );

        $config = [
            [
                "field" => "n_name",
                "label" => "Nama Lengkap",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_dob",
                "label" => "Tanggal Lahir",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "email",
                "label" => "Email",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "password",
                "label" => "Password",
                "rules" => "required|trim|min_length[5]",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_balance",
                "label" => "Saldo",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_contact",
                "label" => "No Hp",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_address",
                "label" => "Alamat",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_city",
                "label" => "Kota",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_province",
                "label" => "Provinsi",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "n_postcode",
                "label" => "Kode Pos",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "nasabah/create", $data);
        } else {
            $email = xss_input($this->input->post("email", true));
            $password = xss_input($this->input->post("password", true));
            $n_name = xss_input($this->input->post("n_name", true));
            $n_dob = xss_input($this->input->post("n_dob", true));
            $n_balance = xss_input($this->input->post("n_balance", true));
            $n_address = xss_input($this->input->post("n_address", true));
            $n_province = xss_input($this->input->post("n_province", true));
            $n_city = xss_input($this->input->post("n_city", true));
            $n_postcode = xss_input($this->input->post("n_postcode", true));
            $n_contact = xss_input($this->input->post("n_contact", true));

            $dataAuth = [
                "email" => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "fk_role" => "4ea170807728f752a1a91cb4502855ce",
                "isActive" => 1
            ];
            $userAuth = $this->Auth_model->cek_nasabah($email);
            if (!$userAuth) {
                $insertAuth = $this->Auth_model->create_admin_auth($dataAuth);
                if ($insertAuth) {
                    $dataNasabah = [
                        "_id" => generate_id(),
                        "fk_auth" => $email,
                        "n_name" => $n_name,
                        "n_dob" => $n_dob,
                        "n_balance" => $n_balance,
                        "n_address" => $n_address,
                        "n_province" => $n_province,
                        "n_city" => $n_city,
                        "n_postcode" => $n_postcode,
                        "n_contact" => $n_contact,
                        "isExist" => 1,
                        "n_status" => "offline"
                    ];

                    $create = $this->Nasabah_model->create_nasabah($dataNasabah);
                    if ($create) {
                        _set_flashdata($this, 'message', 'success', 'Tambah Nasabah Berhasil', 'nasabah');
                    } else {
                        _set_flashdata($this, 'message', 'danger', 'Tambah Nasabah Gagal', 'nasabah/create');
                    }
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Gagal menambahkan admin auth nasabah', 'nasabah/create');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Email sudah dipakai', 'nasabah/create');
            }
        }
    }

    function update($id = "")
    {
        if ($id !== "") {
            $where = ["_id" => $id];
            $data = array(
                'title' => 'Ubah Data Nasabah',
                'active' => 'Data Nasabah',
                'user' => _get_user($this),
                'nasabah' => $this->Nasabah_model->get_where($where)[0]
            );

            $config = [
                [
                    "field" => "n_name",
                    "label" => "Nama Lengkap",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_dob",
                    "label" => "Tanggal Lahir",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_balance",
                    "label" => "Saldo",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_contact",
                    "label" => "No Hp",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_address",
                    "label" => "Alamat",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_city",
                    "label" => "Kota",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_province",
                    "label" => "Provinsi",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "n_postcode",
                    "label" => "Kode Pos",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ]
            ];

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "nasabah/update", $data);
            } else {
                $n_name = xss_input($this->input->post("n_name", true));
                $n_dob = xss_input($this->input->post("n_dob", true));
                $n_balance = xss_input($this->input->post("n_balance", true));
                $n_address = xss_input($this->input->post("n_address", true));
                $n_province = xss_input($this->input->post("n_province", true));
                $n_city = xss_input($this->input->post("n_city", true));
                $n_postcode = xss_input($this->input->post("n_postcode", true));
                $n_contact = xss_input($this->input->post("n_contact", true));
                $dataNasabah = [
                    "n_name" => $n_name,
                    "n_dob" => $n_dob,
                    "n_balance" => $n_balance,
                    "n_address" => $n_address,
                    "n_province" => $n_province,
                    "n_city" => $n_city,
                    "n_postcode" => $n_postcode,
                    "n_contact" => $n_contact,
                ];

                $update = $this->Nasabah_model->update_nasabah($dataNasabah, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Ubah Nasabah Berhasil', 'nasabah');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Ubah Nasabah Gagal', 'nasabah/update');
                }
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'ID Invalid', 'nasabah/update');
        }
    }

    function update_auth($id = "")
    {
        if ($id !== "") {
            $where = ["_id" => $id];
            $data = array(
                'title' => 'Ubah Data Nasabah',
                'active' => 'Data Nasabah',
                'user' => _get_user($this),
                'nasabah' => $this->Nasabah_model->get_where($where)[0]
            );

            $config = [
                [
                    "field" => "password",
                    "label" => "Password",
                    'rules' => 'required|trim|min_length[5]',
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "cpassword",
                    "label" => "Konfirmasi Password",
                    'rules' => 'required|trim|min_length[5]|matches[password]',
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
            ];

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "nasabah/update", $data);
            } else {
                $email = xss_input($this->input->post("email", true));
                $password = xss_input($this->input->post("password", true));
                $dataAuth = [
                    "password" => $password,
                ];
                $where = [
                    "email" => $email
                ];
                $update = $this->Auth_model->update_auth($dataAuth, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Ubah Password Berhasil', 'nasabah');
                } else {
                    _set_flashdata($this, 'message2', 'danger', 'Ubah Password Gagal', 'nasabah/update');
                }
            }
        } else {
            _set_flashdata($this, 'message2', 'danger', 'ID Invalid', 'nasabah/update');
        }
    }

    function balance()
    {
        $data = array(
            'title' => 'Balance Nasabah',
            'active' => 'Balance Nasabah',
            'user' => _get_user($this),
            'listBalance' => $this->Nasabah_model->get_nasabah()
        );

        wrapper_templates($this, "nasabah/balance", $data);
    }

    function get_mutasi_nasabah($id)
    {
        $data = array(
            'title' => 'Mutasi Nasabah',
            'active' => 'Data Nasabah',
            'user' => _get_user($this),
            'listMutasi' => $this->Mutasi_model->get_where(["fk_nasabah" => $id])
        );

        wrapper_templates($this, "nasabah/mutasi", $data);
    }

    function get_data($id)
    {
        $data = $this->Nasabah_model->get_where(['_id' => $id]);
        echo json_encode($data);
    }
}
