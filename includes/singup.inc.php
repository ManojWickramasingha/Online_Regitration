<?php
    if(isset($_POST["submit"])){
        $userName = $_POST["your-name"];
        $email = $_POST["email"];
        $Uid = $_POST["username"]; 
        $nic = $_POST["nic"];
        $phone = $_POST["phone"];
        $corsDistrict = $_POST["cors-district"];
        $examYear = $_POST["exam-year"];
        $courseListScol = $_POST["course-list-scol"];
        //$resultSitting = $_POST["result-sitting"];
        //$fileSchol = $_POST["file-schol"];
        //$fileCv = $_POST["file-cv"];
        $userPassword = $_POST["your-password"];
        $userConfirmPassword = $_POST["your-conpassword"];

        require_once 'dbh.inc.php';
        require_once 'function.inc.php';

        $emptyInput = emptyInputSingup($userName,$email,$phone,$userPassword,$userConfirmPassword);

        $invalidUid = invalidUid($Uid);
        $invalidEmail = invalidEmail($email);
        $pwdMatch = pwdMath($userPassword,$userConfirmPassword);
        $uidExits = uidExits($conn,$email, $Uid);


        if($emptyInput !== false){
            header("Location:../Register.php?error=emptyInput");
            exit();
        }

        if($invalidUid !== false){
            header("Location:../Register.php?error=invalidUid");
            exit();
        }

        if( $invalidEmail !== false){
            header("Location:../Register.php?error=invalidEmail");
            exit();
        }

        if($pwdMatch !== false){
            header("Location:../Register.php?error=passworddontmatch");
            exit();
        }

        if($uidExits !== false){
            header("Location:../Register.php?error=usernameExist");
            exit();
        }
        

        createUser($conn,$userName,$email,$nic,$corsDistrict,$examYear,$courseListScol,$userPassword,$Uid,$phone);
        
    }
    else{
        header('Location:../login.php');
        exit();
    }