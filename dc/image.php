<?php
include('include/config.php'); // Include your database connection

// Get the image ID from the URL (e.g., image.php?id=1)
$imageId = $_GET['id'];

// Prepare the SQL statement
$stmt = $con->prepare("SELECT image_data, image_type FROM images WHERE id = ?");
$stmt->bind_param("i", $imageId);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($imageData, $imageType);
$stmt->fetch();

// Set the content type header
header("Content-Type: " . $imageType);
echo $imageData;

// Close the statement
$stmt->close();
?>