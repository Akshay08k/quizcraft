<?php
session_start();
include 'db.php';

$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

$quiz_sql = "SELECT * FROM quizzes WHERE id = ?";
$quiz_stmt = $conn->prepare($quiz_sql);
$quiz_stmt->bind_param("i", $quiz_id);
$quiz_stmt->execute();
$quiz_result = $quiz_stmt->get_result();

if ($quiz_result->num_rows == 0) {
    die("Quiz not found");
}

$quiz = $quiz_result->fetch_assoc();

// Fetching Questions From Quiz
$questions_sql = "SELECT * FROM questions WHERE quiz_id = ?";
$questions_stmt = $conn->prepare($questions_sql);
$questions_stmt->bind_param("i", $quiz_id);
$questions_stmt->execute();
$questions_result = $questions_stmt->get_result();

//Holding values in session as array and variable at end of quiz 
//redirect user to submit_quiz.php then get all details from session
//and store into database
//running query for each question again and again is not a good idea
//so first complete the quiz and than in single query store all details
$_SESSION['current_quiz_id'] = $quiz_id;
$_SESSION['quiz_questions'] = [];
$_SESSION['quiz_start_time'] = time();

$quiz_questions = [];
while ($question = $questions_result->fetch_assoc()) {
    //The options are stored in a JSON format
    //so need to convert it to array
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
    <link rel="stylesheet" href="public/css/output.css">
    <link rel="shortcut icon" href="public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="public/css/takeQuiz.css">
</head>

<body class="bg-gray-100">
    <div id="initialFullscreenModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center">
        <div class="space-y-4 mb-6">
            <div class="bg-white p-10 rounded-lg shadow-lg max-w-2xl w-full">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h2 class="font-semibold text-xl mb-2">Important Rules:
                        <?php echo $quiz['name']; ?>
                    </h2>
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
                <div class="text-center pt-10">
                    <button type="submit" id="startFullscreenBtn"
                        class="bg-green-500 text-white px-8 py-3 rounded-lg hover:bg-green-600 transition duration-300">
                        Proceed to Quiz
                    </button>
                </div>
            </div>
        </div>

    </div>
    <div id="fullscreenWarningModal"
        class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-8 rounded-lg text-center max-w-md">
            <h2 class="text-3xl font-bold text-red-600 mb-4">Quiz Warning!</h2>
            <p class="text-lg mb-6">You have left the fullscreen mode. This will terminate your quiz if not resumed.
            </p>
            <div class="flex justify-center space-x-4">
                <button id="resumeQuizBtn" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Resume Quiz
                </button>
                <button id="terminateQuizBtn" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-600">
                    End Quiz
                </button>
            </div>
            <div class="mt-4">
                <p>Time Remaining to Resume: <span id="warningCountdown" class="font-bold text-red-500">10</span>
                    seconds</p>
            </div>
        </div>
    </div>


    <div class="container mx-auto px-4 py-8">
        <div id="startQuizContainer" class="text-center" style="display: none;">
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

    <script>
        let isFullscreen = false;
        let warningTimeout = null;
        let warningCountdown = 20;
        // DOM Elements
        const initialFullscreenModal = document.getElementById('initialFullscreenModal');
        const startFullscreenBtn = document.getElementById('startFullscreenBtn');
        const fullscreenWarningModal = document.getElementById('fullscreenWarningModal');
        const warningCountdownElement = document.getElementById('warningCountdown');
        const resumeQuizBtn = document.getElementById('resumeQuizBtn');
        const terminateQuizBtn = document.getElementById('terminateQuizBtn');
        const startQuizContainer = document.getElementById('startQuizContainer');
        const quizContainer = document.getElementById('quiz-container');
        const startQuizBtn = document.getElementById('startQuizBtn');

        // Going Into Full Screen
        startFullscreenBtn.addEventListener('click', () => {
            initialFullscreenModal.style.display = 'none';
            enterFullscreen();
            startQuizContainer.style.display = 'block';
        });

        //Final Enter
        function enterFullscreen() {
            const element = document.documentElement;
            if (element.requestFullscreen) {
                element.requestFullscreen();
            } else if (element.mozRequestFullScreen) {
                element.mozRequestFullScreen();
            } else if (element.webkitRequestFullscreen) {
                element.webkitRequestFullscreen();
            } else if (element.msRequestFullscreen) {
                element.msRequestFullscreen();
            }
            isFullscreen = true;
        }



        function exitFullscreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
            isFullscreen = false;
        }

        function startWarningCountdown() {
            warningCountdown = 20;
            warningCountdownElement.textContent = warningCountdown;
            fullscreenWarningModal.style.display = 'flex';

            warningTimeout = setInterval(() => {
                warningCountdown--;
                warningCountdownElement.textContent = warningCountdown;

                if (warningCountdown <= 0) {
                    clearInterval(warningTimeout);
                    // Terminate quiz with terminate true 
                    // and this happened it goes to submit quiz with terminate which insert data from as it is
                    window.location.href = 'profile.php';
                }
            }, 1000);
        }

        // Fullscreen change event listeners
        document.addEventListener('fullscreenchange', handleFullscreenChange);
        document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
        document.addEventListener('mozfullscreenchange', handleFullscreenChange);
        document.addEventListener('MSFullscreenChange', handleFullscreenChange);

        function handleFullscreenChange() {
            if (!document.fullscreenElement && isFullscreen) {
                startWarningCountdown();
            }
        }

        // Resume Quiz Button click system cant detect the automatic fullscreen
        //so we to add the button click so system can detect we are in full screen and
        //resume the quiz again
        resumeQuizBtn.addEventListener('click', () => {
            clearInterval(warningTimeout);
            fullscreenWarningModal.style.display = 'none';
            enterFullscreen();
        });

        // Terminate Quiz Button
        terminateQuizBtn.addEventListener('click', () => {
            clearInterval(warningTimeout);
            window.location.href = 'submit_quiz.php?terminated=true';
        });

        // Quiz Start Logic
        startQuizBtn.addEventListener('click', function () {
            this.style.display = 'none';
            quizContainer.style.display = 'block';
            startTimer();
        });

        const totalQuestions = <?php echo $total_questions; ?>;
        const totalTime = totalQuestions * 60; // seconds
        let remainingTime = totalTime;
        let currentQuestionIndex = 0;
        const questions = document.querySelectorAll('.quiz-question');
        let countdownInterval = null;

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

        // Disable right-click and dev tools
        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('keydown', (e) => {
            if ((e.key === 'F12' && (e.ctrlKey || e.shiftKey))) {
                e.preventDefault();
            }
        });

        // Initial setup
        window.onload = () => {
            quizContainer.style.display = 'none';
            startQuizContainer.style.display = 'none';
        };
    </script>
</body>

</html>