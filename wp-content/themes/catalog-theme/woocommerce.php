<?php
get_header(); // Loads the header.php template. ?>

	<?php if ( current_theme_supports( 'breadcrumb-trail' ) && hybrid_get_setting('supreme_show_breadcrumb')) breadcrumb_trail( array( 'separator' => '&raquo;' ) ); ?>

	<?php do_atomic( 'before_content' ); // supreme_before_content ?>

	<div id="content">

		<?php do_atomic( 'open_content' ); // supreme_open_content ?>

		<div class="hfeed">
			
			<?php get_sidebar( 'before-content' ); // Loads the sidebar-before-content.php template. ?>

			<?php if ( have_posts() ) : ?>
					<?php woocommerce_content(); ?>
			<?php endif; ?>
			
			<?php get_sidebar( 'after-content' ); // Loads the sidebar-after-content.php template. ?>

		</div><!-- .hfeed -->

		<?php do_atomic( 'close_content' ); // supreme_close_content ?>

	</div><!-- #content -->

	<?php do_atomic( 'after_content' ); // supreme_after_content ?>

<?php get_footer(); // Loads the footer.php template. ?>