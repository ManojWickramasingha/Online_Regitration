<?php
    if(isset($_POST["submit"])){
        $username = $_POST["uid"];
        $password = $_POST["pwd"];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';

        $isEmpty = emptyInputLogin($username, $password);

        if($isEmpty !== false){
            header("location:../login.php?error=empty");
            exit();
        }

        loginUser($conn, $username,$password);
    }
    else{
        header('Location:../login.php');
        exit();
    }