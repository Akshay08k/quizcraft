<?php
session_start();
require_once('../db.php');

if (empty($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Fetch categories
$categoriesResult = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];

    // Insert quiz
    $query = "INSERT INTO quizzes (name, category_id) VALUES (:title, :category_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute([':title' => $title, ':category_id' => $category_id]);
    $quiz_id = $conn->lastInsertId();

    // Insert questions
    if (isset($_POST['questions'])) {
        foreach ($_POST['questions'] as $question) {
            $question_text = $question['text'];
            $options = json_encode($question['options']);
            $correct_answer = $question['correct_answer'];

            $q = "INSERT INTO questions (quiz_id, question_text, options, correct_answer) 
                  VALUES (:quiz_id, :question_text, :options, :correct_answer)";
            $s = $conn->prepare($q);
            $s->execute([
                ':quiz_id' => $quiz_id,
                ':question_text' => $question_text,
                ':options' => $options,
                ':correct_answer' => $correct_answer
            ]);
        }
    }

    header('Location: quizzes.php?success=created');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>QuizCraft - Create Quiz</title>
    <link rel="shortcut icon" href="../public/images/logo.jpeg" type="image/x-icon" />
    <link rel="stylesheet" href="../public/css/output.css">
</head>
<body class="bg-gray-100">
<?php include('./sidebar.php'); ?>

<div class="ml-64 p-8">
    <h1 class="text-3xl font-bold mb-6">Create New Quiz</h1>

    <form method="POST" class="bg-white p-8 rounded-lg shadow-md">
        <div class="mb-4">
            <label class="block mb-2">Quiz Title</label>
            <input type="text" name="title" required class="w-full p-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-2">Category</label>
            <select name="category_id" required class="w-full p-2 border rounded">
                <?php while ($category = $categoriesResult->fetch(PDO::FETCH_ASSOC)): ?>
                    <option value="<?php echo htmlspecialchars($category['id']); ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <h2 class="text-xl font-semibold mb-2">Questions</h2>
        <div id="questions-container"></div>

        <button type="button" onclick="addQuestion()"
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4">
            + Add Question
        </button>

        <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">
            Create Quiz
        </button>
    </form>
</div>

<script>
let questionIndex = 0;

function addQuestion() {
    const container = document.getElementById('questions-container');
    const block = document.createElement('div');
    block.className = 'mb-4 p-4 bg-gray-100 rounded';

    block.innerHTML = `
        <div class="mb-2">
            <label class="block mb-1">Question Text</label>
            <input type="text" name="questions[\${questionIndex}][text]" required
                   class="w-full p-2 border rounded">
        </div>
        <div class="mb-2">
            <label class="block mb-1">Options</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="questions[\${questionIndex}][options][]" placeholder="Option A" required class="p-2 border rounded">
                <input type="text" name="questions[\${questionIndex}][options][]" placeholder="Option B" required class="p-2 border rounded">
                <input type="text" name="questions[\${questionIndex}][options][]" placeholder="Option C" required class="p-2 border rounded">
                <input type="text" name="questions[\${questionIndex}][options][]" placeholder="Option D" required class="p-2 border rounded">
            </div>
        </div>
        <div>
            <label class="block mb-1">Correct Answer</label>
            <select name="questions[\${questionIndex}][correct_answer]" required class="w-full p-2 border rounded">
                <option value="A">Option A</option>
                <option value="B">Option B</option>
                <option value="C">Option C</option>
                <option value="D">Option D</option>
            </select>
        </div>
    `;
    container.appendChild(block);
    questionIndex++;
}
</script>
</body>
</html>
