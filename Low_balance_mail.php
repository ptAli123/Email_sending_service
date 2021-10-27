<?php
     require "Database.php";
     class LowBalanceMail
     {
        private $Emails;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        // function Take_email(&$Email){
            
        //     $data = json_decode(file_get_contents("php://input"),true);
            
        //     $Email = $data['Email'];
        // }
        function fetch_email(){
            $db = new Database();
            $this->Emails = $db->Fetch_emails();
        }

        function Send_mails(){

            $subject = "Low Balance";
            $body = "Please recharge your Balance";
            $headers = "From: pt.alihussain@gmail.com"; // mail from will be change after testing
            for($i = 0; $i < sizeof($this->Emails); $i++){
                $to_email = $this->Emails[$i];
                //mail($to_email, $subject, $body, $headers);
            }
        }
        function Low_balance_mail(){
            self::headers_function();
            //self::Take_email();
            self::fetch_email();
            self::Send_mails();
        }
     }

     $obj = new LowBalanceMail();
     $obj->Low_balance_mail();
     

?>