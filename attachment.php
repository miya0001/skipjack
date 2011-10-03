<?php
/**
 * The template for displaying attachments.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<div id="content">
<div id="alpha">
<?php get_template_part( 'loop', 'attachment' ); ?>
</div>
</div><!-- #content -->

<?php get_footer(); ?>
