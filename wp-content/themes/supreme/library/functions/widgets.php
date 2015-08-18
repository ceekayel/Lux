<?php
/**
 * Sets up the core framework's widgets and unregisters some of the default WordPress widgets if the 
 * theme supports this feature.  The framework's widgets are meant to extend the default WordPress
 * widgets by giving users highly-customizable widget settings.  A theme must register support for the 
 * 'hybrid-core-widgets' feature to use the framework widgets.
 *
 * @package HybridCore
 * @subpackage Functions
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2008 - 2012, Justin Tadlock
 * @link http://themehybrid.com/hybrid-core
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Unregister WP widgets. */
add_action( 'widgets_init', 'hybrid_unregister_widgets' );

/* Register Hybrid widgets. */
add_action( 'widgets_init', 'hybrid_register_widgets' );

/**
 * Registers the core frameworks widgets.  These widgets typically overwrite the equivalent default WordPress
 * widget by extending the available options of the widget.
 *
 * @since 0.6.0
 * @access private
 * @uses register_widget() Registers individual widgets with WordPress
 * @link http://codex.wordpress.org/Function_Reference/register_widget
 * @return void
 */
function hybrid_register_widgets() {

	/* Load the archives widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-archives.php' );

	/* Load the authors widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-authors.php' );

	/* Load the bookmarks widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-bookmarks.php' );

	/* Load the calendar widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-calendar.php' );

	/* Load the categories widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-categories.php' );

	/* Load the nav menu widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-nav-menu.php' );

	/* Load the pages widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-pages.php' );

	/* Load the search widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-search.php' );

	/* Load the tags widget class. */
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-tags.php' );
	
	/* Load the mega menu widget class. */
	if(file_exists(get_stylesheet_directory().'/functions/mega_menu_widget.php')){
		require_once(get_stylesheet_directory().'/functions/mega_menu_widget.php');
	}else{
		require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-mega_menu.php' );
	}
	/* Load the subscribe widget class */
	if(file_exists( trailingslashit( HYBRID_CLASSES ) . 'widget-subscribe.php' )){
		require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-subscribe.php' );
	}
	
	/* Load the Social media widget class */
	if(file_exists( trailingslashit( HYBRID_CLASSES ) . 'widget-social_media.php' )){
		require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-social_media.php' );
	}
	
	/* Load the Flicker widget class */
	
	if(file_exists( trailingslashit( HYBRID_CLASSES ) . 'widget_flicker.php' )){
		require_once( trailingslashit( HYBRID_CLASSES ) . 'widget_flicker.php' );
	}
	
	/* Load the Testimonial widget class */
	if(file_exists( trailingslashit( HYBRID_CLASSES ) . 'widget-testimonials.php' )){
		require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-testimonials.php' );
	}
	
	require_once( trailingslashit( HYBRID_CLASSES ) . 'widget-google_map.php' );
	
	/* Register the archives widget. */
	register_widget( 'Hybrid_Widget_Archives' );

	/* Register the authors widget. */
	register_widget( 'Hybrid_Widget_Authors' );

	/* Register the bookmarks widget. */
	register_widget( 'Hybrid_Widget_Bookmarks' );

	/* Register the calendar widget. */
	register_widget( 'Hybrid_Widget_Calendar' );

	/* Register the categories widget. */
	register_widget( 'Hybrid_Widget_Categories' );

	/* Register the nav menu widget. */
	register_widget( 'Hybrid_Widget_Nav_Menu' );

	/* Register the pages widget. */
	register_widget( 'Hybrid_Widget_Pages' );

	/* Register the search widget. */
	register_widget( 'Hybrid_Widget_Search' );

	/* Register the tags widget. */
	register_widget( 'Hybrid_Widget_Tags' );
	
/*	Code By Templatic Start */	
	/* Register the mega menu widget. */
	register_widget( 'dc_jqmegamenu_widget' );
	
	/* Register Google Map Widget */
	register_widget('templatic_google_map');

	register_widget("templatic_slider");	
	
	/*	Code By Templatic End */
}

/**
 * Unregister default WordPress widgets that are replaced by the framework's widgets.  Widgets that
 * aren't replaced by the framework widgets are not unregistered.
 *
 * @since 0.3.2
 * @access private
 * @uses unregister_widget() Unregisters a registered widget.
 * @link http://codex.wordpress.org/Function_Reference/unregister_widget
 * @return void
 */
function hybrid_unregister_widgets() {

	/* Unregister the default WordPress widgets. */
	unregister_widget( 'WP_Widget_Archives' );
	unregister_widget( 'WP_Widget_Calendar' );
	unregister_widget( 'WP_Widget_Categories' );
	unregister_widget( 'WP_Widget_Links' );
	unregister_widget( 'WP_Nav_Menu_Widget' );
	unregister_widget( 'WP_Widget_Pages' );
	unregister_widget( 'WP_Widget_Recent_Posts' );
	unregister_widget( 'WP_Widget_Search' );
	unregister_widget( 'WP_Widget_Tag_Cloud' );
}

/*
 * Create the templatic twiter post widget
 */	
 if(!function_exists('is_curl_installed')){
	function is_curl_installed() {
		if  (in_array  ('curl', get_loaded_extensions())) {
			return true;
		}
		else {
			return false;
		}
	}
}

 if(!class_exists('templatic_twiter')){
	 if(!class_exists('TwitterOAuth')){ 
		require_once('Oauth/twitteroauth.php');
	}
	class templatic_twiter extends WP_Widget{
		function templatic_twiter(){
			$this->options = array(
				array(
					'name'	=> 'title',
					'label'	=> __( 'Title', 'supreme' ),
					'type'	=> 'text'
				),			
				array(
					'name'	=> 'twitter_username',
					'label'	=> __( 'Twitter Username', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_key',
					'label'	=> __( 'Consumer Key', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'consumer_secret',
					'label'	=> __( 'Consumer Secret', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token',
					'label'	=> __( 'Access Token', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'access_token_secret',
					'label'	=> __( 'Access Token Secret', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'twitter_number',
					'label'	=> __( 'Number Of Tweets', 'supreme' ),
					'type'	=> 'text'
				),
				array(
					'name'	=> 'follow_text',
					'label'	=> __( 'Twitter button text <small>(for eg. Follow us, Join me on Twitter, etc.)</small>', 'supreme' ),
					'type'	=> 'text'
				),			
			);
			$widget_options = array(
				'classname'		=>	'widget Templatic twitter',
				'description'	=>	__('Show your latest tweets on your site.','supreme')
			);
			$this->WP_Widget(false, __('T &rarr; Latest Twitter Feeds','supreme'), $widget_options);
		}
		
		function widget($args, $instance){
			extract($args, EXTR_SKIP );
			$title = ($instance['title']) ? $instance['title'] : 'Latest Tweets';
			$twitter_username = ($instance['twitter_username']) ? $instance['twitter_username'] : '';
			$consumer_key = ($instance['consumer_key']) ? $instance['consumer_key'] : '3';
			$consumer_secret = ($instance['consumer_secret']) ? $instance['consumer_secret'] : '3';
			$access_token = ($instance['access_token']) ? $instance['access_token'] : '3';
			$access_token_secret = ($instance['access_token_secret']) ? $instance['access_token_secret'] : '3';
			$twitter_number = ($instance['twitter_number']) ? $instance['twitter_number'] : '3';
			$follow_text = apply_filters('widget_title', $instance['follow_text']);
			
			echo $before_widget;
			
			if ( $title ) {
				echo '<h3 class="widget-title">' . $title . '</h3>';
			}
			if (!is_curl_installed()) {
				_e("cURL is NOT installed on this server",'supreme');
			}else{
			if ($twitter_username != '') {
				templatic_twitter_messages($instance);
				}
			}
			
			echo $after_widget;
		}
		
		/** @see WP_Widget::update */
		function update($new_instance, $old_instance) {				
			$instance = $old_instance;
			foreach ($this->options as $val) {
				if ($val['type']=='text') {
					$instance[$val['name']] = strip_tags($new_instance[$val['name']]);
				} else if ($val['type']=='checkbox') {
					$instance[$val['name']] = ($new_instance[$val['name']]=='on') ? true : false;
				}
			}
			return $instance;
		}
		function form($instance){
			if (empty($instance)) {
				$instance['title']					= __( 'Latest Tweets', 'supreme' );			
				$instance['twitter_username']		= 'templatic';
				$instance['consumer_key']			= '';
				$instance['consumer_secret']		= '';
				$instance['access_token']			= '';
				$instance['access_token_secret']	= '';
				$instance['twitter_number']			= '3';			
				$instance['follow_text']			= __('Follow Us','supreme');
			}
			echo '<p><span style="font-size:11px">To use this widget, <a href="https://dev.twitter.com/apps/new" style="text-decoration:none;" target="_blank">create</a> an application or <a href="https://dev.twitter.com/apps" target="_blank" style="text-decoration:none;" >click here</a> if you already have it, and fill required fields below. Need help? Read <a href="http://templatic.com/docs/latest-changes-in-twitter-widget-for-all-templatic-themes/" title="Tweeter Widget Guide" target="_blank" style="text-decoration:none;" >Tweeter Guide</a>.</small></p>';
			foreach ($this->options as $val) {
				$label = '<label for="'.$this->get_field_id($val['name']).'">'.$val['label'].'</label>';
				if ($val['type']=='separator') {
					echo '<hr />';
				} else if ($val['type']=='text') {
					echo '<p>'.$label.'<br />';
					echo '<input class="widefat" id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="text" value="'.esc_attr($instance[$val['name']]).'" /></p>';
				} else if ($val['type']=='checkbox') {
					$checked = ($instance[$val['name']]) ? 'checked="checked"' : '';
					echo '<input id="'.$this->get_field_id($val['name']).'" name="'.$this->get_field_name($val['name']).'" type="checkbox" '.$checked.' /> '.$label.'<br />';
				}
			}
		}
	}
	// Register Widget
	add_action('widgets_init', create_function('', 'return register_widget("templatic_twiter");'));
}

//Function to convert date to time ago format
//eg.1 day ago, 1 year ago, etc...
if(!function_exists('time_elapsed_string')){
function time_elapsed_string($ptime) {
    $etime = time() - $ptime;
    
    if ($etime < 1) {
        return __('0 seconds','supreme');
    }
    
    $a = array( 12 * 30 * 24 * 60 * 60  =>  __('year','supreme'),
                30 * 24 * 60 * 60       =>  __('month','supreme'),
                24 * 60 * 60            =>  __('day','supreme'),
                60 * 60                 =>  __('hour','supreme'),
                60                      =>  __('minute','supreme'),
                1                       =>  __('second','supreme')
                );
    
    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return __("$r $str".($r > 1 ? 's' : ''),'supreme').' '.__("ago",'supreme');
		}
    }
}
}
//Function to convert date to time ago format
function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret) {
		$connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);
		return $connection;
	}
function templatic_twitter_messages($options){
	$twitter_username	 = $options['twitter_username'];
	$consumer_key		 = $options['consumer_key'];
	$consumer_secret	 = $options['consumer_secret'];
	$access_token		 = $options['access_token'];
	$access_token_secret = $options['access_token_secret'];
	$twitter_number		 = $options['twitter_number'];
	$follow_text		 = $options['follow_text'];
	
	
	$connection = getConnectionWithAccessToken($consumer_key, $consumer_secret, $access_token, $access_token_secret);
	$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$twitter_username."&count=".$twitter_number);
	$tweet_errors = (array) $tweets->errors;
	if (empty($tweets)) {
	    _e('No public tweets','supreme');
	}elseif(!empty($tweet_errors)){
		$twitter_error = $tweet_errors;
		$debug = '<br />Error:('.$twitter_error[0]->code.')<br/> '.$twitter_error[0]->message;
		_e('Unable to get tweets'.$debug,'supreme');
	}else{
		echo '<ul id="twitter_update_list" class="templatic_twitter_widget">';
		foreach ($tweets  as $tweet) {
			$exact_link = $tweet->entities->urls[0]->url;
			$twitter_timestamp = strtotime($tweet->created_at);
			$tweet_date = time_elapsed_string( $twitter_timestamp );
			echo '<li>';
				$msg = $tweet->text;
				$flag = 0;
				if(strpos($msg, "http://") !== false){
					$flag = 1;
				}
				if($flag==1){
					$msg = substr($msg,0,strpos($msg, "http://"));
				}
				$msg = utf8_encode($msg);	
				echo $msg;
				if($flag==1){
					echo '<br/><a href="'.$exact_link.'" target="_blank" class="twitter-link" >'.$exact_link.'</a>';
				}
				echo '<span class="twit_time" style="display: block;">'.$tweet_date.'</span>';
			echo '</li>';
		}
		echo '</ul>';
		if($follow_text){				
			echo "<a href='http://www.twitter.com/$twitter_username/' title='$follow_text' class='twitter_title_link follow_us_twitter' target='_blank'>$follow_text</a>";				
		}
	}
}
 
