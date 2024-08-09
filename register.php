<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RecipeDB";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$uploadDir = 'uploads';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
    $bio = $_POST["bio"];
    $userType = $_POST["userType"];
    $profilePicture = "";

    if (!empty($_FILES["profilePicture"]["name"])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
        if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
            $profilePicture = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    $stmt = $conn->prepare("INSERT INTO User (Name, ProfilePicture, Bio, UserType, Password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $profilePicture, $bio, $userType, $password);

    if ($stmt->execute()) {
        echo "<script>
                alert('Register Successfully');
                window.location.href = 'login.php';
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
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="profilePicture">Profile Picture:</label>
            <input type="file" id="profilePicture" name="profilePicture">

            <label for="bio">Bio:</label>
            <textarea id="bio" name="bio" rows="4" cols="50"></textarea>

            <label for="userType">User Type:</label>
            <select id="userType" name="userType" required>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>

            <input type="submit" value="Register">
            <p>Don't have an account? <a href="login.php">Log In here</a>.</p>
        </form>
    </div>
</body>
</html>
