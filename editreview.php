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

// Check if reviewid is provided in the URL
if (isset($_GET['reviewid'])) {
    $reviewid = $_GET['reviewid'];

    // Fetch the current review details based on the reviewid
    $sql = "SELECT review.recipeid, review.username, review.rating, review.review, recipes.recipename, recipes.recipeimage, recipes.recipedescription, recipes.ingredients, recipes.steps, recipes.preparationtime 
            FROM review
            JOIN recipes ON review.recipeid = recipes.recipeid 
            WHERE review.reviewid = '$reviewid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Fetch review and recipe data
        $data = mysqli_fetch_assoc($result);
        $recipe = [
            'recipename' => $data['recipename'],
            'recipeimage' => $data['recipeimage'],
            'recipedescription' => $data['recipedescription'],
            'ingredients' => $data['ingredients'],
            'steps' => $data['steps'],
            'preparationtime' => $data['preparationtime'],
        ];
        $review = [
            'username' => $data['username'],
            'rating' => $data['rating'],
            'review' => $data['review'],
        ];
    } else {
        die("No review found for the provided review ID.");
    }
} else {
    die("Review ID not provided.");
}

// Handle form submission to update the review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $rating = $_POST["rating"];
    $reviewText = $_POST["review"]; // To avoid overwriting the review array key

    $sql = "UPDATE review 
            SET username = '$username', rating = '$rating', review = '$reviewText' 
            WHERE reviewid = '$reviewid'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Review updated successfully');
            window.location.href = 'http://localhost/IWT_MLB_01.02_09/readreview.php?recipeid=" . $data['recipeid'] . "';
          </script>";
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Review</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">
<?php if ($recipe): ?>
    <!-- Display the recipe details -->
    <div class="recipe-container">
        <h2><?php echo htmlspecialchars($recipe['recipename']); ?></h2>
        <img src="<?php echo htmlspecialchars($recipe['recipeimage']); ?>" alt="Recipe Image" width="200">
        <p><strong>Description:</strong> <?php echo htmlspecialchars($recipe['recipedescription']); ?></p>
        <p><strong>Ingredients:</strong> <?php echo htmlspecialchars($recipe['ingredients']); ?></p>
        <p><strong>Steps:</strong> <?php echo htmlspecialchars($recipe['steps']); ?></p>
        <p><strong>Preparation Time:</strong> <?php echo htmlspecialchars($recipe['preparationtime']); ?></p>
    </div>
<?php else: ?>
    <p>No recipe found.</p>
<?php endif; ?>

    <!-- Review Update Form -->
    <div class="review">
        <h2>Update Your Review</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?reviewid=$reviewid"; ?>" method="POST" id="review-form">
            <label for="username" class="form-label"><b>User Name: </b></label>
            <input type="text" id="username" name="username" class="form-input" value="<?php echo isset($review['username']) ? htmlspecialchars($review['username']) : ''; ?>" required><br>

            <label for="rating" class="form-label"><b>Rating: </b></label>
            <input type="number" id="rating" name="rating" class="form-input" min="0" max="5" value="<?php echo isset($review['rating']) ? htmlspecialchars($review['rating']) : ''; ?>" required><br>

            <label for="review" class="form-label"><b>Review: </b></label>
            <textarea id="review" name="review" class="form-input input-textarea" required><?php echo isset($review['review']) ? htmlspecialchars($review['review']) : ''; ?></textarea><br>

            <button type="submit" id="update" class="submit-button">Update</button>
        </form>
    </div>
</div>

</body>
</html>
