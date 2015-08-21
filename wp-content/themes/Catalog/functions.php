<?php
/**
 * This is your child theme functions file.  In general, most PHP customizations should be placed within this
 * file.  Sometimes, you may have to overwrite a template file.  However, you should consult the theme 
 * documentation and support forums before making a decision.  In most cases, what you want to accomplish
 * can be done from this file alone.  This isn't a foreign practice introduced by parent/child themes.  This is
 * how WordPress works.  By utilizing the functions.php file, you are both future-proofing your site and using
 * a general best practice for coding.
 *
 * All style/design changes should take place within your style.css file, not this one.
 *
 * The functions file can be your best friend or your worst enemy.  Always double-check your code to make
 * sure that you close everything that you open and that it works before uploading it to a live site.
 *
 * @package Catalog
 * @subpackage Functions
 */

/* Adds the child theme setup function to the 'after_setup_theme' hook. */
//error_reporting(0);


if(is_admin() && ($pagenow =='themes.php' || $pagenow =='post.php' || $pagenow =='edit.php'|| $pagenow =='admin-ajax.php'  || @$_REQUEST['page'] == 'Catalog_tmpl_theme_update')){
	require_once('wp-updates-theme.php');
	if(function_exists('supreme_get_theme_data'))
		$theme_data = supreme_get_theme_data(get_stylesheet_directory().'/style.css');
	new WPUpdatesCatalogUpdater( 'http://templatic.com/updates/api/index.php',basename(get_stylesheet_directory()));
}

add_action( 'after_setup_theme', 'supreme_child_theme_setup', 11 );

/**
 * Setup function.  All child themes should run their setup within this function.  The idea is to add/remove 
 * filters and actions after the parent theme has been set up.  This function provides you that opportunity.
 *
 * @since 0.1.0
 */

global $pagenow;
if(is_admin() && 'customize.php' == $pagenow){
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this section.' ) );
	}
}
$currrent_theme_name = get_option('stylesheet');
$templatic_woocommerce_themes = get_option('templatic_woocommerce_themes');
update_option('templatic_woocommerce_themes',$templatic_woocommerce_themes.",".$currrent_theme_name);
function supreme_child_theme_setup() {
	/* Get the theme prefix ("supreme"). */
		$prefix = hybrid_get_prefix();
	/* Example action. */
	// add_action( "{$prefix}_header", 'dotos_child_example_action' );
	/* Example filter. */
	// add_filter( "{$prefix}_site_title", 'dotos_child_example_filter' );
	define('CATALOG_DOMAIN','templatic');
	define('TEMPLATE_CHILD_DIRECTORY_PATH',get_stylesheet_directory()."/");
	define('TEMPLATE_CHILD_DIRECTORY_URL',get_stylesheet_directory_uri()."/");
	define('TEMPLATE_FUNCTION_FOLDER_PATH',get_stylesheet_directory()."/functions/");
	add_theme_support( 'supreme-slider' );
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	global $blog_id,$upload_folder_path;
	if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
	{
		$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
	}else
	{
		$upload_folder_path = "wp-content/uploads/";
	}
	
	add_action( 'customize_register',  'catalog_register_customizer_settings');
	add_image_size('discount_thumbs', 48, 48, true ); //(cropped)
	add_image_size('category_thumbs', 218, 242, true ); //(cropped)
	add_image_size('home_slider', 980, 425, true ); //(cropped)
	add_image_size('small_slider_thumbs', 220, 220, true ); //(cropped)
	add_image_size('widget_slider_thumbs', 220, 220, true ); //(cropped)
	//add_action("widgets_init","templatic_widget_load");
	add_action("init","call_function");
	add_action('wp_head', 'templatic_load_theme_stylesheet');
	add_action('wp_enqueue_scripts', 'templatic_load_theme_scripts');
	add_action( 'load-appearance_page_theme-settings', 'catalog_theme_settings_meta_boxes' );
	add_action('admin_menu', 'ptthemes_taxonomy_meta_box');
	add_action('save_post', 'catalog_insert_post_type');
	include(TEMPLATE_FUNCTION_FOLDER_PATH.'auto_install/auto_install.php');
	add_theme_support( 'theme-layouts', array( // Add theme layout options.
		'1c',
		'2c-l',
		'2c-r'
		) );
	
	/* for bbPress. */
	
	if ( function_exists ( 'is_bbpress' ) ) {
	
		if ( function_exists( 'bbp_is_topic' ) ) {
			if ( bbp_is_topic() )
				wp_dequeue_script( 'supreme-bbpress-topic', trailingslashit( get_template_directory_uri() ) . 'js/bbpress-topic.js', array( 'wp-lists' ), false, true );
		}
				
		if( function_exists( 'bbp_is_single_user_edit' ) ) {
			if ( bbp_is_single_user_edit() )
				wp_dequeue_script( 'user-profile' );
		}
	
	}
	
	/* for BuddyPress */
	
	if ( function_exists ( 'bp_is_active' ) ) {

		wp_dequeue_style( 'bp' );

		/* Load BuddyPress-specific styles. */
		wp_dequeue_script ( 'supreme-buddypress', trailingslashit ( get_template_directory_uri() ) . 'css/buddypress.css', false, '20120608', 'all' );
	
	}
	
	
	if(file_exists(TEMPLATE_FUNCTION_FOLDER_PATH."custom_functions.php")){
		include_once(TEMPLATE_FUNCTION_FOLDER_PATH."custom_functions.php");
	}
	if(file_exists(TEMPLATE_FUNCTION_FOLDER_PATH."widget_functions.php")){
		include_once(TEMPLATE_FUNCTION_FOLDER_PATH."widget_functions.php");
	}
	if(file_exists(TEMPLATE_CHILD_DIRECTORY_PATH."language.php")){
		include_once(TEMPLATE_CHILD_DIRECTORY_PATH."language.php");
	}
}
function templatic_load_theme_stylesheet(){
	/*	Function to load the custom stylesheet. 
	from this if we select any color from 
	"Theme Color Settings" in backend and 
	save some color then then this file is called	*/
	include(TEMPLATE_CHILD_DIRECTORY_PATH.'css/admin-style.php');
}
function templatic_load_theme_scripts() {
    /*	This will include farbtastic css,js and fancybox css,js  */
		wp_enqueue_script( 'fancybox' );
		wp_enqueue_style( 'fancybox' );
	if(file_exists(TEMPLATE_FUNCTION_FOLDER_PATH."shortcodes.php")){
		include_once(TEMPLATE_FUNCTION_FOLDER_PATH."shortcodes.php");
	}
}
/* 
 *
 */
