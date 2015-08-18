<!doctype html>

<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?>> <!--<![endif]-->

<head>
	
	<meta charset="utf-8">

	<title><?php wp_title(''); ?></title>

	<!-- Google Chrome Frame for IE -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<!-- mobile meta -->
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<?php
	/* display favicon icon */
	$favicon = tmpl_get_theme_settings('tmpl_favicon_icon');
	if(@$favicon ==''){
	$favicon = get_template_directory_uri()."/favicon.ico"; // favicon icon
	} 
	?>
	<link rel="icon" href="<?php echo $favicon; ?>">
	<?php 
   
    /* Set google font as per selection */
	$tmpl_google_fonts = tmpl_get_theme_settings('tmpl_google_fonts');
	if(isset($tmpl_google_fonts) && $tmpl_google_fonts != '')
	{
		if(strstr($tmpl_google_fonts,"+"))
		{
			$css_gogole_font = str_replace("+"," ",$tmpl_google_fonts);
		}else
		{
			$css_gogole_font = $tmpl_google_fonts;
		}
	  ?>
	<link href='http://fonts.googleapis.com/css?family=<?php echo $tmpl_google_fonts; ?>' rel='stylesheet' type='text/css'>
	<style>
	  html body, body .accordion dd > a, body button, body .button, body .label, body .pricing-table .title, body .pricing-table .price, body .side-nav, body .side-nav li.active > a:first-child:not(.button), body .sub-nav dt, body .sub-nav dd, body .sub-nav li, body .tabs dd > a, body .top-bar-section ul li > a, body h1, body h2, body h3, body h4, body h5, body h6, body .commentlist .comment-reply-link{font-family: '<?php echo $css_gogole_font; ?>', sans-serif;}
	</style>
	  <?php
	}
	/* End */
	
	/* Set Font Size */
	$tmpl_fonts_size = tmpl_get_theme_settings('tmpl_fonts_size');
	if(@tmpl_fonts_size)
	{ ?>
	<style  type='text/css'>
		html, body{font-size: <?php echo $tmpl_fonts_size."px !important;"; ?> }
	</style>
	<?php } 
	/* End */ ?>
	<!--[if IE]>
		<link rel="shortcut icon" href="<?php echo $favicon; ?>">
	<![endif]-->
	<meta name="msapplication-TileColor" content="#f01d4f">
	<meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/library/images/win8-tile-icon.png">

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	<link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Droid+Serif:400,700">
	<?php wp_head(); ?>
	<!-- Drop Google Analytics here -->
	<!-- end analytics -->
	<?php if(get_option('directory_custom_css'))
	{?>
	<link href="<?php echo get_template_directory_uri(); ?>/custom.css" rel="stylesheet" type="text/css" />
	<?php 
	}?>
</head>

<?php /* Set Body background */
	@$tmpl_body_background_image_url = tmpl_get_theme_settings('tmpl_body_background_image_url');
 ?>
<body <?php body_class(); ?>  <?php if(@$tmpl_body_background_image_url){?> style="background-image:url(<?php echo $tmpl_body_background_image_url; ?>); " <?php } ?>>

<!-- #start off-canvas-wrap - Mobile menu navigation-->
<div class="off-canvas-wrap" data-offcanvas>
	<!-- #start inner-wrap container wrapper  -->
	<div class="inner-wrap">
		<div id="container">
		<?php 
		@$tmpl_header_background_image_url = tmpl_get_theme_settings('tmpl_header_background_image_url');
	    ?> 
		<header class="header" role="banner">

				<?php if ( has_nav_menu('footer-links') ) { ?>
				<nav role="navigation" class="top-nav show-for-large-up hide-for-xsmall-only">
					<div class="row">
						<div class="large-12 columns">	
							<?php tmpl_footer_links(); ?>
						</div>
					</div>
				</nav>
				<?php } ?>
			<div id="inner-header" class="row" <?php if(@$tmpl_header_background_image_url){?> style="background-image:url(<?php echo $tmpl_header_background_image_url; ?>); " <?php } ?>>
				<div class="large-12 columns show-for-large-up hide-for-xsmall-only">
					<div class="row">
						<div class="large-6 medium-6 columns">
							<h1>
								<?php 
								// site title
								if(tmpl_get_theme_settings('tmpl_logo_url')){ ?>
								<a href="<?php echo home_url(); ?>" rel="nofollow">
									<img src="<?php echo tmpl_get_theme_settings('tmpl_logo_url'); ?>" title="<?php bloginfo('description'); ?>"/>
								</a>
								<?php }elseif(tmpl_get_theme_settings('display_header_text')){ ?>
								<a href="<?php echo home_url(); ?>" rel="nofollow">
									<?php bloginfo('name'); ?>
								</a>
								<?php } 
								// site description
								if(tmpl_get_theme_settings('theme_site_description')){ ?>
									<small>
										<?php  bloginfo('description'); ?>
									</small>
								<?php } ?>
							</h1>
						</div>
						<div class="large-6 medium-6 columns">
							<?php
							/* if header right thann show it otherwise links */
							if ( is_active_sidebar( 'header_right' ) ) {
								dynamic_sidebar('header_right'); 
							}
							?>
							
						</div>
					</div>
				</div>
				<?php  get_template_part( 'partials/nav', 'offcanvas' ); ?>
			</div> <!-- end #inner-header -->

		</header> <!-- end header -->		