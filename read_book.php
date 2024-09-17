<?php
session_start();
require_once('config.php');

// Get the book ID from the URL
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Fetch the book details from the database
    $query = "SELECT * FROM books WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if (!$book) {
        echo "Book not found.";
        exit();
    }
} else {
    echo "No book selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($book['title']); ?> - Read Book</title>
</head>
<body>
    <h1><?php echo htmlspecialchars($book['title']); ?></h1>
    <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
    <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>

    <!-- Display the PDF if the book file is a PDF -->
    <?php if (pathinfo($book['book_file'], PATHINFO_EXTENSION) === 'pdf') { ?>
        <embed src="uploads/<?php echo htmlspecialchars($book['book_file']); ?>" width="100%" height="600px" type="application/pdf">
    <?php } else { ?>
        <!-- For other file types (e.g., text), you can provide a download link -->
        <p><a href="uploads/<?php echo htmlspecialchars($book['book_file']); ?>" download>Download Book</a></p>
    <?php } ?>

</body>
</html>
