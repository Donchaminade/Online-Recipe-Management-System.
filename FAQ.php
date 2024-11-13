<?php

include "config.php"; // Include your database connection file

// Fetch all FAQs from the 'faq' table
$sql = "SELECT * FROM faq";
$res = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userQuestion = htmlspecialchars($_POST['question']); // Sanitize input
    $ans = "No answer"; // Default answer

    // Insert user's question and default answer into the database
    $sql = "INSERT INTO faq (QUESTIONS, ANSWERS) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $userQuestion, $ans);

    if ($stmt->execute()) {
        echo "Your question has been submitted successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="faqstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>FAQ Page</title>
</head>
<body>

<!-- Header Section -->
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

<!-- FAQ Form and Display Section -->
<div class="faq-body">
    <div class="faq-header">
        <h2>Frequently Asked Questions</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="faq-input">
                <textarea name="question" placeholder="Please enter your question" required style="width: 80%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); font-size: 16px; resize: vertical; margin-bottom: 10px;"></textarea>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <div class="faq-content">
        <div class="support">
            <h3>Need Support?</h3>
            <p>If you found any bugs, please report them through our contact us page.</p>
            <a href="#" class="contact">Contact Us</a>
        </div>

        <div class="questions">
            <h3>Top Frequently Asked Questions</h3>

            <?php
            if ($res->num_rows > 0) {
                $i = 0;
                while ($row = $res->fetch_assoc()) {
                    $i++;
                    ?>
                    <div class="faq-item">
                        <h5 class="faq-question" onclick="toggleAnswer(this)">
                            <?php echo $i . ". " . htmlspecialchars($row["QUESTIONS"]); ?>
                            <span class="toggle-icon">+</span>
                        </h5>
                        <p class="faq-answer"><?php echo htmlspecialchars($row["ANSWERS"]); ?></p>
                        <div style="display: flex; gap: 5px;">
                            <form action="edit.php" method="get">
                                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" class="edit-btn">Edit</button>
                            </form>

                            <form action="delete.php" method="get" onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                <button type="submit" class="delete-btn">Delete</button>
                            </form>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>No FAQs available.</p>";
            }

            $conn->close();
            ?>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const icon = element.querySelector('.toggle-icon');
        if (answer.style.display === 'block') {
            answer.style.display = 'none';
            icon.textContent = '+';
        } else {
            answer.style.display = 'block';
            icon.textContent = '-';
        }
    }

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>

<!-- Footer Section -->
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
