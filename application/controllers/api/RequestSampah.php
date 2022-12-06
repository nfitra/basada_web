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
        $this->load->model('Admin_model');
        $this->load->model('Nasabah_model');
        $this->load->model('Transaksi_model');
        $this->load->model('Mutasi_model');
        $this->load->model('Device_model');
        $this->load->model('Sampah_model');
        $this->load->model('Unit_model');
        header('Content-Type: application/json');
    }

    public function index()
    {
        echo json_encode("Data");
    }

    public function test($emailNasabah = 'dea@gmail.com')
    {
        $title = "Pembaruan request sampahmu!";
        $message = 'hi there!';
        $device = $this->Device_model->get_by_auth($emailNasabah);
        $devices = [];
        for ($i = 0; $i < count($device); $i++) {
            array_push($devices, $device[$i]->registration_id);
        }
        $resultNotification = sendFCM($title, $message, $devices);
        var_dump($resultNotification);
    }

    public function testHTTP()
    {
        $result = testHTTPRequest();
        var_dump($result);
    }

    public function get_admin()
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Admin_model->get_admin();
        echo json_encode($data);
    }

    public function get_unit()
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Unit_model->get_unit();
        echo json_encode($data);
    }

    public function get_unit_by_status($status)
    {
        $this->nasabah = _checkNasabah($this);
        $data = $this->Unit_model->get_where(['un_status' => ucfirst($status)]);
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
                    $insertRequest = $this->RequestSampah_model->create_request($dataRequest);
                    if ($insertRequest) {
                        $admin = $this->Admin_model->get_where(["_id" => $fk_admin])[0];
                        $emailAdmin = $admin->fk_auth;
                        $title = "Permintaan penjemputan sampah baru!";
                        $message = "Dari " . $this->nasabah->n_name;
                        $resultNotification = $this->send_notification_to_admin($emailAdmin, $title, $message, $imageName);
                        $message = "Berhasil merequest sampah";
                        $statusCode = 200;
                    } else {
                        $message = "Gagal merequest sampah";
                        $statusCode = 400;
                    }
                } else {
                    $message = "Minimal angkut sampah harus $min kg";
                    $statusCode = 401;
                }
            } else {
                $message = "Gagal upload foto sampah";
                $statusCode = 401;
            }
        } else {
            $message = "Tidak ada inputan";
            $statusCode = 401;
        }
        if (isset($resultNotification)) {
            echo json_encode(array('status' => $statusCode, 'message' => $message, 'notification' => $resultNotification));
        } else {
            echo json_encode(array('status' => $statusCode, 'message' => $message));
        }
    }

    function do_upload($name)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$name]['name']);
        $config['upload_path']          = './uploads/mobile/';
        $config['file_name']            = $new_name;
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['max_size'] = 1024 * 20;

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
        $this->user = _checkUser($this);
        $result = $this->RequestSampah_model->get_one(['_id' => $id]);
        $requestData = parsePutRequest();
        if ($requestData) {
            $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
            $emailNasabah = $nasabah->fk_auth;
            $data['fk_garbage'] = $requestData['id_sampah'];
            $data['r_weight'] = $requestData['berat'];
            $resultQuery = $this->RequestSampah_model->update_request($data, ["_id" => $id]);

            if ($resultQuery) {
                // var_dump("berhasil");
                $message = "Berhasil mengubah data";
                $resultData = $this->RequestSampah_model->get_detail($id);
                $statusCode = 200;
                http_response_code('200');
                echo json_encode(array('status' => $statusCode, 'data' => $resultData));
            } else {
                $message = "Gagal mengubah data";
                $resultData['error_message'] = $resultQuery;
                $statusCode = 500;
                http_response_code('500');

                echo json_encode(array('status' => $statusCode, 'data' => $resultData));
            }
        } else {
            $message = "Tidak ada inputan";
            $statusCode = 400;
            http_response_code('400');
            echo json_encode(array('status' => $statusCode, 'message' => $message));
        }
    }

    public function done($id)
    {
        $this->user = _checkUser($this);
        $result = $this->RequestSampah_model->get_one(['_id' => $id]);
        $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
        $emailNasabah = $nasabah->fk_auth;
        $data['r_status'] = 2;
        $resultQuery = $this->RequestSampah_model->update_request($data, ["_id" => $id]);
        if ($resultQuery) {
            $resultData = $this->RequestSampah_model->get_detail($id);
            $cekTransaksi = $this->Transaksi_model->check_transaksi($id);
            if ($cekTransaksi) {
                $message = "Transaksi sudah pernah didaftarkan";
                $statusCode = 200;
                http_response_code('200');
                echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $resultData));
            } else {
                $message = "Uang sampah telah masuk";
                $message = "Selamat! Request telah selesai";
                $this->Admin_model->decrementQuota($result->fk_admin);

                $dataTransaksi = [
                    "_id" => generate_id(),
                    "fk_request" => $id,
                    "fk_auth" => $this->user->email,
                ];

                $transaksi = $this->create_transaksi($dataTransaksi);
                if ($transaksi) {
                    $statusCode = 200;
                    http_response_code('200');
                }
                $resultNotification = $this->send_notification_to_nasabah($emailNasabah, $message);

                echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $resultData, 'notification' => $resultNotification));
            }
        }
    }

    public function confirm($id)
    {
        $this->user = _checkUser($this);
        $result = $this->RequestSampah_model->get_one(['_id' => $id]);
        $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
        $admin = $this->Admin_model->get_admin_by_id($result->fk_admin);
        $emailNasabah = $nasabah->fk_auth;
        if ($admin->un_daily_quota > 0) {
            $data['r_status'] = 1;
            $resultQuery = $this->RequestSampah_model->update_request($data, ["_id" => $id]);
            if ($resultQuery) {
                $message = "Menunggu Petugas Datang";
                $message = "Request telah dikonfirmasi";
                $resultNotification = $this->send_notification_to_nasabah($emailNasabah, $message);
                $resultData = $this->RequestSampah_model->get_detail($id);
                $statusCode = 200;
                http_response_code('200');
                // echo json_encode(array('status' => $statusCode, 'data' => $resultData));
                echo json_encode(array('status' => $statusCode, 'message' => $message, 'data' => $resultData, 'notification' => $resultNotification));
            }
        } else {
            $statusCode = 200;
            http_response_code('200');
            $message = "Maaf, kuota harian telah habis!";
            echo json_encode(array('status' => $statusCode, 'message' => $message));
        }
    }

    public function reject($id)
    {
        $this->user = _checkUser($this);
        $result = $this->RequestSampah_model->get_one(['_id' => $id]);
        $nasabah = $this->Nasabah_model->get_where(["_id" => $result->fk_nasabah])[0];
        $emailNasabah = $nasabah->fk_auth;
        $data['r_status'] = -1;
        $resultQuery = $this->RequestSampah_model->update_request($data, ["_id" => $id]);
        if ($resultQuery) {
            $message = "Request anda telah ditolak";
            $resultData['message'] = "Request berhasil ditolak";
            $resultNotification = $this->send_notification_to_nasabah($emailNasabah, $message);
            $resultData = $this->RequestSampah_model->get_detail($id);
            $statusCode = 200;
            http_response_code('200');
            echo json_encode(array('status' => $statusCode, 'notification' => $resultNotification, 'data' => $resultData));
        }
    }

    function create_transaksi($data)
    {
        $transaksi = $this->Transaksi_model->create_transaksi($data);
        if ($transaksi) {
            $this->create_mutasi($data['fk_request']);
        }
    }

    function create_mutasi($idRequest)
    {
        $request = $this->RequestSampah_model->get_detail($idRequest);
        $idNasabah = $request->fk_nasabah;
        $data = [
            "_id" => generate_id(),
            "kode" => $request->j_name,
            "m_satuan" => $request->r_weight,
            "m_information" => "Penukaran dengan Barang $request->jenis_sampah",
            "m_type" => "Debit",
            "m_amount" => $request->harga,
            "fk_nasabah" => $idNasabah
        ];
        $mutation = $this->Mutasi_model->create_mutasi($data);
        if ($mutation) {
            $this->add_balance($request->harga, $idNasabah);
        } else {
            echo json_encode(array('status' => 500, 'message' => 'Gagal membuat mutasi'));
        }
    }

    function add_balance($amount, $idNasabah)
    {
        $where = [
            "_id" => $idNasabah
        ];
        $add = $this->Nasabah_model->balance($amount, $where, "+");
        if (!$add) {
            echo json_encode(array('status' => 500, 'message' => 'Gagal membuat mutasi'));
        }
    }

    function send_notification_to_nasabah($emailNasabah, $message)
    {
        $title = "Pembaruan request sampahmu!";
        $device = $this->Device_model->get_by_auth($emailNasabah);
        $devices = [];
        for ($i = 0; $i < count($device); $i++) {
            array_push($devices, $device[$i]->registration_id);
        }
        $resultNotification = sendFCM($title, $message, $devices);
        return $resultNotification;
    }

    function send_notification_to_admin($emailAdmin, $title, $message, $imageName)
    {
        $device = $this->Device_model->get_by_auth($emailAdmin);
        $devices = [];
        for ($i = 0; $i < count($device); $i++) {
            array_push($devices, $device[$i]->registration_id);
        }
        $resultNotification = sendFCM($title, $message, $devices, base_url("uploads/mobile/" . $imageName));

        return $resultNotification;
    }
}
