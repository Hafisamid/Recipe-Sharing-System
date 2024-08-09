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

$name = $_SESSION['name'];
$stmt = $conn->prepare("SELECT ProfilePicture, Bio FROM User WHERE Name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<link rel="stylesheet" href="stylesdashboard.css">
<div class="content">
    <div class="welcome-message">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
    </div>
    <?php if (!empty($user['ProfilePicture'])): ?>
        <img src="<?php echo htmlspecialchars($user['ProfilePicture']); ?>" alt="Profile Picture" class="profile-picture">
    <?php else: ?>
        <img src="default-profile.png" alt="Default Profile Picture" class="profile-picture">
    <?php endif; ?>
    <br>
    <div class="profile-info">
        <p class="bio"><?php echo htmlspecialchars($user['Bio']); ?></p>
    </div>
    <div class="dashboard-info">
        <p>This is your dashboard where you can manage your recipes and more.</p>
    </div>
</div>
<?php include('footer.php'); ?>
