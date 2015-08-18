<?php
ob_start();

/* Localization */

//load_theme_textdomain( 'templatic', get_template_directory() .'/functions/translation' );
if(defined('WPLANG') && WPLANG != '')
        $locale = WPLANG;
else
        $locale = get_locale();
//if ( is_readable($locale_file) ) require_once($locale_file);

if(file_exists(get_template_directory() ."/functions/translation/$locale.mo"))
{
        load_textdomain('templatic', get_template_directory() ."/functions/translation/$locale.mo");
}else
        {
                load_textdomain('templatic', get_template_directory() ."/functions/translation/default.mo");
        }

/* Localization End */

// Thumbnail sizes
/* image size use in popular post widget */
add_image_size( 'listing-post-thumb', 278, 200, true );
add_image_size( 'listing-post-retina-thumb', 556, 400, true );

/* image size use in related post in video detail page */
add_image_size( 'popular-post-thumb', 69, 50, true );
add_image_size( 'popular-post-retina-thumb', 138, 100, true );

/* user image size in video detail page next and previous video */
add_image_size( 'listing-widget-thumb', 82, 58, true );
add_image_size( 'listing-widget-retina-thumb', 164, 116, true );

/* unset image size of large and medium of wordpress default */
update_option('large_size_w',0);
update_option('large_size_h',0);

update_option('medium_size_w',0);
update_option('medium_size_h',0);
/*
You can change the names and dimensions to whatever
you like. 
*/
/* global variable declare */
global $pagenow,$theme_settings,$video_upload_size,$image_upload_size;
$page= @$_REQUEST['page']; 

/* set as global variable value set */
$theme_settings = get_option('video_theme_settings');
$video_upload_size = isset($theme_settings['fileupload_video']) ? tmpl_mb_return_bytes($theme_settings['fileupload_video']) : tmpl_mb_return_bytes(ini_get('post_max_size')); 
$image_upload_size = isset($theme_settings['fileupload_image']) ? tmpl_mb_return_bytes($theme_settings['fileupload_image']) : tmpl_mb_return_bytes(ini_get('post_max_size'));

/* theme activiation hook */
add_action('after_switch_theme', 'tmpl_video_setup_options');

function tmpl_video_setup_options () {
    $theme_options['video_default_status'] = 'draft';
    $theme_options['fileupload_video'] = rtrim(ini_get('post_max_size'),'M');
    $theme_options['fileupload_image'] = rtrim(ini_get('post_max_size'),'M');
    $theme_options['video_google_analytics'] = '';
    update_option('video_theme_settings', $theme_options);
}

/* Code to check the auto updates of theme */
if(is_admin() && ($pagenow =='themes.php' || $pagenow =='post.php' || $pagenow =='edit.php' || trim($page) == trim('templatic_menu'))){
	require_once(get_template_directory().'/functions/tmpl_theme_update.php');	
	new WPUpdates_Video_Updater( 'http://templatic.com/updates/api/', basename(get_template_directory_uri()) );
}
/* Code to check the auto updates of theme */
add_action( 'after_setup_theme', 'tmpl_theme_setup',11 );

/* Set up the theme supported functions */
function tmpl_theme_setup(){
	add_theme_support('breadcrumb-trail'); // add the support for breadcrumbs

	/*	Add Action for Customizer   START	*/
	add_action( 'customize_register',  'templatic_register_customizer_settings');
	/*	Add Action for Customizer   END	*/
	/*	Stylesheet for theme color settings START */
	add_action('wp_head', 'video_load_theme_stylesheet');
	/*	Stylesheet fro theme color settings End */
	require_once(get_template_directory().'/functions/templatic.php'); // if you remove this, Joints will break
	require_once(get_template_directory().'/functions/tmpl_post_type.php'); // you can disable this if you like
	require_once(get_template_directory().'/functions/tmpl_functions.php'); // all theme functions
	require_once(get_template_directory().'/functions/tmpl_widgets.php'); // theme widget file
	require_once(get_template_directory().'/functions/tmpl_breadcrumb-trail.php'); // to show breadcrumb
	require_once(get_template_directory().'/functions/tmpl_customizer.php'); // Add color customizer
        include_once(get_template_directory().'/functions/registration/reg_main.php'); // registration, login and edit profile
        
        /* Set theme specific options */
        add_action( 'admin_init', 'tmpl_set_themesettings' );       
}

