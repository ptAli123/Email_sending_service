<?php
    require "Database.php";
    class Logout_merchant
    {
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function Take_Crediants(&$Email){
            $data = json_decode(file_get_contents("php://input"),true);
            $Email = $data['Email'];
        }
        function Logout_api($Email)
        {
            self::Take_Crediants($Email);
            $db = new Database();
            $db->Logout_merchant($Email);
            echo json_encode(array('Message'=>'You have Successfully Logout...:','status'=>200));
        }
    }

    $Email = null;
    $Logout = new Logout_merchant();
    $Logout->Logout_api($Email);
?>