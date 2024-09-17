<?php
// session_start();

// require_once('config.php');
// if(!empty($_SESSION['id'])){
//     header("Location:mainpage.php");
// }

// if(isset($_POST['submit'])){
//     $usernameemail = $_POST['usernameemail'];
//     $password = $_POST['password'];
    
//     $select = mysqli_query($connection, "SELECT * FROM easyuser WHERE username='$usernameemail' OR email= '$usernameemail'");
//     $row = mysqli_fetch_assoc($select);
//     if(mysqli_num_rows($select)>0){
//         if($password == $row['password']){
//             $_SESSION['login'] = true;
//             $_SESSION['id'] = $row['id'];

//             header("Location:mainpage.php");
//         }else{
//             echo "<script>alert('Wrong password')</script>";
//         }
//     }else{
//         echo "<script>alert('user not registered')</script>";
//     }
// }

// require_once('config.php');
//     if(!empty($_SESSION['id'])){
//         header("Location:mainpage.php");
//     }
    
//     if(isset($_POST['submit'])){
//         $usernameemail = $_POST['usernameemail'];
//         $password = $_POST['password'];

//         $select = mysqli_query($connection, "SELECT * FROM easyuser WHERE username = '$usernameemail' OR email='$usernameemail'");
//         $fetch_row = mysqli_fetch_assoc($select);
//         if(mysqli_num_rows($select)> 0){
//             if($password == $fetch_row['password']){
//                 $_SESSION['Login'] = true;
//                 $_SESSION['id'] = $fetch_row['id'];
//                 header("Location:mainpage.php");
//             }else{
//                 echo "<script>alert('Wrong password')</script>";
//             }
//         }else{
//             echo "<script>alert('User not registered')</script>";
//         }
//     }

?>

<?php
// session_start();
// require_once('config.php');

// if (!empty($_SESSION['id'])) {
//     header("Location: mainpage.php");
//     exit;
// }

// if (isset($_POST['submit'])) {
//     $usernameemail = trim($_POST['usernameemail']);
//     $password = trim($_POST['password']);

//     if (empty($usernameemail) || empty($password)) {
//         echo "<script>alert('Please fill in all fields.')</script>";
//     } else {
//         $select_query = "SELECT * FROM easyuser WHERE username = ? OR email = ?";
//         $stmt = mysqli_prepare($connection, $select_query);
//         mysqli_stmt_bind_param($stmt, "ss", $usernameemail, $usernameemail);
//         mysqli_stmt_execute($stmt);
//         $result = mysqli_stmt_get_result($stmt);

//         if (mysqli_num_rows($result) > 0) {
//             $fetch_row = mysqli_fetch_assoc($result);
//             if (password_verify($password, $fetch_row['password'])) {
//                 $_SESSION['Login'] = true;
//                 $_SESSION['id'] = $fetch_row['id'];
//                 header("Location: mainpage.php");
//                 exit;
//             } else {
//                 echo "<script>alert('Wrong password')</script>";
//             }
//         } else {
//             echo "<script>alert('User not registered')</script>";
//         }
//         mysqli_stmt_close($stmt);
//     }
// }

?>
<?php
session_start();
require_once('config.php');

// Initialize error message
$errorMessage = '';

if (!empty($_SESSION['id'])) {
    header("Location: mainpage.php");
    exit;
}

// Initialize 
$usernameemail = '';
$password = '';
if (isset($_POST['submit'])) {
    $usernameemail = trim($_POST['usernameemail']);
    $password = trim($_POST['password']);

    if (empty($usernameemail) || empty($password)) {
        $errorMessage = 'Please fill up the input fields';
    } else {
        $select_query = "SELECT * FROM easyuser WHERE username = ? OR email = ?";
        $stmt = mysqli_prepare($connection, $select_query);
        mysqli_stmt_bind_param($stmt, "ss", $usernameemail, $usernameemail);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $fetch_row = mysqli_fetch_assoc($result);
            if (password_verify($password, $fetch_row['password'])) {
                $_SESSION['Login'] = true;
                $_SESSION['id'] = $fetch_row['id'];
                $_SESSION['username'] = $fetch_row['username']; // Store the username in session
                // header("Location: mainpage.php");
                echo "<script>alert('Login successfully');window.location.href='mainpage.php';</script>";
                exit;
            } else {
                $errorMessage = 'Wrong password';
            }
        } else {
            $errorMessage = 'User not registered';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
    <style>
        @keyframes fadeIn{
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .fade-in{
            animation: fadeIn 3s ease-in-out;
        }

        .error-message {
            color: white;
            font-size: 15px;
            margin-top: 10px;
            padding: 10px;
            background-color: red;
            text-align: center;
            font-family: monospace;
            border-radius: 5px;
            text-decoration: underline;
        }
    </style>
</head>
<body class="fade-in">
    
    <nav>
        <div class="logo-container">
        <img src="image/open-book.png" alt="">
        <h2>BOOK.<span>LIB</span></h2>
        </div>
        <div class="link">
            <a href="register.php">Register</a>
        </div>
    </nav>
    <div class="box">
    <div class="container">
          <?php if (!empty($errorMessage)) : ?>
            <div class="error-message"><?php echo htmlspecialchars($errorMessage); ?></div>
        <?php endif; ?>
        <form action="" method="post">
        <div class="form-logo-container">
        <img src="image/open-book.png" alt="" width="50px">
        <h1>BOOK.<span>LIB</span></h1>
        </div>
        <div class="form-group">
        <input type="text" name="usernameemail" placeholder="Username or Email" required value="<?php echo htmlspecialchars($usernameemail);?>">
        </div>
        <div class="form-group">
        <input type="password" name="password" placeholder="Password" required value="<?php echo htmlspecialchars($password);?>">
        </div>
        <button type="submit" name="submit">Login</button>
        <p>Don't have an account? <a href="register.php"> Register</a></p>
        </form>
        <!-- Display error message -->
      
    </div>
    </div>
</body>
</html>