/*********************
MENUS & NAVIGATION
*********************/
// registering wp3+ menus
register_nav_menus(
	array(
		'main-nav' => __( 'Primary Menu',"templatic" ),   // main nav
		'footer-links' => __( 'Secondary Menu',"templatic" ) // secondary nav
	)
);

// the main menu
function tmpl_main_nav() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => false,                           // remove nav container
    	'container_class' => '',           // class of container (should you choose to use it)
    	'menu' => __( 'The Main Menu', 'templatic' ),  // nav name
    	'menu_class' => '',         // adding custom nav class
    	'theme_location' => 'main-nav',                 // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
    	'fallback_cb' => 'tmpl_main_nav_fallback'      // fallback function
	));
}

// the footer menu (should you choose to use one)
function tmpl_footer_links() {
	// display the wp3 menu if available
    wp_nav_menu(array(
    	'container' => '',                              // remove nav container
    	'container_class' => 'footer-links clearfix',   // class of container (should you choose to use it)
    	'menu' => __( 'Footer Links', 'templatic' ),   // nav name
    	'menu_class' => 'sub-nav',      // adding custom nav class
    	'theme_location' => 'footer-links',             // where it's located in the theme
    	'before' => '',                                 // before the menu
        'after' => '',                                  // after the menu
        'link_before' => '',                            // before each link
        'link_after' => '',                             // after each link
        'depth' => 0,                                   // limit the depth of the nav
    	'fallback_cb' => 'tmpl_footer_links_fallback'  // fall back function
	));
} /* end joints footer link */
// Theme Specific message for category wise custom fields. END
function video_load_theme_stylesheet(){
	/*	Function to load the custom style sheet. 
	"Theme Color Settings" in back end and 
	save some color then then this file is called	*/
	if(file_exists(get_stylesheet_directory()."/functions/tmpl_admin_style.php")){
		require_once(get_stylesheet_directory().'/functions/tmpl_admin_style.php');
	}
}
// this is the fall back for header menu
function tmpl_main_nav_fallback() {
	wp_page_menu( array(
		'show_home' => true,
    	'menu_class' => 'top-bar top-bar-section',      // adding custom nav class
		'include'     => '',
		'exclude'     => '',
		'echo'        => true,
        'link_before' => '',                            // before each link
        'link_after' => ''                             // after each link
	) );
}

// this is the fall back for footer menu
function tmpl_footer_links_fallback() {
	/* you can put a default here if you like */
}

/*********************
COMMENT LAYOUT
*********************/

if(!function_exists('tmpl_comments')){
function tmpl_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment;

   $default_avatar = ''; ?>
	<li <?php comment_class('panel'); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix large-12 columns">
			<header class="comment-author">
				<?php
				if($args['avatar_size'] !=''){
					
					echo get_avatar($comment,$size=$args['avatar_size'],$default_avatar,$default='<path_to_url>' );
				}
				?>
				<!-- custom gravatar call -->
				<?php
					// create variable
					$bgauthemail = get_comment_author_email();
				?>
				<?php printf(__('<cite class="fn">%s</cite>', 'templatic'), "<a href=".get_author_posts_url($post->post_author).$comment->comment_author.">".get_comment_author_link()."</a>");  ?>
				<time datetime="<?php  echo comment_time('Y-m-j'); ?>"><span class="byline"><?php _e(' on','templatic'); comment_time(__(' F jS, Y - g:ia', 'templatic')); ?> </span></time>
				<?php edit_comment_link(__('(Edit)', 'templatic'),'  ',''); ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
				<div class="alert alert-info">
					<p><?php _e('Your comment is awaiting moderation.', 'templatic') ?></p>
				</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				
				<?php comment_text() ?>
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
			</section>
			
		</article>
	<!-- </li> is added by WordPress automatically -->
<?php
	}
} // don't remove this bracket!


/*
 * Function Name: video_wp_head_script
 * include javascript in header
 */
add_action("wp_head","video_wp_head_script");
function video_wp_head_script(){
?>
<script type="text/javascript">
var theme_url='<?php echo get_template_directory_uri();?>';
var page='<?php echo get_option("posts_per_page");?>';
var First="<?php echo __( 'First', 'templatic' )?>";
var Last="<?php echo __( 'Last', 'templatic' )?>";
</script>
<?php
}

