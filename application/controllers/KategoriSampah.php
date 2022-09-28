<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class KategoriSampah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Sampah_model');
        $this->load->model('KategoriSampah_model');
    }

    function index()
    {
        $listKategori = $this->KategoriSampah_model->get_kategori();
        $data = array(
            'title'=>'Kategori Sampah',
            'active'=>'Kelola Data Sampah',
            'user'=>_get_user($this),
            'listKategori'=>$listKategori,
        );
        wrapper_templates($this, "kategori/sampah/index", $data);
    }

    function create()
    {
        $listKategori = $this->KategoriSampah_model->get_kategori();
        $data = array(
            'title'=>'Tambah Kategori Sampah',
            'active'=>'Kelola Data Sampah',
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
            wrapper_templates($this, "kategori/sampah/create", $data);
        } else {
            $k_name = xss_input($this->input->post('k_name', true));
            $dataKategori = [
                "_id" => generate_id(),
                "k_name" => $k_name,
            ];
            $create = $this->KategoriSampah_model->create_kategori($dataKategori);
            if($create){
                _set_flashdata($this,'message', 'success', 'Tambah Kategori Sampah Berhasil', 'kategoriSampah');
            } else {
                _set_flashdata($this,'message', 'danger', 'Tambah Kategori Sampah Gagal', 'kategoriSampah');
            }
        }
    }

    function update($id)
    {
        if($id == ""){
            _set_flashdata($this,'message','success','Silahkan Masukkan ID yang valid','kategoriSampah');
        }
        else{
            $data = array(
                'title'=>'Update Data Kategori',
                'active'=>'Kelola Data Sampah',
                'user' => _get_user($this),
                'dataKategori' => $this->KategoriSampah_model->get_kategori_by_id($id)
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
                wrapper_templates($this, "kategori/sampah/update", $data);
            } else {
                $dataUpdate = [
                    "k_name" => xss_input($this->input->post('k_name', true))
                ];

                $where = [
                    "_id" => $id
                ];
                
                $update = $this->KategoriSampah_model->update_kategori($dataUpdate, $where);
                if($update){
                    _set_flashdata($this,'message','success','Update data berhasil','kategoriSampah');
                }
                else{
                    _set_flashdata($this,'message','danger','Update data gagal','kategoriSampah');
                }
            }
        }
    }

    function delete($id)
    {
        if($id == ""){
            _set_flashdata($this,'message','success','Silahkan Masukkan ID yang valid','kategoriSampah');
        }
        else{
            $whereKategori = ["_id"=>$id];
            $dataSampah = $this->Sampah_model->get_sampah_by_kategori($id);
            foreach($dataSampah as $sampah){
                $whereSampah = ["_id" => $sampah->_id];
                unlink('uploads/'.$sampah->a_image);
                $deleteSampah = $this->Sampah_model->delete_sampah($whereSampah);
            }
            
            $deleteKategori = $this->KategoriSampah_model->delete_kategori($whereKategori);
            if($deleteKategori){
                _set_flashdata($this,'message', 'success', 'Hapus Kategori Sampah berhasil', 'kategoriSampah');
            } else {
                _set_flashdata($this,'message', 'success', 'Hapus Kategori Sampah Gagal', 'kategoriSampah');
            }
        }
    }
}
