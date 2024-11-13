<?php

include "config.php"; 

if (isset($_GET['id'])) {
    $idno = htmlspecialchars($_GET['id']);
} else {
    die("No ID parameter found in the URL.");
}

// Prepare the SQL statement to retrieve the FAQ based on ID
$sql = "SELECT * FROM faq WHERE ID = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing the statement: " . $conn->error);
}

$stmt->bind_param("i", $idno); 

$stmt->execute();

// Store the result
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Fetch the FAQ data
    $faq = $result->fetch_assoc();
    $question = htmlspecialchars($faq['QUESTIONS']); // Retrieve the question
    $answer = htmlspecialchars($faq['ANSWERS']); // Retrieve the answer
} else {
    die("No FAQ found with the specified ID.");
}

// Close the statement and connection
$stmt->close();
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit FAQ</title>
    <link rel="stylesheet" href="faqeditstyle.css"> <!-- Link to the new external CSS file -->
</head>
<body>

    <div class="form-container">
        <h2>Edit FAQ</h2>
        
        <!-- Edit Form -->
        <form action="pageedit.php" method="post">
            <input type="hidden" name="id" value="<?php echo $idno; ?>">

            <!-- Question Field -->
            <label for="question">Question:</label>
            <textarea
                id="question" 
                name="question" 
                required><?php echo $question; ?></textarea>

            <!-- Answer Field -->
            <label for="answer">Answer:</label>
            <textarea
                id="answer" 
                name="answer" 
                rows="5" 
                required><?php echo $answer; ?></textarea>

            <!-- Submit Button -->
            <button type="submit">Save Changes</button>
        </form>
    </div>

</body>
</html>