add_action('wp_footer','supreme_add_nivoslider_js');
function supreme_add_nivoslider_js()
{
	wp_enqueue_script('flexslider_script', get_template_directory_uri()."/js/jquery.flexslider-min.js");
}

function supreme_add_nivoslider_css()
{
	echo '<link rel="stylesheet" href="'.get_template_directory_uri().'/css/flexslider.css" type="text/css" media="screen" />';
}
/*

 * Create the templatic Slider
 */
if(!class_exists('templatic_slider') && current_theme_supports('supreme-slider')){	
class templatic_slider extends WP_Widget {
	
	function templatic_slider() {
	//Constructor
		$widget_ops = array('classname' => __('widget Templatic Slider','supreme'), 'description' => __('Home Page Slider that displays either selected post types or custom images on the Home Page','supreme') );
		$this->WP_Widget('templatic_slider', __('T &rarr;  Home Page Main Slider','supreme'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;		
		 /*
		  *  Add flexslider script and style sheet in head tag
		  */
		  
		 
				$custom_banner_temp = empty($instance['custom_banner_temp']) ? '' : $instance['custom_banner_temp'];
				$post_type = empty($instance['post_type']) ? 'post,1' : apply_filters('widget_category', $instance['post_type']);								
						
				$s1 = empty($instance['s1']) ? '' : apply_filters('widget_s1', $instance['s1']);
				$s1_title = empty($instance['s1_title']) ? '' : apply_filters('widget_s1_title', $instance['s1_title']);
				$s1_title_link = empty($instance['s1_title_link']) ? '' : apply_filters('widget_s1_title_link', $instance['s1_title_link']);
				$animation = empty($instance['animation']) ? 'slide' : apply_filters('widget_number', $instance['animation']);
				$number = empty($instance['number']) ? '5' : apply_filters('widget_number', $instance['number']);
				$height = empty($instance['height']) ? '' : apply_filters('widget_height', $instance['height']);
				$autoplay = empty($instance['autoplay']) ? '' : apply_filters('widget_autoplay', $instance['autoplay']);
				$slideshowSpeed =  empty($instance['slideshowSpeed']) ? '' : apply_filters('widget_autoplay', $instance['slideshowSpeed']);
				$sliding_direction = empty($instance['sliding_direction']) ? 'horizontal' : $instance['sliding_direction'];
				$reverse = empty($instance['reverse']) ? 'false' : $instance['reverse'];
				$animation_speed = empty($instance['animation_speed']) ? '2000' : $instance['animation_speed'];
				$slider_id = empty($instance['slider_id']) ? 'flexslider' : $instance['slider_id'];
				
				
				// Carousel Slider Settings
				$is_Carousel = empty($instance['is_Carousel']) ? '' : $instance['is_Carousel'];
				$carousel='';
				if($is_Carousel)
				{
					
					$item_width = empty($instance['item_width']) ? '0' : $instance['item_width'];
					?>
					<style>
						.slides > li { width:<?php echo  $item_width; ?>px !important }
					</style>
					<?php
					//$item_margin = empty($instance['item_margin']) ? '0' : $instance['item_margin'];
					$min_item = empty($instance['min_item']) ? '0' : $instance['min_item'];
					$max_items = empty($instance['max_items']) ? '0' : $instance['max_items'];
					$item_move = empty($instance['item_move']) ? '0' : $instance['item_move'];
					
					$width=apply_filters('carousel_slider_width',$item_width);
					$height=apply_filters('carousel_slider_height','');
					$carousel='carousel';
				}else{
					$item_width=0;
					$min_item = 0;
					$max_items =0;
					$item_move=0;
					$width=0;
					$height='';
				}
			
				if($autoplay==''){ $autoplay='false'; }
				if($slideshowSpeed==''){$slideshowSpeed='7000';}
				if($animation_speed==''){$animation_speed='600';}
				if($autoplay=='false'){ $animation_speed='70000'; }
	?>
	
				<script type="text/javascript">					
					 jQuery(window).load(function(){
					 	// store the slider in a local variable
						  var $window = jQuery(window), flexslider;
						 
						  // tiny helper function to add breakpoints
						  function getGridSize() {
						    return (window.innerWidth < 600) ? 1 :
						           (window.innerWidth < 900) ? 3 : <?php echo $max_items;?>;
						  }
					  jQuery('#<?php echo $slider_id; ?>').flexslider({
						animation: '<?php echo $animation;?>',
						slideshow: <?php echo $autoplay;?>,
						direction: "<?php echo $sliding_direction;?>",
						slideshowSpeed: <?php echo $slideshowSpeed;?>,						
						<?php if($autoplay=='true'):?>animationSpeed: <?php echo $animation_speed;?>,<?php endif;?>
						reverse: <?php echo $reverse;?>,
						animationLoop: true,
						startAt: 0,
						smoothHeight: true,
						easing: "swing",
						pauseOnHover: true,
						video: true,
						controlNav: true, 
						directionNav: true,
						prevText: "",
						nextText: "",
						// Carousel Slider Options
						itemWidth: <?php echo (int)$item_width;?>,                   //{NEW} Integer: Box-model width of individual carousel items, including horizontal borders and padding.
						itemMargin: <?php if($min_item!=""){echo $min_item;}else echo '0'?>,                  //{NEW} Integer: Margin between carousel items.						
						move: <?php echo $item_move;?>,                        //{NEW} Integer: Number of carousel items that should move on animation. If 0, slider will move all visible items.
						minItems: getGridSize(), // use function to pull in initial value
				      	maxItems: getGridSize(), // use function to pull in initial value
					     start: function(slider){
							jQuery('body').removeClass('loading');
					   	}
						
					  });
					});
					//FlexSlider: Default Settings
				</script>

<div id="<?php echo $slider_id; ?>" class="flexslider clearfix">
	<div class="slides_container clearfix">
		<?php do_action('templ_slider_search_widget',$instance);// add action for display additional field?>
		<ul class="slides">
			<?php if(isset($instance['custom_banner_temp']) && $instance['custom_banner_temp'] == 1):?>
			<?php if(is_array($s1)):?>
			<?php for($i=0;$i<count($s1);$i++):?>
			<?php if($s1[$i]!=""):
								   
								    if(function_exists('icl_register_string')){
										icl_register_string('supreme','custom_content_title'.$s1_title[$i].$i,$s1_title[$i]);
										$s1_title[$i] = icl_t('supreme','custom_content_title'.$s1_title[$i].$i,$s1_title[$i]);	
									}

									?>
			<li>
				<div class="post_list <?php echo $carousel;?>">
				<div class="post_img">
					<a href="<?php echo @$s1_title_link[$i]?>" title="<?php echo @$s1_title[$i];?>"><img src="<?php echo $s1[$i]; ?>"  alt="" /></a>
				</div>
				<div class="slider-post custom_image">
					<?php 
					if(@$s1_title[$i] != '')
					{?>
						<h2><a href="<?php echo $s1_title_link[$i]?>" title="<?php echo $s1_title[$i];?>"><?php echo $s1_title[$i]; ?> </a></h2>
					<?php 	do_action('tmpl_image_text_link',$i,$instance); 
					}?>
				</div>
				</div>
			</li>
			<?php endif;?>
			<?php endfor;//finish forloop?>
			<?php endif;?>
			<?php else: 
						global $post,$wpdb;
						$counter=0;
						$postperslide = 1;						
						$slider_post=$post_type;
						for($k=0;$k<sizeof($slider_post);$k++){
							
							$posttype = explode(',',$slider_post[$k]);				
							$post_type = $posttype[0];
							$catid = $posttype[1];
							$cat_name = @$posttype[2];
							$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));							
							if($post_type=='product')
							{
								$taxonomies[0]='product_cat';	
							}
							$term = get_term( $catid, $taxonomies[0] );							
							$cat_id[]=$term->term_id;
						
						}
						$args=array(												  
								  'post_type' => $post_type,
								  'posts_per_page' => -1,												  
								  'post_status' => 'publish' ,
								  'tax_query' => array(                
											array(
												'taxonomy' =>$taxonomies[0],
												'field' => 'id',
												'terms' => $cat_id,
												'operator'  => 'IN'
											)            
										 )
								  );	
							 
						$slide = null;	
						remove_all_actions('posts_where');
						remove_all_actions('posts_orderby');
						$slide = new WP_Query($args);							
						if( $slide->have_posts() ) {
							while ($slide->have_posts()) : $slide->the_post();
								global $post;	
								if($slider_post_id!=""){
									if(in_array(get_the_ID(),$slider_post_id))
										continue;
								}
								
								$slider_post_id[]=get_the_ID();
									//check post thumbnail image if available
									if ( has_post_thumbnail()) {
										$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'home-page-slider');
										$post_images=$large_image_url[0];
									}else{
										if(function_exists('bdw_get_images_plugin'))
										{
											$post_images=bdw_get_images_plugin($post->ID,'home-page-slider');													
											$post_images = $post_images[0]['file'];
										}
									}
								//$post_images =  bdw_get_images_with_info($post->ID,'home_slider');
								if($counter=='0' || $counter%$postperslide==0){ echo "<li>";}
							?>
			<div class="post_list <?php echo $carousel;?>">
				<div class="post_img"> <a href="<?php the_permalink(); ?>">
					<?php if($post_images != ""){?>
					<img  src="<?php echo $post_images;?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					<?php }else{?>
					<img  src="<?php echo TEMPL_PLUGIN_URL;?>tmplconnector/monetize/templatic-widgets/widget_images/add_220x220.png"  alt="<?php the_title(); ?>" title="<?php the_title(); ?>" />
					<?php }?>
					</a>
				</div>
				<div class="slider-post">
					<h2>
						<a href="<?php the_permalink() ?>" rel="bookmark"> <?php the_title(); ?> </a>
					</h2>
					<?php echo print_excerpt(50); ?>
					<?php do_action('slider_extra_content',get_the_ID());// do action for display the extra content?>
				</div>
			</div>
			<?php
								$counter++; 
								if($counter%$postperslide==0){ echo "</li>"; }
							endwhile;
							
						}
					?>
			<?php endif;?>
		</ul>
	</div>
</div>
<?php		
		echo $after_widget;		
	}
	
	function update($new_instance, $old_instance) {
				//save the widget						
				return $new_instance;
			}
	
	function form($instance) {		
		//widgetform in backend
				$instance = wp_parse_args( (array) $instance, array( 'search'=>'','search_post_type'=>'','location'=>'','distance'=>'','radius'=>'', 'post_type' => '', 'number' => '', 'animation'=>'', 'slideshowSpeed'=>'', 'animation_speed'=>'', 'sliding_direction'=>'', 'reverse'=>'', 'item_width'=>'','is_Carousel_temp'=>'',  'min_item'=>'', 'max_items'=>'', 'item_move'=>'', 'custom_banner_temp'=>'','s1' => '', 's1_title' => '' ) );
				
				// Widget Get Posts settings
				
				$custom_banner_temp = strip_tags($instance['custom_banner_temp']);
				$post_type = $instance['post_type'];				
				$number = strip_tags($instance['number']);
				
				// Slider Basic Settings
				$autoplay = strip_tags($instance['autoplay']);
				$animation = strip_tags($instance['animation']);
				$slideshowSpeed = strip_tags($instance['slideshowSpeed']);
				$sliding_direction = strip_tags($instance['sliding_direction']);
				$reverse = strip_tags($instance['reverse']);
				$animation_speed = strip_tags($instance['animation_speed']);
				
				// Carousel Slider Settings
				// Carousel Slider Settings
				$is_Carousel = strip_tags($instance['is_Carousel']);
				$item_width = strip_tags($instance['item_width']);
				//$item_margin = strip_tags($instance['item_margin']);
				$min_item = strip_tags($instance['min_item']);
				$max_items = strip_tags($instance['max_items']);
				$item_move = strip_tags($instance['item_move']);
				
				$is_Carousel_temp = strip_tags($instance['is_Carousel_temp']);
				$item_width = strip_tags($instance['item_width']);
				//$item_margin = strip_tags($instance['item_margin']);
				$min_item = strip_tags($instance['min_item']);
				$max_items = strip_tags($instance['max_items']);
				$item_move = strip_tags($instance['item_move']);
				
				//  If Custom Banner Slider (Settings)				
				$s1 = ($instance['s1']);
				global $count_s1;
				$count_s1 = count($instance['s1']);
				$s1_title = ($instance['s1_title']);
				$s1_title_link = ($instance['s1_title_link']);
				
				
			?>
				<script type="text/javascript">										
					function select_custom_image(id,div_def,div_custom)
					{
						var checked=id.checked;
						jQuery('#'+div_def).slideToggle('slow');
						jQuery('#'+div_custom).slideToggle('slow');
					}
					function select_is_Carousel(id,div_def)
					{
						var checked=id.checked;
						jQuery('#'+div_def).slideToggle('slow');						
					}
				</script>
	<?php do_action('templ_search_slider_widget_form',$this,$instance); // add action for display additional field?>
	<p>
		<label for="<?php echo $this->get_field_id('slider_id'); ?>">
			<?php _e('Slider ID','supreme'); ?></label>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('slider_id'); ?>" id="<?php echo $this->get_field_id('slider_id'); ?>"/>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('animation'); ?>">
			<?php _e('Animation','supreme'); ?>
			<select class="widefat" name="<?php echo $this->get_field_name('animation'); ?>" id="<?php echo $this->get_field_id('animation'); ?>">
				<option <?php if(esc_attr($animation)=='fade'){?> selected="selected"<?php }?> value="fade">
				<?php _e("Fade","templatic");?>
				</option>
				<option <?php if(esc_attr($animation)=='slide'){?> selected="selected"<?php }?> value="slide">
				<?php _e("Slide","templatic");?>
				</option>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('autoplay'); ?>">
			<?php _e('Slide show','supreme'); ?>
			<select class="widefat" name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>">
				<option <?php if(esc_attr($autoplay)=='true'){?> selected="selected"<?php }?> value="true">
				<?php _e("Yes","templatic");?>
				</option>
				<option <?php if(esc_attr($autoplay)=='false'){?> selected="selected"<?php }?> value="false">
				<?php _e("No","templatic");?>
				</option>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('sliding_direction'); ?>">
			<?php _e('Sliding Direction','supreme'); ?>
			<select class="widefat" name="<?php echo $this->get_field_name('sliding_direction'); ?>" id="<?php echo $this->get_field_id('sliding_direction'); ?>">
				<option <?php if(esc_attr($sliding_direction)=='horizontal'){?> selected="selected"<?php }?> value="horizontal">
				<?php _e("Horizontal","templatic");?>
				</option>
				<option <?php if(esc_attr($sliding_direction)=='vertical'){?> selected="selected"<?php }?> value="vertical">
				<?php _e("Vertical","templatic");?>
				</option>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('reverse'); ?>">
			<?php _e('Animation Direction','supreme'); ?>
			<select class="widefat" name="<?php echo $this->get_field_name('reverse'); ?>" id="<?php echo $this->get_field_id('reverse'); ?>">
				<option <?php if(esc_attr($reverse)=='false'){?> selected="selected"<?php }?> value="false">
				<?php _e("Right to Left","templatic");?>
				</option>
				<option <?php if(esc_attr($reverse)=='true'){?> selected="selected"<?php }?> value="true">
				<?php _e("Left to Right","templatic");?>
				</option>
			</select>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('slideshowSpeed'); ?>">
			<?php _e('Slide Show Speed','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('slideshowSpeed'); ?>" name="<?php echo $this->get_field_name('slideshowSpeed'); ?>" type="text" value="<?php echo esc_attr($slideshowSpeed); ?>" />
			  <small><?php _e('Default : 7000 - Set the speed of the slideshow cycle in milliseconds.','supreme');?> </small>
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('animation_speed'); ?>">
			<?php _e('Animation Speed','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('animation_speed'); ?>" name="<?php echo $this->get_field_name('animation_speed'); ?>" type="text" value="<?php echo esc_attr($animation_speed); ?>" />
			  <small><?php _e('Default : 600 - Set the speed of animations, in milliseconds.','supreme');?> </small>
		</label>
	</p>

	<p><br/>
		<label for="<?php echo $this->get_field_id('custom_banner_temp'); ?>">
			<input id="<?php echo $this->get_field_id('custom_banner_temp'); ?>" name="<?php echo $this->get_field_name('custom_banner_temp'); ?>" type="checkbox" value="1" <?php if($custom_banner_temp =='1'){ ?>checked=checked<?php } ?>style="width:10px;" onclick="select_custom_image(this,'<?php echo $this->get_field_id('home_slide_default_temp'); ?>','<?php echo $this->get_field_id('home_slide_custom_temp'); ?>');" />
			<?php _e('<b>Use custom images?</b>','supreme');?>
			<br/>
		</label>
		<br/>
	</p>
<div id="<?php echo $this->get_field_id('home_slide_default_temp'); ?>" style="<?php if($custom_banner_temp =='1'){ ?>display:none;<?php }else{?>display:block;<?php }?>">
	<p>
		<label for="<?php echo $this->get_field_id('post_type');?>" >
			<?php _e('Select Taxonomy:','supreme');?>
			<select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>[]" class="widefat"  multiple="multiple" size="8">
				<?php $taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );
						foreach ( $taxonomies as $taxonomy ) {	
							$query_label = '';
							if ( !empty( $taxonomy->query_var ) )
								$query_label = $taxonomy->query_var;
							else
								$query_label = $taxonomy->name;
							
							if($taxonomy->labels->name!='Tags' && $taxonomy->labels->name!='Format' && !strstr($taxonomy->labels->name,'tag') && !strstr($taxonomy->labels->name,'Tags') && !strstr($taxonomy->labels->name,'format') && !strstr($taxonomy->labels->name,'Shipping Classes')&& !strstr($taxonomy->labels->name,'Order statuses')&& !strstr($taxonomy->labels->name,'genre')&& !strstr($taxonomy->labels->name,'platform') && !strstr($taxonomy->labels->name,'colour') && !strstr($taxonomy->labels->name,'size')):	
								?>
				<optgroup label="<?php echo esc_attr( $taxonomy->object_type[0])."-".esc_attr($taxonomy->labels->name); ?>">
				<?php
									$terms = get_terms( $taxonomy->name, 'orderby=name&hide_empty=0' );
									foreach ( $terms as $term ) {		
									$term_value=esc_attr($taxonomy->object_type[0]). ',' .$term->term_id.','.$query_label;
				?>
				<!--<option style="margin-left: 8px; padding-right:10px;" value="<?php echo $term_value ?>" <?php if($post_type==$term_value) echo "selected";?>><?php echo '-' . esc_attr( $term->name ); ?></option>-->
				<option style="margin-left: 8px; padding-right:10px;" value="<?php echo $term_value ?>" <?php if($term_value !='' && is_array($post_type) && in_array(trim($term_value),$post_type)) echo "selected";?>><?php echo '-' . esc_attr( $term->name ); ?></option>
				<?php } ?>
						</optgroup>
				<?php
								endif;
								
						}
				
		?>
			</select>
		</label>
          <small><?php _e('Please select the categories of the same post type.','supreme');?> </small>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('number'); ?>">
			<?php _e('Number of posts','supreme');?>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo esc_attr($number); ?>" />
		</label>
	</p>
</div>
<div id="<?php echo $this->get_field_id('home_slide_custom_temp'); ?>" style="<?php if($custom_banner_temp =='1'){ ?>display:block;<?php }else{?>display:none;<?php }?>">
	<div id="TextBoxesGroup" class="TextBoxesGroup">
		<div id="TextBoxDiv1" class="TextBoxDiv1">
		<?php	do_action('tmpl_before_slider_title',$instance,$this);	?>
			<p>
				<?php global $textbox_title;
				$textbox_title=$this->get_field_name('s1_title');
							?>
				<label for="<?php echo $this->get_field_id('s1_title'); ?>">
					<?php _e('Banner Slider Title 1','supreme');?>
					<input type="text" class="widefat"  name="<?php echo $textbox_title; ?>[]" value="<?php echo esc_attr($s1_title[0]); ?>">
				</label>
			</p>
			<?php
			do_action('tmpl_after_slider_title',$instance,$this);
			?>
               <p>
				<?php global $textbox_title_link;
				$textbox_title_link=$this->get_field_name('s1_title_link');
							?>
				<label for="<?php echo $this->get_field_id('s1_title_link'); ?>">
					<?php _e('Banner Slider Title Link 1','supreme');?>
					<input type="text" class="widefat"  name="<?php echo $textbox_title_link; ?>[]" value="<?php echo esc_attr($s1_title_link[0]); ?>">
				</label>
			</p>
			<p>
				<?php global $textbox_name;
				$textbox_name=$this->get_field_name('s1');
							?>
				<label for="<?php echo $this->get_field_id('s1'); ?>">
					<?php _e('Banner Slider Image 1 full URL <small>(ex.http://templatic.com/images/banner1.png. )</small>  :','supreme');?>
					<input type="text" class="widefat"  name="<?php echo $textbox_name; ?>[]" value="<?php echo esc_attr($s1[0]); ?>">
				</label>
			</p>
		</div>
		<?php
						for($i=1;$i<count($s1);$i++)
						{							
							if($s1[$i]!="")
							{
								$j=$i+1;
								echo '<div  class="TextBoxDiv-'.$j.'">';
								echo '<p>';
								echo '<label>Banner Slider Text '.$j;
								echo ' <input type="text" class="widefat"  name="'.$textbox_title.'[]" value="'.esc_attr($s1_title[$i]).'"></label>';
								echo '</label>';
								echo '</p>';
								do_action('tmpl_image_link',$j,$instance,$this);
								echo '<p>';
								echo '<label>Banner Slider Text Link '.$j;
								echo ' <input type="text" class="widefat"  name="'.$textbox_title_link.'[]" value="'.esc_attr($s1_title_link[$i]).'"></label>';
								echo '</label>';
								echo '</p>';
								
								echo '<p>';
								echo '<label>Banner Slider Image '.$j.' full URL';
								echo ' <input type="text" class="widefat"  name="'.$textbox_name.'[]" value="'.esc_attr($s1[$i]).'"></label>';
								echo '</label>';
								echo '</p>';
								echo '</div>';
							}
						}
						?>
	</div>
	<?php
		do_action('add_slider_submit',$instance,$textbox_name,$textbox_title,$textbox_title_link);
	?>
	
	&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" onclick="remove_textbox();"><?php _e('Remove','supreme')?></a>	
</div>
<!--is_Carousel -->
<p><br/>
	<label for="<?php echo $this->get_field_id('is_Carousel'); ?>">
		<input id="<?php echo $this->get_field_id('is_Carousel'); ?>" name="<?php echo $this->get_field_name('is_Carousel'); ?>" type="checkbox" value="1" <?php if($is_Carousel =='1'){ ?>checked=checked<?php } 
?>style="width:10px;" onclick="select_is_Carousel(this,'<?php echo $this->get_field_id('home_slide_carousel'); ?>');"/>
		<?php _e('<b>Settings for Carousel slider option?</b>','supreme');?><br/>
          <small><?php _e('If you want to use carousel slider option then you must select the animation option as slide and sliding direction as horizontal.','supreme');?></small>
          
	</label>
</p>
<div id="<?php echo $this->get_field_id('home_slide_carousel'); ?>" style="<?php if($is_Carousel =='1'){ ?>display:block;<?php }else{?>display:none;<?php }?>">
	<p>
		<label for="<?php echo $this->get_field_id('item_width'); ?>">
			<?php _e('Item Width: <br/><small>(Box-model width of individual items, including horizontal borders and padding.)</small>','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('item_width'); ?>" name="<?php echo $this->get_field_name('item_width'); ?>" type="text" value="<?php echo esc_attr($item_width); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('min_item'); ?>">
			<?php _e('Min Item (Resizable/Responsive options) <br/><small>(Minimum number of items that should be visible. Items will resize fluidly when below this.)</small>','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('min_item'); ?>" name="<?php echo $this->get_field_name('min_item'); ?>" type="text" value="<?php echo esc_attr($min_item); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('max_items'); ?>">
			<?php _e('Max Item <br/><small>(Maxmimum number of items that should be visible. Items will resize fluidly when above this limit.)</small>','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('max_items'); ?>" name="<?php echo $this->get_field_name('max_items'); ?>" type="text" value="<?php echo esc_attr($max_items); ?>" />
		</label>
	</p>
	<p>
		<label for="<?php echo $this->get_field_id('item_move'); ?>">
			<?php _e('Slide Items <br/><small>(Number of items that should move on animation. If it&acute;s 0, slider will move all visible items.)</small>','supreme'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('item_move'); ?>" name="<?php echo $this->get_field_name('item_move'); ?>" type="text" value="<?php echo esc_attr($item_move); ?>" />
		</label>
	</p>
</div>

<!-- Finish is_Carousel -->
<?php
	}
}
}
/*
 * templatic Slider widget init
 */
add_action('add_slider_submit','add_slider_submit_button',10,3);
function add_slider_submit_button($instance,$textbox_name,$textbox_title,$textbox_title_link)
{
	?>
     	<a href="javascript:void(0)" class="link" onclick="add_textbox('<?php echo $textbox_name;?>','<?php echo $textbox_title;?>','<?php echo $textbox_title_link?>');" >+ Add New</a>		
	<?php
}
add_action('admin_footer','multitext_box');
add_action('customize_controls_enqueue_scripts','multitext_box',999);

function multitext_box()
{
	global $textbox_name,$textbox_title,$count_s1;
	?>
<script type="application/javascript">			
		
		var counter = <?php echo $count_s1;?> + 1;
		function add_textbox(name,title,title_link)
		{
			var newTextBoxDiv = jQuery(document.createElement('div')).attr("class", 'TextBoxDiv' + counter);
			newTextBoxDiv.html('<p><label>Banner Slider Title '+ counter + ' </label>'+'<input type="text" class="widefat" name="'+title+'[]" id="textbox' + counter + '" value="" ></p><p><label>Banner Slider Title Link '+ counter + ' </label>'+'<input type="text" class="widefat" name="'+title_link+'[]" id="textbox' + counter + '" value="" ></p><p><label>Banner Slider Image '+ counter + ' full URL : </label>'+'<input type="text" class="widefat" name="'+name+'[]" id="textbox' + counter + '" value="" ></p>');			  
			newTextBoxDiv.appendTo(".TextBoxesGroup");
				
		    counter++;
		}
		function remove_textbox()
		{
		    if(counter-1==1){
			   alert("you need one textbox required.");
			   return false;
		    }
		    counter--;							
		    jQuery(".TextBoxDiv" + counter).remove();
		}
	</script>
<?php
}

define('NUMBER_REVIEWS_TEXT',__('Number of Reviews','supreme'));
class templatic_recent_review extends WP_Widget {
	function templatic_recent_review() {
	//Constructor
		$widget_ops = array('classname' => 'widget recent_reviews Recent Review', 'description' => 'Shows the latest commented post/taxonomy' );		
		$this->WP_Widget('widget_comment', 'T &rarr; Recent Review', $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);
		$count = empty($instance['count']) ? '5' : apply_filters('widget_count', $instance['count']);
 		
		echo $before_widget;

 		  if(function_exists('recent_review_comments')) {
			recent_review_comments(30, $count, 100, false,$post_type,$title);
		  }

		echo $after_widget;		
	}
	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$instance['count'] = strip_tags($new_instance['count']);
 		return $instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'post_type'=>'', 'count' => '' ) );		
		$title = strip_tags($instance['title']);
		$post_type = strip_tags($instance['post_type']);
		$count = strip_tags($instance['count']);
 ?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php echo TITLE_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
	<p>
    	<label for="<?php echo $this->get_field_id('post_type');?>" ><?php _e('Select Post:','supreme');?>    	
    	<select  id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat">        	
    <?php
		$all_post_types = get_post_types();
		foreach($all_post_types as $post_types){
			if( $post_types != "page" && $post_types != "attachment" && $post_types != "revision" && $post_types != "nav_menu_item" ){
				?>
                	<option value="<?php echo $post_types;?>" <?php if($post_types== $post_type)echo "selected";?>><?php echo esc_attr($post_types);?></option>
                <?php				
			}
		}
	?>	
    	</select>
    </label>
    </p>
        <p><label for="<?php echo $this->get_field_id('count'); ?>"><?php echo NUMBER_REVIEWS_TEXT; ?>: <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo esc_attr($count); ?>" /></label></p>
<?php
	}
}





add_action( 'widgets_init', create_function('', 'return register_widget("templatic_recent_review");') );
/*	
name : recent_comments
description :Function for getting recent comments -- */
function recent_review_comments($g_size = 30, $no_comments = 10, $comment_lenth = 60, $show_pass_post = false,$post_type='post',$title='') {
        global $wpdb, $tablecomments, $tableposts,$rating_table_name,$hybrid;
		$tablecomments = $wpdb->comments;
		$tableposts = $wpdb->posts;
		
		 if(is_plugin_active('wpml-translation-management/plugin.php')){
			$language = ICL_LANGUAGE_CODE;			
			$icl_translations=$wpdb->prefix."icl_translations icl_translations";
			$request = "SELECT ID, comment_ID, comment_content, comment_author,comment_post_ID, comment_author_email FROM $tableposts, $tablecomments ,$icl_translations WHERE $tableposts.ID=icl_translations.element_id  AND icl_translations.language_code = '".$language."' AND $tableposts.ID=$tablecomments.comment_post_ID AND post_type='".$post_type."' AND post_status = 'publish' ";	
			if(!$show_pass_post) { $request .= "AND post_password ='' "; }	
			$request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT 0,$no_comments";
			
	 	}else
		{
			$request = "SELECT ID, comment_ID, comment_content, comment_author,comment_post_ID, comment_author_email FROM $tableposts, $tablecomments WHERE $tableposts.ID=$tablecomments.comment_post_ID AND post_type='".$post_type."' AND post_status = 'publish' ";	
			if(!$show_pass_post) { $request .= "AND post_password ='' "; }	
			$request .= "AND comment_approved = '1' ORDER BY $tablecomments.comment_date DESC LIMIT 0,$no_comments";
		}
        $comments = $wpdb->get_results($request);
		if($comments){
		if ( $title <> "") { 
			echo ' <h3 class="widget-title">'.$title.'</h3>';
		}
		echo '<ul class="recent_comments">';
        foreach ($comments as $comment) {
		$comment_id = $comment->comment_ID;
		$comment_content = strip_tags($comment->comment_content);
		$comment_excerpt = mb_substr($comment_content, 0, $comment_lenth)."";
		$permalink = get_permalink($comment->ID)."#comment-".$comment->comment_ID;
		$comment_author_email = $comment->comment_author_email;
		$comment_post_ID = $comment->comment_post_ID;
		$post_title = stripslashes(get_the_title($comment_post_ID));
		$permalink = get_permalink($comment_post_ID);
		
		
		echo "<li class='clearfix'><span class=\"li".$comment_id."\">";
		if (function_exists('get_avatar')) {
					  if ('' == @$comment->comment_type) {
						  echo  '<a href="'.$permalink.'">';
							echo apply_filters( "{$hybrid->prefix}_avatar",get_avatar($comment->comment_author_email, 60));
						 echo '</a>';
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
						 echo  '<a href="'.$permalink.'">';
						  echo apply_filters( "{$hybrid->prefix}_avatar",get_avatar($comment->comment_author_email, 60));
					  }
				   } elseif (function_exists('gravatar')) {
					  echo  '<a href="'.$permalink.'">';
					  echo "<img src=\"";
					  if ('' == $comment->comment_type) {
						 echo apply_filters( "{$hybrid->prefix}_avatar",get_avatar($comment->comment_author_email, 60));
						  echo '</a>';
					  } elseif ( ('trackback' == $comment->comment_type) || ('pingback' == $comment->comment_type) ) {
						echo  '<a href="'.$permalink.'">';
						 echo apply_filters( "{$hybrid->prefix}_avatar",get_avatar($comment->comment_author_email, 60));
						 echo '</a>';
					  }
					  echo "\" alt=\"\" class=\"avatar\" />";
				   }
		echo "</span>\n";
		echo '' ;
		echo  '<a href="'.$permalink.'" class="title">'.$post_title.'</a>';
		$tmpdata = get_option('templatic_settings');
		if($tmpdata['templatin_rating']=='yes'):
			$post_rating = $wpdb->get_var("select rating_rating from $rating_table_name where comment_id=\"$comment_id\"");
			echo draw_rating_star_plugin($post_rating);
		endif;
		echo "<a class=\"comment_excerpt\" href=\"" . $permalink . "\" title=\"View the entire comment\">";
		echo $comment_excerpt;
		echo "</a>";			
		echo '</li>';
    	}
		echo "</ul>";
	}
}


/*
 * Create the templatic recent post widget
 */
if(!class_exists('supreme_popular_post')){
class supreme_popular_post extends WP_Widget {
	function supreme_popular_post() {
	//Constructor
		$widget_ops = array('classname' => __('widget Templatic Popular Posts Widget ','supreme'), 'description' => __('It lists the popular posts as per total views , daily views or comments.( you can also select another post-type)','supreme') );
		$this->WP_Widget('supreme_popular_post', __('T &rarr; Popular Posts Widget ','supreme'), $widget_ops);
	}
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$post_type = empty($instance['post_type']) ? 'post' : apply_filters('widget_post_type', $instance['post_type']);	
		$number = empty($instance['number']) ? 5 : apply_filters('widget_number', $instance['number']);
		$slide = empty($instance['slide']) ? 5 : apply_filters('widget_slide', $instance['slide']);
		$popular_per = empty($instance['popular_per']) ? 'comments' : apply_filters('widget_popular_per', $instance['popular_per']);
		$pagination_position = empty($instance['pagination_position']) ? 0 : apply_filters('widget_pagination_position', $instance['pagination_position']);
		if ( $title <> "" ) { 
			echo ' <h3 class="widget-title">'.$title.'</h3>';
		}
		global $wpdb,$posts,$post,$query_string;
		$now = gmdate("Y-m-d H:i:s",time());
		$lastmonth = gmdate("Y-m-d H:i:s",gmmktime(date("H"), date("i"), date("s"), date("m")-12,date("d"),date("Y")));

		if($popular_per == 'views'){	       
	        $popularposts = "SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE  post_status = 'publish' AND meta_key = 'viewed_count' AND post_password = '' AND post_type='$post_type' ORDER BY views DESC LIMIT 0,$number";
			
		}elseif($popular_per == 'dailyviews'){
			$popularposts = "SELECT DISTINCT $wpdb->posts.*, (meta_value+0) AS views FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON $wpdb->postmeta.post_id = $wpdb->posts.ID WHERE  post_status = 'publish' AND meta_key = 'viewed_count_daily' AND post_password = '' AND post_type='$post_type' ORDER BY views DESC LIMIT 0,$number";
		}else{
			$popularposts = "SELECT COUNT(ID) as count FROM $wpdb->posts, $wpdb->comments WHERE comment_approved = '1' AND $wpdb->posts.ID=$wpdb->comments.comment_post_ID AND post_status = 'publish' AND post_date < '$now' AND post_date > '$lastmonth' AND comment_status = 'open' AND post_type='$post_type' LIMIT 0,$number"; 
		}
		$totalpost = $wpdb->get_results($popularposts);	
		@$countpost = ($totalpost[0]->count < $number) ? $totalpost[0]->count : $number ;
		if($popular_per == 'views' || $popular_per == 'dailyviews' ){
		$countpost = count($totalpost) ; }
		$dot = ceil($countpost / $slide);
		 if(is_plugin_active('wpml-translation-management/plugin.php')){
					global $sitepress;
					$current_lang_code= ICL_LANGUAGE_CODE;
					$language=$current_lang_code;
				}
		if ( $pagination_position == 1  ) {
		?>
          <div class="postpagination clearfix">
			<?php if($dot != 1) { ?>
				<a num="1" rel="0" rev="<?php echo $slide; ?>" class="active">1</a>
				<?php
					for($c = 1; $c < $dot; $c++) {
						$start = ($c * $slide);
						echo '<a num="'.($c+1).'" rel="'.$start.'" rev="'.$slide.'">'.($c+1).'&nbsp;</a>';
					}
				?>
				
			<?php } ?>
		  </div>
		 <?php } ?> 
			<div class="popular_post templatic_popular_post_technews"><ul class="listingview clearfix list" id="list"></ul></div>
		<?php 
			if ( $pagination_position!=1 ) {
		?>
		  <div class="postpagination clearfix">
			<?php if($dot != 1) { ?>
				<a num="1" rel="0" rev="<?php echo $slide; ?>" class="active">1</a>
				<?php
					for($c = 1; $c < $dot; $c++) {
						$start = ($c * $slide);
						echo '<a num="'.($c+1).'" rel="'.$start.'" rev="'.$slide.'">'.($c+1).'&nbsp;</a>';
					}
				?>
				
			<?php } ?>
		  </div>
		 <?php } ?>	
			
			<script type="text/javascript">
			jQuery('.postpagination a').click(function(){				
						var start =  parseInt(jQuery(this).attr('rel'));
						var end =  parseInt(jQuery(this).attr('rev'));	
						var num =parseInt(jQuery(this).attr('num'));
						jQuery('.postpagination a').attr('class','');
						jQuery(this).attr('class','active');					
						jQuery('#list').load('<?php echo get_template_directory_uri(); ?>/library/functions/loadpopularpost.php', { "limitarr[]": [start, end,(start + end),'<?php echo $post_type;?>',num,'<?php echo $popular_per;?>',<?php echo $number;?>,'<?php echo $language; ?>']}, function(){});
				});
				
				jQuery('#list').load('<?php echo get_template_directory_uri(); ?>/library/functions/loadpopularpost.php', { "limitarr[]": [0, <?php echo $slide; ?>,<?php echo $number; ?>,'<?php echo $post_type;?>',1,'<?php echo $popular_per;?>',<?php echo $number;?>,'<?php echo $language; ?>'] }, function(){});
				
            </script>
        <?php
	
		echo $after_widget;			
	}
	
	function update($new_instance, $old_instance) {		
		return $new_instance;
	}
	
	
	function form($instance) {
		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
			'post_type'=>'',			
			'number' => 0,		
			'slide'=>0,
			'popular_per' => '',					
			'pagination_position' => '',					
			) );
		//widgetform in backend			
		?>
        <p>
        	<label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','supreme');?>: 
            <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></label>
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('post_type');?>" ><?php _e('Select Post:','supreme');?>    	
            <select id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat" >        	
        <?php
            $all_post_types = get_post_types();
            foreach($all_post_types as $post_types){
                if( $post_types != "page" && $post_types != "attachment" && $post_types != "revision" && $post_types != "nav_menu_item" ){
                    ?>
                        <option value="<?php echo esc_attr($post_types);?>" <?php if($post_types== $instance['post_type'])echo "selected";?>><?php echo $post_types;?></option>
                    <?php				
                }
            }
        ?>	
            </select>
        </label>
        </p>
		<p>
        	<label for="<?php  echo $this->get_field_id('number'); ?>"><?php _e('Total Number of Posts','supreme');?> 
            <input class="widefat" id="<?php  echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $instance['number']; ?>" /></label>
        </p>

   		<p>
        	<label for="<?php  echo $this->get_field_id('slide'); ?>"><?php _e('Number of Posts Per Slide','supreme');?> 
            <input class="widefat" id="<?php  echo $this->get_field_id('slide'); ?>" name="<?php echo $this->get_field_name('slide'); ?>" type="text" value="<?php echo $instance['slide']; ?>" /></label>
        </p>
		
		<p>
        	<label for="<?php  echo $this->get_field_id('popular_per'); ?>"><?php _e('Shows post as per view counting/comments','supreme');?> 
            <select class="widefat" id="<?php  echo $this->get_field_id('popular_per'); ?>" name="<?php echo $this->get_field_name('popular_per'); ?>">
                <option value="views" <?php if($instance['popular_per'] == 'views') { ?>selected='selected'<?php } ?>><?php _e('Total views','supreme'); ?></option>
                <option value="dailyviews" <?php if($instance['popular_per'] == 'dailyviews') { ?>selected='selected'<?php } ?>><?php _e('Daily views','supreme'); ?></option>
                <option value="comments" <?php if($instance['popular_per'] == 'comments') { ?>selected='selected'<?php } ?>><?php _e('Total comments','supreme'); ?></option>
            </select>
            </label>
        </p>
		
		<p>
        	<label for="<?php  echo $this->get_field_id('pagination_position'); ?>"><?php _e('Pagination Position','supreme');?> 
            <select class="widefat" id="<?php  echo $this->get_field_id('pagination_position'); ?>" name="<?php echo $this->get_field_name('pagination_position'); ?>">
                <option value="0" <?php if($instance['pagination_position'] == 0) { ?>selected='selected'<?php } ?>><?php _e('After Posts','supreme'); ?></option>
                <option value="1" <?php if($instance['pagination_position'] == 1) { ?>selected='selected'<?php } ?>><?php _e('Before Posts','supreme'); ?></option>
            </select>
            </label>
        </p>

		<?php
	}
}
}
add_action( 'widgets_init', create_function('', 'return register_widget("supreme_popular_post");') );


