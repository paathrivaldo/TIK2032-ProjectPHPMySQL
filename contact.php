<?php
session_start();
$page = 'contact';
require_once 'db_connect.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_message'])) {
    $full_name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $message_text = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO contacts (full_name, message) VALUES ('$full_name', '$message_text')";
    if (mysqli_query($conn, $query)) {
        $message = 'Message sent successfully!';
    } else {
        $message = 'Error: ' . mysqli_error($conn);
    }
}

// Handle delete message
if (isset($_GET['delete_id']) && isset($_SESSION['user_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $query = "DELETE FROM contacts WHERE id = '$delete_id'";
    mysqli_query($conn, $query);
    header("Location: contact.php");
    exit();
}

// Fetch all messages
$query = "SELECT id, full_name, message, created_at FROM contacts ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$contacts = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rivaldo Paath - Contact</title>
  <link rel="shortcut icon" href="./assets/images/logo.ico" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="./assets/css/manage.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
  <main>
    <aside class="sidebar" data-sidebar>
      <div class="sidebar-info">
        <figure class="avatar-box">
          <img src="./assets/images/my-avatar.png" alt="Rivaldo Paath" width="80">
        </figure>
        <div class="info-content">
          <h1 class="name" title="Rivaldo Paath">Rivaldo Paath</h1>
          <p class="title">Informatics Engineering</p>
        </div>
        <button class="info_more-btn" data-sidebar-btn>
          <span>Show Contacts</span>
          <ion-icon name="chevron-down"></ion-icon>
        </button>
      </div>
      <div class="sidebar-info_more">
        <div class="separator"></div>
        <ul class="contacts-list">
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="mail-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Email</p>
              <a href="mailto:jonathanpaath@gmail.com" class="contact-link">jonathanpaath@gmail.com</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="phone-portrait-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Phone</p>
              <a href="tel:+6285696299606" class="contact-link">+62 85696299606</a>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="calendar-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Birthday</p>
              <time datetime="2005-05-13">13 Mei 2005</time>
            </div>
          </li>
          <li class="contact-item">
            <div class="icon-box">
              <ion-icon name="location-outline"></ion-icon>
            </div>
            <div class="contact-info">
              <p class="contact-title">Location</p>
              <address>Manado, Sulawesi Utara, Indonesia</address>
            </div>
          </li>
        </ul>
        <div class="separator"></div>
        <ul class="social-list">
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-facebook"></ion-icon>
            </a>
          </li>
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-twitter"></ion-icon>
            </a>
          </li>
          <li class="social-item">
            <a href="#" class="social-link">
              <ion-icon name="logo-instagram"></ion-icon>
            </a>
          </li>
        </ul>
        <div class="sidebar-login">
          <?php if (isset($_SESSION['user_id'])): ?>
            <p class="user-info">Logged in as <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <a href="logout.php" class="logout-btn">Logout</a>
          <?php else: ?>
            <h4>Admin Login</h4>
            <a href="login.php?redirect=contact.php" class="login-btn">Login</a>
          <?php endif; ?>
        </div>
      </div>
    </aside>
    <div class="main-content">
      <nav class="navbar">
        <ul class="navbar-list">
          <li class="navbar-item">
            <a href="home.php" class="navbar-link <?php echo $page === 'home' ? 'active' : ''; ?>">Home</a>
          </li>
          <li class="navbar-item">
            <a href="gallery.php" class="navbar-link <?php echo $page === 'gallery' ? 'active' : ''; ?>">Gallery</a>
          </li>
          <li class="navbar-item">
            <a href="blog.php" class="navbar-link <?php echo $page === 'blog' ? 'active' : ''; ?>">Blog</a>
          </li>
          <li class="navbar-item">
            <a href="contact.php" class="navbar-link <?php echo $page === 'contact' ? 'active' : ''; ?>">Contact</a>
          </li>
        </ul>
      </nav>
      <article class="contact active" data-page="contact">
        <header>
          <h2 class="h2 article-title">Contact</h2>
        </header>
        <section class="contact-form">
          <h3 class="h3 form-title">Contact Form</h3>
          <?php if ($message): ?>
            <p class="form-message"><?php echo htmlspecialchars($message); ?></p>
          <?php endif; ?>
          <form action="contact.php" method="POST" class="form" data-form>
            <div class="input-wrapper">
              <input type="text" name="fullname" class="form-input" placeholder="Full name" required>
            </div>
            <textarea name="message" class="form-input" placeholder="Your Message" required></textarea>
            <button class="form-btn" type="submit" name="submit_message">
              <ion-icon name="paper-plane"></ion-icon>
              <span>Send Message</span>
            </button>
          </form>
        </section>
        <?php if (isset($_SESSION['user_id'])): ?>
        <section class="content-management">
          <h3>Manage Messages</h3>
          <table>
            <thead>
              <tr>
                <th>Full Name</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($contacts as $contact): ?>
                <tr>
                  <td><?php echo htmlspecialchars($contact['full_name']); ?></td>
                  <td><?php echo htmlspecialchars($contact['message']); ?></td>
                  <td><?php echo date('M d, Y H:i', strtotime($contact['created_at'])); ?></td>
                  <td>
                    <a href="contact.php?delete_id=<?php echo $contact['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </section>
        <?php endif; ?>
      </article>
    </div>
  </main>
  <script src="./assets/js/script.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>