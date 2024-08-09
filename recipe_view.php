<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

include('header.php');
$conn = new mysqli("localhost", "root", "", "RecipeDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories
$categoryStmt = $conn->prepare("SELECT * FROM Category");
$categoryStmt->execute();
$categoryResult = $categoryStmt->get_result();
$categories = $categoryResult->fetch_all(MYSQLI_ASSOC);
$categoryStmt->close();

// Fetch recipes based on category filter
$categoryID = isset($_GET['category']) ? intval($_GET['category']) : 0;
if ($categoryID > 0) {
    $recipeStmt = $conn->prepare("SELECT * FROM Recipe WHERE CategoryID = ?");
    $recipeStmt->bind_param("i", $categoryID);
} else {
    $recipeStmt = $conn->prepare("SELECT * FROM Recipe");
}
$recipeStmt->execute();
$recipeResult = $recipeStmt->get_result();
$recipes = $recipeResult->fetch_all(MYSQLI_ASSOC);
$recipeStmt->close();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipes</title>
    <link rel="stylesheet" href="stylesrecipeview.css">
</head>
<body>
<div class="content">
    <div class="welcome-message">
        <h2>View Recipes</h2>
    </div>
    <form class="filter-form" action="recipe_view.php" method="GET">
        <label for="category">Filter by Category:</label>
        <select id="category" name="category">
            <option value="0">All</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?php echo $category['CategoryID']; ?>" <?php echo ($categoryID == $category['CategoryID']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($category['Name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filter</button>
    </form>

    <div class="card-container">
        <?php foreach ($recipes as $recipe): ?>
        <div class="card">
            <div class="card-image">
                <?php if ($recipe['Image']): ?>
                <img src="<?php echo htmlspecialchars($recipe['Image']); ?>" alt="Recipe Image">
                <?php else: ?>
                <img src="default-image.png" alt="Default Recipe Image">
                <?php endif; ?>
            </div>
            <div class="card-content">
                <h3><?php echo htmlspecialchars($recipe['Title']); ?></h3>
                <p><?php echo htmlspecialchars($recipe['Description']); ?></p>
                <a href="recipe_detail.php?id=<?php echo $recipe['RecipeID']; ?>" class="btn btn-primary">View Details</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
