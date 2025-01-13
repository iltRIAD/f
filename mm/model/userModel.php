<?php

function get_connection(){

    $conn = mysqli_connect("127.0.0.1", "root", "", "local" );
    return $conn;
}



function login($username, $password){
    $conn = get_connection();
    $sql = "select * from users where username = '{$username}' and password = '{$password}'";
    $result = mysqli_query($conn, $sql);
    $row_count = mysqli_num_rows($result);
    if($row_count > 0){
        return true;
    }
    else{
        return false;
    }
}

// function addUser($name, $email, $username, $password){
//     $conn = get_connection();
//     $sql = "INSERT INTO users VALUES('','{$name}', '{$username}', '{$password}', '{$email}')";
//     if(mysqli_query($conn, $sql)){
//         return true;
//     }else{
//         return false;
//     }
// }

// Add a new user
function addUser($name, $email, $username, $password) {
    $conn = get_connection();

    $sql = "INSERT INTO users (name, email, username, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssss", $name, $email, $username, $password);

    if ($stmt->execute()) {
        $stmt->close();
        $conn->close();
        return true;
    } else {
        $stmt->close();
        $conn->close();
        return false;
    }
}






// Function to get user ID
// function getUserID($username, $password) {
//     $conn = getConnection();
//     $sql = "SELECT id, password FROM users WHERE username = ?";
//     $stmt = $conn->prepare($sql);

//     if (!$stmt) {
//         die("Error preparing statement: " . $conn->error);
//     }

//     $stmt->bind_param("s", $username);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows === 1) {
//         $user = $result->fetch_assoc();
//         if (password_verify($password, $user['password'])) {
//             return $user['id']; // Return user ID if password matches
//         }
//     }

//     $stmt->close();
//     $conn->close();
//     return null; // User not found or password doesn't match
// }


// Fetch all users
function getAllUsers() {
    $conn = get_connection();
    $sql = "SELECT id, name, email, username, status FROM users";
    $result = $conn->query($sql);

    if ($result === false) {
        die("SQL query failed: " . $conn->error);
    }

    $users = $result->fetch_all(MYSQLI_ASSOC);
    $conn->close();
    return $users;
}

// Update user profile
function updateUser($id, $name, $email, $status) {
    $conn = get_connection();
    $sql = "UPDATE users SET name = ?, email = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssi", $name, $email, $status, $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}

// Delete user
function deleteUser($id) {
    $conn = get_connection();
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $stmt->close();
    $conn->close();
    return true;
}


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    username VARCHAR(50),
    password VARCHAR(255),
    status VARCHAR(20) DEFAULT 'active'
);
