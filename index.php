<?php get_header(); ?>

<div id="featured">
<div id="carousel"><?php sj_featured_slide(); ?></div>
<div id="carousel-nav"></div>
</div><!--end #featured-->

<div id="home-widgets" class="wrap">

<div class="alpha"><?php if (!dynamic_sidebar('first-home-widget-area')): ?>
    <div class="widget-container">
        <?php get_template_part('loop'); ?>
    </div>
<?php endif; ?></div><!-- .alpha -->

<div class="beta"><?php if (!dynamic_sidebar('second-home-widget-area')): ?>
    <div class="widget-container">
        <h2 class="widget-title"><?php _e("Pages", "skipjack"); ?></h2>
        <?php wp_page_menu() ?>
    </div>
    <div class="widget-container">
        <h2 class="widget-title"><?php _e("Category", "skipjack"); ?></h2>
        <ul><?php wp_list_categories('title_li='); ?></ul>
    </div>
<?php endif; ?></div><!-- .beta -->

<div class="omega"><?php if (!dynamic_sidebar('third-home-widget-area')): ?>
    <div class="widget-container">
        <h2 class="widget-title"><?php _e("Search", "skipjack"); ?></h2>
        <?php get_search_form(); ?>
    </div>
<?php endif; ?></div><!-- .omega -->

</div><!-- #home-widgets -->

<?php get_footer(); ?>
