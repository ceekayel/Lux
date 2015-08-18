<?php
/**
 * Comment Template
 *
 * The comment template displays an individual comment. This can be overwritten by templates specific
 * to the comment type (comment.php, comment-{$comment_type}.php, comment-pingback.php, 
 * comment-trackback.php) in a child theme.
 *
 * @package supreme
 * @subpackage Template
 */

	global $post, $comment;
?>

	<li id="comment-<?php comment_ID(); ?>" class="<?php hybrid_comment_class(); ?>">

		<?php do_atomic( 'before_comment' ); // supreme_before_comment ?>
	
		<div class="comment-wrap">
		
			<?php do_atomic( 'open_comment' ); // supreme_open_comment ?>

			<div class="comment-header">
				<?php echo hybrid_avatar(); ?>

				<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="comment-meta">[comment-author] [comment-published] [comment-permalink before=" . "] [comment-edit-link before=" . "]</div>' ); ?>
			</div><!-- .comment-header -->

			<div class="comment-content comment-text">
				<?php if ( '0' == $comment->comment_approved ) : ?>
					<?php echo apply_atomic_shortcode( 'comment_moderation', '<p class="alert moderation">' . __( 'Your comment is awaiting moderation.', 'supreme' ) . '</p>' ); ?>
				<?php endif; ?>

				<?php comment_text( $comment->comment_ID ); ?>
			</div><!-- .comment-content .comment-text -->
			<?php echo apply_atomic_shortcode( 'comment_meta', '<div class="templatic_comment">[comment-reply-link]</div>' ); ?>
			<?php do_atomic( 'close_comment' ); // supreme_close_comment ?>

		</div><!-- .comment-wrap -->

		<?php do_atomic( 'after_comment' ); // supreme_after_comment ?>

	<?php /* No closing </li> is needed.  WordPress will know where to add it. */ ?>