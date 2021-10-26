<?php
    require "Database.php";
    require "validation.php";
    class ListView
    {
        private $Id;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function Merchant_validation(&$Merchant_email,&$Merchant_token){
            $data = json_decode(file_get_contents("php://input"),true);
            $Merchant_email = $data['Merchant_Email'];
            $Merchant_token = $data['Merchant_Token'];
        }
        private function match_token($Email,$Token){
            $db = new Database();
            $T = $db->Get_token("merchant",$Email);
            // echo $T;
            // echo $Token;
            if ($T == $Token){
                return true;
            }else{
                return false;
            }
        }

        function json_conversion($Object)
        {
            return json_encode($Object);
        }

        function Merchant_info($Merchant_email){
            $db = new Database();
            $result = $db->List_view($Merchant_email);
            $this->Id = $result['Id'];
            echo self::json_conversion($result);
        }

        function Merchant_users(){
            $db = new Database();
            $result = $db->Secondary_user_list($this->Id);
            echo self::json_conversion($result);
        }

        function Merchant_card(){
            $db = new Database();
            $result = $db->cart_list($this->Id);
            echo self::json_conversion($result);
        }

        function Merchant_requests(){
            $db = new Database();
            $result = $db->Request_list($this->Id);
            echo self::json_conversion($result);
        }

        function Merchant_information_api($Merchant_email,$Merchant_token){
            self::headers_function();
            self::Merchant_validation($Merchant_email,$Merchant_token);
            if(self::match_token($Merchant_email,$Merchant_token) == true){
                echo ("yes you are Valid");
                self::Merchant_info($Merchant_email);
                self::Merchant_users();
                self::Merchant_card();
                self::Merchant_requests();
            }
            else{
                die("you are not allowed to view List");
            }
        }

    }

    $Merchant_email = null;
    $Merchant_token = null;
    $merchant_list = new ListView();
    $merchant_list->Merchant_information_api($Merchant_email,$Merchant_token);
?>