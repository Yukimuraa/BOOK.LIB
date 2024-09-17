<?php
if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
        echo "<script>alert('Please fill in all fields.')</script>";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email format.')</script>";
        } else {
            // Check for duplicate username or email
            $duplicate_query = "SELECT * FROM easyuser WHERE username = ? OR email = ?";
            $stmt = mysqli_prepare($connection, $duplicate_query);
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo "<script>alert('Username or Email are already taken.')</script>";
            } else {
                // Check if passwords match
                if ($password === $confirmpassword) {
                    // Hash the password
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert new user into the database
                    $insert_query = "INSERT INTO easyuser (name, username, email, password) VALUES (?, ?, ?, ?)";
                    $stmt = mysqli_prepare($connection, $insert_query);
                    mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashed_password);

                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Successfully signed up'); window.location.href='login.php';</script>";
                    } else {
                        echo "<script>alert('Error in registration. Please try again.')</script>";
                    }
                } else {
                    echo "<script>alert('Passwords do not match.')</script>";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

?>


<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="">
        <input type="password" name="" id="pwd">
        <input type="checkbox" name="" id="chk">Show password
    </form>
</body>
    <script>
        const pwd = document.getElementById('pwd');
        const chk = document.getElementById('chk');

        chk.onchange = function(e){
            pwd.type = chk.checked ? "text" : "password";
        };
    </script>
</html> -->