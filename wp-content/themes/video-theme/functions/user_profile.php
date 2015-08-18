<?php
/*
 * edit profile form and save function
 */
global $current_user, $wpdb;
if (isset($_POST['action']) && $_POST['action'] == 'user_profile') {
    $user_id = $current_user->ID;
    if ($user_id == $_POST['user_id']) {
        $user_email = $_POST['user_email'];
        $userName = $_POST['user_fname'];
        
        $user_data = array('ID' => $user_id,
            'user_email' => $_POST['user_email'],
            'display_name' => $_POST['display_name'],
            'user_url' => $_POST['user_url'],
        );
        wp_update_user($user_data);
  
        update_user_meta($user_id, 'description', trim($_REQUEST['description']));
        update_user_meta($user_id, 'profile_photo', trim($_REQUEST['profile_photo']));
        echo '<p class="success_msg"> ' . __('Hi ', 'templatic') . ' <a href="' . get_author_posts_url($user_id) . '">' . $userName . '</a>, ' . __('Your profile is updated successfully.', 'templatic') . ' </p>';
    }else{
        wp_redirect(site_url());
    }
}
if (isset($_POST['action']) && $_POST['action'] == 'changepwd') {
    $user_id = $current_user->ID;
    if ($_POST['new_passwd'] == $_POST['cnew_passwd']) {
        $user_data = array('ID' => $user_id, 'user_pass' => $_POST['new_passwd'],);
        wp_update_user($user_data);

        echo '<p class="success_msg"> ' . __('Password changed successfully. Please login with your new password.', 'templatic') . ' </p>';
        $_SESSION['update_password'] = '1';
        wp_logout();
        wp_redirect(site_url());
    } else {
        echo '<p class="error_msg"> ' . __(PW_NO_MATCH_MSG, 'templatic') . ' </p>';
    }
}
global $submit_form_validation_id;
$submit_form_validation_id = "userform";
remove_filter('the_content', 'wpautop', 12);
global $theme_settings;
$theme_settings = empty($theme_settings) ? get_option('video_theme_settings'): $theme_settings;
?>