/*
 * Function Name : video_wp_title
 * Description : string The filtered title.
 */
function video_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}
	$sep = '|';
	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_front_page() ) ) {
		$title .= get_bloginfo( 'name' );
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	
	return $title;
}
add_filter( 'wp_title', 'video_wp_title', 10, 2 );
/*
 * Function Name : video_the_attached_image
 * Description : fetch image on gallery detail page.
 */
function video_the_attached_image() {
	$post                = get_post();
	
	$attachment_size     = apply_filters( 'video_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

		printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
/*
 * Name : tmpl_remove_transient
 * Description : delete the transient for category listing.
 * */
add_action('save_post','tmpl_remove_transient');
function tmpl_remove_transient()
{
	delete_transient('taxonomy_most_viewed_query_results');
	delete_transient('texonomy_most_rated_query_results');
	delete_transient('texonomy_latest_query_results');
}
if(!function_exists('customAdmin')){
	function customAdmin() {
		
		/* auto install for theme */
		if(strstr($_SERVER['REQUEST_URI'],'themes.php') || (isset($_REQUEST['page']) && $_REQUEST['page']=='templatic_system_menu') ){
			if(file_exists(get_stylesheet_directory().'/functions/auto_install/auto_install.php')){
				include_once(get_stylesheet_directory().'/functions/auto_install/auto_install.php');
			}elseif(file_exists(get_template_directory()."/functions/auto_install/auto_install.php")){
				include_once(get_template_directory().'/functions/auto_install/auto_install.php');
			}
		}
	}
}
add_action('admin_head', 'customAdmin', 11);
add_action('pre_get_posts','tmpl_pre_get_posts'); // call filter to set order by

/* Apply filter to set order by for video */
function tmpl_pre_get_posts(){
	
	add_filter('posts_orderby', 'tmpl_filter_orderby');
}

/* Filter to apply order by on category and search pages for video*/
function tmpl_filter_orderby($orderby){
	global $wpdb;
	if(is_tax() || is_tag() || is_archive()){
		$orderby='';
		if(isset($_REQUEST['most_rated']) && $_REQUEST['most_rated']=='videos'){	
			$orderby .= " $wpdb->posts.comment_count+0 DESC";
		}elseif(isset($_REQUEST['most_viewed']) && $_REQUEST['most_viewed'] == 'videos'){
			/* fetch most viewed post */
			$orderby .= " (select $wpdb->postmeta.meta_value from $wpdb->postmeta where $wpdb->postmeta.post_id=$wpdb->posts.ID and $wpdb->postmeta.meta_key = 'post_views_count')+0 DESC";	
		}else
		{	/* fetch latest post */
			$orderby .= " $wpdb->posts.post_date DESC";		
		}
	}
	return $orderby;
}

/* function for adding meta tags for facebook */
add_action('wp_head','tmpl_video_fb_metatags');
function tmpl_video_fb_metatags(){
	
	if(is_single()){
		global $post;
		
		/* if post has thumbnai then add meta tag for image */
		if ( has_post_thumbnail() ) {
			$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),'full');
			?>
			<meta property="og:image" content="<?php echo $large_image_url[0] ?>" />
			<?php
			
		}
		?>
		<meta property="og:title" content="<?php echo $post->post_title; ?>" />
		<meta property="og:url" content="<?php echo $post->guid; ?>" />
		<meta property="og:description" content="<?php echo strip_tags($post->post_content); ?>" />
		
		<?php
	}
}

add_filter('excerpt_more', 'new_excerpt_more',99);
function new_excerpt_more($more){
	global $post;
	return ' <a href="'. get_permalink($post->ID) . '">  ...'.__('Read more','templatic').' &raquo; </a>'; //you can change this text to whatever you like
}

/* added files for video front end submition register with shortcode
 * 
 * Short code of video submition is "[submit_video_form]"
 *   */
add_action('init','video_post_init_function');
function video_post_init_function(){
	/*Submit form page shortcode*/
        require_once(get_template_directory().'/functions/video_posts.php'); // add video post functionality
	require_once(get_template_directory().'/functions/post_videos_functions.php');
        add_shortcode('submit_video_form', 'submit_video_form');
       
}

