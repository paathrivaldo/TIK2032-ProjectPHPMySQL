<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

// Check if database connection is successful
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    if ($result === false) {
        $error = "Database query failed: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'blog.php';
            header("Location: $redirect");
            exit();
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rivaldo Paath - Login</title>
  <link rel="shortcut icon" href="./assets/images/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <main>
    <div class="main-content">
      <article class="login-container">
        <header>
          <h2 class="h2 article-title">Login</h2>
        </header>
        <section>
          <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" required>
            <label for="password">Password</label>
            <input type="password" name="password" required>
            <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($_GET['redirect'] ?? 'blog.php'); ?>">
            <button type="submit" name="login">Login</button>
            <?php if (isset($error)): ?>
              <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
          </form>
        </section>
      </article>
    </div>
  </main>
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>