<?php
/*-- Function to fetch images in particular specified size BOF --*/
function bdw_get_images_with_info($iPostID,$img_size='thumb'){
	$arrImages =& get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . $iPostID );
	$return_arr = array();
	if (has_post_thumbnail( $iPostID )){
		if($img_size == 'large'){
			$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id($iPostID),'full' );	// THE FULL SIZE IMAGE INSTEAD
			$imgarr['id'] = get_post_thumbnail_id($iPostID);
			$imgarr['file'] = $img_arr[0];
			$return_arr[] = $imgarr;
		}elseif($img_size == 'medium'){
			$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id($iPostID), 'medium'); //THE medium SIZE IMAGE INSTEAD
			$imgarr['id'] = get_post_thumbnail_id($iPostID);
			$imgarr['file'] = $img_arr[0];
			$return_arr[] = $imgarr;
		}elseif($img_size == 'thumb'){
			$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id($iPostID), 'thumbnail'); // Get the thumbnail url for the attachment
			$imgarr['id'] = get_post_thumbnail_id($iPostID);
			$imgarr['file'] = $img_arr[0];
			$return_arr[] = $imgarr;
		}elseif($img_size == 'discount_thumbs'){
			$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id($iPostID), 'discount_thumbs'); // Get the thumbnail url for the attachment
			$imgarr['id'] = get_post_thumbnail_id($iPostID);
			$imgarr['file'] = $img_arr[0];
			$return_arr[] = $imgarr;
		}else{
			$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id($iPostID),$img_size);	// THE FULL SIZE IMAGE INSTEAD
			$imgarr['id'] = get_post_thumbnail_id($iPostID);
			$imgarr['file'] = $img_arr[0];
			$return_arr[] = $imgarr;
		}
	}
	if($arrImages){
		foreach($arrImages as $key=>$val){	
			$id = $val->ID;
			if($img_size == 'large'){
				$img_arr = wp_get_attachment_image_src($id,'full');	// THE FULL SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}elseif($img_size == 'medium'){
				$img_arr = wp_get_attachment_image_src($id, 'medium'); //THE medium SIZE IMAGE INSTEAD
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
			}elseif($img_size == 'thumb'){
				$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
				
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'discount_thumbs'){
				$img_arr = wp_get_attachment_image_src($id, 'discount_thumbs'); // Get the discount_thumbs url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'category_thumbs'){
			
				$img_arr = wp_get_attachment_image_src($id, 'category_thumbs'); // Get the category_thumbs url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'small_slider_thumbs'){
				$img_arr = wp_get_attachment_image_src($id, 'small_slider_thumbs'); // Get the small_slider_thumbs url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'home_slider'){
				$img_arr = wp_get_attachment_image_src($id, 'home_slider'); // Get the home_slider url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}elseif($img_size == 'widget_slider_thumbs'){
				$img_arr = wp_get_attachment_image_src($id, 'widget_slider_thumbs'); // Get the widget_slider_thumbs url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
			elseif($img_size == 'widget_slider_thumbs'){
				$img_arr = wp_get_attachment_image_src($id, 'widget_slider_thumbs'); // Get the widget_slider_thumbs url for the attachment
				//print_r($img_arr);
				$imgarr['id'] = $id;
				$imgarr['file'] = $img_arr[0];
				$return_arr[] = $imgarr;
				
			}
		}
	}
	return $return_arr;
}
/**-- Function to fetch images in particular specified size EOF --**/
	
/*	Function to get the post by post title START  */
	function get_post_by_title($post_title, $output = OBJECT) {
		global $wpdb;
		$post = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_title like %s AND post_type='shop_coupon' and post_status='publish'", $post_title ));
		if ( $post )
			return get_post($post, $output);

		return null;
	}
/*	Function to get the post by post title END  */


