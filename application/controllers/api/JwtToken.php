<?php
require APPPATH . '/libraries/CreatorJwt.php';

class JwtToken extends CI_Controller
{
    public function __construct()
    {
        
        parent::__construct();
        $this->objOfJwt = new CreatorJwt();
        header('Content-Type: application/json');
        // $this->dataJson = [];
        // if($received_Token = $this->input->request_headers('Authorization')){
        //     if(isset($received_Token['Token'])){
        //         $jwtData = $this->objOfJwt->DecodeToken($received_Token['Token']);
        //         $this->dataJson = $jwtData;
        //     } else {
        //         http_response_code('401');
        //         echo json_encode(array( "status" => false, "message" => "Unauthorized"));
        //         exit;
        //     }
        // }
        // else{
        //     http_response_code('401');
        //     echo json_encode(array( "status" => 401, "message" => "Unauthorized"));
        //     exit;
        // }
    }

    /*************Ganerate token this function use**************/

    public function LoginToken()
    {
        $tokenData['uniqueId'] = '11';
        $tokenData['role'] = 'alamgir';
        $tokenData['timeStamp'] = Date('Y-m-d h:i:s');
        $tokenData['microtime'] = microtime(true) * 1000000;
        $jwtToken = $this->objOfJwt->GenerateToken($tokenData);
        echo json_encode(array('Token'=>$jwtToken, 'data'=>$tokenData));
    }
     
   /*************Use for token then fetch the data**************/
         
    public function GetTokenData()
    {
        $received_Token = $this->input->request_headers('Authorization');
        try
        {
            $jwtData = $this->objOfJwt->DecodeToken($received_Token['Token']);
            echo json_encode(["real"=>$jwtData]);
        }
        catch (Exception $e)
            {
            http_response_code('401');
            echo json_encode(array( "status" => false, "message" => $e->getMessage()));exit;
        }
    }
}