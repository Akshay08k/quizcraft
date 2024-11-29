<!DOCTYPE html>
<html lang="en">
<?php
include 'db.php';
session_start();
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc(); // Get user data once

$totalQuiz = "SELECT count(*) as total_quiz FROM quiz_results WHERE user_id = ?";
$stmt = $conn->prepare($totalQuiz);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$quizResult = $stmt->get_result();
$totalQuizCount = $quizResult->fetch_assoc();

$avgScore = "SELECT AVG(score) as avg_score FROM quiz_results WHERE user_id = ?";
$stmt = $conn->prepare($avgScore);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$avgResult = $stmt->get_result();
$avgScore = $avgResult->fetch_assoc();

$leaderBoardRank = "select rank() over (order by score desc) as rank, score from quiz_results where user_id = ?";
$stmt = $conn->prepare($leaderBoardRank);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$rankResult = $stmt->get_result();
$leaderBoardRank = $rankResult->fetch_assoc();

$userInfo = [
    "username" => $_SESSION['username'],
    "email" => $userData['email'], // Now using the first query's result
    "totalQuiz" => $totalQuizCount['total_quiz'], // Using the second query's result
    "avgScore" => $avgScore['avg_score'],
    "leaderBoardRank" => $leaderBoardRank['rank']
];


