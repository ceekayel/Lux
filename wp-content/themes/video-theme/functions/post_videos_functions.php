<?php
if(isset($_REQUEST['pid']) && $_REQUEST['pid'] !=''){
    global $current_user;
    $post_author_id = get_post_field( 'post_author', $_REQUEST['pid'] );
    if ($post_author_id != $current_user->ID){
        wp_redirect(site_url());
        exit;
    }
}
if(!function_exists('display_video_custom_post_field_plugin'))
{
	function display_video_custom_post_field_plugin()
	{
            /* get data if post in edit mode */
            if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
                $edit_id = $_REQUEST['pid'];
                $edit_post = get_post($edit_id); 
                $value = $edit_post->post_title;
                $content = $edit_post->post_content;
                $post_excerpt = $edit_post->post_excerpt;
                $video_upload = get_post_meta($edit_id,'video_upload',true);
            }else{
                $value = '';
                $content = '';
                $post_excerpt = '';
                $default_video_upload = 'upload';
            }
            $is_required = '<span class="required">*</span>';
       
                echo "<div class='fields-set'>";
       
                    do_action('tmpl_custom_fields_video_option_before'); 
                    ?>
                    <div class="video_option">
                        <label class="main_title"><?php _e('Video Details','templatic'); ?></label>
                        <?php
                        $options = 'upload,ptthemes_oembed,ptthemes_video';
                        $option_title = __('Upload','templatic').','. __('Video URL','templatic').','.__('Video Embed Code','templatic');
                        if($options)
                        { 
                            $chkcounter = 0;
                            echo '<div class="form_cat_left">';
                                $option_values_arr = explode(',',$options);
                                $option_titles_arr = explode(',',$option_title);

                                if($option_title ==''){  $option_titles_arr = $option_values_arr;  }

                                echo '<ul class="hr_input_radio">';
                                    for($i=0;$i<count($option_values_arr);$i++)
                                    {
                                        $chkcounter++;
                                        $seled='';

                                        /* show radio button default selected when it is as cumpalsary field, otherwise all radiobuttons will ne unchecked */
                                        if(empty($default_video_upload) && empty($video_upload)){
                                                if($i==0 && trim($video_upload)==''){ $seled='checked="checked"';}	
                                        }elseif(trim($video_upload) == $option_values_arr[$i])	{
                                            $seled='checked="checked"';
                                        }

                                        if (isset($default_video_upload) && trim($default_video_upload) == trim($option_values_arr[$i])){ $seled='checked="checked"';}

                                        echo '<li><input name="video_upload"  id="video_upload_'.$chkcounter.'" type="radio" value="'.$option_values_arr[$i].'" '.$seled.' /> <label for="video_upload_'.$chkcounter.'">'.$option_titles_arr[$i].'</label></li>';
                                    }
                                echo '</ul>';	
                            echo '</div>';
                        }
                    echo '</div>';
                    echo $is_required_msg;
		
                    if($admin_desc!=""):?><div class="description"><?php echo $admin_desc; ?></div><?php endif;
		    
		echo "</div>";
                
                /* image related options call */
                do_action('tmpl_custom_fields_video_option_after');
                ?>
                    
                <div class="form_row clearfix submit_category_box">	  
                    <label class="r_lbl"><?php _e('Select Category','templatic');echo $is_required; ?></label>
                    <div class="cf_checkbox"><?php require_once(get_template_directory().'/functions/video_category.php');?></div>
                        <span id="category_error"></span>
                        <?php if($admin_desc!=""):?>
                            <div class="description"><?php echo $admin_desc; ?></div>
                        <?php else: ?>
                            <span class="message_note msgcat"><?php _e("Select categories in which you want to post the video.",'templatic'); ?></span>
                        <?php endif;
                        ?>
                </div>
                <?php
		echo "<div class='fields-set'>";
			do_action('video_custom_fields_post_title_before'); ?>
			<label class="r_lbl"><?php _e('Title','templatic');echo $is_required; ?></label>
			<input name="post_title" id="post_title" value="<?php if(isset($value) && $value!=''){ echo stripslashes($value); } ?>" type="text" class="textfield"/>
			<span id="post_title_error"></span>
			<?php
			if($admin_desc!=""):?><div class="description"><?php echo $admin_desc; ?></div><?php endif;
			do_action('video_custom_fields_post_title_after'); 
		echo "</div>";
		
                echo "<div class='fields-set'>";
                    do_action('tmpl_custom_fields_post_excerpt_before'); ?>
                    <label class="r_lbl"><?php _e('Video Excerpt','templatic'); ?></label>	
                    <textarea name="post_excerpt" id="post_excerpt" rows="3"><?php if(isset($post_excerpt))echo stripslashes($post_excerpt);?></textarea>
                    <?php echo $is_required_msg;

                    if($admin_desc!=""):?><div class="description"><?php echo $admin_desc; ?></div><?php endif;

                    do_action('tmpl_custom_fields_post_excerpt_after'); 
                echo "</div>";
                
                
		echo "<div class='fields-set'>";
			?>
			 <label class="r_lbl"><?php _e('Video Description','templatic');echo $is_required; ?></label>
			<?php
			do_action('video_custom_fields_post_content_before');
			$media_buttons = apply_filters('tmpl_media_button_pro',false);
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		
			/* Wp editor on submit form */
			$settings =   apply_filters('tmpl_cf_wpeditor_settings',array(
				'wpautop' => false,
				'media_buttons' => $media_buttons,
				'textarea_name' => 'post_content',
				'textarea_rows' => apply_filters('tmpl_wp_editor_rows',get_option('default_post_edit_rows',6)), /* rows="..."*/
				'tabindex' => '',
				'editor_css' => '<style>.wp-editor-wrap{width:640px;margin-left:0px;}</style>',
				'editor_class' => '',
				'toolbar1'=> 'bold,italic,underline,bullist,numlist,link,unlink,forecolor,undo,redo',
				'teeny' => false,
				'dfw' => false,
				'tinymce' => true,
				'quicktags' => false
			));				
						
                        wp_editor( stripslashes($content), 'post_content', apply_filters('tmpl_wp_editor_settings',$settings));

                        ?>
                        <span id="post_content_error"></span>
                        <?php

                        if($admin_desc!=""):?><div class="description"><?php echo $admin_desc; ?></div><?php 
                        endif;

                        do_action('video_custom_fields_post_content_after');
		echo "</div>";
	}
}
/*
	Return the categories array of taxonomy which we pass in argument
*/
function templ_get_video_parent_categories($taxonomy) {
	$cat_args = array(
	'taxonomy'=>$taxonomy,
	'orderby' => 'name', 				
	'hierarchical' => 'true',
	'parent'=>0,
	'hide_empty' => 0,	
	'title_li'=>'');				
	$categories = get_categories( $cat_args );	/* fetch parent categories */
	return $categories;
}
/*
	If we pass parent category ID and taxonomy in functions argument it will return all the child categories 
*/
function templ_get_video_child_categories($taxonomy,$parent_id) {
	$args = array('child_of'=> $parent_id,'hide_empty'=> 0,'taxonomy'=>$taxonomy);                        
	$child_cats = get_categories( $args );	/* get child cats */
	return $child_cats;
}
/*
	function to show different video option while submit video
*/
add_action('tmpl_custom_fields_video_option_after','tmpl_custom_fields_video_option_after');
function tmpl_custom_fields_video_option_after()
{
        global $theme_settings;
        $theme_settings = empty($theme_settings) ? get_option('video_theme_settings'): $theme_settings;
        $name = 'video_image';
        if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
            $edit_id = $_REQUEST['pid'];
            $wp_attached_file = get_post_meta($edit_id,'_wp_attached_file',true);
            $video = get_post_meta($edit_id,'video',true);
            $oembed = get_post_meta($edit_id,'oembed',true);
            $video_autoplay = get_post_meta($edit_id,'autoplay',true);
            
            /* default seleted and display block*/
            $video_upload = get_post_meta($edit_id,'video_upload',true);
            $is_downloadable = get_post_meta($edit_id,'is_downloadable',true);
            $image_upload = get_post_meta($edit_id,'upload_image',true);
            $image_generate = get_post_meta($edit_id,'image_generate',true);
            $upload_image_type = get_post_meta($edit_id,'upload_image_type',true);
            $video_image = get_post_meta($edit_id,'video-image',true);          
            
        }else{
            $wp_attached_file = '';
            $video = '';
            $oembed = '';
            $video_autoplay = false;
            $is_downloadable = false;
            $video_upload = '';
            $image_upload = false;
            $image_generate = false;
            $upload_image_type = 'upload_image';
            $video_image = '';            
        }
	 ?>
     	<div class="fields-set" id="div_upload_video" style="<?php echo ($video_upload == '' || $video_upload == 'upload') ? '' : 'display:none'; ?>">
            <input type="file" class="upload_video" id="upload_video" name="upload_video"/>
            <label class="r_lbl"><?php echo __('Maximum upload size: ','templatic') . $theme_settings['fileupload_video'] . __('MB','templatic');?></label>
            <label class="r_lbl"><?php echo __('Supported file types: MP4, WebM, and Ogg','templatic');?></label>
            <input type="hidden" value="<?php echo $wp_attached_file; ?>" name="_wp_attached_file"/>
            <?php echo ($wp_attached_file !='') ? '<span>'. __('Attach Url: ') .$wp_attached_file . '</span>' : '';?>
            <span id="upload_video_error"></span>
            <div class="fields-set">
                <input type="checkbox" name="is_downloadable" id="is_downloadable" class="pt_input_checkbox" <?php echo ($is_downloadable=='on') ? 'checked="checked"' : ''; ?>> <label for="is_downloadable"> <?php echo __('Allow Downloads','templatic');?></label>
            </div>
        </div>
        <div class="fields-set" id="div_oembed_video" style="<?php echo ($video_upload == 'ptthemes_oembed') ? '' : 'display:none'; ?>">
            <label class="r_lbl"><?php echo __('Video URL','templatic'); ?></label>
            <div class="fields-set">
                <input type="text" id="oembed_video" name="oembed" value="<?php echo $oembed; ?>" class="textfield" size="100">                
                <span id="ptthemes_oembed_error"></span>
            </div>
        </div>
        
        <!--common option for upload video and url-->
       
        <div class="fields-set div-autoplay" style="<?php echo ($video_upload == 'ptthemes_video') ? 'display:none' : ''; ?>">
            <input type="checkbox" name="autoplay" id="video_autoplay" class="pt_input_checkbox" <?php echo ($video_autoplay == 'on' || $is_downloadable==false) ? 'checked="checked"' : ''; ?>> <label for="video_autoplay"> <?php echo __('Enable Autoplay','templatic');?></label>
            <label class="r_lbl"><?php echo __('Autoplays video on its detail page.','templatic'); ?> </label>
        </div>

        <div class="fields-set" id="div_ptthemes_video" style="<?php echo ($video_upload == 'ptthemes_video') ? '' : 'display:none'; ?>">
            <label class="r_lbl"><?php _e('Video Embed Code','templatic'); ?></label>
            <textarea id="video" class="upload_video pt_input_textarea" name="video" cols="98" rows="3"><?php echo $video; ?></textarea>
            <span id="ptthemes_video_error"></span>
        </div>
        <?php 
        /* only add auto generate option when video-thumbnail plugin active 
         * by default upload feature image
         * after plugin active give option to choose
         */
        if ( is_plugin_active( 'video-thumbnails/video-thumbnails.php' ) ) { ?>
        <div id="div_video_thumbnail_option">    
            <label class="r_lbl">Video thumbnail option</label>
            <div class="fields-set">
                <ul class="hr_input_radio">
                    <li id="li-upload-image"><input name="upload_image_type" id="image_upload" type="radio" value="upload_image" <?php echo ($upload_image_type == 'upload_image') ? 'checked="checked"' : ''; ?>/> <label for="image_upload"><?php _e('Upload feature Image','templatic');?></label></li>                    
                    <li id="li-image-generage"><input name="upload_image_type" id="image_generate" type="radio" value="generate_image" <?php echo ($upload_image_type == 'generate_image') ? 'checked="checked"' : ''; ?>/> <label for="image_generate"><?php _e('Generate video thumbnail','templatic');?></label></li>
                </ul>
            </div>
        </div>
        <?php } ?>
                
        <div class="fields-set">
            <label class="r_lbl">Video thumbnail</label>
            <div id="div_upload_image">
                <div class="upload_box <?php echo apply_filters('tmpl_cf_img_uploder_class',''); ?>">
                    <div class="hide_drag_option_ie">
                        <p><?php _e('You can drag &amp; drop images from your computer to this box.','templatic'); ?></p>
                        <p><?php _e('OR','templatic'); ?></p>
                    </div>
                    <?php
                    echo '<div class="tmpl_single_uploader">';

                            $wp_upload_dir = wp_upload_dir();?>

                            <!-- Save the uploaded image path in hidden fields -->
                            <input type="hidden" value="<?php echo stripslashes($video_image); ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="fileupload uploadfilebutton"  placeholder="<?php echo @$val['default']; ?>"/>
                            <div id="<?php echo $name; ?>"></div>

                            <div id="fancy-contact-form">
                                <div class="dz-default dz-message" ><span  id="fancy-<?php echo $name; ?>"><span><i class="fa fa-folder"></i>  <?php _e('Upload File','templatic'); ?></span></span></div>
                                <p class="max-upload-size">
                                    <?php echo __( 'Maximum upload file size: ','templatic') . $theme_settings['fileupload_image'] . __('MB','templatic'); ?>
                                </p>
                                    <?php if(@$_REQUEST['pid']==''){ ?>
                                    <span  id="image-<?php echo $name; ?>"></span>
                                    <?php } ?>
                                <input type="hidden" name="submitted" value="1">
                            </div>
                            <script type="text/javascript" async >
                                    var image_thumb_src = '<?php echo  $wp_upload_dir['url'];?>/';
                                    jQuery(document).ready(function(){
                                            var settings = {
                                                    url: '<?php echo get_template_directory_uri(); ?>/functions/single_upload.php',
                                                    dragDrop:true,
                                                    fileName: "<?php echo $name; ?>",
                                                    allowedTypes:"jpeg,jpg,png,gif",	
                                                    returnType:"json",
                                                    multiple:false,
                                                    showDone:false,
                                                    showAbort:false,
                                                    showProgress:true,
                                                    onSubmit:function(files, xhr)
                                                    {
                                                            /*jQuery('.ajax-file-upload-statusbar').html('');*/
                                                    },
                                                    onSuccess:function(files,data,xhr)
                                                    {
                                                            jQuery('#image-<?php echo $name; ?>').html('');
                                                            if(jQuery('#img_<?php echo $name; ?>').length > 0)
                                                            {
                                                                    jQuery('#img_<?php echo $name; ?>').remove();
                                                            }
                                                        var img = jQuery('<img height="60px" width="60px" id="img_<?php echo $name; ?>">'); /*Equivalent: $(document.createElement('img'))*/
                                                        data = data+'';
                                                            if(data != 'error'){
                                                                    var id_name = data.split('.');
                                                                    console.log(id_name);
                                                                    if(id_name[1] == 'pdf')
                                                                            var img_name = '<?php echo TEVOLUTION_PAGE_TEMPLATES_URL."/images/pdfthumb.png"; ?>';
                                                                    else
                                                                            var img_name = '<?php echo bloginfo('template_url')."/images/tmp/"; ?>'+id_name[0]+"."+id_name[1];	

                                                                    img.attr('src', img_name);
                                                                    img.appendTo('#image-<?php echo $name; ?>');
                                                            }
                                                            else
                                                            {
                                                                    jQuery('#image-<?php echo $name; ?>').html("<?php _e('Image can&rsquo;t be uploaded due to some error.','templatic'); ?>");
                                                                    jQuery('.ajax-file-upload-statusbar').css('display','none');
                                                                    return false;
                                                            }
                                                            jQuery('#image-<?php echo $name; ?>').css('display','');
                                                            jQuery('#<?php echo $name; ?>').val(image_thumb_src+data);
                                                            jQuery('.ajax-file-upload-filename').css('display','none');
                                                            jQuery('.ajax-file-upload-red').css('display','none');
                                                            jQuery('.ajax-file-upload-progress').css('display','none');
                                                    },
                                                    showDelete:true,
                                                    deleteCallback: function(data,pd)
                                                    {
                                                            for(var i=0;i<data.length;i++)
                                                            {
                                                                    jQuery.post("<?php echo get_template_directory_uri(); ?>/functions/delete_image.php",{op:"delete",name:data[i]},
                                                                    function(resp, textStatus, jqXHR)
                                                                    {
                                                                            /*Show Message  */
                                                                            jQuery('#image-<?php echo $name; ?>').html("<div><?php _e('File Deleted','templatic');?></div>");
                                                                            jQuery('#<?php echo $name; ?>').val('');
                                                                    });
                                                             }      
                                                            pd.statusbar.hide(); /*You choice to hide/not.*/

                                                    }
                                            }
                                            var uploadObj = jQuery("#fancy-"+'<?php echo $name; ?>').uploadFile(settings);
                                    });
                                    function single_delete_image(name,field_name)
                                    {
                                            jQuery.ajax({
                                                     url: '<?php echo get_template_directory_uri(); ?>/functions/delete_image.php?op=delete&name='+name,
                                                     type: 'POST',
                                                     success:function(result){
                                                            jQuery('#image-'+field_name).html("<div>File Deleted</div>");
                                                            jQuery('#'+field_name).val('');			
                                                    }				 
                                             });
                                    }
                            </script>
                            <?php do_action('tmpl_custom_fields_'.$name.'_after');

                            /* check the format of uploaded file ( is image ??)*/
                            if($_REQUEST['pid'] ):
                                $thumb_img_arr = bdw_get_images_plugin($_REQUEST['pid'],'full');

                                     if($thumb_img_arr):
                                        foreach ($thumb_img_arr as $val) :
                                                    $image = $val['file'];
                                                    $tmpimg = explode("/",$val['file']);
                                                    $name1 = end($tmpimg);
                                                    if($name!="")
                                                            $image_name.=$name1.",";
                                           endforeach;	   
                                     endif;

                                    if(isset($_REQUEST[$name]) && $_REQUEST[$name] != '')
                                    {
                                            $image = $_REQUEST[$name];
                                    }

                                    $upload_file=strtolower(substr(strrchr($image,'.'),1));
                                    if($upload_file =='jpg' || $upload_file =='jpeg' || $upload_file =='gif' || $upload_file =='png' || $upload_file =='jpg' ){
                                                    ?>
                                            <p id="image-<?php echo $name; ?>" class="resumback"><img height="60px" width="60px" src="<?php echo $image; ?>" /><span class="ajax-file-upload-red" onclick="single_delete_image('<?php echo basename($image);?>','<?php echo $name;?>')"><?php _e('Delete','templatic-admin'); ?></span></p>
                                    <?php }elseif($upload_file != ''){ ?>
                                            <p id="image-<?php echo $name; ?>" class="resumback"><a href="<?php echo get_post_meta($_REQUEST['pid'],'_wp_attached_file', $single = true); ?>"><?php echo basename(get_post_meta($_REQUEST['pid'],'_wp_attached_file', $single = true)); ?></a><span class="ajax-file-upload-red" onclick="single_delete_image('<?php echo basename($video_image);?>','<?php echo $name;?>')"><?php _e('Delete','templatic-admin'); ?></span></p>
                                    <?php } 
                            endif; 
                    echo '</div>';
                            if($admin_desc!=""):?><div class="description"><?php echo $admin_desc; ?></div><?php endif; ?>
                            <?php echo $is_required_msg;?>
                            <span class="message_error2" id="post_images_error"></span>
                            <span class="safari_error" id="safari_error"></span>
                </div>
            </div>               
        </div>
