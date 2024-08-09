<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

include('headeradmin.php');
$conn = new mysqli("localhost", "root", "", "RecipeDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch reviews from the Review table
$sql = "SELECT r.*, rec.Title AS RecipeTitle 
        FROM Review r 
        JOIN Recipe rec ON r.RecipeID = rec.RecipeID";
$reviewStmt = $conn->prepare($sql);

// Check if prepare() failed
if (!$reviewStmt) {
    die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
}

$reviewStmt->execute();
$reviewResult = $reviewStmt->get_result();
$reviews = $reviewResult->fetch_all(MYSQLI_ASSOC);
$reviewStmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews</title>
    <link rel="stylesheet" href="stylesreview2.css">
</head>
<body>
<div class="content">
    <div class="welcome-message">
        <h2>All Reviews</h2>
    </div>
    <div class="review-container">
        <?php foreach ($reviews as $review): ?>
        <div class="review-card">
            <h3><?php echo htmlspecialchars($review['RecipeTitle']); ?></h3>
            <p><strong>Reviewer:</strong> <?php echo htmlspecialchars($review['UserName']); ?></p>
            <p><strong>Rating:</strong> <?php echo htmlspecialchars($review['Rating']); ?>/5</p>
            <p><?php echo nl2br(htmlspecialchars($review['Comment'])); ?></p>
            <p><em><?php echo htmlspecialchars($review['ReviewDate']); ?></em></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
