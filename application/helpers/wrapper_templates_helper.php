<?php

function wrapper_templates($templates, $nameView = "dashboard/blank", $data = "")
{
    $templates->load->view('templates/admin/header', $data);
    $templates->load->view('templates/admin/navbar');
    $templates->load->view($nameView);
    $templates->load->view('templates/admin/footer');
}
