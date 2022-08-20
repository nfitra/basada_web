<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Pelapak extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Pelapak_model');
    }
    function index()
    {
        $data = array(
            'title' => 'Pelapak',
            'active' => 'Pelapak',
            'user' => _get_user($this),
            'listPelapak' => $this->Pelapak_model->get_pelapak()
        );
        wrapper_templates($this, "pelapak/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Tambah Pelapak',
            'active' => 'Pelapak',
            'user' => _get_user($this),
        );

        $config = [
            [
                "field" => "p_nama",
                "label" => "Nama Pelapak",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "p_kontak",
                "label" => "Kontak Pelapak",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "p_alamat",
                "label" => "Alamat Pelapak",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "pelapak/create", $data);
        } else {
            $p_nama = xss_input($this->input->post("p_nama", true));
            $p_kontak = xss_input($this->input->post("p_kontak", true));
            $p_alamat = xss_input($this->input->post("p_alamat", true));
            $dataPelapak = [
                "_id" => generate_id(),
                "p_nama" => $p_nama,
                "p_kontak" => $p_kontak,
                "p_alamat" => $p_alamat,
            ];

            $create = $this->Pelapak_model->create_pelapak($dataPelapak);
            if ($create) {
                _set_flashdata($this, 'message', 'success', 'Tambah Pelapak Berhasil', 'pelapak');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Tambah Pelapak Gagal', 'pelapak');
            }
        }
    }

    function update($id = "")
    {
        if ($id !== "") {
            $where = ["_id" => $id];
            $data = array(
                'title' => 'Ubah Pelapak',
                'active' => 'Pelapak',
                'user' => _get_user($this),
                'pelapak' => $this->Pelapak_model->get_where($where)[0]
            );

            $config = [
                [
                    "field" => "p_nama",
                    "label" => "Nama Pelapak",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "p_kontak",
                    "label" => "Kontak Pelapak",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "p_alamat",
                    "label" => "Alamat Pelapak",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ]
            ];

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "pelapak/update", $data);
            } else {
                $p_nama = xss_input($this->input->post("p_nama", true));
                $p_kontak = xss_input($this->input->post("p_kontak", true));
                $p_alamat = xss_input($this->input->post("p_alamat", true));
                $dataPelapak = [
                    "p_nama" => $p_nama,
                    "p_kontak" => $p_kontak,
                    "p_alamat" => $p_alamat,
                ];

                $update = $this->Pelapak_model->update_pelapak($dataPelapak, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Ubah Pelapak Berhasil', 'pelapak');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Ubah Pelapak Gagal', 'pelapak');
                }
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'ID Invalid', 'pelapak');
        }
    }

    function delete($id)
    {
        if ($id !== "") {
            $where = ["_id" => $id];
            $delete = $this->Pelapak_model->delete_pelapak($where);
            if ($delete) {
                _set_flashdata($this, 'message', 'success', 'Hapus Pelapak berhasil', 'pelapak');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Hapus Pelapak Gagal', 'pelapak');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Harap Masukkan ID Pelapak', 'pelapak');
        }
    }
}
