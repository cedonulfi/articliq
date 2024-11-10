<?php
// Get your Cloudflare Account ID and API Token here: https://developers.cloudflare.com/workers-ai/get-started/rest-api/

// Insert your Account ID and API Token here
$account_id = "YOUR-ACCOUNT-ID";
$api_token = "YOUR-API-TOKEN";

// Set the API URL and the data to be sent
$urli = "https://api.cloudflare.com/client/v4/accounts/{$account_id}/ai/run/@cf/stabilityai/stable-diffusion-xl-base-1.0";

// Prompt to generate an image
// The variable $title holds the title of the previously generated article.
// Array containing 10 example prompts
$prompts = array(
    "Create a vibrant and detailed illustration capturing the essence of the article titled '\$title'.",
    "Design an abstract visual representation that embodies the themes and ideas presented in '\$title'.",
    "Illustrate a scene that reflects the key concepts discussed in the article titled '\$title', using a modern and minimalist style.",
    "Generate a surreal and imaginative image inspired by the core message of '\$title'.",
    "Produce a realistic depiction of a pivotal moment or concept from '\$title', emphasizing emotion and atmosphere.",
    "Create a cartoon-style illustration that highlights the main points of the article '\$title', with a touch of humor.",
    "Design a conceptual art piece that visually interprets the challenges and solutions presented in '\$title'.",
    "Illustrate a futuristic and innovative concept related to the article titled '\$title', using a vibrant color palette.",
    "Generate a nature-inspired image that reflects the environmental themes discussed in '\$title'.",
    "Create a digital painting that captures the historical context and significance of the events described in '\$title'."
);

// Select a random prompt from the array
$randomPrompt = $prompts[array_rand($prompts)];

$data = array(
    'prompt' => "$randomPrompt"
);

// Convert data to JSON format
$data_json = json_encode($data);

// Configure the cURL request
$ch = curl_init($urli);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $api_token,
    'Content-Type: application/json'
));

// Execute the request and store the response
$responsei = curl_exec($ch);

// Check for any errors
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
}

// Close the cURL connection
curl_close($ch);

// If the response is successfully received
if ($responsei) {
    // Set a temporary filename
    $temp_file = tempnam(sys_get_temp_dir(), 'cloudflare_image');

    // Save the response in the temporary file
    file_put_contents($temp_file, $responsei);

    // Display the image using the <img> tag
    echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents($temp_file)) . '" />';

    // Delete the temporary file
    unlink($temp_file);
} else {
    // Display a message if the response is empty
    echo 'Empty response or an error occurred while fetching the image.';
}
?>
