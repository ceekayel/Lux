<?php
/*
The comments page
*/

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="alert help">
    	<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments.", "templatic"); ?></p>
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<h3 id="comments" class="h2"><?php comments_number(__('<span>No</span> Responses', 'templatic'), __('<span>One</span> Response', 'templatic'), _n(__('<span>%</span> Response','templatic'), __('<span>%</span> Responses ','templatic'), get_comments_number(),'templatic') ); _e(' to','templatic');?>  &#8220;<?php the_title(); ?>&#8221;</h3>

	
	<ol id="commentlist" class="commentlist">
		<?php wp_list_comments('avatar_size=62&type=comment&callback=tmpl_comments'); ?>
	</ol>
	
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	
	<!-- If comments are closed. -->
	<!--p class="nocomments"><?php _e("Comments are closed.", "templatic"); ?></p-->

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>

<section id="respond" class="respond-form">

	<h3 id="comment-form-title" class="h2"><?php comment_form_title( __('Leave a Reply', 'templatic'), __('Leave a Reply to %s', 'templatic' )); ?></h3>

	<div id="cancel-comment-reply">
		<p class="small"><?php cancel_comment_reply_link(); ?></p>
	</div>

	<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
  	<div class="alert help">
  		<p><?php printf( __('You must be %1$slogged in%2$s to post a comment.', 'templatic'), '<a href="'.wp_login_url( esc_url(get_permalink()) ).'">', '</a>' ); ?></p>
  	</div>
	<?php else : ?>

	<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<?php if ( is_user_logged_in() ) : ?>

	<p class="comments-logged-in-as"><?php _e("Logged in as", "templatic"); ?> <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php echo wp_logout_url(esc_url(get_permalink())); ?>" title="<?php _e("Log out of this account", "templatic"); ?>"><?php _e("Log out", "templatic"); ?> <?php _e("&raquo;", "templatic"); ?></a></p>

	<p><textarea name="comment" id="comment" placeholder="<?php _e('Your Comment here...', 'templatic'); ?>" ></textarea></p>

	<?php $tab_index = 2; else : ?>
	
	<p><textarea name="comment" id="comment" placeholder="<?php _e('Your Comment here...', 'templatic'); ?>" tabindex="1"></textarea></p>
	
	<ul id="comment-form-elements" class="clearfix">
		
		<li>
		  <label for="author"><?php _e("Name", "templatic"); ?> <?php if ($req) _e("(required)","templatic"); ?></label>
		  <input type="text" name="author" id="author" value="<?php echo esc_attr($comment_author); ?>" placeholder="<?php _e('Your Name*', 'templatic'); ?>" tabindex="2" <?php if ($req) echo "aria-required='true'"; ?> />
		</li>
		
		<li>
		  <label for="email"><?php _e("Mail", "templatic"); ?> <?php if ($req) _e("(required)","templatic"); ?></label>
		  <input type="email" name="email" id="email" value="<?php echo esc_attr($comment_author_email); ?>" placeholder="<?php _e('Your E-Mail*', 'templatic'); ?>" tabindex="3" <?php if ($req) echo "aria-required='true'"; ?> />
		  <small><?php _e("(will not be published)", "templatic"); ?></small>
		</li>
		
		<li>
		  <label for="url"><?php _e("Website", "templatic"); ?></label>
		  <input type="url" name="url" id="url" value="<?php echo esc_attr($comment_author_url); ?>" placeholder="<?php _e('Got a website?', 'templatic'); ?>" tabindex="4" />
		</li>
		
	</ul>

	<?php $tab_index = 5; endif; ?>
	
	<p>
	  <input name="submit" type="submit" id="submit" class="button"  value="<?php _e('Submit', 'templatic'); ?>" />
	  <?php comment_id_fields(); ?>
	</p>
	
	<?php do_action('comment_form', $post->ID); ?>
	
	</form>
	
	<?php endif; // If registration required and not logged in ?>
</section>

<?php endif; // if you delete this the sky will fall on your head ?>
