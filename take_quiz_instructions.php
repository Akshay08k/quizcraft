<?php
session_start();
include 'db.php';

// Check if user is logged in
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz details
$quiz_sql = "SELECT * FROM quizzes   WHERE id = ?";
$quiz_stmt = $conn->prepare($quiz_sql);
$quiz_stmt->bind_param("i", $quiz_id);
$quiz_stmt->execute();
$quiz_result = $quiz_stmt->get_result();

if ($quiz_result->num_rows == 0) {
    die("Quiz not found");
}

$quiz = $quiz_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Instructions - <?php echo htmlspecialchars($quiz['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-lg shadow-lg max-w-2xl w-full">
        <h1 class="text-3xl font-bold mb-6 text-center">Quiz Instructions:
            <?php echo htmlspecialchars($quiz['name']); ?>
        </h1>

        <div class="space-y-4 mb-6">
            <div class="bg-blue-50 p-4 rounded-lg">
                <h2 class="font-semibold text-xl mb-2">Important Rules:</h2>
                <ul class="list-disc list-inside">
                    <li>This quiz consists of multiple-choice questions</li>
                    <li>You have 1 minute per question</li>
                    <li>Total quiz time: <span id="total-time"></span></li>
                    <li>Once you start, you must complete the quiz in one sitting</li>
                    <li>Leaving the quiz screen will terminate the attempt</li>
                </ul>
            </div>

            <div class="bg-yellow-50 p-4 rounded-lg">
                <h2 class="font-semibold text-xl mb-2">Quiz Guidelines:</h2>
                <ul class="list-disc list-inside">
                    <li>Select only one answer per question</li>
                    <li>You can navigate between questions</li>
                    <li>Your final score will be calculated automatically</li>
                </ul>
            </div>
        </div>

        <div class="text-center">
            <form id="startQuizForm" action="takeQuiz.php" method="GET">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                <button type="submit"
                    class="bg-green-500 text-white px-8 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                    Proceed to Quiz
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const totalQuestions = <?php    
            $count_sql = "SELECT COUNT(*) as count FROM questions WHERE quiz_id = ?";
            $count_stmt = $conn->prepare($count_sql);
            $count_stmt->bind_param("i", $quiz_id);
            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $question_count = $count_result->fetch_assoc()['count'];
            echo $question_count;
            ?>;
            const totalTime = totalQuestions * 60;
            const minutes = Math.floor(totalTime / 60);
            const seconds = totalTime % 60;

            document.getElementById('total-time').textContent =
                `${minutes} minutes ${seconds} seconds`;
        });
    </script>
</body>

</html>