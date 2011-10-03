<?php get_header(); ?>

<div id="featured">
<div id="carousel"><?php sj_featured_slide(); ?></div>
<div id="carousel-nav"></div>
</div><!--end #featured-->
<div id="home-widgets">
<div class="alpha"><?php dynamic_sidebar('first-home-widget-area'); ?></div>
<div class="beta"><?php dynamic_sidebar('second-home-widget-area'); ?></div>
<div class="omega"><?php dynamic_sidebar('third-home-widget-area'); ?></div>
</div><!-- #content -->

<?php get_footer(); ?>
