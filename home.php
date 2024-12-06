<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QuizCraft</title>
  <link rel="stylesheet" href="public/css/output.css">
  <link rel="stylesheet" href="public/css/home.css">
  <link rel="shortcut icon" href="public/images/logo.jpeg" type="image/x-icon" />
</head>

<body class="bg-gray-100">

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

  <section class="relative h-screen flex items-center justify-center text-center text-white"
    style="background-image: url('https://t4.ftcdn.net/jpg/03/03/32/29/360_F_303322991_j4dMRbdkvaTKU8o50FJichVrYEbvjbWJ.jpg'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-800 via-blue-600 to-transparent opacity-75"></div>
    <div class="relative z-10 px-4 fade-in">
      <h1 class="text-6xl font-bold mb-4">Welcome to QuizCraft</h1>
      <p class="text-xl mb-6">Test your knowledge and compete with others in various categories!</p>
      <a href="quizz.php"
        class="bg-blue-600 text-white font-semibold py-3 px-10 rounded-full shadow-lg hover:bg-blue-500 transition duration-300 transform hover:scale-105">Start
        Quiz</a>
    </div>
  </section>

  <section class="py-16 bg-gray-100 fade-in">
    <div class="max-w-7xl mx-auto px-4">
      <h2 class="text-center text-3xl font-bold text-blue-600 mb-8">About QuizCraft</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

        <div class="p-8 bg-white rounded-lg shadow-lg zoom-in">
          <img src="https://img.icons8.com/96/quiz.png" alt="Variety of Quizzes" class="mx-auto mb-4 icon-bounce">
          <h3 class="text-2xl font-bold text-blue-600 mb-2">Wide Variety of Quizzes</h3>
          <p>Choose from various categories and challenge yourself with different levels of difficulty.</p>
        </div>
        <div class="p-8 bg-white rounded-lg shadow-lg zoom-in">
          <img src="https://img.icons8.com/color/96/leaderboard.png" alt="Leaderboard" class="mx-auto mb-4 icon-bounce">
          <h3 class="text-2xl font-bold text-blue-600 mb-2">Leaderboard</h3>
          <p>See how you rank against others in real-time and take your place at the top of the leaderboard.</p>
        </div>
        <div class="p-8 bg-white rounded-lg shadow-lg zoom-in">
          <img src="https://img.icons8.com/color/96/analytics.png" alt="Track Progress"
            class="mx-auto mb-4 icon-bounce">
          <h3 class="text-2xl font-bold text-blue-600 mb-2">Track Your Progress</h3>
          <p>Monitor your scores, review your performance, and improve over time with detailed analytics.</p>
        </div>
      </div>
    </div>
  </section>

  <footer class="bg-gray-800 text-white py-8">
    <div class="max-w-7xl mx-auto text-center">
      <p>&copy; 2024 QuizCraft. All Rights Reserved.</p>
    </div>
  </footer>

</body>

</html>