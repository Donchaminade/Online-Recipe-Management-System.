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

// Fetch all recipes from the database
$sql = "SELECT recipeid, recipename, recipeimage, preparationtime, recipedescription, ingredients, steps FROM recipes";
$result = mysqli_query($conn, $sql);

// Check if the query executed successfully
if (!$result) {
    die("Error in query: " . mysqli_error($conn));
}

$recipes = [];
if (mysqli_num_rows($result) > 0) {
    // Fetch all recipes
    while ($row = mysqli_fetch_assoc($result)) {
        $recipes[] = $row;
    }
} else {
    echo "No recipes found.";
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Recipes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="searchpage.css"> 
</head>
<body>

<header class="header">

<nav class="navbar nav-1">
   <section class="flex">
      <a href="Home.html" class="logo"><i class="fas fa-house-circle-check"></i>Recipe</a>
   </section>
</nav>

<nav class="navbar nav-2">
   <section class="flex">

      <div class="menu">
         <ul>
            <li><a href="Rec.php">Add recipe <i class="fas fa-utensils"></i></a>
            </li>
            <li><a href="Searchpage.php">Reciepes <i class="fas fa-list"></i></a>
            </li>
            <li><a href="index1.php">Contact us <i class="fa-regular fa-address-book"></i></a>
            </li>
            <li><a href="FAQ.php">FAQ <i class="fas fa-question"></i></a></li>
         </ul>
      </div>

      <ul>
         <li><a href="#">Account <i class="fas fa-angle-down"></i></a>
            <ul>
               <li><a href="login.php">login</a></li>
               <li><a href="signin.php">register</a></li>
            </ul>
         </li>
      </ul>
   </section>

</nav>
</header>

<div class="container">
    <?php if (!empty($recipes)): ?>
        <?php foreach ($recipes as $recipe): ?>
            <div class="recipe-container">
                <h2><?php echo htmlspecialchars($recipe['recipename']); ?></h2>
                <div class="square-image">
                    <img src="<?php echo htmlspecialchars($recipe['recipeimage']); ?>" alt="Recipe Image">
                </div>
                <p>Preparation Time: <span class="highlight"><?php echo htmlspecialchars($recipe['preparationtime']); ?></span></p>
                <a href="http://localhost/IWT_MLB_01.02_09/reviewform.php?recipeid=<?php echo $recipe['recipeid']; ?>" class="view-recipe-button">View Recipe</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No recipes found.</p>
    <?php endif; ?>
</div>

<footer class="footer">

   <section class="flex">

      <div class="box">
         <a href="tel:1234567890"><i class="fas fa-phone"></i><span>1234567890</span></a>
         <a href="tel:0987654321"><i class="fas fa-phone"></i><span>0987654321</span></a>
         <a href="mailto:mailme@gmail.com"><i class="fas fa-envelope"></i><span>ark@gmail.com</span></a>
         <a href="#"><i class="fas fa-map-marker-alt"></i><span>Hindu College lane, Jaffna</span></a>
      </div>

      <div class="box">
         <a href="Home.html"><span>Home</span></a>
         <a href="index1.php"><span>Contact</span></a>
         <a href="Searchpage.php"><span>All listings</span></a>
      </div>

      <div class="box">
         <a href="#"><span>facebook</span><i class="fab fa-facebook-f"></i></a>
         <a href="#"><span>instagram</span><i class="fab fa-instagram"></i></a>
         <a href="#"><span>twitter</span><i class="fab fa-twitter"></i></a>
         <a href="#"><span>linkedin</span><i class="fab fa-linkedin"></i></a>
         <a href="#"><span>youtube</span><i class="fab fa-youtube"></i></a>
      </div>

   </section>

   <div class="credit"> Designed and deployed by <span>ARK</span> IT sector || &copy; all rights reserved </div>

</footer>

</body>
</html>
