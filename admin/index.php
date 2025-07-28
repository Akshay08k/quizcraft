<?php
session_start();

// Redirect to login if admin not logged in
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: /admin/login.php');
    exit();
}

require_once('../db.php'); // Assumes $conn is your PDO connection

try {
    // Count total users
    $userCountStmt = $conn->query("SELECT COUNT(*) AS count FROM users");
    $userCount = $userCountStmt ? $userCountStmt->fetch(PDO::FETCH_ASSOC)['count'] : 0;

    // Count total quizzes
    $quizCountStmt = $conn->query("SELECT COUNT(*) AS count FROM quizzes");
    $quizCount = $quizCountStmt ? $quizCountStmt->fetch(PDO::FETCH_ASSOC)['count'] : 0;

    // Count total quiz plays
    $totalPlaysStmt = $conn->query("SELECT COUNT(*) AS count FROM quiz_attempts");
    $totalPlays = $totalPlaysStmt ? $totalPlaysStmt->fetch(PDO::FETCH_ASSOC)['count'] : 0;
} catch (PDOException $e) {
    // Log error in production, but show generic message
    $userCount = $quizCount = $totalPlays = 0;
    // error_log($e->getMessage());
}
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

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Users</h2>
                <p class="text-4xl font-bold text-blue-600"><?php echo htmlspecialchars($userCount); ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Quizzes</h2>
                <p class="text-4xl font-bold text-green-600"><?php echo htmlspecialchars($quizCount); ?></p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold">Total Quiz Plays</h2>
                <p class="text-4xl font-bold text-purple-600"><?php echo htmlspecialchars($totalPlays); ?></p>
            </div>
        </div>
    </div>
</body>

</html>
