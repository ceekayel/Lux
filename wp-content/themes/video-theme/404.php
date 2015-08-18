<?php get_header(); ?>
			
			<div id="content">

				<div id="inner-content" class="row clearfix">
			
					<div id="main" class="large-9 medium-12 columns first clearfix" role="main">
						<?php if ( current_theme_supports( 'breadcrumb-trail' )) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>
						<article id="post-not-found" class="hentry clearfix">
						
							<header class="article-header">
								<h1><?php _e("Epic 404 - Article Not Found", "templatic"); ?></h1>
							</header> <!-- end article header -->
					
							<section class="entry-content">
								<p><?php _e("The article you were looking for was not found, but maybe try looking again!", "templatic"); ?></p>
							</section> <!-- end article section -->

							<section class="search">
							    <p><?php get_search_form(); ?></p>
							</section> <!-- end search section -->
						
							<footer class="article-footer">
							    <p><?php _e("This is the 404.php template.", "templatic"); ?></p>
							</footer> <!-- end article footer -->
					
						</article> <!-- end article -->
			
					</div> <!-- end #main -->

				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>