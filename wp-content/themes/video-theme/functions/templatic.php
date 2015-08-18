<?php
/* 
This is the core theme file where most of the
main functions & features reside. If you have
any custom functions, it's best to put them
in the functions.php file.

*/


// we're firing all out initial functions at the start
add_action('after_setup_theme','tmpl_theme_start', 16);

function tmpl_theme_start() {

    // launching operation clean up
    add_action('init', 'tmpl_head_cleanup');
    // remove WP version from RSS
    add_filter('the_generator', 'tmpl_rss_version');
    // remove pesky injected css for recent comments widget
    add_filter( 'wp_head', 'tmpl_remove_wp_widget_recent_comments_style', 1 );
    // clean up comment styles in the head
    add_action('wp_head', 'tmpl_remove_recent_comments_style', 1);
    // clean up gallery output in wp
    add_filter('gallery_style', 'tmpl_gallery_style');

    // enqueue base scripts and styles
    add_action('wp_enqueue_scripts', 'tmpl_scripts_and_styles', 999);
    // ie conditional wrapper

    // launching this stuff after theme setup
    tmpl_theme_support();

    // adding the search form (created in functions.php)
    add_filter( 'get_search_form', 'tmpl_wpsearch' );

    // cleaning up random code around images
    add_filter('the_content', 'tmpl_filter_ptags_on_images');
    // cleaning up excerpt
	if(!is_single() && !is_page())
		add_filter('excerpt_more', 'tmpl_excerpt_more');

}

/*********************
WP_HEAD GOODNESS
The default wordpress head is a mess. 
Let's clean it up by removing all the junk we don't need.
*********************/

function tmpl_head_cleanup() {
	// category feeds
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// post and comment feeds
	// remove_action( 'wp_head', 'feed_links', 2 );
	// EditURI link
	remove_action( 'wp_head', 'rsd_link' );
	// windows live writer
	remove_action( 'wp_head', 'wlwmanifest_link' );
	// index link
	remove_action( 'wp_head', 'index_rel_link' );
	// previous link
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	// start link
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	// links for adjacent posts
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	// WP version
	remove_action( 'wp_head', 'wp_generator' );
  // remove WP version from css
  add_filter( 'style_loader_src', 'tmpl_remove_wp_ver_css_js', 9999 );
  // remove Wp version from scripts
  add_filter( 'script_loader_src', 'tmpl_remove_wp_ver_css_js', 9999 );

} 

// remove WP version from RSS
function tmpl_rss_version() { return ''; }

// remove WP version from scripts
function tmpl_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}

// remove injected CSS for recent comments widget
function tmpl_remove_wp_widget_recent_comments_style() {
   if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
      remove_filter('wp_head', 'wp_widget_recent_comments_style' );
   }
}

// remove injected CSS from recent comments widget
function tmpl_remove_recent_comments_style() {
  global $wp_widget_factory;
  if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
    remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
  }
}

// remove injected CSS from gallery
function tmpl_gallery_style($css) {
  return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
}


/*********************
SCRIPTS & ENQUEUEING
*********************/

// loading modernizr and jquery, and reply script
function tmpl_scripts_and_styles() {
  global $wp_styles,$wpdb,$wp_query,$post; // call global $wp_styles variable to add conditional wrapper around ie stylesheet the WordPress way  
  if (!is_admin()) {

  	// jquery 

    wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/library/js/jquery.js', array(), '2.1.1', false );
    
    // modernizr (without media query polyfill)
    wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/library/js/modernizr.js', array(), '2.8.2', false );
    
    // adding Foundation scripts file in the footer
    wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/library/js/foundation.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'foundation-orbit-js', get_template_directory_uri() . '/library/js/foundation.orbit.js', array( 'jquery' ), '', true );

    // adding Foundation Interchange scripts file in the footer
    wp_enqueue_script( 'foundation-interchange-js', get_template_directory_uri() . '/library/js/foundation.interchange.js', array(), '', true );
	
	 // adding Foundation scripts file in the footer
    wp_enqueue_script( 'fastclick-js', get_template_directory_uri() . '/library/js/fastclick.js', array(  ), '', true );

    // register main stylesheet
    wp_enqueue_style( 'tmpl-stylesheet', get_template_directory_uri() . '/library/css/style.css', array(), '', 'all' );
   	wp_enqueue_style( 'tmpl-admin-style', get_template_directory_uri() . '/functions/theme_options.css', array(), '', 'all' );   
    
   
    // comment reply script for threaded comments
    if ( is_singular() && is_single()) {
      wp_enqueue_script( 'comment-reply' );
    }

    //adding scripts file in the footer
    wp_enqueue_script( 'tmpl-js', get_template_directory_uri() . '/library/js/scripts.js', array( 'jquery' ), '', true );
    if((is_archive() &&  get_post_type()==CUSTOM_POST_TYPE) || (is_tax() && (get_query_var('videoscategory')!='' || get_query_var('videostags')!='')) || is_search()){
		wp_enqueue_script( 'templatic-script', get_template_directory_uri() . '/library/js/jquery_coockies.js', array( 'jquery' ), '', true );
	}

    // enqueue styles and scripts    
    wp_enqueue_style( 'tmpl-stylesheet' );
    wp_enqueue_style( 'tmpl-admin-style' );
    wp_enqueue_style( 'parent-theme-rtl' );

    $wp_styles->add_data( 'tmpl-ie-only', 'conditional', 'lt IE 9' ); // add conditional wrapper around ie stylesheet
    
    /* this script for post submit front end */      
    if(get_post_meta($post->ID,'is_video_submit_form',true) == 1){
        wp_enqueue_script( 'theme-submit-script', get_template_directory_uri() . '/library/js/video.js', array(), '1.0.0', true ); 
        wp_enqueue_script( 'jquery-ui-sortable' );
        wp_enqueue_script('media_upload_scripts', get_template_directory_uri().'/library/js/media_upload_scripts.js', array('jquery'));
        wp_enqueue_script('drag_drop_media_upload_scripts', get_template_directory_uri().'/library/js/jquery.uploadfile.js', array('jquery'),false);
    }
  }
}

    
//Replace jQuery with Google CDN jQuery
if (!is_admin()) add_action("wp_enqueue_scripts", "my_jquery_enqueue", 11);
function my_jquery_enqueue() {
   wp_deregister_script('jquery');
   wp_register_script('jquery', "http" . ($_SERVER['SERVER_PORT'] == 443 ? "s" : "") . "://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js", false, null);
   wp_enqueue_script('jquery');
}