/*
	get the login page URL
*/
function get_tevolution_login_permalink(){
	
	$login_page_id = get_option('tevolution_login');
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php') && function_exists('icl_object_id')){
		$login_page_id = icl_object_id( $login_page_id, 'page', false, ICL_LANGUAGE_CODE );
	 }
	return get_permalink($login_page_id);
}

/*
	get the registration page uRL
*/
function get_tevolution_register_permalink(){
	
	$register_page_id=get_option('tevolution_register');
	if(is_plugin_active('sitepress-multilingual-cms/sitepress.php') && function_exists('icl_object_id')){									
		$register_page_id = icl_object_id( $register_page_id, 'page', false, ICL_LANGUAGE_CODE );
	 }
	 if($register_page_id !='')
		return get_permalink($register_page_id);
}

/* this function user for set the author page post type listing */
function tmpl_set_author_post_tyep( &$query )
{
    if ( $query->is_author ){
        if(!is_admin()){
            if(is_author()){
                global $current_user;
                $author = get_user_by( 'slug', get_query_var( 'author_name' ) );

                /* Don't pass $post_type as in array() */
                $query->set('post_type','videos');
                /* ferch all post for same user */
                if($author->ID == $current_user->ID){
                        $query->set('post_status', array('publish','draft','private'));
                }else{
                        $query->set('post_status', array('publish'));
                }
            }
        }
    }
    remove_action( 'pre_get_posts', 'tmpl_set_author_post_tyep' ); // run once!
}
add_action( 'pre_get_posts', 'tmpl_set_author_post_tyep' );

/*
 *  User edit profile short code and fucntion
 *  Short code of edit profile page is [tevolution_profile]
 */
add_shortcode('tevolution_profile', 'tevolution_user_profile');

function tevolution_user_profile($atts)
{
	ob_start();
	if(!is_user_logged_in()): /* user not login*/
		/* user not logeed in then redirect login page	*/
		wp_redirect(site_url().'/?ptype=login');
		exit;
	else: 
            /* include user profile file for edit */
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script('media_upload_scripts', get_template_directory_uri().'/library/js/media_upload_scripts.js', array('jquery'));
            wp_enqueue_script('drag_drop_media_upload_scripts', get_template_directory_uri().'/library/js/jquery.uploadfile.js', array('jquery'),false);
            include(get_template_directory().'/functions/user_profile.php');
	
	endif;
	
	return ob_get_clean();
}

/* add page template filter for page routing */
add_filter('template_include','templ_template_include');
function templ_template_include($file)
{
    /* route page for login and registration */
    return apply_filters('templ_add_template_page_filter',$file);
}

/* site general mail function to send emails */
function templ_sendEmail($fromEmail,$fromEmailName,$toEmail,$toEmailName,$subject,$message,$extra='')
{
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	
	// Additional headers
	$headers .= 'To: '.$toEmailName.' <'.$toEmail.'>' . "\r\n";
	
	$subject = apply_filters('templ_send_email_subject', $subject);
	$message = apply_filters('templ_send_email_content', $message);
	$headers = apply_filters('templ_send_email_headers', $headers);

        wp_mail($toEmail, $subject, $message, $headers);	
}

/*
 * [header-right-menu login='1' register='1' author_link='1' submit_video='1']
 * login is alter native for logout
 * register is only enable if admin allow Any one can register in back end setting
 * Add 1 or 0
 *  */
