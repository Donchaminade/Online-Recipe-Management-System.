<?php 
include 'config1.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form inputs
    $name = $conn->real_escape_string(trim($_POST['name']));
    $phone = $conn->real_escape_string(trim($_POST['phone']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Basic validation
    if (empty($name) || empty($phone) || empty($email) || empty($message)) {
        echo '<script>alert("Please fill in all fields!");</script>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<script>alert("Invalid email format!");</script>';
    } else {
        // Insert the data into the database
        $sql = "INSERT INTO customers (NAME, EMAIL, PHONENUMBER, MESSAGE) 
                VALUES ('$name', '$email', '$phone', '$message')";
        
        if ($conn->query($sql)) {
            echo '<script>
                    alert("Data saved successfully!");
                    window.location.href = "https://localhost/IWT_MLB_01.02_09/index1.php";
                  </script>';
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Contact Us</title>
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

    <div class="contact-container">
        <h2 class="contact-title">Contact Us</h2>
        <div class="form-container">
            <div class="form-card">
                <h3 class="form-header">Send Us</h3>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="email" name="email" placeholder="Email address" required>
                    <input type="tel" name="phone" placeholder="Phone number" required>
                    <textarea name="message" placeholder="Message" required></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
            <div class="contact-info">
                <h3>Contact Information</h3>
                <div class="contact-item">
                    <img src="download.png" width="20" height="20" alt="Phone">
                    <a href="tel:+1234567890">+1 234-567-890</a>
                </div>
                <div class="contact-item">
                    <img src="download (1).png" width="20" height="20" alt="Email">
                    <a href="mailto:your-email@example.com">your-email@example.com</a>
                </div>
                <div class="contact-item">
                    <img src="download (2).png" width="20" height="20" alt="Location">
                    <a href="https://maps.google.com/?q=40.7128,-74.0060" target="_blank">121 street, Kandy road, Sri Lanka</a>
                </div>
            </div>
        </div>
    </div>
    <script src="contactus.js"></script>

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
