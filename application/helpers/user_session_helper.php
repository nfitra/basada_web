<?php

function _set_flashdata($user_data, $type, $class, $message, $redirect)
{

    $user_data->session->set_flashdata($type, '<div class="alert alert-' . $class . '" role="alert"> ' . $message . ' </div>');
    redirect($redirect);
}

function _get_user($ci)
{
    // var_dump();
    // $email = $session->session->userdata('email');
    // return $session->Admin_model->get_admin_by_email($email);
    if ($ci->session->userdata('email')) {
        if ($ci->Admin_model->check_admin($ci->session->userdata('email'))) {
            $email = $ci->session->userdata('email');
            return $ci->Admin_model->get_admin_by_email($email);
        } else {
            $where = [
                'fk_auth' => $ci->session->userdata('email')
            ];
            return $ci->Unit_model->get_unit_by_email($where)[0];
        }
    } else {
        redirect(base_url("auth"));
    }
}
