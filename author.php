<?php get_header(); ?>

<div id="content">
<div id="alpha">

<?php if (have_posts()): ?>
    <?php the_post(); ?>
    <h1 class="archive-title"><?php
    printf(
        __('Archive for %s', "skipjack"),
        get_the_author());
    ?></h1>
    <?php if (get_the_author_meta('description')): ?>
        <div id="entry-author-info">
            <div class="author-avatar">
                <?php echo get_avatar(get_the_author_meta( 'user_email' ), 60); ?>
            </div>
            <div class="author-description">
                <?php the_author_meta( 'description' ); ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php rewind_posts(); ?>

<?php get_template_part('loop', 'author'); ?>

</div><!-- #alpha -->

<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->

</div><!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
