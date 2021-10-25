<?php
    require "Database.php";
    require "validation.php";
    class AddSecondaryUser
    {
        private $merchant_id;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }

        // function Merchant_information(&$Email,&$Token){
        //     $data = json_decode(file_get_contents("php://input"),true);
        //     $Email = $data['Email'];
        //     $Token = $data['Token'];
        // }

        function user_validation(&$Merchant_email,&$Merchant_token,&$Name,&$Email,&$User_password,&$Email_permission,&$List_view_permission,&$Payment_permission,&$Forget_password_permission,&$Login_permission){
            $validate = new Validate();
            $data = json_decode(file_get_contents("php://input"),true);
           
            $Merchant_email = $data['Merchant_Email'];
            $Merchant_token = $data['Merchant_Token'];
            
            if ($validate->name_validate($data['Name']) == true){
                $Name = $data['Name'];
            }
            else{
                die("Name is not valid");
            }
    
            if ($validate->email_validate($data['Email']) == true){
                $Email = $data['Email'];
            }
            else{
                die("Email is not valid");
            }
    
            if ($validate->password_validate($data['User_password']) == true){
                $Merchant_password = $data['User_password'];
            }
            else{
                die("Password is not valid");
            }
            $Email_permission = $data['Email_permission'];
            $List_view_permission = $data['List_view_permission'];
            $Payment_permission = $data['Payment_permission'];
            $Forget_password_permission = $data['Forget_password_permission'];
            $Login_permission = $data['Login_permission'];
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

        function Reference_key($value){
            $db = new Database();
            return $db->get_id("merchant","Email",$value);
        }

        function add_secondary_user_api($Merchant_email,$Merchant_token,$Name,$Email,$User_password,$Email_permission,$List_view_permission,$Payment_permission,$Forget_password_permission,$Login_permission){
            self::headers_function();
            //self::Merchant_information($Merchnat_email,$Merchant_token);
            self::user_validation($Merchant_email,$Merchant_token,$Name,$Email,$User_password,$Email_permission,$List_view_permission,$Payment_permission,$Forget_password_permission,$Login_permission);
            if (self::match_token($Merchant_email,$Merchant_token) == true){
                echo ("yes you are Valid");
                $this->merchant_id = self::Reference_key($Merchant_email);
                $db = new Database();
                $pera = array($Name,$Email,$User_password,$Email_permission,$List_view_permission,$Payment_permission,$Forget_password_permission,$Login_permission,$this->merchant_id);
                $db->insert("secondary_user",$pera);
            }
            else{
                die("you are not allowed to Add User");
            }
            
        }


    }
    $Merchant_email = null;
    $Merchant_token = null;
    $Name = null;
    $Email = null;
    $User_password = null;
    $Email_permission = null;
    $List_view_permission = null;
    $Payment_permission = null;
    $Forget_password_permission = null;
    $Login_permission = null;
    $AddSecondaryUser = new AddSecondaryUser();
    $AddSecondaryUser->add_secondary_user_api($Merchant_email,$Merchant_token,$Name,$Email,$User_password,$Email_permission,$List_view_permission,$Payment_permission,$Forget_password_permission,$Login_permission);


?>