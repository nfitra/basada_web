<?php

defined('BASEPATH') or exit('No direct script upload allowed');

class Upload extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Role_model');
        $this->load->model('Upload_model');
    }

    function index()
    {
        $data = array(
            'title' => 'Upload Tutorial',
            'active' => 'Upload Tutorial',
            'user' => _get_user($this),
            'listUpload' => $this->Upload_model->get_upload()
        );
        wrapper_templates($this, "upload/index", $data);
    }

    function create()
    {
        $check = [
            'vid' => $this->Upload_model->check_tutorial('video'),
        ];
        $data = array(
            'title' => 'Tambah File Tutorial',
            'active' => 'Upload Tutorial',
            'user' => _get_user($this),
            'check' => $check,
        );
        wrapper_templates($this, "upload/create", $data);
    }

    function update($id)
    {
        $where = [
            "_id" => $id
        ];
        $data = array(
            'title' => 'Ubah File Tutorial',
            'active' => 'Upload Tutorial',
            'user' => _get_user($this),
            'data' => $this->Upload_model->get_one($where),
        );
        wrapper_templates($this, "upload/update", $data);
    }
    function add_file($type)
    {
        $upload = $type == "pic" ? $this->do_upload($type, "picture") : $this->do_upload($type, "video");
        if ($upload["status"]) {
            $file_title = xss_input($this->input->post("file_title", true));
            $dataGambar = [
                "_id" => generate_id(),
                "file_title" => $file_title,
                "file_name" => xss_input($upload["file"]),
                "file_type" => $type == "pic" ? "picture" : "video",
            ];
            $insert = $this->Upload_model->create_upload($dataGambar);
            if ($insert) {
                _set_flashdata($this, 'message', 'success', 'Tambah File Tutorial Berhasil', 'upload');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Tambah File Tutorial Gagal', 'upload');
            }
        } else {
            $eng = trim($upload['error']['error'], "</p>");
            $ind = [
                "The file you are attempting to upload is larger than the permitted size." => "Gambar yang anda masukkan maksimal berukuran 512kb",
            ];
            $ind["The filetype you are attempting to upload is not allowed."] = "File yang diupload harus dengan extensi " . ($type == "pic" ? ".jpg/.jpeg/.png" : ".mp4/.mkv/.3gp/.avi/.m4v");
            _set_flashdata($this, 'message', 'danger', $ind[$eng], 'upload');
        }
    }

    function change_file($type, $id)
    {
        $upload = $type == "pic" ? $this->do_upload($type, "picture") : $this->do_upload($type, "video");
        if ($upload["status"]) {
            $file_title = xss_input($this->input->post("file_title", true));
            $dataGambar = [
                "file_title" => $file_title,
                "file_name" => xss_input($upload["file"]),
            ];
            $where = [
                '_id' => $id
            ];
            $data = $this->Upload_model->get_one($where);
            $update = $this->Upload_model->update_upload($dataGambar, $where);
            if ($update) {
                unlink($data->file_name);
                _set_flashdata($this, 'message', 'success', 'Ubah File Tutorial Berhasil', 'upload');
            } else {
                _set_flashdata($this, 'message', 'danger', 'Ubah File Tutorial Gagal', 'upload');
            }
        } else {
            $eng = trim($upload['error']['error'], "</p>");
            $ind = [
                "The file you are attempting to upload is larger than the permitted size." => "Gambar yang anda masukkan maksimal berukuran 512kb",
            ];
            $ind["The filetype you are attempting to upload is not allowed."] = "File yang diupload harus dengan extensi " . ($type == "pic" ? ".jpg/.jpeg/.png" : ".mp4/.mkv/.3gp/.avi/.m4v");
            _set_flashdata($this, 'message', 'danger', $ind[$eng], 'upload');
        }
    }

    function delete($id = "")
    {
        if ($id) {
            $where = [
                '_id' => $id
            ];
            $data = $this->Upload_model->get_one($where);
            $delete = $this->Upload_model->delete_upload($where);
            if ($delete) {
                unlink($data->file_name);
                _set_flashdata($this, 'message', 'success', "Delete file tutorial berhasil !", 'upload');
            } else {
                _set_flashdata($this, 'message', 'danger', "Delete file tutorial gagal !", 'upload');
            }
        } else {
            _set_flashdata($this, 'message', 'danger', 'Masukkan ID yang valid', 'upload');
        }
    }

    public function do_upload($type, $name)
    {
        $new_name = time() . str_replace(' ', '_', $_FILES[$name]['name']);
        $config['upload_path']          = './uploads/tutorial/';
        $config['file_name']            = $new_name;
        if ($type === "pic") {
            $config['allowed_types']        = 'jpg|png|gif';
            $config['max_size']             = 2048;
        } else {
            $config['allowed_types']        = 'mp4|mkv|3gp|avi|m4v';
        }

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($name)) {
            $error = array('error' => $this->upload->display_errors());
            return array("status" => false, "error" => $error);
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array("status" => true, "file" => $config['upload_path'] . $new_name);
        }
    }
}
