<?php

defined('BASEPATH') or exit('No direct script access allowed');

class TransaksiNasabah extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Unit_model');
        $this->load->model('Auth_model');
        $this->load->model('RequestSampah_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Mutasi_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Transaksi Nasabah',
            'active' => 'Transaksi Nasabah',
            'user' => _get_user($this),
            'requests' => $this->RequestSampah_model->get_all_item(2)
        );
        wrapper_templates($this, "transaksi/nasabah", $data);
    }

    function take_balance()
    {
        $data = array(
            'title' => 'Transaksi Nasabah',
            'active' => 'Transaksi Nasabah',
            'user' => _get_user($this),
            'listNasabah' => $this->Nasabah_model->get_list_nasabah()
        );

        $config = [
            [
                'field' => 'fk_nasabah',
                'label' => 'Id Nasabah',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
            [
                'field' => 'm_amount',
                'label' => 'Saldo',
                'rules' => 'required|trim',
                'errors' => [
                    'required' => '%s wajib diisi'
                ]
            ],
        ];

        $this->form_validation->set_rules($config);

        if ($this->form_validation->run() === FALSE) {
            wrapper_templates($this, "transaksi/formMutasi", $data);
        } else {
            $fk_nasabah = xss_input($this->input->post("fk_nasabah", true));
            $m_amount = xss_input($this->input->post("m_amount", true));
            $saldo = $this->Nasabah_model->cek_balance(["_id" => $fk_nasabah])->n_balance;
            if ($m_amount <= $saldo) {
                $dataMutasi = [
                    "_id" => generate_id(),
                    "m_type" => "Kredit",
                    "m_amount" => $m_amount,
                    "m_information" => "Penarikan saldo sebanyak $m_amount",
                    "fk_nasabah" => $fk_nasabah,
                ];
                $insert = $this->Mutasi_model->create_mutasi($dataMutasi);
                if ($insert) {
                    $where = ["_id" => $fk_nasabah];
                    $this->Nasabah_model->balance($m_amount, $where, "-");
                    _set_flashdata($this, 'message', 'success', 'Berhasil Menarik Saldo', 'transaksiNasabah');
                } else {
                    _set_flashdata($this, 'message', 'danger', 'Gagal Menarik Saldo', 'transaksiNasabah');
                }
            } else {
                _set_flashdata($this, 'message', 'danger', 'Saldo Nasabah Tidak Cukup', 'transaksiNasabah');
            }
        }
    }
}
