<?php
    include_once "includes/booklist.php";
    $list = new booklist();
    ob_start();
    session_start();
    $list->setUserIndex($_SESSION['user']);

    if(isset($_GET['book']) && isset($_GET['list'])){                                              
        if(ctype_space($_GET['book'])|| empty($_GET['book']) || ctype_space($_GET['list'])|| empty($_GET['list'])){
            header('location:index.php');
        }else{
            $bookName = $_GET['book'];
            $listName = $_GET['list'];
            // set names
            $list->setListName($listName);
            $list->setName($bookName);
            // get list index
           print_r($list->deleteBook());
            header("location:view.php?&list=$listName");
        }
    }else{
        header('location:index.php');
    }

?>