<?php 
/* Search page template */
get_header(); ?>
			
<div id="content">

	<div id="inner-content" class="row clearfix">

		<div id="main" class="large-9 medium-12 columns first clearfix" role="main">
			<h1 class="archive-title"><span><?php _e('Search Results for:', 'templatic'); ?></span> <?php echo esc_attr(get_search_query()); ?></h1>

			
			<?php /* Differentiate the vidoe and post search */
			if(!empty($_REQUEST['post_type']) && $_REQUEST['post_type'][0] == 'videos'){
				/* check if its search in video taxonomy */
				
				if(isset($_REQUEST['most_rated']) && $_REQUEST['most_rated']=='videos'){
					/* query to show most commented / reviewed videos */
					$args=array(	'post_type'=>'videos',	
					"s" =>$_REQUEST['s'],			    
						'orderby' => 'comment_count'
						
					);
				}
				elseif(isset($_REQUEST['most_viewed']) && $_REQUEST['most_viewed'] == 'videos'){
					/* query to show most viewed videos */
					$args=array('post_type'=>'videos',
						"s" =>$_REQUEST['s'],
						'meta_key' => 'post_views_count',
						'orderby' => 'meta_value_num',
						'meta_value_num'=>'post_views_count',
						'order' => 'DESC'
					);
				}
				else
				{
					/* query to show latest videos */
					$args=array('post_type'=>'videos',
							"s" =>$_REQUEST['s']
						);
				}
			}else
			{
				/* check if its search in posts */
				$args=array('post_type'=>'post',
						"s" =>$_REQUEST['s']
					);
			}
			$my_query = new WP_Query($args);
			if ($my_query->have_posts()) :
			global $post;
			
			/* Show the video specific tabs if post type is video */
			
			/* Vide HTML */
			if($post->post_type=='videos') { ?>
			<dl class="tabs radius">
				<?php 
				/* Set the within search results e.g. if after search select most rated tabe , the url should contain the search text too. */
				$search_link=$_SERVER['REQUEST_URI'];					    			
				if(false===strpos($search_link,'?')){
					$url_glue = '?';
				}else{
					$url_glue = '&amp;';	
				}
				if(strpos($search_link,'most_rated') != '')
				{
					$search_link = explode("&most_rated",$search_link);
					$search_link = $search_link[0];
				}
				if(strpos($search_link,'most_viewed') != '')
				{
					$search_link = explode("&most_viewed",$search_link);
					$search_link = $search_link[0];
				}
				?>
				<!-- Grid view /List view -->
				<?php  get_template_part('partials/tmpl','viewbuttons'); ?>
				<!-- #End-->
				<!-- #tabs start -->
				<dd class="<?php if(!isset($_REQUEST['most_rated']) && !isset($_REQUEST['most_viewed'])):?>active<?php endif;?>"><a href="<?php echo $search_link;?>"><?php _e('Latest','templatic'); ?></a></dd>
				<dd class="<?php if(!isset($_REQUEST['most_rated']) && ( isset($_REQUEST['most_viewed']))):?>active<?php endif;?>"><a href="<?php echo $search_link.$url_glue."most_viewed=videos";?>"><?php _e('Most Viewed','templatic'); ?></a></dd>
				<dd class="<?php if(isset($_REQUEST['most_rated'])):?>active<?php endif;?>"><a href="<?php echo $search_link.$url_glue."most_rated=videos";?>"><?php _e('Most Commented','templatic'); ?></a></dd>
				<!-- #tabs end -->
			</dl>
			
				<div class="tabs-content grid" id="video-cat-content">
				<div class="content thumbnails active" id="most_video_view">
					 <!-- Create json for video listing -->
					<?php 
					while ((have_posts())) : the_post(); 
						/* get video thumb nails */
						$video_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb');
						$video_img_x2 =  tmpl_get_image_withinfo($post->ID,'listing-post-retina-thumb'); // -retina
						
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
								<p class="clearfix"><?php the_excerpt();  ?></p>
							</div>
						</div>
						</div>
					
					<?php endwhile;
					/* pagination start */
					if (function_exists('tmpl_page_navi')) { ?>
					<?php tmpl_page_navi(); ?>
					<?php } else { ?>
					<nav class="wp-prev-next">
						<ul class="clearfix">
							<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "templatic")) ?></li>
							<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "templatic")) ?></li>
						</ul>
					</nav>
					<?php } /* pagination end  */  ?>
					<!-- Create json for video listing end -->
			</div>	
			</div>
			<?php 
			} elseif($post->post_type == 'post')
			{	 /* POST HTML */
			  while ((have_posts())) : the_post(); 
				?>
				
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
					
					<header class="article-header">	
						<h1 class="entry-title single-title" itemprop="headline"><a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php the_title(); ?></a></h1>
						<?php get_template_part( 'partials/content', 'byline' ); ?>
					</header> <!-- end article header -->
									
					<section class="entry-content clearfix" itemprop="articleBody">
						<?php the_post_thumbnail('full'); ?>
						<?php echo get_the_excerpt(); ?>
					</section> <!-- end article section -->
										
					<footer class="article-footer">
						<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'templatic') . '</span> ', ', ', ''); ?></p>	</footer> <!-- end article footer -->
													
																	
				</article> <!-- end article -->
				<?php
			 endwhile;  } ?>
			<?php
			else : /* show if there is no search results found */  ?>
		
				<article id="post-not-found" class="hentry clearfix">
					<header class="article-header">
						<h3><?php _e("Sorry, The page you're looking for cannot be found!", "templatic"); ?></h3>
					</header>
					<section class="entry-content">
						<p><?php echo sprintf( __("I can help you find the page you want to see, just help me with a few clicks please. I recommend you either <a href='%s'>go back</a>, go to <a href='%s'>home page</a> or simply search what you want to see below.",'templatic'),'javascript:history.back();',site_url()); ?></p>
					</section>
					<footer class="article-footer">
						<p><?php get_search_form(); ?></p>
					</footer>
				</article>
		
			<?php endif; ?>

		</div> <!-- end #main -->
	
		<?php get_sidebar(); ?>
	
	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>