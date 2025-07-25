<?php
session_start();
require_once('../db.php');

if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
$categoriesResult = $conn->query("SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $title = $_POST['title'];
    $query = "INSERT INTO quizzes (name, category_id) VALUES (:title, :category_id)";
    $stmt = $conn->prepare($query);
    $stmt->execute([':title' => $title, ':category_id' => $category_id]);
    $quiz_id = $conn->lastInsertId();
    foreach ($_POST['questions'] as $question) {
        $question_text = $question['text'];
        $query = "INSERT INTO quiz_questions (quiz_id, question_text) VALUES (:quiz_id, :question_text)";
        $stmt = $conn->prepare($query);
        $stmt->execute([':quiz_id' => $quiz_id, ':question_text' => $question_text]);
        $question_id = $conn->lastInsertId();
    }
    header('Location: quizzes.php?success=1');
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
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo $category['name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>





            <button type="submit" class="w-full bg-green-600 text-white p-2 rounded">
                Create Quiz
            </button>
        </form>
    </div>
</body>

</html>