<?php
}

/*
	script to show video option on submit video page
*/
add_action('wp_footer','show_video_option');
function show_video_option()
{
	?>
    <script>
		jQuery(document).ready(function(e) {
			jQuery("#submit_form input[name=video_upload]:radio").change(function () {
				if(jQuery(this).val()=='upload')
				{
					jQuery('#div_upload_video').css('display','block');
					jQuery('#div_ptthemes_video').css('display','none');
					jQuery('#div_oembed_video').css('display','none');
                                        jQuery('#video-options').css('display','block');
                                        jQuery('#div_video_thumbnail_option').show();                                        
                                        jQuery('.div-autoplay').show();
				}
				else if(jQuery(this).val()=='ptthemes_video')
				{
					jQuery('#div_ptthemes_video').css('display','block');
					jQuery('#div_oembed_video').css('display','none');
					jQuery('#div_upload_video').css('display','none');
					jQuery('#video-options').css('display','none');
                                        jQuery('#div_upload_image').show();
                                        jQuery('#div_secound').hide();
                                        jQuery('.div-autoplay').hide();
                                        jQuery('#div_video_thumbnail_option').hide();
                                        
				}
				else if(jQuery(this).val()=='ptthemes_oembed')
				{
					jQuery('#div_upload_video').css('display','none');
					jQuery('#div_ptthemes_video').css('display','none');
					jQuery('#div_oembed_video').css('display','block');
                                        jQuery('#video-options').css('display','block');
                                        jQuery('#div_video_thumbnail_option').show();                                        
                                        jQuery('.div-autoplay').show();
				}
			});
                        jQuery("#submit_form input[name=upload_image_type]:radio").change(function () {
                            if(jQuery(this).val()=='upload_image')
                            {
                                jQuery('#div_upload_image').show();
                                jQuery('#div_secound').hide();
                            }else{
                                jQuery('#div_secound').show();
                                jQuery('#div_upload_image').hide();
                            }
                        });
                        jQuery("#submit_form input[name=video_url_image_type]:radio").change(function () {
                            if(jQuery(this).val()=='upload_image')
                            {
                                jQuery('#div_upload_video_url').show();
                                jQuery('#div_secound_video_url').hide();
                            }else{
                                jQuery('#div_secound_video_url').show();
                                jQuery('#div_upload_video_url').hide();
                            }
                        });
                        
        });
	</script>
    <?php
}
if(isset($_REQUEST['page']) && $_REQUEST['page'] == "paynow")
{
    /* video post submit */
    if(($_POST['submit_post_type'] && $_POST['submit_post_type']!="")  && (isset( $_POST['submit_form_nonce_field'] ) || wp_verify_nonce( $_POST['submit_form_nonce_field'], 'submit_form_action' )) )
    {
        $custom_fields = $_POST;
        $custom = array();
        $post_title = stripslashes($_POST['post_title']);
        $description = @$_POST['post_content'];
        $post_excerpt = $_POST['post_excerpt'];
        
        $post_type = $_POST['submit_post_type'];
        $catids_arr = array();
        $my_post = array();	

        if(isset($_POST['category']) && $_POST['category']!=''){
                foreach($_POST['category'] as $value){
                        $category=explode(',',$value);				
                        $category_id[]=$category[0];
                }
        }

        global $current_user,$last_postid;
        $current_user_id = ($current_user->ID != 0) ? $current_user->ID : tmpl_video_insertuser_with_listing();
        /*Post author */		
        $my_post['post_author']=($current_user_id)?$current_user_id: 0;
        /* Post Title */
        $my_post['post_title'] = $post_title;
        /*Post Content */
        $my_post['post_content'] = $description;
        /*Post Excerpt */
        $my_post['post_excerpt'] = $post_excerpt;
        /*Post Category */
        
        $my_post['post_category'] = $category_id;
        
        /*Post type */
        $my_post['post_type'] = $_POST['submit_post_type'];
        /*Post Name*/
        $my_post['post_name']=sanitize_title($post_title);
        
        /*Post Status set as per theme option set by admin, other wise by default draft*/
        $theme_settings = get_option('video_theme_settings');
        $my_post['post_status'] = isset($theme_settings['video_default_status']) ? $theme_settings['video_default_status'] : 'draft';

        $default_comment_status = get_option('default_comment_status'); /* default get comment status for new posts */

        $my_post['comment_status'] = $default_comment_status;

        if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
            $my_post['ID'] = $_REQUEST['pid'];
        }
        
        /* remove hook of video thumbnai generator if upload image type is seleted */
        if(is_plugin_active( 'video-thumbnails/video-thumbnails.php' ) && (isset($_REQUEST['upload_image_type']) && $_REQUEST['upload_image_type'] == 'upload_image')){
            remove_action( 'save_post', 'save_video_thumbnail', 10);
        }
        
        /* Insert the post into the database */
        /* added condition for spam entry */
        if($my_post['post_category']){
                $last_postid = wp_insert_post($my_post);
                update_post_meta($last_postid, 'category', implode(',', $my_post['post_category']));
        }
        $taxonomy = 'videoscategory';
        /*Insert Post selected category */
        if($my_post['post_category']){
                if(!isset($_POST['action_edit']))
                        wp_set_post_terms( $last_postid,'',$taxonomy,false);


                if(isset($_POST['action_edit'])){
                        wp_set_post_terms( $last_postid,'',$taxonomy,false);
                                foreach($my_post['post_category'] as $_post_category){	
                                        wp_set_post_terms( $last_postid,$_post_category,$taxonomy,true);					
                                }
                }else{
                        foreach($my_post['post_category'] as $_post_category){					
                                wp_set_post_terms( $last_postid,$_post_category,$taxonomy,true);					
                        }
                }
         }
         if(!isset($custom_fields['upload_image_type'])){
             $custom_fields['upload_image_type'] = 'upload_image';
         }  
         $exclude_post=apply_filters('submit_exclude_post',array('category','post_title','post_content','imgarr','Update','post_excerpt','post_tags','selectall','submitted','submit_post_type','action','pid','generate_video_second','video_image'),$_POST);
         /* insert/update custom fields */
        foreach($custom_fields as $key=>$val)
        {
                /* Check submitted key in exclude post array*/
                if(!in_array($key,$exclude_post))
                {			
                        if($key=='recurrence_bydays'){

                                $val=implode(',',$val);
                                update_post_meta($last_postid, $key, trim($val));

                }elseif($key == 'upload_image_type'){
                    update_post_meta($last_postid, $key, $val);
                    if($val == 'upload_image'){
                        global $wpdb;
                       if(@$custom_fields['video_image']!= '')
						{
							$image_title = explode('/', $custom_fields['video_image']);
							$image_title = explode(".",end($image_title));
							$image_title = $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title = '$image_title[0]' AND post_type = 'attachment'");
			                $image_id = $wpdb->get_var( $image_title );
	                        update_post_meta( $last_postid, '_thumbnail_id', $image_id );
						}
                    }else{
                        update_post_meta( $last_postid, '_thumbnail_id','');
                        update_post_meta( $last_postid, 'video_image','');
                    }
                    
                }else{
                                $value=(is_array($val))?$val:trim($val);
                                if($value!=""){
                                        update_post_meta($last_postid, $key, $value);
                                }
                                else
                                {
                                        update_post_meta($last_postid, $key, '');
                                }
                        }
                }
        }

        /* file upload and attach with the post */
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
        }
        $upload_dir = wp_upload_dir();
        $uploadPath = $upload_dir['path'];
        $uploadUrl = $upload_dir['url'];
        if(isset($_FILES) && !empty($_FILES['upload_video']) && $_FILES['upload_video']['name'] != ''){
            foreach($_FILES as $file){

                //process file and upload
                $override = array( 'test_form' => false );
                $uploaded_file = wp_handle_upload($file, $override);

                if($uploaded_file){
                        $attachment = array(
                                'post_title' => $file['name'],
                                'post_content' => '',
                                'post_type' => 'attachment',
                                'post_parent' => 0,
                                'post_mime_type' => $file['type'],
                                'guid' => $uploaded_file['url']
                        );

                        $attach_id = wp_insert_attachment($attachment,$uploaded_file['file'],$last_postid);
                        if($attach_id){
                            wp_update_attachment_metadata( $attach_id, wp_generate_attachment_metadata( $attach_id, $uploaded_file['file'] ) );
                            update_post_meta($last_postid, '_wp_attached_file', $uploaded_file['url']);
                        }

                } else {
                        $error = true;
                        $errors[] = $uploaded_file['error'];
                }
                unset($file);
            }
        }
        
        /* send email of video post & update submit*/
        global $post;
        $post = get_post($last_postid);
        $author = $post->post_author;
        $name = get_the_author_meta( 'display_name', $author );
        $email = get_the_author_meta( 'user_email', $author );
        $title = $post->post_title;
        
        $to[] = sprintf( '%s <%s>', $name, $email );
        $subject = sprintf( 'Video Post: %s', $title );
        $message = '';
        
	$message .= "<p>Dear $name</p>";
	if(isset($_REQUEST['pid']) && $_REQUEST['pid']!="")
	{
            $message .= '<p class="sucess_msg_prop">'. __('Thank you for submitting your video at our site, your request has been updated successfully.','templatic').'</p>';
	}else{
            /* if user set by default status publish than show different message */
            $theme_settings = get_option('video_theme_settings');
            if(isset($theme_settings['video_default_status']) && $theme_settings['video_default_status'] == 'publish'){
                $message .= '<p class="sucess_msg_prop">'.__('The video will goes live on the site.','templatic').'</p>';                
            }else{
                $message .= '<p class="sucess_msg_prop">'.__('The video will require admin approval before it goes live on the site.','templatic').'</p>';
                $message .= '<p class="sucess_msg_prop">'.__('You will get an email confirmation once your video has been published.','templatic').'</p>';
            }
	}
        $message .= "<p>You can view your video on the following link</p>";	
        $message .= '<a href="'.get_permalink($last_postid).'">'.get_permalink($last_postid).'</a>';	
        $message .= "<p>Thank you</p>";
        
        $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        
        $fromEmail = get_option('admin_email');
        $fromEmailName = stripslashes(get_option('blogname'));
        $headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
        
        wp_mail( $to, $subject, $message, $headers ); 
        
        wp_redirect(site_url().'/?page=success&pid='.$last_postid);
        exit;
    }	
}


