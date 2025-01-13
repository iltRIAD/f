<?php
require_once('../model/userModel.php');

$data = json_decode(file_get_contents('php://input'), true);
deleteUser($data['id']);
echo "User deleted successfully!";
?>
