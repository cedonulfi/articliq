<?php
// Load WordPress environment
require_once( dirname(__FILE__) . '/new/wp-load.php' );

// Article Variables
$title = 'You Will Love This Beautiful Image of Nature';
$content = 'Content of the article goes here';
$img = 'https://theartofberlin.com/wp-content/uploads/2024/06/5996049-AHRVPAKW-7.jpg'; // Image URL to be uploaded
$tags = ['nature', 'lovely']; // List of tags
$categories = [1, 2]; // Category IDs (e.g., categories with ID 1 and 2), see all IDs in id.php

// Create a new post
$post_data = [
    'post_title'    => $title,
    'post_content'  => $content,
    'post_status'   => 'publish', // Or 'draft' if you want to save as a draft
    'post_author'   => 1, // Author ID, adjust according to your user ID
    'post_category' => $categories,
    'tags_input'    => $tags,
];

// Insert the post into WordPress
$post_id = wp_insert_post($post_data);

// Upload the image and set it as the featured image
if ($post_id && !is_wp_error($post_id)) {
    // Include required WordPress files for media upload
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');

    // Attempt to sideload the image
    $attachment_id = media_sideload_image($img, $post_id, '', 'id');

    // Check for errors in image upload
    if (!is_wp_error($attachment_id)) {
        // Set as featured image if upload succeeded
        set_post_thumbnail($post_id, $attachment_id);
        echo 'Article successfully posted with featured image. Post ID: ' . $post_id;
    } else {
        echo 'Failed to upload image. Error: ' . $attachment_id->get_error_message();
    }
} else {
    echo 'Failed to post article. Message: ' . ($post_id ? $post_id->get_error_message() : 'Unknown error');
}
?>
