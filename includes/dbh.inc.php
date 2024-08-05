<?php

$serverName = "localhost";
$dbUsername ="Todo123";
$dbPassword ="SCrpAEMVtSYUmz!/";
$dbName="edu.todo.crm.login";

$conn = mysqli_connect($serverName,$dbUsername,$dbPassword,$dbName);

if(!$conn){
    die("Connection failed: " .mysqli_connect_error());
}else{
    echo 'connection successful';
}