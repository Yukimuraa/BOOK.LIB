<?php
// Not secure code
// session_start();
// require_once('config.php');

// if (isset($_SESSION['id'])) {
//     header("Location: mainpage.php");
//     exit;
// }

// if (isset($_POST['submit'])) {
//     $name = $_POST['name'];
//     $username = $_POST['username'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $confirmpassword = $_POST['confirmpassword'];

//     // Sanitize input data
//     $name = mysqli_real_escape_string($connection, $name);
//     $username = mysqli_real_escape_string($connection, $username);
//     $email = mysqli_real_escape_string($connection, $email);
//     $password = mysqli_real_escape_string($connection, $password);
//     $confirmpassword = mysqli_real_escape_string($connection, $confirmpassword);

//     $duplicate = mysqli_query($connection, "SELECT * FROM easyuser WHERE username = '$username' OR email ='$email'");
    
//     if (mysqli_num_rows($duplicate) > 0) {
//         echo "<script>alert('Username or Email are already taken')</script>";
//     } else {
//         if ($password == $confirmpassword) {
//             // Hash the password
//             $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//             $insert_into_db = "INSERT INTO easyuser VALUES('', '$name', '$username', '$email', '$hashed_password')";
//             mysqli_query($connection, $insert_into_db);
//             echo "<script>alert('Successfully sign up')</script>";
//         } else {
//             echo "<script>alert('Password does not match')</script>";
//         }
//     }
// }

 

?>
<?php
// Secure Code
// session_start();
// require_once('config.php');

// if (!empty($_SESSION['id'])) {
//     header("Location: mainpage.php");
//     exit;
// }

// if (isset($_POST['submit'])) {
//     $name = trim($_POST['name']);
//     $username = trim($_POST['username']);
//     $email = trim($_POST['email']);
//     $password = trim($_POST['password']);
//     $confirmpassword = trim($_POST['confirmpassword']);

//     // Check if all fields are filled
    // if (empty($name) || empty($username) || empty($email) || empty($password) || empty($confirmpassword)) {
//         echo "<script>alert('Please fill in all fields.')</script>";
//     } else {
//         // Validate email format
//         if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//             echo "<script>alert('Invalid email format.')</script>";
//         } else {
//             // Check for duplicate username or email
//             $duplicate_query = "SELECT * FROM easyuser WHERE username = ? OR email = ?";
//             $stmt = mysqli_prepare($connection, $duplicate_query);
//             mysqli_stmt_bind_param($stmt, "ss", $username, $email);
//             mysqli_stmt_execute($stmt);
//             $result = mysqli_stmt_get_result($stmt);

//             if (mysqli_num_rows($result) > 0) {
//                 echo "<script>alert('Username or Email are already taken.')</script>";
//             } else {
//                 // Check if passwords match
//                 if ($password === $confirmpassword) {
//                     // Hash the password
//                     $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//                     // Insert new user into the database
//                     $insert_query = "INSERT INTO easyuser (name, username, email, password) VALUES (?, ?, ?, ?)";
//                     $stmt = mysqli_prepare($connection, $insert_query);
//                     mysqli_stmt_bind_param($stmt, "ssss", $name, $username, $email, $hashed_password);

//                     if (mysqli_stmt_execute($stmt)) {
//                         echo "<script>alert('Successfully signed up'); window.location.href='login.php';</script>";
//                     } else {
//                         echo "<script>alert('Error in registration. Please try again.')</script>";
//                     }
//                 } else {
//                     echo "<script>alert('Passwords do not match.')</script>";
//                 }
//             }
//             mysqli_stmt_close($stmt);
//         }
//     }
// }


session_start();
require_once('config.php');
   if(!empty($_SESSION['id'])){
    header("Location:mainpage.php");
   }

   $errorMessage = '';
   $name = '';
   $username = '';
   $email ='';
   $password = '';
   $confirmpassword ='';
   
   if(isset($_POST['submit'])){
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmpassword = trim($_POST['confirmpassword']);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        // echo "<script>alert('Invlid Email format')</script>";
        $errorMessage = 'Invalid email format';
    }else{
        // duplicate email
        $duplicate_query = "SELECT * FROM easyuser WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($connection,$duplicate_query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)> 0){
            // echo "<script>alert('Username or email are already taken')</script>";
            $errorMessage ='Username or email are already taken' ;
        }else{
            if($password === $confirmpassword){
                $pass_hashed = password_hash($password, PASSWORD_DEFAULT);

                $insert_into_db = "INSERT INTO easyuser (name, username, email, password) VALUES (?,?,?,?)";
                $stmt = mysqli_prepare($connection, $insert_into_db);
                mysqli_stmt_bind_param($stmt, "ssss", $name,$username,$email,$pass_hashed);

                if(mysqli_stmt_execute($stmt)){
                   
                    echo "<script>alert('Successfully signed up'); window.location.href='login.php';</script>";                  
                } 
                }else{
                // echo "<script>alert('Password does not match')</script>";
                $errorMessage = 'Password does not match';
            }
        }
    }
   }
    
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="register.css">
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .fade-in {
            animation: fadeIn 3s ease-in-out;
        }
        .error-message{
            background-color: red;
            color: white;
            font-size: 15px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body class="fade-in">
    <nav>
        <div class="logo-container">
            <img src="image/open-book.png" alt="">
            <h2>BOOK.LIB</h2>
        </div>
        <div class="link">
            <a href="login.php">Login</a>
        </div>
    </nav>
    <div class="box">
        <div class="container">
        <?php if (!empty($errorMessage)) : ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
            <h1>Create Account</h1>
            <form action="" method="post" onsubmit="return validatePassword();">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Name" required  value="<?php echo htmlspecialchars($name);?>">
                </div>
                <div class="form-group">
                    <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($username);?>">
                </div>
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email);?>">
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Password" required value="<?php echo htmlspecialchars($password);?>">
                </div>
                <div class="form-group">
                    <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required value="<?php echo htmlspecialchars($confirmpassword);?>">
                </div>
                <button type="submit" name="submit">Sign up</button>
            </form>
            <p>Already have an account? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script>
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmpassword = document.getElementById("confirmpassword").value;
        const passwordCriteria = /^[A-Za-z\d]{8,}$/; // Minimum 8 characters, letters, and numbers

        if (!password.match(passwordCriteria)) {
            alert("Password must be at least 8 characters long and include both letters and numbers.");
            return false;
        }

        if (password !== confirmpassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
       
    }
    document.body.classList.add('fade-in');
</script>

</body>
</html>
