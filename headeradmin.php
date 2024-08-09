<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheader.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="nav-bar">
        <div class="nav-left">
            <h1> Michelin Star <i class="fas fa-star"></i></h1>
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="dashboardadmin.php"><i class="fas fa-home"></i> Home</a></li>
                <li><a href="recipe.php"><i class="fas fa-utensils"></i> Recipes</a></li>
                <li><a href="aboutadmin.php"><i class="fas fa-info-circle"></i> About</a></li>
                <li><a href="review.php"><i class="fas fa-star"></i> Review</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </div>
    <div class="content">
