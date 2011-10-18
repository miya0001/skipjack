<!DOCTYPE html>
<html
    xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="<?php bloginfo('language'); ?>" lang="<?php bloginfo('language'); ?>"
    xmlns:og="http://ogp.me/ns#"
    xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
    wp_title(' | ', true, 'right');
    bloginfo('name');
?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/css/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_directory' ); ?>/style.css?<?php echo SKIPJACK_VERSION; ?>" />
<?php if (is_child_theme()): ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?<?php echo SKIPJACK_VERSION; ?>" />
<?php endif; ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
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
