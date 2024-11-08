<?php
// Insert your Gemini API key
$API_KEY = "YOUR-API-KEY-HERE"; 

// API URL
$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $API_KEY;

// Get the topic from the GET parameter
$topic = isset($_GET["topic"]) ? htmlspecialchars($_GET["topic"]) : "the future of AI";
$text = "Create an interesting and SEO-friendly article in English about $topic.";

// Data to be sent in the request
$data = array(
    "contents" => array(
        array(
            "parts" => array(
                array(
                    "text" => $text
                )
            )
        )
    )
);

// Convert data to JSON format
$postData = json_encode($data);

// cURL configuration
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and capture the response
$response = curl_exec($curl);

// Handle errors if any
if ($response === false) {
    $error = curl_error($curl);
    echo "Error: " . $error;
} else {
    // Decode the response into a PHP array
    $responseArray = json_decode($response, true);

    // Check if the response has the expected structure
    if (isset($responseArray['candidates'][0]['content']['parts'][0]['text'])) {
        // Extract the text from the API response
        $texth = $responseArray['candidates'][0]['content']['parts'][0]['text'];

        // Separate the title and article based on lines
        $lines = explode("\n", $texth);

        // Take the first line as the title
        $title = trim(strip_tags($lines[0]));
        $title = str_replace("## ", "", $title);

        // Take the content from the third line onward as the article
        $article_lines = array_slice($lines, 2);
        $article = implode("\n", $article_lines);

        // Replace text between ** with <b> and </b>
        $article = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $article);

        // Output the article with title and content
        echo "<strong>$title</strong><br /><br />\n\n";
        echo nl2br($article);
    } else {
        echo "Error: Invalid response structure";
    }
}

// Close the cURL connection
curl_close($curl);
?>
