<?php


function wrapper_auth($templates, $nameView="auth/login", $data=[])
{
    $templates->load->view('templates/admin/header', $data);
    $templates->load->view($nameView);
}