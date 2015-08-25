<?php
/*
Plugin Name: Templatic Shortcodes
Plugin URI: http://templatic.com
Description: A simple shortcode generator. Add buttons, columns, tabs, toggles and alerts to your theme.
Version: 1.0.7
Author: Templatic
Author URI: http://www.templatic.com
*/

ob_start();
@define('TSC_DOMAIN','templatic_shortcode');

$locale = get_locale();
load_textdomain( TSC_DOMAIN, plugin_dir_path( __FILE__ ).'languages/'.$locale.'.mo' );
@define('PLUGINS_VERSION','1.0.7');
@define('PLUGINS_SLUG','Templatic-Shortcodes/templatic_shortcodes.php');

/* for shortcode work in text widget */
add_filter( 'widget_text', 'shortcode_unautop');
add_filter( 'widget_text', 'do_shortcode');

include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); 
	/* for auto updates */
	
	if(strstr($_SERVER['REQUEST_URI'],'plugins.php')){
		require_once('wp-updates-plugin.php');
		new WPUpdatesShortcodePluginUpdater( 'http://templatic.com/updates/api/index.php', plugin_basename(__FILE__) );
	}
if(!class_exists('TemplaticShortcodes')){

	class TemplaticShortcodes
	{
		var $buttonName = 'ShortcodeSelector';
		var $buttonTitle = 'templatic';
		
		function __construct()
		{
			require_once( plugin_dir_path( __FILE__ ) .'shortcodes.php' );
			define('TEMPL_URI', plugin_dir_url( __FILE__ )); /* DEFINE PLUGIN ROOT FOLDER PATH */
			define('TEMPL_IMAGE_URI', plugin_dir_url( __FILE__ ).'images/'); /* DEFINE PLUGIN ROOT FOLDER PATH */
			
			add_action( 'wp_enqueue_scripts', array(&$this, 'templ_css_init'));
			add_action( 'wp_footer', array(&$this, 'templ_func_init'));
			add_action( 'admin_head', array(&$this, 'templ_func_admin_init'));
			add_action( 'wp_footer',         array(&$this, 'templatic_wp_head') );
			add_filter( 'attachment_link', array(&$this, 'attachment_link'), 20, 2 );
		}
		
		function templ_css_init(){
			wp_enqueue_style( 'shortcodes', TEMPL_URI. 'css/style.css',false);
		}
		function templatic_wp_head() {
			if(!is_home() && !is_front_page() && !is_search() && !is_archive()  && !is_404() && !isset($_REQUEST['page']) && !isset($_REQUEST['ptype']))
			{
		 ?>
			<script type="text/javascript">
			// <![CDATA[
				var $shorcode_gallery_popup = jQuery.noConflict();
				$shorcode_gallery_popup(document).ready(function($){
					$shorcode_gallery_popup(".gallery").each(function(index, obj){
						var galleryid = Math.floor(Math.random()*10000);
						$shorcode_gallery_popup(obj).find("a").colorbox({rel:galleryid, maxWidth:"95%", maxHeight:"95%"});
					});
					$shorcode_gallery_popup("a.lightbox").colorbox({maxWidth:"95%", maxHeight:"95%"});
				});
			// ]]>
			</script>
	<?php
			}
			/* Remove extra <p></p> from woocommerce cart page */
			if(is_page()){
				global $post;
				if($post->ID == get_option('woocommerce_cart_page_id') || $post->ID == get_option('woocommerce_checkout_page_id') || $post->ID == get_option('woocommerce_pay_page_id') || $post->ID == get_option('woocommerce_thanks_page_id') || $post->ID == get_option('woocommerce_myaccount_page_id') || $post->ID == get_option('woocommerce_edit_address_page_id') || $post->ID == get_option('woocommerce_view_order_page_id') || $post->ID == get_option('woocommerce_change_password_page_id') || $post->ID == get_option('woocommerce_logout_page_id') || $post->ID == get_option('woocommerce_lost_password_page_id') ){
					remove_filter( 'the_content', 'wpautop',12 );
				}
			}
			/* Remove extra <p></p> from woocommerce cart page end */
		}
		function attachment_link( $link, $id ) {
			// The lightbox doesn't function inside feeds obviously, so don't modify anything
			if ( is_feed() || is_admin() )
				return $link;
	
			$post = get_post( $id );
	
			if ( 'image/' == substr( $post->post_mime_type, 0, 6 ) )
				return wp_get_attachment_url( $id );
			else
				return $link;
		}
		function templ_func_init(){
			if( ! is_admin() ){
				wp_enqueue_script('jquery');
				wp_enqueue_script('jquery-ui-core');	

				/* load light box js on detail page and on pages only */	
				if(is_single() || (is_page() && !is_front_page()))
					wp_enqueue_script( 'templatic_colorbox', plugins_url( 'js/jquery.colorbox-min.js', __FILE__ ), array( 'jquery' ), '1.3.14' );
			    wp_enqueue_script('bootstrap',TEMPL_URI . 'js/bootstrap-mini.js', false, '', true );
				wp_reset_query();				
			}
		}
		
		
		function addSelector(){
			/* Don't bother doing this stuff if the current user lacks permissions*/
			if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
				return;
	 
		    if ( get_user_option('rich_editing') == 'true')
			{
				add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
				add_filter('mce_buttons', array($this, 'registerButton'));
		    }
		}
	 
		function registerButton($buttons){
			array_push($buttons, "separator", $this->buttonName);
			return $buttons;
		}
	 
		function registerTmcePlugin($plugin_array){
			$plugin_array[$this->buttonName] = plugin_dir_url( __FILE__ ) . 'templ_plugin.php';
			if ( get_user_option('rich_editing') == 'true') 
			return $plugin_array;
		}
		
		function templ_func_admin_init()
		{
			/* LOAD THE JS FILE */
			?>
               <style>
               #menu_content_content_ShortcodeSelectorList_menu #menu_content_content_ShortcodeSelectorList_menu_tbl .mceFirst{display:none;}
               </style>
               <?php
			wp_enqueue_script( 'admin-shortcodes.js	', TEMPL_URI . 'js/admin_shortcodes.js	');
		}
	}

}

if(!isset($shortcodesES)){
	$shortcodesES = new TemplaticShortcodes();
	add_action('admin_head', array($shortcodesES, 'addSelector'));
}

function templ_addsample_shortcodedata()
{
	include_once(plugin_dir_path( __FILE__ ) .'sample_shortcodes.php');
}
add_action('wp_ajax_templatic_shortcodes','templatic_shortcodes_update_login', 10);
/*
 * Update Templaic Shortcodes plugin version after templatic member login
 */

function templatic_shortcodes_update_login()
{	
	check_ajax_referer( 'templatic_shortcodes', '_ajax_nonce' );
	$plugin_dir = rtrim( plugin_dir_path(__FILE__), '/' );	
	require_once( $plugin_dir .  '/templatic_login.php' );	
	exit;
}

register_activation_hook( __FILE__,'templ_addsample_shortcodedata'); /* Register Activation hook */

?>