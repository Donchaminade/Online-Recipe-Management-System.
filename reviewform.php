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

// Get the recipe ID from the URL if available
if (isset($_GET['recipeid'])) {
    $recipeid = $_GET['recipeid'];
} else {
    die("Recipe ID not provided.");
}

// Fetch the recipe based on the recipe ID
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
    echo "No recipe found.";
}

// Check if a POST request is made to submit a review
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $rating = $_POST["rating"];
    $review = $_POST["review"];

    // Insert the review with the associated recipeid
    $sql = "INSERT INTO review (recipeid, username, rating, review) VALUES ('$recipeid', '$username', '$rating', '$review')";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
            alert('Review added successfully');
            window.location.href = 'http://localhost/IWT_MLB_01.02_09/readreview.php?recipeid=$recipeid';
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
    <title>Recipe and Review Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="container">

<a href="Searchpage.php"><button class="submit-button1">Back</button></a>

<?php if ($recipe): ?>
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

<!-- Review Form -->
<div class="review">
<h2>Add Review</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?recipeid=" . $recipeid); ?>" method="POST">
    <label for="username" class="form-label"><b>User Name: </b></label>
    <input type="text" id="username" name="username" class="form-input" placeholder="Enter your name" required><br>

    <label for="rating" class="form-label"><b>Rating: </b></label>
    <input type="number" id="rating" name="rating" min="0" max="5" class="form-input" placeholder="Rate 0 - 5" required><br>

    <label for="review" class="form-label"><b>Review: </b></label>
    <textarea id="review" name="review" class="form-input input-textarea" placeholder="Enter your comment" required></textarea><br>

    <button type="submit" class="submit-button">Submit</button>
</form>
</div>

</div>

</body>
</html>
