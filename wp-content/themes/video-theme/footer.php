		<footer class="footer" role="contentinfo">
			<div id="inner-footer" class="row clearfix">
				<?php
				if(is_active_sidebar('footer_content')){ ?>
					<div class="large-12 medium-12 columns footer-widget">
						<?php dynamic_sidebar('footer_content'); ?>
					</div>
				<?php } ?>
				<div class="footer-bottom"> 
					<div class="large-12 medium-12 columns">		
						<div class="columns footer-meta">
							<p class="source-org copyright left">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>
							<?php if(tmpl_get_theme_settings('footer_insert')){  
								 echo do_shortcode(tmpl_get_theme_settings( 'footer_insert' ));  // customizer footer
							}?>
						</div>
					</div>		
				</div>
			</div> <!-- end #inner-footer -->			
		</footer> <!-- end .footer -->
		</div> <!-- end #container -->
	</div> <!-- end .inner-wrap -->
</div> <!-- end .off-canvas-wrap -->
				
<!-- all js scripts are loaded in library/templatic.php -->
<?php wp_footer(); ?>
</body>
<!-- Bodu End -->
</html> <!-- end page -->
