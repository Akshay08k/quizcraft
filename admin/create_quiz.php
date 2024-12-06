<?php
session_start();
require_once('../db.php');

if ($_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}
$categoriesResult = mysqli_query($conn, "SELECT * FROM categories");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $query = "INSERT INTO quizzes (name, category_id) VALUES ('$title', $category_id)";
    mysqli_query($conn, $query);
    $quiz_id = mysqli_insert_id($conn);

    foreach ($_POST['questions'] as $question) {
        $question_text = mysqli_real_escape_string($conn, $question['text']);
        $query = "INSERT INTO quiz_questions (quiz_id, question_text) VALUES ($quiz_id, '$question_text')";
        mysqli_query($conn, $query);
        $question_id = mysqli_insert_id($conn);
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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                    <?php while ($category = $categoriesResult->fetch_assoc()): ?>
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