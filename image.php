<?php

// Database connection
include 'config.php';



// Check connection

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST")  {
    $id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : '';

    if(isset($_FILES["image"])){



        $allowtypes = ["png", "jpg", "jpeg"];
        // Get the file extension
        $filetype = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));
    
        if(!in_array($filetype, $allowtypes)) {
            $message = "<div>Invalid image format</div>";
        } else {
            // Generate unique file name
            $filename = time() . "." . $filetype;
            // Move the uploaded file to the uploads directory
            if(move_uploaded_file($_FILES['image']["tmp_name"], "uploads/" . $filename)) {
                // Insert the file name into the database
                $sql = "UPDATE users SET image='$filename' WHERE id='{$id}'";
               
                if($conn->query($sql)) {
                    $message = "<h1>Image uploaded and saved successfully.</h1>";
                } else {
                    $message = "<h1>Database insert failed.</h1>";
                }
            } else {
                $message = "<h1>File upload failed.</h1>";
            }
        }


    }



   

}


header("Location: index.php?id=" . urlencode($id));
exit();
?>

<?php
echo $id;

?>

