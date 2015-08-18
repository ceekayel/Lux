<?php
/**
 * Page Template
 *
 * This is the default page template.  It is used when a more specific template can't be found to display 
 * singular views of pages.
 */
get_header(); // Loads the header.php template. ?>
<?php 
	do_action( 'before_content' );
	do_action( 'templ_before_container_breadcrumb' );	?>
	<section id="content" class="section-main-content">
	   <?php do_action( 'open_content' ); 
	   do_action( 'templ_inside_container_breadcrumb' );	?>
	   	<div class="row clearfix">
			<div class="large-9 medium-12 columns first clearfix">
				<?php 
						if ( have_posts() ) :
							woocommerce_content(); 
						endif; 
					?>
			</div>
			<!-- page Sidebar -->
            <aside class="sidebar large-3 medium-12 columns">
            	<?php if ( is_active_sidebar( 'post_category_sidebar' ) ) : ?>
					<?php dynamic_sidebar( 'post_category_sidebar' ); ?>
				<?php else : ?>
					<!-- This content shows up if there are no widgets defined in the back end. -->
					<?php dynamic_sidebar('sidebar1'); ?>
				<?php endif; ?>
            </aside>
            <!-- page Sidebar #end-->
	  </div>
	  <?php do_action( 'close_content' ); ?>
	</section>
<!-- #content -->
<?php do_action( 'after_content' );
	
	get_footer(); // Loads the footer.php template. 
?>