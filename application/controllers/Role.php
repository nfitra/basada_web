<?php

class Role extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    function index()
    {
        echo "ROLE";
    }
}