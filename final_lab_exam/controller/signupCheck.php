<?php
    session_start();

    require_once('../model/userModel.php');

    if(isset($_POST['submit'])){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $email = trim($_POST['email']);

        if($username == null || empty($password) || empty($email)){
            echo "Null username/password/email";
        }else {
            $status = addUser($username, $password, $email);
            if($status){
                header('location: ../view/login.html');
            }else{
                header('location: ../view/signup.html');
            }
        }
    
    }else{
        header('location: ../view/signup.html');
    }
?>