add_action('video_posts_submition_success_msg','video_posts_submition_success_msg_fn');

/*
 *  function while change in status from transaction detail page
 */
function video_posts_submition_success_msg_fn(){
	global $wpdb,$current_user,$monetization;
	//$post_link = "<a href='".get_permalink($_REQUEST['pid'])."'>".__("Click here",'templatic')."</a> ".__('for a preview of the submitted content.','templatic');
	
	$store_name = '<a href="'.home_url().'">'.get_option('blogname').'</a>';
	
	$siteName = "<a href='".home_url()."'>".$store_name."</a>";
	$search_array = array('[#post_type#]','[#payable_amt#]','[#bank_name#]','[#account_number#]','[#submition_Id#]','[#store_name#]','[#site_name#]');
	$replace_array = array($suc_post->post_type,$paid_amount,@$bankInfo,@$accountinfo,$orderId,$store_name,$siteName);	
	$posttype_obj = get_post_type_object($suc_post->post_type);
	$post_lable = ( @$posttype_obj->labels->menu_name ) ? strtolower( @$posttype_obj->labels->menu_name ) :  strtolower( $posttype_obj->labels->singular_name );
        
        $theme_settings = get_option('video_theme_settings');
	if(!isset($_REQUEST['action']))
	{
            /* if user set by default status publish than show different message */
            
            if(isset($theme_settings['video_default_status']) && $theme_settings['video_default_status'] == 'publish'){
                $filecontent .= '<p class="sucess_msg_prop">'.__('The video will goes live on the site.','templatic').'</p>';                
            }else{
                $filecontent = '<p class="sucess_msg_prop">'.__('The video will require admin approval before it goes live on the site.','templatic').'</p>';
                $filecontent .= '<p class="sucess_msg_prop">'.__('You will get an email confirmation once your video has been published.','templatic').'</p>';
            }            
	}
	elseif($_REQUEST['action']=='edit' && !isset($_REQUEST['upgrade'])){
		$filecontent = '<p class="sucess_msg_prop">'.sprintf(__('Thank you for submitting your %s at our site, your %s request has been updated successfully.','templatic'),$suc_post->post_type,$suc_post->post_type).'</p>';
	}
        $filecontent .= "<p>You can view your video on the following link</p>";	
        
        if(isset($theme_settings['video_default_status']) && $theme_settings['video_default_status'] == 'publish'){
            $filecontent .= '<a href="'.get_permalink($_REQUEST['pid']).'">'.get_permalink($_REQUEST['pid']).'</a>';	
        }else{
            $filecontent .= '<a href="#">'.get_permalink($_REQUEST['pid']).'</a>';	
        }
	
	$filecontent = str_replace($search_array,$replace_array,$filecontent); 
	echo $filecontent;
}
add_action('video_posts_submition_success_post_content','post_videos_submition_success_post_submited_content');
function post_videos_submition_success_post_submited_content()
{
	?>
     <!-- Short Detail of post -->
	<div class="submit_info_section sis_on_submitinfo">
		<h3><?php _e('Your submitted Video','templatic');?></h3>
	</div>
        <div class="submited_info">
	<?php
            global $wpdb,$post,$current_user;
            remove_all_actions('posts_where');

            $suc_post = get_post($_REQUEST['pid']);

            do_action('after_tevolution_success_msg');
	?>
	</div>
     
        <div class="title_space">
            <div class="submit_info_section">
                <h3><?php _e('Title','templatic');?></h3>
            </div>
            <p><?php echo stripslashes($suc_post->post_title); ?></p>
        </div>
        <?php 
           if(!empty($suc_post->post_excerpt)){ ?>
               <div class="title_space">
                   <div class="submit_info_section">
                       <h3><?php _e('Video Excerpt','templatic');?></h3>
                   </div>
                   <p><?php echo nl2br($suc_post_con = $suc_post->post_excerpt); ?></p>
               </div>

               <!-- End Short Detail of post -->
       <?php
       }
        
	 $media = get_attached_media( 'video', $_REQUEST['pid']);
	 if(!empty( $media )){
		$count=0;
		foreach ( $media as $attachment ) {
				$count++;
				$class = "post-attachment mime-".$attachment->ID.sanitize_title( $attachment->post_mime_type );
				$link = wp_get_attachment_url( $attachment->ID,'','','', false );	
				$mimetype = $attachment->post_mime_type;
				$video_link='<video width="100%" height="100%" controls><source src="'.$link.'" type="'.$mimetype.'"></video> ';												
				if($count ==1){
					break;
				}
		}
	 }else{
		if(get_post_meta($_REQUEST['pid'],'video',true) !='') {
			$video_link=get_post_meta($_REQUEST['pid'],'video',true);
		}
		elseif(get_post_meta($_REQUEST['pid'],'oembed',true) !='') {
			$autoplay = 0;			
			$video_link=wp_oembed_get(get_post_meta($_REQUEST['pid'],'oembed',true),array( 'autoplay' => $autoplay, 'rel' => 0) );	
		}
	 }
	 if(@$video_link){
	  ?>
    <!-- display video end -->

	<article class="row detail-video">
	<div class="large-12 columns">
		<div class="flex-video">
			<?php echo $video_link; ?>
		</div>
	</div>
	</article>
    <?php
	 }?>
      <div class="title_space">
         <div class="submit_info_section">
            <h3><?php _e('Video Description', 'templatic');?></h3>
         </div>
         <p><?php echo nl2br($suc_post->post_content); ?></p>
      </div>
    <?php
    global $post;
    $categories = get_the_terms( $suc_post->ID, 'videoscategory' );
    echo __('Posted In:- ', 'templatic');
    $category_list = '';    
    foreach($categories as $category){
        $category_list .= '<a href="'.get_term_link($category).'" title="'.$category->name.'">'.$category->name .'</a>, ';
    }
    echo rtrim($category_list,", ");
    
}

