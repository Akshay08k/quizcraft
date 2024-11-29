<?php
session_start();
include 'db.php';

// Check if user is logged in and quiz is in progress
if (!isset($_SESSION['user_id']) || !isset($_SESSION['current_quiz_id']) || !isset($_SESSION['quiz_questions'])) {
    header("Location: quizz.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_SESSION['current_quiz_id'];
$quiz_questions = $_SESSION['quiz_questions'];

// Check if quiz was terminated
$terminated = isset($_GET['terminated']) ? true : false;

$total_questions = count($quiz_questions);
$correct_answers = 0;

// If not terminated, validate answers
if (!$terminated) {
    foreach ($quiz_questions as $question_id) {
        // Retrieve the correct answer from the database
        $check_sql = "SELECT question_text, options, correct_answer FROM questions WHERE id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $question_id);
        $check_stmt->execute();
        $result = $check_stmt->get_result();

        if ($result->num_rows > 0) {
            $question = $result->fetch_assoc();

            // Get user's answer
            $user_answer = isset($_POST['question_' . $question_id]) ? $_POST['question_' . $question_id] : null;

            // Parse options (assuming it's stored as a JSON string)
            $options = json_decode($question['options'], true);

            // Check if the user's answer matches the correct answer
            if ($user_answer !== null && $user_answer == $question['correct_answer']) {
                $correct_answers++;
            }
        }
        $check_stmt->close();
    }
}

// Calculate percentage
$score_percentage = $terminated ? 0 : round(($correct_answers / $total_questions) * 100, 2);

// Save result to database
$insert_sql = "INSERT INTO quiz_results (user_id, quiz_id, total_questions, correct_answers, score_percentage, attempt_date) 
               VALUES (?, ?, ?, ?, ?, ?)";
$date = date('Y-m-d');
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("iiidsi", $user_id, $quiz_id, $total_questions, $correct_answers, $score_percentage, $date);
$insert_stmt->execute();
$insert_stmt->close();

// Clear session quiz data
unset($_SESSION['current_quiz_id']);
unset($_SESSION['quiz_questions']);
unset($_SESSION['quiz_start_time']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result - QuizCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <?php if ($terminated): ?>
            <h1 class="text-4xl font-bold mb-6 text-red-600">Quiz Terminated</h1>
            <p class="text-xl mb-6">You left the quiz screen and did not return in time.</p>
        <?php else: ?>
            <h1 class="text-4xl font-bold mb-6 text-green-600">Quiz Completed!</h1>

            <div class="mb-6">
                <p class="text-2xl">Total Questions: <span class="font-bold"><?php echo $total_questions; ?></span></p>
                <p class="text-2xl">Correct Answers: <span
                        class="font-bold text-green-600"><?php echo $correct_answers; ?></span></p>
                <p class="text-2xl">Score: <span class="font-bold text-blue-600"><?php echo $score_percentage; ?>%</span>
                </p>
            </div>

            <div class="mt-6">
                <h2 class="text-2xl font-bold mb-4">Detailed Results</h2>
                <?php
                // Retrieve and display detailed quiz results
                foreach ($quiz_questions as $question_id) {
                    $detail_sql = "SELECT question_text, options, correct_answer FROM questions WHERE id = ?";
                    $detail_stmt = $conn->prepare($detail_sql);
                    $detail_stmt->bind_param("i", $question_id);
                    $detail_stmt->execute();
                    $detail_result = $detail_stmt->get_result();

                    if ($detail_result->num_rows > 0) {
                        $question_detail = $detail_result->fetch_assoc();
                        $user_answer = isset($_POST['question_' . $question_id]) ? $_POST['question_' . $question_id] : 'Not Answered';
                        $options = json_decode($question_detail['options'], true);
                        $is_correct = $user_answer == $question_detail['correct_answer'];

                        echo "<div class='mb-4 p-4 " . ($is_correct ? 'bg-green-100' : 'bg-red-100') . " rounded'>";
                        echo "<p class='font-bold'>" . htmlspecialchars($question_detail['question_text']) . "</p>";
                        echo "<p>Your Answer: " . htmlspecialchars($user_answer) . "</p>";
                        echo "<p>Correct Answer: " . htmlspecialchars($question_detail['correct_answer']) . "</p>";
                        echo "</div>";
                    }
                    $detail_stmt->close();
                }
                ?>
            </div>
        <?php endif; ?>

        <div class="space-x-4 mt-6">
            <a href="quizz.php" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Back to Quizzes
            </a>
            <a href="profile.php" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                View Profile
            </a>
        </div>
    </div>
</body>

</html>