<?php
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>
			
			<div id="content">
			
				<div id="inner-content" class="row clearfix">
			
				    <div id="main" class="large-9 medium-12 columns first clearfix" role="main">
				    	<article class="row">
						    <section class="large-12 columns">
						<?php 
						if(is_active_sidebar('front_banner')){
								echo '<article class="row"> <section class="large-12 columns">';
								dynamic_sidebar('front_banner');
								echo "</section></article>";
						} ?>
						    </section>
						</article>
						<?php 
						if(is_active_sidebar('front_content')){
								echo '<article class="row"> <section class="large-12 columns">';
								dynamic_sidebar('front_content');
								echo "</section></article>";
						} ?>
					    
	
				    </div> <!-- end #main -->
    			   
	    			   <!-- Front  Page sidebar -->
					   <div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">

							<?php if ( is_active_sidebar( 'front_sidebar' ) ) : ?>

								<?php dynamic_sidebar( 'front_sidebar' ); ?>

							<?php else : ?>

							<!-- This content shows up if there are no widgets defined in the backend. -->
												
							<?php dynamic_sidebar( 'sidebar1' ); ?>

							<?php endif; ?>

						</div>
					 <!-- Front  Page sidebar End-->				    
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>
