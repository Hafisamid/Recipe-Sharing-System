<?php
session_start();

if (isset($_POST['confirm_logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <link rel="stylesheet" href="styleslogout.css">
</head>
<body>
    <div class="logout-container">
        <h2>Are you sure you want to log out?</h2>
        <form method="POST">
            <button type="submit" name="confirm_logout" class="btn">Yes, Log Out</button>
            <a href="dashboard.php" class="btn">Cancel</a>
        </form>
    </div>
</body>
</html>
