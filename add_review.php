<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RecipeDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeID = $_POST['recipeID'];
    $userID = $_POST['UserID']; // Corrected from $_POST['UserID']
    $userName = $_POST['userName'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO Review (RecipeID, UserID, UserName, Rating, Comment) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("iisds", $recipeID, $userID, $userName, $rating, $comment); // Corrected parameter count and type specifiers

    if ($stmt->execute()) {
        echo "<script>
                alert('Review submitted successfully.');
                window.location.href = 'recipe_detail.php?id=$recipeID';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Add Review</title>
    <link rel="stylesheet" href="stylesreview.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
<div class="content">
    <h3>Add a Review</h3>
    <form action="add_review.php" method="POST">
        <input type="hidden" name="recipeID" value="<?php echo htmlspecialchars($_GET['recipeID']); ?>">
        <label for="userName">Name:</label>
        <input type="text" id="userName" name="userName" required>
        <label for="rating">Rating:</label>
        <div class="star-rating">
            <input type="radio" id="5-stars" name="rating" value="5" required /><label for="5-stars" class="fa fa-star"></label>
            <input type="radio" id="4-stars" name="rating" value="4" /><label for="4-stars" class="fa fa-star"></label>
            <input type="radio" id="3-stars" name="rating" value="3" /><label for="3-stars" class="fa fa-star"></label>
            <input type="radio" id="2-stars" name="rating" value="2" /><label for="2-stars" class="fa fa-star"></label>
            <input type="radio" id="1-star" name="rating" value="1" /><label for="1-star" class="fa fa-star"></label>
        </div>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" required></textarea>
        <input type="submit" value="Submit Review">
    </form>
</div>
</body>
</html>
