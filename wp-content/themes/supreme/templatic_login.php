<?php
	/*
	 * Get framework Version
	 */
	function tmpl_get_frm_version () {		
		$theme_name = basename(get_template_directory());
		$theme_data = supreme_get_theme_data(get_template_directory().'/style.css');			
		return $theme_version = $theme_data['Version'];	
	}

	/* GET FRAMEWORK REMOTE VERSION */

	function tmpl_get_frm_remote_verison(){
		
		
		global $theme_response,$wp_version;			
		$theme_name = basename(get_template_directory());
		$remote_version = get_option('supreme_new_version');
		return $remote_version = $remote_version[$theme_name]['new_version'];	
	}
	
	global $current_user;
	$self_url =  esc_url( add_query_arg( array( 'slug' => 'supreme', 'action' => 'supreme' , '_ajax_nonce' => wp_create_nonce( 'supreme' ), 'TB_iframe' => true ), admin_url( 'admin-ajax.php' ) ));

	if(isset($_POST['templatic_login']) && isset($_POST['templatic_username']) && $_POST['templatic_username']!=''  && isset($_POST['templatic_password']) && $_POST['templatic_password']!='' && @$_REQUEST['page'] == 'templatic_menu')
	{ 
		$arg=array(
			'method' => 'POST',
			'timeout' => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking' => true,
			'headers' => array(),
			'body' => array( 'username' => $_POST['templatic_username'], 'password' => $_POST['templatic_password']),
			'cookies' => array()
		    );
		$warnning_message='';
		$response = wp_remote_post('http://templatic.com/members/login_api.php',$arg );	
	
		if( is_wp_error( $response ) ) {
		  	$warnning_message="Invalid UserName or password. are you using templatic member username and password?";
		} else { 
		  	$data = json_decode($response['body']);
		}
	
		/*Return error message */
		if(isset($data->error_message) && $data->error_message!='')
		{
			$warnning_message=$data->error_message;			
		}

		/*Finish error message */
		$data_product = (array)$data->product;
		if(isset($data_product) && is_array($data_product))
		{		
			foreach($data_product as $key=>$val)
			{
				$product[]=$key;
			}			
			if( $data->is_supreme == 1 ) // Check it member has supreme framework in his member area.....
			{
				$successfull_login=1;	
				session_start();
				$_SESSION['success_user_login'] = 'yes';
				$download_link=$data_product['Automotive - developer license '];
				if(!$download_link){
					$download_link=$data_product['Nightlife - developer license '];
				}
			}else
			{
				$warnning_message="Update was unable to continue because supreme theme doesn't seem to be associated with your Templatic account. Please <a href='http://templatic.com/contact/' target='_blank'>contact us</a> if this message is showing in error.";
			}
		}
	}else{
		if(isset($_POST['templatic_login']) && ($_POST['templatic_username'] =='' || $_POST['templatic_password']=='')){
		$warnning_message="Invalid UserName or password. Please enter templatic member's username and password."; }
	}
	
	/* version of framework */
			$theme_version = tmpl_get_frm_version();
			$remote_version = tmpl_get_frm_remote_verison();
			
			/* set flag on updates */
			if (version_compare($theme_version, $remote_version, '<') && $theme_version!='')
			{	
				$flag = 1;
			}else{
				$flag = 0;
			}
			$the_name = wp_get_theme();
	
	$session = @$_SESSION['success_user_login'];
	?>
		
    <div class='wrap templatic_login'>
	
		<?php if($flag ==1){ ?>
			  <div id="update-nag">
			  <p style=" clear:both;"> <?php _e('The new version of supreme is available.','supreme'); ?></p>
			  
			  <p><?php _e('you can update to the latest version automatically , or download the latest version of the theme.','supreme'); ?></p>
			  <p><span style="color:red; font-weight:bold;"><?php _e('Warning','supreme'); ?>: </span><?php _e('Updating will undo all your file customizations so make sure to keep backup of all files before updating.','supreme'); ?></p>
			  <a target="_blank" class="button-secondary" href="http://templatic.com/members/member"><?php _e('Download latest Version','supreme'); ?></a> 
			  
			  </div>
		<?php } ?>
		  
		   <div id='pblogo'>
               <img src="<?php echo esc_url( get_template_directory_uri()."/images/templatic-wordpress-themes.jpg"); ?>" style="margin-right: 50px;" />
			    <?php echo '<h3>Supreme Updates</h3>'; ?>
		   </div> 
	<?php if($flag ==1){ 
	
		if(isset($warnning_message) && $warnning_message!='')
		{ ?>
			<div class='error'><p><strong><?php echo sprintf(__('%s','supreme'), $warnning_message);?></strong></p></div>	
		<?php }
		if(!isset($successfull_login) && @$successfull_login!=1 && !$session):?>
		<p class="info">
			   
			   <?php _e('Templatic Login , enter your templatic credentials to take the updates of supreme.','supreme');?></p>
               <form action="<?php echo site_url()."/wp-admin/admin.php?page=templatic_menu";?>" name="" method="post">
                   <table>
					<tr>
					<td><label><?php _e('User Name', 'supreme')?></label></td>
					<td><input type="text" name="templatic_username"  /></td>
					</tr>
					<tr>
                    <td><label><?php _e('Password', 'supreme')?></label></td>
					<td><input type="password" name="templatic_password"  /></td>
					</tr>
					<tr>
					<td><input type="submit" name="templatic_login" value="Sign In" class="button-secondary"/></td>
					<td><a title="Close" id="TB_closeWindowButton" href="#" class="button-secondary"><?php _e('Cancel','supreme'); ?></a></td>
					</tr>
				</table>
				
               </form>
          <?php else:								
				 $file='supreme';
				$download= wp_nonce_url(admin_url('update.php?action=upgrade-theme&theme=').$file, 'upgrade-theme_' . $file);				
				  echo ' Supreme framework <a id="TB_closeWindowButton" href="'.$download.'" target="_parent" class="button-secondary">Update Now</a>';
			 endif;

		} ?>
          </div>
<?php

if($flag == 0){
	echo '<h3>'.__('You have the latest version of supreme parent theme.','supreme').'</h3>';
    echo '<p>&rarr;'.sprintf(__('<strong>Your version:</strong> %s','supreme'),$theme_version).'</p>';	
}
do_action('admin_footer', '');
do_action('admin_print_footer_scripts');
?>