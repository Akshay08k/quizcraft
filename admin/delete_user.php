<?php
session_start();
require_once('../db.php');

if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID");
}

$user_id = intval($_GET['id']);

try {
    $conn->beginTransaction();

    $stmt = $conn->prepare("DELETE FROM quiz_attempts WHERE user_id = :id");
    $stmt->execute([':id' => $user_id]);

    $delete_query = "DELETE FROM users WHERE id = :id";
    $stmt = $conn->prepare($delete_query);
    $stmt->execute([':id' => $user_id]);

    $conn->commit();

    header('Location: users.php?success=deleted');
    exit();
} catch (PDOException $e) {
    $conn->rollBack();
    die("Failed to delete user: " . htmlspecialchars($e->getMessage()));
}
