<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
	<header class="article-header">
				<h1><?php the_title(); ?></h1>
				<?php get_template_part( 'partials/content', 'byline' ); ?>
				</p>							
	</header> <!-- end article header -->
							
	<section class="entry-content clearfix" itemprop="articleBody">
				<?php the_post_thumbnail('full'); ?>
				<?php the_content(); ?>
	</section> <!-- end article section -->
								
	<footer class="article-footer">
		    <p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'templatic') . '</span> ', ', ', ''); ?></p>
	</footer> <!-- end article footer -->
	<div class="author_cont">
	<div class="author_photo">
	<?php
		$description=get_user_meta($post->post_author,'description',true);
		 $user_info = get_userdata($post->post_author);
	?>
	   <article id="post-author">
			<div class="profile-image">
				<?php echo get_avatar($post->post_author );  ?>
			</div>
			<div class="profile-content">
				<h5><a href="<?php echo get_author_posts_url( $user_info->ID, $user_info->user_nicename ); ?>" class="author_name"><strong><?php echo $user_info->display_name; ?></strong></a></h5>
				<p> <?php echo $description; ?></p>
				
			</div>
		</article>
	</div>	
	</div>	
</article>
