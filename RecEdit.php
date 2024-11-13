<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Edit Recipe</title>

   <!--css file link-->
   <link rel="stylesheet" href="RecEditStyle.css">
</head>
<body>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "iwt";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if a recipe ID is provided in the URL
if (isset($_GET['recid'])) {
    $recid = $_GET['recid'];
    $sql = "SELECT * FROM rec WHERE recid = '$recid'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $ingredients = $_POST["ingredients"];
            $description = $_POST["description"];
            $process = $_POST["process"];

            // Image upload handling
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                // File upload configuration
                $target_dir = "BackImage/";
                $target_file = $target_dir . basename($_FILES["image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if file is an image
                $check = getimagesize($_FILES["image"]["tmp_name"]);
                if ($check !== false) {
                    // Check file size (limit to 2MB)
                    if ($_FILES["image"]["size"] <= 2000000) {
                        // Allow only certain file formats
                        if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                            // Upload the file
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                                // Update the recipe details including the image name
                                $image_name = basename($_FILES["image"]["name"]);
                                $updateSql = "UPDATE rec SET name = '$name', ingredients = '$ingredients', description = '$description', process = '$process', image_path = '$image_name' WHERE recid = '$recid'";

                                if (mysqli_query($conn, $updateSql)) {
                                    echo "<script>
                                    alert('ID $recid has been updated successfully');
                                    window.location.href = 'http://localhost/IWT_MLB_01.02_09/RecRead.php';
                                    </script>";
                                    exit();
                                } else {
                                    echo "Error updating recipe: " . mysqli_error($conn);
                                }
                            } else {
                                echo "Sorry, there was an error uploading your file.";
                            }
                        } else {
                            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                        }
                    } else {
                        echo "Sorry, your file is too large.";
                    }
                } else {
                    echo "File is not an image.";
                }
            } else {
                // If no image is uploaded, update other details only
                $updateSql = "UPDATE rec SET name = '$name', ingredients = '$ingredients', description = '$description', process = '$process' WHERE recid = '$recid'";

                if (mysqli_query($conn, $updateSql)) {
                    echo "<script>
                    alert('ID $recid has been updated successfully');
                    window.location.href = 'http://localhost/IWT_MLB_01.02_09/RecRead.php?recid=" . $recid . "';
                    </script>";
                    exit();
                } else {
                    echo "Error updating recipe: " . mysqli_error($conn);
                }
            }
        }
?>
        <h2>Edit Recipe</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?recid=' . $recid; ?>" enctype="multipart/form-data"> <!-- Added enctype for file upload -->

    <label for="name">Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($row["name"]); ?>" required><br>

    <label for="ingredients">Ingredients</label>
    <input type="text" name="ingredients" value="<?php echo htmlspecialchars($row["ingredients"]); ?>" required><br>

    <label for="description">Description</label>
    <input type="text" name="description" value="<?php echo htmlspecialchars($row["description"]); ?>" required><br>

    <label for="process">Process</label>
    <input type="text" name="process" value="<?php echo htmlspecialchars($row["process"]); ?>" required><br>

    <?php if (!empty($row['image_path'])): ?>
        <img src='BackImage/<?php echo htmlspecialchars($row['image_path']); ?>' alt='Recipe Image' width='200' />
    <?php endif; ?>

    <label for="image">Image</label>
    <input type="file" name="image" accept="image/*"><br> <!-- Input for image upload -->

    <input type="submit" value="Update">
</form>

<?php
    } else {
        echo "Recipe not found.";
    }
} else {
    echo "Invalid request - No recipe ID provided.";
}

mysqli_close($conn);
?>

</body>
</html>
