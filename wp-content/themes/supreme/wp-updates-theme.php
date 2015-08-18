<?php
/*
 * Function Name: supreme_update_theme
 * Return: update supreme version after templatic member login
 */
function supreme_update_theme()
{
	check_ajax_referer( 'supreme', '_ajax_nonce' );
	$theme_dir = rtrim(  get_template_directory(), '/' );	
	require_once( get_template_directory() .  '/templatic_login.php' );	
	exit;
}


if( !class_exists('WPSupremeUpdater') ) {
	class WPSupremeUpdater {
	
		var $api_url;		
		var $theme_slug;
		function supreme_clear_update_transient() {		
			delete_transient( 'supreme-update' );
		}
		
		
		function __construct( $api_url, $theme_slug ) {
			$this->api_url = $api_url;			
			$this->theme_slug = $theme_slug;
			
			add_filter( 'pre_set_site_transient_update_themes', array(&$this, 'check_for_update') );
			add_filter( 'after_theme_row_supreme', array(&$this, 'supreme_theme_row') );
			add_action('wp_ajax_supreme','supreme_update_theme');
			// This is for testing only!
			//set_site_transient('update_themes', null);
			if(!strstr($_SERVER['REQUEST_URI'],'plugin-install.php') && !strstr($_SERVER['REQUEST_URI'],'update.php'))
			{
			
				add_action( 'load-update-core.php', array(&$this,'supreme_clear_update_transient') );
				add_action( 'load-themes.php', array(&$this, 'supreme_clear_update_transient') );
				if(!strstr($_SERVER['REQUEST_URI'],'/network/')){
					add_action( 'admin_notices', array(&$this, 'supreme_update_nag') );
				}
				delete_transient( 'supreme-update' );
				add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
			}
		}
	
		function supreme_update_nag($transient) {
			global $supreme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_template_directory_uri());
    			$theme_data = supreme_get_theme_data(get_template_directory().'/style.css');	
			$supreme_version = $theme_data['Version'];
			$remote_version = (!empty($update_themes) && $update_themes!="" && !empty($update_themes->response))?$update_themes->response[$theme_name]['new_version']:$supreme_response[$theme_name]['new_version'];				
			if (version_compare($supreme_version, $remote_version, '<') && $supreme_version!='')
			{	
				echo '<div id="update-nag">';
				$new_version = version_compare($supreme_version, $remote_version, '<') ? __('New Version of supreme is available now .', 'supreme') .' <a class="thickbox" title="Supreme Forms" href="plugin-install.php?tab=plugin-information&plugin=templatic&TB_iframe=true&width=640&height=808">'. sprintf(__('View version %s Details', 'supreme'), $remote_version) . '</a>. ' : '';
				
				$ajax_url = esc_url( add_query_arg( array( 'slug' => 'supreme', 'action' => 'supreme' , '_ajax_nonce' => wp_create_nonce( 'supreme' ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
				$ajax_url=site_url('/wp-admin/admin.php?page=templatic_menu');
				$file= get_template_directory().'/style.css';
				$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$file, 'upgrade-theme_' . $file);
				echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version . sprintf(__( 'or <a href="%s"  title="Supreme Update">update now</a>.', 'supreme'),$ajax_url) .'</div></td>';
				echo '</div>';
			}
		
		}
	
	
		function check_for_update( $transient ) {
			global $supreme_response,$wp_version;
			
			if (empty($transient->checked)) return $transient;
			
			$request_args = array(					
					'slug' => $this->theme_slug,
					'version' => $transient->checked[$this->theme_slug]
					);
			$request_string = $this->supreme_prepare_request( 'templatic_theme_update', $request_args );
			$raw_response = wp_remote_post( $this->api_url, $request_string );
			
			$response = null;
			if( !is_wp_error($raw_response) && ($raw_response['response']['code'] == 200) )
				$response = json_decode($raw_response['body']);
			
			if( !empty($response) ){ // Feed the update data into WP updater
				$transient->response[$this->theme_slug] = (array)$response;				
				$supreme_response[$this->theme_slug] = (array)$response; 
				update_option('supreme_new_version',$supreme_response);
			}			
			return $transient;
		}
	
		/*
		* add action for set the auto update for tevolution plugin
		* Functio Name: tevolution_plugin_row
		* Return : Display the plugin new version update message
		*/
		function supreme_theme_row()
		{
			global $supreme_response,$wp_version;			
			
			$update_themes=get_option('_site_transient_update_themes');
			$theme_name = basename(get_template_directory_uri());
    			$theme_data = supreme_get_theme_data(get_template_directory().'/style.css');	
			
			$supreme_version = $theme_data['Version'];
			$remote_version = (!empty($update_themes) && $update_themes!="")?$update_themes->response[$theme_name]['new_version']:$supreme_response[$theme_name]['new_version'];	
			
			if (version_compare($supreme_version, $remote_version, '<') && $supreme_version!='')
			{	
				$new_version = version_compare($supreme_version, $remote_version, '<') ? __('New Version of supreme is available now .', 'supreme') .' <a class="thickbox" title="Supreme Forms" href="plugin-install.php?tab=plugin-information&plugin=templatic&TB_iframe=true&width=640&height=808">'. sprintf(__('View version %s Details', 'supreme'), $remote_version) . '</a>. ' : '';
				
				$ajax_url = esc_url( add_query_arg( array( 'slug' => 'supreme', 'action' => 'supreme' , '_ajax_nonce' => wp_create_nonce( 'supreme' ), 'TB_iframe' => true ,'width'=>500,'height'=>400), admin_url( 'admin-ajax.php' ) ) );
				$file= get_template_directory().'/style.css';
				$download= wp_nonce_url( self_admin_url('update.php?action=upgrade-theme&theme=').$file, 'upgrade-theme_' . $file);
				echo '</tr><tr class="plugin-update-tr"><td colspan="3" class="plugin-update"><div class="update-message">' . $new_version . __( 'or <a href="'.$ajax_url.'" class="thickbox" title="Supreme Update">update now</a>.', 'supreme') .'</div></td>';
			
			}
		}
	
		function supreme_prepare_request( $action, $args ) {
			global $wp_version;
			
			return array(
				'body' => array(
					'action' => $action, 
					'request' => serialize($args),
					'api-key' => md5(get_bloginfo('url'))
				),
				'user-agent' => 'WordPress/'. $wp_version .'; '. home_url()
			);	
		}//finish the prepare requst function
	
	}
}

?>