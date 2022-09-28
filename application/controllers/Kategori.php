<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Artikel_model');
        $this->load->model('Kategori_model');
    }

    function index()
    {
        $listKategori = $this->Kategori_model->get_kategori();
        $data = array(
            'title'=>'Kategori Artikel',
            'active'=>'Artikel',
            'user'=>_get_user($this),
            'listKategori'=>$listKategori,
        );
        wrapper_templates($this, "kategori/artikel/index", $data);
    }

    function create()
    {
        $listKategori = $this->Kategori_model->get_kategori();
        $data = array(
            'title'=>'Tambah Kategori Artikel',
            'active'=>'Artikel',
            'user'=>_get_user($this),
            'listKategori'=>$listKategori,
        );
        $config = [
            [
                'field'=>'k_name',
                'label'=>'Nama Kategori',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            wrapper_templates($this, "kategori/artikel/create", $data);
        } else {
            $k_name = xss_input($this->input->post('k_name', true));
            $dataKategori = [
                "_id" => generate_id(),
                "k_name" => $k_name,
            ];
            $create = $this->Kategori_model->create_kategori($dataKategori);
            if($create){
                _set_flashdata($this,'message', 'success', 'Tambah Kategori Artikel Berhasil', 'kategori');
            } else {
                _set_flashdata($this,'message', 'danger', 'Tambah Kategori Artikel Gagal', 'kategori');
            }
        }
    }

    function _get_user()
    {
        // var_dump();
        $email = $this->session->userdata('email');
        return $this->Admin_model->get_admin_by_email($email);
    }

    function update($id)
    {
        if($id == ""){
            _set_flashdata($this,'message','success','Silahkan Masukkan ID yang valid','kategori');
        }
        else{
            $data = array(
                'title'=>'Update Data Kategori',
                'active'=>'Artikel',
                'user' => _get_user($this),
                'dataKategori' => $this->Kategori_model->get_kategori_by_id($id)
            );

            $config = [
                [
                    'field'=>'k_name',
                    'label'=>'Nama Kategori',
                    'rules'=>'required|trim',
                    'errors'=>[
                        'required' => '%s wajib diisi'
                    ]
                ],
            ];

            $this->form_validation->set_rules($config);

            if($this->form_validation->run()===FALSE){
                wrapper_templates($this, "kategori/artikel/update", $data);
            } else {
                $dataUpdate = [
                    "k_name" => xss_input($this->input->post('k_name', true))
                ];

                $where = [
                    "_id" => $id
                ];
                
                $update = $this->Kategori_model->update_kategori($dataUpdate, $where);
                if($update){
                    _set_flashdata($this,'message','success','Update data berhasil','kategori');
                }
                else{
                    _set_flashdata($this,'message','danger','Update data gagal','kategori');
                }
            }
        }
    }

    function update_gambar($id)
    {
        if(isset($_POST['update_img'])){
            if($id !== ""){
                $where = [
                    "_id"=>$id
                ];
                $thing = $this->Artikel_model->get_artikel_by_id($id);
                if($thing){
                    $upload = $this->do_upload("a_image");
                    if($upload["status"]){
                        unlink('uploads/'.$thing->a_image);
                        $dataArtikel = [
                            "a_image" => $upload["pic"],
                        ];
                        $update = $this->Artikel_model->update_gambar($dataArtikel, $where);
                        if($update){
                            _set_flashdata($this,'message', 'success', 'Ubah Foto Artikel Berhasil', 'artikel');
                        } else {
                            _set_flashdata($this,'message', 'danger', 'Ubah Foto Artikel Gagal', 'artikel');
                        }
                    } else {
                        //_set_flashdata($this,'message', 'danger', 'Image Harus lebih kecil dari 512MB', 'artikel');
                        _set_flashdata($this,'message', 'danger', $upload['error']['error'], 'artikel');
                    }
                } else {
                    _set_flashdata($this,'message', 'danger', 'Harap masukkan ID yang valid', 'artikel');
                }
            } else {
                _set_flashdata($this,'message', 'danger', 'Harap Masukkan ID terlebih dahulu', 'artikel');
            }
        } else {
            _set_flashdata($this,'message', 'danger', 'Harap isi gambar terlebih dahulu', 'artikel');
        }
    }

    function delete($id)
    {
        if($id == ""){
            _set_flashdata($this,'message','success','Silahkan Masukkan ID yang valid','kategoriSampah');
        }
        else{
            $whereKategori = ["_id"=>$id];
            $dataArtikel = $this->Artikel_model->get_artikel_by_kategori($id);
            foreach($dataArtikel as $artikel){
                $whereArtikel = ["fk_kategori" => $artikel->fk_kategori];
                unlink('uploads/'.$artikel->a_file);
                $deleteArtikel = $this->Artikel_model->delete_artikel($whereArtikel);
            }
            
            $deleteKategori = $this->Kategori_model->delete_kategori($whereKategori);
            if($deleteKategori){
                _set_flashdata($this,'message', 'success', 'Hapus Kategori Artikel berhasil', 'kategori');
            } else {
                _set_flashdata($this,'message', 'success', 'Hapus Kategori Artikel Gagal', 'kategori');
            }
        }
    }

    public function do_upload($type)
    {
        $new_name = time().str_replace(' ','_', $_FILES[$type]['name']);

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size']             = 512;
        $config['file_name']            = $new_name;

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($type))
        {
            $error = array('error' => $this->upload->display_errors());
            // _set_flashdata($this,'message','success','Update data berhasil','sampah/index');
            return array("status"=>false, "error"=>$error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            return array("status"=>true, "pic"=>$new_name);
            // $this->load->view('upload_success', $data);
        }
    }
}
