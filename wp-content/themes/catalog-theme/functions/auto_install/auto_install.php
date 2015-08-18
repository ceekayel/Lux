<?php 
global $wpdb;
$a = get_option('supreme_theme_settings');
if(!isset($a['supreme_show_breadcrumb'])){
	$b = array(
			'supreme_show_breadcrumb'			=> 1,
			'supreme_site_description' 			=> 0,
			'supreme_archive_display_excerpt' 	=> 1,
			'supreme_frontpage_display_excerpt' => 1,
			'supreme_search_display_excerpt' 	=> 1,
			'supreme_header_primary_search' 	=> 0,
			'supreme_header_secondary_search' 	=> 0,
			'supreme_author_bio_posts' 			=> 0,
			'supreme_author_bio_pages' 			=> 0,
			'supreme_global_layout' 			=> $a['supreme_global_layout'],
			'supreme_bbpress_layout' 			=> $a['supreme_bbpress_layout'],
			'supreme_buddypress_layout' 		=> $a['supreme_buddypress_layout']
	);
	update_option('supreme_theme_settings',$b);
}
if(false == get_option( 'hide_ajax_notification' )){
	if(strstr($_SERVER['REQUEST_URI'],'themes.php')){
		$WooPluginFile = ABSPATH . 'wp-content/plugins/woocommerce/woocommerce.php';
		$JigoPluginFile = ABSPATH . 'wp-content/plugins/jigoshop/jigoshop.php';
		if(file_exists($WooPluginFile) || file_exists($JigoPluginFile)){
			if(is_plugin_active('woocommerce/woocommerce.php') || is_plugin_active('jigoshop/jigoshop.php')){
				add_action("admin_head", "autoinstall_admin_header"); // please comment this line if you wish to DEACTIVE SAMPLE DATA INSERT.
			}else{
				//IF WOOCOMMERCE OR JIGOSHOP PLUGIN IS NOT AVAILABLE THEN INFORM USER TO DOWNLOAD AND ACTIVATE IT START.
				add_action("admin_head", "activate_woo_plugin");
				//IF WOOCOMMERCE OR JIGOSHOP PLUGIN IS NOT AVAILABLE THEN INFORM USER TO DOWNLOAD AND ACTIVATE IT FINISH.
			}
		}else{
			//IF WOOCOMMERCE OR JIGOSHOP PLUGIN IS NOT AVAILABLE THEN INFORM USER TO DOWNLOAD AND ACTIVATE IT START.
			add_action("admin_head", "activate_woo_plugin1");
			//IF WOOCOMMERCE OR JIGOSHOP PLUGIN IS NOT AVAILABLE THEN INFORM USER TO DOWNLOAD AND ACTIVATE IT FINISH.
		}
	}
}
function activate_woo_plugin(){
	$dummy_data_msg = 'Please activate <a href="'.admin_url().'plugins.php" class="act_pligin" target="_blank">WooCommerce plugin</a> or <a href="'.admin_url().'plugins.php" class="act_pligin"  target="_blank">Jigoshop plugin</a> to set up theme with dummy data.';
	define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p><span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span><a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right">Dismiss</a></div>');
	echo THEME_ACTIVE_MESSAGE;
}

function activate_woo_plugin1(){
	$dummy_data_msg = 'Please download and activate <a href="http://www.woothemes.com/woocommerce/" class="act_pligin" target="_blank">WooCommerce plugin</a> or <a href="http://jigoshop.com/" class="act_pligin"  target="_blank">Jigoshop plugin</a> to set up theme with dummy data.';
	define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p><span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span><a href="javascript:;" id="dismiss-ajax-notification" class="templatic-dismiss" style="float:right">Dismiss</a></div>');
	echo THEME_ACTIVE_MESSAGE;
}

