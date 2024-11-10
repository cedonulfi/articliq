<?php
// Get the base64 image code from img.php
// Place the base64 string of the image to be uploaded
$base64_string = 'data:image/png;base64,....'; // Replace this with your actual base64 string

// Split the base64 string into the header and the data
$exploded = explode(',', $base64_string);
$data = base64_decode($exploded[1]);

// Define the file path and name for saving the image
$file_name = 'uploaded_image.png';  // Change the file name as needed
$file_path = 'uploads/' . $file_name;  // Make sure the 'uploads' folder exists and has the correct permissions

// Save the image data to the file
if (file_put_contents($file_path, $data)) {
    echo "Image successfully uploaded and saved to $file_path";
} else {
    echo "There was an error saving the image.";
}
?>