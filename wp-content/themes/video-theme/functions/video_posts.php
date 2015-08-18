<?php
/* define Absolute folder path for the plugin */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/* add filter to show edit link after the content */
add_filter( 'the_content', 'tmpl_video_edit_post_link' );
function tmpl_video_edit_post_link($content){
    $edit_link = '';
    if ( is_super_admin() ) {
        $edit_link = "<a href='".get_edit_post_link()."'>". __('Edit This') ."</a>";
    }else{
        /* for subscriber and post owner show edit link */
        global $post,$current_user,$wpdb;
        get_currentuserinfo();
        if ($post->post_author == $current_user->ID) {
            
            $get_submit_page = $wpdb->get_row("SELECT post_id FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = 'is_video_submit_form' and $wpdb->postmeta.meta_value = '1'");
            $post_id = isset($get_submit_page->post_id) ? $get_submit_page->post_id : '';
            if($post_id != ''){
                $post_content = $wpdb->get_row("SELECT post_name FROM $wpdb->posts WHERE $wpdb->posts.ID =". $post_id);
                $edit_link = '<a class="post-edit-link" href="' . site_url().'/'.$post_content->post_name.'?pid=' . $post->ID. '">' . __('Edit This') . '</a>';
            }
        }
    }
    $content .= $edit_link;
    return $content;
}

/* Add columns to User panel list page for total video submited */
function tmpl_video_add_user_columns( $defaults ) {
     $defaults['videos'] = __('Video', 'user-column');
     return $defaults;
}

function tmpl_video_add_custom_user_columns($value, $column_name, $id) {
    global $wpdb;  
    if( $column_name == 'videos' ) {
         $post_content = $wpdb->get_row("SELECT count(ID) as total FROM $wpdb->posts WHERE $wpdb->posts.post_author = $id AND $wpdb->posts.post_type ='videos'");
         return $post_content->total; 
    }
}
add_action('manage_users_custom_column', 'tmpl_video_add_custom_user_columns', 15, 3);
add_filter('manage_users_columns', 'tmpl_video_add_user_columns', 15, 1);
        
/*
 * Function Name: tmpl_vidoe_breadcrumb_trail_items
 * Return: display the breadcrumb as per submit.edit and delete submit page.
 */
add_filter('breadcrumb_trail_items','tmpl_vidoe_breadcrumb_trail_items');
function tmpl_vidoe_breadcrumb_trail_items($trail){
	global $post;	
	$post_id=(isset($_REQUEST['pid']) && $_REQUEST['pid']!='')? $_REQUEST['pid'] : '';
	$post_type = get_post_type($post_id);
	if(get_post_meta(@$post->ID,'submit_post_type',true)!="" && $post_type==get_post_meta(@$post->ID,'submit_post_type',true)){
		$replace_title='Submit '.ucfirst($post_type);
		if(@$_REQUEST['action'] =='delete'){
			$title = __("Delete ".$post_type);
		}
		if(@$_REQUEST['action'] =='edit'){
			$title = __("Edit ".$post_type);
		}
		
		if(in_array(ucfirst($replace_title),$trail)){
			$trail[1]=$title;
		}
	}	
	return $trail;
}

/*
 * main function of video submition, call of shortcode "submit_video_form"
 *  */
