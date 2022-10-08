<?php

function wrapper_templates_public($templates, $nameView = "public/index", $data = "")
{
    $templates->load->view('templates/public/header', $data);
    $templates->load->view('templates/public/navbar');
    $templates->load->view($nameView);
    $templates->load->view('templates/public/footer');
}
