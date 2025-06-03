<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: blog.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);
$query = "SELECT * FROM articles WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$article = mysqli_fetch_assoc($result);

if (!$article) {
    header("Location: blog.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $publish_date = mysqli_real_escape_string($conn, $_POST['publish_date']);

    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['banner_image']['tmp_name'];
        $file_name = basename($_FILES['banner_image']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_ext, $allowed_ext)) {
            $upload_dir = './assets/images/';
            $new_file_name = uniqid() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_path)) {
                if ($article['banner_image'] && file_exists($upload_dir . $article['banner_image'])) {
                    unlink($upload_dir . $article['banner_image']);
                }
                $banner_image = mysqli_real_escape_string($conn, $new_file_name);
                $query = "UPDATE articles SET title='$title', content='$content', banner_image='$banner_image', publish_date='$publish_date' WHERE id='$id'";
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid file format. Allowed: jpg, jpeg, png, gif.";
        }
    } else {
        $query = "UPDATE articles SET title='$title', content='$content', publish_date='$publish_date' WHERE id='$id'";
    }

    if (!isset($error)) {
        mysqli_query($conn, $query);
        header("Location: blog.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/edit_article.css">
</head>
<body>
    <div class="main-content">
        <section class="content-management">
            <h3>Edit Article</h3>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($article['title']); ?>" required>

                <label for="content">Content:</label>
                <textarea name="content" required><?php echo htmlspecialchars($article['content']); ?></textarea>

                <label for="banner_image">Current Banner Image:</label>
                <?php if (!empty($article['banner_image'])): ?>
                    <img src="./assets/images/<?php echo htmlspecialchars($article['banner_image']); ?>" alt="Current Banner" class="banner-preview">
                <?php else: ?>
                    <p>No banner image uploaded.</p>
                <?php endif; ?>
                <input type="file" name="banner_image" accept="image/*">

                <label for="publish_date">Publish Date:</label>
                <input type="datetime-local" name="publish_date" value="<?php echo date('Y-m-d\TH:i', strtotime($article['publish_date'])); ?>" required>

                <button type="submit">Update Article</button>
            </form>
        </section>
    </div>
</body>
</html>