function submit_video_form($atts){
	
	extract( shortcode_atts( array (
			'post_type'   =>'post',				
			), $atts ) 
		);	
	ob_start();
	remove_filter( 'the_content', 'wpautop' , 12);
	
	/* Set global variable to user any where in tevolution submit form */
	global $wpdb,$post,$current_user,$all_cat_id,$monetization,$validation_info,$submit_form_validation_id;
	$validation_info = array();
	
	/* set the submit post type on submit form page */
	if(get_post_meta($post->ID,'submit_post_type',true)=="" || $post_type!=get_post_meta($post->ID,'submit_post_type',true)){
		update_post_meta($post->ID,'submit_post_type',$post_type);	
	}
	
	/*Update submit form post meta for its a tevolution submit form */
	if(get_post_meta($post->ID,'is_video_submit_form',true)=="" || '1'!=get_post_meta($post->ID,'is_video_submit_form',true)){
		update_post_meta($post->ID,'is_video_submit_form',1);	
	}
	
	$submit_post_type = get_post_meta($post->ID,'submit_post_type',true);
	
	/* submit_form_return add hook for return before submit form display */
	if(apply_filters('submit_form_return',false)){
		return;	
	}
	
	/* submit_form_before_content hook for add additional html or information on this hook */
	do_action('submit_viddeo_form_before_content');

	$submit_form_validation_id = "submit_form";
	
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
		global $sitepress;
		if(isset($_REQUEST['lang'])){
			$url = site_url().'/?page=paynow&lang='.$_REQUEST['lang'];
		}elseif($sitepress->get_current_language()){
			
			if($sitepress->get_default_language() != $sitepress->get_current_language()){
				$url = site_url().'/'.$sitepress->get_current_language().'/?page=paynow';
			}else{
				$url = site_url().'/?page=paynow';
			}	
		}else{
			$url = site_url().'/?page=paynow';
		}
	}else{
		$url = site_url().'/?page=paynow';
	}
	
	?>
        <script>
            var can_submit_form = 0;
	</script>
        <?php
	echo '<form name="submit_form" id="submit_form" class="dropzone form_front_style" action="'.$url.'" method="post" enctype="multipart/form-data">';
		wp_nonce_field('submit_form_action','submit_form_nonce_field');
		echo "<input type='hidden' id='submit_post_type' name='submit_post_type' value='".$post_type."'>";
		echo "<input type='hidden' id='submit_post_url' name='submit_post_url' value='".$_SERVER["REQUEST_URI"]."'>";
		echo "<input type='hidden' id='cur_post_type' name='cur_post_type' value='".$post_type."'>";
		echo "<input type='hidden' id='submit_page_id' name='submit_page_id' value='".$post->ID."'>";
		$is_user_select_subscription_pkg = 0;
		if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
			$edit_id = $_REQUEST['pid'];
			echo "<input type='hidden' id='submit_pid' name='pid' value='".$_REQUEST['pid']."'>";			
			/*  edit listing*/
			if(isset($_REQUEST['action']) && $_REQUEST['action']=='edit'){
				echo "<input type='hidden' name='action' value='edit'>";
				echo "<input type='hidden' id='action_edit' name='action_edit' value='edit'>";
				echo "<input type='hidden' id='monetize_pkg_id' name='monetize_pkg_id' value='".get_post_meta($_REQUEST['pid'],'package_select',true)."'>";
			}
			/* Renew Listing */
			if(isset($_REQUEST['renew']) && $_REQUEST['renew']=='1'){
				echo "<input type='hidden' name='renew' value='1'>";
			}			
		}
		do_action('action_before_html');
		?>
		<div class="accordion" id="post-listing" >
			
		<?php		
                    /* Start submit form details structure */
                    /*while edit a listing show default post tab active*/
                    if(isset($edit_id) && $edit_id !='' ||  is_user_logged_in()){
                            $post_heading_number = '1';
                            $active = 'active';
                    }
                    else
                    {
                            $post_heading_number = 1;
                            $active = 'active';
                    }
			?>            
                    <div id="step-post" class="accordion-navigation step-wrapper step-post">
                        <a class="step_enter_detail step-heading submit-video active" href="#"><span><?php echo $post_heading_number; ?></span><span><?php _e('Enter Details','templatic'); ?></span><span></span></a>
                        <div id="post" class="step-post content <?php echo $active; ?> clearfix">
                        <?php
				
                            /*get the post type taxonomy */
                            $taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));
                            $taxonomy = $taxonomies[0];


                            /*Apply filter hook for create submit from va;lidation info array*/
                            $validation_info=apply_filters('tevolution_submit_from_validation',$validation_info,$custom_metaboxes);

                            /* Display custom fields post type wuse */
                            echo '<div id="submit_form_custom_fields" class="submit_form_custom_fields">';
                                    if(function_exists('display_video_custom_post_field_plugin'))
                                    {
                                            display_video_custom_post_field_plugin();/*displaty default post html.*/
                                    }
                            echo '</div>';

                            global $submit_button;
                                $submit_button=(!isset($submit_button))?'':$submit_button; 
				
				echo '<span class="message_error2" id="common_error"></span>';
				
				if($current_user->ID ==''){
					echo '<input type="button" class="button secondary_btn post-edit-link" id="continue_submit_from" name="continue_login" value="'.__('Continue','templatic').'" '.$submit_button.'/>&nbsp;&nbsp;';
				}else{
					echo '<input type="submit" class="button secondary_btn post-edit-link" id="continue_submit_from" name="continue_submit_from" value="'.__('Submit','templatic').'" '.$submit_button.'/>&nbsp;&nbsp;';
				}
                                ?>
                        </div>
                    </div>
                    <?php
				
                        /* Finish submit custom fields detail structure*/
                        do_action('before_login_register_form',$post_type,$post->ID);
                        if($current_user->ID=='') {  
                        ?>
                            <div id="step-auth" class="accordion-navigation step-wrapper step-auth">
                                <a class="step-heading active" href="#"><span id="span_user_login">2</span><span><?php _e('Login / Register','templatic'); ?></span><span></span></a>
                                    <div id="auth" class="step-auth content clearfix">
                                        <?php
                                            /*display the login and register form while user submit a form without logged in.*/
                                            $_SESSION['redirect_to']=get_permalink();
                                            do_action('templ_fecth_login_onsubmit');
                                            $users_can_register = get_option('users_can_register');
                                            if($users_can_register):
                                                    do_action('templ_fetch_registration_onsubmit');
                                            endif;
                                        ?>
                                    </div>
                            </div>
                         <?php
                        }
                        do_action('before_payment_option_form',$post_type,$post->ID);

                        /* Delete option of pay cash on delivery because we removed it. */
                                delete_option('payment_method_payondelivery');
                        /* Delete option of pay cash on delivery because we removed it. */
                        /*while edit a listing show default post tab active*/
                        if((isset($edit_id) && $edit_id !='' && (!isset($_REQUEST['renew']))) || $is_user_select_subscription_pkg == 1)
                        {
                                $val=($current_user->ID != '')? '2':'3';
                        }
                        else
                        {
                                $val=($current_user->ID != '')? '3': '4';
                        }
                        ?>

                        <?php

                        do_action('after_payment_option_form',$post_type,$post->ID);
                        echo '<input type="button" style="display:none;" id="submit_form_button" name="submit_form_button" />&nbsp;&nbsp;';
                    ?>
            </div>
        <?php

	echo '</form>';	
	
	echo '<div id="preview_submit_from_'.$post_type.'"  class="reveal-modal singular-'.$post_type.' preview_submit_from_data" data-reveal></div>';
	/* Include submit validation script file */
	require_once(get_template_directory().'/functions/submition_validation.php');
	
	/* submit_form_after_content hook for add additional html or information on this hook */	 
	do_action('submit_form_after_content');
	
	return ob_get_clean();
}

