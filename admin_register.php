<?php
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert the new admin into the database
    $query = "INSERT INTO admin (username, password) VALUES (?, ?)";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $success = $stmt->execute();

    // Respond with JSON
    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Admin registered successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Registration failed']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="admin_register.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav>
        <div class="logo-container">
            <img src="image/open-book.png" alt="">
            <h2>BOOK.<span>LIB</span></h2>
        </div>
        <div class="link">
            <a href="admin_login.php">Login</a>
        </div>
    </nav>
    <div class="box">
        <div class="container">
            <h1>Admin <span>Signup</span> </h1>
            <form id="registrationForm">
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit">Register</button>
                <p>Already have an account?<a href="admin_login.php"> Login</a></p>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);

            fetch('admin_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.success ? 'Success!' : 'Error!',
                    text: data.message,
                    confirmButtonText: 'OK'
                }).then(() => {
                    if (data.success) {
                        window.location.href = 'admin_login.php';
                    }
                });
            })
            .catch(() => {
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
