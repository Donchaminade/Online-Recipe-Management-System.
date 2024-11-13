<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Add Reciepe</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">


   <link rel="stylesheet" href="RecStyle.css">

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
            <li><a href="Searchpage.php">Reciepes<i class="fas fa-list"></i></a>
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



<section class="sell-intro">
    <div class="main-intro">
        <img src="Image/Rec1.jpg" alt="image">
        <div class="main-text">
            <h1 class="header-intro">Reciepe</h1>
            <h5><span>Import new recipe</span></h5>
            <p class="intro-text">Our online food recipe page offers a convenient platform for users to explore a variety of delicious dishes from around the world. It provides easy-to-follow instructions, ingredient lists, and cooking tips, catering to both beginners and experienced chefs. With a clean layout, beautiful images, and search functionality, users can quickly find recipes based on cuisine type, dietary preferences, or cooking time. Whether you’re looking to try something new or perfect a classic dish, an online recipe page serves as the perfect culinary guide at your fingertips.</p>
        </div>
    </div>
</section>




<section class="contact">

   <div class="row">
      <div class="image">
          <img src="Image/Rec2.jpg" alt="Food image">
      </div>
      <form id="recipeForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
    <h3>Share your recipe with us</h3>
    <label for="name">Enter the name:</label>
    <input type="text" name="name" id="name" required maxlength="50" placeholder="Name" class="box">
    
    <label for="ingredients">Enter the ingredients:</label>
    <input type="text" name="ingredients" id="ingredients" required maxlength="50" placeholder="Ingredients" class="box">
    
    <label for="description">Enter the description:</label>
    <input type="text" name="description" id="description" required maxlength="50" placeholder="Description" class="box">

    <label for="prep-hours">Preparation Time:</label>
    <div class="prep-time">
        <input type="number" name="prephours" id="prephours" min="0" max="24" placeholder="Hours" class="box" required>
        <input type="number" name="prepminutes" id="prepminutes" min="0" max="59" placeholder="Minutes" class="box" required>
    </div>
  
    <textarea name="process" placeholder="Enter the process" id="process" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
    
    <label for="image">Select Image:</label>
    <input type="file" name="image" id="image" accept="image/*" required>
    
    <input type="submit" value="Submit details" name="send" class="btn">
</form>

  </div>
 
 </section>







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

<script src="RecScript.js"></script>

</body>
</html>





<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "iwt";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Retrieve text inputs
   $name = $_POST["name"];
   $ingredients = $_POST["ingredients"];
   $description = $_POST["description"];
   $prephours = $_POST["prephours"];
   $prepminutes = $_POST["prepminutes"];
   $process = $_POST["process"];

   // Handle file upload (image)
   if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
       // File upload configuration
       $target_dir = "BackImage/";
       $target_file = $target_dir . basename($_FILES["image"]["name"]);
       $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

       // Check if file is an image
       $check = getimagesize($_FILES["image"]["tmp_name"]);
       if ($check !== false) {
           // Check file size (limit to 2MB)
           if ($_FILES["image"]["size"] <= 2000000) {
               // Allow only certain file formats
               if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                   // Upload the file
                   if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                       echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                       // Insert data into the database (recipe info + image name)
                       $image_name = basename($_FILES["image"]["name"]);
                       $sql = "INSERT INTO rec (name, ingredients, description, prephours, prepminutes, process, image_path) 
                               VALUES ('$name', '$ingredients', '$description', '$prephours', '$prepminutes', '$process', '$image_name')";

                       if (mysqli_query($conn, $sql)) {
                           echo "<script>
                                    alert('Recipe and image uploaded successfully!');
                                    window.location.href = 'http://localhost/IWT_MLB_01.02_09/RecRead.php';
                                    </script>";
                       } else {
                           echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                       }
                   } else {
                       echo "Sorry, there was an error uploading your file.";
                   }
               } else {
                   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
               }
           } else {
               echo "Sorry, your file is too large.";
           }
       } else {
           echo "File is not an image.";
       }
   } else {
       echo "Please select an image to upload.";
   }
}


mysqli_close($conn);
?>
