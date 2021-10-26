<?php
    require "Database.php";
    class stripe
    {
        private $amount;
        private $data;
        function headers_function(){    
            header("Content-Type: application/json");
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Methods:POST");
        }
        function user_validation(&$Merchant_email,&$Merchant_token){
            $input = json_decode(file_get_contents("php://input"),true);
           
            $Merchant_email = $input['Merchant_Email'];
            $Merchant_token = $input['Merchant_Token'];
            $this->data =  [
                'card[number]' => $input['number'],
                'card[exp_month]' => $input['expMonth'],
                'card[exp_year]' => $input['expYear'],
                'card[cvc]' => $input['cvc']
            ];
            $this->amount = $input['Amount'];
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

        function Credit_update($Email){
            $db = new Database();
            $Credit = $db->get_credit($Email);
            $Id = $db->get_card_id($Email);
            $Credit = $Credit + $this->amount;
            $db->Update_credit($Id,$Credit);
        }

        function Stripe_api($Merchant_email,$Merchant_token){
            self::headers_function();
            self::user_validation($Merchant_email,$Merchant_token);
            if (self::match_token($Merchant_email,$Merchant_token) == true){
                echo "yes you are valid";
                $db = new Database();
                $stripTokenResponse = $db->getStripeToke($this->data);
                $stripTokenRes = json_decode($stripTokenResponse);
                $stripToken =  $stripTokenRes->id;
                $addBalance = $db->charge($stripToken,$this->amount);
                self::Credit_update($Merchant_email);
            }
            else{
                die("you are not allowed to Payment");
            }
        }
    }
    $Merchant_email = null;
    $Merchant_token = null;
    $Stripe = new stripe();
    $Stripe->Stripe_api($Merchant_email,$Merchant_token);
?>