?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - QuizCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .fade-in {
            opacity: 0;
            animation: fadeIn 1.5s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .zoom-in {
            transform: scale(0.9);
            transition: transform 0.3s;
        }

        .zoom-in:hover {
            transform: scale(1.05);
        }

        .icon-bounce {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .gradient-bg {
            background: linear-gradient(to right, #1e40af, #3b82f6, transparent);
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 2rem;
            border-radius: 1rem;
            max-width: 500px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            transform: scale(0.95);
            transition: transform 0.3s;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close:hover {
            color: #1e40af;
        }

        /* Progress Bar Animation */
        @keyframes progressFill {
            from {
                width: 0;
            }

            to {
                width: var(--progress);
            }
        }

        .progress-bar-fill {
            animation: progressFill 1s ease-out forwards;
        }
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-50 fade-in">
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

    <!-- Hero Profile Section -->
    <section class="relative h-64 flex items-center justify-center text-white gradient-bg mb-8 mt-16">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-800 via-blue-600 to-transparent opacity-75"></div>
        <div class="relative z-10 max-w-7xl w-full mx-auto px-4 flex items-center space-x-8 fade-in">
            <div
                class="w-32 h-32 bg-white rounded-full flex items-center justify-center border-4 border-white shadow-xl">
                <span class="text-5xl text-blue-600"><?php echo substr($userInfo['username'], 0, 1); ?></span>
            </div>
            <div>
                <h1 class="text-4xl font-bold"><?php echo htmlspecialchars($userInfo['username']); ?></h1>
                <div class="flex items-center space-x-4 mt-2">
                    <button onclick="openModal()"
                        class="bg-white text-blue-600 px-4 py-1 rounded-full text-sm hover:bg-blue-50">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 pb-10">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stats-card p-6 rounded-lg shadow-lg zoom-in">
                <div class="flex items-center justify-between">
                    <img src="https://img.icons8.com/48/quiz.png" alt="Quiz" class="icon-bounce">
                </div>
                <h3 class="text-gray-600 mt-4">Total Quizzes</h3>
                <p class="text-3xl font-bold text-blue-600"><?php echo $userInfo['totalQuiz']; ?></p>
            </div>

            <div class="stats-card p-6 rounded-lg shadow-lg zoom-in">
                <div class="flex items-center justify-between">
                    <img src="https://img.icons8.com/color/47/accuracy.png" alt="Accuracy" class="icon-bounce">
                </div>
                <h3 class="text-gray-600 mt-4">Average Score</h3>
                <p class="text-3xl font-bold text-blue-600"><?php echo round($userInfo['avgScore'], 2); ?>% </p>
            </div>



            <div class="stats-card p-6 rounded-lg shadow-lg zoom-in">
                <div class="flex items-center justify-between">
                    <img src="https://img.icons8.com/color/48/leaderboard.png" alt="Rank" class="icon-bounce">
                </div>
                <h3 class="text-gray-600 mt-4">Global Rank</h3>
                <p class="text-3xl font-bold text-blue-600"># <?php echo $userInfo['leaderBoardRank']; ?></p>
            </div>
        </div>

        <!-- Analytics Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow-lg fade-in">
                <h2 class="text-2xl font-bold text-blue-600 mb-4">Performance Trend</h2>
                <canvas id="progressChart" height="200"></canvas>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-lg fade-in">
                <h2 class="text-2xl font-bold text-blue-600 mb-4">Category Mastery</h2>
                <canvas id="categoryChart" height="200"></canvas>
            </div>
        </div>
        <!-- Recent Achievements -->


        <!-- Quiz History -->
        <section class="bg-white p-6 rounded-lg shadow-lg fade-in">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-blue-600">Quiz History</h2>
                <select
                    class="border rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option>All Time</option>
                    <option>This Month</option>
                    <option>This Week</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase">Quiz</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase">Score</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-blue-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        $quizHistory = [
                            ["quiz" => "Advanced Mathematics", "score" => 92, "time" => "45m", "date" => "2024-10-15"],
                            ["quiz" => "World History", "score" => 88, "time" => "30m", "date" => "2024-10-12"],
                            ["quiz" => "Physics Fundamentals", "score" => 85, "time" => "35m", "date" => "2024-10-10"],
                        ];
                        foreach ($quizHistory as $quiz): ?>
                            <tr class="hover:bg-blue-50 transition duration-150">
                                <td class="px-6 py-4"><?php echo $quiz['quiz']; ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <span><?php echo $quiz['score']; ?>%</span>
                                        <div class="w-24 h-2 bg-gray-200 rounded-full">
                                            <div class="h-full bg-blue-600 rounded-full progress-bar-fill"
                                                style="--progress: <?php echo $quiz['score']; ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><?php echo $quiz['time']; ?></td>
                                <td class="px-6 py-4"><?php echo $quiz['date']; ?></td>
                                <td class="px-6 py-4">
                                    <button class="text-blue-600 hover:text-blue-800">Review</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2 class="text-2xl font-bold text-blue-600 mb-6">Edit Profile</h2>
            <form action="update_profile.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2" for="username">Username</label>
                    <input type="text" id="username" name="username"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo htmlspecialchars($userInfo['username']); ?>">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2" for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        value="<?php echo htmlspecialchars($userInfo['email']); ?>">
                </div>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-150">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>

    <script>
        function openModal() {
            document.getElementById('editProfileModal').style.display = 'block';
            setTimeout(() => {
                document.getElementById('editProfileModal').classList.add('active');
            }, 10);
        }

        function closeModal() {
            document.getElementById('editProfileModal').classList.remove('active');
            setTimeout(() => {
                document.getElementById('editProfileModal').style.display = 'none';
            }, 300);
        }

        const progressCtx = document.getElementById('progressChart').getContext('2d');
        new Chart(progressCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Average Score',
                    data: [75, 82, 78, 85, 82, 90],
                    borderColor: '#2563eb',
                    tension: 0.4,
                    fill: true,
                    backgroundColor: 'rgba(37, 99, 235, 0.1)'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });

        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'radar',
            data: {
                labels: ['General Knowledge & Current Affairs', 'Science & Technology', 'Mathematics', 'Arts & Entertainment', 'Literature & Languages', 'Sports & Fitness', 'Business & Economy', 'History & Geography', 'Education & Academics', 'Pop Culture & Media'],
                datasets: [{
                    label: 'Mastery Level',
                    data: [85, 92, 78, 88, 95, 10, 20, 30, 40, 50],
                    backgroundColor: 'rgba(37, 99, 235, 0.2)',
                    borderColor: '#2563eb',
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: '#2563eb'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            stepSize: 20 // Changed from 40 to ensure finer control within the max 100
                        }
                    }
                }
            }
        });

    </script>
</body>

</html>