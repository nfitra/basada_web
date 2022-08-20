<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Auth_model');
        $this->load->model('Unit_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Transaksi_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Dashboard',
            'active' => 'Dashboard Admin',
            'user' => _get_user($this),
            'nasabah' => $this->Nasabah_model->get_total(),
            'unit' => $this->Unit_model->get_total(),
            'omset' => $this->Transaksi_model->get_omset($this->session->userdata('email'))
        );
        wrapper_templates($this, "dashboard/index", $data);
    }

    // function induk()
    // {
    //     $data = array(
    //         'title'=>'Data Admin Induk',
    //         'active'=>'Data Admin Induk',
    //         'user' => _get_user($this),
    //         'listAdmin' => $this->Admin_model->get_admin()
    //     );
    //     wrapper_templates($this, "admin/induk/index", $data);
    // }

    // function create()
    // {
    //     $data = array(
    //         'title'=>'Tambah Data Admin Induk',
    //         'active'=>'Data Admin Induk',
    //         'user'=>$this->_get_user()
    //     );

    //     $config = [
    //         [
    //             'field'=>'email',
    //             'label'=>'Email',
    //             'rules'=>'required|trim|valid_email|is_unique[auth.email]',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi',
    //                 'valid_email' => 'Format %s harus benar',
    //                 'is_unique' => '%s sudah digunakan.'
    //             ]
    //         ],
    //         [
    //             'field'=>'fullName',
    //             'label'=>'Nama Lengkap',
    //             'rules'=>'required|trim',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi'
    //             ]
    //         ],
    //         [
    //             'field'=>'password',
    //             'label'=>'Password',
    //             'rules'=>'required|trim|min_length[5]',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi',
    //                 'min_length' => 'Panjang %s minimal 5 karakter',
    //             ]
    //         ],
    //         [
    //             'field'=>'confPass',
    //             'label'=>'Konfirmasi Password',
    //             'rules'=>'required|trim|min_length[5]|matches[password]',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi',
    //                 'min_length' => 'Panjang %s minimal 5 karakter',
    //                 'matches' => '%s tidak sama'
    //             ]
    //         ],
    //     ];

    //     $this->form_validation->set_rules($config);

    //     if($this->form_validation->run()==FALSE){
    //         wrapper_templates($this, "admin/induk/create", $data);
    //     } else {
    //         $email = xss_input($this->input->post('email', true));
    //         $password = xss_input($this->input->post('password', true));
    //         $dataAuth = [
    //             "email" => $email,
    //             "password" => password_hash($password, PASSWORD_BCRYPT),
    //             "fk_role" => "cee6de74c28ff53dcdf3da10f3ee1c05",
    //             "isActive" => 1
    //         ];
    //         $insertAuth = $this->Auth_model->create_admin_auth($dataAuth);
    //         if($insertAuth){
    //             $fullName = xss_input($this->input->post('fullName', true));

    //             $dataAdmin = [
    //                 "_id" => generate_id(),
    //                 "fk_auth" => $email,
    //                 "u_name" => $fullName
    //             ];

    //             $insertAdmin = $this->Admin_model->create_admin($dataAdmin);
    //             if($insertAdmin){
    //                 echo TRUE;
    //             } else {
    //                 $deleteDataAuth = [
    //                     "email" => $email
    //                 ];
    //                 $deleteAuth = $this->Auth_model->delete_auth($deleteDataAuth);
    //             }
    //         }
    //     }
    // }

    // function update($id)
    // {
    //     $data = array(
    //         'title'=>'Update Admin Induk',
    //         'active'=>'Data Admin Induk',
    //         'user' => _get_user($this),
    //         'dataAdmin' => $this->Admin_model->get_admin_by_id($id)
    //     );

    //     $config = [
    //         [
    //             'field'=>'fullName',
    //             'label'=>'Nama Lengkap',
    //             'rules'=>'required|trim',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi'
    //             ]
    //         ],
    //     ];

    //     $this->form_validation->set_rules($config);

    //     if($this->form_validation->run()===FALSE){
    //         wrapper_templates($this, "admin/induk/update", $data);
    //     } else {
    //         $dataUpdate = [
    //             "u_name" => xss_input($this->input->post('fullName', true))
    //         ];

    //         $where = [
    //             "_id" => $id
    //         ];

    //         $update = $this->Admin_model->update_admin($dataUpdate, $where);
    //         if($update){
    //             _set_flashdata($this,'message','success','Update data berhasil','admin/induk');
    //         }

    //     }
    // }

    // function update_auth($id)
    // {
    //     $admin = $this->Admin_model->get_admin_by_id($id);
    //     $data = array(
    //         'title'=>'Update Admin Induk',
    //         'active'=>'Data Admin Induk',
    //         'user' => _get_user($this),
    //         'dataAdmin' => $admin
    //     );

    //     $config = [
    //         [
    //             'field'=>'password',
    //             'label'=>'Password',
    //             'rules'=>'required|trim|min_length[5]',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi',
    //                 'min_length' => 'Panjang %s minimal 5 karakter',
    //             ]
    //         ],
    //         [
    //             'field'=>'confPass',
    //             'label'=>'Konfirmasi Password',
    //             'rules'=>'required|trim|min_length[5]|matches[password]',
    //             'errors'=>[
    //                 'required' => '%s wajib diisi',
    //                 'min_length' => 'Panjang %s minimal 5 karakter',
    //                 'matches' => '%s tidak sama'
    //             ]
    //         ],
    //     ];

    //     $this->form_validation->set_rules($config);

    //     if($this->form_validation->run()===FALSE){
    //         wrapper_templates($this, "admin/induk/update", $data);
    //     } else {

    //         $dataUpdate = [
    //             "password" => xss_input(password_hash($this->input->post('password', true), PASSWORD_BCRYPT))
    //         ];

    //         $where = [
    //             "email" => $admin->fk_auth
    //         ];

    //         $update = $this->Auth_model->update_auth($dataUpdate, $where);
    //         if($update){
    //             _set_flashdata($this,'message','success','Update data berhasil','admin/induk');
    //         }

    //     }
    // }

    // function delete($id)
    // {
    //     $email = $this->Admin_model->get_admin_by_id($id);

    //     $dataAuth = [
    //         "isActive" => 0,
    //     ];

    //     $where = [
    //         "email" => $email->fk_auth
    //     ];

    //     $delete = $this->Auth_model->update_auth($dataAuth, $where);
    //     if($delete){
    //         _set_flashdata($this,'message','success','Update data berhasil','admin/induk');
    //     }
    // }
}
