<?php
    include_once "booklist.php";

    class user extends booklist{
        var $username;
        var $password;

        public function login(){
            $user = $this->getUser();//check if user exist
            if($user === false){  
                return "username is not valid";
                exit;
            }else{
                $password = $this->getUserPassword(); // got by index
                if($password == $this->getPassword()){
                    return  $user;
                }else{
                    return "wrong password";
                }
            }
            //check if password match
        }
        
        //chech if username exists
        //returns user index if exists or false when it doesn't
        public function getUser(){
            $data = parent::getOnlineData();
            $inUser = $this->getUsername();
            $names =[];
            for($i=0;$i < sizeof($data);$i++){
                $names[]=$data[$i]["userName"];
            }
            return array_search($inUser,$names);
        }

        public function getUserPassword(){
            $data = parent::getOnlineData();
            $index = $this->getUser();
            $password = $data[$index]["password"];
            return $password;
        }




        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of username
         */ 
        public function getUsername()
        {
                return $this->username;
        }

        /**
         * Set the value of username
         *
         * @return  self
         */ 
        public function setUsername($username)
        {
                $this->username = $username;

                return $this;
        }
    }

?>