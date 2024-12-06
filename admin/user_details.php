<?php
session_start();
require_once('../db.php');

// Check if the admin is logged in
if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Validate and fetch user ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid user ID");
}
$user_id = intval($_GET['id']);

// Fetch user details
$user_query = "SELECT * FROM users WHERE id = $user_id";
$user_result = mysqli_query($conn, $user_query);
$user = mysqli_fetch_assoc($user_result);

if (!$user) {
    die("User not found");
}

// Fetch user quiz attempts
$attempts_query = "
    SELECT 
        qa.id, 
        q.name AS quiz_title, 
        qa.score, 
        qa.completed_at,
        qc.name AS category
    FROM 
        quiz_attempts qa
    JOIN 
        quizzes q ON qa.quiz_id = q.id
    JOIN 
        categories qc ON q.category_id = qc.id
    WHERE 
        qa.user_id = $user_id
    ORDER BY 
        qa.completed_at DESC
";
$attempts_result = mysqli_query($conn, $attempts_query);

// Calculate user stats
$total_attempts = mysqli_num_rows($attempts_result);
$total_score = 0;
$categories_played = [];

while ($attempt = mysqli_fetch_assoc($attempts_result)) {
    $total_score += $attempt['score'];
    $categories_played[$attempt['category']] = true;
}

$average_score = $total_attempts > 0 ? round($total_score / $total_attempts, 2) : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include('./sidebar.php'); ?>

    <div class="ml-64 p-8">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-6">User Details</h1>
            <div class="flex items-center mb-6">
                <div
                    class="w-24 h-24 bg-blue-500 rounded-full flex items-center justify-center text-white text-4xl mr-6">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
                <div>
                    <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($user['username']); ?></h1>
                    <p class="text-gray-600"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-100 p-4 rounded">
                    <h3 class="text-lg font-semibold">Total Quiz Attempts</h3>
                    <p class="text-2xl font-bold"><?php echo $total_attempts; ?></p>
                </div>
                <div class="bg-green-100 p-4 rounded">
                    <h3 class="text-lg font-semibold">Average Score</h3>
                    <p class="text-2xl font-bold"><?php echo $average_score; ?>%</p>
                </div>
                <div class="bg-purple-100 p-4 rounded">
                    <h3 class="text-lg font-semibold">Categories Played</h3>
                    <p class="text-2xl font-bold"><?php echo count($categories_played); ?></p>
                </div>
            </div>

            <h2 class="text-2xl font-bold mb-4">Quiz Attempt History</h2>
            <div class="bg-white shadow-md rounded">
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Quiz Title</th>
                            <th class="p-3 text-left">Category</th>
                            <th class="p-3 text-left">Score</th>
                            <th class="p-3 text-left">Completed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        mysqli_data_seek($attempts_result, 0);
                        while ($attempt = mysqli_fetch_assoc($attempts_result)):
                            ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo htmlspecialchars($attempt['quiz_title']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($attempt['category']); ?></td>
                                <td class="p-3"><?php echo $attempt['score']; ?>%</td>
                                <td class="p-3"><?php echo date('d M Y H:i', strtotime($attempt['completed_at'])); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <a href="users.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Back to Users
                </a>
            </div>
        </div>
    </div>
</body>

</html>