/*	Function to add theme color settings options in wordpress customizer START	*/
	function catalog_register_customizer_settings($wp_customize){
		/*	Add Settings START */
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color1]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"catalog_customize_supreme_color1",
				'sanitize_js_callback' => 	"catalog_customize_supreme_color1",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color2]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"catalog_customize_supreme_color2",
				'sanitize_js_callback' => 	"catalog_customize_supreme_color2",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color3]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"catalog_customize_supreme_color3",
				'sanitize_js_callback' => 	"catalog_customize_supreme_color3",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color4]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"catalog_customize_supreme_color4",
				'sanitize_js_callback' => 	"catalog_customize_supreme_color4",
				//'transport' => 'postMessage',
			));
			
			$wp_customize->add_setting('supreme_theme_settings[color_picker_color5]',array(
				'default' => '',
				'type' => 'option',
				'capabilities' => 'edit_theme_options',
				'sanitize_callback' => 	"catalog_customize_supreme_color5",
				'sanitize_js_callback' => 	"catalog_customize_supreme_color5",
				//'transport' => 'postMessage',
			));
			
		/* Add Control START */	
		/*
			Primary: 	 Effect on buttons, links and main headings.
			Secondary: 	 Effect on sub-headings.
			Content: 	 Effect on content.
			Sub-text: 	 Effect on sub-texts.
			Background:  Effect on body & menu background. 
		
		*/
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color1', array(
				'label'   => __( 'Primary:', 'templatic' ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color1]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color2', array(
				'label'   => __( 'Secondary:', 'templatic' ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color2]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color3', array(
				'label'   => __( 'Footer:', 'templatic' ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color3]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color4', array(
				'label'   => __( 'Headings:', 'templatic' ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color4]',
			) ) );
			
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'color_picker_color5', array(
				'label'   => __( 'Subtext:', 'templatic' ),
				'section' => 'colors',
				'settings'   => 'supreme_theme_settings[color_picker_color5]',
			) ) );
	}		

	/*  Handles changing settings for the live preview of the theme START.  */	
	function catalog_customize_supreme_color1( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color1]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "catalog_customize_supreme_color1", $setting, $object );
	}	
	function catalog_customize_supreme_color2( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color2]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "catalog_customize_supreme_color2", $setting, $object );
	}	
	function catalog_customize_supreme_color3( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color3]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "catalog_customize_supreme_color3", $setting, $object );
	}	
	function catalog_customize_supreme_color4( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color4]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "catalog_customize_supreme_color4", $setting, $object );
	}
	function catalog_customize_supreme_color5( $setting, $object ) {
		
		/* Make sure we kill evil scripts from users without the 'unfiltered_html' cap. */
		if ( "supreme_theme_settings[color_picker_color5]" == $object->id && !current_user_can( 'unfiltered_html' )  )
			$setting = stripslashes( wp_filter_post_kses( addslashes( $setting ) ) );
		/* Return the sanitized setting and apply filters. */
		return apply_filters( "catalog_customize_supreme_color5", $setting, $object );
	}


/*	Function to add theme color settings options in wordpress customizer END	*/

/*	Function to display form in meta box in backend theme settings START	*/	
function add_nivoslider_js(){
		 wp_enqueue_script('flexslider', get_stylesheet_directory_uri()."/js/jquery.flexslider-min.js");
}

/*	Function to display form in meta box in backend theme settings END	*/	

/*	 Add The Metabox for post type selection for archive page template. START	*/
if(!function_exists('ptthemes_taxonomy_meta_box')){
	function ptthemes_taxonomy_meta_box() {
		add_meta_box("post_type_meta", "Post type options", "post_type_meta_box", "page", "side", "default");
	}	
}
function post_type_meta_box(){ ?>
	<script type="text/javascript">
		jQuery.noConflict(); 
		jQuery(document).ready(function() {
		var page_template = jQuery("#page_template").val();
		if(page_template !='page-template-archives.php'){
			jQuery("#post_type_meta").css('display','none');
		}
		jQuery("#page_template").change(function() {
			var src = jQuery(this).val();
				if(jQuery("#page_template").val() =='page-template-archives.php'){
				jQuery("#post_type_meta").fadeIn(2000); }else{
				jQuery("#post_type_meta").fadeOut(2000);
				}
			});
		});
	</script>
<?php
		$custom_post_types_args = array();  
		$custom_post_types = get_post_types($custom_post_types_args,'objects');   
		global $post;
		foreach ($custom_post_types as $content_type) 
		{
			if($content_type->name!='nav_menu_item' && $content_type->name!='attachment' && $content_type->name!='revision' && $content_type->name!='product_variation' && $content_type->name!='shop_order' && $content_type->name!='shop_coupon'){
				$template_post_type = "";
				$template_post_type = get_post_meta($post->ID,'template_post_type',true);
				if(isset($template_post_type) && !empty($template_post_type)){
					$template_post_type = $template_post_type;
				}else{
					$template_post_type = "post";
				}
				if($template_post_type == $content_type->name){ $c = 'checked=checked';}else{ $c=''; }
				echo "<input type='radio' name='template_post_type' id='".$content_type->name."' value='".$content_type->name."' $c/> ".ucfirst($content_type->name)."<br/>"; 
			}
		}	
}

function catalog_insert_post_type(){
	global $globals,$wpdb;
	update_post_meta(@$_POST['post_ID'], 'template_post_type', @$_POST['template_post_type']);
}
/*	 Add The Metabox for post type selection for archive page template. END	*/

