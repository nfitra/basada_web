<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Artikel_model');
        $this->load->model('Kategori_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Sampah_model');
        $this->load->model('KategoriSampah_model');
        $this->load->model('Schedule_model');
        $this->load->model('Upload_model');

        $this->load->library('pagination');
    }

    function index()
    {
        if($this->session){
            $dataSession = ["email","fk_role"];
            $this->session->unset_userdata($dataSession);
        }
        $data = array(
            'title'=>'BASADA',
            'listArtikel' => $this->Artikel_model->get_artikel_limit(3)
        );
        wrapper_templates_public($this, "public/index", $data);
    }

    function info()
    {
        echo phpinfo();
    }
    
    function artikel()
    {
        $count = $this->Artikel_model->get_count();
        $limit = 6;

        $this->pagination->initialize($this->_pagination(base_url('home/artikel'),$count,$limit));
        $data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data = array(
            'title'=>'Artikel - BASADA',
            'listArtikel' =>  $this->Artikel_model->get_artikel_list($limit, $data['page']),
            'pagination' => $this->pagination->create_links()
        );
        wrapper_templates_public($this, "public/artikel", $data);
    }
    
    function detail_artikel($id)
    {
        $data = array(
            'title'=>'Detail Artikel -  BASADA',
            'artikel' => $this->Artikel_model->get_artikel_by_id($id),
            'listArtikel' => $this->Artikel_model->get_artikel_limit(3),
            'listKategori' => $this->Kategori_model->get_kategori_with_count()
        );
        wrapper_templates_public($this, "public/detail-artikel", $data);
    }
    
    function rekening()
    {
        $data = array(
            'title'=>'Buka Rekening - BASADA',
        );
        $config = [
            [
                'field'=>'email',
                'label'=>'Email',
                'rules'=>'required|trim|valid_email|is_unique[auth.email]',
                'errors'=>[
                    'required' => '%s wajib diisi',
                    'valid_email' => 'Format %s harus benar',
                    'is_unique' => '%s sudah digunakan.'
                ]
            ],
            [
                'field'=>'password',
                'label'=>'Password',
                'rules'=>'required|trim|min_length[5]',
                'errors'=>[
                    'required' => '%s wajib diisi',
                    'min_length' => 'Panjang %s minimal 5 karakter',
                ]
            ],
            [
                'field'=>'n_name',
                'label'=>'Nama Nasabah',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'n_address',
                'label'=>'Alamat',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'n_province',
                'label'=>'Provinsi',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'n_city',
                'label'=>'Kota',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'n_postcode',
                'label'=>'Kode Pos',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'n_contact',
                'label'=>'Nomor Handphone',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            wrapper_templates_public($this, "public/rekening", $data);
        } else {
            $email = xss_input($this->input->post('email', true));
            $password = xss_input($this->input->post('password', true));
            $dataAuth = [
                "email" => $email,
                "password" => password_hash($password, PASSWORD_BCRYPT),
                "fk_role" => "4ea170807728f752a1a91cb4502855ce",
                "isActive" => 1
            ];
            $insertAuth = $this->Auth_model->create_admin_auth($dataAuth);
            if($insertAuth){
                $n_name = xss_input($this->input->post('n_name', true));
                $n_address = xss_input($this->input->post('n_address', true));
                $n_province = xss_input($this->input->post('n_province', true));
                $n_city = xss_input($this->input->post('n_city', true));
                $n_postcode = xss_input($this->input->post('n_postcode', true));
                $n_contact = xss_input($this->input->post('n_contact', true));
                $dataNasabah = [
                    "_id" => generate_id(),
                    "fk_auth" => $email,
                    "n_name" => $n_name,
                    "n_address" => $n_address,
                    "n_province" => $n_province,
                    "n_city" => $n_city,
                    "n_postcode" => $n_postcode,
                    "n_contact" => $n_contact,
                ];
                $insertNasabah = $this->Nasabah_model->create_nasabah($dataNasabah);
                if($insertNasabah){
                    echo "<script>alert('Tambah Nasabah Berhasil')</script>";
                    redirect('home');
                    //_set_flashdata($this,'message', 'success', 'Tambah Nasabah Berhasil', 'kategori');
                } else {
                    $deleteDataAuth = [
                        "email" => $email
                    ];
                    $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
                    echo "<script>alert('Tambah Nasabah Gagal')</script>";
                    //_set_flashdata($this,'message', 'danger', 'Tambah Nasabah Gagal', 'kategori');
                }
            }
            else{
                echo "<script>alert('Tambah Admin Nasabah Gagal')</script>";
            }
        }
    }

    function sampah()
    {
        $data = array(
            'title'=>'Kategori Sampah - BASADA',
            'listKategori' => $this->KategoriSampah_model->get_kategori()
        );
        $kategori = xss_input($this->input->get("kategori"),true);
        $search = xss_input($this->input->get("search"),true);

        if(!empty($kategori) && !empty($search)){
            if($kategori === "all"){
                $data['category'] = $this->Sampah_model->get_kategori_group($search);
                $data['listSampah'] = $this->Sampah_model->get_sampah_with_search($search);
            }
            else{
                $data['category'] = $this->Sampah_model->get_kategori_group_with_kategori($kategori, $search);
                $data['listSampah'] = $this->Sampah_model->get_sampah_with_search_and_kategori($kategori,$search);
            }
        }
        else if(!empty($kategori) && $kategori !== "all"){
            $data['category'] = $this->KategoriSampah_model->get_where(['_id' => $kategori]);
            $data['listSampah'] = $this->Sampah_model->get_where(['fk_kategori' => $kategori]);
        }
        else{
            $data['category'] = $this->KategoriSampah_model->get_kategori();
            $data['listSampah'] = $this->Sampah_model->get_all();
        }
        wrapper_templates_public($this, "public/list-sampah", $data);
    }
    
    function jadwal_sampah()
    {
        $data = array(
            'title'=>'Jadwal Pengangkutan Sampah - BASADA',
            'listSampah' => $this->Schedule_model->get_schedule(),
        );
        wrapper_templates_public($this, "public/jadwal-sampah", $data);
    }

    function get_map()
    {
        header('Content-Type: application/json');
        echo json_encode($this->Unit_model->get_unit());
    }
    
    function tutorial()
    {
        $data = array(
            'title'=>'Tutorial Memilih Sampah - BASADA',
            'listTutorial'=>$this->Upload_model->get_upload()
        );
        wrapper_templates_public($this, "public/tutorial", $data);
    }

    function _pagination($base_url,$count,$limit)
    {
        //konfigurasi pagination
        $config['base_url'] = $base_url;
        $config['total_rows'] = $count;
        $config['per_page'] = $limit;  //show record per halaman
        $config["uri_segment"] = 3;  // uri parameter
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
 
        $config['next_link'] = '&gt;';
        $config['prev_link'] = '&lt;';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['full_tag_open'] = '<ul>';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><span>';
        $config['cur_tag_close'] = '</span></li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_open'] = '<li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_open'] = '<li>';
        return $config;
    }
}