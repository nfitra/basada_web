<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pengeluaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
        $this->load->model('Pengeluaran_model');
    }

    function index()
    {
        $listPengeluaran = $this->Pengeluaran_model->get_where(["pengeluaran.fk_auth" => $this->session->userdata("email")]);
        for($i = 0; $i < count($listPengeluaran); $i++) {
            $role = $this->Auth_model->get_where(['email' => $listPengeluaran[$i]->fk_admin])[0]->fk_role;
            if($role == "cee6de74c28ff53dcdf3da10f3ee1c05") {
                $listPengeluaran[$i]->un_name = $this->Admin_model->get_where(['fk_auth'=>$listPengeluaran[$i]->fk_admin])[0]->un_name;
            }
            else{
                $listPengeluaran[$i]->un_name = $this->Unit_model->get_where(['fk_auth'=>$listPengeluaran[$i]->fk_admin])[0]->un_name;
            }
        }
        $data = array(
            'title' => 'Data Pengeluaran',
            'active' => 'Data Keuangan',
            'user' => _get_user($this),
            'listPengeluaran' => $listPengeluaran,
        );
        wrapper_templates($this, "pengeluaran/index", $data);
    }

    function create()
    {
        $id = $this->Admin_model->get_where(['fk_auth' => $this->session->userdata('email')])[0]->_id;
        $data = array(
            'title' => 'Tambah Data Pengeluaran',
            'active' => 'Data Keuangan',
            'user' => _get_user($this),
            'listUnit' => $this->Unit_model->get_where(['fk_admin'=>$id])
        );
        $config = [
            [
                'field' => 'pk_bulan',
                'label' => 'Bulan',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pk_jenis',
                'label' => 'Jenis Pengeluaran',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pk_jumlah',
                'label' => 'Jumlah',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'pk_harga',
                'label' => 'Harga Satuan',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'fk_admin',
                'label' => 'Bank Unit',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "pengeluaran/create", $data);
        } else {
            $upload = $this->do_upload("pk_bukti");
            if ($upload["status"]) {
                $pk_bulan = xss_input($this->input->post('pk_bulan', true));
                $pk_jenis = xss_input($this->input->post('pk_jenis', true));
                $pk_jumlah = xss_input($this->input->post('pk_jumlah', true));
                $pk_harga = xss_input($this->input->post('pk_harga', true));
                $pk_total = xss_input($this->input->post('pk_total', true));
                $fk_admin = xss_input($this->input->post('fk_admin', true));
                $pk_keterangan = xss_input($this->input->post('pk_keterangan', true));
                $dataPengeluaran = [
                    "_id" => generate_id(),
                    "pk_bulan" => $pk_bulan,
                    "pk_jenis" => $pk_jenis,
                    "pk_jumlah" => $pk_jumlah,
                    "pk_harga" => $pk_harga,
                    "pk_total" => $pk_total,
                    "pk_keterangan" => $pk_keterangan,
                    "fk_admin" => $fk_admin,
                    "pk_bukti" => $upload["pic"],
                    "fk_auth" => $this->session->userdata("email"),
                ];
                $create = $this->Pengeluaran_model->create_pengeluaran($dataPengeluaran);
                if ($create) {
                    _set_flashdata($this, 'message', 'success', 'Tambah Data Pengeluaran Berhasil', 'pengeluaran');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Tambah Data Pengeluaran Gagal', 'pengeluaran');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Upload Bukti Pengeluaran Gagal', 'pengeluaran');
            }
        }
    }

    function update($id)
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'pengeluaran');
        } else {
            $_id = $this->Admin_model->get_where(['fk_auth' => $this->session->userdata('email')])[0]->_id;
            $data = array(
                'title' => 'Update Data Pengeluaran',
                'active' => 'Data Keuangan',
                'user' => _get_user($this),
                'pengeluaran' => $this->Pengeluaran_model->get_where(["_id" => $id])[0],
                'listUnit' => $this->Unit_model->get_where(['fk_admin'=>$_id])
            );

            $config = [
                [
                    'field' => 'pk_bulan',
                    'label' => 'Bulan',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pk_jenis',
                    'label' => 'Jenis Pengeluaran',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pk_jumlah',
                    'label' => 'Jumlah',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'pk_harga',
                    'label' => 'Harga Satuan',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ],
                [
                    'field' => 'fk_admin',
                    'label' => 'Bank Unit',
                    'rules' => 'required|trim',
                    'errors' => [
                        'required' => '%s wajib diisi'
                    ]
                ]
            ];

            $this->form_validation->set_rules($config);

            if ($this->form_validation->run() === FALSE) {
                wrapper_templates($this, "pengeluaran/update", $data);
            } else {
                $pk_bulan = xss_input($this->input->post('pk_bulan', true));
                $pk_jenis = xss_input($this->input->post('pk_jenis', true));
                $pk_jumlah = xss_input($this->input->post('pk_jumlah', true));
                $pk_harga = xss_input($this->input->post('pk_harga', true));
                $pk_total = xss_input($this->input->post('pk_total', true));
                $fk_admin = xss_input($this->input->post('fk_admin', true));
                $pk_keterangan = xss_input($this->input->post('pk_keterangan', true));
                $dataPengeluaran = [
                    "pk_bulan" => $pk_bulan,
                    "pk_jenis" => $pk_jenis,
                    "pk_jumlah" => $pk_jumlah,
                    "pk_harga" => $pk_harga,
                    "pk_total" => $pk_total,
                    "pk_keterangan" => $pk_keterangan,
                    "fk_admin" => $fk_admin,
                    "fk_auth" => $this->session->userdata("email"),
                ];

                $where = [
                    "_id" => $id
                ];

                $update = $this->Pengeluaran_model->update_pengeluaran($dataPengeluaran, $where);
                if ($update) {
                    _set_flashdata($this, 'message', 'success', 'Update Data Pengeluaran Berhasil', 'pengeluaran');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Update Data Pengeluaran Gagal', 'pengeluaran');
                }
            }
        }
    }

    function update_gambar($id)
    {
        if (isset($_POST['update_img'])) {
            if ($id !== "") {
                $where = ["_id" => $id];
                $thing = $this->Pengeluaran_model->get_where($where)[0];
                if ($thing) {
                    $upload = $this->do_upload("pk_bukti");
                    if ($upload["status"]) {
                        unlink($thing->pk_bukti);
                        $dataPengeluaran = [
                            "pk_bukti" => $upload["pic"],
                        ];
                        $update = $this->Pengeluaran_model->update_pengeluaran($dataPengeluaran, $where);
                        if ($update) {
                            _set_flashdata($this, 'message', 'success', 'Ubah Foto Bukti Pengeluaran Berhasil', 'pengeluaran');
                        } else {
                            _set_flashdata($this, 'message', 'danger', 'Ubah Foto Bukti Pengeluaran Gagal', 'pengeluaran');
                        }
                    } else {
                        $eng = trim($upload['error']['error'], "</p>");
                        $ind = [
                            "The file you are attempting to upload is larger than the permitted size." => "Gambar yang anda masukkan maksimal berukuran 512kb",
                            "The filetype you are attempting to upload is not allowed." => "File yang diupload harus dengan extensi .jpg/.jpeg/.png",
                            "You did not select a file to upload." => "Silahkan pilih foto anda terlebih dahulu"
                        ];
                        _set_flashdata($this, 'message', 'danger', $ind[$eng], 'pengeluaran');
                    }
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Harap masukkan ID yang valid', 'pengeluaran');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Harap Masukkan ID terlebih dahulu', 'pengeluaran');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Harap isi gambar terlebih dahulu', 'pengeluaran');
        }
    }

    function delete($id)
    {
        if ($id == "") {
            _set_flashdata($this, 'message', 'success', 'Silahkan Masukkan ID yang valid', 'pengeluaran');
        } else {
            $wherePengeluaran = ["_id" => $id];
            $deletePengeluaran = $this->Pengeluaran_model->delete_pengeluaran($wherePengeluaran);
            if ($deletePengeluaran) {
                _set_flashdata($this, 'message', 'success', 'Hapus Data Pengeluaran berhasil', 'pengeluaran');
            } else {
                _set_flashdata($this, 'message', 'success', 'Hapus Data Pengeluaran Gagal', 'pengeluaran');
            }
        }
    }
    public function do_upload($type)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$type]['name']);

        $config['upload_path']          = './uploads/bukti_pengeluaran/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 2048;
        $config['file_name']            = $new_name;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

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
