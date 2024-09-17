<?php
session_start();
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Fetch admin from the database
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        // Respond with JSON for success
        echo json_encode(['success' => true, 'message' => 'Successfully logged in']);
    } else {
        // Respond with JSON for error
        echo json_encode(['success' => false, 'message' => 'Wrong Credentials']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="admin_login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav>
        <div class="logo-container">
            <img src="image/open-book.png" alt="" width="50px">
            <h2>BOOK.<span>LIB</span></h2>
        </div>
        <div class="link">
            <a href="admin_register.php">Register</a>
        </div>
    </nav>
    <div class="box">
        <div class="container">
            <h1>Admin Login</h1>
            <form id="loginForm" method="POST">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" name="submit">Login</button>
                <p>Don't have an account?<a href="admin_register.php">Register</a></p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let formData = new FormData(this);

            fetch('admin_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success Alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,

                        confirmButtonText: 'OK',
                    }).then(() => {
                        window.location.href = 'admin_dashboard.php'; // Redirect after success
                    });
                } else {
                    // Error Alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(() => {
                // General Error Alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Something went wrong!',
                    confirmButtonText: 'OK'
                });
            });
        });
    </script>
</body>
</html>