add_filter('widget_text', 'do_shortcode');
add_shortcode( 'header-right-menu', 'tmpl_header_right_menu' );
function tmpl_header_right_menu( $atts ) {
        global $current_user,$wpdb;
        $login = (isset($atts['login']) && !empty($atts['login'])) ? $atts['login'] : '1';
        $register = (isset($atts['register']) && !empty($atts['register'])) ? $atts['register'] : '1';
        $author_link = (isset($atts['author_link']) && !empty($atts['author_link'])) ? $atts['author_link'] : '1';
        $submit_video = (isset($atts['submit_video']) && !empty($atts['submit_video'])) ? $atts['submit_video'] : '1';
        /*Primary Menu location */
        /* Check the condition for theme menu location prompt, footer and secondary */
        echo '<div class="menu"><ul class="primary_menu clearfix" id="menu-primary-items">';

        /* login/logour links */
        if($login == 1){
            if($current_user->ID){
                echo '<li class="tmpl-login' . ((is_home())? ' ' : '') . '"><a href="' .wp_logout_url(home_url()). '">' . __('Log out','templatic') . '</a></li>';
            }else{
                echo '<li class="tmpl-login' . (($_REQUEST['ptype']=='login')? ' current_page_item' : '') . '" >  <a href="'.site_url().'/?ptype=login" title='. __('Login','templatic') .'>' . __('Login','templatic') . '</a></li>';
            }
        }
        
        /* author link */
        if($current_user->ID && $author_link==1){
            echo '<li class="tmpl-login' . ((is_author())? ' current-menu-item ' : '') . '"><a href="' . get_author_posts_url($current_user->ID) . '">' . $current_user->display_name . '</a></li>';
        }else{
            $users_can_register = get_option('users_can_register');
            if($register == 1 && $users_can_register==1){
                echo '';
            }
        }
	
        /* submit video link */
        if($submit_video ==1){
            $page_id = $wpdb->get_var("SELECT ID FROM `$wpdb->posts` WHERE `post_content` LIKE '%[submit_video_form%' LIMIT 0 , 1");
            if($page_id != ''){
                $submit_video_url = get_permalink($page_id);
            }
            
            if($submit_video_url != '')
                echo "<li class='listing-btn'><a href='$submit_video_url'>". __('Add Video','templatic'). "</a></li>";
        }
        echo '</ul></div>';  
        
}

function tmpl_set_themesettings(){
    global $pagenow;
	/*change auto install text*/
	if($pagenow == 'themes.php')
	{
		add_action('admin_footer','auto_install_text');
	}
        remove_meta_box( 'postcustom', 'videos', 'normal' );
}

/*change auto install text*/
function auto_install_text(){
?>
    <script>
        jQuery('.tmpl-auto-install-yb a.button-primary').click(function(){
			/* if button is disabled then do not allow to click again */
			if(jQuery(this).is('[disabled=disabled]')){
				return false;
			}	
                if(jQuery(this).parent().find('.delete-data-button').length <= 0 )
                { 
                        jQuery('span a.button-primary').html('Installing Sample Data...');
                        jQuery('.tmpl-auto-install-yb span').html('<span style="color:green;margin-left: 10px;"><br/>This <strong>could take up to 5-10 minutes</strong>. Sit back and relax while we install the sample data for you. Please do not close this window until it completes.</span>');
                        /* disable button during auto install is runing */
                        jQuery(this).attr("disabled","disabled");
                }else{
                        jQuery('span a.button-primary').html('Deleting Sample Data...');
                        jQuery('.tmpl-auto-install-yb span').html('<span style="color:green;margin-left: 10px;"><br/>This <strong>could take up to 5-10 minutes</strong>. Sit back and relax while we deleting the sample data for you. Please do not close this window until it completes.</span>');
                        /* disable button during auto install is runing */
                        jQuery(this).attr("disabled","disabled");
                }
        });
        jQuery(document).ready(function(){
            <?php if(isset($_REQUEST['x']) && $_REQUEST['x'] == 'y'){ ?>
               jQuery('.tmpl-auto-install-yb span').append('<span style="color:green;margin-left: 10px;">All done. Your site is ready with sample data now. <a href="<?php echo site_url(); ?>">Visit your site</a>.</span>');
            <?php } ?>
        });
    </script>
<?php
}



/*
	check if woo commerce is active or not 
*/
if(!function_exists('check_if_woocommerce_active')){
	function check_if_woocommerce_active(){
		$plugins = wp_get_active_and_valid_plugins();
		$flag ='';
		foreach($plugins as $plugins){
			if (strpos($plugins,'woocommerce.php') !== false) {
				$flag = 'true';
				break;
			}else{
				 $flag = 'false';
			}
		}
		return $flag;
	}
}
/* add theme support of woo-commerce */
if(function_exists('check_if_woocommerce_active')){
	$is_woo_active = check_if_woocommerce_active();
	if($is_woo_active == 'true'){
		add_theme_support( 'woocommerce' );
	}
}

/* convert mb to bytes */
/* val variable support 512M and 512 both*/
function tmpl_mb_return_bytes($val) {
    $val = trim($val);
    $last = is_numeric($val) ? 'm' : strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
?>
