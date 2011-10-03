<div id="first" class="widget-area grid_4 alpha">
<?php if ( is_active_sidebar( 'first-footer-widget-area' ) ) : ?>
    <ul class="xoxo">
        <?php dynamic_sidebar( 'first-footer-widget-area' ); ?>
    </ul>
<?php else: ?>
<br />
<?php endif; ?>
</div><!-- #first .widget-area -->

<div id="second" class="widget-area grid_4">
<?php if ( is_active_sidebar( 'second-footer-widget-area' ) ) : ?>
    <ul class="xoxo">
        <?php dynamic_sidebar( 'second-footer-widget-area' ); ?>
	</ul>
<?php else: ?>
<br />
<?php endif; ?>
</div><!-- #second .widget-area -->

<div id="third" class="widget-area grid_4">
<?php if ( is_active_sidebar( 'third-footer-widget-area' ) ) : ?>
    <ul class="xoxo">
        <?php dynamic_sidebar( 'third-footer-widget-area' ); ?>
    </ul>
<?php else: ?>
<br />
<?php endif; ?>
</div><!-- #third .widget-area -->

<div id="fourth" class="widget-area grid_4 omega">
<?php if ( is_active_sidebar( 'fourth-footer-widget-area' ) ) : ?>
    <ul class="xoxo">
        <?php dynamic_sidebar( 'fourth-footer-widget-area' ); ?>
    </ul>
<?php else: ?>
<br />
<?php endif; ?>
</div><!-- #fourth .widget-area -->

