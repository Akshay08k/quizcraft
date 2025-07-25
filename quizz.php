<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Quizzes - QuizCraft</title>
    <link rel="stylesheet" href="public/css/output.css">
    <style>
        .quiz-masonry {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .quiz-item {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .quiz-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .quiz-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .quiz-item-content {
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>

<body class="bg-gray-50">
    <nav class="bg-white shadow-md fixed top-0 left-0 w-full z-10">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold text-blue-600">QuizCraft</div>
                <ul class="flex space-x-6">
                    <li><a href="home.php" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="quizz.php" class="text-gray-700 hover:text-blue-600">Quizzes</a></li>
                    <li><a href="leaderboard.php" class="text-gray-700 hover:text-blue-600">Leaderboard</a></li>
                    <li><a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a></li>
                    <li><a href="logout.php" class="text-gray-700 hover:text-blue-600">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="pt-24 max-w-7xl mx-auto px-4">
        <section class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Explore Our Quiz Universe</h1>
            <p class="text-xl text-gray-600">Discover exciting quizzes across multiple categories</p>
        </section>

        <section class="mb-12">
            <form method="GET" action="quizz.php" class="max-w-2xl mx-auto">
                <div class="relative">
                    <input type="text" name="search" placeholder="Search quizzes..."
                        class="w-full px-4 py-3 pl-10 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                        value="">

                </div>
            </form>
        </section>

        <section>
            <?php
            if (isset($_GET['search'])) {

                $search_query = isset($_GET['search']) ? $_GET['search'] : '';
            }
            $total_quizzes_found = 0;

            $category_colors = [
                '#3B82F6',
                '#10B981',
                '#F43F5E',
                '#8B5CF6',
                '#F59E0B',
                '#6366F1',
                '#14B8A6',
                '#EF4444'
            ];

          $category_sql = "SELECT c.id, c.name, COUNT(q.id) as quiz_count 
                 FROM categories c
                 LEFT JOIN quizzes q ON c.id = q.category_id
                 WHERE 1=1";

if (!empty($search_query)) {
    $category_sql .= " AND q.name LIKE :search_query";
}

$category_sql .= " GROUP BY c.id, c.name
                 HAVING COUNT(q.id) > 0";


            $category_stmt = $conn->prepare($category_sql);
            if (!empty($search_query)) {
                $category_stmt->bindValue(':search_query', "%{$search_query}%", PDO::PARAM_STR);
            }
            $category_stmt->execute();
            $category_result = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($category_result)) {
                $color_index = 0;
                foreach ($category_result as $category) {
                    $category_color = $category_colors[$color_index % count($category_colors)];

                    $quiz_sql = "SELECT id, name FROM quizzes 
                                 WHERE category_id = :category_id";

                    if (!empty($search_query)) {
                        $quiz_sql .= " AND name LIKE :search_query";
                    }

                    $quiz_stmt = $conn->prepare($quiz_sql);
                    $quiz_stmt->bindValue(':category_id', $category['id'], PDO::PARAM_INT);
                    if (!empty($search_query)) {
                        $quiz_stmt->bindValue(':search_query', "%{$search_query}%", PDO::PARAM_STR);
                    }
                    $quiz_stmt->execute();
                    $quiz_result = $quiz_stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (!empty($quiz_result)) {
                        $total_quizzes_found += count($quiz_result);

                        echo "<div class='mb-12'>";
                        echo "<h2 class='text-2xl font-bold text-gray-800 mb-6 flex items-center'>";
                        echo "<span class='w-4 h-4 mr-3 rounded-full' style='background-color: {$category_color}'></span>";
                       echo "{$category['name']} <span class='text-sm text-gray-500 ml-2'>(" . count($quiz_result) . " Quizzes)</span>";

                        echo "</h2>";

                        echo "<div class='quiz-masonry'>";
                        foreach ($quiz_result as $quiz) {
                            echo "<div class='quiz-item'>";
                            echo "<div class='quiz-item-header'>";
                            echo "<h3 class='text-lg font-semibold text-gray-800'>" . htmlspecialchars($quiz['name']) . "</h3>";
                            echo "<span class='text-sm text-gray-500 px-2 py-1 rounded-full' style='background-color: " . $category_color . "20;'>{$category['name']}</span>";
                            echo "</div>";
                            echo "<div class='quiz-item-content'>";
                            echo "<span class='text-sm text-gray-500'></span>";
                            echo "<a href='takeQuiz.php?quiz_id={$quiz["id"]}' class='px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition'>Start Quiz</a>";
                            echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                        echo "</div>";
                    }

                    $color_index++;
                }
            }

            // No quizzes found scenario
            if ($total_quizzes_found === 0 && !empty($search_query)) {
                echo "<div class='text-center py-16 bg-white rounded-xl shadow-md'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' class='h-24 w-24 mx-auto text-gray-300 mb-4' fill='none' viewBox='0 0 24 24' stroke='currentColor'>";
                echo "<path strokeLinecap='round' strokeLinejoin='round' strokeWidth={2} d='M9.172 16.172a4 4 0 005.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z' />";
                echo "</svg>";
                echo "<h2 class='text-2xl font-bold text-gray-600 mb-2'>No Quizzes Found</h2>";
                echo "<p class='text-gray-500'>Your search for \"" . htmlspecialchars($search_query) . "\" did not match any quizzes.</p>";
                echo "<p class='text-gray-500 mt-2'>Try a different search term or browse all quizzes.</p>";
                echo "</div>";
            }
            ?>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-6 mt-12 fixed bottom-0 left-0 w-full">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>
</body>

</html>