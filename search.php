<?php get_header(); ?>

<div id="content">
<div id="alpha">
				<h1 class="page-title"><?php printf('検索結果: %s', get_search_query()); ?></h1>

<?php get_template_part('loop', 'tag'); ?>

</div><!-- #alpha -->

<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->

</div><!-- #content -->

<?php get_footer(); ?>
