<?php

class RequestSampah extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->nasabah = _checkUser($this);
        $this->load->model('RequestSampah_model');
        $this->load->model('Admin_model');
        header('Content-Type: application/json');
    }

    public function get_admin()
    {
        $data = $this->Admin_model->get_admin();
        echo json_encode($data);
    }

    public function get_min_sampah()
    {
        // $min = read_file(base_url("/assets/file/minSampah.txt"));
        $min = file_get_contents("./assets/file/minSampah.txt", true);
        // echo $min;
        // die();
        echo json_encode($min);
    }

    public function get_request()
    {
        $data = $this->RequestSampah_model->get_where(['fk_nasabah' => $this->nasabah->_id]);
        for ($i = 0; $i <  count($data); $i++) {
            if ($data[$i]->r_status == 0)
                $data[$i]->keterangan = "Sampah Belum Dikonfirmasi";
            else if ($data[$i]->r_status == 1)
                $data[$i]->keterangan = "Menunggu Petugas Datang";
            else if ($data[$i]->r_status == -1)
                $data[$i]->keterangan = "Request anda telah ditolak";
            else
                $data[$i]->keterangan = "Uang sampah telah masuk";
        }
        echo json_encode($data);
    }

    public function request()
    {
        $min = file_get_contents("./assets/file/minSampah.txt", true);
        
        if ($this->input->post()) {
            $upload = $this->do_upload('r_image');
            if ($upload["status"]) {
                $formdata = json_decode(file_get_contents('php://input'), true);
                $fk_garbage = $this->input->post('fk_garbage');
                $fk_nasabah = $this->nasabah->_id;
                $r_weight = $this->input->post('r_weight');
                $fk_jadwal = $this->input->post('fk_jadwal');
                $fk_admin = $this->input->post('fk_admin');
                
                if ($r_weight >= $min){
                    $dataRequest = [
                        "_id" => generate_id(),
                        "fk_garbage" => $fk_garbage,
                        "fk_nasabah" => $fk_nasabah,
                        "r_weight" => $r_weight,
                        "r_image" => "uploads/mobile/" . xss_input($upload['pic']),
                        "r_notes" => "input by nasabah",
                        "fk_jadwal" => $fk_jadwal,
                        "fk_admin" => $fk_admin,
                        "r_status" => 0
                    ];
                    $insertRequest = $this->RequestSampah_model->create_request($dataRequest);
                    if ($insertRequest) {
                        $tokenData['message'] = "Berhasil merequest sampah";
                        $status_code = 200;
                    } else {
                        var_dump($insertRequest);
                        $tokenData['message'] = "Gagal merequest sampah";
                        $status_code = 400;
                    }
                } else {
                    $tokenData['message'] = "Minimal angkut sampah harus $min kg";
                    $status_code = 401;
                }
            } else {
                $tokenData['message'] = "Gagal upload foto sampah";
                $status_code = 401;
            }
        } else {
            $tokenData['message'] = "Tidak ada inputan";
            $status_code = 401;
        }
        echo json_encode(array('status' => $status_code, 'data' => $tokenData));
    }

    function do_upload($name)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$name]['name']);
        $config['upload_path']          = './uploads/mobile/';
        $config['file_name']            = $new_name;
        $config['allowed_types']        = 'jpg|png|gif';
        $config['max_size']             = 2048;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            $error = array('error' => $this->upload->display_errors());
            var_dump($error);
            die();
            return array("status" => false, "error" => $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array("status" => true, "pic" => $new_name);
        }
    }
}
