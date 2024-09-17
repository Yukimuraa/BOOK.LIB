<?php
session_start();
require_once('config.php');

// Check if the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $book_title = $_POST['book_title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Handle the image file upload
    $image = $_FILES['image']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    
    // Handle the book file upload
    $book_file = $_FILES['book_file']['name'];
    $book_target_file = $target_dir . basename($book_file);
    

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file) && move_uploaded_file($_FILES['book_file']['tmp_name'], $book_target_file)) {
        // Insert the new book into the database with image and file path
        $query = "INSERT INTO books (title, author, description, price, image, book_file) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        $stmt->bind_param("sssdss", $book_title, $author, $description, $price, $image, $book_file);
        $stmt->execute();
        
        // Redirect with success flag
        header("Location: admin_addbooks.php?success=true");
        exit();
    } else {
        $error = "Error uploading files.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_addbooks.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert -->
</head>
<body>
    <a href="admin_dashboard.php" class="Back">Back</a>
    
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>

    <div class="box">
        <div class="container">
            <form action="admin_addbooks.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="book_title" placeholder="Book Title" required>
                <input type="text" name="author" placeholder="Author" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" step="0.01" name="price" placeholder="Price" required>

                <!-- Image input -->
                <label for="uploadImage">Upload Image</label>
                <input type="file" name="image" id="uploadImage" required>

                <!-- Book file input -->
                <label for="uploadBook">Upload Book File</label>
                <input type="file" name="book_file" id="uploadBook" required>

                <!-- Add Book button -->
                <button type="submit" name="submit">Add Book</button>
            </form>
        </div>
    </div>

    <!-- SweetAlert Success Message -->
    <script>
        // Debugging: Console log the success parameter to check if it's passed correctly
        console.log("Success parameter: <?php echo isset($_GET['success']) ? $_GET['success'] : 'Not set'; ?>");

        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            Swal.fire({
                icon: 'success',
                title: 'Book Added!',
                text: 'The book has been added successfully.',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
    </script>
</body>
</html>
