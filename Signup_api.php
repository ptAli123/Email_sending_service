<?php
  require "Database.php";
  require "validation.php";
class SignUpMerchant{
    private $Card_id;
    // This Function contain all headers of Rest API
    
    function headers_function(){    
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods:POST");
    }

    // This function will take Name and CNIC as perameter and check validation

    function Merchant_validation(&$Name,&$Email,&$Merchant_password){
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

        if ($validate->password_validate($data['Merchant_password']) == true){
            $Merchant_password = $data['Merchant_password'];
        }
        else{
            die("Password is not valid");
        }

    }

    function Card_validation(&$Card_number,&$Cvc_number){
        $validate = new Validate();
        $data = json_decode(file_get_contents("php://input"),true);
        
        //$Credit = $data['Credit'];
        
        if ($validate->Card_number_validation($data['Card_number']) == true){
            $Card_number = $data['Card_number'];
        }
        else{
            die("Card Number is not valid");
        }

        if ($validate->Cvc_number_validation($data['Cvc_number']) == true){
            $Cvc_number = $data['Cvc_number'];
        }
        else{
            die("Cvc Number is not valid");
        }

    }

    // This fucntion will take php object , conver to json format and return json

    function json_conversion($Object)
    {
        return json_encode($Object);
    }

    function Reference_key($value){
        $db = new Database();
        return $db->get_id("card","Card_number",$value);
    }


    function Card_Api($tableName,$Card_number,$Cvc_number){
        self::headers_function();
        self::Card_validation($Card_number,$Cvc_number);
        $Valid_from = date("Y-m-d");
        $Valid_till = date('Y-m-d', strtotime( $Valid_from . " +15 days"));
        $db = new Database();
        $pera = array($Card_number,$Cvc_number,$Valid_from,$Valid_till);
        $db->insert($tableName,$pera);
        $this->Card_id = self::Reference_key($Card_number);
    }

 
    function Merchant_Api($tableName,$Name,$Email,$Merchant_password,$Image = "Image.jpeg"){
        self::headers_function();
        self::Merchant_validation($Name,$Email,$Merchant_password);
        $Card_id = $this->Card_id;
        $Create_at = date("H:i:s");
        $Current_at = date("H:i:s");
        $db = new Database();
        $pera = array($Name,$Email,$Merchant_password,$Image,$Create_at,$Current_at,$Card_id);
        $db->insert($tableName,$pera);

    }
    // This fucntion will take table Name , Name, CNIC and fetch data and print in json format
    function Sign_Api($Name,$Email,$Merchant_password,$Card_number,$Cvc_number){
        self::Card_Api("card",$Card_number,$Cvc_number);
        self::Merchant_Api("merchant",$Name,$Email,$Merchant_password);
    }
}
    $Name = null;
    $Email = null;
    $Merchant_password = null;
    $Card_number = null;
    $Cvc_number = null;
    $Credit = null;
    $Api = new SignUpMerchant();
    $Api->Sign_Api($Name,$Email,$Merchant_password,$Card_number,$Cvc_number);

?>