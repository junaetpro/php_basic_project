<?php

$server= "localhost";
$user= "admin";
$pass= "123";
$db= "php_basic_project";

$conn= new mysqli($server, $user, $pass, $db);

if(!$conn){
    echo "database not connect";
}

?>
