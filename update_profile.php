<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
    $stmt->execute([
        ':username' => $name,
        ':email' => $email,
        ':id' => $_SESSION['user_id']
    ]);
    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;
    header("Location: profile.php");
    exit();
}