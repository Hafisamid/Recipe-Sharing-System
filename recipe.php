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

$stmt = $conn->prepare("SELECT * FROM Recipe");
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipes</title>
    <link rel="stylesheet" href="stylesrecipe.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="content">
    <div class="welcome-message">
        <h2>Recipes</h2>
    </div>
    <a href="recipe_form.php?action=create" class="btn btn-primary mb-3">Create New Recipe</a>
    <div class="table-container">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Ingredients</th>
                    <th>Instructions</th>
                    <th>Preparation Time</th>
                    <th>Cooking Time</th>
                    <th>Servings</th>
                    <th>Image</th>
                    <th>Video</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($recipe = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($recipe['Title']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['Description']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($recipe['Ingredients'])); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($recipe['Instructions'])); ?></td>
                    <td><?php echo htmlspecialchars($recipe['PreparationTime']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['CookingTime']); ?></td>
                    <td><?php echo htmlspecialchars($recipe['Servings']); ?></td>
                    <td>
                        <?php if ($recipe['Image']): ?>
                        <img src="<?php echo htmlspecialchars($recipe['Image']); ?>" alt="Recipe Image" class="img-thumbnail">
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($recipe['Video']): ?>
                        <?php
                        // Extract the YouTube video ID from the URL
                        parse_str(parse_url($recipe['Video'], PHP_URL_QUERY), $videoParams);
                        if (isset($videoParams['v'])) {
                            $youtubeID = htmlspecialchars($videoParams['v']);
                        ?>
                        <iframe width="100" height="100" src="https://www.youtube.com/embed/<?php echo $youtubeID; ?>" frameborder="0" allowfullscreen></iframe>
                        <?php
                        } else {
                            echo "Invalid YouTube URL";
                        }
                        ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="#" class="btn btn-warning btn-edit" data-id="<?php echo $recipe['RecipeID']; ?>">Edit</a>
                        <a href="recipe_delete.php?id=<?php echo $recipe['RecipeID']; ?>" onclick="return confirm('Are you sure you want to delete this recipe?');" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Recipe</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.btn-edit').click(function(){
        var recipeID = $(this).data('id');
        $.ajax({
            url: 'recipe_form.php?action=update',
            method: 'GET',
            data: { id: recipeID },
            success: function(data) {
                $('#editModal .modal-body').html(data);
                $('#editModal').modal('show');
            }
        });
    });
});
</script>
<?php
$stmt->close();
$conn->close();
include('footer.php');
?>
</body>
</html>