/* Login -  from  on SUbmit video page  */
/*
 fetch login and registration form in submit page template
*/

add_action('templ_fetch_registration_onsubmit','templ_fetch_registration_onsubmit_');
function templ_fetch_registration_onsubmit_(){
	if($_SESSION['custom_fields']['login_type'])
	{
		$user_login_or_not = $_SESSION['custom_fields']['login_type'];
	}
	if((isset($_SESSION['user_email']) && $_SESSION['user_email']!='') || (isset($_REQUEST['backandedit']) && $_REQUEST['backandedit'] == 1))
	{
		$user_login_or_not = 'new_user';
	}
	global $user_validation_info;
	$user_validation_info[] = array(
								   'name'	=> 'user_email',
								   'espan'	=> 'user_email_error',
								   'type'	=> 'text',
								   'text'	=> 'Email',
								   );
	$user_validation_info[] = array(
								   'name'	=> 'user_fname',
								   'espan'	=> 'user_fname_error',
								   'type'	=> 'text',
								   'text'	=> 'Username',
								   );
	?>
	<div id="login_user_meta" <?php if($user_login_or_not=='new_user'){ echo 'style="display:block;"';}else{ echo 'style="display:none;"'; }?> >
		<input type="hidden" name="user_email_already_exist" id="user_email_already_exist" value="<?php if($_SESSION['custom_fields']['user_email_already_exist']) { echo "1"; } ?>" />
		<input type="hidden" name="user_fname_already_exist" id="user_fname_already_exist" value="<?php if($_SESSION['custom_fields']['user_fname_already_exist']) { echo "1"; } ?>" />
		<input type="hidden" name="login_type" id="login_type" value="<?php echo $_SESSION['custom_fields']['login_type']; ?>" />
		<input type="hidden" name="reg_redirect_link" value="<?php echo apply_filters('tevolution_register_redirect_to',@$_SERVER['HTTP_REFERER']);?>" />
        <div class="form_row clearfix"><label>Email <span class="indicates">*</span> </label><input name="user_email" type="text" id="user_email" size="25" class="textfield" value=""><span id="user_email_error"></span><span class="message_note"></span></div><div class="form_row clearfix"><label>Username <span class="indicates">*</span> </label><input name="user_fname" type="text" id="user_fname" size="25" class="textfield" value=""><span id="user_fname_error"></span><span class="message_note"></span></div>       

        <div class="form_row clearfix">
        	<input name="register" type="button" id="register_form" value="<?php echo __('Sign Up','templatic'); ?>" class="button secondary_btn post-edit-link">
        </div>
        <?php require_once(get_template_directory().'/functions/registration_validation.php'); ?>
	</div>
<?php
}
add_action('templ_fecth_login_onsubmit','templ_fecth_login_onsubmit');
function templ_fecth_login_onsubmit(){ 
	global $post;
?>
<p style="display:none;" class="status"></p>
	<div class="login_submit clearfix" id="loginform">
		<div class="sec_title">
			<h3 class="form_title spacer_none"><?php _e('Login or register','templatic');?></h3>
		</div>
		<?php 
		
		if($_SESSION['custom_fields']['login_type'])
		{
			$user_login_or_not = $_SESSION['custom_fields']['login_type'];
		}
		if(isset($_REQUEST['usererror'])==1)
		{
			if(isset($_SESSION['userinset_error']))
			{
				for($i=0;$i<count($_SESSION['userinset_error']);$i++)
				{
					echo '<div class="error_msg"><p>'.$_SESSION['userinset_error'][$i].'</p></div>';
				}
				
			}
		}
		
		if(isset($_REQUEST['emsg'])==1): ?>
			<div class="error_msg"><?php _e('Incorrect Username/Password.','templatic');?></div>
		<?php endif; ?>
		
		<div class="user_type clearfix">
			
			<label class="lab1"><?php _e('I am a','templatic');?> </label>
			<label class="radio_lbl"><input name="user_login_or_not" type="radio" value="existing_user" <?php if($user_login_or_not=='existing_user'){ echo 'checked="checked"';}else{ echo 'checked="checked"'; }?> onclick="set_login_registration_frm('existing_user');" /> <?php _e('Existing User','templatic');?> </label>
			<?php 
				$users_can_register = get_option('users_can_register');
				if($users_can_register):
			?><label class="radio_lbl"><input name="user_login_or_not" type="radio" value="new_user" <?php if($user_login_or_not=='new_user'){ echo 'checked="checked"';}?> onclick="set_login_registration_frm('new_user');" /> <?php _e('New User? Register Now','templatic');?> </label>
			<?php endif;
		do_action('tmpl_login_options');
		?>
		
		</div>
		
		<?php echo do_action('show_meida_login_button',$post->ID); ?>
		
		<!-- Login Form -->
		<div name="loginform" class="sublog_login" <?php if($user_login_or_not=='existing_user' || $user_login_or_not == '' ){ ?> style="display:block;" <?php } else {  ?> style="display:none;" <?php }?>  id="login_user_frm_id"  >
      
			<div class="form_row clearfix lab2_cont">
				<label class="lab2"><?php _e('Login','templatic');?><span class="required">*</span></label>
				<input type="text" class="textfield slog_prop " id="user_login" name="log" />
			</div>

			<div class="form_row learfix lab2_cont">
				<label class="lab2"><?php _e('Password','templatic');?><span class="required">*</span> </label>
				<input type="password" class="textfield slog_prop" id="user_pass" name="pwd" />
			</div>
		  
			<div class="form_row clearfix">
				<input name="submit_form_login" type="button" id="submit_form_login" value="<?php _e('Login','templatic');?>" class="button secondary_btn post-edit-link" />
			</div>
			<?php do_action('login_form');
			$login_redirect_link = get_permalink();?>
		  <input type="hidden" name="redirect_to" value="<?php echo $login_redirect_link; ?>" />
		  <input type="hidden" name="testcookie" value="1" />
		  <input type="hidden" name="pagetype" value="<?php echo $login_redirect_link; ?>" />
		  <?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
          
		</div>
		<!-- Login Form End -->
    </div>
	<?php
	add_action('wp_footer','tmpl_submit_form_ajax_login',20); /* call a function for ajax login.*/
} 