/*
 * Create the templatic recent post widget
 */
	
class templatic_recent_post extends WP_Widget {
	function templatic_recent_post() {
	//Constructor
		$widget_ops = array('classname' => __('widget Templatic Listing Post','supreme'), 'description' => __('Shows Listing post with post thumbnail, post title, post content, post category, gravatar with order by option.','supreme') );
		$this->WP_Widget('templatic_recent_post', __('T &rarr; Listing Post','supreme'), $widget_ops);
	}
	function widget($args, $instance) {
		// prints the widget
		extract($args, EXTR_SKIP);
		// defaults
			$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
			'post_type'=>'',
			'post_type_taxonomy' => '',
			'post_number' => 0,			
			'orderby' => '',
			'order' => '',
			'show_image' => 0,
			'image_alignment' => '',
			'image_size' => '',
			'show_gravatar' => 0,
			'gravatar_alignment' => '',
			'gravatar_size' => '',
			'show_title' => 0,
			'show_byline' => 0,
			'post_info' => '[post_date] ' . __('By', 'supreme') . ' [post_author_posts_link] [post_comments]',
			'show_content' => 'excerpt',
			'content_limit' => '',
			'more_text' => __('[Read More...]', 'supreme'),			
			) );
		
		if(function_exists('icl_register_string')){
			icl_register_string('supreme','listing_widget_more_text',$instance['more_text']);		
			$instance['more_text'] = icl_t('supreme','listing_widget_more_text',$instance['more_text']);
		}
		echo $before_widget;
		// Set up the author bio
		if (!empty($instance['title']))
			echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title;
		
		remove_all_actions('posts_where');	
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $instance['post_type'] ));	
		if($instance['post_type']=='product'){
			$taxonomies[0]=$taxonomies[1];
		}
		if($instance['post_type_taxonomy'])
			$cat_id=array($instance['post_type_taxonomy']);
		else
		{
			$args=array('type'=> 'post','child_of'=> 0,'taxonomy'=> $taxonomies[0]);
			$categories = get_categories( $args ); 
			foreach($categories as $cat)
				$cat_id.=$cat->term_id.",";				
			$cat_id=substr($cat_id,0,-1);
			$cat_id = explode(",",$cat_id);
		}
		$featured_arg=array('post_type' => $instance['post_type'], 'showposts' => $instance['post_number'],'orderby' => $instance['orderby'], 'order' => $instance['order'],'tax_query' => array(                
							array(
								'taxonomy' =>$taxonomies[0],
								'field' => 'id',
								'terms' =>$cat_id,
								'operator'  => 'IN'
							)            
						 ));		
		remove_all_actions('posts_orderby');
		if(is_plugin_active('wpml-translation-management/plugin.php') && function_exists('tmpl_widget_wpml_filter')){
			add_filter('posts_where','tmpl_widget_wpml_filter');
		}
		$featured_posts = new WP_Query($featured_arg);
		if(function_exists('tmpl_widget_wpml_filter')){
			remove_filter('posts_where','tmpl_widget_wpml_filter');
		}		
		if($featured_posts->have_posts()) : 
			while($featured_posts->have_posts()) : $featured_posts->the_post();
				echo '<div '; post_class(); echo '>';
					if(!empty($instance['show_image'])) :
						printf( '<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), esc_attr( $instance['image_alignment'] ), featured_get_image( array( 'format' => 'html', 'size' => $instance['image_size'] ) ) );
					endif;
					/*Show gravatar */
					if(!empty($instance['show_gravatar'])) :
						echo '<span class="'.esc_attr($instance['gravatar_alignment']).'">';
						echo get_avatar( get_the_author_meta('ID'), $instance['gravatar_size'] );
						echo '</span>';
					endif;
					/* show post title*/
					if(!empty($instance['show_title'])) :
						printf( '<h2><a href="%s" title="%s">%s</a></h2>', get_permalink(), the_title_attribute('echo=0'), the_title_attribute('echo=0') );
					endif;
					if(!empty($instance['show_content'])) :					
						if($instance['show_content'] == 'excerpt') :
							the_excerpt();
						elseif($instance['show_content'] == 'content-limit') :							
							the_content_limit( (int)$instance['content_limit'], esc_html( $instance['more_text'] ) );
						else :
							the_content( esc_html( $instance['more_text'] ) );
						endif;					
					endif;
						
				echo '</div><!--end post_class()-->';
			endwhile;
		endif;
	
		echo $after_widget;		
	}

	function update($new_instance, $old_instance) {
		//save the widget				
		return $new_instance;
		//return $instance;
	}

	function form($instance) {

		//widgetform in backend
		$instance = wp_parse_args( (array)$instance, array(
			'title' => '',
			'post_type'=>'',
			'post_type_taxonomy' => '',
			'post_number' => 0,			
			'orderby' => '',
			'order' => '',
			'show_image' => 0,
			'image_alignment' => '',
			'image_size' => '',
			'show_gravatar' => 0,
			'gravatar_alignment' => '',
			'gravatar_size' => '',
			'show_title' => 0,
			'show_byline' => 0,
			'post_info' => '[post_date] ' . __('By', 'supreme') . ' [post_author_posts_link] [post_comments]',
			'show_content' => 'excerpt',
			'content_limit' => '',
			'more_text' => __('[Read More...]', 'supreme'),			
			) );
		

	?>
	<p>
	  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','supreme');?>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
	  </label>
	</p>
     <p>
    	<label for="<?php echo $this->get_field_id('post_type');?>" ><?php _e('Select Post:','supreme');?>    	
    	<select  id="<?php echo $this->get_field_id('post_type'); ?>" name="<?php echo $this->get_field_name('post_type'); ?>" class="widefat">        	
    <?php
		$all_post_types = get_post_types();
		foreach($all_post_types as $post_types){
			if( $post_types != "page" && $post_types != "attachment" && $post_types != "revision" && $post_types != "nav_menu_item" ){
				?>
                	<option value="<?php echo $post_types;?>" <?php if($post_types== $instance['post_type'])echo "selected";?>><?php echo esc_attr($post_types);?></option>
                <?php				
			}
		}
	?>	
    	</select>
    </label>
    </p>
    <p>   
    	<label for="<?php echo $this->get_field_id('post_type_taxonomy');?>" ><?php _e('Select Category:','supreme');?>    	
    	<select id="<?php echo $this->get_field_id('post_type_taxonomy'); ?>" name="<?php echo $this->get_field_name('post_type_taxonomy'); ?>" class="widefat" >      
        	<option value=""><?php _e('---Select Category wise recent post ---','supreme'); ?></option>
     <?php
			$taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );			
						foreach ( $taxonomies as $taxonomy ) {							
							$query_label = '';
							if ( !empty( $taxonomy->query_var ) )
								$query_label = $taxonomy->query_var;
							else
								$query_label = $taxonomy->name;
							
							if($taxonomy->labels->name!='Tags' && $taxonomy->labels->name!='Format' && !strstr($taxonomy->labels->name,'tag') && !strstr($taxonomy->labels->name,'Tags') && !strstr($taxonomy->labels->name,'format') && !strstr($taxonomy->labels->name,'Shipping Classes')&& !strstr($taxonomy->labels->name,'Order statuses')&& !strstr($taxonomy->labels->name,'genre')&& !strstr($taxonomy->labels->name,'platform') && !strstr($taxonomy->labels->name,'colour') && !strstr($taxonomy->labels->name,'size')):	
								?>
                                <optgroup label="<?php echo esc_attr( $taxonomy->object_type[0])."-".esc_attr($taxonomy->labels->name); ?>">
                                    <?php
									$terms = get_terms( $taxonomy->name, 'orderby=name&hide_empty=0' );
									foreach ( $terms as $term ) {		
									$term_value=$term->term_id;	?>
									<option style="margin-left: 8px; padding-right:10px;" value="<?php echo $term_value ?>" <?php if($instance['post_type_taxonomy']==$term_value) echo "selected";?>><?php echo '-' . esc_attr( $term->name ); ?></option><?php } ?>                                    </optgroup>
                                <?php
								endif;								
						}			
		?>
        	</select>
    </label>
    </p>
	<p>
	  <label for="<?php echo $this->get_field_id('post_number'); ?>"><?php _e('Number of posts:','supreme');?>
	  <input class="widefat" id="<?php echo $this->get_field_id('post_number'); ?>" name="<?php echo $this->get_field_name('post_number'); ?>" type="text" value="<?php echo $instance['post_number']; ?>" />
	  </label>
	</p>	
    <p>
    <label for="<?php echo $this->get_field_id('orderby'); ?>"><?php _e('Order By', 'supreme'); ?>:</label>
        <select id="<?php echo $this->get_field_id('orderby'); ?>" name="<?php echo $this->get_field_name('orderby'); ?>">
        <option style="padding-right:10px;" value="date" <?php selected('date', $instance['orderby']); ?>><?php _e('Date', 'supreme'); ?></option>
        <option style="padding-right:10px;" value="title" <?php selected('title', $instance['orderby']); ?>><?php _e('Title', 'supreme'); ?></option>
        <option style="padding-right:10px;" value="parent" <?php selected('parent', $instance['orderby']); ?>><?php _e('Parent', 'supreme'); ?></option>
        <option style="padding-right:10px;" value="ID" <?php selected('ID', $instance['orderby']); ?>><?php _e('ID', 'supreme'); ?></option>
        <option style="padding-right:10px;" value="comment_count" <?php selected('comment_count', $instance['orderby']); ?>><?php _e('Comment Count', 'supreme'); ?></option>
        <option style="padding-right:10px;" value="rand" <?php selected('rand', $instance['orderby']); ?>><?php _e('Random', 'supreme'); ?></option>
    </select>
    </p>
    <p>
    	<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Sort Order', 'supreme'); ?>:</label>
        <select id="<?php echo $this->get_field_id('order'); ?>" name="<?php echo $this->get_field_name('order'); ?>">
            <option style="padding-right:10px;" value="DESC" <?php selected('DESC', $instance['order']); ?>><?php _e('Descending (3, 2, 1)', 'supreme'); ?></option>
            <option style="padding-right:10px;" value="ASC" <?php selected('ASC', $instance['order']); ?>><?php _e('Ascending (1, 2, 3)', 'supreme'); ?></option>
        </select>
    </p>
    <p>
            <input id="<?php echo $this->get_field_id('show_gravatar'); ?>" type="checkbox" name="<?php echo $this->get_field_name('show_gravatar'); ?>" value="1" <?php checked(1, $instance['show_gravatar']); ?>/> <label for="<?php echo $this->get_field_id('show_gravatar'); ?>"><?php _e('Show Author Gravatar', 'supreme'); ?></label>
        
        <label for="<?php echo $this->get_field_id('gravatar_size'); ?>"><?php _e('Gravatar Size', 'supreme'); ?>:</label>
        <select id="<?php echo $this->get_field_id('gravatar_size'); ?>" name="<?php echo $this->get_field_name('gravatar_size'); ?>">
            <option style="padding-right:10px;" value="45" <?php selected(45, $instance['gravatar_size']); ?>><?php _e('Small (45px)', 'supreme'); ?></option>
            <option style="padding-right:10px;" value="65" <?php selected(65, $instance['gravatar_size']); ?>><?php _e('Medium (65px)', 'supreme'); ?></option>
            <option style="padding-right:10px;" value="85" <?php selected(85, $instance['gravatar_size']); ?>><?php _e('Large (85px)', 'supreme'); ?></option>
            <option style="padding-right:10px;" value="125" <?php selected(125, $instance['gravatar_size']); ?>><?php _e('Extra Large (125px)', 'supreme'); ?></option>
        </select>
    </p>
    <p>
		<input id="<?php echo $this->get_field_id('show_image'); ?>" type="checkbox" name="<?php echo $this->get_field_name('show_image'); ?>" value="1" <?php checked(1, $instance['show_image']); ?>/> <label for="<?php echo $this->get_field_id('show_image'); ?>"><?php _e('Show Featured Image', 'supreme'); ?></label>
        
        <label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size', 'supreme'); ?>:</label>
        <?php 
			global $_wp_additional_image_sizes;
			if ( $_wp_additional_image_sizes ){
				$sizes = $_wp_additional_image_sizes;
			}else{
				$sizes = array();
			}	
		?>
        <select id="<?php echo $this->get_field_id('image_size'); ?>" name="<?php echo $this->get_field_name('image_size'); ?>">
            <option style="padding-right:10px;" value="thumbnail">thumbnail (<?php echo get_option('thumbnail_size_w'); ?>x<?php echo get_option('thumbnail_size_h'); ?>)</option>
            <?php
            foreach((array)$sizes as $name => $size) :
            echo '<option style="padding-right: 10px;" value="'.esc_attr($name).'" '.selected($name, $instance['image_size'], FALSE).'>'.esc_html($name).' ('.$size['width'].'x'.$size['height'].')</option>';
            endforeach;
            ?>
        </select>
    </p>
    <p>
        <input id="<?php echo $this->get_field_id('show_title'); ?>" type="checkbox" name="<?php echo $this->get_field_name('show_title'); ?>" value="1" <?php checked(1, $instance['show_title']); ?>/> 
        <label for="<?php echo $this->get_field_id('show_title'); ?>"><?php _e('Show Post Title', 'supreme'); ?></label>
    </p>
   <p>
        <label for="<?php echo $this->get_field_id('show_content'); ?>"><?php _e('Content Type', 'supreme'); ?>:</label>
        <select id="<?php echo $this->get_field_id('show_content'); ?>" name="<?php echo $this->get_field_name('show_content'); ?>">
        <option value="content" <?php selected('content' , $instance['show_content'] ); ?>><?php _e('Show Content', 'supreme'); ?></option>
        <option value="excerpt" <?php selected('excerpt' , $instance['show_content'] ); ?>><?php _e('Show Excerpt', 'supreme'); ?></option>
        <option value="content-limit" <?php selected('content-limit' , $instance['show_content'] ); ?>><?php _e('Show Content Limit', 'supreme'); ?></option>
        <option value="" <?php selected('' , $instance['show_content'] ); ?>><?php _e('No Content', 'supreme'); ?></option>
        </select>
   </p>
   <p>
        <label for="<?php echo $this->get_field_id('content_limit'); ?>"><?php _e('Limit content to', 'supreme'); ?></label> <input type="text" id="<?php echo $this->get_field_id('image_alignment'); ?>" name="<?php echo $this->get_field_name('content_limit'); ?>" value="<?php echo esc_attr(intval($instance['content_limit'])); ?>" size="3" /> <?php _e('characters', 'supreme'); ?>
	</p>
    <p>        
        <label for="<?php echo $this->get_field_id('more_text'); ?>"><?php _e('More Text (if applicable)', 'supreme'); ?>:</label>
        <input type="text" id="<?php echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" value="<?php echo esc_attr($instance['more_text']); ?>" />
    </p>
	<?php
	}
}
/*
 * templatic recent post widget init
 */
