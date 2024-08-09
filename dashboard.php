<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('header.php');
$conn = new mysqli("localhost", "root", "", "RecipeDB");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and is a staff member
if (!isset($_SESSION['name'])) {
    header("Location: dashboard.php");
    exit();
}

// Fetch user information from the database
$name = $_SESSION['name'];
$sql = "SELECT * FROM user WHERE name = '$name'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    // Fetch ownerID from the fetched user data
    $UserID = $user['UserID'];
    $_SESSION['UserID'] = $UserID; // Store ownerID in session
} else {
    echo "User not found.";
    exit();
}

// Retrieve user ID from session
$UserID = $_SESSION['UserID'];

// Fetch user profile picture and bio
$stmt = $conn->prepare("SELECT ProfilePicture, Bio FROM User WHERE Name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Fetch total review count made by the user
$sql = "SELECT COUNT(*) AS TotalReviews FROM Review WHERE UserID = $UserID";
$result = $conn->query($sql);
$totalReviews = 0; // Initialize total reviews count

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalReviews = $row['TotalReviews'];
}

// Fetch average rating of reviews made by the user
$sql = "SELECT AVG(Rating) AS AverageRating FROM Review WHERE UserID = $UserID";
$result = $conn->query($sql);
$averageRating = 0; // Initialize average rating

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $averageRating = round($row['AverageRating'], 2); // Round to 2 decimal places
}

// Fetch count of reviews per category for the user
$sql = "SELECT c.Name AS CategoryName, COUNT(r.ReviewID) AS ReviewCount
        FROM Review r
        JOIN Recipe rec ON r.RecipeID = rec.RecipeID
        JOIN Category c ON rec.CategoryID = c.CategoryID
        WHERE r.UserID = $UserID
        GROUP BY c.Name";
$result = $conn->query($sql);

$categoryData = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categoryData[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="stylesdashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
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
        <div class="stats-container">
            <p>Total Reviews Made by User: <?php echo $totalReviews; ?></p>
            <p>Average Rating Given by User: <?php echo $averageRating; ?></p>
        </div>
    </div>
    <div class="chart-container" style="width: 50%; margin: auto;">
        <canvas id="categoryChart"></canvas>
    </div>
</div>
<?php include('footer.php'); ?>

<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryData = <?php echo json_encode($categoryData); ?>;

        const labels = categoryData.map(data => data.CategoryName);
        const data = categoryData.map(data => data.ReviewCount);

        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Reviews per Category',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.raw;
                                return label;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
</body>
</html>
