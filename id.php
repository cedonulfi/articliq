<?php
// Load WordPress environment
require_once( dirname(__FILE__) . '/wp-load.php' );

// Get list of authors
$authors = get_users([
    'who' => 'authors',
]);

echo "<h2>Author List</h2>";
foreach ($authors as $author) {
    echo 'ID: ' . $author->ID . ' - Name: ' . $author->display_name . '<br>';
}

// Get list of categories
$categories = get_categories([
    'hide_empty' => false,
]);

echo "<h2>Category List</h2>";
foreach ($categories as $category) {
    echo 'ID: ' . $category->term_id . ' - Name: ' . $category->name . '<br>';
}
?>
