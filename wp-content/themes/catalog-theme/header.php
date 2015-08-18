<?php
/**
 * Header Template
 *
 * The header template is generally used on every page of your site. Nearly all other templates call it 
 * somewhere near the top of the file. It is used mostly as an opening wrapper, which is closed with the 
 * footer.php file. It also executes key functions needed by the theme, child themes, and plugins. 
 *
 * @package Catalog
 * @subpackage Template
 */
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title><?php hybrid_document_title(); ?></title>
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="all" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php 
		$GetSupremeThemeOptions = get_option('supreme_theme_settings');
		if(isset($GetSupremeThemeOptions['supreme_favicon_icon'])){
			$GetFaviconIcon = $GetSupremeThemeOptions['supreme_favicon_icon'];
		}
		if(isset($GetFaviconIcon)){
	 ?>
			<link rel="shortcut icon" type="image/png" href="<?php echo $GetFaviconIcon; ?>">
	<?php 
		}
	?>
	<?php 
		$catalog_theme_settings = get_option('supreme_theme_settings');
		if ( isset($catalog_theme_settings['customcss']) && $catalog_theme_settings['customcss']==1 ) { ?>
			<link href="<?php echo get_stylesheet_directory_uri(); ?>/custom.css" rel="stylesheet" type="text/css" />
	<?php } ?>
	<?php wp_head(); // wp_head ?>
	<?php /*<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery.flexslider-min.js"></script>*/?>
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/flexslider.css" type="text/css" media="screen" />
</head>

