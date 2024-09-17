<?php
// session_start();
require_once('config.php');

// Check if the user is an admin
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// if(isset($_GET['logout'])) {
//     session_destroy();
//     header("Location:admin_login.php");
//     exit();
// }


// $admin = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
<!--    
    <header>
    <nav>
    <div class="logo-container">
        <img src="image/open-book.png" alt="" width="50px">
        <h2>BOOK.<span>LIB</span></h2>
    </div>
    <div class="link-container">
    <h1>Admin,<?php echo htmlspecialchars($admin)?></h1>
    <a href="?logout=1">Logout</a>
    </div>

    </nav>
    </header>
    <br>

   
    <section class="addbooks">
    <a href="admin_addbooks.php">ADD BOOKS</a>
    </section> -->
  
    
</body>
</html>

<?php
session_start();
require_once('config.php');

// Check if the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

$admin = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Sidebar Menu</h2>
        <a href="admin_addbooks.php">
            <i class="fas fa-book"></i> Add Books
        </a>
        <a href="?logout=1">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="main-content">
        <nav>
            <div class="logo-container">
                <img src="image/open-book.png" alt="" width="50px">
                <h2>BOOK.<span>LIB</span></h2>
            </div>
            <div class="link-container">
                <h1>Admin, <?php echo htmlspecialchars($admin); ?></h1>
                <a href="?logout=1">Logout</a>
            </div>

            <!-- Hamburger menu for smaller screens -->
            <button class="hamburger" id="hamburger">☰</button>
        </nav>

        <div class="addbooks">
            <!-- <a href="admin_addbooks.php">ADD BOOKS</a> -->
        </div>
    </div>

    <script>
        // JavaScript to toggle sidebar visibility on smaller screens
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const hamburger = document.getElementById('hamburger');

        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('expanded');
        });
    </script>
</body>
</html>
