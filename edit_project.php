<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once 'db_connect.php';

// Redirect jika tidak login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=gallery.php");
    exit();
}

// Ambil ID project
if (!isset($_GET['id'])) {
    header("Location: gallery.php");
    exit();
}

$id = mysqli_real_escape_string($conn, $_GET['id']);

// Ambil data project
$query = "SELECT * FROM projects WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$project = mysqli_fetch_assoc($result);

if (!$project) {
    echo "Project not found.";
    exit();
}

// Handle update form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_project'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $newImage = $project['image']; // default image lama

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
                // Hapus gambar lama
                if ($project['image'] && file_exists($upload_dir . $project['image'])) {
                    unlink($upload_dir . $project['image']);
                }
                $newImage = mysqli_real_escape_string($conn, $new_file_name);
            } else {
                $error = "Failed to upload image.";
            }
        } else {
            $error = "Invalid file format. Allowed: jpg, jpeg, png, gif.";
        }
    }

    if (!isset($error)) {
        $update_query = "UPDATE projects SET title = '$title', image = '$newImage' WHERE id = '$id'";
        mysqli_query($conn, $update_query);
        header("Location: gallery.php");
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
    <title>Edit Project</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/edit_project.css">
</head>
<body>
    <main>
        <div class="edit-project">
            <h2>Edit Project</h2>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>

                <label for="image">Current Project Image:</label>
                <?php if (!empty($project['image'])): ?>
                    <img src="./assets/images/<?php echo htmlspecialchars($project['image']); ?>" alt="Current Project" class="project-preview">
                <?php else: ?>
                    <p>No project image uploaded.</p>
                <?php endif; ?>
                <input type="file" name="image" accept="image/*">

                <button type="submit" name="update_project">Update Project</button>
            </form>
            <p><a href="gallery.php" class="back-btn">← Back to Gallery</a></p>
        </div>
    </main>
</body>
</html>