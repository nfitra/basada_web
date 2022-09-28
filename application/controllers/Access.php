<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Access_model');
        $this->load->model('Role_model');
        $this->load->model('Sub_Menu_model');
    }

    function index()
    {
        $data = array(
            'title'=>'Access Management',
            'active'=>'Access Role',
            'user'=>_get_user($this),
            'accesses' => $this->Access_model->get_all(),
            'roles'=>$this->Role_model->get_role()
        );
        wrapper_templates($this, "access/index", $data);
    }

    function create()
    {
        $data = array(
            'title'=>'Access Management',
            'active'=>'Access Role',
            'user'=>_get_user($this),
            'roles'=>$this->Role_model->get_role(),
            'subMenu'=>$this->Sub_Menu_model->get_sub_menu()
            
        );

        $config = [
            [
                "field"=>"role",
                "label"=>"Role",
                "rules"=>'required|trim',
                "errors"=>[
                    'required'=>'%s wajib diisi'
                ]
            ],
            [
                "field"=>"access",
                "label"=>"Access",
                "rules"=>'required|trim',
                "errors"=>[
                    'required'=>'%s wajib diisi'
                ]
            ]
        ];


        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE){
            wrapper_templates($this, "access/create", $data);
        } else {
            $access = xss_input($this->input->post('access', true));
            $role = xss_input($this->input->post('role', true));

            $dataAccess = [
                "_id"=>generate_id(),
                "fk_subMenu"=>$access,
                "fk_role"=>$role
            ];

            $createAccess = $this->Access_model->create_access($dataAccess);
            if($createAccess){
                _set_flashdata($this,'message','success','Tambah Access berhasil','access/index');
            }
            else{
                _set_flashdata($this,'message','danger','Tambah Access gagal','access/index');
            }
        }        
    }

    function update($id="")
    {
        if($id){
            $data = array(
                'title'=>'Access Management',
                'active'=>'Access Role',
                'user'=>_get_user($this),
                'roles'=>$this->Role_model->get_role(),
                'subMenu'=>$this->Sub_Menu_model->get_sub_menu(),
                'access'=>$this->Access_model->get_access_byID($id)
            );

            $config = [
                [
                    "field"=>"role",
                    "label"=>"Role",
                    "rules"=>'required|trim',
                    "errors"=>[
                        'required'=>'%s wajib diisi'
                    ]
                ],
                [
                    "field"=>"access",
                    "label"=>"Access",
                    "rules"=>'required|trim',
                    "errors"=>[
                        'required'=>'%s wajib diisi'
                    ]
                ]
            ];

            $this->form_validation->set_rules($config);

            if($this->form_validation->run()==FALSE){
                wrapper_templates($this, "access/update", $data);
            } else {
                $role_id = xss_input($this->input->post("role",true));
                $subMenu_id = xss_input($this->input->post("access",true));

                $dataUpdate = [
                    "fk_role" => $role_id,
                    "fk_subMenu" => $subMenu_id,
                ];

                $where = ["_id"=>$id];

                $update = $this->Access_model->update($dataUpdate, $where);
                if($update){
                    _set_flashdata($this,'message','success','Ubah Data Berhasil !','access/index');
                } else {
                    _set_flashdata($this,'message','danger','Ubah Data Gagal','access/index');
                }
            }
        } else {
            _set_flashdata($this,'message','danger','Masukkan ID yang valid','access/index');
        }
    }

    function delete($id="")
    {
        if($id){
            $delete = $this->Access_model->delete($id);
            if($delete){
                _set_flashdata($this,'message','success','Delete access berhasil !','access/index');    
            } else {
                _set_flashdata($this,'message','danger','Masukkan ID yang valid','access/index');
            }
            
        } else {
            _set_flashdata($this,'message','danger','Masukkan ID yang valid','access/index');
        }
    }

    function get_json_sub_menu_byRole($id)
    {
        $accesses = $this->Access_model->get_by_fk_role($id);
        $arrFkSubMenu = [];
        foreach($accesses as $access){
            array_push($arrFkSubMenu, $access->fk_subMenu);
        }

        $test = $this->Sub_Menu_model->get_not_in($arrFkSubMenu);
        echo json_encode($test);
        // $subMenu = $this->Sub_Menu_model->
    }
}