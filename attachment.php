<?php get_header(); ?>

<div id="content">
<div id="alpha">
<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
    <?php if ( ! empty( $post->post_parent ) ) : ?>
        <p class="page-title"><a href="<?php echo get_permalink( $post->post_parent ); ?>" title="<?php esc_attr( printf('Back to %s', get_the_title( $post->post_parent ) ) ); ?>" rel="gallery"><?php
        printf(
            '<span class="meta-nav">&larr;</span> %s',
            get_the_title($post->post_parent)
        );
        ?></a></p>
    <?php endif; ?>
    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <h1 class="entry-title"><?php the_title(); ?></h1>
        <div class="entry-meta clearfix">
            <?php sj_posted_in(); ?>
        </div><!-- .entry-meta -->
        <div class="entry-content">
        <?php if (wp_attachment_is_image()) : ?>
            <div class="attachment">
                <div class="entry-caption"><?php
                if (!empty($post->post_excerpt)) the_excerpt();
                ?></div>
                <?php echo wp_get_attachment_image($post->ID, 'medium'); ?>
                <div class="navigation">
                    <div class="nav-previous"><?php
                        previous_image_link('medium', '&larr; Previous');
                    ?></div>
                    <div class="nav-next"><?php
                        next_image_link('medium', 'Next &rarr;');
                    ?></div>
                </div>
            </div>
    <?php else : ?>
        <a href="<?php
            echo wp_get_attachment_url();
        ?>" title="<?php
            echo esc_attr( get_the_title() );
        ?>" rel="attachment"><?php
            echo basename( get_permalink() );
        ?></a>
    <?php endif; ?>
            <div class="content"><?php the_content(); ?></div>
        </div><!-- .entry-content -->
    </div><!-- #post-## -->
<?php endwhile; // end of the loop. ?>
</div>
</div><!-- #content -->

<?php get_footer(); ?>
