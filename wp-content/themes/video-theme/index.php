<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="row clearfix">
			
				    <div id="main" class="large-9 medium-12 columns clearfix" role="main">
						<?php if ( current_theme_supports( 'breadcrumb-trail' )) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); 
						if (have_posts()) :   
						while (have_posts()) : the_post(); ?>
								<div class="main-view clearfix">
								<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
									<header class="article-header">
												<h1><a href="<?php echo get_permalink($post->ID); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
												<?php //get_template_part( 'partials/content', 'byline' ); ?>
												</p>							
									</header> <!-- end article header -->
															
									<section class="entry-content clearfix" itemprop="articleBody">
												<?php the_post_thumbnail('full'); ?>
												<?php the_content('<span class="moretext clearfix">'.__('Continue Reading ','templatic').'<i class="fa fa-angle-double-right"></i>
</span>'); ?>
									</section> <!-- end article section -->
																
									<footer class="article-footer">
											<p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'templatic') . '</span> ', ', ', ''); ?></p>
									</footer> <!-- end article footer -->
								</article>
								<hr>
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
					    else : 
							get_template_part( 'partials/content', 'missing' ); 
					
					    endif; ?>
			
				    </div> <!-- end #main -->
					
					<!-- Category page sidebar -->
					<div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">
				    <?php 
				    if(is_home() && get_option('show_on_front')=='page' && get_option('page_for_posts') != '')
				    {
						dynamic_sidebar( 'post_category_sidebar' );
					}
				    else
				    {			    
						dynamic_sidebar( 'sidebar1' );
					}?>
				    </div>
					<!-- Category page sidebar #end-->
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>