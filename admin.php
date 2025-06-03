<?php
$page = 'admin';
require_once 'db_connect.php';

$project_message = '';
$article_message = '';

// Tangani formulir penambahan proyek
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_project'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    
    // Tangani unggahan gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (in_array($image['type'], $allowed_types) && $image['size'] <= $max_size) {
            $image_name = time() . '_' . basename($image['name']);
            $image_path = './assets/images/' . $image_name;
            
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $query = "INSERT INTO projects (title, image) VALUES ('$title', '$image_name')";
                if (mysqli_query($conn, $query)) {
                    $project_message = 'Project added successfully!';
                } else {
                    $project_message = 'Error: ' . mysqli_error($conn);
                }
            } else {
                $project_message = 'Error uploading image.';
            }
        } else {
            $project_message = 'Invalid image type or size. Only JPG, PNG allowed, max 5MB.';
        }
    } else {
        $project_message = 'Please upload an image.';
    }
}

// Tangani formulir penambahan artikel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_article'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $publish_date = !empty($_POST['publish_date']) ? $_POST['publish_date'] : date('Y-m-d');
    
    // Tangani unggahan gambar
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['banner_image'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if (in_array($image['type'], $allowed_types) && $image['size'] <= $max_size) {
            $image_name = time() . '_' . basename($image['name']);
            $image_path = './assets/images/' . $image_name;
            
            if (move_uploaded_file($image['tmp_name'], $image_path)) {
                $query = "INSERT INTO articles (title, category, publish_date, content, banner_image) VALUES ('$title', '$category', '$publish_date', '$content', '$image_name')";
                if (mysqli_query($conn, $query)) {
                    $article_message = 'Article added successfully!';
                } else {
                    $article_message = 'Error: ' . mysqli_error($conn);
                }
            } else {
                $article_message = 'Error uploading image.';
            }
        } else {
            $article_message = 'Invalid image type or size. Only JPG, PNG allowed, max 5MB.';
        }
    } else {
        $article_message = 'Please upload a banner image.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>vCard - Admin</title>
  <link rel="shortcut icon" href="./assets/images/logo.ico?v=1" type="image/x-icon">
  <link rel="stylesheet" href="./assets/css/style.css">
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
          <p class="title">Informatics Engineering Student</p>
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
          <li class="navbar-item">
            <a href="admin.php" class="navbar-link <?php echo $page === 'admin' ? 'active' : ''; ?>">Admin</a>
          </li>
        </ul>
      </nav>
      <article class="admin active" data-page="admin">
        <header>
          <h2 class="h2 article-title">Admin Dashboard</h2>
        </header>
        <section class="admin-form">
          <h3 class="h3 form-title">Add New Project</h3>
          <?php if ($project_message): ?>
            <p class="form-message"><?php echo htmlspecialchars($project_message); ?></p>
          <?php endif; ?>
          <form action="admin.php" method="POST" enctype="multipart/form-data" class="form">
            <div class="input-wrapper">
              <input type="text" name="title" class="form-input" placeholder="Project Title" required>
            </div>
            <div class="input-wrapper">
              <input type="file" name="image" class="form-input" accept="image/jpeg,image/png,image/jpg" required>
            </div>
            <button class="form-btn" type="submit" name="add_project">
              <ion-icon name="add-circle"></ion-icon>
              <span>Add Project</span>
            </button>
          </form>
        </section>
        <section class="admin-form">
          <h3 class="h3 form-title">Add New Article</h3>
          <?php if ($article_message): ?>
            <p class="form-message"><?php echo htmlspecialchars($article_message); ?></p>
          <?php endif; ?>
          <form action="admin.php" method="POST" enctype="multipart/form-data" class="form">
            <div class="input-wrapper">
              <input type="text" name="title" class="form-input" placeholder="Article Title" required>
            </div>
            <div class="input-wrapper">
              <select name="category" class="form-input" required>
                <option value="" disabled selected>Select Category</option>
                <option value="Technology">Technology</option>
                <option value="Programming">Programming</option>
                <option value="Lifestyle">Lifestyle</option>
                <option value="Data Science">Data Science</option>
              </select>
            </div>
            <div class="input-wrapper">
              <textarea name="content" class="form-input" placeholder="Article Content" required></textarea>
            </div>
            <div class="input-wrapper">
              <input type="date" name="publish_date" class="form-input" placeholder="Publish Date">
            </div>
            <div class="input-wrapper">
              <input type="file" name="banner_image" class="form-input" accept="image/jpeg,image/png,image/jpg" required>
            </div>
            <button class="form-btn" type="submit" name="add_article">
              <ion-icon name="add-circle"></ion-icon>
              <span>Add Article</span>
            </button>
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