add_action( 'widgets_init', create_function('', 'return register_widget("templatic_recent_post");') );
/*
 * Function Name:the_content_limit
 * Return : Display the limited content
 */
function the_content_limit($max_char, $more_link_text = 'Read More ->', $stripteaser = true, $more_file = '') {	
	global $post;
	$content = do_shortcode(get_the_content());
	$content = strip_tags($content);
	$content = substr($content, 0, $max_char);
	$content = substr($content, 0, strrpos($content, " "));
	$more_link_text='<a href="'.get_permalink().'">'.$more_link_text.'</a>';
	$content = $content." ".$more_link_text;
	echo $content;	
}
/* 
 * Function name: featured_get_image
 * Return: pass post image;
 */

function featured_get_image($arg)
{
	global $post;
	if($arg['format']=='html')
	{
		get_the_image(array('post_id'=>$post->ID,'size'=>$arg['size'],'image_class'=>'img','default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png"));					
	}else
	{
		get_the_image(array('post_id'=>$post->ID,'size'=>$arg['size'],'image_class'=>'img','default_image'=>get_stylesheet_directory_uri()."/images/img_not_available.png", 'format'=>''));									
	}	
}


/*
 * Create the templatic facebook post widget
 */
	
class templatic_facebook extends WP_Widget {
	function templatic_facebook() {
		//Constructor
		$widget_ops = array('classname' => __('widget Templatic facebook fans t_facebook_fans','supreme'), 'description' => __('Show your facebook fans on your site.','supreme') );
		$this->WP_Widget('templatic_facebook', __('T &rarr; Facebook Fans','supreme'), $widget_ops);
	}
	
	function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
			$facebook_page_url = empty($instance['facebook_page_url']) ? '' : apply_filters('widget_facebook_page_url', $instance['facebook_page_url']);
			$width = empty($instance['width']) ? '' : apply_filters('widget_width', $instance['width']);
			$show_faces = empty($instance['show_faces']) ? '' : apply_filters('widget_show_faces', $instance['show_faces']);
			$show_stream = empty($instance['show_stream']) ? '' : apply_filters('widget_show_stream', $instance['show_stream']);
			$show_header = empty($instance['show_header']) ? '' : apply_filters('widget_show_header', $instance['show_header']);
			
			
			if($show_faces == 1) $face='true'; else $face='false';
			if($show_stream == 1) $stream='true'; else $stream='false';
			if($show_header == 1) $header='true'; else $header='false';
			
			if(isset($_SERVER['HTTPS']))
			{
				if ($_SERVER["HTTPS"] == "on") 
				{
					$fb_url = 'https://connect.facebook.net/en_US/all.js#xfbml=1';
				}
			}
			else
			{
				$fb_url = 'http://connect.facebook.net/en_US/all.js#xfbml=1';
			}
			
			?>		 
			<div id="fb-root"></div><script src="<?php echo $fb_url; ?>"></script><fb:like-box href="<?php echo $facebook_page_url; ?>" width="<?php echo $width; ?>" show_faces="<?php echo $face; ?>" border_color="" stream="<?php echo $stream; ?>" header="<?php echo $header; ?>"></fb:like-box>
         
		<?php
		echo $after_widget;		
	}
	function update($new_instance, $old_instance) {
		//save the widget
		$instance = $old_instance;
		$instance['facebook_page_url'] = strip_tags($new_instance['facebook_page_url']);
		$instance['width'] = strip_tags($new_instance['width']);
		$instance['show_faces'] = strip_tags($new_instance['show_faces']);
		$instance['show_stream'] = strip_tags($new_instance['show_stream']);
		$instance['show_header'] = strip_tags($new_instance['show_header']);			
		return $instance;

	}
	function form($instance) {
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array('width'=>'', 'facebook_page_url'=>'', 'show_faces'=>'', 'show_stream'=>'', 'show_header'=>'' ) );
			$facebook_page_url = strip_tags($instance['facebook_page_url']);
			$width = strip_tags($instance['width']);
			$show_faces = strip_tags($instance['show_faces']);
			$show_stream = strip_tags($instance['show_stream']);
			$show_header = strip_tags($instance['show_header']);
			
	?>
        <p>
          <label for="<?php echo $this->get_field_id('facebook_page_url'); ?>"><?php  _e('Facebook Page Full URL','supreme')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('facebook_page_url'); ?>" name="<?php echo $this->get_field_name('facebook_page_url'); ?>" type="text" value="<?php echo esc_attr($facebook_page_url); ?>" />
          </label>
        </p>        
        <p>
          <label for="<?php echo $this->get_field_id('width'); ?>"><?php  _e('Width','supreme')?>:
            <input class="widefat" id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
          </label>
        </p> 
		<p>
		  <label for="<?php echo $this->get_field_id('show_faces'); ?>"><?php  _e('Show Faces','supreme')?>:
		  <select id="<?php echo $this->get_field_id('show_faces'); ?>" name="<?php echo $this->get_field_name('show_faces'); ?>" style="width:50%;">
			  <option value="1" <?php if(esc_attr($show_faces)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','supreme'); ?></option>
			  <option value="0" <?php if(esc_attr($show_faces)=='0'){ echo 'selected="selected"';}?>><?php _e('No','supreme'); ?></option>
		  </select>
		  </label>
		</p>		
		<p>
          <label for="<?php echo $this->get_field_id('show_stream'); ?>"><?php  _e('Show Stream','supreme')?>:
          <select id="<?php echo $this->get_field_id('show_stream'); ?>" name="<?php echo $this->get_field_name('show_stream'); ?>" style="width:50%;">
			  <option value="1" <?php if(esc_attr($show_stream)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','supreme'); ?></option>
			  <option value="0" <?php if(esc_attr($show_stream)=='0'){ echo 'selected="selected"';}?>><?php _e('No','supreme'); ?></option>
		  </select>
          </label>
        </p>
		<p>
          <label for="<?php echo $this->get_field_id('show_header'); ?>"><?php  _e('Show Header','supreme')?>:
            <select id="<?php echo $this->get_field_id('show_header'); ?>" name="<?php echo $this->get_field_name('show_header'); ?>" style="width:50%;">
			  <option value="1" <?php if(esc_attr($show_header)=='1'){ echo 'selected="selected"';}?>><?php _e('Yes','supreme'); ?></option>
			  <option value="0" <?php if(esc_attr($show_header)=='0'){ echo 'selected="selected"';}?>><?php _e('No','supreme'); ?></option>
			</select>
          </label>
        </p>
       
	<?php
		
	}
}


/*
 * templatic templatic facebook widget init
 */
add_action( 'widgets_init', create_function('', 'return register_widget("templatic_facebook");') );


/*
 * Create the templatic advertisement widget
 */
	
class templatic_advertisements extends WP_Widget {
	function templatic_advertisements() {
	//Constructor
		$widget_ops = array('classname' => __('widget Templatic Advertisements','supreme'), 'description' => __('Show the advertisements, Here you can use HTML, JavaScript, or an IFrame too. ','supreme') );
		$this->WP_Widget('templatic_advertisements', __('T &rarr; Advertisements','supreme'), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget

		extract($args, EXTR_SKIP);
		echo $before_widget;
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
		$ads = empty($instance['ads']) ? '' : $instance['ads'];
		if ( $title <> "" ) { 
			echo ' <h3 class="widget-title">'.$title.'</h3>';
		}
		?>
        <div class="advertisements">
			<?php echo $ads; ?>
        </div>
        <?php
		echo $after_widget;		
	}

	function update($new_instance, $old_instance) {
	//save the widget
		$instance = $old_instance;		
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['ads'] = $new_instance['ads'];
		return $instance;
	}

	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'ads' => '') );		
		$title = strip_tags($instance['title']);
		$ads = ($instance['ads']);
	?>
	<p>
    	<label for="<?php  echo $this->get_field_id('title'); ?>"><?php _e('Title','supreme');?>: 
        <input class="widefat" id="<?php  echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
    </p>     
	<p>
    	<label for="<?php echo $this->get_field_id('ads'); ?>">
			<?php _e('Advertisement code <small>(ex.&lt;a href="#"&gt;&lt;img src="http://templatic.com/banner.png" /&gt;&lt;/a&gt; and google ads code here )</small>','supreme');?>: 
       		<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('ads'); ?>" name="<?php echo $this->get_field_name('ads'); ?>"><?php echo $ads; ?></textarea>
       	</label>
    </p>
	<?php
	}
}
/*
 * templatic advertisements widget init
 */
add_action( 'widgets_init', create_function('', 'return register_widget("templatic_advertisements");') );
if(function_exists('check_if_woocommerce_active')){
	$is_woo_active = check_if_woocommerce_active();
	if($is_woo_active == 'true'){
		register_sidebars(1,array('name' => 'WooCommerce Sidebar','id' => 'woocommerce_sidebar','before_widget' => 	'<div id="%1$s" class="widget %2$s "><div class="widget-wrap widget-inside">', 'after_widget' => 		'</div></div>','before_title' => '<h3>','after_title' => '</h3>'));
		add_theme_support( 'woocommerce' );
	}
}
?>
