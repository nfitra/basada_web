<?php

class RequestSampah extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->nasabah = _checkNasabah($this);
        $this->load->model('RequestSampah_model');
        $this->load->model('Device_model');
        $this->load->model('Admin_model');
        $this->load->model('Nasabah_model');
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

    public function get_request_by_nasabah()
    {
        $data = $this->RequestSampah_model->get_by_nasabah($this->nasabah->_id);
        // var_dump($data);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->r_status == 0)
                $data[$i]->keterangan = "Sampah Belum Dikonfirmasi";
            else if ($data[$i]->r_status == 1)
                $data[$i]->keterangan = "Menunggu Petugas Datang";
            else if ($data[$i]->r_status == -1)
                $data[$i]->keterangan = "Request anda telah ditolak";
            else
                $data[$i]->keterangan = "Uang sampah telah masuk";
            unset($data[$i]->r_status);
        }
        echo json_encode($data);
    }

    public function get_request_by_admin($id)
    {
        $data = $this->RequestSampah_model->get_by_admin($id);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]->r_status == 0)
                $data[$i]->keterangan = "Sampah Belum Dikonfirmasi";
            else if ($data[$i]->r_status == 1)
                $data[$i]->keterangan = "Menunggu Petugas Datang";
            else if ($data[$i]->r_status == -1)
                $data[$i]->keterangan = "Request anda telah ditolak";
            else
                $data[$i]->keterangan = "Uang sampah telah masuk";
            unset($data[$i]->r_status);
        }
        echo json_encode($data);
    }

    public function get_request_by_admin_jadwal($idAdmin, $idJadwal)
    {
        $data = $this->RequestSampah_model->get_by_admin_n_jadwal($idAdmin, $idJadwal);
        for ($i = 0; $i < count($data); $i++) {
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

    public function get_detail_request($id)
    {
        $data = $this->RequestSampah_model->get_detail($id);
        // var_dump($data);
        if ($data->r_status == 0)
            $data->keterangan = "Sampah Belum Dikonfirmasi";
        else if ($data->r_status == 1)
            $data->keterangan = "Menunggu Petugas Datang";
        else if ($data->r_status == -1)
            $data->keterangan = "Request anda telah ditolak";
        else
            $data->keterangan = "Uang sampah telah masuk";
        unset($data->r_status);
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
                $lat = $this->input->post('lat');
                $long = $this->input->post('long');
                $r_weight = $this->input->post('r_weight');
                $fk_jadwal = $this->input->post('fk_jadwal');
                $fk_admin = $this->input->post('fk_admin');

                if ($r_weight >= $min) {
                    $dataRequest = [
                        "_id" => generate_id(),
                        "fk_garbage" => $fk_garbage,
                        "fk_nasabah" => $fk_nasabah,
                        "r_weight" => $r_weight,
                        "r_image" => "uploads/mobile/" . xss_input($upload['pic']),
                        // "r_image" => "uploads/mobile/1604164961buku.jpg",
                        "r_notes" => "input by nasabah",
                        "r_location" => "POINT(" . $lat . " " . $long . ")",
                        "fk_jadwal" => $fk_jadwal,
                        "fk_admin" => $fk_admin,
                        "r_status" => 0
                    ];
                    // var_dump($dataRequest);
                    $insertRequest = $this->RequestSampah_model->create_request($dataRequest);
                    if ($insertRequest) {
                        $FCMhelper = new fcm_helper();
                        $admin = $this->Admin_model->get_where(["_id" => $fk_admin])[0];
                        $emailAdmin = $admin->fk_auth;
                        $device = $this->Device_model->get_by_auth($emailAdmin);
                        $devices = [];
                        for ($i = 0; $i < count($device); $i++) {
                            array_push($devices, $device[$i]['registration_id']);
                        }
                        $title = "Permintaan penjemputan sampah baru!";
                        $message = "Dari " . $this->nasabah->n_name;
                        $resultNotification = $FCMhelper->sendFCM($title, $message, $devices);
                        $tokenData['message'] = "Berhasil merequest sampah";
                        $statusCode = 200;
                    } else {
                        var_dump($insertRequest);
                        $tokenData['message'] = "Gagal merequest sampah";
                        $statusCode = 400;
                    }
                } else {
                    $tokenData['message'] = "Minimal angkut sampah harus $min kg";
                    $statusCode = 401;
                }
            } else {
                $tokenData['message'] = "Gagal upload foto sampah";
                $statusCode = 401;
            }
        } else {
            $tokenData['message'] = "Tidak ada inputan";
            $statusCode = 401;
        }
        if (isset($resultNotification)) {
            echo json_encode(array('status' => $statusCode, 'notification' => $resultNotification, 'data' => $tokenData));
        } else {
            echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
        }
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

    public function update($id)
    {
        $FCMhelper = new fcm_helper();
        $result = $this->RequestSampah_model->get_one(["_id" => $id]);
        if ($this->input->post()) {
            $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
            $emailNasabah = $nasabah->fk_auth;
            $data['r_status'] = $this->input->post('status');
            $data['fk_garbage'] = $this->input->post('id_sampah');
            $data['r_weight'] = $this->input->post('berat');
            $resultQuery = $this->RequestSampah_model->update_request($data, $id);

            if ($resultQuery) {
                $tokenData['message'] = "Berhasil mengubah data";
                $statusCode = 200;
                http_response_code('200');
                if ($result->r_status != $data['r_status']) {
                    if ($data['r_status'] == 1) {
                        $message = "Menunggu Petugas Datang";
                    } else if ($data['r_status'] == -1) {
                        $message = "Request anda telah ditolak";
                    } else if ($data['r_status'] == 2) {
                        $message = "Uang sampah telah masuk";
                    }
                    $title = "Pembaruan request sampahmu!";
                    $device = $this->Device_model->get_by_auth($emailNasabah);
                    $devices = [];
                    for ($i = 0; $i < count($device); $i++) {
                        array_push($devices, $device[$i]['registration_id']);
                    }
                    $resultNotification = $FCMhelper->sendFCM($title, $message, $devices);

                    echo json_encode(array('status' => $statusCode, 'notification' => $resultNotification, 'data' => $tokenData));
                }
            } else {
                $tokenData['message'] = "Gagal mengubah data";
                $tokenData['error_message'] = $resultQuery;
                $statusCode = 500;
                http_response_code('500');

                echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
            }
        }
    }
}
