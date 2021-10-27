<?php
    require "Database.php";
    class Admin
    {
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }

        function json_conversion($Object)
        {
            return json_encode($Object);
        }

        function Merchant_list(){
            $db = new Database();
            $result = $db->Merchant_list();
            echo self::json_conversion($result);
        }
        function Request_list(){
            $db = new Database();
            $result = $db->request_complete_list();
            echo self::json_conversion($result);
        }

        function Admin_api(){
            self::headers_function();
            self::Merchant_list();
            self::Request_list();
        }
    }

    $Admin = new Admin();
    $Admin->Admin_api();

?>