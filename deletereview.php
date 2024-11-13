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

// Check if recipeid and reviewid are set in the URL
if (isset($_GET['recipeid']) && isset($_GET['reviewid'])) {
    $recipeid = $_GET['recipeid'];
    $reviewid = $_GET['reviewid'];

    // Delete the review from the database
    $sql = "DELETE FROM review WHERE reviewid = '$reviewid'";
    
    if (mysqli_query($conn, $sql)) {
        // After successful deletion, redirect to the review page for that recipe
        echo "<script>
                alert('Review deleted successfully');
                window.location.href = 'reviewform.php?recipeid=$recipeid';
              </script>";
        exit();
    } else {
        echo "Error deleting review: " . mysqli_error($conn);
    }
} else {
    echo "Recipe ID or Review ID not provided.";
}

// Close the database connection
mysqli_close($conn);
?>
