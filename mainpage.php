<!-- <?php
session_start();
require_once('config.php');

if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if(!isset($_SESSION['id'])){
    header("Location: register.php");
    exit();
}

if(isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="mainpage.css">
</head>
<body>
    <nav>
       <div class="logo-container">
        <img src="image/open-book.png" alt="">
        <h2>BOOK.<SPAN>LIB</SPAN></h2>
       </div>
     
       <div class="link">
       <h5>Welcome, <?php echo htmlspecialchars($username); ?>!</h5>
        <a href="?logout=1">Log out</a>
        
       </div>
       <!-- <div class="link">

       </div> -->
    <!-- </nav> -->
    <!-- <header>
        <h1>Welcome to homepage</h1>
    </header> -->
    <!-- <main> -->
       
     
        <!-- Your main content goes here -->
    <!-- </main>
    <footer>
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer> -->
</body>
</html> 
<?php
// session_start();
require_once('config.php');

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

// Fetch books from the database
$query = "SELECT * FROM books";
$result = $connection->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="mainpage.css">
</head>
<body>
    <nav>
       <div class="logo-container">
        <img src="image/open-book.png" alt="">
        <h2>BOOK.<SPAN>LIB</SPAN></h2>
       </div>
     
       <div class="link">
       <h5>Welcome, <?php echo htmlspecialchars($username); ?>!</h5>
        <a href="?logout=1">Log out</a>
       </div>
    </nav>

    <main>
    <h2>Book List</h2>
    <ul>
        <?php while ($book = $result->fetch_assoc()) { ?>
            <li>
                <a class="Link-to-another" href="read_book.php?book_id=<?php echo $book['id']; ?>"> <!-- Link to the book reading page -->
                    <img src="uploads/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>">
                    <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                </a>
                <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                <p>Description: <?php echo htmlspecialchars($book['description']); ?></p>
                <!-- <p>Price: $<?php echo number_format($book['price'], 2); ?></p> -->
                <a class="Read" href="read_book.php?book_id=<?php echo $book['id'];?>">Read Now</a>
            </li>
        <?php } ?>
    </ul>
</main>


        
   

    <!-- <footer>
        &copy; <?php echo date("Y"); ?> Your Website. All rights reserved.
    </footer> -->
</body>
</html>
