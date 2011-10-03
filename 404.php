<?php get_header(); ?>
<div id="content">
<div id="alpha">

    <h1 class="entry-title">Not Found</h1>

    <div class="entry-content">
        <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'skipjack' ); ?></p>
					<?php get_search_form(); ?>
	</div><!-- .entry-content -->
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>
</div><!-- #alpha -->

<div id="beta">
<?php get_sidebar(); ?>
</div><!-- #beta -->

</div><!-- #content -->

<?php get_footer(); ?>
