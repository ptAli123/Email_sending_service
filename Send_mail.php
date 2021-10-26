<?php
    require "Database.php";
    require "validation.php";
    class SendMail
    {
        private $merchant_id;
        private $response_id;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }

        function user_validation(&$Merchant_email,&$Merchant_token,&$Mail_from,&$Mail_to,&$Mail_cc,&$Mail_bcc,&$Subject,&$Body){
            $validate = new Validate();
            $data = json_decode(file_get_contents("php://input"),true);
           
            $Merchant_email = $data['Merchant_Email'];
            $Merchant_token = $data['Merchant_Token'];
            
    
            if ($validate->email_validate($data['Mail_from']) == true){
                $Mail_from = $data['Mail_from'];
            }
            else{
                die("Email from is not valid");
            }

            if ($validate->email_validate($data['Mail_to']) == true){
                $Mail_to = $data['Mail_to'];
            }
            else{
                die("Email to is not valid");
            }

            if ($data['Mail_cc'] != null){
                if ($validate->email_validate($data['Mail_cc']) == true){
                    $Mail_cc = $data['Mail_cc'];
                }
                else{
                    die("Email_cc to is not valid");
                }
            }

            if ($data['Mail_bcc'] != null){
                if ($validate->email_validate($data['Mail_bcc']) == true){
                    $Mail_bcc = $data['Mail_bcc'];
                }
                else{
                    die("Email_bcc to is not valid");
                }
            }

            $Subject = $data['Subject'];
            $Body = $data['Body'];

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

        function Merchant_reference_key($value){
            $db = new Database();
            return $db->get_id("merchant","Email",$value);
        }

        function send_mail($Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body){
            $to_email = $Mail_to;
            $subject = $Subject;
            $body = $Body;
            $headers = "From: pt.alihussain@gmail.com"; // mail from will be change after testing

            if (mail($to_email, $subject, $body, $headers)) {
                return true;
            } else {
                return false;
            }
        }

        function json_conversion($Object)
        {
            return json_encode($Object);
        }

        function Generate_response(){
            $response = array('received','processed','error','invalid');
            $response_number = rand(0,3);
            $feedback = $response[$response_number];
            $error = null;
            if ($feedback == "error"){
                $error = "this is error";
            }
            $object = array("response" => "$feedback",
                            "error" => "$error",
                            "description" => "this mail is mail");
            $db = new Database();
            $pera = array($object["response"],$object["error"],$object["description"]);
            $db->insert("response",$pera);
            echo self::json_conversion($object);

        }

        function Credit_handle($Email){
            $db = new Database();
            $Credit = $db->get_credit($Email);
            $Id = $db->get_card_id($Email);
            if ($Credit >= 0.0489){
                $Credit = $Credit - 0.0489;
                $db->Update_credit($Id,$Credit);
            }
            else{
                $msg = array("Alert" => "You have Sufficient Balance to Send Mail Please Recharge!");
                echo self::json_conversion($msg);
                die;
            }

        }

        function get_response_id(){
            $db = new Database();
            return $db->Get_response_refernce_key("response");
        }

        function Send_email_api($Merchant_email,$Merchant_token,$Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body){
            self::headers_function();
            self::user_validation($Merchant_email,$Merchant_token,$Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body);
            if (self::match_token($Merchant_email,$Merchant_token) == true){
                echo ("yes you are Valid");
                self::Credit_handle($Merchant_email);
                $this->merchant_id = self::Merchant_reference_key($Merchant_email);
                if (self::send_mail($Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body)){
                    echo "Email successfully sent to $Mail_to...";
                    self::Generate_response();
                    $this->response_id = self::get_response_id();

                    $db = new Database();
                    $pera = array($Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body,$this->merchant_id,$this->response_id);
                    $db->insert("request",$pera);
                }
                else{
                    echo json_encode(array('Message'=>'Email Sending Failed  :','status'=>204));
                    die;//("Email sending failed...");
                }
               
                
            }
            else{
                echo json_encode(array('Message'=>'you are not allowed to send Mail  :','status'=>204));
                die;//("you are not allowed to Send Mail");
            }
        }
    }


    $Merchant_email = null;
    $Merchant_token = null;
    $Mail_from = null;
    $Mail_to = null;
    $Mail_cc = null;
    $Mail_bcc = null;
    $Subject = null;
    $Body = null;
    $sendMalik = new SendMail();
    $sendMalik->Send_email_api($Merchant_email,$Merchant_token,$Mail_from,$Mail_to,$Mail_cc,$Mail_bcc,$Subject,$Body)


?>