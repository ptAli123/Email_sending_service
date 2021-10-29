<?php 
require "vendor/stripe/stripe-php/init.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Database{
    public $card_reference_key;

    private function build_connection(){     //build sql database connection 
        $conn = new mysqli("localhost","root","","mail_sending_service");
        if ($conn->connect_error){
            echo "Database Connection Error";
        }
        else{
            //echo "connection";
            return $conn;
        }
        
    }
    private function close_connection($conn){   //close database connection
        $conn->close();
    }

    /**
     * Function to insert user or Employee in database.
     * 
     */


    function insert($tableName,$perameter){
        $col_name = null;
        if ($tableName == "card"){
            $col_name = "Card_number,Cvc_number,Valid_from,Valid_till"; 
        }elseif($tableName == "merchant"){
            $col_name = "Name,Email,Merchant_Password,Image,Current_at,Card_id";
        }elseif($tableName == "secondary_user"){
            $col_name = "Name,Email,User_password,Email_permission,List_view_permission,Payment_permission,Forget_password_permission,Login_permission,Merchant_id";
        }elseif($tableName == "request"){
            $col_name = "Mail_from,Mail_to,Mail_cc,Mail_bcc,Subject,Body,Merchant_id,Response_id";
        }elseif($tableName == "response"){
            $col_name = "Status,error,Description";
        }

        $S = implode("','",$perameter);
        $S2 = "'".$S."'";
        $conn = self::build_connection();
        

        $q2 = "insert into $tableName($col_name) values($S2)";
        $conn->query($q2);
        //echo "Data successfully insert!";
        self::close_connection($conn);
    }



    // this function take tableName , Col_name, its col value and return id on that value.
    function get_id($tableName,$col_name,$value){
        $conn = self::build_connection();
        $V = "'$value'";
        $q = "select Id from $tableName where $col_name = $V";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Id'];
        self::close_connection($conn);
        return $ret;
    }
    // this function take tableName , Email, Password and return true if entries exist and false if not.
    function Search_login($tableName,$Email,$Password,$password_col){
        $conn = self::build_connection();
        $E = "'$Email'";
        $P = "'$Password'";
        $q = "select * from $tableName where Email = $E and $password_col = $P";
        $result = $conn->query($q);
        if ($result->num_rows > 0){
            return true;
        }else{
            return false;
        }
        self::close_connection($conn);
    }
    // this function take Token and Email, update token and status for login merchants
    function Update_token($Token,$Email){
        $conn = self::build_connection();
        $T = "'$Token'";
        $E = "'$Email'";
        $q = "UPDATE merchant SET Token = $T, Status = 1 where Email = $E";
        $result = $conn->query($q);
        self::close_connection($conn);
    }
    // this function take Email, update Create_at and current_at time for login merchants
    function Set_login_time($Email){
        $conn = self::build_connection();
        $t = time();
        $Time = date("H:i:s",$t);
        $T = "'$Time'";
        $E = "'$Email'";
        $q = "UPDATE merchant SET Create_at = $T, Current_at = $T where Email = $E";
        $result = $conn->query($q);
        self::close_connection($conn);
    }

    // this function will remove token and change status for logout merchant
    function Logout_merchant($Email){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "UPDATE merchant SET Token = null, Status = 0 where Email = $E";
        $result = $conn->query($q);
        self::close_connection($conn);
    }
    // take email and return token according to that email
    function Get_token($tableName,$Email){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "select * from $tableName where Email = $E";// and new() <= data_add(Create_at,interval 15 minute)";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Token'];
        self::close_connection($conn);
        return $ret;
    }
    // take tableName and return last entry Id
    function Get_response_refernce_key($tableName){
        $conn = self::build_connection();
        $q = "SELECT Id FROM $tableName ORDER BY Id  DESC LIMIT 1";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Id'];
        self::close_connection($conn);
        return $ret;
    }
    // take mercant Eamil and return its credit value
    function get_credit($Email){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "select Credit from card where Id = (select Card_id from merchant where Email=$E)";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Credit'];
        self::close_connection($conn);
        return $ret;
    }
    // take mercant Eamil and return its Id value
    function get_card_id($Email){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "select Id from card where Id = (select Card_id from merchant where Email=$E)";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Id'];
        self::close_connection($conn);
        return $ret;
    }
    //after email send, reduce credit function
    function Update_credit($Id,$Credit){
        $conn = self::build_connection();
        $q = "UPDATE card SET Credit = $Credit where Id = $Id";
        $result = $conn->query($q);
        self::close_connection($conn);
    }
    // take Email and return merchant data
    function List_view($Email){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "select * from merchant where Email = $E";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = array("Id"=>$row['Id'],
                "Name"=>$row['Name'],
                "Email"=>$row['Email'],
                "Merchant_Password"=>$row['Merchant_Password'],
                "Image"=>$row['Image'],
                "Create_at"=>$row['Create_at']);
        self::close_connection($conn);
        return $ret;
    }
    //take merchant Id and return its users
    function Secondary_user_list($Id){
        $conn = self::build_connection();
        $q = "select * from secondary_user where merchant_id = $Id";
        $result = $conn->query($q);
        $users = array();
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $ret = array("Id"=>$row['Id'],
                "Name"=>$row['Name'],
                "Email"=>$row['Email'],
                "Email_permission"=>$row['Email_permission'],
                "List_view_permission"=>$row['List_view_permission'],
                "Payment_permission"=>$row['Payment_permission']);
                $users[$row['Id']] = $ret;
            }
        }
        self::close_connection($conn);
        return $users;
    }
    // take marchant id and return its card info
    function cart_list($Id){
        $conn = self::build_connection();
        $q = "select * from card where Id = (select Card_id from merchant where Id=$Id)";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = array("Id"=>$row['Id'],
                "Card_number"=>$row['Card_number'],
                "Credit"=>$row['Credit'],
                "Cvc_number"=>$row['Cvc_number'],
                "Valid_from"=>$row['Valid_from'],
                "Valid_till"=>$row['Valid_till']);
        self::close_connection($conn);
        return $ret;
    }
    // take merchant id and return its requests and responses
    function Request_list($Id){
        $conn = self::build_connection();
        $q = "select * from request where merchant_id = $Id";
        $result = $conn->query($q);
        $requests = array();
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $ID = $row['Id'];
                $response_q = "select * from response where Id = (select response_id from request where Id=$ID)";
                $response_result = $conn->query($response_q);
                $response_row = $response_result->fetch_assoc();
                $ret = array("Id"=>$row['Id'],
                "Mail_from"=>$row['Mail_from'],
                "Mail_to"=>$row['Mail_to'],
                "Mail_cc"=>$row['Mail_cc'],
                "Mail_bcc"=>$row['Mail_bcc'],
                "Subject"=>$row['Subject'],
                "Body"=>$row['Body'], array("Id"=>$response_row['Id'],"Status"=>$response_row['Status'], "error"=>$response_row['error'], "Description"=>$response_row['Description'] ));
                $requests[$row['Id']] = $ret;
            }
        }
        self::close_connection($conn);
        return $requests;
    }


    // below some functions is for admin action
    function Merchant_list(){
        $conn = self::build_connection();
        $q = "select * from merchant";
        $result = $conn->query($q);
        $users = array();
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $ID = $row['Id'];
                $card_q = "select * from card where Id = (select Card_id from merchant where Id=$ID)";
                $card_result = $conn->query($card_q);
                $card_row = $card_result->fetch_assoc();
                $ret = array("Id"=>$row['Id'],
                "Name"=>$row['Name'],
                "Email"=>$row['Email'],
                "Merchant_Password"=>$row['Merchant_Password'],
                "Image"=>$row['Image'],
                "Create_at"=>$row['Create_at'],array("Id"=>$card_row['Id'],
                "Card_number"=>$card_row['Card_number'],
                "Credit"=>$card_row['Credit'],
                "Cvc_number"=>$card_row['Cvc_number'],
                "Valid_from"=>$card_row['Valid_from'],
                "Valid_till"=>$card_row['Valid_till']));
                $users[$row['Id']] = $ret;
            }
        }
        self::close_connection($conn);
        return $users;
    }


    function request_complete_list(){
        $conn = self::build_connection();
        $q = "select * from request";
        $result = $conn->query($q);
        $requests = array();
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $ID = $row['Id'];
                $response_q = "select * from response where Id = (select response_id from request where Id=$ID)";
                $response_result = $conn->query($response_q);
                $response_row = $response_result->fetch_assoc();
                $ret = array("Id"=>$row['Id'],
                "Mail_from"=>$row['Mail_from'],
                "Mail_to"=>$row['Mail_to'],
                "Mail_cc"=>$row['Mail_cc'],
                "Mail_bcc"=>$row['Mail_bcc'],
                "Subject"=>$row['Subject'],
                "Body"=>$row['Body'], array("Id"=>$response_row['Id'],"Status"=>$response_row['Status'], "error"=>$response_row['error'], "Description"=>$response_row['Description'] ));
                $requests[$row['Id']] = $ret;
            }
        }
        self::close_connection($conn);
        return $requests;
    }

    //Check Validation of Secondary User
    function Check_permission($tableName,$Email,$permission){
        $conn = self::build_connection();
        $E = "'$Email'";
        $q = "select $permission from $tableName where Email = $E";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row[$permission];
        self::close_connection($conn);
        return $ret;
    }

    // Low balance mail api
    function Fetch_emails(){
        $conn = self::build_connection();
        $q = "select Email from merchant inner join card on(merchant.Card_id = card.Id) where card.Credit < 60";
        $result = $conn->query($q);
        $arr = array();
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $size = sizeof($arr);
                $arr[$size] = $row['Email'];
                $size = $size + 1;
            }
        }
        self::close_connection($conn);
        return $arr;
    }

    //take User_mail and return merchant Mail
    function Get_Mercant_mail($User_email){
        $conn = self::build_connection();
        $E = "'$User_email'";
        $q = "select Email from merchant where Id = (select Merchant_id from secondary_user where Email = $E)";
        $result = $conn->query($q);
        $row = $result->fetch_assoc();
        $ret = $row['Email'];
        self::close_connection($conn);
        return $ret;
    }

     // this function take Token and Email, update token and status for login User
     function Update_user_token($Token,$Email){
        $conn = self::build_connection();
        $T = "'$Token'";
        $E = "'$Email'";
        $q = "UPDATE secondary_user SET Token = $T where Email = $E";
        $result = $conn->query($q);
        self::close_connection($conn);
    }

  

        // stripe db functions
    public function getStripeToke($data){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_URL => 'https://api.stripe.com/v1/tokens',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT => true,
            CURLOPT_POSTFIELDS => http_build_query($data),
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer sk_test_51JokwxCOcXmy6SZxZvU7H1ZymEdVFv5XeNF1qD1HCdPtoKMqYVHI9Uc7Y3esFdBZqL6xYvCoYtQCsAleb1NjoqeX00DWYDfcoj',
                'Content-type: application/x-www-form-urlencoded',
            ]
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function charge($token,$amount){
        $stripe = new \Stripe\StripeClient(
            'sk_test_51JokwxCOcXmy6SZxZvU7H1ZymEdVFv5XeNF1qD1HCdPtoKMqYVHI9Uc7Y3esFdBZqL6xYvCoYtQCsAleb1NjoqeX00DWYDfcoj'
        );
        $stripe->charges->create([
            'amount' => $amount,
            'currency' => 'usd',
            'source' => $token,
            'description' => 'balance top up',
        ]);

        return $stripe;
    }
}

?>