function call_function(){
	// Remove Default jigoshop sidebar
		remove_action('jigoshop_sidebar', 'jigoshop_get_sidebar');
	// Remove Default jigoshop sidebar
	
	/*	Removed the navigation menu option which are not in used in this theme.	*/
	unregister_nav_menu( 'header-primary');
	unregister_nav_menu( 'header-secondary');
	unregister_nav_menu( 'header-horizontal');
	unregister_nav_menu( 'footer');
	unregister_nav_menu( 'subsidiary');
	
	/*	Removed the sidebars which are not in used in this theme.	*/
	unregister_sidebar('header');
	unregister_sidebar('subsidiary');
	unregister_sidebar('subsidiary-2c');
	unregister_sidebar('subsidiary-3c');
	unregister_sidebar('subsidiary-4c');
	unregister_sidebar('subsidiary-5c');
	unregister_sidebar('entry');
	unregister_sidebar('after-header-5c');
	unregister_sidebar('widgets-template');
	unregister_sidebar('after-header-2c');
	unregister_sidebar('after-header-3c');
	unregister_sidebar('after-header-4c');
}
/*	Conditions for WooCommerce / Jigoshop plugin START	*/
if(!function_exists("is_wooCommerce_plugin")){
	function is_wooCommerce_plugin(){
		if(is_plugin_active('woocommerce/woocommerce.php')){
			return true;
		}else{
			return false;
		}
	}
}	
if(!function_exists("is_jigoshop_plugin")){
	function is_jigoshop_plugin(){
		if(is_plugin_active('jigoshop/jigoshop.php')){
			return true;
		}else{
			return false;
		}
	}
}
if(!function_exists("woo_jigo_product_price")){
	function woo_jigo_product_price(){
		$price = "";
		if(is_wooCommerce_plugin()){
			global $product;
			$price = $product->get_price_html();
		}elseif(is_jigoshop_plugin()){
			$_product = new jigoshop_product( get_the_ID() );
			$price = $_product->get_price_html();
		}else{
			$price = "";
		}
		return $price;
	}
}
if(!function_exists("woo_jigo_sale_image")){
	function woo_jigo_sale_image(){
		$sale_image = "";
		if(is_wooCommerce_plugin()){
			global $product;
			if ($product->is_on_sale()){
				$sale_image = apply_filters('woocommerce_sale_flash', '<span class="onsale">'.__('Sale', 'woocommerce').'</span>', $post, $product);
			}
		}elseif(is_jigoshop_plugin()){
			$sale_image = "";
		}else{
			$sale_image = "";
		}
		return $sale_image;
	}
}
if(!function_exists("woo_jigo_add_to_cart_button")){
	function woo_jigo_add_to_cart_button($post){
		if(is_wooCommerce_plugin()){
			do_action('woocommerce_after_shop_loop_item'); 
		}elseif(is_jigoshop_plugin()){
			$product_meta = get_post( $post->ID );
			$_product = new jigoshop_product( $product_meta->ID );
			jigoshop_template_loop_add_to_cart($product_meta, $_product);
		}
	}
}
/*	Conditions for WooCommerce / Jigoshop plugin END	*/






/* THEME UPDATE CODING START */
//Theme update templatic menu
function Catalog_tmpl_theme_update(){
	require_once(get_stylesheet_directory()."/templatic_login.php");
}


/* Theme update templatic menu*/
function Catalog_tmpl_support_theme(){
	echo "<h3>Need Help?</h3>";
	echo "<p>Here's how you can get help from templatic on any thing you need with regarding this theme. </p>";
	echo "<br/>";
	echo '<p><a href="http://templatic.com/docs/catalog-theme-guide/" target="blank">'."Take a look at theme guide".'</a></p>';
	echo '<p><a href="http://templatic.com/docs/" target="blank">'."Knowlegebase".'</a></p>';
	echo '<p><a href="http://templatic.com/forums/" target="blank">'."Explore our community forums".'</a></p>';
	echo '<p><a href="http://templatic.com/helpdesk/" target="blank">'."Create a support ticket in Helpdesk".'</a></p>';
}

/* Theme update templatic menu*/
function Catalog_tmpl_purchase_theme(){
	wp_redirect( 'http://templatic.com/wordpress-themes-store/' ); 
	exit;
}

add_action('admin_menu','Catalog_theme_menu',11); // add submenu page 
add_action('admin_menu','delete_Catalog_templatic_menu',11);
function Catalog_theme_menu(){
	
	add_submenu_page( 'templatic_menu', 'Theme Update','Theme Update', 'administrator', 'Catalog_tmpl_theme_update', 'Catalog_tmpl_theme_update',27 );
	
	add_submenu_page( 'templatic_menu', 'Framework Update','Framework Update', 'administrator', 'tmpl_framework_update', 'tmpl_framework_update',28 );
	
	add_submenu_page( 'templatic_menu', 'Get Support' ,'Get Support' , 'administrator', 'Catalog_tmpl_support_theme', 'Catalog_tmpl_support_theme',29 );
	
	add_submenu_page( 'templatic_menu', 'Purchase theme','Purchase theme', 'administrator', 'Catalog_tmpl_purchase_theme', 'Catalog_tmpl_purchase_theme',30 );
}


/*
	Realtr delete menu 
*/	
function delete_Catalog_templatic_menu(){
	remove_submenu_page('templatic_menu', 'templatic_menu'); 
}

/* THEME UPDATE CODING END */


?>