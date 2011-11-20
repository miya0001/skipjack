<?php /* If there are no posts to display, such as an empty archive page */ ?>
<?php if ( ! have_posts() ) : ?>
	<div class="post error404 not-found">
	</div><!-- #post-0 -->
<?php endif; ?>

<?php while ( have_posts() ) : the_post(); ?>
<div <?php post_class(); ?>>
    <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<div class="entry-meta clearfix">
		<?php sj_posted_in(); ?>
	</div><!-- .entry-meta -->
    <?php if (has_post_thumbnail()): ?>
    <?php the_post_thumbnail(); ?>
    <?php else: ?>
    <div class="excerpt"><?php the_excerpt(); ?></div>
    <?php endif; ?>
</div>
<?php endwhile; // End the loop. Whew. ?>

<?php if (  $wp_query->max_num_pages > 1 ) : ?>
<div id="nav-below" class="navigation">
<div class="nav-previous"><?php previous_posts_link(__('<span class="meta-nav">&laquo; Previous</span>', 'skipjack')); ?></div>
<div class="nav-next"><?php next_posts_link(__('<span class="meta-nav">Next &raquo;</span>', 'skipjack')); ?></div>
</div><!-- #nav-below -->
<?php endif; ?>
