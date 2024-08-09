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
    $userID = $user['UserID'];
    $_SESSION['UserID'] = $userID; // Store ownerID in session
} else {
    echo "User not found.";
    exit();
}

$userID = $_SESSION['UserID']; // Retrieve ownerID from session

// Output ownerID for debugging
echo "user ID: " . $userID;

$recipeID = isset($_GET['id']) ? $_GET['id'] : 0;

$stmt = $conn->prepare("SELECT * FROM Recipe WHERE RecipeID = ?");
$stmt->bind_param("i", $recipeID);
$stmt->execute();
$result = $stmt->get_result();
$recipe = $result->fetch_assoc();

if (!$recipe) {
    echo "Recipe not found.";
    exit();
}

// Extract the YouTube video ID from the URL
$youtubeID = '';
if ($recipe['Video']) {
    parse_str(parse_url($recipe['Video'], PHP_URL_QUERY), $videoParams);
    $youtubeID = isset($videoParams['v']) ? $videoParams['v'] : '';
}

$userName = $_SESSION['name'];

// Fetch reviews for the recipe
$reviewStmt = $conn->prepare("SELECT * FROM Review WHERE RecipeID = ?");
$reviewStmt->bind_param("i", $recipeID);
$reviewStmt->execute();
$reviewResult = $reviewStmt->get_result();
$reviews = $reviewResult->fetch_all(MYSQLI_ASSOC);

$reviewStmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($recipe['Title']); ?></title>
    <link rel="stylesheet" href="stylesrecipedetail.css">
    <script src="https://www.youtube.com/iframe_api"></script>
</head>
<body>
<div class="content">
    <div class="recipe-detail">
        <h2><?php echo htmlspecialchars($recipe['Title']); ?></h2>
        <div class="recipe-image-container">
            <?php if ($recipe['Image']): ?>
                <img src="<?php echo htmlspecialchars($recipe['Image']); ?>" alt="Recipe Image">
            <?php else: ?>
                <img src="default-image.png" alt="Default Recipe Image">
            <?php endif; ?>
        </div>
        <div class="recipe-info">
            <p><strong>Description:</strong> <?php echo htmlspecialchars($recipe['Description']); ?></p>
            <div class="section-container">
                <h3>Ingredients:</h3>
                <p><?php echo nl2br(htmlspecialchars($recipe['Ingredients'])); ?></p>
            </div>
            <div class="section-container">
                <h3>Instructions:</h3>
                <p><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></p>
            </div>
            <p><strong>Preparation Time:</strong> <?php echo htmlspecialchars($recipe['PreparationTime']); ?> minutes</p>
            <p><strong>Cooking Time:</strong> <?php echo htmlspecialchars($recipe['CookingTime']); ?> minutes</p>
            <p><strong>Servings:</strong> <?php echo htmlspecialchars($recipe['Servings']); ?></p>
            <?php if ($youtubeID): ?>
                <div class="recipe-video-container">
                    <div id="player"></div>
                    <div class="video-buttons">
                        <br></br>
                        <button id="startRecognition" class="btn btn-primary" disabled>Enable Voice Commands</button>
                        <button id="playButton" class="btn">Play</button>
                        <button id="stopButton" class="btn">Stop</button>
                        <button id="continueButton" class="btn">Continue</button>
                    </div>
                    <div id="playCountContainer">
                        <p>Video has been played <span id="playCount">0</span> times.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Reviews Container -->
   <!-- Reviews Section -->
<div class="reviews-container">
    <h3>Reviews</h3>
    <?php if (!empty($reviews)): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <p><strong>User: <?php echo htmlspecialchars($review['UserName']); ?></strong></p>
                <p><strong>Rating: <?php echo htmlspecialchars($review['Rating']); ?>/5</strong></p>
                <p><?php echo nl2br(htmlspecialchars($review['Comment'])); ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>
