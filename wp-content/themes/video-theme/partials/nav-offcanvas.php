<!-- Navigation - Desktop Devices -->
<div class="large-12 columns show-for-large-up hide-for-xsmall-only">
	<div>
	
		<!-- If you want to use the more traditional "fixed" navigation.
		 simply replace "sticky" with "fixed" -->
	
		<nav class="top-bar" data-topbar>
			<ul class="title-area">
				<!-- Title Area -->
				<li class="toggle-topbar menu-icon">
					<a href="#"><span>Menu</span></a>
				</li>
			</ul>	
			
			<section class="top-bar-section">
				<?php tmpl_main_nav(); /* Header navigation menu */ ?>
			</section>
			
		</nav>
	</div>
</div>
<!-- #End Desktop Devices -->

<!-- Small devices - show site title e.g width <= 480px -->
<div class="large-12 columns hide-for-large-up lpn rpn">
	<div class="contain-to-grid">
		<nav class="tab-bar">
			<section class="middle tab-bar-section">
				<h1 class="title"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php 
				if(tmpl_get_theme_settings('tmpl_logo_url')){
					echo '<img src="'.tmpl_get_theme_settings('tmpl_logo_url').'" />';
				}else{
					bloginfo('name');
				}	
				?></a></h1>
			</section>
			<section class="left-small">
				<a class="left-off-canvas-toggle menu-icon" ><span></span></a>
			</section>
		</nav>
	</div>
</div>
<!-- Small devices Navigation  e.g width <= 480px -->						
<aside class="left-off-canvas-menu hide-for-large-up">
	<?php if ( is_active_sidebar( 'offcanvas' ) ) : ?>
		<?php dynamic_sidebar( 'offcanvas' ); /* Header navigation menu */?>
	<?php else: ?>
	<ul class="off-canvas-list">
		<li><label><?php _e('Navigation','templatic'); ?></label></li>
			<?php tmpl_main_nav(); ?>    
	</ul>
	<?php endif; ?>
	<ul class="nav-search lmn">
      <!-- Search | has-form wrapper -->
      <li class="has-form">
        <?php dynamic_sidebar('header_right'); // Header right side bar (e.g. to show search text box type widget  )  ?>
      </li>
    </ul>
</aside>
<a class="exit-off-canvas"></a>
