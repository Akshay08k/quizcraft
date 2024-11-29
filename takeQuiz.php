<?php
session_start();
include 'db.php';

// Check if user is logged in (uncomment when authentication is implemented)
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz details
$quiz_sql = "SELECT * FROM quizzes WHERE id = ?";
$quiz_stmt = $conn->prepare($quiz_sql);
$quiz_stmt->bind_param("i", $quiz_id);
$quiz_stmt->execute();
$quiz_result = $quiz_stmt->get_result();

if ($quiz_result->num_rows == 0) {
    die("Quiz not found");
}

$quiz = $quiz_result->fetch_assoc();

// Fetch questions for this quiz
$questions_sql = "SELECT * FROM questions WHERE quiz_id = ?";
$questions_stmt = $conn->prepare($questions_sql);
$questions_stmt->bind_param("i", $quiz_id);
$questions_stmt->execute();
$questions_result = $questions_stmt->get_result();

// Store quiz questions in session for validation later
$_SESSION['current_quiz_id'] = $quiz_id;
$_SESSION['quiz_questions'] = [];
$_SESSION['quiz_start_time'] = time();

// Prepare questions and options
$quiz_questions = [];
while ($question = $questions_result->fetch_assoc()) {
    // Parse options from the options column
    $options = json_decode($question['options'], true);
    $question['parsed_options'] = $options;
    $quiz_questions[] = $question;
    $_SESSION['quiz_questions'][] = $question['id'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($quiz['name']); ?> - QuizCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Prevent text selection and right-click */
        body {
            user-select: none;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div id="startQuizContainer" class="text-center">
            <button id="startQuizBtn" class="bg-blue-500 text-white px-6 py-3 rounded">Start Quiz</button>
        </div>

        <div id="quiz-container" class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold"><?php echo htmlspecialchars($quiz['name']); ?></h1>
                <div id="timer" class="text-2xl font-bold text-red-500"></div>
            </div>

            <form action="submit_quiz.php" method="POST" id="quizForm">
                <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">
                <?php
                $total_questions = count($quiz_questions);
                foreach ($quiz_questions as $index => $question) {
                    ?>
                    <div class="quiz-question" id="question_<?php echo $question['id']; ?>"
                        style="display: <?php echo $index === 0 ? 'block' : 'none'; ?>;">
                        <p class="font-semibold mb-4"><?php echo htmlspecialchars($question['question_text']); ?></p>

                        <?php foreach ($question['parsed_options'] as $option_key => $option_text) { ?>
                            <div class="flex items-center mb-2">
                                <input type="radio" name="question_<?php echo $question['id']; ?>"
                                    id="option_<?php echo $question['id'] . '_' . $option_key; ?>"
                                    value="<?php echo $option_key; ?>" class="mr-2">
                                <label for="option_<?php echo $question['id'] . '_' . $option_key; ?>" class="ml-2">
                                    <?php echo htmlspecialchars($option_text); ?>
                                </label>
                            </div>
                        <?php } ?>

                        <div class="flex justify-between mt-6">
                            <?php if ($index > 0): ?>
                                <button type="button" onclick="changeQuestion(-1)"
                                    class="bg-gray-500 text-white px-4 py-2 rounded">Previous</button>
                            <?php endif; ?>

                            <?php if ($index < $total_questions - 1): ?>
                                <button type="button" onclick="changeQuestion(1)"
                                    class="bg-blue-500 text-white px-4 py-2 rounded">Next</button>
                            <?php endif; ?>

                            <?php if ($index == $total_questions - 1): ?>
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Finish Quiz</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>

    <!-- Fullscreen Warning Modal -->
    <div id="fullscreenWarningModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg text-center">
            <h2 class="text-2xl font-bold mb-4">Warning!</h2>
            <p class="mb-4">You have left the quiz screen. Return to fullscreen or the quiz will be terminated.</p>
            <div id="warningCountdown" class="text-4xl font-bold text-red-500">10</div>
        </div>
    </div>

    <script>
        const totalQuestions = <?php echo $total_questions; ?>;
        const totalTime = totalQuestions * 60; // seconds
        let remainingTime = totalTime;
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.quiz-question');
        let countdownInterval = null;
        let warningInterval = null;
        let warningCountdownValue = 10;

        document.getElementById('startQuizBtn').addEventListener('click', function () {
            requestFullscreen();
            this.style.display = 'none'; 
            document.getElementById('quiz-container').style.display = 'block'; // Show quiz container
            startTimer();
        });

        function requestFullscreen() {
            const container = document.getElementById('quiz-container');
            if (container.requestFullscreen) container.requestFullscreen();
            else if (container.webkitRequestFullscreen) container.webkitRequestFullscreen();
            else if (container.mozRequestFullScreen) container.mozRequestFullScreen();
            else if (container.msRequestFullscreen) container.msRequestFullscreen();
        }

        function startTimer() {
            updateTimer();
            countdownInterval = setInterval(() => {
                remainingTime--;
                if (remainingTime <= 0) {
                    clearInterval(countdownInterval);
                    document.getElementById('quizForm').submit();
                }
                updateTimer();
            }, 1000);
        }

        function updateTimer() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            document.getElementById('timer').textContent =
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }

        function changeQuestion(direction) {
            questions[currentQuestionIndex].style.display = 'none';
            currentQuestionIndex += direction;
            questions[currentQuestionIndex].style.display = 'block';
        }

        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', (e) => {
            if (
                (e.key === 'F12' && (e.ctrlKey || e.shiftKey))) {
                e.preventDefault();
            }
        });

        window.onload = () => {
            document.getElementById('quiz-container').style.display = 'none';
        };
    </script>


</body>

</html>