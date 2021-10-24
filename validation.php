<?php
    class Validate      //Create validation class to check all the input in correct methord :
    {
        /**
         *email_validate function get one parmeter and check email pattern if pattern match return true else false
         */
        public function email_validate($email){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return false; 
            }
            else{
                return true;
            } 
        }
        /**
         * password_validate function get one parmeter and check password pattern if pattern match return true else false
         */
        public function password_validate($password){
            $password_pattern='/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/';     //password length > 8 and also 1 uppercase charecter
            if(!preg_match($password_pattern, $password)){  //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
        
        /**
         *name_validate function get one parmeter and check name pattern if pattern match return true else false
         */
        public function name_validate($name){
            $name_pattern="/^[a-zA-Z ]*$/";     //Not Accept Special character and digit
            if(!preg_match($name_pattern, $name)){      //check patteren match
                return false;
            }
            else{
                return true;
            } 
        }
       
       public function Card_number_validation($Card_number){
        $Card_pattern = "/^[0-9]{15}$/";
        if (!preg_match($Card_pattern, $Card_number)){
            return false;
        }else{
            return true;
        }
       }

       public function Cvc_number_validation($Cvc_number){
        $Cvc_pattern = "/^[0-9]{4}$/";
        if (!preg_match($Cvc_pattern, $Cvc_number)){
            return false;
        }else{
            return true;
        }
       }

       public function Date_validation($Date){
           $Date_pattern = "/^[0-9]{4}:[0-2]{2}:[0-3]{2}$/";
           if(!preg_match($Date_pattern,$Date)){
               return false;
           }else{
               return true;
           }
       }
    }
?>
