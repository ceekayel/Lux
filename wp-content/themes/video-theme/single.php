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
				while (have_posts()) : the_post(); 
					
					get_template_part( 'partials/content'); /* call standard content post */
				
					comments_template();
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
		<!-- Post Detail  Page sidebar End-->

	</div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>