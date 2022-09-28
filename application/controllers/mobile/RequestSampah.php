<?php

class RequestSampah extends CI_Controller
{
    public function __construct()
    {
        ini_set("allow_url_fopen", true);
        ini_set("file_uploads", "on");
        parent::__construct();
        $this->load->helper('fcm_helper');
        $this->load->model('RequestSampah_model');
        $this->load->model('Device_model');
        $this->load->model('Admin_model');
        $this->load->model('Nasabah_model');
        header('Content-Type: application/json');
    }

    public function index()
    {
        echo json_encode("Data");
    }

    public function get_admin()
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Admin_model->get_admin();
        echo json_encode($data);
    }

    public function get_min_sampah()
    {
        $this->nasabah = _checkNasabah($this);
        // $min = read_file(base_url("/assets/file/minSampah.txt"));
        $min = file_get_contents("./assets/file/minSampah.txt", true);
        // echo $min;
        // die();
        echo json_encode($min);
    }

    public function get_request_by_nasabah()
    {
        $this->nasabah = _checkNasabah($this);
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
        $this->user = _checkUser($this);
        $data = $this->RequestSampah_model->get_by_id_admin($id);
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

    public function get_request_by_current_admin()
    {
        $this->admin = _checkUser($this);
        // $this->nasabah = _checkNasabah($this);
        $data = $this->RequestSampah_model->get_by_email_admin($this->admin->email);
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
        $this->user = _checkUser($this);
        $data = $this->RequestSampah_model->get_by_id_admin_n_jadwal($idAdmin, $idJadwal);
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

    public function get_request_by_current_admin_jadwal($idJadwal)
    {
        $this->admin = _checkUser($this);
        $data = $this->RequestSampah_model->get_by_email_admin_n_jadwal($this->admin->email, $idJadwal);
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
        $this->user = _checkUser($this);
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
        $this->nasabah = _checkNasabah($this);
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
                $imageName = xss_input($upload['pic']);

                if ($r_weight >= $min) {
                    $dataRequest = [
                        "_id" => generate_id(),
                        "fk_garbage" => $fk_garbage,
                        "fk_nasabah" => $fk_nasabah,
                        "r_weight" => $r_weight,
                        "r_image" => "uploads/mobile/" . $imageName,
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
                        $admin = $this->Admin_model->get_where(["_id" => $fk_admin])[0];
                        $emailAdmin = $admin->fk_auth;
                        $device = $this->Device_model->get_by_auth($emailAdmin);
                        $devices = [];
                        for ($i = 0; $i < count($device); $i++) {
                            array_push($devices, $device[$i]['registration_id']);
                        }
                        $title = "Permintaan penjemputan sampah baru!";
                        $message = "Dari " . $this->nasabah->n_name;
                        $resultNotification = sendFCM($title, $message, $devices, base_url("uploads/mobile/" . $imageName));
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
        $result = $this->RequestSampah_model->get_one(['_id' => $id]);
        $requestData = parsePutRequest();
        // var_dump($data);
        if ($requestData) {
            $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
            // var_dump($result);
            $emailNasabah = $nasabah->fk_auth;
            $data['r_status'] = $requestData['status'];
            $data['fk_garbage'] = $requestData['id_sampah'];
            $data['r_weight'] = $requestData['berat'];
            $resultQuery = $this->RequestSampah_model->update_request($data, ["_id" => $id]);

            if ($resultQuery) {
                // var_dump("berhasil");
                $resultData['message'] = "Berhasil mengubah data";
                $statusCode = 200;
                http_response_code('200');
                if ($result->r_status != $data['r_status']) {
                    if ($data['r_status'] == 1) {
                        $message = "Menunggu Petugas Datang";
                    } else if ($data['r_status'] == -1) {
                        $message = "Request anda telah ditolak";
                    } else if ($data['r_status'] == 2) {
                        $message = "Uang sampah telah masuk";
                    } else if ($data['r_status'] == 0) {
                        $message = "Sampah Belum Dikonfirmasi";
                    }
                    $title = "Pembaruan request sampahmu!";
                    $device = $this->Device_model->get_by_auth($emailNasabah);
                    // var_dump($device);
                    $devices = [];
                    for ($i = 0; $i < count($device); $i++) {
                        array_push($devices, $device[$i]['registration_id']);
                    }
                    $resultNotification = sendFCM($title, $message, $devices);

                    $resultData['data'] = $this->RequestSampah_model->get_detail($id);
                    echo json_encode(array('status' => $statusCode, 'notification' => $resultNotification, 'data' => $resultData));
                } else {
                    $resultData['data'] = $this->RequestSampah_model->get_detail($id);
                    echo json_encode(array('status' => $statusCode, 'data' => $resultData));
                }
            } else {
                $resultData['message'] = "Gagal mengubah data";
                $resultData['error_message'] = $resultQuery;
                $statusCode = 500;
                http_response_code('500');

                echo json_encode(array('status' => $statusCode, 'data' => $resultData));
            }
        } else {
            $tokenData['message'] = "Tidak ada inputan";
            $statusCode = 400;
            http_response_code('400');
            echo json_encode(array('status' => $statusCode, 'data' => $tokenData));
        }
    }
}
