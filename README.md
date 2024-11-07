# Articliq

Articliq is a PHP tool designed to automate the process of creating and publishing AI-generated articles and images on WordPress. It uses external APIs to generate unique content and images, then posts them directly to a WordPress blog located in the same directory.

## Features

- **Generate Articles** using *Gemini AI API* for unique article titles and content.
- **Create Illustrations** for articles using *Cloudflare Workers AI API*.
- **Retrieve WordPress Author and Category IDs** to streamline the posting process.
- **Automated Posting** of articles and images directly to WordPress, including setting the featured image.

## Requirement

- **Gemini API Key** you can get the Gemini API Key here: https://ai.google.dev/gemini-api/docs
- **Cloudflare API token and Account ID** to use the REST API, you need your API token and Account ID. Click here: https://developers.cloudflare.com/workers-ai/get-started/rest-api/
- **WordPress Web** with the access to your hosting control panel.

## Files

1. **`article.php`** - Generates article titles and content using Gemini AI API.
2. **`img.php`** - Creates an illustration that matches the article title using Workers AI API from Cloudflare.
3. **`id.php`** - Retrieves Author and Category IDs from your WordPress blog for assigning authorship and categorization.
4. **`autopost.php`** - Posts the generated article and uploads the featured image to WordPress, making use of WordPress functions directly as it resides within the same directory.

## Installation

1. Clone this repository:
   ```bash
   git clone https://github.com/cedonulfi/articliq.git
   cd articliq
   ```

2. Install any necessary PHP libraries, such as `cURL`:
   ```bash
   sudo apt-get install php-curl
   ```

3. Set up your API keys in `article.php` and `img.php`.

4. Ensure that `autopost.php` can access WordPress functions by including WordPress's `wp-load.php` file.

## Usage

### Generating an Article

Run `article.php` to create a unique title and content using Gemini AI API:

```php
php article.php
```

### Generating an Image

Run `img.php` to create an illustration that matches the article’s theme using Cloudflare Workers AI API:

```php
php img.php
```

### Retrieving Author and Category IDs

Use `id.php` to find the Author and Category IDs from WordPress, which are required for posting:

```php
php id.php
```

### Posting the Article and Image to WordPress

After generating your content and image, run `autopost.php` to post them on WordPress with the image as the featured image:

```php
php autopost.php
```

**Note:** Because `autopost.php` is in the same directory as WordPress, it directly loads WordPress functions by including `wp-load.php`:

```php
require_once('../wp-load.php');
```

## Example Code for `autopost.php`

Here’s a simplified version of how `autopost.php` might look if it’s in the same directory as WordPress:

```php
<?php
// Include WordPress core for direct access
require_once('../wp-load.php');

// Prepare article and image data
$title = "Generated Article Title";
$content = "This is the AI-generated content.";
$image_path = "/path/to/generated/image.jpg";

// Create new post
$post_id = wp_insert_post([
    'post_title'   => $title,
    'post_content' => $content,
    'post_status'  => 'publish',
    'post_author'  => 1, // Replace with the desired author ID
    'post_category' => [2] // Replace with the desired category ID
]);

// Set the featured image
if ($post_id && file_exists($image_path)) {
    $attachment_id = wp_insert_attachment([
        'post_mime_type' => 'image/jpeg',
        'post_title'     => basename($image_path),
        'post_content'   => '',
        'post_status'    => 'inherit'
    ], $image_path, $post_id);

    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata($attachment_id, $image_path);
    wp_update_attachment_metadata($attachment_id, $attach_data);
    set_post_thumbnail($post_id, $attachment_id);
}
?>
```

Make sure to adjust file paths and IDs as needed. 

## License

This project is licensed under the MIT License.

