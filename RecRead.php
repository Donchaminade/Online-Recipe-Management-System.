<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book Listings</title>

   <!-- CSS file link -->
   <link rel="stylesheet" href="RecReadStyle.css">  
</head>
<body>
   <section class="listings">
      <h1 class="heading">Latest Listings</h1>
      <div class="box-container">

      <?php
      // Database connection
      $host = "localhost";
      $username = "root";
      $password = "";
      $database = "iwt";

      $conn = mysqli_connect($host, $username, $password, $database);
      if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
      }

      // Fetching all records from the `rec` table
      $sql = "SELECT recid, name, description, prepminutes, image_path FROM rec";
      $result = mysqli_query($conn, $sql);

      // Check if there are any rows returned
      if (mysqli_num_rows($result) > 0) {
          // Loop through each row and display the details
          while ($row = mysqli_fetch_assoc($result)) {
              echo '<div class="box">';
              
              // Recipe Name
              echo '<h3 class="name">' . htmlspecialchars($row["name"]) . '</h3>';
              
              // Recipe Description
              echo '<p class="description">' . htmlspecialchars($row["description"]) . '</p>';
              
              // Preparation Time
              echo '<p class="prepminutes">Preparation Time: ' . htmlspecialchars($row["prepminutes"]) . ' minutes</p>';
              
              // Image Section (if available)
              if (!empty($row['image_path'])) {
                  echo "<div class='image-box'>";
                  echo "<img src='BackImage/" . htmlspecialchars($row['image_path']) . "' alt='Recipe Image' width='200' />";
                  echo "</div>";
              }

              echo '<a href="RecEdit.php?recid=' . $row['recid'] . '"><button class="btn edit">Edit</button></a>';
              echo '<a href="RecDelete.php?recid=' . $row['recid'] . '"><button class="btn delete">Delete</button></a>';

              echo '</div>'; // End of .box
          }
      } else {
          // If no records found
          echo '<p>No listings found</p>';
      }

      // Close the database connection
      mysqli_close($conn);
      ?>

      </div>
      <div style="margin-top: 2rem; text-align:center;">
          <a href="metrobuylistings.html" class="inline-btn">View All</a>
      </div>
   </section>
</body>
</html>
