
<?php
require_once('../model/userModel.php');

$data = json_decode(file_get_contents('php://input'), true);
updateUser($data['id'], $data['name'], $data['email'], $data['status']);
echo "User updated successfully!";
?>
