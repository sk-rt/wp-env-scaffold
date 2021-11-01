<?php use App\CustomTags as Tags; ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<meta charset="utf-8">
<meta name="description" content="<?php echo Tags\get_the_description(); ?>">
<meta property="og:type" content="<?php if (is_front_page()) : ?>website<?php else : ?>article<?php endif; ?>">
<meta property="og:url" content="<?php echo Tags\get_the_canonical_url(); ?>">
<meta property="og:title" content="<?php echo wp_get_document_title(); ?>">
<meta property="og:description" content="<?php echo Tags\get_the_description(); ?>">
<meta property="og:image" content="<?php echo Tags\get_the_ogimage_url(); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?php echo wp_get_document_title(); ?>">
<meta itemprop="image" content="<?php echo Tags\get_the_ogimage_url(); ?>">
<link rel="icon" type="image/png" sizes="48x48" href="<?php echo get_template_directory_uri(); ?>/site-icons/favicon.png">
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/site-icons/favicon.png">
<?php wp_head(); ?>