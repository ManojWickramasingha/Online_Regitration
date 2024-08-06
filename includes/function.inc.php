<?php

function emptyInputSingup($userName,$email,$phone,$userPassword,$userConfirmPassword)
{

    $result;
    if(empty($userName) || empty($email)  || empty($phone)   || empty($userPassword) || empty($userConfirmPassword))
    {
        $result = true;

    }else{
        $result = false;
    }

    return $result;
}

function invalidUid($Uid)
{

    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $Uid))
    {
        $result = true;

    }else{
        $result = false;
    }

    return $result;
}

function invalidEmail($email)
{
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $result = true;

    }else{
        $result = false;
    }

    return $result;
}

function pwdMath($userPassword,$userConfirmPassword)
{
    $result;
    if($userPassword !== $userConfirmPassword)
    {
        $result = true;

    }else{
        $result = false;
    }

    return $result;

}

function uidExits($conn,$email, $Uid)
{
    $sql = "SELECT * FROM users WHERE usersEmail = ? OR usersUld = ?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("Location:../Register.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss",$email,$Uid);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData))
    {
        return $row;
    }
    else
    {
        return false;
    }

    mysqli_stmt_close($stmt);

}

function createUser($conn,$userName,$email,$nic,$corsDistrict,$examYear,$courseListScol,$userPassword,$Uid,$phone)
{
    $sql = "INSERT INTO users(usersName,usersEmail,usersNic,usersDistric,usersExameYear,usersCourse,usersPassword,usersUld,usersPhone) VALUES(?,?,?,?,?,?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql))
    {
        header("Location:../singup.php?error=stmtfailed");
        exit();
    }

    $hashPwd = password_hash($userPassword, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssssss", $userName,$email,$nic,$corsDistrict,$examYear,$courseListScol,$hashPwd,$Uid,$phone);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("Location:../login.php?error=none");
    exit();
}

function emptyInputLogin($username, $password)
{

    $result;
    if(empty($username) || empty($password)){
        $result = true;

    }else{
        $result = false;
    }

    return $result;
}

function loginUser($conn,$username,$password)
{
    $ExistUser = uidExits($conn,$username,$username);
    if($ExistUser === false)
    {
        header('Location:../Register.php?error=wronglogin1');
        exit();
    }
    $pwHashed = $ExistUser["usersPassword"];
    $checkPw = password_verify($password, $pwHashed);

    if($checkPw === false)
    {
        header('Location:../Register.php?error=wrongLogin2');
        exit();
    }
    elseif($checkPw === true)
    {
        session_start();
        $_SESSION["userid"] = $ExistUser["usersId "];
        $_SESSION["useruid"] = $ExistUser["usersUId"];
        header("Location:../Home.php");
        exit();
    }
}