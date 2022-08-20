<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pemasukan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Pemasukan_model');
        $this->load->model('Pelapak_model');
        $this->load->model('Sampah_model');
    }

    function index()
    {
        $listPemasukan = $this->Pemasukan_model->get_where(["fk_auth" => $this->session->userdata("email")]);
        $data = array(
            'title' => 'Data Pemasukan',
            'active' => 'Data Keuangan',
            'user' => _get_user($this),
            'listPemasukan' => $listPemasukan,
        );
        wrapper_templates($this, "pemasukan/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Tambah Data Pemasukan',
            'active' => 'Data Keuangan',
            'user' => _get_user($this),
            'listSampah' => $this->Sampah_model->get_all(),
            'listPelapak' => $this->Pelapak_model->get_pelapak()
        );
        $config = [
            [
                'field' => 'fk_garbage',
                'label' => 'Jenis Sampah',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pm_hasil',
                'label' => 'Produk Hasil',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pm_jumlah',
                'label' => 'Jumlah',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pm_total',
                'label' => 'Total Harga',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pm_created_at',
                'label' => 'Tanggal Penjualan',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'fk_pelapak',
                'label' => 'Pelapak',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "pemasukan/create", $data);
        } else {
            $fk_garbage = xss_input($this->input->post('fk_garbage', true));
            $pm_hasil = xss_input($this->input->post('pm_hasil', true));
            $pm_jumlah = xss_input($this->input->post('pm_jumlah', true));
            $pm_total = xss_input($this->input->post('pm_total', true));
            $pm_created_at = xss_input($this->input->post('pm_created_at', true));
            $fk_pelapak = xss_input($this->input->post('fk_pelapak', true));
            $dataPemasukan = [
                "_id" => generate_id(),
                "pm_jumlah" => $pm_jumlah,
                "pm_hasil" => $pm_hasil,
                "pm_total" => $pm_total,
                "fk_garbage" => $fk_garbage,
                "pm_created_at" => $pm_created_at,
                "fk_pelapak" => $fk_pelapak,
                "fk_auth" => $this->session->userdata("email"),
            ];
            $create = $this->Pemasukan_model->create_pemasukan($dataPemasukan);
            if ($create) {
                _set_flashdata($this, 'message', 'success', 'Tambah Data Pemasukan Berhasil', 'pemasukan');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Tambah Data Pemasukan Gagal', 'pemasukan');
            }
        }
    }

    function update($id)
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'pemasukan');
        } else {
            $data = array(
                'title' => 'Update Data Pemasukan',
                'active' => 'Data Keuangan',
                'user' => _get_user($this),
                'listSampah' => $this->Sampah_model->get_all(),
                'pemasukan' => $this->Pemasukan_model->get_where(["pemasukan._id" => $id])[0],
                'listPelapak' => $this->Pelapak_model->get_pelapak()
            );

            $config = [
                [
                    'field' => 'fk_garbage',
                    'label' => 'Jenis Sampah',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pm_hasil',
                    'label' => 'Produk Hasil',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pm_jumlah',
                    'label' => 'Jumlah',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pm_total',
                    'label' => 'Total Harga',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pm_created_at',
                    'label' => 'Tanggal Penjualan',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'fk_pelapak',
                    'label' => 'Pelapak',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
            ];

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() === FALSE) {
                wrapper_templates($this, "pemasukan/update", $data);
            } else {
                $fk_garbage = xss_input($this->input->post('fk_garbage', true));
                $pm_hasil = xss_input($this->input->post('pm_hasil', true));
                $pm_jumlah = xss_input($this->input->post('pm_jumlah', true));
                $pm_total = xss_input($this->input->post('pm_total', true));
                $pm_created_at = xss_input($this->input->post('pm_created_at', true));
                $fk_pelapak = xss_input($this->input->post('fk_pelapak', true));
                $dataPemasukan = [
                    "pm_jumlah" => $pm_jumlah,
                    "pm_hasil" => $pm_hasil,
                    "pm_total" => $pm_total,
                    "fk_garbage" => $fk_garbage,
                    "pm_created_at" => $pm_created_at,
                    "fk_pelapak" => $fk_pelapak,
                    "fk_auth" => $this->session->userdata("email"),
                ];

                $where = [
                    "pemasukan._id" => $id
                ];

                $update = $this->Pemasukan_model->update_pemasukan($dataPemasukan, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Update Data Pemasukan Berhasil', 'pemasukan');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Update Data Pemasukan Gagal', 'pemasukan');
                }
            }
        }
    }

    function delete($id)
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'pemasukan');
        } else {
            $wherePemasukan = ["_id" => $id];
            $deletePemasukan = $this->Pemasukan_model->delete_pemasukan($wherePemasukan);
            if ($deletePemasukan) {
                _set_flashdata($this, 'message', 'success', 'Hapus Data Pemasukan berhasil', 'pemasukan');
            } else {
                _set_flashdata($this, 'message', 'success', 'Hapus Data Pemasukan Gagal', 'pemasukan');
            }
        }
    }
    function get_harga_by_id($id)
    {
        header('Content-Type: application/json');
        echo json_encode(["harga_pelapak" => $this->Sampah_model->get_one(["jenis_sampah._id" => $id])->harga_pelapak]);
    }
}
