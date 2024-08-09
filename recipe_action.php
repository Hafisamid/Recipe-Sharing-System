<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RecipeDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header('Location: login.php');
    exit();
}

$uploadDir = 'uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$action = isset($_GET['action']) ? $_GET['action'] : 'create';
$recipeID = isset($_POST['recipeID']) ? $_POST['recipeID'] : '';

$title = isset($_POST['title']) ? $_POST['title'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$ingredients = isset($_POST['ingredients']) ? $_POST['ingredients'] : '';
$instructions = isset($_POST['instructions']) ? $_POST['instructions'] : '';
$preparationTime = isset($_POST['preparationTime']) ? $_POST['preparationTime'] : '';
$cookingTime = isset($_POST['cookingTime']) ? $_POST['cookingTime'] : '';
$servings = isset($_POST['servings']) ? $_POST['servings'] : '';
$categoryID = isset($_POST['categoryID']) ? $_POST['categoryID'] : '';
$image = '';
$video = isset($_POST['video']) ? $_POST['video'] : '';

if (!empty($_FILES['image']['name'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        $image = $target_file;
    } else {
        echo "<script>
                alert('Sorry, there was an error uploading your image.');
                window.history.back();
              </script>";
        exit();
    }
}

if ($action == 'create') {
    $stmt = $conn->prepare("INSERT INTO Recipe (Title, Description, Ingredients, Instructions, PreparationTime, CookingTime, Servings, Image, Video, CategoryID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }
    $stmt->bind_param("ssssiisssi", $title, $description, $ingredients, $instructions, $preparationTime, $cookingTime, $servings, $image, $video, $categoryID);
} else if ($action == 'update' && $recipeID) {
    if ($image) {
        $stmt = $conn->prepare("UPDATE Recipe SET Title=?, Description=?, Ingredients=?, Instructions=?, PreparationTime=?, CookingTime=?, Servings=?, Image=?, Video=?, CategoryID=? WHERE RecipeID=?");
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ssssiisssii", $title, $description, $ingredients, $instructions, $preparationTime, $cookingTime, $servings, $image, $video, $categoryID, $recipeID);
    } else {
        $stmt = $conn->prepare("UPDATE Recipe SET Title=?, Description=?, Ingredients=?, Instructions=?, PreparationTime=?, CookingTime=?, Servings=?, Video=?, CategoryID=? WHERE RecipeID=?");
        if (!$stmt) {
            die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
        }
        $stmt->bind_param("ssssiissii", $title, $description, $ingredients, $instructions, $preparationTime, $cookingTime, $servings, $video, $categoryID, $recipeID);
    }
}

if ($stmt->execute()) {
    echo "<script>
            alert('Recipe " . ucfirst($action) . "d Successfully');
            window.location.href = 'recipe.php';
          </script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
