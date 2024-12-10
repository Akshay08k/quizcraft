<?php
session_start();
require_once('../db.php');

// Check if the admin is logged in
if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Fetch all users
$users_query = "SELECT * FROM users";
$users_result = mysqli_query($conn, $users_query);
if (!$users_result) {
    die("Failed to fetch users: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - User Management</title>
    <link rel="shortcut icon" href="../public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/output.css">
</head>

<body class="bg-gray-100">
    <?php include('./sidebar.php'); ?>

    <div class="ml-64 p-8">
        <div class="bg-white shadow-md rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-6">User Management</h1>
            <div class="bg-white shadow-md rounded">
                <table class="w-full">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 text-left">Username</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">Total Quiz Attempts</th>
                            <th class="p-3 text-left">Average Score</th>
                            <th class="p-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($user = mysqli_fetch_assoc($users_result)): ?>
                            <?php
                            // Fetch quiz attempt details for each user
                            $user_id = $user['id'];
                            $attempts_query = "
                                SELECT 
                                    qa.score
                                FROM 
                                    quiz_attempts qa
                                WHERE 
                                    qa.user_id = $user_id
                            ";
                            $attempts_result = mysqli_query($conn, $attempts_query);
                            $total_attempts = mysqli_num_rows($attempts_result);
                            $total_score = 0;

                            while ($attempt = mysqli_fetch_assoc($attempts_result)) {
                                $total_score += $attempt['score'];
                            }

                            $average_score = $total_attempts > 0 ? round($total_score / $total_attempts, 2) : 0;
                            ?>
                            <tr class="border-b">
                                <td class="p-3"><?php echo htmlspecialchars($user['username']); ?></td>
                                <td class="p-3"><?php echo htmlspecialchars($user['email']); ?></td>
                                <td class="p-3"><?php echo $total_attempts; ?></td>
                                <td class="p-3"><?php echo $average_score; ?>%</td>
                                <td class="p-3">
                                    <a href="user_details.php?id=<?php echo $user['id']; ?>"
                                        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View</a>
                                    <button onclick="confirmDeleteUser(<?php echo $user['id']; ?>)"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function confirmDeleteUser(userId) {
            if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                window.location.href = 'delete_user.php?id=' + userId;
            }
        }
    </script>
</body>

</html>