<?php

function generate_id()
{
    return md5(base64_encode(microtime(true))); 
}

function is_logged_in()
{
    $ci = get_instance();
    
    if($ci->session->userdata('email') === null){
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        // var_dump($menu);
        $querySubMenu = $ci->db->get_where('sub_menu', ['sm_name'=>$menu])->row();
        $menu_id = $querySubMenu->_id;
        // var_dump($menu_id);

        $user_access = $ci->db->get_where('role_access_menu',[
            'fk_role' => $role_id,
            'fk_subMenu' => $menu_id
        ])->num_rows();

        if($user_access === 0){
            redirect('auth/blocked');
        }
        // echo $role_id."<br>";
        // echo $menu."<br >";
        // var_dump($querySubMenu);
        // var_dump($user_access);
    }
}