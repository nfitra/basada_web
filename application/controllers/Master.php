<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Master extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Access_model');
        $this->load->model('Role_model');
        $this->load->model('Menu_model');
        $this->load->model('Sub_Menu_model');
        $this->load->model('Upload_model');
    }

    // menu feature

    function menu()
    {
        $listMenu = $this->Menu_model->get_menu();
        $listSubMenu = $this->Sub_Menu_model->get_sub_menu();
        $data = array(
            'title'=>'Menu Management',
            'active'=>'Menu Management',
            'user'=>_get_user($this),
            'listMenu'=>$listMenu,
            'listSubMenu'=>$listSubMenu,
        );
        wrapper_templates($this, "menu/index", $data);
    }

    function create_menu($type="")
    {
        $listMenu = $this->Menu_model->get_menu();
        $data = array(
            'title'=>'Menu Management',
            'active'=>'Menu Management',
            'user'=>_get_user($this),
            'listMenu'=>$listMenu,
        );
        if($type === "menu"){
            wrapper_templates($this, "menu/menu/create", $data);
        } else if($type === "subMenu"){
            wrapper_templates($this, "menu/subMenu/create", $data);
        } else {
            _set_flashdata($this,'message', 'danger', 'Harap masukkan tipe menu yg valid', 'menu');
        }
    }

    function create_data($type="")
    {
        if($type === "menu"){
            $this->_create_menu();
        } else if($type === "subMenu"){
            $this->_create_sub_menu();
        } else {
            _set_flashdata($this,'message', 'danger', 'Harap masukkan tipe menu yg valid', 'menu');
        }
    }

    private function _create_menu()
    {
        $config = [
            [
                'field'=>'m_name',
                'label'=>'Nama Menu',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'m_order',
                'label'=>'Urutan',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi',
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE){
            _set_flashdata($this,'menu', 'danger', 'Tambah Menu Gagal', 'menu');
        } else {
            $m_name = xss_input($this->input->post('m_name', true));
            $m_order = xss_input($this->input->post('m_order', true));

            $dataMenu = [
                "_id" => generate_id(),
                "m_name" => $m_name,
                "m_order" => $m_order
            ];

            $insert = $this->Menu_model->create_menu($dataMenu);
            if($insert){
                _set_flashdata($this,'menu', 'success', 'Tambah Menu Berhasil', 'menu');
            } else {
                _set_flashdata($this,'menu', 'danger', 'Tambah Menu Gagal', 'menu');
            }
        }
    }

    private function _create_sub_menu()
    {
        $config = [
            [
                'field'=>'fk_menu',
                'label'=>'Parent Menu',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'sm_order',
                'label'=>'Urutan',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi',
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE){
            $listMenu = $this->Menu_model->get_menu();
            $data = array(
                'title'=>'Menu Management',
                'active'=>'Menu Management',
                'user'=>_get_user($this),
                'listMenu'=>$listMenu,
            );
            wrapper_templates($this, "menu/subMenu/create", $data);
        } else {
            $fk_menu = xss_input($this->input->post('fk_menu', true)); 
            $sm_title = xss_input($this->input->post('sm_title', true));
            $sm_url = xss_input($this->input->post('sm_url', true));
            $sm_icon = xss_input($this->input->post('sm_icon', true));
            $sm_order = xss_input($this->input->post('sm_order', true));

            $dataSubMenu = [
                "_id" => generate_id(),
                "sm_title" => $sm_title,
                "sm_url" => $sm_url,
                "sm_icon" => $sm_icon,
                "sm_order" => $sm_order,
                "fk_menu" => $fk_menu,
                "sm_isActive" => 1
            ];

            $insert = $this->Sub_Menu_model->create_sub_menu($dataSubMenu);
            if($insert){
                _set_flashdata($this,'subMenu', 'success', 'Tambah Sub Menu Berhasil', 'menu');
            } else {
                _set_flashdata($this,'subMenu', 'danger', 'Tambah Sub Menu Gagal', 'menu');
            }
        }
    }

    function update($type="", $id="")
    {
        if($type  == ""){
            _set_flashdata($this,'message', 'danger', 'Harap masukkan tipe menu valid', 'menu');
        } else if($id == "") {
            _set_flashdata($this,'message', 'danger', 'Harap masukkan ID '.$type.' yg valid', 'menu');
        } else {

            if($type === "menu"){
                $menu = $this->Menu_model->get_menu_by_id($id);
                $data = array(
                    'title'=>'Menu Management',
             'active'=>'Menu Management',
                    'user'=>_get_user($this),
                    'menu' => $menu
                );
                wrapper_templates($this, "menu/menu/update", $data);
            } else if($type="subMenu"){
                $subMenu = $this->Sub_Menu_model->get_sub_menu_by_id($id);
                $listMenu = $this->Menu_model->get_menu();
                $data = array(
                    'title'=>'Menu Management',
                    'active'=>'Menu Management',
                    'user'=>_get_user($this),
                    'subMenu' => $subMenu,
                    'listMenu' => $listMenu
                );

                if($subMenu){
                    wrapper_templates($this, "menu/subMenu/update", $data);
                } else {
                    _set_flashdata($this,'message', 'danger', 'Harap masukkan ID yang benar', 'menu');    
                }
                
            } else {
                _set_flashdata($this,'message', 'danger', 'Harap masukkan tipe menu yang benar', 'menu');
            }
        }
    }

    function update_data($type="", $id="")
    {
        if($type==""){

        } else if($id == ""){

        } else {
            if($type == "menu"){
                $this->_update_menu($id);
            } else if($type == "subMenu") {
                $this->_update_sub_menu($id);
            }
        }
    }

    private function _update_menu($id)
    {
        $config = [
            [
                'field'=>'m_name',
                'label'=>'Nama Menu',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'m_order',
                'label'=>'Urutan',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi',
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE){
            _set_flashdata($this,'menu', 'danger', 'Ubah Menu Gagal', 'menu');
        } else {
            $m_name = xss_input($this->input->post('m_name', true));
            $m_order = xss_input($this->input->post('m_order', true));

            $dataMenu = [
                "m_name" => $m_name,
                "m_order" => $m_order
            ];

            $where = [
                "_id"=>$id
            ];

            $update = $this->Menu_model->update_menu($dataMenu, $where);

            if($update){
                _set_flashdata($this,'menu', 'success', 'Ubah Menu Berhasil', 'menu');
            } else {
                _set_flashdata($this,'menu', 'danger', 'Ubah Menu Gagal', 'menu');
            }
        }
    }

    private function _update_sub_menu($id)
    {
        $config = [
            [
                'field'=>'fk_menu',
                'label'=>'Parent Menu',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field'=>'sm_order',
                'label'=>'Urutan',
                'rules'=>'required|trim',
                'errors'=>[
                    'required' => '%s wajib diisi',
                ]
            ]
        ];

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()===FALSE){
            $listMenu = $this->Menu_model->get_menu();
            $data = array(
                'title'=>'Menu Management',
                'active'=>'Menu Management',
                'user'=>_get_user($this),
                'listMenu'=>$listMenu,
            );
            wrapper_templates($this, "menu/subMenu/create", $data);
        } else {
            $fk_menu = xss_input($this->input->post('fk_menu', true)); 
            $sm_title = xss_input($this->input->post('sm_title', true));
            $sm_url = xss_input($this->input->post('sm_url', true));
            $sm_icon = xss_input($this->input->post('sm_icon', true));
            $sm_order = xss_input($this->input->post('sm_order', true));

            $dataSubMenu = [
                "sm_title" => $sm_title,
                "sm_url" => $sm_url,
                "sm_icon" => $sm_icon,
                "sm_order" => $sm_order,
                "fk_menu" => $fk_menu,
                "sm_isActive" => 1
            ];

            $where = [
                "_id" => $id
            ];

            $insert = $this->Sub_Menu_model->update_sub_menu($dataSubMenu, $where);
            if($insert){
                _set_flashdata($this,'subMenu', 'success', 'Ubah Sub Menu Berhasil', 'menu');
            } else {
                _set_flashdata($this,'subMenu', 'danger', 'Ubah Sub Menu Gagal', 'menu');
            }
        }
    }

    // access feature

    function access()
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

    function create_access()
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
        }     
    }

    function update_access($id="")
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

    function index()
    {
        echo json_encode(["status"=>403, "message"=>"Bad request"]);
    }

    function delete_access($id="")
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