<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            margin-top: 20px;
        }
        input[type="file"] {
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Upload an Image</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="fileToUpload">Select image to upload:</label><br>
        <input type="file" name="fileToUpload" id="fileToUpload" accept="image/*" required><br>
        <input type="submit" value="Upload Image" name="submit">
    </form>

    <h2>Uploaded Images</h2>
    <ul>
        <?php
        include('include/config.php'); // Include your database connection

        // Fetch and display uploaded images
        $result = $con->query("SELECT id, image_type FROM images");
        while ($row = $result->fetch_assoc()) {
            echo '<li>';
            echo '<img src="Dental_home.jpg" width="100" height="100" alt="Image">';
            echo '</li>';
        }
        ?>
    </ul>
</body>
</html>