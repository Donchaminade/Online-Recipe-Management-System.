<?php

include "config.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id']) && isset($_POST['question']) && isset($_POST['answer'])) {
        $idno = htmlspecialchars($_POST['id']);
        $question = htmlspecialchars($_POST['question']);
        $answer = htmlspecialchars($_POST['answer']);

        // Prepare the SQL statement to update the FAQ
        $sql = "UPDATE faq SET QUESTIONS = ?, ANSWERS = ? WHERE ID = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Error preparing the statement: " . $conn->error);
        }

        $stmt->bind_param("ssi", $question, $answer, $idno); 

        if ($stmt->execute()) {
            echo "FAQ updated successfully!";
        } else {
            echo "Error updating FAQ: " . $conn->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    } else {
        echo "Invalid input.";
    }
} else {
    echo "Invalid request method.";
}
header("Location: FAQ.php");
exi
?>