<body class="<?php hybrid_body_class(); ?>">
	<?php do_atomic( 'open_body' ); // supreme_open_body ?>
	<div class="header_bg">
		<?php 
			$theme_name = get_option('stylesheet');
			$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
			if(isset($nav_menu['nav_menu_locations']['primary']) && $nav_menu['nav_menu_locations']['primary'] != 0){
				get_template_part( 'menu', 'primary' ); // Loads the menu-primary.php template. 
			}else{?>
            	<div id="menu-primary" class="menu-container">
					<div class="wrap">
						<div id="menu-primary-title">
							<?php _e( 'Menu', 'supreme' ); ?>
						</div><!-- #menu-primary-title -->
						<div class="menu">
							<ul id="menu-primary-items" class="">
								<li>
									<a href="<?php echo home_url(); ?>/"><?php _e('Home','templatic');?></a>
								</li>
								<li>
									<?php $about_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'About Us'");?>
									<a href="<?php echo get_page_link($about_page_id);?>"><?php _e('About Us','templatic'); ?></a>
								</li>
								<li>
									<?php $primary_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'My Account'");?>
									<a href="<?php echo get_page_link($primary_id);?>"><?php _e('My Account','templatic'); ?></a>
									<ul class="sub-menu">
										<li>
											<?php $primary_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'My Account'");
											wp_list_pages("title_li=&post_type=page&child_of=$primary_id");
											//wp_list_pages();?>
										</li>
									</ul>
								</li>
							</ul>
						</div>	
					</div>
				</div>
        <?php	
			}
		?>
        <div class="clearfix"></div>
    </div>
    <div class="header_bg_down nav_container">
	<?php 
		do_atomic( 'after_menu_primary' ); // supreme_before_header 
		do_atomic( 'before_header' ); // supreme_before_header 
	?>
	<div id="header">
		<?php do_atomic( 'open_header' ); // supreme_open_header ?>
		<div class="header-wrap">
			<div id="branding">
				<?php if ( hybrid_get_setting( 'supreme_logo_url' ) ) : ?>	
						<h1 id="site-title">
							<a href="<?php echo home_url(); ?>/" title="<?php echo bloginfo( 'name' ); ?>" rel="Home">
								<img class="logo" src="<?php echo hybrid_get_setting( 'supreme_logo_url' ); ?>" alt="<?php echo bloginfo( 'name' ); ?>" />
							</a>
						</h1>
						
				<?php else : 
						hybrid_site_title();
					  endif;

					  if ( !hybrid_get_setting( 'supreme_site_description' ) )  : // If hide description setting is un-checked, display the site description. 
						hybrid_site_description(); 
					  endif;
				?>
				</div><!-- #branding -->
                <?php 
					if(function_exists('dynamic_sidebar')){
						dynamic_sidebar('header_advertisement');
						dynamic_sidebar('header_right');
					}
				?>
			</div><!-- .wrap -->
			<?php do_atomic( 'close_header' ); // supreme_close_header ?>
		</div><!-- #header -->
	<?php do_atomic( 'after_header' ); // supreme_after_header 
			if ( current_theme_supports( 'theme-layouts' ) ) {
				$supreme_layout = theme_layouts_get_layout();
				
				if ( $supreme_layout == 'layout-default' || $supreme_layout == 'layout-1c' || $supreme_layout == 'layout-2c-l' || $supreme_layout == 'layout-2c-r' || $supreme_layout == 'layout-3c-c' || $supreme_layout == 'layout-3c-l' || $supreme_layout == 'layout-3c-r' ) {
					$theme_name = get_option('stylesheet');
					$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
					if(isset($nav_menu['nav_menu_locations']['secondary']) && $nav_menu['nav_menu_locations']['secondary'] != 0){
						get_template_part( 'menu', 'secondary' ); // Loads the menu-secondary.php template.
					}elseif(is_active_sidebar('mega_menu')){
						if(function_exists('dynamic_sidebar')){
							dynamic_sidebar('mega_menu');
						}	
					}else{?>
						<div id="menu-secondary" class="menu-container">
							<div class="wrap">
								<div id="menu-secondary-title">
									<?php _e( 'Menu', 'supreme' ); ?>
								</div><!-- #menu-secondary-title -->
								<?php 
									 global $wpdb,$current_term,$wp_query,$page;
									 $page_title = @$wp_query->query['pagename'];
									 $current_term = $wp_query->get_queried_object();
									 global $current_term,$post;
									 $slug = @$current_term->slug;
									 $shop = @$current_term->name;
									 $post_type = @$current_term->post_type;
									 //echo "<pre/>";
									 //print_r($current_term);
								?>
							<div class="nav_bg">
								<div class="menu">
									<ul id="menu-header-horizontal-items">
										<li class="<?php if (!is_tax() && !is_category() && !is_page() && !is_single() && !$slug && is_home()) { ?> current-menu-item current-page-item <?php } ?>">
										<a href="<?php echo home_url(); ?>/"><?php _e('Home','templatic');?></a>
										</li>
									
										<li class="<?php if($shop =='product' || $post_type == 'product'){ echo 'current-menu-item current-page-item';}?>">
										<?php $id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_name like 'shop' and post_type='page'");?>
											<a href="<?php echo get_page_link($id); ?>"/><?php _e('Shop','templatic'); ?></a>
										</li>
										<li class="<?php if($slug =='blog' || $post_type == 'post'){ echo 'current-menu-item current-page-item';}?>">
										<?php $id = $wpdb->get_var("SELECT term_id FROM $wpdb->terms where name like 'Blog'");
											  $link = get_category_link( $id );?>
										<a href="<?php echo $link; ?>"/><?php _e('Blog','templatic'); ?></a>
										</li>
										
										<li class="<?php if($page_title!="" && !$slug){ echo 'current-menu-item current-page-item';}?>">
											<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");?>
											<a href="<?php echo get_page_link($page_id);?>"><?php _e('Page Templates','templatic'); ?></a>
											<ul class="sub-menu">
												<li class="<?php if($page_title!="" && !$slug){ echo 'current-menu-item current-page-item';}?>">
													<?php $page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Page Templates'");
													wp_list_pages("title_li=&post_type=page&child_of=$page_id");
													//wp_list_pages();?>
												</li>
											</ul>
										</li>
									</ul>
								</div>
                                <div class="clearfix"></div>
                           </div>     
							</div>
						</div>
					<?php	
					}
				}
			}?>
        <div class="clearfix"></div>
	</div>
	<?php if(is_home()){?>		
			<div class="slider_content">
	<?php		dynamic_sidebar('home-page-slider-widget');?>
			</div>
	<?php } ?>
	
	<div id="container"><div class="container-wrap">
	
		<?php get_sidebar( 'after-header' ); // Loads the sidebar-after-header.php template.
			  get_sidebar( 'after-header-2c' ); // Loads the sidebar-after-header-2c.php template.
			  get_sidebar( 'after-header-3c' ); // Loads the sidebar-after-header-3c.php template.
			  get_sidebar( 'after-header-4c' ); // Loads the sidebar-after-header-4c.php template.
			  get_sidebar( 'after-header-5c' ); // Loads the sidebar-after-header-5c.php template.
			  do_atomic( 'before_main' ); // supreme_before_main ?>
	
		<div id="main">

			<div class="wrap">

			<?php do_atomic( 'open_main' ); // supreme_open_main ?>