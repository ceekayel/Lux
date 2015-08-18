<?php
/*
This is the custom post type taxonomy template.
For - Fetch videos from video tags
*/

get_header(); ?>
			
<div id="content">

	<div id="inner-content" class="row clearfix">

		<div id="main" class="large-9 medium-12 columns first clearfix" role="main">
		<!-- Start header-->
		<header>
			<h1 class="archive-title"><?php single_cat_title(); ?></h1>
			<?php
			/* Show category description */
			global $wp_query, $post;
			$current_term = $wp_query->get_queried_object();	
			$category_link = get_term_link( $current_term->slug, CUSTOM_TAG_SLUG); 
			if( $current_term->name){
				$termid = $current_term->term_id; 
			}
			echo "<p>".term_description($termid,CUSTOM_TAG_SLUG )."</p>"; // fetch category description
			/* end category description */
			 ?>
		</header>
		<!-- End header-->
		<article class="row">
		<div class="columns">	
		 
										
			<?php					
			if (have_posts()) : ?>
					<dl class="tabs radius">
					<!-- Tabs -->
					<?php $term_link=get_term_link( get_query_var('videostags'), 'videostags' );					    			
						if(false===strpos($term_link,'?')){
							$url_glue = '?';
						}else{
							$url_glue = '&amp;';	
						}
					?>
					<!-- Grid view /List view -->
					<?php  get_template_part('partials/tmpl','viewbuttons'); ?>
					<!-- #End-->
					<dd class="<?php if(!isset($_REQUEST['most_rated']) && !isset($_REQUEST['most_viewed'])):?>active<?php endif;?>"><a href="<?php echo $term_link;?>"><?php _e('Latest','templatic'); ?></a></dd>
					<dd class="<?php if(!isset($_REQUEST['most_rated']) && ( isset($_REQUEST['most_viewed']) && $_REQUEST['most_viewed'] == 'videos') ):?>active<?php endif;?>"><a href="<?php echo $term_link.$url_glue."most_viewed=videos";;?>"><?php _e('Most Viewed','templatic'); ?></a></dd>
					<dd class="<?php if(isset($_REQUEST['most_rated'])):?>active<?php endif;?>"><a href="<?php echo $term_link.$url_glue."most_rated=videos";?>"><?php _e('Most Commented','templatic'); ?></a></dd>

					
				</dl>
					<!-- Tab start -->
					<div id="video-cat-content" class="tabs-content row grid">
						<div class="content thumbnails active" id="most_video_view">
						 <!-- Create json for video listing -->
						<?php 
						while ((have_posts())) : the_post(); 
								$video_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb');
								$video_img_x2 =  tmpl_get_image_withinfo($post->ID,'listing-post-retina-thumb'); // -retina
								$time = get_post_meta($post->ID,'time',true);
								$video_length='';
								if($time){
									$video_length='<li class="video-length"><span><i class="fa fa-clock-o"></i>'.$time.'</span></li>';
								}
								$comment='<li><a href="'.esc_url(get_permalink($post->ID)).'#respond"><i class="step fa fa-comment"></i>'.get_comments_number(get_the_ID()  ).'</a></li>';
								$byline = '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>'. tmpl_get_post_view($post->ID).'</span></span><cite class="fn"><i class="fa fa-clock-o"></i> '.get_the_time(get_option('date_format')).'</cite>'; ?>
							<div class="main-view clearfix">
							<div class="hover-overlay">
								<div class="view-img">
									<a href="<?php echo get_permalink($post->ID); ?>"><img data-interchange="[<?php echo $video_img[0]['file']; ?>, (default)], [<?php echo $video_img_x2[0]['file']; ?>, (retina)]" class="thumb-img" /><span class="video-overlay"><i class="fa fa-play-circle-o"></i></span></a>
								</div>
								<!-- Show video meta -->
								<div class='view-desc'>
									<h6><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title();  ?></a></h6>
									<span class="byline"><?php echo $byline; ?></span>
									<p class="clearfix"><?php the_excerpt(); ?></p>
								</div>
							</div>
							</div>
						
						<?php endwhile;
						/* Pagination start */
						if (function_exists('tmpl_page_navi')) { 
							 tmpl_page_navi(); 
							 } else { ?>
						<nav class="wp-prev-next">
							<ul class="clearfix">
								<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "templatic")) ?></li>
								<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "templatic")) ?></li>
							</ul>
						</nav>
						<?php } 
						/* Pagination end */
						?>
						<!-- Create json for video listing end -->
				</div>
				
				<?php else :
				
				get_template_part( 'partials/content', 'missing' ); 

				endif; ?>
					</div> <!-- Tab End .COLUMNS-->
				
		</article> <!--End Row -->
		</div> <!-- end #Column -->
		
	   <!-- Video category  Page sidebar -->
		<div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">

				<?php if ( is_active_sidebar( 'video_category_sidebar' ) ) : ?>

					<?php dynamic_sidebar( 'video_category_sidebar' ); ?>

				<?php else : ?>

				<!-- This content shows up if there are no widgets defined in the backend. -->
									
				<?php dynamic_sidebar( 'sidebar1' ); ?>

				<?php endif; ?>

		</div>
		<!-- Video category  Page sidebar End-->
		
	</div> <!-- end #inner-content -->

</div> <!-- end #content -->
<?php get_footer(); ?>