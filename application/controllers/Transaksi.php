<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Unit_model');
        $this->load->model('Auth_model');
    }

    function index()
    {
        $data = array(
            'title'=>'Data Keuangan',
            'active'=>'Data Keuangan',
            'user' => _get_user($this)
        );
        wrapper_templates($this, "transaksi/index", $data);
    }
}