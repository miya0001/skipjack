<?php if (comments_open()): ?>
<div id="comments">
    <?php if ( post_password_required() ) : ?>
        <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'skipjack' ); ?></p>
        </div><!-- #comments -->
    <?php return; ?>
	<?php endif; ?>

<?php if ( have_comments() ) : ?>
			<h2 id="comments-title"><?php
			printf(_n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'skipjack'),
			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );
			?></h2>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'skipjack' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'skipjack' ) ); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					/* Loop through and list the comments. Tell wp_list_comments()
					 * to use skipjack_comment() to format the comments.
					 * If you want to overload this in a child theme then you can
					 * define skipjack_comment() and that will be used instead.
					 * See skipjack_comment() in skipjack/functions.php for more.
					 */
					wp_list_comments( array( 'callback' => 'sj_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'skipjack' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'skipjack' ) ); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
<?php endif; // end comments_open() ?>
