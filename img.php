<?php
// Get your Cloudflare Account ID and API Token here: https://developers.cloudflare.com/workers-ai/get-started/rest-api/

// Prompt to generate an image
$text = $_GET["text"];

// Insert your Account ID and API Token here
$account_id = "YOUR-ACCOUNT-ID";
$api_token = "YOUR-API-TOKEN";

// Set the API URL and the data to be sent
$url = "https://api.cloudflare.com/client/v4/accounts/{$account_id}/ai/run/@cf/stabilityai/stable-diffusion-xl-base-1.0";

$data = array(
    'prompt' => "$text"
);

// Convert data to JSON format
$data_json = json_encode($data);

// Configure the cURL request
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization: Bearer ' . $api_token,
    'Content-Type: application/json'
));

// Execute the request and store the response
$response = curl_exec($ch);

// Check for any errors
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
}

// Close the cURL connection
curl_close($ch);

// If the response is successfully received
if ($response) {
    // Set a temporary filename
    $temp_file = tempnam(sys_get_temp_dir(), 'cloudflare_image');

    // Save the response in the temporary file
    file_put_contents($temp_file, $response);

    // Display the image using the <img> tag
    echo '<img src="data:image/png;base64,' . base64_encode(file_get_contents($temp_file)) . '" />';

    // Delete the temporary file
    unlink($temp_file);
} else {
    // Display a message if the response is empty
    echo 'Empty response or an error occurred while fetching the image.';
}
?>