/*
 * Add filter hook : tevolution_submit_from_validation
 * This function will be create validation info global array for submit page validation
 */
add_filter('tevolution_submit_from_validation','tmpl_video_submit_from_validation',10,2);
function tmpl_video_submit_from_validation($validation_info,$custom_fields){
	global $validation_info;
	
	$tmpdata = get_option('templatic_settings');
	$custom_fields = array();

	$custom_fields['category'] = array(
				   'name'	=> 'category',
				   'espan'	=> 'category_error',
				   'ctype'	=> 'checkbox',
				   'field_require_desc'	=> 'Please select category',
				   'is_require' => 1,
				   'validation_type' => 'require');
	$custom_fields['post_content'] = array(
				   'name'	=> 'post_content',
				   'espan'	=> 'post_content_error',
				   'ctype'	=> 'texteditor',
				   'is_require' => 1,
				   'field_require_desc'	=> 'Please enter content',
				   'validation_type' => 'require');
	$custom_fields['post_title'] = array(
				   'name'	=> 'post_title',
				   'espan'	=> 'post_title_error',
				   'ctype'	=> 'text',
				   'is_require' => 1,
				   'field_require_desc'	=> 'Please enter title',
				   'validation_type' => 'require');
	
	foreach($custom_fields as $key=>$value){
		if($value['is_require']=='1'){
			
		$validation_info[] = array(
						'title'	       => $value['name'],
						'name'	       => $key,
						'espan'	       => $key.'_error',
						'type'	       => $value['ctype'],
						'text'	       => $value['field_require_desc'],
						'is_require'	  => @$value['is_require'],
						'validation_type'=> $value['validation_type'],
						'search_ctype'   => $value['search_ctype']
				);
		}
	}/*end for each loop*/
	
	return $validation_info;
}

/*
Name: tevolution_tiny_mce_before_init
tinymce validation.
*/

add_filter( 'tiny_mce_before_init', 'tmpl_video_submit_form_tiny_mce_before_init',100,2 );
function tmpl_video_submit_form_tiny_mce_before_init( $initArray ,$editor_id)
{

	if(!is_admin() || isset($_REQUEST['front']) && $_REQUEST['front']==1){	
	global $validation_info,$post;
	for($i=0;$i<count($validation_info);$i++) {
			$title = $validation_info[$i]['title'];
			$name = $validation_info[$i]['name'];
			$espan = $validation_info[$i]['espan'];
			$type = $validation_info[$i]['type'];
			$text = __($validation_info[$i]['text'],'templatic');
			$validation_type = $validation_info[$i]['validation_type'];
			$is_required = $validation_info[$i]['is_require'];
			
			/*finish post type wise replace post category, post title, post content, post expert, post images*/
			
			if($type=='texteditor'){								
				?>
				<script>
					var content_id = '<?php echo $name; ?>';
					var espan = '<?php echo $espan; ?>';
				</script>
			<?php
				 $initArray['setup'] = <<<JS
[function(ed) { 
    ed.onKeyUp.add(function(ed, e) {					
        if(tinyMCE.activeEditor.id == content_id) {

            var content = tinyMCE.get(content_id).getContent().replace(/<[^>]+>/g, "");
            var len = content.length;
            if (len > 0) {
                                jQuery('#'+espan).text("");
                                jQuery('#'+espan).removeClass("message_error2");
                                return true;
            }else{
                                jQuery('#'+espan).text("$text");
                                jQuery('#'+espan).addClass("message_error2");
                                return false;
                        }
         }
    });

}][0]
JS;
				
			}
		}	
	}
	 return $initArray;
}
?>