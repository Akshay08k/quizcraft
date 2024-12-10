<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - QuizCraft</title>
    <link rel="stylesheet" href="public/css/output.css">
    <link rel="shortcut icon" href="public/images/logo.jpeg" type="image/x-icon" />
</head>

<body class="bg-gray-100 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-10 fade-in">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-blue-600">QuizCraft</div>
                <ul class="flex space-x-4">
                    <li><a href="home.php" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="quizz.php" class="text-gray-700 hover:text-blue-600">Quizzes</a></li>
                    <li><a href="leaderboard.php" class="text-gray-700 hover:text-blue-600">Leaderboard</a></li>
                    <li><a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a></li>
                    <li><a href="logout.php" class="text-gray-700 hover:text-blue-600">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Leaderboard Section -->
    <main class="flex-grow pt-32 pb-10">
        <section class="text-center">
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Leaderboard</h1>
                <p class="text-lg text-gray-600">See the top scorers from all quizzes and challenge yourself to rank
                    higher!</p>
            </div>
        </section>

        <!-- Leaderboard Table -->
        <section class="py-8">
            <div class="max-w-5xl mx-auto px-4">
                <table class="w-full text-center rounded-lg overflow-hidden shadow-lg">
                    <thead>
                        <tr class="bg-blue-500 text-white">
                            <th class="p-4">Rank</th>
                            <th class="p-4">Username</th>
                            <th class="p-4">Total Score</th>
                            <th class="p-4">Quizzes Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT 
                                    u.id AS user_id, 
                                    u.username, 
                                    COALESCE(SUM(qa.score), 0) AS total_score, 
                                    COUNT(DISTINCT qa.id) AS completed_quizzes
                                FROM 
                                    users u
                                LEFT JOIN 
                                    quiz_attempts qa ON u.id = qa.user_id
                                GROUP BY 
                                    u.id, u.username
                                ORDER BY 
                                    total_score DESC, 
                                    completed_quizzes DESC
                                LIMIT 100";

                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $rank = 1;
                            $processedUsers = [];
                            $_SESSION['UserRank'] = null; // Initialize as null to ensure clarity.
                        
                            while ($row = mysqli_fetch_assoc($result)) {
                                if ($row['completed_quizzes'] > 0 && !isset($processedUsers[$row['user_id']])) {
                                    echo "<tr class='border-b border-gray-200'>";
                                    echo "<td class='p-4'>" . $rank . "</td>";

                                    $usernameClass = $row['user_id'] == $_SESSION['user_id'] ? 'text-blue-600 font-bold' : '';
                                    echo "<td class='p-4 $usernameClass'>" . htmlspecialchars($row['username']) . "</td>";

                                    echo "<td class='p-4'>" . number_format($row['total_score']) . "</td>";
                                    echo "<td class='p-4'>" . $row['completed_quizzes'] . "</td>";
                                    echo "</tr>";

                                    // Save the rank of the logged-in user
                                    if ($row['user_id'] == $_SESSION['user_id']) {
                                        $_SESSION['UserRank'] = $rank;
                                        // Optionally break the loop if you only care about the logged-in user's rank
                                        // break;
                                    }

                                    $processedUsers[$row['user_id']] = true;
                                    $rank++;
                                }
                            }

                        } else {
                            echo "<tr><td colspan='4' class='text-center p-4'>No leaderboard data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>