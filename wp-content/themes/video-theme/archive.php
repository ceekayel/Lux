<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="row clearfix">
				
				    <div id="main" class="large-9 medium-12 columns first clearfix" role="main">
						<?php if ( current_theme_supports( 'breadcrumb-trail' )) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>
					    <?php if (is_category()) { ?>
						    <h1>
							    <span><?php _e("Topic:", "templatic"); ?></span> <?php single_cat_title(); ?>
					    	</h1>
					    
					    <?php } elseif (is_tag()) { ?> 
						    <h1>
							    <span><?php _e("Tagged:", "templatic"); ?></span> <?php single_tag_title(); ?>
						    </h1>
					    
					    <?php } elseif (is_author()) { 
					    	global $post;
					    	$author_id = $post->post_author;
					    ?>
						    <h1>

						    	<span><?php _e("Posts By:", "templatic"); ?></span> <?php echo get_the_author_meta('display_name', $author_id); ?>

						    </h1>
					    <?php } elseif (is_day()) { ?>
						    <h1>
	    						<span><?php _e("Daily Archives:", "templatic"); ?></span> <?php the_time('l, F j, Y'); ?>
						    </h1>
		
		    			<?php } elseif (is_month()) { ?>
			    		    <h1>
				    	    	<span><?php _e("Monthly Archives:", "templatic"); ?></span> <?php the_time('F Y'); ?>
					        </h1>
					
					    <?php } elseif (is_year()) { ?>
					        <h1>
					    	    <span><?php _e("Yearly Archives:", "templatic"); ?></span> <?php the_time('Y'); ?>
					        </h1>
					    <?php } 
						
							// Show an optional term description.
							$term_description = term_description();
							if ( ! empty( $term_description ) ) :
								printf( '<div class="taxonomy-description">%s</div>', $term_description );
							endif;
						
						if (have_posts()) : while (have_posts()) : the_post(); ?>
								<div class="main-view clearfix">
								<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
									<header class="article-header">
												<h1><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
												<?php //get_template_part( 'partials/content', 'byline' ); ?>
												</p>							
									</header> <!-- end article header -->
															
									<section class="entry-content clearfix" itemprop="articleBody">
												<?php the_post_thumbnail('full'); ?>
												<?php the_excerpt(); ?>
									</section> <!-- end article section -->
																
									<footer class="article-footer">
											<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'templatic') . '</span> ', ', ', ''); ?></p>
									</footer> <!-- end article footer -->
								</article>
								<hr>
								</div>
					    <?php endwhile; 
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
					
					     else : ?>
					
    						<?php get_template_part( 'partials/content', 'missing' ); ?>
					
					    <?php endif; ?>
			
    				</div> <!-- end #main -->
    
	    			<div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">
					<?php if ( is_active_sidebar( 'post_category_sidebar' ) ) : ?>

						<?php dynamic_sidebar( 'post_category_sidebar' ); ?>

					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the back end. -->
												
						<?php dynamic_sidebar('sidebar1'); ?>

					<?php endif; ?>
					</div>
                
                </div> <!-- end #inner-content -->
                
			</div> <!-- end #content -->

<?php get_footer(); ?>