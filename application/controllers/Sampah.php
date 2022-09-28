<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sampah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Sampah_model');
        $this->load->model('Role_model');
        $this->load->model('KategoriSampah_model');
    }
    function index()
    {
        $min = read_file(base_url("/assets/file/minSampah.txt"));

        $data = array(
            'title' => 'Kelola Data Sampah',
            'active' => 'Kelola Data Sampah',
            'user' => _get_user($this),
            'things' => $this->Sampah_model->get_all(),
            'listKategori' => $this->KategoriSampah_model->get_kategori(),
            'min' => $min
        );
        wrapper_templates($this, "sampah/index", $data);
    }

    function editMin()
    {
        $min = $this->input->post('minimal', true);
        if(write_file(FCPATH."assets/file/minSampah.txt", $min))
            _set_flashdata($this, 'minAngkut', 'success', 'Minimal Angkut Sampah berhasil diubah', 'sampah');
        else 
            _set_flashdata($this, 'minAngkut', 'danger', 'Minimal Angkut Sampah gagal diubah', 'sampah');
    }

    function create()
    {
        $data = array(
            'title' => 'Kelola Data Sampah',
            'active' => 'Kelola Data Sampah',
            'user' => _get_user($this),
            'things' => $this->Sampah_model->get_all(),
            'listKategori' => $this->KategoriSampah_model->get_kategori()
        );

        $config = [
            [
                "field" => "j_name",
                "label" => "Jenis Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "j_satuan",
                "label" => "Satuan Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "j_price",
                "label" => "Harga Sampah",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
            [
                "field" => "harga_pelapak",
                "label" => "Harga Pelapak",
                "rules" => "required|trim",
                "errors" => [
                    "required" => "%s wajib diisi"
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() == FALSE) {
            wrapper_templates($this, "sampah/create", $data);
        } else {
            $upload = $this->do_upload("j_img");
            if ($upload["status"]) {
                $j_name = xss_input($this->input->post("j_name", true));
                $j_price = xss_input($this->input->post("j_price", true));
                $harga_pelapak = xss_input($this->input->post("harga_pelapak", true));
                $j_satuan = xss_input($this->input->post("j_satuan", true));
                $fk_kategori = xss_input($this->input->post("fk_kategori", true));
                $dataSampah = [
                    "_id" => generate_id(),
                    "j_name" => $j_name,
                    "j_price" => $j_price,
                    "harga_pelapak" => $harga_pelapak,
                    "satuan" => $j_satuan,
                    "fk_kategori" => $fk_kategori,
                    "j_image" => $upload["pic"],
                ];

                $create = $this->Sampah_model->create_sampah($dataSampah);
                if ($create) {
                    _set_flashdata($this, 'sampah', 'success', 'Tambah Jenis Sampah Berhasil', 'sampah');
                } else {
                    _set_flashdata($this, 'sampah', 'danger', 'Tambah Jenis Sampah Gagal', 'sampah');
                }
            } else {
                _set_flashdata($this, 'sampah', 'danger', 'Upload Gambar Jenis Sampah Gagal', 'sampah');
            }
        }
    }

    function update($id = "")
    {
        if ($id !== "") {
            $where = ["jenis_sampah._id" => $id];
            $data = array(
                'title' => 'Kelola Data Sampah',
                'active' => 'Kelola Data Sampah',
                'user' => _get_user($this),
                'thing' => $this->Sampah_model->get_one($where),
                'listKategori' => $this->KategoriSampah_model->get_kategori()
            );

            $config = [
                [
                    "field" => "j_name",
                    "label" => "Jenis Sampah",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "j_satuan",
                    "label" => "Satuan Sampah",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "j_price",
                    "label" => "Harga Sampah",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
                [
                    "field" => "harga_pelapak",
                    "label" => "Harga Pelapak",
                    "rules" => "required|trim",
                    "errors" => [
                        "required" => "%s wajib diisi"
                    ]
                ],
            ];

            $this->form_validation->set_rules($config);
            if ($this->form_validation->run() == FALSE) {
                wrapper_templates($this, "sampah/update", $data);
            } else {
                $j_name = xss_input($this->input->post("j_name", true));
                $j_price = xss_input($this->input->post("j_price", true));
                $harga_pelapak = xss_input($this->input->post("harga_pelapak", true));
                $j_satuan = xss_input($this->input->post("j_satuan", true));
                $fk_kategori = xss_input($this->input->post("fk_kategori", true));
                $dataSampah = [
                    "j_name" => $j_name,
                    "j_price" => $j_price,
                    "harga_pelapak" => $harga_pelapak,
                    "satuan" => $j_satuan,
                    "fk_kategori" => $fk_kategori,
                ];

                $update = $this->Sampah_model->update_sampah($dataSampah, $where);
                if ($update) {
                    _set_flashdata($this, 'sampah', 'success', 'Ubah Jenis Sampah Berhasil', 'sampah');
                } else {
                    _set_flashdata($this, 'sampah', 'danger', 'Ubah Jenis Sampah Gagal', 'sampah');
                }
            }
        } else {
            _set_flashdata($this, 'sampah', 'danger', 'ID Invalid', 'sampah');
        }
    }

    function update_gambar($id)
    {
        if (isset($_POST['update_img'])) {
            if ($id !== "") {
                $where = ["jenis_sampah._id" => $id];
                $thing = $this->Sampah_model->get_one($where);
                if ($thing) {
                    $upload = $this->do_upload("j_img");
                    if ($upload["status"]) {
                        unlink($thing->j_image);
                        $dataSampah = [
                            "j_image" => $upload["pic"],
                        ];
                        $update = $this->Sampah_model->update_sampah($dataSampah, $where);
                        if ($update) {
                            _set_flashdata($this, 'sampah', 'success', 'Ubah Foto Jenis Sampah Berhasil', 'sampah');
                        } else {
                            _set_flashdata($this, 'sampah', 'danger', 'Ubah Foto Jenis Sampah Gagal', 'sampah');
                        }
                    } else {
                        $eng = trim($upload['error']['error'], "</p>");
                        $ind = [
                            "The file you are attempting to upload is larger than the permitted size." => "Gambar yang anda masukkan maksimal berukuran 512kb",
                            "The filetype you are attempting to upload is not allowed." => "File yang diupload harus dengan extensi .jpg/.jpeg/.png"
                        ];
                        _set_flashdata($this, 'sampah', 'danger', $ind[$eng], 'sampah');
                    }
                } else {
                    _set_flashdata($this, 'sampah', 'danger', 'Harap masukkan ID yang valid', 'sampah');
                }
            } else {
                _set_flashdata($this, 'sampah', 'danger', 'Harap Masukkan ID terlebih dahulu', 'sampah');
            }
        } else {
            _set_flashdata($this, 'sampah', 'danger', 'Harap isi gambar terlebih dahulu', 'sampah');
        }
    }

    function delete($id)
    {
        if ($id !== "") {
            $where = ["jenis_sampah._id" => $id];
            $jenis_sampah = $this->Sampah_model->get_one($where);
            $delete = $this->Sampah_model->delete_sampah($where);
            if ($delete) {
                unlink($jenis_sampah->j_image);
                _set_flashdata($this, 'sampah', 'success', 'Hapus Jenis Sampah berhasil', 'sampah');
            } else {
                _set_flashdata($this, 'sampah', 'danger', 'Hapus Jenis Sampah Gagal', 'sampah');
            }
        } else {
            _set_flashdata($this, 'sampah', 'danger', 'Harap Masukkan ID Jenis Sampah', 'sampah');
        }
    }

    public function do_upload($type)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$type]['name']);

        $config['upload_path']          = './uploads/sampah/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 1024;
        $config['file_name']            = $new_name;
        // $config['max_width']            = 1024;
        // $config['max_height']           = 768;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($type)) {
            $error = array('error' => $this->upload->display_errors());
            // _set_flashdata($this,'message','success','Update data berhasil','sampah/index');
            return array("status" => false, "error" => $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array("status" => true, "pic" => $config['upload_path'] . $new_name);
            // $this->load->view('upload_success', $data);
        }
    }

    function get_harga_by_id($id)
    {
        header('Content-Type: application/json');
        echo json_encode(["harga_pelapak" => $this->Sampah_model->get_one(["jenis_sampah._id" => $id])->harga_pelapak]);
    }
}
