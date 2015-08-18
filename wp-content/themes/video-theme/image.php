<?php 
/*
This is the post single template.
For - Post detail
*/
get_header(); ?>
			
<div id="content">
	
	<div id="inner-content" class="row clearfix">
		
		<div id="main" class="large-9 medium-12 columns first clearfix" role="main">
			<?php if ( current_theme_supports( 'breadcrumb-trail' )) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); 
			
			 if (have_posts()) :
			  ?>
			 <div id="single-post-main" class="clearfix"></div>
				<?php while (have_posts()) : the_post(); ?>	
					<div class="entry-attachment">
						<div class="attachment">
							<?php video_the_attached_image(); /* get the image on gallery detail page. */?>
						</div><!-- .attachment -->
					</div>
				<!-- Author box -->
				<div class="author_cont">
					<div class="author_photo">
					<?php
						$description=get_user_meta($post->post_author,'description',true); /* get user description/biography */
						$user_info = get_userdata($post->post_author); /* to get the all information of user */
					?>
					   <article id="post-author">
							<div class="profile-image">
								<?php echo get_avatar($post->post_author ); /* Get user Photo/gravtar */  ?>
							</div>
							<div class="profile-content">
								<h5><a href="<?php echo get_author_posts_url( $user_info->ID, $user_info->user_nicename ); ?>" class="author_name"><strong><?php echo $user_info->display_name; ?></strong></a></h5>
								<p> <?php echo $description; ?></p>
								
							</div>
						</article>
					</div>	
				</div>	
				<!-- Author box End -->				
			   <?php comments_template();
			    endwhile;
			  else : 
					get_template_part( 'partials/content', 'missing' ); 

			 endif; ?>

		</div> <!-- end #main -->

		  <!-- Post Detail  Page sidebar -->
		<div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">

				<?php if ( is_active_sidebar( 'post_detail_sidebar' ) ) : ?>

					<?php dynamic_sidebar( 'post_detail_sidebar' ); ?>

				<?php else : ?>

				<!-- This content shows up if there are no widgets defined in the backend. -->
									
				<?php dynamic_sidebar( 'sidebar1' ); ?>

				<?php endif; ?>

		</div>
		<!-- Post Detail Page sidebar End-->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>
