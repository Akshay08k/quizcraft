<?php
session_start();
// Authentication check
if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once('../db.php');

$quiz_id = intval($_GET['id'] ?? 0);

// Fetch quiz details
$quiz_stmt = $conn->prepare("SELECT id, name, category_id FROM quizzes WHERE id = :id");
$quiz_stmt->execute([':id' => $quiz_id]);
$quiz = $quiz_stmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    die("Quiz not found.");
}

// Fetch existing questions
$questions_stmt = $conn->prepare("SELECT id, question_text, options, correct_answer FROM questions WHERE quiz_id = :id");
$questions_stmt->execute([':id' => $quiz_id]);
$questions = $questions_stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn->beginTransaction();

    try {
        // Update quiz title
        $quiz_title = $_POST['title'] ?? '';
        $update_stmt = $conn->prepare("UPDATE quizzes SET name = :title WHERE id = :id");
        $update_stmt->execute([
            ':title' => $quiz_title,
            ':id' => $quiz_id
        ]);

        // Process each question
        if (!empty($_POST['questions'])) {
            foreach ($_POST['questions'] as $question_data) {
                $question_id = intval($question_data['id'] ?? 0);
                $question_text = $question_data['text'] ?? '';
                $correct_answer = $question_data['correct_answer'] ?? '';
                $options = json_encode($question_data['options'] ?? []);

                if ($question_id > 0) {
                    // Update existing
                    $update_q_stmt = $conn->prepare("
                        UPDATE questions 
                        SET question_text = :text, options = :options, correct_answer = :correct 
                        WHERE id = :qid
                    ");
                    $update_q_stmt->execute([
                        ':text' => $question_text,
                        ':options' => $options,
                        ':correct' => $correct_answer,
                        ':qid' => $question_id
                    ]);
                } else {
                    // Insert new
                    $insert_stmt = $conn->prepare("
                        INSERT INTO questions (quiz_id, question_text, options, correct_answer) 
                        VALUES (:quiz_id, :text, :options, :correct)
                    ");
                    $insert_stmt->execute([
                        ':quiz_id' => $quiz_id,
                        ':text' => $question_text,
                        ':options' => $options,
                        ':correct' => $correct_answer
                    ]);
                }
            }
        }

        $conn->commit();
        header("Location: quizzes.php?success=updated");
        exit();
    } catch (Exception $e) {
        $conn->rollBack();
        $error_message = "Failed to update quiz: " . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Edit Quiz</title>

    <link rel="shortcut icon" href="../public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/output.css">
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
                                $options = json_decode($question['options'], true);
                                $current_options = ['A', 'B', 'C', 'D'];
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