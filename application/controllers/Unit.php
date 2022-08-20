<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Unit extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
        $this->load->model('Role_model');
        $this->load->model('Nasabah_model');
        $this->load->model('RequestSampah_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Mutasi_model');
        $this->load->model('Schedule_model');
        $this->load->model('Sampah_model');
    }
    function index()
    {
        $unit = $this->Unit_model->get_where(["fk_auth" => $this->session->userdata('email')])[0]->fk_admin;
        $induk = $this->Admin_model->get_where(["_id"=>$unit])[0]->fk_auth;
        $data = array(
            'title' => 'Dashboard Unit',
            'active' => 'Dashboard Unit',
            'user' => _get_user($this),
            'requests' => $this->RequestSampah_model->get_all_item_by_admin($induk),
            'nasabah' => $this->Nasabah_model->get_total(),
            'listSampah' => $this->Transaksi_model->get_data()
        );
        wrapper_templates($this, "dashboard/unit", $data);
    }

    function data()
    {
        $data = array(
            'title' => 'Data Admin Unit',
            'active' => 'Data Admin Unit',
            'user' => _get_user($this),
            'listAdmin' => $this->Unit_model->get_unit()
        );
        wrapper_templates($this, "admin/induk/index", $data);
    }

    function create()
    {
        $data = array(
            'title' => 'Request Sampah',
            'active' => 'Dashboard Induk',
            'user' => _get_user($this),
            'listSampah' => $this->Sampah_model->get_all(),
            'listJadwal' => $this->Schedule_model->get_schedule()
        );

        $config = [
            [
                "field" => "fk_garbage",
                "label" => "Jenis Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "fk_jadwal",
                "label" => "Jadwal Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "r_weight",
                "label" => "Berat Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ]
        ];

        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "dashboard/create_request", $data);
        } else {
            $upload = $this->do_upload('r_image');
            if ($upload["status"]) {
                $fk_garbage = xss_input($this->input->post("fk_garbage", true));
                $r_weight = xss_input($this->input->post("r_weight", true));
                $fk_jadwal = xss_input($this->input->post("fk_jadwal", true));
                $fk_nasabah = $this->Unit_model->get_where(["fk_auth" => $this->session->userdata("email")])[0]->_id;
                $dataRequest = [
                    "_id" => generate_id(),
                    "fk_garbage" => $fk_garbage,
                    "fk_nasabah" => $fk_nasabah,
                    "r_weight" => $r_weight,
                    "r_image" => xss_input($upload['pic']),
                    "r_notes" => "input by admin",
                    "r_request_date" => date("Y-m-d H:i:s"),
                    "fk_jadwal" => $fk_jadwal,
                    "r_status" => 2
                ];
                $insertRequest = $this->RequestSampah_model->create_request($dataRequest);
                if ($insertRequest) {
                    $this->create_transaction($dataRequest["_id"]);
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Gagal merequest sampah', 'induk');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Gagal upload foto sampah', 'induk');
            }
        }
    }

    function update($id)
    {
        if ($id !== "") {
            $where = ["_id" => $id];
            $data = array(
                'title' => 'Update data request',
                'active' => 'Dashboard Unit',
                'user' => _get_user($this),
                'request' => $this->RequestSampah_model->get_one($where),
                'listSampah' => $this->Sampah_model->get_all()
            );

            $config = [
                [
                    "field" => "fk_garbage",
                    "label" => "Jenis Sampah",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "r_weight",
                    "label" => "Berat Sampah",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
            ];

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "dashboard/update_request", $data);
            } else {
                $r_weight = xss_input($this->input->post("r_weight", true));
                $fk_garbage = xss_input($this->input->post("fk_garbage", true));
                $dataRequest = [
                    "r_weight" => $r_weight,
                    "fk_garbage" => $fk_garbage,
                ];

                $update = $this->RequestSampah_model->update_request($dataRequest, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Update Request Sampah Berhasil', 'unit');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Update Request Sampah Gagal', 'unit');
                }
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'ID Invalid', 'unit');
        }
    }

    function update_gambar($id)
    {
        if (isset($_POST['update_img'])) {
            if ($id !== "") {
                $where = ["_id" => $id];
                $thing = $this->RequestSampah_model->get_one($where);
                if ($thing) {
                    $upload = $this->do_upload("r_img");
                    if ($upload["status"]) {
                        unlink($thing->r_image);
                        $dataSampah = [
                            "r_image" => $upload["pic"],
                        ];
                        $update = $this->RequestSampah_model->update_request($dataSampah, $where);
                        if ($update) {
                            _set_flashdata($this, 'message', 'success', 'Ubah Foto Request Sampah Berhasil', 'unit');
                        } else {
                            _set_flashdata($this, 'message', 'danger', 'Ubah Foto Request Sampah Gagal', 'unit');
                        }
                    } else {
                        $eng = trim($upload['error']['error'], "</p>");
                        $ind = [
                            "The file you are attempting to upload is larger than the permitted size." => "Gambar yang anda masukkan maksimal berukuran 2048kb",
                            "The filetype you are attempting to upload is not allowed." => "File yang diupload harus dengan extensi .jpg/.jpeg/.png"
                        ];
                        _set_flashdata($this, 'message', 'danger', $ind[$eng], 'unit');
                    }
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Harap masukkan ID yang valid', 'unit');
                }
            } else {
                _set_flashdata($this, 'sampah', 'danger', 'Harap Masukkan ID terlebih dahulu', 'unit');
            }
        } else {
            _set_flashdata($this, 'sampah', 'danger', 'Harap isi gambar terlebih dahulu', 'unit');
        }
    }

    function accept_request($id)
    {
        if ($id) {
            $update = [
                "r_request_date" => date("Y-m-d H:i:s"),
                "r_status" => 1
            ];
            $where = [
                "_id" => $id
            ];
            $accept = $this->RequestSampah_model->update_request($update, $where);
            if ($accept) {
                _set_flashdata($this, 'message', 'success', 'Anda Berhasil mengonfirmasi request', 'unit');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Anda Gagal mengonfirmasi request', 'unit');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Silahkan Masukkan ID yang valid', 'unit');
        }
    }

    function finish_request($id)
    {
        if ($id) {
            $update = [
                "r_status" => 2
            ];
            $where = [
                "_id" => $id
            ];
            $accept = $this->RequestSampah_model->update_request($update, $where);
            if ($accept) {
                $this->create_transaction($id);
            } else {
                _set_flashdata($this, 'message', 'danger', 'Anda Gagal mengonfirmasi request', 'unit');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Silahkan Masukkan ID yang valid', 'unit');
        }
    }

    function create_transaction($req)
    {
        $data = [
            "_id" => generate_id(),
            "fk_request" => $req,
            "fk_auth" => $this->session->userdata('email'),
        ];
        $transaksi = $this->Transaksi_model->create_transaksi($data);
        if ($transaksi) {
            $this->create_mutation($req);
        } else {
            _set_flashdata($this, 'message', 'danger', 'Anda Gagal membuat transaksi', 'unit');
        }
    }

    function create_mutation($req)
    {
        $request = $this->RequestSampah_model->get_one(["_id" => $req]);
        $sampah = $this->Sampah_model->get_where(["_id" => $request->fk_garbage])[0];
        $id_nasabah = $request->fk_nasabah;
        $harga = $sampah->j_price * $request->r_weight;
        $data = [
            "_id" => generate_id(),
            "kode" => $sampah->j_name,
            "m_satuan" => $request->r_weight,
            "m_information" => "Penukaran dengan Barang $sampah->j_name",
            "m_type" => "Debit",
            "m_amount" => $harga,
            "fk_nasabah" => $id_nasabah
        ];
        $mutation = $this->Mutasi_model->create_mutasi($data);
        if ($mutation) {
            $this->add_balance($harga, $id_nasabah);
        } else {
            _set_flashdata($this, 'message', 'danger', 'Anda Gagal membuat mutasi', 'unit');
        }
    }

    function add_balance($amount, $fk_nasabah)
    {
        $where = [
            "_id" => $fk_nasabah
        ];
        $add = $this->Nasabah_model->balance($amount, $where, "+");
        if ($add) {
            _set_flashdata($this, 'message', 'success', 'Request telah selesai', 'unit');
        } else {
            _set_flashdata($this, 'message', 'danger', 'Anda Gagal menambah balance ke nasabah', 'unit');
        }
    }

    public function do_upload($type)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$type]['name']);
        $config['upload_path']          = './uploads/mobile/';
        $config['file_name']            = $new_name;
        $config['allowed_types']        = 'jpg|png|gif';
        $config['max_size']             = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($type)) {
            $error = array('error' => $this->upload->display_errors());
            return array("status" => false, "error" => $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array("status" => true, "pic" => $config['upload_path'] . $new_name);
        }
    }
}
