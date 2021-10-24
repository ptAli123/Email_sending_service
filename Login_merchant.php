<?php
    require "Database.php";
    require "validation.php";
    require "jwt.php";
    class Login_merchant
    {
        private $Token;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function Login_validation(&$Email,&$Merchant_password){
            $validate = new Validate();
            $data = json_decode(file_get_contents("php://input"),true);
    
            if ($validate->email_validate($data['Email']) == true){
                $Email = $data['Email'];
            }
            else{
                die("Email is not valid");
            }
    
            if ($validate->password_validate($data['Password']) == true){
                $Merchant_password = $data['Password'];
            }
            else{
                die("Password is not valid");
            }
        }
        private function fetch_token($Email){
            $jwt = new Jwt($Email);
            return $jwt->generate_jwt(); 
        }

        function Login_api($Email,$Merchant_password)
        {   self::headers_function();
            self::Login_validation($Email,$Merchant_password);
            $db = new Database();
            if ($db->Search_login("merchant",$Email,$Merchant_password)){
                $Token = self::fetch_token($Email);
                $db->Update_token($Token,$Email);
                $db->Set_login_time($Email);
                echo $Token;
            }else{
                echo "Your Email or Password is not valid";
            }
        }

    }

    $Email = null;
    $Merchant_password = null;
    $Login = new Login_merchant();
    $Login->Login_api($Email,$Merchant_password);

?>