<?php
/* File contain the functions which run & execute the auto install */

set_time_limit(0);
global  $wpdb,$pagenow;

/* Show notifications As per plug-ins activation */
add_action("admin_notices", "tmpl_autoinstall");  // action show notification when custom field module not available.

/* css to hide notification */
add_action('admin_notices','add_css_to_admin');
function add_css_to_admin(){
	echo '<style type="text/css">
		#message1{
			display:none;
		}
		.oneclick {
			display:inline-block;
		}
		.templatic_autoinstall ul li > b {
		    display: inline-block;
		    max-width: 150px;
		    vertical-align: top;
		    width: 100%;
		}
		#ajax-notification li:nth-child(2n) b {
			max-width: 153px;
		}
		.templatic_autoinstall ul li a {
		    display: inline-block;
		    vertical-align: top;
		}
		.templatic_autoinstall ul li a + a {
		    display: block;
		    margin-left: 153px;
		}
		div.templatic_autoinstall {
			padding:1rem;
			position:relative;
			display:block;
			max-width:600px;
		}
		.templatic_autoinstall h3 {
			margin-top:0;
		}
		.wp-core-ui .templatic_autoinstall .button.button_delete {
			margin-bottom:1rem;
		}
		.themes-php div.updated.templatic_autoinstall a {
			text-decoration:none;
		}
		.templatic-dismiss {
			position:absolute;
			top:15px;
			right:15px;
		}
		.templatic-dismiss:before {
			background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
		    color: #BBBBBB;
		    content: "";
		    font: 400 16px/1 dashicons;
		    height: 20px;
		    margin: 2px 0;
		    text-align: center;
		    width: 20px;
		    position:relative;
		    left:-3px;
		    top:3px;
		}
		.wp-core-ui .templatic_login .update-nag .button-primary, .wp-core-ui .templatic_login #update-nag .button-primary { margin-bottom: 0.5rem; }
		.wp-core-ui #update-nag, .wp-core-ui .update-nag { background: #FFFBCC;  border-top: 1px solid #E6DB55; border-right: 1px solid #E6DB55; border-bottom: 1px solid #E6DB55; border-left-color: #E6DB55; margin-left: 0;}
		.tmpl-form { background-color: #FFFFFF; box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.1); -webkit-box-shadow:0 1px 1px 0 rgba(0, 0, 0, 0.1); margin-top: 20px; padding: 20px; max-width: 646px; }
		.tmpl-form label { font-size: 13px; }
		.tmpl-form td { padding-bottom: 0.5rem; }
		.tmpl-form form { margin-bottom: 0; }
		.wp-core-ui #update-nag h3, .wp-core-ui .update-nag h3 { margin: 0.5rem 0 1em 0; }
                
                .tmpl-welcome-panel { border: 2px solid #cccccc;  box-shadow: none;  max-width: 1472px; overflow: hidden; margin: 50px auto !important; clear:both;}
                .welcome-panel { background: #fff none repeat scroll 0 0;  border: 1px solid #e5e5e5;  box-shadow: 0 1px 1px rgba(0, 0, 0, 0.04);  font-size: 13px;  line-height: 2.1em;  margin: 16px 0;  overflow: auto;  padding: 23px 10px 0;  position: relative; }
                .tmpl-welcome-panel .welcome-panel-content {  margin-right: 13px;  margin-left: 13px;  max-width: 1500px;}
                .welcome-panel a {text-decoration: underline;}
                .welcome-panel-content .delete-data-button {  background: #d54e21 none repeat scroll 0 0; margin-left: 15px; border-color: #d54e21;  box-shadow: 0 1px 0 rgba(255, 255, 255, 0.5) inset;}
                .welcome-panel-content .insert-data-button { margin-left: 15px; }
	</style>';
}
/*
Name: activate_eco_addons
Desc: return message to activate plugin if user activate only directory theme
*/
function activate_eco_addons(){
	$url_custom_field = home_url()."/wp-admin/admin.php?page=templatic_system_menu&activated=custom_fields_templates&true=1";
	$url_custom_post_type = home_url()."/wp-admin/admin.php?page=templatic_system_menu&activated=custom_taxonomy&true=1";
	add_css_to_admin();
	?>
	<div class="error" style="padding:10px 0 10px 10px;font-weight:bold;"> <span>
	  <?php echo sprintf(__('Thanks for choosing templatic themes,  the base system of templatic is not installed at your side Now, Please activate both <a id="templatic_plugin" href="%s" style="color:#21759B">Templatic - Custom Post Types Manager</a> and <a  href="%s" style="color:#21759B">Templatic - Custom Fields</a> addons to get started with %s website.','templatic'),$url_custom_post_type,$url_custom_field,'<span style="color:#000">'. @wp_get_theme().'</span>');?>
	  </span> </div>
	<?php 
	}

	/* Templatic Add-On Required messages End */
	
/* Activate add on when run the auto install */
function tmpl_autoinstall()
{
	global $wpdb;
	$wp_user_roles_arr = get_option($wpdb->prefix.'user_roles');
	global $wpdb;
	if((strstr($_SERVER['REQUEST_URI'],'themes.php') && !isset($_REQUEST['page'])) && @$_REQUEST['template']=='' || (isset($_REQUEST['page']) && $_REQUEST['page']=="templatic_system_menu") ){
	
		$post_counts = $wpdb->get_var("select count(post_id) from $wpdb->postmeta where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content') and meta_value=1");
		if($post_counts>0){
			$theme_name = get_option('stylesheet');
			$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
                        $menu_msg = "<h4>".__('Get Started','templatic')."</h4>";
			if(!isset($nav_menu['nav_menu_locations']['secondary']) && @$nav_menu['nav_menu_locations']['secondary'] == 0){
				$menu_msg .= "<ul>
								<li><b>".__('Navigation Menu','templatic').":</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a></li> 
								<li><b>".__('Customize','templatic').":</b><a href='".site_url("/wp-admin/customize.php")."'><b>".__('Customize your Theme Options.','templatic')."</b></a></li>
								<li><b>".__('Help','templatic').":</b> <a href='http://templatic.com/docs/new-video-theme-guide/'> <b>".__('Theme Documentation Guide','templatic')."</b></a></li> 
								<li><b>".__('Support','templatic').":</b><a href='http://templatic.com/forums/viewforum.php?f=133'><b>".__('Community Forum','templatic')."</b></a></li>
							</ul>";
			}else{
				$menu_msg .= "<ul>
							<li><b>".__('Navigation Menu','templatic').":</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a></li> 
							<li><b>".__('Customize','templatic').":</b> <a href='".site_url("/wp-admin/customize.php")."'><b>".__('Customize your Theme Options.','templatic')."</b></a></li>
							<li><b>".__('Help','templatic').":</b> <a href='http://templatic.com/docs/new-video-theme-guide/'><b>".__('Theme Documentation Guide','templatic')."</b></a></li> 
							<li><b>".__('Support','templatic').":</b><a href='http://templatic.com/forums/viewforum.php?f=133'><b>".__('Community Forum','templatic')."</b></a></li>
						</ul>";
			}			
			
			$import_data = __('<div class="tmpl-auto-install-yb"><h3 class="oneclick">Sample data has been populated on your website.</h3>','templatic');
			$dummy_data_msg = $import_data.'<a class="button_delete button-primary delete-data-button" href="'.home_url().'/wp-admin/themes.php?dummy=del">'.__("Delete Sample Data",'templatic').'</a><span></span></div>';
			$dummy_data_msg .=$menu_msg;
		}else{
			$theme_name = get_option('stylesheet');
			$nav_menu = get_option('theme_mods_'.strtolower($theme_name));
                        $menu_msg1 = "<h4>".__('Get Started','templatic')."</h4>";
			if( @$nav_menu['nav_menu_locations']['secondary'] == 0 ){
				$menu_msg1 .= "<ul>
								<li><b>".__('Navigation Menu','templatic').":</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a></li> 
								<li><b>".__('Customize','templatic').":</b> <a href='".site_url("/wp-admin/customize.php")."'><b>".__('Customize your Theme Options.','templatic')."</b></a><br/></li> 
								<li><b>".__('Help','templatic').":</b> <a href='http://templatic.com/docs/new-video-theme-guide/'> <b>".__('Theme Documentation Guide','templatic')."</b></a></li>
								<li><b>".__('Support','templatic').":</b><a href='http://templatic.com/forums/viewforum.php?f=133'> <b>".__('Community Forum','templatic')."</b></a></li>
							  </ul>";
			}else{
				$menu_msg1 .="<ul>
								<li><b>".__('Navigation Menu','templatic').":</b> <a href='".site_url("/wp-admin/nav-menus.php")."'><b>Setup your Menu here</b></a></li>
								<li><b>".__('Customize','templatic').":</b> <a href='".site_url("/wp-admin/customize.php")."'><b>".__('Customize your Theme Options.','templatic')."</b></a></li>
								<li><b>".__('Help','templatic').":</b> <a href='http://templatic.com/docs/new-video-theme-guide/'> <b>".__('Theme Documentation Guide','templatic')."</b></a></li>
								<li><b>".__('Support','templatic').":</b><a href='http://templatic.com/forums/viewforum.php?f=133'> <b>".__('Community Forum','templatic')."</b></a></li>
							</ul>";
			}
			
			$dummy_data_msg='';
			$dummy_data_msg =''.__('<div class="tmpl-auto-install-yb"><h3 class="oneclick">Your site not looking like our online demo? </h3>','templatic').'<a class="button_insert button-primary insert-data-button" href="'.home_url().'/wp-admin/themes.php?dummy_insert=1">'.__('Install Sample Data','templatic').'</a><span></span></div>';
			$dummy_data_msg .='<p>'.__('<span class="dashicons dashicons-editor-help" data-code="f223"></span> 1 click-install allows you to quickly populate your site with sample content such as videos, posts, pages etc. and it will also populate relevant widgets on different pages.','templatic').'</p>';
                        $dummy_data_msg .='<p>'.__('<span class="dashicons dashicons-editor-help" data-code="f223"></span> 2 All new page and short code related document available in theme guide.','templatic').'</p>'.$menu_msg1;
		}
		
		if(isset($_REQUEST['dummy_insert']) && $_REQUEST['dummy_insert']){
			require_once (get_template_directory().'/functions/auto_install/auto_install_data.php');
			
			$args = array(
						'post_type' => 'page',
						'meta_key' => '_wp_page_template',
						'meta_value' => 'page-templates/front-page.php'
						);
			$page_query = new WP_Query($args);
			$front_page_id = $page_query->post->ID;
			update_option('page_on_front',$front_page_id);
			wp_redirect(admin_url().'themes.php?x=y');
		}
		if(isset($_REQUEST['dummy']) && $_REQUEST['dummy']=='del'){
			tmpl_delete_dummy_data();
			wp_redirect(admin_url().'themes.php');
		}
		
		define('THEME_ACTIVE_MESSAGE','<div id="ajax-notification" class="welcome-panel tmpl-welcome-panel"><div class="welcome-panel-content">'.$dummy_data_msg.'</div></div>');
                
		echo THEME_ACTIVE_MESSAGE;
	}
}

/*
 To delete dummy data
*/
function tmpl_delete_dummy_data()
{
	global $wpdb;
	delete_option('sidebars_widgets'); //delete widgets
	$productArray = array();
	$pids_sql = "select p.ID from $wpdb->posts p join $wpdb->postmeta pm on pm.post_id=p.ID where (meta_key='pt_dummy_content' || meta_key='tl_dummy_content' || meta_key='auto_install') and (meta_value=1 || meta_value='auto_install')";
	$pids_info = $wpdb->get_results($pids_sql);
	foreach($pids_info as $pids_info_obj)
	{
		wp_delete_post($pids_info_obj->ID,true);
	}
}

/*
Name : set_page_info_autorun
Description : update pages in autorun
*/
function set_page_info_autorun($pages_array,$page_info_arr)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($page_info_arr);$i++)
	{ 
		$post_title = $page_info_arr[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $page_info_arr[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = 'page';
			if(isset($post_info_arr['post_author']) && $post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
                        $my_post['comment_status'] = (isset($post_info_arr['comment_status'])) ? $post_info_arr['comment_status'] : 'closed';
                        $my_post['ping_status'] = (isset($post_info_arr['ping_status'])) ? $post_info_arr['ping_status'] : 'closed';
                        
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = (isset($post_info_arr['post_image']))?$post_info_arr['post_image']:'';
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'attachment';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
?>
