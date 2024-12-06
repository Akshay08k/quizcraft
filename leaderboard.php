<?php session_start();
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit();
// }
require_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard - QuizCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                            <th class="p-4">Score</th>
                            <th class="p-4">Quizzes Completed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $_SESSION['username'] = "test";
                        $sql = "SELECT users.username,quiz_attempts.score,count(DISTINCT quiz_attempts.id) as completed FROM users
                        LEFT JOIN quiz_attempts ON users.id = quiz_attempts.user_id
                        GROUP BY users.username,quiz_attempts.score
                        ORDER BY quiz_attempts.score DESC,completed DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $rank = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr class='border-b border-gray-200'>";
                                echo "<td class='p-4'>" . $rank . "</td>";
                                echo "<td class='p-4'>" . $row['username'] . "</td>";
                                echo "<td class='p-4'>" . $row['score'] . "</td>";
                                echo "<td class='p-4'>" . $row['completed'] . "</td>";
                                echo "</tr>";
                                $rank++;
                            }
                        }

                        
                        // User data to be included
                        // if ($_SESSION['username'] == $row['username']) {
                        //     $userData = ["username" => $row['username'], "score" => $row['score'], "completed" => $row['completed']];
                        // }

                        // Sort the leaderboard by score (highest to lowest)
                        

                        // Assign ranks and display the leaderboard
                        
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-blue-500 text-white py-6 mt-10">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>