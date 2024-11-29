<?php
session_start();
// Authentication check
// if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
//     header('Location: login.php');
//     exit();
// }

// Database conn
require_once('../db.php');

// Fetch quizzes with category information
$query = "
    SELECT 
        q.id, 
        q.name, 
        qc.name AS category, 
        (SELECT COUNT(*) FROM questions WHERE quiz_id = q.id) AS question_count,
        (SELECT COUNT(*) FROM quiz_attempts WHERE quiz_id = q.id) AS attempt_count
    FROM 
        quizzes q
    JOIN 
        categories qc ON q.category_id = qc.id
    ORDER BY 
        q.id DESC
";
$result = mysqli_query($conn, $query);

// Handle quiz deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $quiz_id = intval($_GET['delete']);

    // Begin transaction
    mysqli_begin_transaction($conn);

    try {
        // Delete related answers

        // Delete related questions
        mysqli_query($conn, "DELETE FROM questions WHERE quiz_id = $quiz_id");

        // Delete quiz attempts
        mysqli_query($conn, "DELETE FROM quiz_attempts WHERE quiz_id = $quiz_id");

        // Delete the quiz
        mysqli_query($conn, "DELETE FROM     WHERE id = $quiz_id");

        // Commit transaction
        mysqli_commit($conn);

        header('Location: quizzes.php?success=deleted');
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        header('Location: quizzes.php?error=deletion_failed');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Manage Quizzes</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <?php include('./sidebar.php'); ?>

    <div class="ml-64 p-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Manage Quizzes</h1>
            <a href="create_quiz.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Create New Quiz
            </a>
        </div>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                <?php
                if ($_GET['success'] == 'deleted')
                    echo "Quiz successfully deleted.";
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <?php
                if ($_GET['error'] == 'deletion_failed')
                    echo "Failed to delete quiz. Please try again.";
                ?>
            </div>
        <?php endif; ?>

        <div class="bg-white shadow-md rounded">
            <table class="w-full">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Category</th>
                        <th class="p-3 text-left">Questions</th>
                        <th class="p-3 text-left">Total Attempts</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($quiz = mysqli_fetch_assoc($result)): ?>
                        <tr class="border-b">
                            <td class="p-3"><?php echo $quiz['id']; ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($quiz['name']); ?></td>
                            <td class="p-3"><?php echo htmlspecialchars($quiz['category']); ?></td>

                            </td>
                            <td class="p-3"><?php echo $quiz['question_count']; ?></td>
                            <td class="p-3"><?php echo $quiz['attempt_count']; ?></td>
                            <td class="p-3">
                                <div class="flex space-x-2">
                                    <a href="edit_quiz.php?id=<?php echo $quiz['id']; ?>"
                                        class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>
                                    <a href="quiz_details.php?id=<?php echo $quiz['id']; ?>"
                                        class="text-green-600 hover:text-green-800">
                                        View
                                    </a>
                                    <a href="quizzes.php?delete=<?php echo $quiz['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this quiz?');"
                                        class="text-red-600 hover:text-red-800">
                                        Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <?php if (mysqli_num_rows($result) == 0): ?>
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mt-4 text-center">
                No quizzes found. <a href="create_quiz.php" class="underline">Create your first quiz</a>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>