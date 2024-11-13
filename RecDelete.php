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

if (isset($_GET['recid'])) {
    $recid = $_GET['recid'];

    // Create the SQL DELETE query
    $sql = "DELETE FROM rec WHERE recid = '$recid'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect after successful deletion
        echo "<script>
            alert('Review deleted successfully');
            window.location.href = 'http://localhost/IWT_MLB_01.02_09/RecRead.php';
          </script>";
        exit();
    } else {
        echo "Error deleting review: " . mysqli_error($conn);
    }
} else {
    echo "Invalid response...";
}

// Close the database connection
mysqli_close($conn);
?>
