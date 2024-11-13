<?php
   include "config.php";


   if ($_SERVER["REQUEST_METHOD"] == "POST") {
   

    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    $password2 = isset($_POST['password2']) ? htmlspecialchars($_POST['password2']) : '';


    if ($password !== $password2) {
        header("Location: signin.php?error=Passwords+do+not+match");
        exit();
    }
    

    $stmt = $conn->prepare("INSERT INTO users (NAME, EMAIL, PASSWORD) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);


    if ($stmt->execute()) {




$stm = $conn->prepare("SELECT ID FROM users WHERE NAME = ? AND EMAIL= ? AND PASSWORD=? ");
$stm->bind_param("sss", $name, $email,$password);

$stm->execute();

$res = $stm->get_result();

if ($res->num_rows > 0) {

    $row = $res->fetch_assoc();
    $id = $row['ID'];

    header("Location: index.php?id=" . urlencode($id));
    exit();
} 


$stm->close();

 } 
   else {
        header("Location: signin.php?error=" . urlencode($stmt->error));
        exit();
    }

    $stmt->close();
    $conn->close();
}
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
    echo '<script>alert("' . $error . '");</script>';
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="signin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <title>Document</title>
</head>

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

<body>
    <div class="container">
        <div class="title">
            <h3>Sign In</h3>
        </div>
        <form action="signin.php" method="post">
            <div class="grp">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="grp">
                <label for="email">Email</label>
                <input type="email" id="email"  name="email" required>
            </div>
            <div class="grp">
                <label for="password">Password</label>
                <input type="text" id="password"  name="password" required>
            </div>
            <div class="grp">
                <label for="password2">Confirm-password</label>
                <input type="text" id="password2"  name="password2" required>
            </div>
            <center>
                <button class="btn">Submit</button>
            </center>
           
        </form>
    </div>



</script>

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