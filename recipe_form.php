<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$action = isset($_GET['action']) ? $_GET['action'] : 'create';
$recipeID = isset($_GET['id']) ? $_GET['id'] : '';

$title = '';
$description = '';
$ingredients = '';
$instructions = '';
$preparationTime = '';
$cookingTime = '';
$servings = '';
$image = '';
$video = '';
$categoryID = '';

$conn = new mysqli("localhost", "root", "", "RecipeDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($action == 'update' && $recipeID) {
    $stmt = $conn->prepare("SELECT * FROM Recipe WHERE RecipeID = ?");
    $stmt->bind_param("i", $recipeID);
    $stmt->execute();
    $result = $stmt->get_result();
    $recipe = $result->fetch_assoc();

    $title = $recipe['Title'];
    $description = $recipe['Description'];
    $ingredients = $recipe['Ingredients'];
    $instructions = $recipe['Instructions'];
    $preparationTime = $recipe['PreparationTime'];
    $cookingTime = $recipe['CookingTime'];
    $servings = $recipe['Servings'];
    $image = $recipe['Image'];
    $video = $recipe['Video'];
    $categoryID = $recipe['CategoryID'];

    $stmt->close();
}

// Fetch categories
$categories = [];
$categoryStmt = $conn->prepare("SELECT * FROM Category");
$categoryStmt->execute();
$categoryResult = $categoryStmt->get_result();
while ($row = $categoryResult->fetch_assoc()) {
    $categories[] = $row;
}
$categoryStmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($action); ?> Recipe</title>
    <link rel="stylesheet" href="stylesrecipeform.css">
</head>
<body>
    <div class="container">
        <h1><?php echo ucfirst($action); ?> Recipe</h1>
        <form action="recipe_action.php?action=<?php echo $action; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="recipeID" value="<?php echo $recipeID; ?>">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50"><?php echo htmlspecialchars($description); ?></textarea>

            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" rows="4" cols="50"><?php echo htmlspecialchars($ingredients); ?></textarea>

            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" rows="4" cols="50"><?php echo htmlspecialchars($instructions); ?></textarea>

            <label for="preparationTime">Preparation Time (minutes):</label>
            <input type="number" id="preparationTime" name="preparationTime" value="<?php echo htmlspecialchars($preparationTime); ?>" required>

            <label for="cookingTime">Cooking Time (minutes):</label>
            <input type="number" id="cookingTime" name="cookingTime" value="<?php echo htmlspecialchars($cookingTime); ?>" required>

            <label for="servings">Servings:</label>
            <input type="number" id="servings" name="servings" value="<?php echo htmlspecialchars($servings); ?>" required>

            <label for="category">Category:</label>
            <select id="category" name="categoryID" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['CategoryID']; ?>" <?php echo $categoryID == $category['CategoryID'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($category['Name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <?php if ($image): ?>
                <img src="<?php echo htmlspecialchars($image); ?>" alt="Recipe Image" style="width:100px;">
            <?php endif; ?>

            <label for="video">YouTube Video URL:</label>
            <input type="text" id="video" name="video" value="<?php echo htmlspecialchars($video); ?>" placeholder="https://www.youtube.com/watch?v=example">

            <input type="submit" value="<?php echo ucfirst($action); ?> Recipe">
        </form>
    </div>
</body>
</html>
