<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RecipeDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM User WHERE Name = ?");
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['name'] = $name;
            $_SESSION['userType'] = $user['UserType'];
            if ($user['UserType'] == 'Admin') {
                echo "<script>
                        alert('Log In Successful');
                        window.location.href = 'dashboardadmin.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Log In Successful');
                        window.location.href = 'dashboard.php';
                      </script>";
            }
            exit();
        } else {
            echo "<script>alert('Invalid login credentials: Incorrect password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid login credentials: User not found.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styleslogin.css">
</head>
<body>
    <div class="container">
   
        <div class="welcome-container">
            <h1>Welcome!</h1>
            <img src="animation/giphy.gif" alt="" width="200" height="190" style="display: block; margin-left: auto; margin-right: auto;">
          <!--  <div class="animation">
                <span>✨</span>
                <span>🌟</span>
                <span>🌠</span>
            </div>-->
            <p>Welcome to our website. Please log in to learn and get to know various easy dish that we can make.</p>
        </div>
        <div class="login-container">
            <h1>Login</h1>
            <form action="login.php" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <input type="submit" value="Login">
                <p>Don't have an account? <a href="register.php">Register here</a>.</p>
            </form>
        </div>
    </div>
</body>
</html>


