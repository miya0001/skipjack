<?php get_header(); ?>

<div id="content" class="wrap">
<div id="alpha">

				<h1 class="archive-title"><?php
					printf(
                        __('Archive for %s', 'skipjack'),
                        single_tag_title( '', false ));
				?></h1>

<?php get_template_part('loop', 'tag'); ?>

</div><!-- #alpha -->

<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->

</div><!-- #content -->

<?php get_footer(); ?>