<div class="reviews">
        <h3>Add a Review</h3>
        <form action="add_review.php" method="POST">
            <input type="hidden" name="recipeID" value="<?php echo $recipeID; ?>">
            <input type="hidden" name="UserID" value="<?php echo $userID; ?>"> <!-- Add the hidden field for UserID -->
            <label for="userName">Name:</label>
            <input type="text" id="userName" name="userName" value="<?php echo htmlspecialchars($userName); ?>" required readonly>
            <!-- Automatically fill the name field with the logged-in user's name and make it readonly -->
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
</div>
<?php
$stmt->close();
$conn->close();
include('footer.php');
?>
<script>
    let player;
    let playerReady = false;
    let playCount = 0;

    function onYouTubeIframeAPIReady() {
        player = new YT.Player('player', {
            height: '360',
            width: '640',
            videoId: '<?php echo htmlspecialchars($youtubeID); ?>',
            events: {
                'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

    function onPlayerReady(event) {
        playerReady = true;
        document.getElementById('startRecognition').disabled = false;
        console.log('YouTube player is ready');
    }

    function onPlayerStateChange(event) {
        if (event.data === YT.PlayerState.PLAYING && event.target.getCurrentTime() === 0) {
            playCount++;
            document.getElementById('playCount').innerText = playCount;
        }
    }

    function initYouTubePlayer() {
        if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
            setTimeout(initYouTubePlayer, 100);
        } else {
            onYouTubeIframeAPIReady();
        }
    }

    function checkPlayer() {
        if (!player || typeof player.playVideo !== 'function' || typeof player.pauseVideo !== 'function' || typeof player.seekTo !== 'function') {
            console.error('YouTube player not properly initialized. Retrying...');
            setTimeout(checkPlayer, 100);
        } else {
            console.log('YouTube player initialized successfully.');
            document.getElementById('startRecognition').disabled = false;
        }
    }

    document.addEventListener('DOMContentLoaded', (event) => {
        const startButton = document.getElementById('startRecognition');
        const playCmdButton = document.getElementById('playButton');
        const stopCmdButton = document.getElementById('stopButton');
        const continueCmdButton = document.getElementById('continueButton');

        if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
            console.error('Speech recognition not supported in this browser.');
            return;
        }

        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'en-US';
        recognition.continuous = true;
        recognition.interimResults = false;

        function resetButtonColors() {
            playCmdButton.style.backgroundColor = '';
            stopCmdButton.style.backgroundColor = '';
            continueCmdButton.style.backgroundColor = '';
        }

        startButton.addEventListener('click', () => {
            console.log('Starting speech recognition');
            recognition.start();
            startButton.disabled = true;
        });

        recognition.onresult = (event) => {
            const transcript = event.results[event.results.length - 1][0].transcript.trim().toLowerCase();
            console.log('Transcript:', transcript); // Debug log
            resetButtonColors();
            if (!playerReady) {
                console.error('Player is not ready');
                return;
            }
            if (transcript.includes('play')) {
                console.log('Play command detected');
                if (typeof player.seekTo === 'function') {
                    player.seekTo(0);
                    player.playVideo();
                    playCmdButton.style.backgroundColor = '#2196F3'; // Blue
                } else {
                    console.error('seekTo function is not available');
                }
            } else if (transcript.includes('stop')) {
                console.log('Stop command detected');
                if (typeof player.pauseVideo === 'function') {
                    player.pauseVideo();
                    stopCmdButton.style.backgroundColor = '#FF9800'; // Orange
                } else {
                    console.error('pauseVideo function is not available');
                }
            } else if (transcript.includes('continue')) {
                console.log('Continue command detected');
                if (typeof player.playVideo === 'function') {
                    player.playVideo();
                    continueCmdButton.style.backgroundColor = '#2196F3'; // Blue
                } else {
                    console.error('playVideo function is not available');
                }
            } else {
                console.log('Command not recognized');
            }
        };

        recognition.onerror = (event) => {
            console.error('Speech recognition error:', event.error); // Debug log
            if (event.error === 'no-speech') {
                console.error('No speech was detected. Try again.');
            }
        };

        recognition.onend = () => {
            console.log('Speech recognition service disconnected');
            startButton.disabled = false;
        };

        initYouTubePlayer();
        checkPlayer();
    });
</script>
</body>
</html>