// add_action('wp_head','jquery_dataPicker'); // datepicker is not necessary in this
function jquery_dataPicker()
{
	/*
	 * Include jquery datepicker javascript and css file
	 */
	//wp_enqueue_script( 'jQuery_ui_core', TEMPLATE_CHILD_DIRECTORY_URL.'js/jquery.ui.core.js');
	wp_enqueue_script( 'jQuery_datepicker', TEMPLATE_CHILD_DIRECTORY_URL.'js/jquery.ui.datepicker.js');
	wp_enqueue_style( 'jQuery_datepicker_css',TEMPLATE_CHILD_DIRECTORY_URL.'css/datepicker/jquery.ui.all.css');
}

//ADDED CODE FOR FAVICON ICON SETTINGS START.
add_action('admin_head', 'Catalogfavocin_icon');
function Catalogfavocin_icon(){
	$GetSupremeThemeOptions = get_option('supreme_theme_settings');
	if(isset($GetSupremeThemeOptions['supreme_favicon_icon'])){
		$GetFaviconIcon = $GetSupremeThemeOptions['supreme_favicon_icon'];
	}
	if(isset($GetFaviconIcon)){
		echo '<link rel="shortcut icon" href="' . $GetFaviconIcon . '" />';
	}
}
//ADDED CODE FOR FAVICON ICON SETTINGS FINISH.

 /*
@Function Name: catalog_remove_shortcode_p_tag
@Filter: wp_head
@Return: remove p tags generated by shortcode plugin from woocommerce cart page when we add new product. 
*/
add_action('wp_head','catalog_remove_shortcode_p_tag');
if(!function_exists('catalog_remove_shortcode_p_tag')){
	function catalog_remove_shortcode_p_tag(){
		global $post;
		if(is_page()){
			global $post;
			if($post->ID == get_option('woocommerce_cart_page_id') || $post->ID == get_option('woocommerce_checkout_page_id') || $post->ID == get_option('woocommerce_pay_page_id') || $post->ID == get_option('woocommerce_thanks_page_id') || $post->ID == get_option('woocommerce_myaccount_page_id') || $post->ID == get_option('woocommerce_edit_address_page_id') || $post->ID == get_option('woocommerce_view_order_page_id') || $post->ID == get_option('woocommerce_change_password_page_id') || $post->ID == get_option('woocommerce_logout_page_id') || $post->ID == get_option('woocommerce_lost_password_page_id') ){
				remove_filter( 'the_content', 'wpautop',12 );
			}
		}
	}
}
?>