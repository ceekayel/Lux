<?php
/* Templatic video theme options page template */

if (isset($_POST['theme_options_nonce']) && $_POST['theme_options_nonce'] != '') {
    if (wp_verify_nonce(@$_POST['theme_options_nonce'], basename(__FILE__))) {
        
        $theme_options = get_option('video_theme_settings');
        foreach ($_POST as $key => $value) {
            if ($key != "theme_options_nonce" && $key != "Submit") {
                $theme_options[$key] = $value;
            }
        }
        update_option('video_theme_settings', $theme_options);
        wp_safe_redirect(admin_url('themes.php?page=theme-settings-page&updated=1'));
    } else {
        wp_die(__("You do not have permission to edit theme settings.", 'templatic'));
    }
}
/*
  To display theme setting options in appearance -> theme settings
 */
if (!function_exists('theme_settings_page_callback')) {

    function theme_settings_page_callback() {
         global $theme_settings;
         $theme_settings = empty($theme_settings) ? get_option('video_theme_settings'): $theme_settings;
        
        ?>
        <div class="wrap">
            <form name="theme_options_settings" id="theme_options_settings" method="post" enctype="multipart/form-data">
                <input type="hidden" name="theme_options_nonce" value="<?php echo wp_create_nonce(basename(__FILE__)) ?>" />
                <div class="icon32 icon32-posts-post" id="icon-edit"><br>
                </div>
                <h2>
                    <?php echo __("Theme Settings", 'templatic'); ?>
                </h2>  

                <?php if (isset($_REQUEST['updated']) && $_REQUEST['updated'] != '') { ?>
                    <div class="updated" id="message" style="clear:both">
                        <p>
                            <?php echo __("Theme Settings", 'templatic'); ?>
                            <strong>
                                <?php echo __("saved", 'templatic'); ?>
                            </strong>.</p>
                    </div>
                <?php } ?>

                <div class="wp-filter tev-sub-menu" >
                    <ul id="tev_theme_settings" class="filter-links">
                        <li class="general_settings active">
                            <a id="general_settings" href="javascript:void(0);" class="current">
                                <?php echo __("General Settings", 'templatic'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
                <table id="general_settings" class="tmpl-theme_settings form-table active-tab">
                    <tbody>
                        <!-- General Settings -->
                        <tr>
                            <th><label for="supreme_global_layout">
                                    <?php echo __('Default Video Submit Status', 'templatic'); ?>
                                </label></th>
                            <td>
                                <div class="element">
                                    <select style="vertical-align:top;width:200px;" name="video_default_status" id="video_default_status">
                                        <option value="draft" <?php echo ($theme_settings['video_default_status'] == 'draft') ? 'selected' : '' ?>>
                                            <?php echo __("Draft", 'templatic'); ?>
                                        </option>
                                        <option value="publish" <?php echo ($theme_settings['video_default_status'] == 'publish') ? 'selected' : '' ?>>
                                            <?php echo __("Publish", 'templatic'); ?>
                                        </option>                                        
                                    </select>
                                </div>
                                <p class="description">
                                    <?php echo __("Set the default video post status submited from frontend.", 'templatic'); ?>
                                </p>
                            </td>
                        </tr>
                        
                        <tr>
                            <th scope="row"><label for="fileupload_video"><?php _e( 'Max upload Video file size' ) ?></label></th>
                            <td>
                                <div class="element">
                                    <?php printf( _x( '%s MB', 'File size in megabytes' ), '<input name="fileupload_video" type="number" min="1" max="'.rtrim(ini_get('post_max_size'),'M').'" style="width: 100px" id="fileupload_video" aria-describedby="fileupload-video-desc" value="' . $theme_settings['fileupload_video'] . '" />' ); ?>
                                    <p class="screen-reader-text" id="fileupload-maxk-desc">
                                            <?php _e( 'Size in megabytes' ) ?>
                                    </p>
                                </div>
                                <p class="description">
                                    <?php echo __("File size not more than server size: ", 'templatic'). ini_get('post_max_size').'B'; ?>
                                </p>
                            </td>
			</tr>
                        
                        <tr>
                            <th scope="row"><label for="fileupload_image"><?php _e( 'Max upload Image file size' ) ?></label></th>
                            <td>
                                <div class="element">
                                    <?php printf( _x( '%s MB', 'File size in megabytes' ), '<input name="fileupload_image" type="number" min="1" max="'.rtrim(ini_get('post_max_size'),'M').'" style="width: 100px" id="fileupload_image" aria-describedby="fileupload-image-desc" value="' . $theme_settings['fileupload_image'] . '" />' ); ?>
                                    <p class="screen-reader-text" id="fileupload-maxk-desc">
                                            <?php _e( 'Size in megabytes' ) ?>
                                    </p>
                                </div>
                                <p class="description">
                                    <?php echo __("File size not more than server size: ", 'templatic'). ini_get('post_max_size').'B'; ?>
                                </p>
                            </td>
			</tr>
                        
                        <tr>
                            <th><label for="supreme_gogle_analytics_code">
                                    <?php echo __('Google Analytics tracking code', 'templatic'); ?>
                                </label></th>
                            <td><div class="element">
                                    <textarea name="video_google_analytics" id="video_google_analytics" rows="6" cols="60"><?php echo stripslashes($theme_settings['video_google_analytics']); ?></textarea>
                                </div>
                                <p class="description">
                                    <?php echo __("Enter the analytics code you received from GA or some other analytics software. e.g. <a href='https://www.google.co.in/analytics/'>Google Analytics</a>", 'templatic'); ?>
                                </p></td>
                        </tr>
                        
                        <tr>
                            <td colspan="2"><p style="clear: both;" class="submit">
                                    <input type="submit" value="<?php echo __('Save All Settings', 'templatic'); ?>" class="button button-primary button-hero" name="Submit">
                                </p></td>
                        </tr>
                    </tbody>
                </table>

            </form>
        </div>
        <?php
    }
}

/* add script in footer to show hide theme options */
add_action('admin_footer', 'tmpl_themeoptions_script');

function tmpl_themeoptions_script() {
    ?>

    <script type="text/javascript">

        /* Script to add tabs without refresh in tevolution general settings */
        jQuery(document).ready(function () {
            jQuery("#theme_options_settings .tmpl-theme_settings").hide();
            jQuery("#theme_options_settings .active-tab").show();

            jQuery('#tev_theme_settings li a').click(function (e) {
                jQuery("#theme_options_settings .tmpl-theme_settings").hide();
                jQuery("#theme_options_settings .tmpl-theme_settings").removeClass('active-tab');
                jQuery("#tev_theme_settings li a").removeClass('current');

                jQuery(this).parents('li').addClass('active');
                jQuery(this).addClass('current');
                jQuery("#theme_options_settings table#" + this.id).show();
                jQuery("#theme_options_settings table#" + this.id).addClass('tmpl-theme_settings form-table active-tab');
            });
        });
    </script>
    <?php
}
?>