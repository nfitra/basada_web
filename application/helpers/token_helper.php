<?php
require APPPATH . '/libraries/CreatorJwt.php';

function _decodeToken($ci, $req)
{
    $ci->objOfJwt = new CreatorJwt();
    try {
        return $ci->objOfJwt->DecodeToken($req);
        // echo json_encode(["real"=>$jwtData]);
    } catch (Exception $e) {
        http_response_code('401');
        return json_encode(["status" => false, "message" => $e->getMessage()]);
    }
}

function _encodeToken($ci, $data)
{
    $ci->objOfJwt = new CreatorJwt();
    return $ci->objOfJwt->GenerateToken($data);
}

function _checkInput()
{
    ini_set("allow_url_fopen", true);
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: ACCEPT, CONTENT-TYPE, X-CSRF-TOKEN");
    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $formdata = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');
    if (empty($formdata)) {
        $tokenData = [
            'message' => "Belum ada inputan"
        ];
        http_response_code('401');
        echo json_encode(array('status' => 401, 'data' => $tokenData));
        die;
    }
}

function _checkNasabah($ci)
{
    ini_set("allow_url_fopen", true);
    header('Content-Type: application/json');
    // $received_Token = $ci->input->request_headers('Authorization');
    // var_dump(getallheaders());
    // die();
    $received_Token = getAllheaders();

    if (array_key_exists("token", $received_Token)) {
        // if (array_key_exists("token", $received_Token) || array_key_exists("Token", $received_Token)) {
        // var_dump(_decodeToken($ci, $received_Token['token']));
        $email = _decodeToken($ci, $received_Token['token'])['email'];
        $where = [
            'fk_auth' => $email
        ];
        $auth = $ci->db->get_where('nasabah', $where);
        if (empty($auth)) {
            $tokenData = [
                'message' => "Tidak ada akun yang login saat ini"
            ];
            http_response_code('401');
            echo json_encode(array('status' => 401, 'data' => $tokenData));
            die;
        }
        return $auth->row();
    } else if (array_key_exists("Token", $received_Token)) {
        $email = _decodeToken($ci, $received_Token['Token'])['email'];
        $where = [
            'fk_auth' => $email
        ];
        $auth = $ci->db->get_where('nasabah', $where);
        if (empty($auth)) {
            $tokenData = [
                'message' => "Tidak ada akun yang login saat ini"
            ];
            http_response_code('401');
            echo json_encode(array('status' => 401, 'data' => $tokenData));
            die;
        }
        return $auth->row();
    } else {
        $tokenData = [
            'message' => "Tidak ada token dari user"
        ];
        http_response_code('401');
        echo json_encode(array('status' => 401, 'data' => $tokenData));
        die;
    }
}

function _checkUser($ci)
{
    ini_set("allow_url_fopen", true);
    header('Content-Type: application/json');
    // $received_Token = $ci->input->request_headers('Authorization');
    // var_dump(getallheaders());
    // die();
    $received_Token = getAllheaders();

    if (array_key_exists("token", $received_Token)) {
        // if (array_key_exists("token", $received_Token) || array_key_exists("Token", $received_Token)) {
        //var_dump(_decodeToken($ci, $received_Token['token']));
        $email = _decodeToken($ci, $received_Token['token'])["email"];
        $where = [
            'email' => $email
        ];
        $auth = $ci->db->get_where('auth', $where);
        return $auth->row();
    } else if (array_key_exists("Token", $received_Token)) {
        $email = _decodeToken($ci, $received_Token['Token'])["email"];
        $where = [
            'email' => $email
        ];
        $auth = $ci->db->get_where('auth', $where);
        return $auth->row();
    } else {
        $tokenData = [
            'message' => "Tidak ada token dari user"
        ];
        http_response_code('401');
        echo json_encode(array('status' => 401, 'data' => $tokenData));
        die;
    }
}

function parsePutRequest()
{
    // Fetch content and determine boundary
    $raw_data = file_get_contents('php://input');
    $boundary = substr($raw_data, 0, strpos($raw_data, "\r\n"));

    // Fetch each part
    $parts = array_slice(explode($boundary, $raw_data), 1);
    $data = array();

    foreach ($parts as $part) {
        // If this is the last part, break
        if ($part == "--\r\n") break;

        // Separate content from headers
        $part = ltrim($part, "\r\n");
        list($raw_headers, $body) = explode("\r\n\r\n", $part, 2);

        // Parse the headers list
        $raw_headers = explode("\r\n", $raw_headers);
        $headers = array();
        foreach ($raw_headers as $header) {
            list($name, $value) = explode(':', $header);
            $headers[strtolower($name)] = ltrim($value, ' ');
        }

        // Parse the Content-Disposition to get the field name, etc.
        if (isset($headers['content-disposition'])) {
            $filename = null;
            preg_match(
                '/^(.+); *name="([^"]+)"(; *filename="([^"]+)")?/',
                $headers['content-disposition'],
                $matches
            );
            list(, $type, $name) = $matches;
            isset($matches[4]) and $filename = $matches[4];

            // handle your fields here
            switch ($name) {
                    // this is a file upload
                case 'userfile':
                    file_put_contents($filename, $body);
                    break;

                    // default for all other files is to populate $data
                default:
                    $data[$name] = substr($body, 0, strlen($body) - 2);
                    break;
            }
        }
    }
    return $data;
}
