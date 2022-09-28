<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Schedule_model');
    }
    function index()
    {
        $data = array(
            'title'=>'Jadwal sampah',
            'active'=>'Jadwal',
            'user' => _get_user($this),
            'listJadwal' => $this->Schedule_model->get_schedule()
        );
        wrapper_templates($this, "jadwal/index", $data);
    }

    function create()
    {
        $data = array(
            'title'=>'Tambah Jadwal Sampah',
            'active'=>'Jadwal',
            'user' => _get_user($this),
        );
        
        $config = [
            [
                "field"=>"s_day",
                "label"=>"Hari",
                "rules"=>"required|trim",
                "errors"=>[
                    "required"=>"%s wajib diisi"
                ]
            ],
            [
                "field"=>"s_time",
                "label"=>"Jam",
                "rules"=>"required|trim",
                "errors"=>[
                    "required"=>"%s wajib diisi"
                ]
            ],
            [
                "field"=>"s_weather",
                "label"=>"Cuaca",
                "rules"=>"required|trim",
                "errors"=>[
                    "required"=>"%s wajib diisi"
                ]
            ],
            [
                "field"=>"s_weather_icon",
                "label"=>"Ikon Cuaca",
                "rules"=>"required|trim",
                "errors"=>[
                    "required"=>"%s wajib diisi"
                ]
            ]
        ];   

        $this->form_validation->set_rules($config);

        if($this->form_validation->run()==FALSE){
            wrapper_templates($this, "jadwal/create", $data);
        } else{
            $s_day = xss_input($this->input->post("s_day", true));
            $s_time = xss_input($this->input->post("s_time", true));
            $s_weather = xss_input($this->input->post("s_weather", true));
            $s_weather_icon = xss_input($this->input->post("s_weather_icon", true));
            $dataSchedule = [
                "_id"=>generate_id(),
                "s_day" => $s_day,
                "s_time" => $s_time,
                "s_weather" => $s_weather,
                "s_weather_icon" => $s_weather_icon,
            ];

            $create = $this->Schedule_model->create_schedule($dataSchedule);
            if($create){
                _set_flashdata($this,'message', 'success', 'Tambah Jenis Jadwal Berhasil', 'jadwal');
            } else {
                _set_flashdata($this,'message', 'danger', 'Tambah Jenis Jadwal Gagal', 'jadwal');
            }
        }
    }

    function update($id="")
    {
        if($id !== ""){
            $where = ["_id"=>$id];
            $data = array(
                'title'=>'Ubah Jadwal Sampah',
                'active'=>'Jadwal',
                'user' => _get_user($this),
                'jadwal'=>$this->Schedule_model->get_one($where)
            );
            
            $config = [
                [
                    "field"=>"s_day",
                    "label"=>"Hari",
                    "rules"=>"required|trim",
                    "errors"=>[
                        "required"=>"%s wajib diisi"
                    ]
                ],
                [
                    "field"=>"s_time",
                    "label"=>"Jam",
                    "rules"=>"required|trim",
                    "errors"=>[
                        "required"=>"%s wajib diisi"
                    ]
                ],
                [
                    "field"=>"s_weather",
                    "label"=>"Cuaca",
                    "rules"=>"required|trim",
                    "errors"=>[
                        "required"=>"%s wajib diisi"
                    ]
                ],
                [
                    "field"=>"s_weather_icon",
                    "label"=>"Ikon Cuaca",
                    "rules"=>"required|trim",
                    "errors"=>[
                        "required"=>"%s wajib diisi"
                    ]
                ]
            ];   

            $this->form_validation->set_rules($config);
            if($this->form_validation->run()==FALSE){
                wrapper_templates($this, "jadwal/update", $data);
            } else{
                $s_day = xss_input($this->input->post("s_day", true));
                $s_time = xss_input($this->input->post("s_time", true));
                $s_weather = xss_input($this->input->post("s_weather", true));
                $s_weather_icon = xss_input($this->input->post("s_weather_icon", true));
                $dataSchedule = [
                    "s_day" => $s_day,
                    "s_time" => $s_time,
                    "s_weather" => $s_weather,
                    "s_weather_icon" => $s_weather_icon,
                ];
    
                $update = $this->Schedule_model->update_schedule($dataSchedule, $where);
                if($update){
                    _set_flashdata($this,'message', 'success', 'Ubah Jadwal Berhasil', 'jadwal');
                } else {
                    _set_flashdata($this,'message', 'danger', 'Ubah Jadwal Gagal', 'jadwal');
                }
            }
        } else {
            _set_flashdata($this,'message', 'danger', 'ID Invalid', 'jadwal');
        }
    }

    function delete($id)
    {
        if($id !== ""){
            $where = ["_id"=>$id];
            $delete = $this->Schedule_model->delete_schedule($where);
            if($delete){
                _set_flashdata($this,'message', 'success', 'Hapus Jadwal berhasil', 'jadwal');
            } else {
                _set_flashdata($this,'message', 'danger', 'Hapus Jadwal Gagal', 'jadwal');
            }

        } else {
            _set_flashdata($this,'message', 'danger', 'Harap Masukkan ID Jenis Jadwal', 'jadwal');
        }
    }
}