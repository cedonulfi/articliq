<?php

// Check if 'topic' is set in POST request
if (isset($_POST['topic'])) {
    // Include the required files
    include 'article.php';  // Generates the article
    include 'img.php';      // Generates the image for the article
    include 'autopost.php'; // Posts the article to WordPress
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Article</title>
</head>
<body>
    <!-- Form to input the topic and submit -->
    <form action="index.php" method="post">
        <label for="topic">Enter Topic:</label>
        <input type="text" name="topic" id="topic" required>
        <button type="submit">Generate</button>
    </form>
</body>
</html>
