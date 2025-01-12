<?php
session_start();
require_once('../model/userModel.php');

if (isset($_POST['submit'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        echo "Null username/password";
    } else {
        $user = login($username, $password); // Fetch user data during login
        if ($user) {
            $_SESSION['user_id'] = $user['id']; // Store user ID in session
            setcookie('status', 'true', time() + 3000, '/');
            header('location: ../view/home.php');
        } else {
            echo "Invalid User!";
        }
    }
} else {
    header('location: ../view/login.html');
}
?>
