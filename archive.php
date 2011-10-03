<?php get_header(); ?>

<div id="content">
<div id="alpha">

<?php if (have_posts()): ?>
    <?php the_post(); ?>
    <h1 class="archive-title"><?php
        $str = __('Archive for %s', "skipjack");
        if (is_day()) {
            printf(
                $str,
                mysql2date('Y/n/j', $post->post_date, false)
            );
        } elseif (is_month()) {
            printf(
                $str,
                mysql2date('Y/n', $post->post_date, false)
            );
        } elseif (is_year()) {
            printf(
                $str,
                mysql2date('Y', $post->post_date, false)
            );
        }
    ?></h1>
<?php endif; ?>
<?php rewind_posts(); ?>

<?php
    $category_description = category_description();
    if (!empty($category_description)) {
        echo '<div class="archive-meta">' . $category_description . '</div>';
    }
	get_template_part( 'loop', 'category' );
?>

</div><!-- #alpha -->

<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->

</div><!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>
