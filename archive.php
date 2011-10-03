<?php get_header(); ?>

<div id="content">
<div id="alpha">

<?php if (have_posts()): ?>
    <?php the_post(); ?>
    <h1 class="archive-title"><?php
        $str = '%sのバックナンバー';
        if (is_day()) {
            printf(
                $str,
                mysql2date('Y年n月j日', $post->post_date)
            );
        } elseif (is_month()) {
            printf(
                $str,
                mysql2date('Y年n月', $post->post_date)
            );
        } elseif (is_year()) {
            printf(
                $str,
                date('Y年', mysql2date('U', $post->post_date))
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
