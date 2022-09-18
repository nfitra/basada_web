<?php
require APPPATH . '/libraries/CreatorJwt.php';

function _decodeToken($ci, $req)
{
    $ci->objOfJwt = new CreatorJwt();
    try {
        return $ci->objOfJwt->DecodeToken($req);
        // echo json_encode(["real"=>$jwtData]);
    }
    catch (Exception $e) {
        http_response_code('401');
        return json_encode([ "status" => false, "message" => $e->getMessage()]);
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
    if(empty($formdata)){
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
    
    if(array_key_exists("token",$received_Token) || array_key_exists("Token",$received_Token)){
        // var_dump(_decodeToken($ci, $received_Token['token']));
        $email= _decodeToken($ci, $received_Token['token'])['data']->email;
        $where=[
            'fk_auth' => $email
        ];
        $auth = $ci->db->get_where('nasabah',$where);
        if(empty($auth)){
            $tokenData = [
                'message' => "Tidak ada akun yang login saat ini"
            ];
            http_response_code('401');
            echo json_encode(array('status' => 401, 'data' => $tokenData));die;
        }
        return $auth->row();
    }
    else{
        $tokenData = [
            'message' => "Tidak ada token dari user"
        ];
        http_response_code('401');
        echo json_encode(array('status' => 401, 'data' => $tokenData));die;
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
    
    if(array_key_exists("token", $received_Token) || array_key_exists("Token", $received_Token)){
        // var_dump(_decodeToken($ci, $received_Token['token']));
        $email= _decodeToken($ci, $received_Token['token'])['data']->email;
        $where=[
            'email' => $email
        ];
        $auth = $ci->db->get_where('auth', $where);
        return $auth->row();
    }
    else{
        $tokenData = [
            'message' => "Tidak ada token dari user"
        ];
        http_response_code('401');
        echo json_encode(array('status' => 401, 'data' => $tokenData));die;
    }
}