/*********************
THEME SUPPORT
*********************/

// Adding WP 3+ Functions & Theme Support
function tmpl_theme_support() {

	// wp thumbnails (sizes handled in functions.php)
	add_theme_support('post-thumbnails');

	// default thumb size
	set_post_thumbnail_size(125, 125, true);

	// rss 
	add_theme_support('automatic-feed-links');

	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/

	// adding post format support
	add_theme_support( 'post-formats',
		array(
			'aside',             // title less blurb
			'gallery',           // gallery of images
			'link',              // quick link to other site
			'image',             // an image
			'quote',             // a quick quote
			'status',            // a Facebook like status update
			'video',             // video
			'audio',             // audio
			'chat'               // chat transcript
		)
	);

	// wp menus
	add_theme_support( 'menus' );

}

/*********************
RELATED POSTS FUNCTION
*********************/

/*********************
PAGE NAVI
*********************/

// Numeric Page Navi (built into the theme by default)
function tmpl_page_navi($before = '', $after = '') {
	global $wpdb, $wp_query;
	$request = $wp_query->request;
	$posts_per_page = intval(get_query_var('posts_per_page'));
	$paged = intval(get_query_var('paged'));
	$numposts = $wp_query->found_posts;	
	$max_page = $wp_query->max_num_pages;

	if ( $numposts <= $posts_per_page ) { return; }
	if(empty($paged) || $paged == 0) {
		$paged = 1;
	}	
	$pages_to_show = 7;
	$pages_to_show_minus_1 = $pages_to_show-1;
	$half_page_start = floor($pages_to_show_minus_1/2);
	$half_page_end = ceil($pages_to_show_minus_1/2);
	$start_page = $paged - $half_page_start;
	if($start_page <= 0) {
		$start_page = 1;
	}
	$end_page = $paged + $half_page_end;
	if(($end_page - $start_page) != $pages_to_show_minus_1) {
		$end_page = $start_page + $pages_to_show_minus_1;
	}
	if($end_page > $max_page) {
		$start_page = $max_page - $pages_to_show_minus_1;
		$end_page = $max_page;
	}
	if($start_page <= 0) {
		$start_page = 1;
	}
	echo $before.'<nav class="page-navigation pagination-centered"><ul class="pagination">'."";	
	if ($start_page >= 2 && $pages_to_show < $max_page) {
		$first_page_text = __( "First", 'templatic' );
		echo '<li class="bpn-first-page-link"><a href="'.get_pagenum_link().'" title="'.$first_page_text.'">'.$first_page_text.'</a></li>';
	}
	echo '<li class="bpn-prev-link">';
	previous_posts_link("<i class='fa fa-angle-left'></i>");
	echo '</li>';
	for($i = $start_page; $i  <= $end_page; $i++) {
		if($i == $paged) {
			echo '<li class="current"><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		} else {
			echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
		}
	}
	echo '<li class="bpn-next-link">';
	next_posts_link("<i class='fa fa-angle-right'></i>");
	echo '</li>';
	if ($end_page < $max_page) {
		$last_page_text = __( "Last", 'templatic' );
		echo '<li class="bpn-last-page-link"><a href="'.get_pagenum_link($max_page).'" title="'.$last_page_text.'">'.$last_page_text.'</a></li>';
	}
	echo '</ul></nav>'.$after."";
} /* end page navi */

