<?php
include "config.php"; 

if (isset($_GET['id'])) {
    $idno = htmlspecialchars($_GET['id']);
} else {
    die("No ID parameter found in the URL.");
}


$sql = "DELETE FROM users WHERE ID = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}


$stmt->bind_param("i", $idno); 
if ($stmt->execute()) {

    header("Location: signin.php");
    exit();
} else {
    echo "Error deleting record: " . $stmt->error;
}


$stmt->close();
$conn->close();
?>
