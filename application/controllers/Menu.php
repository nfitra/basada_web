<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Menu_model');
        $this->load->model('Sub_Menu_model');
        $this->load->model('Role_model');
    }

    function index()
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

    function create($type="")
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
    
}