/*********************
ADD FOUNDATION FEATURES TO WORDPRESS
*********************/
// Add "has-dropdown" CSS class to navigation menu items that have children in a submenu.
function nav_menu_item_parent_classing( $classes, $item )
{
    global $wpdb;
    
$has_children = $wpdb -> get_var( "SELECT COUNT(meta_id) FROM {$wpdb->prefix}postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='" . $item->ID . "'" );
    
    if ( $has_children > 0 )
    {
        array_push( $classes, "has-dropdown" );
    }
    
    return $classes;
}
 
add_filter( "nav_menu_css_class", "nav_menu_item_parent_classing", 10, 2 );

//Deletes empty classes and changes the sub menu class name
    function change_submenu_class($menu) {
        $menu = preg_replace('/ class="sub-menu"/',' class="dropdown"',$menu);
        return $menu;
    }
    add_filter ('wp_nav_menu','change_submenu_class');


//Use the active class of the ZURB Foundation for the current menu item. (From: https://github.com/milohuang/reverie/blob/master/functions.php)
function required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );

// Search Form
function tmpl_wpsearch($form) {
	global $post; if($post->post_type == 'post') { $post_type = 'post';}else{ $post_type = 'videos';}
	$form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
	<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="'.__('Search the Site...','templatic').'" />
	<input name="post_type[]" value="'. $post_type.'" type="hidden">
	<input type="submit" id="searchsubmit" class="button" value="'. __('Search') .'" />
	</form>';
	return $form;
} // don't remove this bracket!

/*********************
RANDOM CLEANUP ITEMS
*********************/

// remove the p from around imgs
function tmpl_filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

// This removes the annoying […] to a Read More link
function tmpl_excerpt_more($more) {
	global $post;
	// edit here if you like
return '...  <a class="excerpt-read-more" href="'. esc_url(get_permalink($post->ID)) . '" title="'. __('Read', 'templatic') . get_the_title($post->ID).'">'. __('Read more &raquo;', 'templatic') .'</a>';
}

/*
 * This is a modified the_author_posts_link() which just returns the link.
 *
 * This is necessary to allow usage of the usual l10n process with printf().
 */
function tmpl_author_posts_link() {
	global $authordata;
	if ( !is_object( $authordata ) )
		return false;
	$link = sprintf(
		'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
		get_author_posts_url( $authordata->ID, $authordata->user_nicename ),
		esc_attr( sprintf( __( 'Posts by %s',"templatic" ), get_the_author() ) ), // No further l10n needed, core will take care of this one
		get_the_author()
	);
	return $link;
}

/* static string and javascirpt dynamic variable declare for global */
add_action('wp_head','single_post_template_head');
function single_post_template_head()
{
    $delete_msg =__('Are you really sure want to DELETE this post? Deleted post can not be recovered later.','templatic');
    ?>
	
	<script  type="text/javascript" async >
		var ajaxUrl = "<?php echo esc_js( $site_url); ?>";
		var tevolutionajaxUrl = "<?php echo esc_js( $tevolutionajaxUrl); ?>";
		var upload_single_title = "<?php _e("Upload Image",'templatic');?>"; 
		var RecaptchaOptions = { theme : '<?php echo $a['comments_theme']; ?>', lang : '<?php echo $a['recaptcha_language']; ?>', tabindex :'<?php echo $a['comments_tab_index']?>' };
		<?php if(is_author()): ?>
                    var delete_auth_post = "<?php echo wp_create_nonce( "auth-delete-post" );?>";
                    var currUrl = "<?php echo ( is_ssl() ) ? 'https://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"] : 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];?>";
                    var delete_confirm="<?php echo $delete_msg;?>";
                    var deleting="<?php _e('Deleting.','templatic');?>";
		<?php endif;?>
		var current_user="<?php echo $current_user->ID?>";
		var favourites_sort="<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='favourites')? 1:'';?>";
		
        </script>
<?php
}

if(file_exists(get_template_directory().'/functions/theme_options.php')){
	require_once(get_template_directory().'/functions/theme_options.php');
}

/* add menu for theme setting */
add_action('admin_menu', 'register_theme_settings_menu',9999);
if(!function_exists('register_theme_settings_menu')){
	function register_theme_settings_menu() {
		add_theme_page(__("Theme Settings",'templatic-admin'), __("Theme Settings",'templatic-admin'), 'manage_options', 'theme-settings-page', 'theme_settings_page_callback'  );		
	}
}

/* hook before body to add google analytics code */
add_action('before_body_end','video_google_analytics');
function video_google_analytics(){
	echo stripslashes(supreme_get_settings('video_google_analytics'));
}
?>
