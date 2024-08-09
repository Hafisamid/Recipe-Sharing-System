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

$recipeID = isset($_GET['id']) ? $_GET['id'] : '';

if ($recipeID) {
    $stmt = $conn->prepare("DELETE FROM Recipe WHERE RecipeID = ?");
    $stmt->bind_param("i", $recipeID);
    if ($stmt->execute()) {
        echo "<script>
                alert('Recipe Deleted Successfully');
                window.location.href = 'recipe.php';
              </script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
