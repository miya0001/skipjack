<?php get_header(); ?>

<div id="content">
<div id="alpha">

				<h1 class="archive-title"><?php
					printf(
                        __('Archive for %s', "skipjack"),
                        single_cat_title( '', false ));
				?></h1>

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

<?php get_footer(); ?>
