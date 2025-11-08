<?php
include('include/config.php'); // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if an image file was uploaded
    if (isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK) {
        // Get the file data
        $imageData = file_get_contents($_FILES['fileToUpload']['tmp_name']);
        $imageType = $_FILES['fileToUpload']['type'];

        // Prepare the SQL statement
        $stmt = $con->prepare("INSERT INTO images (image_data, image_type) VALUES (?, ?)");
        $stmt->bind_param("bs", $imageData, $imageType); // 'b' for blob, 's' for string

        // Execute the statement
        if ($stmt->execute()) {
            echo "Image uploaded and saved to database successfully.";
        } else {
            echo "Error saving image to database: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "No file uploaded or there was an upload error.";
    }
}
?>