/*
* script for registration validation while submit form.
*/
function tmpl_submit_form_ajax_login()
{
	?>
	<script type="text/javascript" async>
		jQuery(document).ready(function($) {
			var redirecturl = '<?php echo $_SESSION['redirect_to']; ?>';
			jQuery('form#submit_form #user_email').bind('keyup',function(){
				if(jQuery.trim(jQuery("form#submit_form #user_email").val()) != "")
				{
					var a = jQuery("form#submit_form #user_email").val();
					var emailReg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
					if(jQuery("form#submit_form #user_email").val() == "") { 
					<?php
					$msg = html_entity_decode(__("Please provide your email address",'templatic'),ENT_COMPAT, 'utf-8');
					?>
						jQuery("form#submit_form #user_email").addClass("error");
						jQuery("form#submit_form #user_email_error").text("<?php echo $msg; ?>");
						jQuery("form#submit_form #user_email_error").addClass("message_error2");
					return false;
						
					} else if(!emailReg.test(jQuery("form#submit_form #user_email").val().replace(/\s+$/,""))) { <?php
						$msg = html_entity_decode(__("Please enter a valid email address",'templatic'),ENT_COMPAT, 'utf-8');
						?>
						jQuery("form#submit_form #user_email").addClass("error");
						jQuery("form#submit_form #user_email_error").text("<?php echo $msg; ?>");
						jQuery("form#submit_form #user_email_error").addClass("message_error2");
						return false;
					} else {
					chkemail(jQuery("form#submit_form #user_email").val());
					var chk_email = document.getElementById("user_email_already_exist").value;

						if(chk_email > 0)
						{
							
							jQuery("form#submit_form #user_email_already_exist").val(1);
							jQuery("form#submit_form #user_email_error").removeClass('message_error2');
							jQuery("form#submit_form #user_email_error").addClass('available_tick');
							jQuery("form#submit_form #user_email_error").html("<?php _e('The email address is correctly entered.','templatic');?>");
							jQuery("form#submit_form #user_email").removeClass("error");
							jQuery("form#submit_form #user_email_error").removeClass("message_error2");
							return true;
						}
						else{
							jQuery("form#submit_form #user_email_error").html("<?php _e('Email address already exists, Please enter another email','templatic');?>");
							jQuery("form#submit_form #user_email_already_exist").val(0);
							jQuery("form#submit_form #user_email_error").removeClass('available_tick');
							jQuery("form#submit_form #user_email_error").addClass('message_error2');
							return false;
						}
					}
				}
			});
			jQuery('form#submit_form #user_fname').bind('keyup',function(){
				if(jQuery.trim(jQuery("form#submit_form #user_fname").val()) != "")
				{
					var a = jQuery("form#submit_form #user_fname").val();
					var userLength = jQuery("form#submit_form #user_fname").val().length;
					if(jQuery("form#submit_form #user_fname").val() == "") {
							jQuery("form#submit_form #user_fname").addClass("error");
							jQuery("form#submit_form #user_fname_error").text("<?php echo $msg; ?>");
							jQuery("form#submit_form #user_fname_error").addClass("message_error2");
							
					}else if(jQuery("form#submit_form #user_fname").val().match(/\ /)){
						jQuery("form#submit_form #user_fname").addClass("error");
						jQuery("form#submit_form #user_fname_error").text("<?php _e("Usernames should not contain space.",'templatic'); ?>");
						jQuery("form#submit_form #user_fname_error").addClass("message_error2");
						return false;
					}else if(userLength < 4 ){
						jQuery("form#submit_form #user_fname").addClass("error");
						jQuery("form#submit_form #user_fname_error").text("<?php _e("The username must be at least 4 characters long",'templatic'); ?>");
						jQuery("form#submit_form #user_fname_error").addClass("message_error2");
						return false;
					}else
					{
						chkname(jQuery("form#submit_form #user_fname").val());
						var chk_fname = document.getElementById("user_fname_already_exist").value;
						if(chk_fname > 0)
						{
							jQuery("form#submit_form #user_fname_error").html("<?php _e('This username is available.','templatic');?>");
							jQuery("form#submit_form #user_fname_already_exist").val(1);
							jQuery("form#submit_form #user_fname_error").removeClass('message_error2');
							jQuery("form#submit_form #user_fname_error").addClass('available_tick');
							jQuery("form#submit_form #user_fname").removeClass("error");
							jQuery("form#submit_form #user_fname_error").removeClass("message_error2");
							return true;
						}
						else{
							jQuery("form#submit_form #user_fname_error").html("<?php _e('The username you entered already exists, please try a different one','templatic');?>");
							jQuery("form#submit_form #user_fname_already_exist").val(0);
							jQuery("form#submit_form #user_fname_error").addClass('message_error2');
							jQuery("form#submit_form #user_fname_error").removeClass('available_tick');
							return false;
						}
					}
				}
			});
		});
	</script>
	<?php
}
/*
 return page to insert user
*/
function tmpl_video_insertuser_with_listing(){
	$current_user_id = include_once(get_template_directory().'/functions/single_page_checkout_insertuser.php');	
        /* set session for check is new user submit post in success page */
        $_SESSION['new_user_register'] = 1;
        return $current_user_id;
}
/* Return User name while submit form as a guest user */
function tmpl_video_get_user_name_plugin($fname,$lname='')
{
	global $wpdb;
	if($lname)
	{
		$uname = $fname.'-'.$lname;
	}else
	{
		$uname = $fname;
	}
	$nicename = strtolower(str_replace(array("'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," "),array('','','','-','','-','-','','','','','','','','','','-','-',''),$uname));
	$nicenamecount = $wpdb->get_var("select count(user_nicename) from $wpdb->users where user_nicename like \"$nicename\"");
	if($nicenamecount=='0')
	{
		return trim($nicename);
	}else
	{
		$lastuid = $wpdb->get_var("select max(ID) from $wpdb->users");
		return $nicename.'-'.$lastuid;
	}
}
/*
 * Include the submit video related script.
 */
add_action('wp_head','video_post_template_head');
function video_post_template_head()
{
	global $current_user,$wpdb,$post,$wp_query,$theme_settings;
	$store_login = '<a href="'.site_url().'/?ptype=login">Click Login</a>';
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php')){
		/*$site_url = icl_get_home_url();*/
		$site_url = get_bloginfo( 'wpurl' )."/wp-admin/admin-ajax.php?lang=".ICL_LANGUAGE_CODE ;
	}else{
		$site_url = get_bloginfo( 'wpurl' )."/wp-admin/admin-ajax.php" ;
	}
	define('USER_AVAILABLE',__('This username is available.','templatic'));
	define('USER_EXISTS',__('The username you entered already exists, please try a different one','templatic'));
	define('EMAIL_CORRECT',__('The email address is correctly entered.','templatic'));
	define('EMAIL_EXISTS',__('Email address already exists, Please enter another email','templatic'));
	define('INCORRECT_USER',__('Incorrect username','templatic'));
	?>
	
	<script  type="text/javascript" async >
		var ajaxUrl = "<?php echo esc_js( $site_url); ?>";
		var user_email_error ="<?php _e(EMAIL_EXISTS,'templatic');?>";
		var user_email_verified="<?php _e(EMAIL_CORRECT,'templatic');?>";
		var user_fname_error="<?php _e(USER_EXISTS,'templatic');?>";
		var user_login_link = '<?php _e(' or ','templatic'); echo $store_login?>';
		var user_fname_verified="<?php _e(USER_AVAILABLE,'templatic');?>";
		var user_name_verified='';
		var user_name_error="<?php _e(INCORRECT_USER,'templatic'); ?>";
                var video_upload_size = "<?php echo isset($theme_settings['fileupload_video']) ? tmpl_mb_return_bytes($theme_settings['fileupload_video']) : tmpl_mb_return_bytes(ini_get('post_max_size'));?>";
                var image_upload_size = "<?php echo isset($theme_options['fileupload_image']) ? tmpl_mb_return_bytes($theme_options['fileupload_image']) : tmpl_mb_return_bytes(ini_get('post_max_size'));?>";
                
    </script>
    <?php
}
$video_upload_size = isset($theme_settings['fileupload_video']) ? tmpl_mb_return_bytes($theme_settings['fileupload_video']) : tmpl_mb_return_bytes(ini_get('post_max_size')); 
$image_upload_size = isset($theme_options['fileupload_image']) ? tmpl_mb_return_bytes($theme_options['fileupload_image']) : tmpl_mb_return_bytes(ini_get('post_max_size'));

/*
	check user name and password while login from submit form.
*/
add_action( 'wp_ajax_nopriv_ajaxlogin', 'tmpl_video_ajax_login' );
function tmpl_video_ajax_login(){
	header('Content-Type: application/json; charset=utf-8');
    /* First check the nonce, if it fails the function will break*/
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    /* Nonce is checked, get the POST data and sign user on*/
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    $package_selected = '';
    $package_type = '';
	$package_id=$_POST['pkg_id'];
	if($package_id!=''){
		$selected_package_type=get_post_meta($package_id,'package_type',true);
		$subscription_as_pay_post=get_post_meta($package_id,'subscription_as_pay_post',true);
		if($subscription_as_pay_post==1){
			$_SESSION['custom_fields']=$_POST;
		}
	}
    $package_selected = get_user_meta($user_signon->data->ID,'package_selected',true);
    $tmpdata = get_option('templatic_settings');
    if(@$package_selected)
    {
		$package_type = get_post_meta($package_selected,'package_type',true);
	}
	$username = ucfirst($user_signon->data->display_name);
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','templatic')));
    } else {
		echo json_encode(array('loggedin'=>true, 'message'=>sprintf(__('Welcome %s, submit your listing details.','templatic'),$username),'package_type'=>$package_type,'selected_package_type'=>$selected_package_type));
    }
    die();
}

if(isset($_REQUEST['page']) && $_REQUEST['page'] == "success")
{
    require_once(get_template_directory().'/functions/success.php');
    exit;
}

/* verification of user name and email on registration page */
add_action('wp_ajax_tmpl_video_ajax_check_user_email','tmpl_video_ajax_check_user_email');
add_action('wp_ajax_nopriv_tmpl_video_ajax_check_user_email','tmpl_video_ajax_check_user_email');

/* verification of user name and email on registration page. Previous code was in - Tevolution\tmplconnector\monetize\templatic-registration\ajax_check_user_email.php */
function tmpl_video_ajax_check_user_email()
{
	require(ABSPATH."wp-load.php");	
	global $wpdb,$current_user;
	if(isset($_REQUEST['user_email']) && $_REQUEST['user_email']!= '' )
	{
		$user_email = $_REQUEST['user_email'];
		$cur_user_email = $current_user->user_email;	
		if($cur_user_email != $user_email){
			$count_email =  email_exists($user_email); /* check email id registered/valid */
		}
		echo $count_email.",email";exit;
	}
	elseif(isset($_REQUEST['user_fname']) && $_REQUEST['user_fname']!= '')
	{
		$user_fname = $_REQUEST['user_fname'];
		$cur_user_login = $current_user->user_login;	
		if($cur_user_login != $user_fname){
			$user = get_user_by('login',$user_fname);
		}
		$count_fname = count($user->ID);
		echo $count_fname.",fname";exit;
	}
}

function tmpl_video_edit_link($post){
    $edit_link = '';
    global $post,$current_user,$wpdb;
    get_currentuserinfo();
    if ($post->post_author == $current_user->ID) {

        $get_submit_page = $wpdb->get_row("SELECT post_id FROM $wpdb->postmeta WHERE $wpdb->postmeta.meta_key = 'is_video_submit_form' and $wpdb->postmeta.meta_value = '1'");
        $post_id = isset($get_submit_page->post_id) ? $get_submit_page->post_id : '';
        if($post_id != ''){
            $post_content = $wpdb->get_row("SELECT post_name FROM $wpdb->posts WHERE $wpdb->posts.ID =". $post_id);
            $edit_link = '<a class="button secondary_btn tiny_btn post-edit-link" href="' . site_url().'/'.$post_content->post_name.'?pid=' . $post->ID. '">' . __('Edit') . '</a>';
        }
    }
    return $edit_link;
}

/* video post publish author notification  only call when admin login*/
if(is_admin()){
    function tmpl_video_post_published_notification( $ID, $post ) {
        global $pagenow,$post;
        $post = !isset($post) ? get_post($ID) : $post; 
        $ppostmeta = get_post_meta($post->ID, 'tl_dummy_content',true);
        if(isset($post) && ($post->post_type == 'videos' || $post->post_type == 'revision') && $post->post_status =='publish' && $ppostmeta != 1 && $pagenow != 'themes.php'){
            $author = $post->post_author; /* Post author ID. */
            $name = get_the_author_meta( 'display_name', $author );
            $email = get_the_author_meta( 'user_email', $author );
            $title = $post->post_title;
            $permalink = get_permalink( $ID );
            $to[] = sprintf( '%s <%s>', $name, $email );
            $subject = sprintf( 'Published Video: %s', $title );
            $message = "<p>Dear $name</p>";
            $message .= "<p>Congratulations, $name Your video '$title' has been published.</p>";
            $message .= "<p>View: <a href='$permalink'>$permalink</a> </p>";
            $message .= '<p>Thank You,<br> ' . get_option('blogname') . '</p>';
            
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            
            $fromEmail = get_option('admin_email');
            $fromEmailName = stripslashes(get_option('blogname'));
            $headers .= 'From: '.$fromEmailName.' <'.$fromEmail.'>' . "\r\n";
            
            wp_mail( $to, $subject, $message, $headers );
        }
    }
    add_action( 'save_post', 'tmpl_video_post_published_notification', 10, 2 );
}

/* post video download link return */
function tmpl_get_post_video_download_link(){
    global $post;
    
    $is_downloadable = get_post_meta($post->ID,'is_downloadable',true);
    $video_upload = get_post_meta($post->ID,'video_upload',true);
    if($is_downloadable == 'on' && $video_upload == 'upload')
    {
        $media = get_attached_media( 'video', $post->ID);
        if(!empty( $media )){
               foreach ( $media as $attachment ) {
                   $link = wp_get_attachment_url( $attachment->ID,'','','', false );	
               }
        }
        
        if($link != '')
        {
            $html = "<li><a href='$link' class='video_download_link button' title='Download this video' download><i class='step fa fa-download'></i></a><li>";
            echo $html;
        }
    }
}

add_action('video_download_link','tmpl_get_post_video_download_link');

function bdw_get_images_plugin($iPostID,$img_size='thumb',$no_images='') 
{
	if(is_admin() && isset($_REQUEST['author']) && $_REQUEST['author']!=''){
		remove_action('pre_get_posts','tevolution_author_post');
	}
   $arrImages = get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . @$iPostID );	
	$counter = 0;
	$return_arr = array();	
 
	if (has_post_thumbnail( $iPostID ) ){
		
		$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $iPostID ), 'thumbnail' );
		$imgarr['id'] = get_post_thumbnail_id( $iPostID );;
		$imgarr['file'] = $img_arr[0];
		$return_arr[] = $imgarr;
		
	}else{
		if($arrImages) 
		{
			
		   foreach($arrImages as $key=>$val)
		   {		  
				$id = $val->ID;
				if($val->post_title!="")
				{
					if($img_size == 'thumb')


					{
						$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); /* Get the thumbnail url for the attachment*/
						$imgarr['id'] = $id;
						$imgarr['file'] = $img_arr[0];
						$return_arr[] = $imgarr;
					}
					else
					{
						$img_arr = wp_get_attachment_image_src($id, $img_size); 
			
						$imgarr['id'] = $id;
						$imgarr['file'] = $img_arr[0];
						$return_arr[] = $imgarr;
					}
				}
				$counter++;
				if($no_images!='' && $counter==$no_images)
				{
					break;	
				}
				
		   }
		}
			
	}  return $return_arr;
}

/**
* To delete current author post
*/
add_action( 'wp_ajax_delete_auth_post', 'delete_auth_post_function' );
add_action( 'wp_ajax_nopriv_delete_auth_post', 'delete_auth_post_function' );
if( !function_exists( 'delete_auth_post_function' ) ){
	function delete_auth_post_function(){
		check_ajax_referer( 'auth-delete-post', 'security' );
		global $current_user;
		get_currentuserinfo();
		$post_authr = get_post( @$_POST['postId'] );
		if( $post_authr->post_author == $current_user->ID ){
			wp_delete_post( $_POST['postId'], true );
			echo $_REQUEST['currUrl'];
		}
		die;
	}
}

// Tiny editor button filter
add_filter('mce_buttons', 'tmpl_mce_buttons');
if(!function_exists('tmpl_mce_buttons')){
    function tmpl_mce_buttons(){
            return array('bold', 'italic', 'strikethrough', 'bullist', 'numlist', 'blockquote', 'hr', 'link', 'unlink');
    }
}
?>