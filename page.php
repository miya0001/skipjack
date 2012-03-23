<?php get_header(); ?>

<div id="content" class="wrap">
<div id="alpha">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="breadcrumb"><?php sj_breadcrumb(); ?></div>
					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-content">
						<?php the_content(); ?>
					</div><!-- .entry-content -->

<?php
    wp_link_pages(array(
        'before' => '<div class="page-link clearfix">',
        'after' => '</div>',
        'pagelink' => '<span>%</span>'
    ));
?>

<br clear="all" />
				</div><!-- #post-## -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
</div><!-- #alpha -->

<?php if (!has_post_format('aside') && !has_post_format('gallery')) : ?>
<div id="beta">
<?php get_sidebar('page'); ?>
</div><!-- #beta -->
<?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>
