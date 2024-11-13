<?php
// Establish a connection to the MySQL database
$host = "localhost";
$username = "root";
$password = "";
$database = "iwt";

// Create a connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the recipe ID from the URL
if (isset($_GET['recipeid'])) {
    $recipeid = $_GET['recipeid'];
} else {
    die("Recipe ID not provided.");
}

// Fetch the recipe details for the given recipe ID
$sql = "SELECT recipeid, recipename, recipeimage, preparationtime, recipedescription, ingredients, steps 
        FROM recipes WHERE recipeid = '$recipeid'";
$result = mysqli_query($conn, $sql);

// Check if the query executed successfully
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

$recipe = null;
if (mysqli_num_rows($result) > 0) {
    // Fetch the recipe details
    $recipe = mysqli_fetch_assoc($result);
} else {
    die("No recipe found with the given Recipe ID.");
}

// Fetch the reviews for the specific recipe ID
$reviews = [];
$sql = "SELECT reviewid, username, rating, review 
        FROM review WHERE recipeid = '$recipeid' ORDER BY reviewid DESC LIMIT 1";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
} else {
    $reviews = null; // No reviews for this recipe
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
<?php if ($recipe): ?>
    <!-- Display the recipe details -->
    <div class="recipe-container">
        <h2><?php echo htmlspecialchars($recipe['recipename']); ?></h2>
        <img src="<?php echo htmlspecialchars($recipe['recipeimage']); ?>" alt="Recipe Image" width="200">
        <p><strong class="label">Description:</strong></p>
        <p><span class="highlight"><?php echo htmlspecialchars($recipe['recipedescription']); ?></span></p>
        <p><strong class="label">Ingredients:</strong></p>
        <p><span class="highlight"><?php echo htmlspecialchars($recipe['ingredients']); ?></span></p>
        <p><strong class="label">Steps:</strong></p>
        <p><span class="highlight"><?php echo htmlspecialchars($recipe['steps']); ?></span></p>
        <p><strong class="label">Preparation Time:</strong></p>
        <p><span class="highlight"><?php echo htmlspecialchars($recipe['preparationtime']); ?></span></p>
    </div>
<?php else: ?>
    <p>No recipe found.</p>
<?php endif; ?>

<!-- Review Section -->
<div class="review">
    <h2>Your latest review</h2>
    <?php if ($reviews): ?>
        <?php foreach ($reviews as $review): ?>
                <p><strong>User Name:</strong> <span class ="reviewername"><?php echo htmlspecialchars($review['username']); ?></span></p>
                <p><strong>Rating:</strong> <span class ="reviewstar"><?php echo str_repeat('★', $review['rating']) . str_repeat('☆', 5 - $review['rating']); ?></span></p>
                <p><strong>Review:</strong> <span class="reviewcomment"><?php echo htmlspecialchars($review['review']); ?></span></p>
                <a class="a1" href="deleteReview.php?recipeid=<?php echo $recipeid; ?>&reviewid=<?php echo $review['reviewid']; ?>" onclick="return confirm('Are you sure you want to delete this review?');">
                <button type="button">Delete</button>
                </a>
                <a class="a1" href="editreview.php?reviewid=<?php echo $review['reviewid']; ?>" onclick="return confirm('Are you sure you want to edit this review?');">
                    <button type="button">Edit</button>
                </a>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews added yet for this recipe.</p>
        <a href="reviewform.php?recipeid=<?php echo $recipeid; ?>">
            <button type="button">Add a Review</button>
        </a>
    <?php endif; ?>
</div>

</div>

</body>
</html>
