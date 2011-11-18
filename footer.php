
<div id="footer">
<div class="wrap">

<div id="first" class="widget-area grid_4 alpha">
    <ul class="xoxo">
        <?php if (!dynamic_sidebar('first-footer-widget-area')): ?>
            <br />
        <?php endif; ?>
    </ul>
</div><!-- #first .widget-area -->

<div id="second" class="widget-area grid_4">
    <ul class="xoxo">
        <?php if (!dynamic_sidebar('second-footer-widget-area')): ?>
            <br />
        <?php endif; ?>
	</ul>
</div><!-- #second .widget-area -->

<div id="third" class="widget-area grid_4">
    <ul class="xoxo">
        <?php if (!dynamic_sidebar('third-footer-widget-area')): ?>
            <br />
        <?php endif; ?>
    </ul>
</div><!-- #third .widget-area -->

<div id="fourth" class="widget-area grid_4 omega">
    <ul class="xoxo">
        <?php if (!dynamic_sidebar('fourth-footer-widget-area')): ?>
            <a href="<?php echo admin_url(); ?>/widgets.php">Footer Widget Area</a>
        <?php endif; ?>
    </ul>
</div><!-- #fourth .widget-area -->

</div><!-- .wrap -->

<?php wp_footer(); ?>

</div><!-- #footer -->

</div><!-- #container -->

<!-- <?php echo get_num_queries(); ?> queries. <?php echo timer_stop(); ?> seconds. -->
</body>
</html>
