<?php
session_start();
include 'db.php';

// Check if the quiz session is valid
if (!isset($_SESSION['user_id']) || !isset($_SESSION['current_quiz_id']) || !isset($_SESSION['quiz_questions'])) {
    header("Location: quizz.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$quiz_id = $_SESSION['current_quiz_id'];
$quiz_questions = $_SESSION['quiz_questions'];

// Mapping to convert numeric inputs to letter options
$answer_mapping = array(
    '1' => 'A',
    '2' => 'B',
    '3' => 'C',
    '4' => 'D'
);

// Initialize variables
$correct_answers = 0;
$total_questions = count($quiz_questions);

// Process quiz answers
foreach ($quiz_questions as $question_id) {
    // Fetch question details from the database
    $query = "SELECT question_text, options, correct_answer FROM questions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $question_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $question_text = $row['question_text'];
        $correct_db_answer = $row['correct_answer'];
        $options = json_decode($row['options'], true);

        // Get user's submitted answer
        $user_answer = isset($_POST['question_' . $question_id]) ?
            $_POST['question_' . $question_id] : null;

        // Normalize user answer to match database format
        $normalized_answer = isset($answer_mapping[$user_answer]) ?
            $answer_mapping[$user_answer] : $user_answer;

        // Compare normalized answer with database answer
        if ($normalized_answer === $correct_db_answer) {
            $correct_answers++;
        }
    }
    $stmt->close();
}

// Calculate score
$score_percentage = $correct_answers;

// Insert quiz attempt into the database
$insert_sql = "INSERT INTO quiz_attempts (user_id, quiz_id, score) 
               VALUES (?, ?, ?)";
$insert_stmt = $conn->prepare($insert_sql);
$insert_stmt->bind_param("iii", $user_id, $quiz_id, $score_percentage);
$insert_stmt->execute();
$insert_stmt->close();

// Cleanup session variables
unset($_SESSION['current_quiz_id']);
unset($_SESSION['quiz_questions']);
unset($_SESSION['quiz_start_time']);

// Display the quiz results
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result - QuizCraft</title>
    <link rel="stylesheet" href="public/css/output.css">
    <link rel="shortcut icon" href="public/images/logo.jpeg" type="image/x-icon" />
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg text-center">
        <h1 class="text-4xl font-bold mb-6 text-green-600">Quiz Completed!</h1>

        <div class="mb-6">
            <p class="text-2xl">Total Questions: <span class="font-bold"><?php echo $total_questions; ?></span></p>
            <p class="text-2xl">Correct Answers: <span
                    class="font-bold text-green-600"><?php echo $correct_answers; ?></span></p>
            <p class="text-2xl">Score: <span class="font-bold text-blue-600"><?php echo $score_percentage; ?>2</span>
            </p>
        </div>

        <div class="mt-6">
            <h2 class="text-2xl font-bold mb-4">Detailed Results</h2>
            <?php
            foreach ($quiz_questions as $question_id) {
                $query = "SELECT question_text, options, correct_answer FROM questions WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $question_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    $question_text = $row['question_text'];
                    $correct_db_answer = $row['correct_answer'];
                    $options = json_decode($row['options'], true);

                    $user_answer = isset($_POST['question_' . $question_id]) ?
                        $_POST['question_' . $question_id] : 'Not Answered';
                    $normalized_user_answer = isset($answer_mapping[$user_answer]) ?
                        $answer_mapping[$user_answer] : $user_answer;

                    $is_correct = $normalized_user_answer === $correct_db_answer;

                    echo "<div class='mb-4 p-4 " . ($is_correct ? 'bg-green-100' : 'bg-red-100') . " rounded'>";
                    echo "<p class='font-bold'>" . htmlspecialchars($question_text) . "</p>";
                    echo "<p>Your Answer: " . htmlspecialchars($normalized_user_answer) . "</p>";
                    echo "<p>Correct Answer: " . htmlspecialchars($correct_db_answer) . "</p>";
                    echo "</div>";
                }
                $stmt->close();
            }
            ?>
        </div>

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