<?php
session_start();
// Authentication check
if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
require_once('../db.php');

$quiz_id = intval($_GET['id']);

// Fetch quiz details
$quiz_query = "
    SELECT 
        q.id, 
        q.name, 
        q.category_id
    FROM 
        quizzes q
    WHERE 
        q.id = $quiz_id
";
$quiz_result = mysqli_query($conn, $quiz_query);
$quiz = mysqli_fetch_assoc($quiz_result);

// Fetch existing questions
$questions_query = "
    SELECT 
        id, 
        question_text, 
        options,
        correct_answer
    FROM 
        questions
    WHERE 
        quiz_id = $quiz_id
";
$questions_result = mysqli_query($conn, $questions_query);
$questions = mysqli_fetch_all($questions_result, MYSQLI_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    mysqli_begin_transaction($conn);

    try {
        // Update quiz basic details
        $quiz_title = mysqli_real_escape_string($conn, $_POST['title']);
        $update_quiz_query = "
            UPDATE quizzes 
            SET name = '$quiz_title' 
            WHERE id = $quiz_id
        ";
        mysqli_query($conn, $update_quiz_query);

        // Process questions
        if (isset($_POST['questions'])) {
            foreach ($_POST['questions'] as $question_data) {
                // Determine if existing or new question
                $question_id = isset($question_data['id']) ? intval($question_data['id']) : 0;
                $question_text = mysqli_real_escape_string($conn, $question_data['text']);
                $correct_answer = mysqli_real_escape_string($conn, $question_data['correct_answer']);

                // Prepare options
                $options = json_encode($question_data['options']); // Convert array to JSON
                $options = mysqli_real_escape_string($conn, $options); // Escape the JSON string

                if ($question_id > 0) {
                    // Update existing question
                    $update_query = "
                        UPDATE questions 
                        SET 
                            question_text = '$question_text', 
                            options = '$options', 
                            correct_answer = '$correct_answer'
                        WHERE id = $question_id
                    ";
                    mysqli_query($conn, $update_query);
                } else {
                    // Insert new question
                    $insert_query = "
                        INSERT INTO questions 
                        (quiz_id, question_text, options, correct_answer) 
                        VALUES 
                        ($quiz_id, '$question_text', '$options', '$correct_answer')
                    ";
                    mysqli_query($conn, $insert_query);
                }
            }
        }

        mysqli_commit($conn);
        header("Location: quizzes.php?success=updated");
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $error_message = "Failed to update quiz: " . $e->getMessage();
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Edit Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-8">
        <form method="POST" id="edit-quiz-form">
            <div class="bg-white shadow-md rounded-lg p-8">
                <?php if (isset($error_message)): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <?php echo htmlspecialchars($error_message); ?>
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Quiz Title</label>
                    <input type="text" name="title" value="<?php echo htmlspecialchars($quiz['name']); ?>"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                </div>

                <div id="questions-container">
                    <?php foreach ($questions as $index => $question): ?>
                        <div class="question-block bg-gray-100 p-4 rounded-lg mb-4">
                            <input type="hidden" name="questions[<?php echo $index; ?>][id]"
                                value="<?php echo $question['id']; ?>">

                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                                <input type="text" name="questions[<?php echo $index; ?>][text]"
                                    value="<?php echo htmlspecialchars($question['question_text']); ?>"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                            </div>

                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Options</label>
                                <?php
                                // Decode JSON options from the database to array
                                $options = json_decode($question['options'], true); // Decode options into an array
                                $current_options = ['A', 'B', 'C', 'D']; // Option labels
                                ?>
                                <div class="grid grid-cols-2 gap-2">
                                    <?php foreach ($current_options as $opt_index => $opt): ?>
                                        <!-- Render each option in an input field -->
                                        <input type="text" name="questions[<?php echo $index; ?>][options][]"
                                            value="<?php echo htmlspecialchars($options[$opt_index] ?? ''); ?>" 
                                        placeholder="Option <?php echo $opt; ?>"
                                        class="shadow appearance-none border rounded py-2 px-3 text-gray-700" required>
                                    <?php endforeach; ?>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Correct Answer</label>
                                <select name="questions[<?php echo $index; ?>][correct_answer]"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                                    <?php foreach ($current_options as $opt): ?>
                                        <option value="<?php echo $opt; ?>" <?php echo $question['correct_answer'] == $opt ? 'selected' : ''; ?>> <!-- Set selected if correct answer matches option -->
                                            Option <?php echo $opt; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mt-6 flex justify-between">
                    <button type="button" id="add-question"
                        class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Add Question
                    </button>
                    <div>
                        <a href="quizzes.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mr-2">
                            Cancel
                        </a>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let questionIndex = <?php echo count($questions); ?>;

        document.getElementById('add-question').addEventListener('click', function () {
            const container = document.getElementById('questions-container');
            const newQuestionBlock = document.createElement('div');
            newQuestionBlock.className = 'question-block bg-gray-100 p-4 rounded-lg mb-4';

            newQuestionBlock.innerHTML = `
            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Question Text</label>
                <input type="text" 
                       name="questions[${questionIndex}][text]" 
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" 
                       required>
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Options</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="questions[${questionIndex}][options][]" placeholder="Option A" class="shadow appearance-none border rounded py-2 px-3 text-gray-700" required>
                    <input type="text" name="questions[${questionIndex}][options][]" placeholder="Option B" class="shadow appearance-none border rounded py-2 px-3 text-gray-700" required>
                    <input type="text" name="questions[${questionIndex}][options][]" placeholder="Option C" class="shadow appearance-none border rounded py-2 px-3 text-gray-700" required>
                    <input type="text" name="questions[${questionIndex}][options][]" placeholder="Option D" class="shadow appearance-none border rounded py-2 px-3 text-gray-700" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="block text-gray-700 text-sm font-bold mb-2">Correct Answer</label>
                <select name="questions[${questionIndex}][correct_answer]" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700" required>
                    <option value="A">Option A</option>
                    <option value="B">Option B</option>
                    <option value="C">Option C</option>
                    <option value="D">Option D</option>
                </select>
            </div>
        `;

            container.appendChild(newQuestionBlock);
            questionIndex++;
        });
    </script>
</body>

</html>