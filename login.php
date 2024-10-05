<?php
session_start(); // Start a session to store user data

// Database connection
$servername = "localhost"; // Update with your server details
$username = "root"; // Database username
$password = ""; // Database password
$dbname = "quizcraft"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST['email'];
  $password = $_POST['password'];

  //to prevent sql injection
  $email = $conn->real_escape_string($email);

  // first check record in database than proceed
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      if ($user['role'] == 'admin') {
        header("Location: dashboard.php");
      } else {
        header("Location: homepage.php");
      }
      exit();
    } else {
      $error_message = "Invalid password!";
    }
  } else {
    $error_message = "No account found with that email!";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>QuizCraft | Login</title>
  <style>
    body {
      background-image: url(https://img.freepik.com/premium-vector/different-football-silhouettes-seamless-pattern-vector-background_153454-5070.jpg);
    }
  </style>
  <link rel="shortcut icon" href="logo.jpeg" type="image/x-icon" />
  <link rel="stylesheet" href="output.css">
</head>

<body class="bg-gray-900 flex items-center justify-center h-screen">
  <div class="w-full max-w-md bg-gray-800 shadow-md rounded-lg p-8">
    <h2 class="text-2xl font-semibold text-center text-white mb-6 flex flex-col items-center">
      <img src="logo.jpeg" alt="QuizCraft Logo" class="mb-4 w-16 h-16 rounded-full" />
      <span class="text-3xl font-bold text-yellow-500">QuizCraft Login</span>
    </h2>

    <?php if (!empty($error_message)): ?>
      <div class="bg-red-500 text-white p-2 mb-4 rounded">
        <?php echo $error_message; ?>
      </div>
    <?php endif; ?>

    <form action="login.php" method="POST">
      <div class="mb-4">
        <label for="email" class="block text-gray-300 font-medium mb-2">Email</label>
        <input type="email" id="email" name="email"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your email" required />
      </div>

      <div class="mb-6">
        <label for="password" class="block text-gray-300 font-medium mb-2">Password</label>
        <input type="password" id="password" name="password"
          class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
          placeholder="Enter your password" required />
      </div>

      <div class="mb-4 flex items-center">
        <input type="checkbox" id="remember_me" name="remember_me"
          class="mr-2 bg-gray-700 border border-gray-600 text-blue-500 focus:ring-2 focus:ring-blue-500" />
        <label for="remember_me" class="text-gray-400">Remember me</label>
      </div>

      <button type="submit"
        class="w-full bg-yellow-700 text-white py-2 rounded-lg hover:bg-yellow-800 transition duration-200">
        Login
      </button>
    </form>

    <div class="mt-6 text-center">
      <a href="forgot_password.php" class="text-blue-400 hover:underline">Forgot password?</a>
      <p class="mt-2 text-gray-400">
        Don't have an account?
        <a href="register.php" class="text-blue-400 hover:underline">Sign up</a>
      </p>
    </div>
  </div>
</body>

</html>