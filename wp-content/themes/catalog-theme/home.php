<?php
/**
 * Home Template
 *
 * This is the home template.  Technically, it is the "posts page" template.  It is used when a visitor is on the 
 * page assigned to show a site's latest blog posts.
 *
 * @package Catalog
 * @subpackage Template
 */

get_header(); // Loads the header.php template. ?>

<?php do_atomic( 'before_content' ); // supreme_before_content ?>

<?php //if ( current_theme_supports( 'breadcrumb-trail' ) && !is_home()) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>
<?php 
		$val = hybrid_get_setting( 'templ_listing_view' );
		if($val =='grid'){
			$class ='templ-grid';
		}else{
			$class ='templ-list';
		}
	 
?>

<div class="content" id="content">

	<?php do_atomic( 'open_content' ); // supreme_open_content ?>
	
	<div class="hfeed <?php echo $class; ?>">
	
		<?php get_template_part( 'loop-meta' ); // Loads the loop-meta.php template. ?>
	
		<?php get_sidebar( 'before-content' ); // Loads the sidebar-before-content.php template. ?>
		
		<?php
			if(is_home()){
				dynamic_sidebar( 'catalog_home_content_widget_area' );
			}else{
				if( hybrid_get_setting( 'supreme_frontpage_display_excerpt' ) ) {
					get_template_part( 'loop', 'excerpt' ); // Loads the loop-excerpt.php template.
				} else {
					get_template_part( 'loop' ); // Loads the loop.php template.
				
				}
			}
		?>	
		
		<?php get_sidebar( 'after-content' ); // Loads the sidebar-after-content.php template. ?>
		
	</div><!-- .hfeed -->
	
	<?php do_atomic( 'close_content' ); // rainbow_close_content ?>
	
	<?php //get_template_part( 'loop-nav' ); // Loads the loop-nav.php template. ?>

</div><!-- #content -->

<?php do_atomic( 'after_content' ); // rainbow_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>