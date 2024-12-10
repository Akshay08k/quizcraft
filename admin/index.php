<?php
session_start();
if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

require_once('../db.php');

$userCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$quizCount = mysqli_query($conn, "SELECT COUNT(*) as count FROM quizzes")->fetch_assoc()['count'];
$totalPlays = mysqli_query($conn, "SELECT COUNT(*) as count FROM quiz_attempts")->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Admin Dashboard</title>

    <link rel="shortcut icon" href="../public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/output.css">
</head>

<body class="bg-gray-100">
    <?php include('./sidebar.php'); ?>

    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Users</h2>
                <p class="text-4xl font-bold text-blue-600"><?php echo $userCount; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Quizzes</h2>
                <p class="text-4xl font-bold text-green-600"><?php echo $quizCount; ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Quiz Plays</h2>
                <p class="text-4xl font-bold text-purple-600"><?php echo $totalPlays; ?></p>
            </div>
        </div>
    </div>
</body>

</html>