function autoinstall_admin_header(){
	global $wpdb;
	update_option("ptthemes_alt_stylesheet",'1-default');
	if(isset($_REQUEST['dummy']) && $_REQUEST['dummy'] !="" && $_REQUEST['dummy']=='del'){
		delete_dummy_data();	
		wp_redirect(admin_url().'themes.php');
	}
	if(isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert'] !=""){
		include_once (TEMPLATE_FUNCTION_FOLDER_PATH . 'auto_install/auto_install_data.php'); // auto install data file
		wp_redirect(admin_url().'themes.php');
	}
	$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
	if($post_counts>0){
		$theme_name = get_option('stylesheet');
		$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
		if($nav_menu['nav_menu_locations']['secondary'] == 0){
			$menu_msg = "<p><b>NAVIGATION MENU:</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a>  | <b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/catalog-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums/viewforum.php?f=101'> <b>Community Forum</b></a></p>";
		}else{
			$menu_msg="<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/catalog-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums/viewforum.php?f=101'> <b>Community Forum</b></a></p>";
		}
		$product_counts = $wpdb->get_var("select count(ID) from $wpdb->posts where post_type='product' and post_status='publish'");
		if($product_counts == 0){
			$temp_dummy_data_msg = 'There are no product data available in this theme, If we use product related widgets then it will not display any product. Please insert some prodcuts or import woocommerce or jigoshop dummy data.<br/>';
		}else{
			$temp_dummy_data_msg = '';
		}
		$dummy_data_msg = $temp_dummy_data_msg.' Sample data has been <b>populated</b> on your site.'.$menu_msg.'<p> Wish to delete sample data?  <a class="button_delete button-primary" href="'.home_url().'/wp-admin/themes.php?dummy=del">Yes Delete Please!</a></p>';
	}else{
		$theme_name = get_option('stylesheet');
		$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
		if(isset($nav_menu['nav_menu_locations']['secondary']) && $nav_menu['nav_menu_locations']['secondary'] == 0){
			$menu_msg1 = "<p><b>NAVIGATION MENU:</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a>  | <b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/catalog-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums/viewforum.php?f=101'> <b>Community Forum</b></a></p>";
		}else{
			$menu_msg1="<p><b>CUSTOMIZE:</b> <a href='".site_url("/wp-admin/customize.php")."'><b>Customize your Theme Options.</b></a><br/> <b>HELP:</b> <a href='http://templatic.com/docs/catalog-theme-guide/'> <b>Theme Documentation Guide</b></a> | <b>SUPPORT:</b><a href='http://templatic.com/forums/viewforum.php?f=101'> <b>Community Forum</b></a></p>";
		}
		$dummy_data_msg = 'Install sample data: Would you like to <b>auto populate</b> sample data on your site?  <a class="button_insert button-primary" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1">Yes, insert please</a>'.$menu_msg1;
	}

	define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="updated templatic_autoinstall"><p> '.$dummy_data_msg.'</p><span id="ajax-notification-nonce" class="hidden">' . wp_create_nonce( 'ajax-notification-nonce' ) . '</span><a href="javascript:;" id="dismiss-ajax-notification" class="welcome-panel-close" style="float:right">Dismiss</a></div>');
	echo THEME_ACTIVE_MESSAGE;
}
function delete_dummy_data(){
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj){
		wp_delete_post($pids_info_obj->ID,true);
	}
}


/* Setting For dismiss auto install notification message from themes.php START */
register_activation_hook( __FILE__, 'activate'  );
register_deactivation_hook( __FILE__, 'deactivate'  );
add_action( 'admin_enqueue_scripts', 'register_admin_scripts'  );
add_action( 'wp_ajax_hide_admin_notification', 'hide_admin_notification' );
function activate() {
	add_option( 'hide_ajax_notification', false );
}
function deactivate() {
	delete_option( 'hide_ajax_notification' );
}
function register_admin_scripts() {
	wp_register_script( 'ajax-notification-admin', get_stylesheet_directory_uri().'/js/admin_notification.js'  );
	wp_enqueue_script( 'ajax-notification-admin' );
}
function hide_admin_notification() {
	if( wp_verify_nonce( $_REQUEST['nonce'], 'ajax-notification-nonce' ) ) {
		if( update_option( 'hide_ajax_notification', true ) ) {
			die( '1' );
		} else {
			die( '0' );
		}
	}
}
/* Setting For dismiss auto install notification message from themes.php END */
?>