<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
    wp_title(' | ', true, 'right');
    bloginfo('name');
?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css?ver=<?php echo filemtime(get_template_directory().'/style.css'); ?>" />
<?php if (is_child_theme()): ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css?ver=<?php echo filemtime(get_stylesheet_directory().'/style.css') ?>" />
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php
	if (is_singular() && get_option('thread_comments'))
		wp_enqueue_script('comment-reply');
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="container">

<div id="header">
<div class="wrap">
<?php if (is_home() || is_front_page()): ?>
<h1 id="branding"><a href="<?php echo home_url('/'); ?>"><?php sj_header_image(); ?></a></h1>
<?php else: ?>
<div id="branding"><a href="<?php echo home_url('/'); ?>"><?php sj_header_image(); ?></a></div>
<?php endif; ?>
<?php
wp_nav_menu(array(
    'container_class' => 'secondly-menu',
    'theme_location' => 'secondly',
    'fallback_cb' => false,
));
?>
</div>
</div><!-- #header -->

<div id="primary-menu">
<?php
wp_nav_menu(array(
    'container' => 'div',
    'container_class' => 'menu',
    'theme_location' => 'primary',
    'fallback_cb' => 'wp_page_menu'
));
?>
</div>
