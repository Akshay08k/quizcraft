<?php
session_start();
require_once('../db.php');

// Check if the admin is logged in
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch all users with total attempts & average score in one go
$users_query = "
    SELECT 
        u.id, 
        u.username, 
        u.email,
        COUNT(qa.id) AS total_attempts,
        COALESCE(AVG(qa.score), 0) AS average_score
    FROM 
        users u
    LEFT JOIN 
        quiz_attempts qa ON u.id = qa.user_id
    GROUP BY 
        u.id
    ORDER BY 
        u.id DESC
";
$users_stmt = $conn->query($users_query);
$users = $users_stmt ? $users_stmt->fetchAll(PDO::FETCH_ASSOC) : [];

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

        <?php if (empty($users)): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-4 text-center">
                No users found.
            </div>
        <?php else: ?>
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
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo htmlspecialchars($user['username']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($user['email']); ?></td>
                            <td class="p-3"><?php echo (int)$user['total_attempts']; ?></td>
                            <td class="p-3"><?php echo number_format($user['average_score'], 2); ?>%</td>
                            <td class="p-3">
                                <a href="user_details.php?id=<?php echo (int)$user['id']; ?>"
                                   class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View</a>
                                <button onclick="confirmDeleteUser(<?php echo (int)$user['id']; ?>)"
                                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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
