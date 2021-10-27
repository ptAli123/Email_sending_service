<?php
    require "Database.php";
    require "validation.php";
    require "jwt.php";
    class LoginUser
    {
        private $Token;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function Login_validation(&$Email,&$User_password){
            $validate = new Validate();
            $data = json_decode(file_get_contents("php://input"),true);
    
            if ($validate->email_validate($data['Email']) == true){
                $Email = $data['Email'];
            }
            else{
                echo json_encode(array('Message'=>'Email is not valid  :','status'=>204));
                die;//("Email is not valid");
            }
    
            if ($validate->password_validate($data['Password']) == true){
                $User_password = $data['Password'];
            }
            else{
                echo json_encode(array('Message'=>'Password is not valid  :','status'=>204));
                die;
                //die("Password is not valid");
            }
        }
        function json_conversion($Object)
        {
            return json_encode($Object);
        }

        private function fetch_token($Email){
            $jwt = new Jwt($Email);
            return $jwt->generate_jwt(); 
        }
        function Check_permissoin($Email){
            $db = new Database();
            if ($db->Check_permission("secondary_user",$Email,"Login_permission") == 1){
                return true;
            }
            else{
                return false;
            }
        }

        function Login_api($Email,$User_password)
        {   self::headers_function();
            self::Login_validation($Email,$User_password);
            if (self::Check_permissoin($Email)){

            
                $db = new Database();
                if ($db->Search_login("secondary_user",$Email,$User_password,"User_password")){
                    $Token = self::fetch_token($Email);
                    $db->Update_token($Token,$Email);
                    $db->Set_login_time($Email);
                    $TokenArr = array("Token"=>$Token);
                    echo self::json_conversion($TokenArr);
                    echo json_encode(array('Message'=>'you are successfully Login up  :','status'=>200));
                }else{
                    //echo "Your Email or Password is not valid";
                    echo json_encode(array('Message'=>'Your Email or Password is not valid  :','status'=>204));
                }
            }
            else{
                echo json_encode(array('Message'=>'You Are not Allowed to Login  :','status'=>204));
            }
        }

    }

    $Email = null;
    $User_password = null;
    $Login = new LoginUser();
    $Login->Login_api($Email,$User_password);

?>