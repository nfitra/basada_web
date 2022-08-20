<?php
defined('BASEPATH') or exit('No direct script access allowed');

class API extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
       
        $this->load->model('RequestSampah_model');
    }

    

    // function API
    function notifAPI()
    {
        $admin = $this->session->userdata('email');
        // echo $admin;
        $req = $this->RequestSampah_model->get_all_item_by_admin($admin);
        $data['data'] = $req;
        echo json_encode($data);
    }
}
