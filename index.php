<?php
include "config.php"; // Ensure you have your database connection here

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $idno = htmlspecialchars($_GET['id']);
} else {
    die("No ID parameter found in the URL.");
}

// Fetch the user details for the given ID
$sql = "SELECT * FROM users WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idno); // Assuming ID is an integer
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    $row = $res->fetch_assoc();
    // Pre-fill the form fields with user data
    $name = $row['NAME'];
    $email = $row['EMAIL'];
    $phonenumber = $row['PHONENO'];
    $work = $row['WORK'];
    $description = $row['DESCRIPTION'];
    $review = $row['REVIEW'];
    $image=$row['image'];
} else {
    die("User not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['updatename']) ? htmlspecialchars($_POST['updatename']) : '';
    $updateid = isset($_POST['updateid']) ? htmlspecialchars($_POST['updateid']) : '';
    $work = isset($_POST['work']) ? htmlspecialchars($_POST['work']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    $phoneno = isset($_POST['phoneno']) ? htmlspecialchars($_POST['phoneno']) : '';

    $updatesql = "UPDATE users SET NAME = ?, WORK = ?, DESCRIPTION = ?, PHONENO = ? WHERE ID = ?";
    $stmt = $conn->prepare($updatesql);
    
    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("ssssi", $name, $work, $description, $phoneno, $updateid);
    
    if ($stmt->execute()) {
        echo "Record updated successfully.";
        header("Location: index.php?id=" . urlencode($updateid) . "&message=" . urlencode("Profile updated successfully."));
        exit();
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="editprofile.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Edit Profile</title>
   
</head>

<body class="body">

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
    <div class="container">
        <div class="ccontainer">
            <button onclick="back()" class="back" style="position:absolute;top:70px;right:-195px; padding:8px 14px;background-color:rgba(170, 29, 29, 0.678);border:none; border-radius:4px;">X</button>
            <form action="" method="post" class="form" style="background:linear-gradient(#aaa,black 60%)"> <!-- Form action is now empty for the same page submission -->
                <div class="grp">
                    <div class="profilepic">
                        <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Profile Picture">

                    </div>

<!-- 
............................................................... -->


                    
                </div>
                <div class="grp2">
                    <input type="hidden" name="updateid" value="<?php echo htmlspecialchars($idno); ?>">
                    <div class="input-grp">
                        <label for="updatename">Name</label>
                        <input type="text" name="updatename" value="<?php echo htmlspecialchars($name); ?>" required>
                    </div>
                    <div class="input-grp">
                        <label for="work">Profession</label>
                        <input type="text" name="work" value="<?php echo htmlspecialchars($work); ?>" required>
                    </div>
                    <div class="input-grp">
                        <label for="phoneno">Phone Number</label>
                        <input type="text" name="phoneno" value="<?php echo htmlspecialchars($phonenumber); ?>" required>
                    </div>
                    <div class="input-grp">
                        <label for="description">Description</label>
                        <textarea rows='5' cols='40' name="description" required  style="font-size:1rem;color:grey";><?php echo htmlspecialchars($description); ?></textarea>
                    </div>
                    <button type="submit" style="padding:5px 20px; color:blue;font-size:0.8rem;background:color:#aaa;">Submit</button>
                </div>
            </form>
        </div>

        <div class="profile">
            <!-- <div class="image">
                <img src="student1.jpg" alt="Profile Picture">
            </div> -->

  <!-- ................................................           -->
  <div class="image">
                <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Profile Picture">
            </div>



  <form action="image.php" method="post" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($idno); ?>">
    <input type="file" name="image" required  style="width:20%; display: inline;margin-top:10px; padding: 5px 10px; color: white; background-color: #4CAF50; border: none;border-radius: 5px; font-family: Arial, sans-serif; cursor: pointer;">
    <input type="submit" value="Submit" style="padding: 5px 10px;background-color: #B0C4DE;border:none;border-radius:4px;">
  </form>



  <!-- ................................................................ -->
            <div class="work">
                <h4 class="title">Work <span>--------------------------------</span></h4>
                <p>
                    <h4 class="work-para">Work in <?php echo htmlspecialchars($work); ?></h4>
                    <h4 class="work-para">Migrate to America</h4>
                </p>
            </div>
            <div class="description">
                <h4 class="title">Description <span>-------------------------</span></h4>
                <p class="para" style="max-width:50%"><?php echo htmlspecialchars($description); ?></p>
            </div>
        </div>
        <div class="contact-details">
            <h2><?php echo htmlspecialchars($name); ?></h2>
            <button class="btn" onclick="load()">Edit profile</button>
            <button class="btn" style="background-color:red" onclick="redirectToPage(<?php echo htmlspecialchars($idno); ?>)">Delete My account</button>
            <div class="email">
                <div class="item1"><h4 class="h4">Email :</h4> <span><?php echo htmlspecialchars($email); ?></span></div>
                <div class="item1"><h4 class="h4">Phone No:</h4> <span><?php echo htmlspecialchars($phonenumber); ?></span></div>
            </div>
            <div class="card-container">
                <h4 class="title">Saved recipes <span>-----------------------</span></h4> 
                <div style="display:flex; gap:10px" >

                <div class="card-items">
                    <div class="card">
                        <div class="card-img" style="border:1px solid #aaa;overflow:none; min-height:100px;">
                            <img src="food1.jpg" alt="Recipe Image">
                        </div>
                        <div class="card-details">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-description">card description</p>
                        </div>
                    </div>
                    <!-- Repeat other card items as needed -->
                </div>

                <div class="card-items">
                    <div class="card">
                        <div class="card-img" style="border:1px solid #aaa;overflow:none;min-height:100px;background-size:cover;">
                            <img src="food2.jpg" alt="Recipe Image">
                        </div>
                        <div class="card-details">
                            <h4 class="card-title">Card title</h4>
                            <p class="card-description">card description</p>
                        </div>
                    </div>
                    <!-- Repeat other card items as needed -->
                </div>




                </div>
                
                
            </div>
            <?php include "review.html"; ?>
        </div>

        
        <input type="hidden" id="review" value="<?php echo htmlspecialchars($review); ?>">

        <script src="script.js"></script>
        <script>
            // Prevent form resubmission on refresh
            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);
            }

            function load() {
                const container = document.querySelector(".ccontainer");
                container.style.left = '50%';
                document.querySelector(".body").style.backgroundColor = "#00000050";
            }

            function back() {
                const container = document.querySelector(".ccontainer");
                container.style.left = '-50%';
                document.querySelector(".body").style.backgroundColor = "rgb(204, 204, 204, 0.5)";
            }



            


      function redirectToPage(id) {
    
    var value = confirm("Do you want to delete your account?");

if (value) {
    
    window.location.href = 'deleteaccount.php?id=' + id;
} else {
    // User clicked "Cancel", do nothing
    return;
}
    
      }






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
