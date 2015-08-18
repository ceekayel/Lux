<?php
/**
 * Footer Template
 *
 * The footer template is generally used on every page of your site. Nearly all other
 * templates call it somewhere near the bottom of the file. It is used mostly as a closing
 * wrapper, which is opened with the header.php file. It also executes key functions needed
 * by the theme, child themes, and plugins. 
 *
 * @package Catalog
 * @subpackage Template
 */
 remove_action('posts_where','templatic_searching_filter_where');
?>			
			<?php 
				global $wp_query,$post;
				$page_template=get_post_meta($post->ID,'_wp_page_template',true);
				$add_listing_page = get_post_meta( $wp_query->post->ID, '_wp_page_template', true );				
				$post_type = $post->post_type;
				/*get flag to check if woocommerce is active or not*/
				$is_woo_active = check_if_woocommerce_active();
				/*get flag to check if woocommerce is active or not*/
				if($is_woo_active == 'true' && $post_type =='product'){
					echo '<div id="sidebar-primary" class="sidebar">';
						dynamic_sidebar( 'woocommerce_sidebar' );
					echo '</div>';
				}elseif(!is_page_template('page-template-full_page.php') && !is_page_template('page-template-short_code.php')){
			?>
			
			
				<?php get_sidebar( 'primary' ) // Loads the sidebar-primary template. ?>
				
				<?php get_sidebar( 'secondary' ) // Loads the sidebar-secondary template. ?>
			
			<?php } do_atomic( 'close_main' ); // supreme_close_main ?>

			</div><!-- .wrap -->

		</div><!-- #main -->
		
		<?php do_atomic( 'after_main' ); // supreme_after_main ?>

	</div></div><!-- #container -->

	<?php do_atomic( 'close_body' ); // supreme_close_body ?>
		
	<?php //get_sidebar( 'subsidiary' ); // Loads the sidebar-subsidiary.php template. ?>
	<?php //get_sidebar( 'subsidiary-2c' ); // Loads the sidebar-subsidiary-2c.php template. ?>
	<?php //get_sidebar( 'subsidiary-3c' ); // Loads the sidebar-subsidiary-3c.php template. ?>
	<?php //get_sidebar( 'subsidiary-4c' ); // Loads the sidebar-subsidiary-4c.php template. ?>
	<?php //get_sidebar( 'subsidiary-5c' ); // Loads the sidebar-subsidiary-5c.php template. ?>

	<?php //get_template_part( 'menu', 'subsidiary' ); // Loads the menu-subsidiary.php template. ?>
		
		
	<?php do_atomic( 'before_footer' ); // supreme_before_footer ?>

	<div class="footerbg">
        <div id="footer">
    
    		<?php do_atomic( 'open_footer' ); // supreme_open_footer ?>
            <div class="footer_widgets">
            	<div class="footer_col1"><?php if(function_exists('dynamic_sidebar')){dynamic_sidebar('footer1');} ?></div>
                <div class="footer_col2"><?php if(function_exists('dynamic_sidebar')){dynamic_sidebar('footer2');} ?></div>
                <div class="footer_col3"><?php if(function_exists('dynamic_sidebar')){dynamic_sidebar('footer3');} ?></div>
                <div class="clearfix"></div>
            </div>
			<div class="footer-wrap">
    			
    			<?php get_template_part( 'menu', 'footer' ); // Loads the menu-primary.php template. ?>
    
    			<div class="footer-content">
    				<?php echo apply_atomic_shortcode( 'footer_content', hybrid_get_setting( 'footer_insert' ) ); ?>
    			</div><!-- .footer-content -->
    
    			<?php do_atomic( 'footer' ); // supreme_footer ?>
    
    		</div><!-- .wrap -->
    
    		<?php do_atomic( 'close_footer' ); // supreme_close_footer ?>
            
            
    
    	</div><!-- #footer -->
        <div class="clearfix"></div>
    </div>

	<?php do_atomic( 'after_footer' ); // supreme_after_footer ?>

	<?php wp_footer(); // wp_footer ?>

</body>
</html>