<?php
/**
 * Product reviews template
 *
 * DISCLAIMER
 *
 * Do not edit or add directly to this file if you wish to upgrade Jigoshop to newer
 * versions in the future. If you wish to customise Jigoshop core for your needs,
 * please use our GitHub repository to publish essential changes for consideration.
 *
 * @package		Jigoshop
 * @category	Catalog
 * @author		Jigowatt
 * @copyright	Copyright (c) 2011-2012 Jigowatt Ltd.
 * @license		http://jigoshop.com/license/commercial-edition
 */
 ?>

<?php if ( comments_open() ) : ?>

	<div id="reviews">
	
	<?php

	echo '<div id="comments">';

	$count = $wpdb->get_var("
		SELECT COUNT(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $post->ID
		AND comment_approved = '1'
		AND meta_value > 0
	");

	$rating = $wpdb->get_var("
		SELECT SUM(meta_value) FROM $wpdb->commentmeta
		LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
		WHERE meta_key = 'rating'
		AND comment_post_ID = $post->ID
		AND comment_approved = '1'
	");

	if ( $count>0 ) :

		$average = number_format($rating / $count, 2);

		echo '<div class="hreview-aggregate">';

		echo '<div class="star-rating" title="'.sprintf(__('Rated %s out of 5', 'supreme'),$average).'"><span style="width:'.($average*16).'px"><span class="rating">'.$average.'</span> '.__('out of 5', 'supreme').'</span></div>';

		echo '<h2>'.sprintf( _n('%s Review', '%s reviews', $count, 'supreme'), '<span class="count">'.$count.'</span>' ).'</h2>';

		echo '</div>';

	else :
		echo '<h2>'.__('Reviews', 'supreme').'</h2>';
	endif;

	$title_reply = '';

	if ( have_comments() ) :

		echo '<ol class="commentlist">';

		wp_list_comments( array( 'callback' => 'jigoshop_comments' ) );

		echo '</ol>';

		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="navigation comment-pagination">
				<?php paginate_comments_links(); ?>
			</div>
		<?php endif;

		echo '<p class="add_review"><a href="#review_form" class="inline show_review_form button">'.__('Add Review', 'supreme').'</a></p>';

		$title_reply = __('Add a review', 'supreme');

	else :

		$title_reply = __('Be the first to review ', 'supreme').'&ldquo;'.$post->post_title.'&rdquo;';

		echo '<p>'.__('There are no reviews yet, would you like to <a href="#review_form" class="inline show_review_form">submit yours</a>?', 'supreme').'</p>';

	endif;

	$commenter = wp_get_current_commenter();

	echo '</div><div id="review_form_wrapper"><div id="review_form">';

	comment_form(array(
		'title_reply' => $title_reply,
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'fields' => array(
			'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name', 'supreme' ) . '</label> ' . '<span class="required">*</span>' .
			            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" /></p>',
			'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email', 'supreme' ) . '</label> ' . '<span class="required">*</span>' .
			            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" aria-required="true" /></p>',
		),
		'label_submit' => __('Submit Review', 'supreme'),
		'logged_in_as' => '',
		'comment_field' => '
			<p class="comment-form-rating"><label for="rating">' . __('Rating', 'supreme') .'</label><select name="rating" id="rating">
				<option value="">'.__('Rate...','supreme').'</option>
				<option value="5">'.__('Perfect','supreme').'</option>
				<option value="4">'.__('Good','supreme').'</option>
				<option value="3">'.__('Average','supreme').'</option>
				<option value="2">'.__('Not that bad','supreme').'</option>
				<option value="1">'.__('Very Poor','supreme').'</option>
			</select></p>
			<p class="comment-form-comment"><label for="comment">' . _x( 'Your Review', 'noun', 'supreme' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'
			. jigoshop::nonce_field('comment_rating', true, false)
	));

	echo '</div></div>';
	

?>

	</div><!-- #reviews -->
	
	<script type="text/javascript">
/* <![CDATA[ */
	jQuery(function(){
		jQuery('#review_form_wrapper').hide();
		if (jigoshop_params.load_fancybox) {
			jQuery('a.show_review_form').prettyPhoto({
				animation_speed: 'normal', /* fast/slow/normal */
				slideshow: 5000, /* false OR interval time in ms */
				autoplay_slideshow: false, /* true/false */
				show_title: false,
				theme: 'pp_default', /* pp_default / light_rounded / dark_rounded / light_square / dark_square / facebook */
				horizontal_padding: 50,
				opacity: 0.7,
				deeplinking: false,
				social_tools: false
			});
		}
		// Star ratings for comments
		jQuery('#rating').hide().before('<p class="stars"><span><a class="star-1" href="#">1</a><a class="star-2" href="#">2</a><a class="star-3" href="#">3</a><a class="star-4" href="#">4</a><a class="star-5" href="#">5</a></span></p>');

		jQuery('body').on( 'click', '#respond p.stars a', function() {
			var $star   = jQuery(this);
			var $rating = jQuery(this).closest('#respond').find('#rating');

			$rating.val( $star.text() );
			$star.siblings('a').removeClass('active');
			$star.addClass('active');

			return false;
		}).on( 'click', '#respond #submit', function() {
			var $rating = jQuery(this).closest('#respond').find('#rating');
			var rating  = $rating.val();
			if ( $rating.size() > 0 && ! rating ) {
				alert("<?php _e('Please select a star to rate your review.','supreme'); ?>");
				return false;
			}
		});
	});
/* ]]> */
</script>

<?php endif; ?>