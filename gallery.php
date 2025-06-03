<?php
session_start();
$page = 'gallery';
require_once 'db_connect.php';

$query = "SELECT * FROM projects ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);
$projects = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Handle form submission for adding project
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project']) && isset($_SESSION['user_id'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = basename($_FILES['image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = './assets/images/';
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;
            
            if (move_uploaded_file($file_tmp, $upload_path)) {
                $image = mysqli_real_escape_string($conn, $new_file_name);
                $query = "INSERT INTO projects (title, image) VALUES ('$title', '$image')";
                mysqli_query($conn, $query);
            }
        }
    }
    header("Location: gallery.php");
    exit();
}

// Handle delete project
if (isset($_GET['delete_id']) && isset($_SESSION['user_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    // Get the image file name to delete it from the server
    $query = "SELECT image FROM projects WHERE id = '$delete_id'";
    $result = mysqli_query($conn, $query);
    $project = mysqli_fetch_assoc($result);
    
    if ($project && file_exists('./assets/images/' . $project['image'])) {
        unlink('./assets/images/' . $project['image']);
    }
    
    $query = "DELETE FROM projects WHERE id = '$delete_id'";
    mysqli_query($conn, $query);
    header("Location: gallery.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>vCard - Gallery</title>
  <link rel="shortcut icon" href="./assets/images/logo.ico?v=1" type="image/x-icon">
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
            <a href="login.php?redirect=gallery.php" class="login-btn">Login</a>
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
      <article class="gallery active" data-page="gallery">
        <header>
          <h2 class="h2 article-title">Gallery</h2>
        </header>
        <section class="projects">
          <ul class="project-list">
            <?php foreach ($projects as $project): ?>
              <li class="project-item active" data-filter-item>
                <a href="#">
                  <figure class="project-img">
                    <div class="project-item-icon-box">
                      <ion-icon name="eye-outline"></ion-icon>
                    </div>
                    <img src="./assets/images/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" loading="lazy">
                  </figure>
                  <h3 class="project-title"><?php echo htmlspecialchars($project['title']); ?></h3>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </section>
        <?php if (isset($_SESSION['user_id'])): ?>
        <section class="content-management">
          <h3>Manage Projects</h3>
          <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">Title</label>
            <input type="text" name="title" required>
            <label for="image">Image</label>
            <input type="file" name="image" accept="image/*" required>
            <button type="submit" name="add_project">Add Project</button>
          </form>
          <table>
            <thead>
              <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($projects as $project): ?>
                <tr>
                  <td><?php echo htmlspecialchars($project['title']); ?></td>
                  <td><?php echo htmlspecialchars($project['image']); ?></td>
                  <td>
                    <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="action-btn edit-btn">Edit</a>
                    <a href="gallery.php?delete_id=<?php echo $project['id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
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