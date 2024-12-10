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

$delete_query = "DELETE FROM users WHERE id = $user_id";
if (mysqli_query($conn, $delete_query)) {
    header('Location: users.php?message=User Deleted Successfully');
    exit();
} else {
    die("Failed to delete user: " . mysqli_error($conn));
}