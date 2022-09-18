<?php

class Auth_model extends CI_Model
{
    public $table = 'auth';
    // $builder = $this->db->table('auth');

    function cek_email($email)
    {
        $where = array('email'=>$email);
        return $this->db->get_where($this->table,$where)->row();
    }

    function cek_nasabah($email)
    {
        $where = array('email'=>$email, 'fk_role' => '4ea170807728f752a1a91cb4502855ce');
        return $this->db->get_where($this->table,$where)->row();
    }

    function cek_admin($email)
    {
        return $this->db->select('*')->from('auth')
        ->where('email', $email)
        ->where('fk_role !=', "4ea170807728f752a1a91cb4502855ce")
        ->where('fk_role !=', "37a0b01c4c89bdbd2324609c80a71054")
        ->get()->row();
    }

    function get_where($where)
    {
        return $this->db->get_where($this->table,$where)->result();
    }

    function get_email()
    {
        $this->db->select("email");
        return $this->db->get($this->table);
    }

    function create_admin_auth($dataAuth)
    {
        return $this->db->insert($this->table, $dataAuth);
    }

    function update_auth($dataAuth, $where)
    {
        return $this->db->update($this->table, $dataAuth, $where);
    }

    function delete_auth($dataAuth)
    {
        return $this->db->delete($this->table, $dataAuth);
    }
}
?>