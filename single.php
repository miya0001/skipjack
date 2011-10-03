<?php get_header(); ?>

<div id="content">
<div id="alpha">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<div id="nav-above" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
				</div><!-- #nav-above -->

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="entry-meta clearfix">
						<?php sj_posted_in(); ?>
					</div><!-- .entry-meta -->

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

				</div><!-- #post-## -->

				<div id="nav-below" class="navigation clearfix">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">&larr;</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">&rarr;</span>' ); ?></div>
				</div><!-- #nav-below -->

				<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>
</div><!-- #alpha -->

<?php if (!has_post_format('aside') && !has_post_format('gallery')) : ?>
<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->
<?php endif; ?>

</div><!-- #content -->

<?php get_footer(); ?>
