<?php
$name=$_GET['n'];
header('Content-type: application/pdf'); // set content type
// header("Content-Disposition: attachment; filename=$name.pdf"); // force download
header('Content-disposition: attachment; filename='.$name.'.pdf');
readfile("assets/books/$name.pdf"); // read the content to server
?>