<div class="reg_cont_right">
    <!--user profile form -->
        <?php
        $update_user_info = get_userdata($current_user->ID);
        if ($_POST) {
            $user_email = $_POST['user_email'];
            $user_fname = $_POST['user_fname'];
        } else {
            $user_email = $update_user_info->user_email;
            $user_fname = $update_user_info->display_name;
        }        
        ?>
        
            <section class="entry-content">
                <div class="reg_cont_right">
                    <!--user profile form -->
                <form name="userform" id="userform" action="<?php echo get_permalink(); ?>" method="post" enctype="multipart/form-data" >  
                    <input type="hidden" name="action" value="user_profile" />
                    <input type="hidden" name="user_id" value="<?php echo get_current_user_id(); ?>" />
                    <input type="hidden" name="user_email_already_exist" id="user_email_already_exist" value="1" />
                    <input type="hidden" name="user_fname_already_exist" id="user_fname_already_exist" value="1" />
                    
                    <div class="form_row clearfix"><label><?php echo __('Email','templatic'); ?> <span class="indicates">*</span> </label><input type="text" value="<?php echo $user_email;?>" class="textfield" size="25" id="user_email" name="user_email"><span id="user_email_error"></span><span class="message_note"></span></div>
                    <div class="form_row clearfix"><label><?php echo __('Username','templatic'); ?> <span class="indicates">*</span> </label><input type="text" value="<?php echo $current_user->user_login; ?>" style="background-color:#EEEEEE" class="textfield" size="25" id="user_fname" name="user_fname" readonly="readonly"><span id="user_fname_error"></span><span class="message_note"></span></div>
                    <div class="form_row clearfix"><label><?php echo __('Display Name','templatic'); ?></label><input type="text" value="<?php echo $update_user_info->display_name; ?>" class="textfield" size="25" id="display_name" name="display_name"><span class="message_note"></span></div>
                    <div class="form_row clearfix"><label><?php echo __('Website','templatic'); ?> </label><input type="text" value="<?php echo $update_user_info->user_url; ?>" class="textfield" size="25" id="user_url" name="user_url"><span class="message_note"></span></div>
                    <div class="form_row clearfix"><label for="description"><?php echo __('Biographical Info', 'templatic');?></label>
                        <textarea cols="30" rows="5" id="description" name="description"><?php echo $update_user_info->description; ?></textarea>
                        <p class="description"><?php echo __('Share a little biographical information to fill out your profile. This may be shown publicly.', 'templatic');?></p>
                    </div>
                    <?php $name = 'profile_photo'; ?>
                    <div id="div_upload_image">
                        <div class="upload_box">
                            <div class="hide_drag_option_ie">
                                <p><?php echo __('You can drag & drop images from your computer to this box.','templatic'); ?></p>
                                <p><?php echo __('OR','templatic'); ?></p>
                            </div>
                            <?php
                            echo '<div class="tmpl_single_uploader">';
                                
                                $wp_upload_dir = wp_upload_dir();?>

                                <!-- Save the uploaded image path in hidden fields -->
                                <input type="hidden" value="<?php echo $update_user_info->profile_photo; ?>" name="<?php echo $name; ?>" id="<?php echo $name; ?>" class="fileupload uploadfilebutton"  placeholder="<?php echo $name; ?>"/>
                                <div id="<?php echo $name; ?>"></div>

                                <div id="fancy-contact-form">
                                    <div class="dz-default dz-message" ><span  id="fancy-<?php echo $name; ?>"><span><i class="fa fa-folder"></i>  <?php _e('Upload File','templatic'); ?></span></span></div>
                                    <p class="max-upload-size">
                                        <?php echo __( 'Maximum upload file size: ','templatic') . $theme_settings['fileupload_image'] . __('MB','templatic'); ?>
                                    </p>
                                    <?php
                                    /* check the format of uploaded file ( is image ??)*/
                                        if($update_user_info->profile_photo != '')
                                        {
                                            $image = $update_user_info->profile_photo;                                            
                                        }else{
                                            $image = '';
                                        }
                                            
                                        $upload_file=strtolower(substr(strrchr($image,'.'),1));
                                        if($upload_file =='jpg' || $upload_file =='jpeg' || $upload_file =='gif' || $upload_file =='png' || $upload_file =='jpg' ){
                                        ?>
                                                <p id="image-<?php echo $name; ?>" class="resumback"><img height="60px" width="60px" src="<?php echo $image; ?>" /><span class="ajax-file-upload-red" onclick="single_delete_image('<?php echo basename($image);?>','<?php echo $name;?>')"><?php _e('Delete','templatic-admin'); ?></span></p>
                                        <?php }elseif($upload_file != ''){ ?>
                                                <p id="image-<?php echo $name; ?>" class="resumback"><a href="<?php echo get_post_meta($update_user_info->ID,$name, $single = true); ?>"><?php echo basename($image); ?></a><span class="ajax-file-upload-red" onclick="single_delete_image('<?php echo basename($image);?>','<?php echo $name;?>')"><?php _e('Delete','templatic-admin'); ?></span></p>
                                        <?php }else{ ?>
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
                                        <?php 
                                        
                                        echo '</div>';
                                        ?>        
				</div>
                        </div>          

                    <input type="submit" class="b_registernow btn_update_profile update-btn" value="Update" name="update">               
                    <input type="button" onclick="window.location.href = 'http://localhost/directory/author/admin/'" class="b_registernow cancel-btn" value="Cancel" name="Cancel">          
                </form>
                <!--end user profile form -->
               
                <!--Change password form -->
                <form method="post" action="<?php echo get_permalink(); ?>" id="chngpwdform" name="chngpwdform">
                    <input type="hidden" value="changepwd" name="action">
                    <input type="hidden" value="1" name="user_id">
                    <h3><?php echo __('Change password', 'templatic');?> </h3>
                    <div class="form_row clearfix">
                        <label><?php echo __('New Password', 'templatic');?> <span class="indicates">*</span></label>   
                        <input type="password" class="textfield" id="new_passwd" name="new_passwd">
                    </div>
                    <div class="form_row clearfix ">
                        <label><?php echo __('Confirm New Password', 'templatic');?> <span class="indicates">*</span></label>
                        <input type="password" class="textfield" id="cnew_passwd" name="cnew_passwd">
                    </div>
                    <input type="submit" name="update" value="<?php _e("Update", 'templatic'); ?>" class="b_registernow btn_update_profile update-btn" onclick="return chk_form_pw();"/>               
                    <input type="button" name="Cancel" value="<?php _e("Cancel", 'templatic'); ?>" class="b_registernow cancel-btn" onclick="window.location.href = '<?php echo get_author_posts_url($current_user->ID); ?>'"/>
                </form>
                <!-- end change password form -->
            </div>   
            <script async="" type="text/javascript">
            /* &lt;![CDATA[ */
                    function chk_form_pw()
                    {
                    if (document.getElementById('new_passwd').value == '')
                    {
                    alert("Please enter New Password");
                            document.getElementById('new_passwd').focus();
                            return false;
                    }
                    if (document.getElementById('new_passwd').value.length > 4)
                    {
                    alert("Please enter New Password minimum 5 chars");
                            document.getElementById('new_passwd').focus();
                            return false;
                    }
                    if (document.getElementById('cnew_passwd').value == '')
                    {
                    alert("Please enter Confirm New Password");
                            document.getElementById('cnew_passwd').focus();
                            return false;
                    }
                    if (document.getElementById('cnew_passwd').value.length > 4)
                    {
                    alert("Please enter Confirm New Password minimum 4 chars");
                            document.getElementById('cnew_passwd').focus();
                            return false;
                    }
                    if (document.getElementById('new_passwd').value != document.getElementById('cnew_passwd').value)
                    {
                    alert("New Password and Confirm New Password should be same");
                            document.getElementById('cnew_passwd').focus();
                            return false;
                    }
                    }
            /* ]]&amp;gt; */
            </script>
            <script async="" type="text/javascript">
                /*
                 * registration valdiation
                 */
                jQuery.noConflict();
                        jQuery(document).ready(function()
                {
                var userform_userform = jQuery("#userform");
                        var user_email = jQuery("#userform #user_email");
                        var user_email_error = jQuery("#userform #user_email_error");
                        function validate_userform_user_email()
                        {if (jQuery("#userform #user_email").val() == "" && jQuery("#userform #user_email").length > 0)

                        {
                        user_email.addClass("error");
                                user_email_error.text("Please Enter Email");
                                user_email_error.removeClass("available_tick");
                                user_email_error.addClass("message_error2");
                                return false;
                        }
                        else{
                        if (jQuery("#userform #user_email_already_exist").val() != 1 && jQuery.trim(jQuery("#userform #user_email").val()) != "")
                        {
                        var a = jQuery("#userform #user_email").val();
                                var emailReg = /^(([^&lt;&gt;()[\]\.,;:\s@\"]+(\.[^&lt;&gt;()[\]\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                                if (jQuery("#userform #user_email").val() == "") { user_email.addClass("error");
                                user_email_error.text("Please provide your email address");
                                user_email_error.addClass("message_error2");
                                return false; } else if (!emailReg.test(jQuery("#userform #user_email").val().replace(/\s+$/, ""))) { user_email.addClass("error");
                                user_email_error.text("Please enter a valid email address");
                                /*check available_tick exist or not*/
                                if (user_email_error.hasClass("available_tick"))
                        {
                        user_email_error.removeClass("available_tick");
                        }
                        user_email_error.addClass("message_error2");
                                return false;
                        } else {
                        chkemail("userform");
                                var chk_email = jQuery("#userform #user_email_already_exist").val();
                                if (chk_email > 0)
                        {
                        user_email.removeClass("error");
                                user_email_error.text("");
                                user_email_error.removeClass("message_error2");
                                return true;
                        }
                        else{
                        return false;
                        }
                        }
                        }
                        {
                        user_email.removeClass("error");
                                user_email_error.text("");
                                user_email_error.removeClass("message_error2");
                                return true;
                        }
                        }
                        }
                user_email.blur(validate_userform_user_email); user_email.keyup(validate_userform_user_email);
                        var user_fname = jQuery("#userform #user_fname");
                        var user_fname_error = jQuery("#userform #user_fname_error");
                        function validate_userform_user_fname()
                        {if (jQuery("#userform #user_fname").val() == "" && jQuery("#userform #user_fname").length > 0)

                        {
                        user_fname.addClass("error");
                                user_fname_error.text("Please Enter Username");
                                user_fname_error.removeClass("available_tick");
                                user_fname_error.addClass("message_error2");
                                return false;
                        }
                        else{
                        if (jQuery("#userform #user_fname").length && jQuery("#userform #user_fname").val().match(/\ /)){ user_fname.addClass("error");
                                user_fname_error.text("Usernames should not contain space.");
                                user_fname_error.addClass("message_error2");
                                return false;
                        }
                        if (jQuery("#userform #user_fname_already_exist").val() != 1 && jQuery.trim(jQuery("#userform #user_fname").val()) != "")
                        {
                        var a = jQuery("#userform #user_fname").val();
                                var userLength = jQuery("#userform #user_fname").val().length;
                                if (jQuery("#userform #user_fname").val() == "") { user_fname.addClass("error");
                                user_fname_error.text("Please Enter Username");
                                user_fname_error.addClass("message_error2");
                        } else if (userLength > 4){ user_fname.addClass("error");
                                user_fname_error.text("The username must be at least 4 characters long");
                                user_fname_error.addClass("message_error2");
                                return false;
                        } else
                        {
                        chkname("userform");
                                var chk_fname = jQuery("#userform #user_fname_already_exist").val();
                                if (chk_fname > 0)
                        {
                        user_fname.removeClass("error");
                                user_fname_error.text("");
                                user_fname_error.removeClass("message_error2");
                                return true;
                        }
                        else{
                        return false;
                        }
                        }
                        }{
                        user_fname.removeClass("error");
                                user_fname_error.text("");
                                user_fname_error.removeClass("message_error2");
                                return true;
                        }
                        }
                        }
                user_fname.blur(validate_userform_user_fname); user_fname.keyup(validate_userform_user_fname); var pwd = jQuery("#pwd");
                        var pwd_error = jQuery("#pwdInfo");
                        function validate_pwd()
                        {
                        if (jQuery("#pwd").val() == "")

                        {
                        pwd.addClass("error");
                                pwd_error.text("Please enter password");
                                pwd_error.addClass("message_error2");
                                return false;
                        }
                        else{
                        pwd.removeClass("error");
                                pwd_error.text("");
                                pwd_error.removeClass("message_error2");
                                return true;
                        }
                        }
                pwd.blur(validate_pwd);
                        pwd.keyup(validate_pwd);
                        var cpwd = jQuery("#cpwd");
                        var cpwd_error = jQuery("#cpwdInfo");
                        function validate_cpwd()
                        {
                        if (jQuery("#cpwd").val() == "")

                        {
                        cpwd.addClass("error");
                                cpwd_error.text("Please enter confirm password");
                                cpwd_error.addClass("message_error2");
                                return false;
                        } else if (jQuery("#cpwd").val() != jQuery("#pwd").val()) {
                        cpwd.addClass("error");
                                cpwd_error.text("Please confirm your password");
                                cpwd_error.addClass("message_error2");
                                return false;
                        }
                        else{
                        cpwd.removeClass("error");
                                cpwd_error.text("");
                                cpwd_error.removeClass("message_error2");
                                return true;
                        }
                        }
                cpwd.blur(validate_cpwd);
                        cpwd.keyup(validate_cpwd);
                        userform_userform.submit(function()
                        {
                        if (typeof social_login !== "undefined" && social_login == 1){
                        return true;
                        }
                        if (validate_userform_user_email() & validate_userform_user_fname() & validate_pwd() & validate_cpwd())
                        {
                        return true
                        }
                        else
                        {
                        return false;
                        }
                        });
                });
            </script>

        </section>
        
    <!--end user profile form -->
</div>   
<script  type="text/javascript" async >
    /* <![CDATA[ */
            function chk_form_pw()
            {
            if (document.getElementById('new_passwd').value == '')
            {
            alert("<?php _e('Please enter New Password', 'templatic') ?>");
                    document.getElementById('new_passwd').focus();
                    return false;
            }
            if (document.getElementById('new_passwd').value.length < 4)
            {
            alert("<?php _e('Please enter New Password minimum 5 chars', 'templatic') ?>");
                    document.getElementById('new_passwd').focus();
                    return false;
            }
            if (document.getElementById('cnew_passwd').value == '')
            {
            alert("<?php _e('Please enter Confirm New Password', 'templatic') ?>");
                    document.getElementById('cnew_passwd').focus();
                    return false;
            }
            if (document.getElementById('cnew_passwd').value.length < 4)
            {
            alert("<?php _e('Please enter Confirm New Password minimum 5 chars', 'templatic') ?>");
                    document.getElementById('cnew_passwd').focus();
                    return false;
            }
            if (document.getElementById('new_passwd').value != document.getElementById('cnew_passwd').value)
            {
            alert("<?php _e('New Password and Confirm New Password should be same', 'templatic') ?>");
                    document.getElementById('cnew_passwd').focus();
                    return false;
            }
            }
    /* ]]> */
</script>
<?php
//include_once(TT_REGISTRATION_FOLDER_PATH . 'registration_validation.php');
include_once(get_template_directory().'/functions/registration_validation.php');
?>