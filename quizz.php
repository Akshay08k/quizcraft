<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Quizzes - QuizCraft</title>
    <link rel="stylesheet" href="public/css/output.css">
    <link rel="stylesheet" href="public/css/quizz.css">
    <link rel="shortcut icon" href="public/images/logo.jpeg" type="image/x-icon" />
</head>

<body class="bg-gray-100 text-gray-800 font-sans flex flex-col min-h-screen">

    <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-10 fade-in">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-blue-600">QuizCraft</div>
                <ul class="flex space-x-4">
                    <li><a href="home.php" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="quizz.php" class="text-gray-700 hover:text-blue-600">Quizzes</a></li>
                    <li><a href="leaderboard.php" class="text-gray-700 hover:text-blue-600">Leaderboard</a></li>
                    <li><a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-32 pb-10 text-center fade-in">
        <section class="max-w-4xl mx-auto px-4 mb-10">
            <h1 class="text-5xl font-bold text-gray-800 mb-4">Explore Our Quiz Universe</h1>
            <p class="text-xl text-gray-600">Discover exciting quizzes across multiple categories and challenge your
                knowledge!</p>
        </section>

        <section class="max-w-3xl mx-auto px-4 mb-10">
            <form method="GET" action="quizz.php" class="flex">
                <input type="text" name="search" placeholder="Search quizzes by name or category..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded-r-lg hover:bg-blue-600 transition">
                    Search
                </button>
            </form>
        </section>

        <section class="max-w-6xl mx-auto px-4">
            <?php
            $search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

            $category_colors = [
                '#3B82F6',
                '#10B981',
                '#F43F5E',
                '#8B5CF6',
                '#F59E0B',
                '#6366F1',
                '#14B8A6',
                '#EF4444',
                '#22C55E',
                '#7C3AED'
            ];

            $category_sql = "SELECT c.id, c.name, COUNT(q.id) as quiz_count 
                             FROM categories c
                             LEFT JOIN quizzes q ON c.id = q.category_id
                             GROUP BY c.id, c.name
                             HAVING quiz_count > 0";

            $category_result = $conn->query($category_sql);

            if ($category_result->num_rows > 0) {
                $color_index = 0;
                while ($category = $category_result->fetch_assoc()) {
                    $category_color = $category_colors[$color_index % count($category_colors)];

                    $quiz_sql = "SELECT id, name FROM quizzes 
                                 WHERE category_id = {$category['id']}";

                    if (!empty($search_query)) {
                        $quiz_sql .= " AND name LIKE '%{$search_query}%'";
                    }

                    $quiz_result = $conn->query($quiz_sql);

                    if ($quiz_result->num_rows > 0) {
                        echo "<div class='mb-12'>";
                        echo "<div class='flex items-center mb-6'>";
                        echo "<div class='w-4 h-4 mr-3' style='background-color: {$category_color}'></div>";
                        echo "<h2 class='text-3xl font-bold text-gray-800'>{$category['name']} ({$category['quiz_count']} Quizzes)</h2>";
                        echo "</div>";

                        echo "<div class='quiz-grid'>";
                        while ($quiz = $quiz_result->fetch_assoc()) {
                            echo "<div class='category-card' style='--category-color: {$category_color}'>";
                            echo "<div class='quiz-card p-5'>";
                            echo "<h3 class='text-xl font-semibold mb-3'>" . htmlspecialchars($quiz['name']) . "</h3>";

                            echo "<a href='take_quiz_instructions.php?quiz_id={$quiz["id"]}' class='text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg'>Take Quiz</a>";
                            echo "</div></div>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }

                    $color_index++;
                }
            } else {
                echo "<p class='text-center text-gray-600'>No quizzes available.</p>";
            }
            ?>
        </section>
    </main>

    <footer class="bg-primary text-white py-6 mt-10">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>