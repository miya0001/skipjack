<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.  The actual display of comments is
 * handled by a callback to twentyten_comment which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

			<div id="comments">
<?php if ( post_password_required() ) : ?>
				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>
			</div><!-- #comments -->
<?php
		/* Stop the rest of comments.php from being processed,
		 * but don't kill the script entirely -- we still have
		 * to fully load the template.
		 */
		return;
	endif;
?>

<?php
	// You can start editing here -- including this comment!
?>

<?php if ( have_comments() ) : ?>
			<h3 id="comments-title"><?php
			printf('"%s"への%s件のコメント', get_the_title(), get_comments_number());
			?></h3>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link('<span class="meta-nav">&larr;</span> 古いコメント'); ?></div>
				<div class="nav-next"><?php next_comments_link('新しいコメント <span class="meta-nav">&rarr;</span>'); ?></div>
			</div> <!-- .navigation -->
<?php endif; // check for comment navigation ?>

			<ol class="commentlist">
				<?php
					wp_list_comments( array( 'callback' => 'sj_comment' ) );
				?>
			</ol>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
			<div class="navigation">
				<div class="nav-previous"><?php previous_comments_link('<span class="meta-nav">&larr;</span> 古いコメント'); ?></div>
				<div class="nav-next"><?php next_comments_link('新しいコメント <span class="meta-nav">&rarr;</span>'); ?></div>
			</div><!-- .navigation -->
<?php endif; // check for comment navigation ?>

<?php else : ?>

<?php endif; // end have_comments() ?>

<?php comment_form(); ?>

</div><!-- #comments -->
