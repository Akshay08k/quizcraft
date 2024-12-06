<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['username'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $_SESSION['user_id']);
    $stmt->execute();
    $_SESSION['username'] = $name;
    $_SESSION['email'] = $email;
    header("Location: profile.php");
    exit();
}