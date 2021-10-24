<?php
    require "Database.php";
    class AddUser
    {
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function Merchant_validation(&$Name,&$Email,&$User_password,&$Email_permission,&$List_view_permission,&$Payment_permission,&$Forget_password_permission,&$Login_permission){
            $validate = new Validate();
            $data = json_decode(file_get_contents("php://input"),true);
            
            //$Image = $data['Image'];
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
        function Add_user_api($Name,$Email,$User_password,$Email_permission,$List_view_permission,$Payment_permission,$Forget_password_permission,$Login_permission){
            self::headers_function();
            
        }


    }

?>