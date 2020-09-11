<?php
    class booklist{
        var $listName;
        var $OnlineData;
        var $name;
        var $author;
        var $releaseDate;
        var $cover;
        var $userIndex;
        var $remoteUrl;
        var $remoteList;
        var $item;

        // using curl to fetch data from jsonbin.IO
        function __construct(){
            $ch = curl_init();
            //configurations
            $key='$2b$10$Exi.En25XNvZTiQeDCZdy.Sb//o1f5eprugysLsaSCEvnEPhEh.7a';
            $ctype='application/json';
            $headerVal = array(
                "secret-key:".$key
            );
            $type = array(
                "content-type:".$ctype
            );
            curl_setopt_array($ch, array(
                CURLOPT_URL => "https://api.jsonbin.io/b/5f464f28514ec5112d0ea9db/latest",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER=>$headerVal,
                CURLOPT_HEADER=>$ctype
            ));
            //show me the result
            $output = curl_exec($ch);
            //close curl
            curl_close($ch);
            $output = json_decode($output,true);
            $this->setOnlineData($output);
        }

        //adding a new empty list
        public function createList(){
            $newList = array(
                "listName"=>$this->getListName(),
                "books"=> array()
            );

            $current = $this->getOnlineData(); //fetch data
            $uIndex = $this->getUserIndex();    //get user by index 
            $current[$uIndex]["lists"][]=$newList;  //add a new list
            $this->setOnlineData($current); //update data locally
            $save =$this->saveChanges();    //update online data
            return $save;
        }

        //updating online json file on jsonbin.IO
        public function saveChanges(){
            $data = $this->getOnlineData(); //get latest version of local data
            $data_json = json_encode($data);
            //configs
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://api.jsonbin.io/b/5f464f28514ec5112d0ea9db");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','secret-key:$2b$10$Exi.En25XNvZTiQeDCZdy.Sb//o1f5eprugysLsaSCEvnEPhEh.7a','Accept: application/json','Content-Length: ' . strlen($data_json)));
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response  = json_decode(curl_exec($ch));
            curl_close($ch);
        }

        // get all lists for a user
        public function getLists(){
            $data = $this->getOnlineData(); //get online data
            $lists = $data[$this->getUserIndex()]["lists"]; //extract user lists
            $names=[];
            for($i=0;$i < sizeof($lists);$i++){
                $names[]=$lists[$i]["listName"];
            }
            return $names;
        }

        public function getListIndex(){
            $listName = $this->getListName();
            $lists=$this->getLists();
            $index = array_search($listName,$lists);
            return $index;
        }

        //get remote list by url
        public function getRemote(){
            $ch = curl_init();
            //configurations
            $key='$2b$10$Exi.En25XNvZTiQeDCZdy.Sb//o1f5eprugysLsaSCEvnEPhEh.7a';
            $ctype='application/json';
            $headerVal = array(
                "secret-key:".$key
            );
            $type = array(
                "content-type:".$ctype
            );
            $url=$this->getRemoteUrl();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER=>$headerVal,
                CURLOPT_HEADER=>$ctype
            ));
            //show me the result
            $output = curl_exec($ch);
            //close curl
            curl_close($ch);
            $output = json_decode($output,true);
            $this->setRemoteList($output);
        }

        public function import(){
            $listName = $this->getListName();
            $index = $this->getListIndex();
            $books = $this->getItem();
            //get current data
            $current = $this->getOnlineData();
            $current[$this->getUserIndex()]["lists"][$index]["books"][]=$books;
            $this->setOnlineData($current);
            $save =$this->saveChanges();
            return $save;
        }
        //---------------------------book functions----------------------- 

        public function addBook(){
            $listName = $this->getListName();
            $index = $this->getListIndex();

            $book = array(      //book to be added
                "book name"=>$this->getName(),
                "author"=> $this->getAuthor(),
                "release date"=>$this->getReleaseDate(),
                "cover image"=>$this->getCover()
            );

            //get current data
            $current = $this->getOnlineData();
            //add book
            $current[$this->getUserIndex()]["lists"][$index]["books"][]=$book;
            $this->setOnlineData($current);
            $save =$this->saveChanges();
            return $save;
        }
        
        public function deleteBook(){
            //book array from list name
            $current = $this->getOnlineData();      //get current data
            $books = $this->getBookByListIndex(); //current book 
            $listIndex=$this->getListIndex();      //current list 
            $bookIndex = $this->getBookIndex();     // book to be deleted

            $newbooks = array_splice($books,$bookIndex,1); //contains the removed item, $book contains the remains

            $current[$this->getUserIndex()]["lists"][$listIndex]["books"]=$books; // update local
            $this->setOnlineData($current); 
            $save = $this->saveChanges(); //update online
            return $save;
        }

        public function getBookByListIndex(){
            // get list index 
            $listName = $this->getListName();
            $index = $this->getListIndex();
            // get list books
            $current = $this->getOnlineData();
            $books = $current[$this->getUserIndex()]["lists"][$index]["books"];
            return $books;
        }

        public function getBookIndex(){
            $bookName = $this->getName();
            $books=$this->getBookByListIndex();
            $names=[];
            for($i=0;$i < sizeof($books);$i++){
                $names[]=$books[$i]["book name"];
            }
            $index = array_search($bookName,$names);
            return $index;
        }

        //setters & getters
        public function setName($name){
            $this->name= $name;
        }
        public function getName(){
            return $this->name;
        }

        public function setAuthor($author){
            $this->author= $author;
        }
        public function getAuthor(){
            return $this->author;
        }

        public function setReleaseDate($releaseDate){
            $this->releaseDate= $releaseDate;
        }
        public function getReleaseDate(){
            return $this->releaseDate;
        }

        public function setCover($cover){
            $this->cover= $cover;
        }
        public function getCover(){
            return $this->cover;
        }
        
        /**
         * Get the value of listName
         */ 
        public function getListName()
        {
                return $this->listName;
        }

        /**
         * Set the value of listName
         *
         * @return  self
         */ 
        public function setListName($listName)
        {
                $this->listName = $listName;

                return $this;
        }

        /**
         * Get the value of OnlineData
         */ 
        public function getOnlineData()
        {
                return $this->OnlineData;
        }

        /**
         * Set the value of OnlineData
         *
         * @return  self
         */ 
        public function setOnlineData($OnlineData)
        {
                $this->OnlineData = $OnlineData;

                return $this;
        }

        /**
         * Get the value of userIndex
         */ 
        public function getUserIndex()
        {
                return $this->userIndex;
        }

        /**
         * Set the value of userIndex
         *
         * @return  self
         */ 
        public function setUserIndex($userIndex)
        {
                $this->userIndex = $userIndex;

                return $this;
        }

        /**
         * Get the value of remoteUrl
         */ 
        public function getRemoteUrl()
        {
                return $this->remoteUrl;
        }

        /**
         * Set the value of remoteUrl
         *
         * @return  self
         */ 
        public function setRemoteUrl($remoteUrl)
        {
                $this->remoteUrl = $remoteUrl;

                return $this;
        }

        /**
         * Get the value of remoteList
         */ 
        public function getRemoteList()
        {
                return $this->remoteList;
        }

        /**
         * Set the value of remoteList
         *
         * @return  self
         */ 
        public function setRemoteList($remoteList)
        {
                $this->remoteList = $remoteList;

                return $this;
        }

        /**
         * Get the value of item
         */ 
        public function getItem()
        {
                return $this->item;
        }

        /**
         * Set the value of item
         *
         * @return  self
         */ 
        public function setItem($item)
        {
                $this->item = $item;

                return $this;
        }
    }
?>