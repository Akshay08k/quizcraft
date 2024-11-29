<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Quizzes - QuizCraft</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Smooth Transition and Custom Fade In */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Custom Color Scheme */

        .text-accent {
            color: #14B8A6;
        }



        /* Card Styling */
        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800 font-sans flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed top-0 left-0 w-full z-10 fade-in">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <div class="text-2xl font-bold text-blue-600">QuizCraft</div>
                <ul class="flex space-x-4">
                    <li><a href="index.php" class="text-gray-700 hover:text-blue-600">Home</a></li>
                    <li><a href="quizz.php" class="text-gray-700 hover:text-blue-600">Quizzes</a></li>
                    <li><a href="leaderboard.php" class="text-gray-700 hover:text-blue-600">Leaderboard</a></li>
                    <li><a href="profile.php" class="text-gray-700 hover:text-blue-600">Profile</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Wrapper -->
    <main class="flex-grow pt-32 pb-10 text-center fade-in">
        <!-- Hero Section -->
        <section>
            <div class="max-w-3xl mx-auto px-4">
                <h1 class="text-5xl font-bold text-gray-800 mb-4">Explore Our Latest Quizzes</h1>
                <p class="text-lg text-gray-600">Challenge yourself with our diverse range of quizzes and see where you
                    stand on the leaderboard.</p>
            </div>
        </section>

        <!-- Search Bar -->
        <section class="py-4">
            <div class="max-w-5xl mx-auto px-4">
                <form method="GET" action="quizz.php" class="flex justify-center">
                    <input type="text" name="search" placeholder="Search for quizzes..."
                        class="w-full max-w-md py-2 px-4 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-accent" />
                    <button type="submit"
                        class="text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-r-lg">Search</button>
                </form>
            </div>
        </section>

        <!-- Quizzes List -->
        <section class="py-8">
            <div class="max-w-5xl mx-auto px-4">
                <div class="space-y-8">
                    <?php
                    // Database connection (replace with your actual credentials)
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "quizcraft";

                    // Create connection and check
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    // Get search query if available
                    $search_query = isset($_GET['search']) ? $_GET['search'] : '';
                    $sql = "SELECT id, name FROM categories";

                    // Modify SQL query to filter results if there's a search term
                    if (!empty($search_query)) {
                        $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search_query) . "%'";
                    }

                    $result = $conn->query($sql);

                    // Display quizzes
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="card p-6 flex justify-between items-center fade-in">';
                            echo '<div>';
                            echo '<h3 class="text-2xl font-semibold text-gray-800">' . htmlspecialchars($row["name"]) . '</h3>';
                            echo '</div>';
                            echo '<a href="take_quiz.php?quiz_id=' . $row["id"] . '" class="text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg shadow-lg">Take Quiz</a>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p class="text-center text-gray-600">No quizzes found for your search.</p>';
                    }

                    // Close the connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-primary text-white py-6 mt-10">
        <div class="max-w-7xl mx-auto text-center">
            <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
        </div>
    </footer>

</body>

</html>