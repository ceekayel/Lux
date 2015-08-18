<?php
/* Custom fields for Video
Custom Settings */
global $tmpl_metaboxes; 
$tmpl_metaboxes = array(
		"video" => array (
			"name"		=> "video",
			"default" 	=> "",
			"label" 	=> __("Video Embed Code",'templatic'),
			"type" 		=> "textarea",
			"desc"      => __("Enter video embed code from Youtube, Vimeo or other video sites.",'templatic')
		),
		"oembed_video" => array (
			"name"		=> "oembed",
			"default" 	=> "",
			"label" 	=> __("Video URL",'templatic'),
			"type" 		=> "text",
			"desc"      => __("Enter video URL code from Youtube, Vimeo or other video sites.",'templatic')
		),
		"oembed_autoplay" => array (
			"name"		=> "autoplay",
			"default" 	=> "",
			"label" 	=> __("Enable Auto Play",'templatic'),
			"type" 		=> "checkbox",
			"desc"      => __("Autoplay will not work with videos embedded code.",'templatic')
		),
                "is_downloadable" => array (
			"name"		=> "is_downloadable",
			"default" 	=> "",
			"label" 	=> __("Is downloadable",'templatic'),
			"type" 		=> "general_checkbox",
			"desc"      => __("Download link only work with attach media video.",'templatic')
		)
	);


/*
 set the custom fields for video's post type 
*/

function tmpl_video_meta_box_content() {
    global $post, $tmpl_metaboxes;
    $output = '';
    $output .= '<div class="tmpl_metaboxes_table">'."\n";
	/* $tmpl_metaboxes - return the array of custom fields , if want to add or remove change in global array */
    foreach ($tmpl_metaboxes as $pt_id => $tmpl_metabox) {
    if($tmpl_metabox['type'] == 'text' OR $tmpl_metabox['type'] == 'select' OR $tmpl_metabox['type'] == 'checkbox' OR $tmpl_metabox['type'] == 'textarea' OR $tmpl_metabox['type'] == 'general_checkbox')
            $tmpl_metaboxvalue = get_post_meta($post->ID,$tmpl_metabox["name"],true);
            if ($tmpl_metaboxvalue == "" || !isset($tmpl_metaboxvalue)) {
                $tmpl_metaboxvalue = $tmpl_metabox['default'];
            }
            /* for text box */
            if($tmpl_metabox['type'] == 'text'){
				$option = '';
				if($tmpl_metabox["name"] == 'oembed')
				{
					$option = __("OR","templatic");
				}
                $output .= "\t".'<div>'.$option;
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$tmpl_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><input size="100" class="pt_input_text" type="'.$tmpl_metabox['type'].'" value="'.$tmpl_metaboxvalue.'" name="ptthemes_'.$tmpl_metabox["name"].'" id="'.$pt_id.'"/></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$tmpl_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
             /* for text area */
            elseif ($tmpl_metabox['type'] == 'textarea'){
            			
				$output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$tmpl_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><textarea rows="5" cols="98" class="pt_input_textarea" name="ptthemes_'.$tmpl_metabox["name"].'" id="'.$pt_id.'">' . $tmpl_metaboxvalue . '</textarea></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$tmpl_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
                              
            }
 			/* for select box */
            elseif ($tmpl_metabox['type'] == 'select'){
                            
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><p><strong><label for="'.$pt_id.'">'.$tmpl_metabox['label'].'</label></strong></p>'."\n";
                $output .= "\t\t".'<p><select class="pt_input_select" id="'.$pt_id.'" name="ptthemes_'. $tmpl_metabox["name"] .'"></p>'."\n";
                $output .= '<option>Select a Upload</option>';
                
                $array = $tmpl_metabox['options'];
                
                if($array){
                    foreach ( $array as $id => $option ) {
                        $selected = '';
                        if($tmpl_metabox['default'] == $option){$selected = 'selected="selected"';} 
                        if($tmpl_metaboxvalue == $option){$selected = 'selected="selected"';}
                        $output .= '<option value="'. $option .'" '. $selected .'>' . $option .'</option>';
                    }
                }
                
                $output .= '</select><p><span style="font-size:11px">'.$tmpl_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";
            }
             /* for check boxes */
            elseif ($tmpl_metabox['type'] == 'checkbox'){
                if($tmpl_metaboxvalue == 'on') { $checked = 'checked="checked"';} else {$checked='';}
                
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><label for="'.$pt_id.'">';
                $output .= "\t\t".'<input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" name="ptthemes_'. $tmpl_metabox["name"] .'" />'.$tmpl_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$tmpl_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";

            }elseif ($tmpl_metabox['type'] == 'general_checkbox'){
                if($tmpl_metaboxvalue == 'on') { $checked = 'checked="checked"';} else {$checked='';}
                
                $output .= "\t".'<div>';
                $output .= "\t\t".'<br/><label for="'.$pt_id.'">';
                $output .= "\t\t".'<input type="checkbox" '.$checked.' class="pt_input_checkbox"  id="'.$pt_id.'" name="'. $tmpl_metabox["name"] .'" />'.$tmpl_metabox['label'].'</label></p>'."\n";
                $output .= "\t\t".'<p><span style="font-size:11px">'.$tmpl_metabox['desc'].'</span></p>'."\n";
                $output .= "\t".'</div>'."\n";

            }
        
        }
    
    $output .= '</div>'."\n\n";
    echo $output;
}
// Custom fields for WP write panel
// This code is to save the video custom settings

/* 
Save the value of video custom fields 
*/
function tmpl_video_metabox_insert() {
    global $tmpl_metaboxes, $globals,$pagenow;
    
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return ;	
    }
    
    if(isset($_POST['post_ID']) && $_POST['post_ID'] !='')
        $pID = $_POST['post_ID'];
    
    
    /* $tmpl_metaboxes - return the array of custom fields , if want to add or remove change in global array */
    if(!empty($tmpl_metaboxes)){
            foreach ($tmpl_metaboxes as $tmpl_metabox) { // On Save.. this gets looped in the header response and saves the values submitted
                    if($tmpl_metabox['type'] == 'text' OR $tmpl_metabox['type'] == 'select' OR $tmpl_metabox['type'] == 'checkbox' OR $tmpl_metabox['type'] == 'textarea') // Normal Type Things...
                    {
                            $var = "ptthemes_".$tmpl_metabox["name"]; //set prefix to the variables, to avoid the conflicts 
                            if (isset($_POST[$var])) {
                                    if( get_post_meta( $pID, $tmpl_metabox["name"] ) == "" )
                                            add_post_meta($pID, $tmpl_metabox["name"], $_POST[$var], true );
                                    elseif($_POST[$var] != get_post_meta($pID, $tmpl_metabox["name"], true))
                                            update_post_meta($pID, $tmpl_metabox["name"], $_POST[$var]);
                                    elseif($_POST[$var] == "")
                                            delete_post_meta($pID, $tmpl_metabox["name"], get_post_meta($pID, $tmpl_metabox["name"], true));
                            }

                            /* check box issue, if not seleted than this is not come in $_post so manual check and set it off */
                            if($var == 'ptthemes_autoplay'){
                                if(isset($_POST['ptthemes_autoplay'])){
                                    update_post_meta($pID, $tmpl_metabox["name"], 'on');
                                }else{
                                    update_post_meta($pID, $tmpl_metabox["name"], 'off');
                                }
                            }
                    }elseif($tmpl_metabox["name"] == 'is_downloadable'){
                                if(isset($_POST['is_downloadable'])){
                                    update_post_meta($pID, $tmpl_metabox["name"], 'on');
                                }else{
                                    update_post_meta($pID, $tmpl_metabox["name"], 'off');
                                }
                    } 
            }              
    }
}
/*
to add the custom meta boxes
*/
function tmpl_video_meta_box() {
    if ( function_exists('add_meta_box') ) {
		 add_meta_box('ptthemes-settings',wp_get_theme().' Custom Settings','tmpl_video_meta_box_content','videos','normal','high');
    }
}

add_action('admin_menu', 'tmpl_video_meta_box'); // add meta box
add_action('save_post_videos', 'tmpl_video_metabox_insert'); // save metabox content


/* 
get the image of the relevant size pass in argument if no size pass in argument it will return the thumbnail
*/
function tmpl_get_image_withinfo($iPostID,$img_size='thumb',$no_images='') 
{
	
    $arrImages = get_children('order=ASC&orderby=menu_order ID&post_type=attachment&post_mime_type=image&post_parent=' . @$iPostID );	
	$counter = 0;
	$return_arr = array();	
 
	if (has_post_thumbnail( $iPostID )){
		
		$img_arr = wp_get_attachment_image_src( get_post_thumbnail_id( $iPostID ), $img_size );
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
						$img_arr = wp_get_attachment_image_src($id, 'thumbnail'); // Get the thumbnail url for the attachment
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
		}else{
				$imgarr['id'] = 0;
				$imgarr['file'] = 'http://placehold.it/185x130/333333/999999&text=Thumbnail';
				$return_arr[] = $imgarr;
		}	
	}  return $return_arr;
}


/*
Return post pagination on detail page(previous & next post)
*/
function tmpl_get_post_pagination($post){ 
			

			if($post->post_type == CUSTOM_POST_TYPE){
				$prev_post = tmpl_get_adjacent_post($in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = CUSTOM_CATEGORY_SLUG );
				$next_post = tmpl_get_adjacent_post($in_same_term = false, $excluded_terms = '', $previous = false, $taxonomy = CUSTOM_CATEGORY_SLUG ); 
			}else{
				$prev_post = tmpl_get_adjacent_post($in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' );
				$next_post = tmpl_get_adjacent_post($in_same_term = false, $excluded_terms = '', $previous = false, $taxonomy = 'category' ); 
			}
        	

        	/* fetch previous post details */
        	if ($prev_post) : 
        			$prev_post_url = esc_url(get_permalink($prev_post->ID)); 
					$prev_post_title = $prev_post->post_title; 
					
					$post_images =  tmpl_get_image_withinfo($prev_post->ID,'listing-widget-thumb');   // get previous post image
					$post_images_x2 =  tmpl_get_image_withinfo($prev_post->ID,'listing-widget-retina-thumb');   // get previous post image retina
					$attachment_id = $post_images[0]['id'];
					$alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$title = $attach_data->post_title;
					
					if($title ==''){ $title = $prev_post->post_title; }
					
					if($alt ==''){ $alt = $prev_post->post_title; }
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'listing-widget-thumb' ); // get the previous post image src
					$image_x2 = wp_get_attachment_image_src( get_post_thumbnail_id( $prev_post->ID ), 'listing-widget-retina-thumb' ); // get the retina previous post image src
					
					if(isset($image[0]) && $image[0]!=''){
						 $prev_post_images = $image[0];
						 $prev_post_images_x2 = $image_x2[0];
					}elseif($post_images[0]['file']){	
						$prev_post_images =$post_images[0]['file'];
						$prev_post_images_x2 =$post_images_x2[0]['file'];
					
					}else{
						$prev_post_images = get_template_directory_uri()."/images/img_not_available.png";
					}
		?>
	  
	   	<!-- Previous post html -->
        <div class="small-6 columns prev-icon">
					    		
					<div class="small-3 hide-for-xsmall-only show-for-medium-up columns">
						<a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>"><i class="fa fa-chevron-left step"></i><img style="max-height:50px;max-width:75px; width:100%; height:auto;" data-interchange="[<?php echo $prev_post_images; ?>, (default)], [<?php echo $prev_post_images_x2; ?>, (retina)]" alt="<?php echo $prev_post_title; ?>" /></a>
					</div>
					<div class="medium-9 small-12 columns">
					    <span><?php _e('Previous Video','templatic');?></span>
					    <h6><a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>"><?php echo $prev_post->post_title; ?></a></h6>
					</div>

		</div>
        <?php endif; 
		/* fetch Next post details */
        if ($next_post) : $next_post_url = esc_url(get_permalink($next_post->ID)); 

			        $post_nimages =  tmpl_get_image_withinfo($next_post->ID,'listing-widget-thumb');   
			        $post_nimages_x2 =  tmpl_get_image_withinfo($next_post->ID,'listing-widget-retina-thumb');   // - retina img
					$attachment_id = $post_nimages[0]['id'];
					$altn = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
					$attach_data = get_post($attachment_id);
					$next_post_title = $attach_data->post_title;

					if($next_post_title ==''){ $next_post_title = $next_post->post_title; }
					if($altn ==''){ $altn = $next_post->post_title; }

					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'listing-widget-thumb' ); // get next post image src
					$image_x2 = wp_get_attachment_image_src( get_post_thumbnail_id( $next_post->ID ), 'listing-widget-retina-thumb' ); // get next post image src - retina

					if(isset($image[0]) && $image[0]!=''){
						 $next_post_images = $image[0];
						 $next_post_images_x2 = $image_x2[0];
					}elseif($post_nimages[0]['file']){
							$next_post_images = $post_nimages[0]['file'];
							$next_post_images_x2 = $post_nimages_x2[0]['file'];
					}else{
						$next_post_images = get_stylesheet_directory_uri()."/images/img_not_available.png";
					} ?>
			  <!-- Next post html -->
    		  <div class="small-6 columns next-icon">
					
					<div class="medium-9 small-12 columns text-right">
					    <span><?php _e('Next Video','templatic');?></span>
					    <h6><a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><?php echo $next_post->post_title; ?></a></h6>
					</div>
					<div class="small-3 hide-for-xsmall-only show-for-medium-up columns">
							<a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"><img style="max-height:50px;max-width:75px; width:100%; height:auto;" data-interchange="[<?php echo $next_post_images; ?>, (default)], [<?php echo $next_post_images_x2; ?>, (retina)]" alt="<?php echo $next_post_title; ?>" /><i class="fa fa-chevron-right step"></i></a>
					</div>

				</div>
        <?php endif; ?>
      <?php
}

/*
Display the total views.
*/
function tmpl_get_post_views($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='' || $count== 0){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 ".__('View','templatic');
    }elseif($count== 1){
    	$viewtext = __('View','templatic');
    }else{
    	$viewtext = __('Views','templatic');    	
    }
    return $count.' '.$viewtext;
}

/*
Show the views on every refresh
*/
function tmpl_get_post_view($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count=='' || $count== 0){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 ";
    }
    return $count;
}
/*
Count and set the views on every refresh
*/
function tmpl_set_post_views($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// Remove issues with pre fetching adding extra views
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

/**
 Register the theme widget areas
 */
function tmpl_get_sidebars() {
	/* Set up an array of sidebars. */
	global $theme_sidebars,$plugin_sidebars;
	/* $theme_sidebars - Use when create the child category , it will use full to give the sequence to widget area*/
	if(empty($theme_sidebars))
	{
		$theme_sidebars = array(''); 
	}
	if(empty($plugin_sidebars))
	{
		$plugin_sidebars = array(''); 
	}
	
	$sidebars = array(
		'header_right' => array(
			'name' =>	__( 'Header Right', 'templatic' ),
			'description' =>	apply_filters('front_banner_desc',__( "The area is located on the right side of your menu (example serch widget).", 'templatic' )),
		),
		
		'offcanvas' => array(
			'name' => __('Offcanvas', 'templatic'),
			'description' => __('The offcanvas sidebar will appear on the left side when you click on the menu icon in devices with smaller widths.', 'templatic'),),
		
		'front_banner' => array(
			'name' =>	__( 'Front Banner', 'templatic' ),
			'description' =>	apply_filters('front_banner_desc',__( "The area is located just below your navigation in the content section, Video Slider widget should go here.", 'templatic' )),
		),
		'front_content' => array(
			'name' =>	apply_filters('front_content_title',__( 'Home Page - Content', 'templatic' )),
			'description' =>	__( "This is main content area on home page.", 'templatic' ),
		),	
		'sidebar1' => array(
			'name' => __('Primary Sidebar', 'templatic'),
			'description' => __('This sidebar will appear on all your WordPress pages.', 'templatic'),
		),
		'front_sidebar' => array(
			'name' =>	__( 'Home Page  - Sidebar', 'templatic' ),
			'description' =>	apply_filters('tmpl_home_page_widget_area_description',__('This area appears alongside the homepage sidebar.','templatic')),
		),	
				
		'post_category_sidebar' => array(
			'name' =>  __( 'Blog Listing Page - Sidebar', 'templatic' ),
			'description' => __( 'This sidebar will be shown on your blog and post category pages.', 'templatic' )
		),
		
		'post_detail_sidebar' => array(
			'name' =>  __( 'Blog Detail Page - Sidebar', 'templatic' ),
			'description' => __( 'This sidebar will show on detail (single) Post pages.', 'templatic' )
		),

		'video_category_sidebar' => array(
			'name' =>  __( 'Video Category Page - Sidebar', 'templatic' ),
			'description' => __( 'This sidebar will show on videos category pages.', 'templatic' )
		),
		
		'video_detail_sidebar' => array(
			'name' =>  __( 'Video Detail Page - Sidebar', 'templatic' ),
			'description' => __( 'This sidebar will show on video detail (single)  pages.', 'templatic' )
		),
		
		'footer_content' => array(
			'name' =>	__( 'Footer', 'templatic' ),
			'description' =>	__( 'Displays widgets inside the Footer in four columns.', 'templatic' ),
		),
                'video_submit_page' => array(
			'name' =>	__( 'Video Submit Page', 'templatic' ),
			'description' =>	__( 'This sidebar will be shown on your submit page left side.', 'templatic' ),
		)
	
	);
	
	$sidebars = array_merge($sidebars,$theme_sidebars,$plugin_sidebars);
	/* Return the sidebars. */
	
	return $sidebars;
}

/* Register widget areas. */
add_action( 'widgets_init', 'tmpl_register_sidebars' );
/*
 Name :tmpl_register_sidebars
 Description : Registers the theme supported sidebars 
*/

 function tmpl_register_sidebars() {
	/* Get the theme-supported sidebars. */
	$supported_sidebars = get_theme_support( 'tmpl-core-sidebars' );
	/* If the theme doesn't add support for any sidebars, return. */
	
	/* Get the available core framework sidebars. */
	$core_sidebars = tmpl_get_sidebars();
	/* Loop through the supported sidebars. */

	foreach ( $core_sidebars as $key=>$value ) {
	
		/* Make sure the given sidebar is one of the core sidebars. */
		if ( isset( $core_sidebars[$key] ) ) {
			/* Set up some default sidebar arguments. */
			$defaults = array(
				'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-wrap widget-inside">',
				'after_widget' => 	'</div></div>',
				'before_title' => 	'<h3 class="widget-title h2">',
				'after_title' => 	'</h3>'
			);
			/* Parse the sidebar arguments and defaults. */
			$args = wp_parse_args( $core_sidebars[$key], $defaults );
			/* If no 'id' was given, use the $sidebar variable and sanitize it. */
			$args['id'] = ( isset( $args['id'] ) ? sanitize_key( $args['id'] ) : sanitize_key( $key ) );
			/* Register the sidebar. */
		
			if(@$args['name'] !='')
				register_sidebar($args);
		}
	}
	
}

/* return post's author link */
function tmpl_get_the_author_posts_link($post){
	$userdata = get_userdata($post->post_author);
	return '<a href="'.get_author_posts_url($post->post_author).'">'.$userdata->display_name.'</a>';
}

/*
Display previous/next post pagination for detail page with different taxonomy.
*/
function tmpl_get_adjacent_post( $in_same_term = false, $excluded_terms = '', $previous = true, $taxonomy = 'category' ) {
	global $wpdb;

	if ( ( ! $post = get_post() ) || ! taxonomy_exists( $taxonomy ) )
		return null;

	$current_post_date = $post->post_date;

	$join = '';
	$posts_in_ex_terms_sql = '';
	/* Check if it should come from same term or from different */
	if ( $in_same_term || ! empty( $excluded_terms ) ) {
		$join = " INNER JOIN $wpdb->term_relationships AS tr ON p.ID = tr.object_id INNER JOIN $wpdb->term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";

		if ( $in_same_term ) {
			if ( ! is_object_in_taxonomy( $post->post_type, $taxonomy ) )
				return '';
			$term_array = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
			if ( ! $term_array || is_wp_error( $term_array ) )
				return '';
			$join .= $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id IN (" . implode( ',', array_map( 'intval', $term_array ) ) . ")", $taxonomy );
		}

		$posts_in_ex_terms_sql = $wpdb->prepare( "AND tt.taxonomy = %s", $taxonomy );
		if ( ! empty( $excluded_terms ) ) {
			if ( ! is_array( $excluded_terms ) ) {
				// back-compat, $excluded_terms used to be $excluded_terms with IDs separated by " and "
				if ( false !== strpos( $excluded_terms, ' and ' ) ) {
					_deprecated_argument( __FUNCTION__, '3.3', sprintf( __( 'Use commas instead of %s to separate excluded terms.',"templatic" ), "'and'" ) );
					$excluded_terms = explode( ' and ', $excluded_terms );
				} else {
					$excluded_terms = explode( ',', $excluded_terms );
				}
			}

			$excluded_terms = array_map( 'intval', $excluded_terms );

			if ( ! empty( $term_array ) ) {
				$excluded_terms = array_diff( $excluded_terms, $term_array );
				$posts_in_ex_terms_sql = '';
			}

			if ( ! empty( $excluded_terms ) ) {
				$posts_in_ex_terms_sql = $wpdb->prepare( " AND tt.taxonomy = %s AND tt.term_id NOT IN (" . implode( $excluded_terms, ',' ) . ')', $taxonomy );
			}
		}
	}

	$adjacent = $previous ? 'previous' : 'next';
	$op = $previous ? '<' : '>';
	$order = $previous ? 'DESC' : 'ASC';

	$join  = apply_filters( "get_{$adjacent}_post_join", $join, $in_same_term, $excluded_terms );
	$where = apply_filters( "get_{$adjacent}_post_where", $wpdb->prepare( "WHERE p.post_date $op %s AND p.post_type = %s AND p.post_status = 'publish' $posts_in_ex_terms_sql", $current_post_date, $post->post_type), $in_same_term, $excluded_terms );
	$sort  = apply_filters( "get_{$adjacent}_post_sort", "ORDER BY p.post_date $order LIMIT 1" );

	$query = "SELECT p.ID FROM $wpdb->posts AS p $join $where $sort";
	$query_key = 'adjacent_post_' . md5( $query );
	$result = wp_cache_get( $query_key, 'counts' );
	if ( false !== $result ) {
		if ( $result )
			$result = get_post( $result );
		return $result;
	}

	$result = $wpdb->get_var( $query );
	if ( null === $result )
		$result = '';

	wp_cache_set( $query_key, $result, 'counts' );

	if ( $result )
		$result = get_post( $result );

	return $result;
}

/* return mime type of the file */
if(!function_exists('tmpl_mime_content_type')) {

    function tmpl_mime_content_type($filename) {
		/* array of mime types */
        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',
            'mp4' => 'video/mp4',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
		if($filename !=''){
			$fname = explode('.',$filename);
			$ext = strtolower(array_pop($fname));
		}
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        }
        elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        }
        else {
            return 'application/octet-stream';
        }
    }
}

/* get customizer settings */
function tmpl_get_theme_settings($option=''){
	$theme_settings = get_option('templatic_theme_settings');	
	if(isset($theme_settings[$option]) && $theme_settings[$option] != '')
		return $theme_settings[$option];
	else
		return false;
}
/*
 * Filter for auto play the oembeded code.
 */
function video_autoplay($code,$url, $args){
	$newargs = $args;
	// get rid of discover=true argument
	
	if(is_array($newargs)){
		array_pop( $newargs );
	
		$parameters = http_build_query( $newargs );
		 if(strpos($code, 'youtube.com/') !== false){
			 $return = str_replace( '?feature=oembed', '?feature=oembed'.'&'.$parameters, $code );
		 }else{
			$return = preg_replace("@src=(['\"])?([^'\">\s]*)@", "src=$1$2?".$parameters."&loop=1", $code);
		}
		
		return $return;
	}
}
add_filter('oembed_result','video_autoplay', 10, 3); /* Add filter to set the auto play for video */

/* action to set the templatic advertisement widget */
add_action( 'wp_dashboard_setup', 'TemplaticDashboardWidgetSetup');
function TemplaticDashboardWidgetSetup() {
	add_meta_box( 'templatic_dashboard_news_widget', __('News From Templatic','templatic'), 'TmplDashboardWidgetFunction', 'dashboard', 'normal', 'high' );
}

/* TemplaticDashboardWidgetFunction - Admin dashboard widget to show templatic news */
function TmplDashboardWidgetFunction() {	
	?>
<div class="table table_tnews">
  <div class="trss-widget">
    <?php
   $items = get_transient('templatic_dashboard_news');

   if (empty($items)) {
		include_once(ABSPATH . WPINC . '/class-simplepie.php');
		$trss = new SimplePie();
		$trss->set_timeout(5);
		$trss->set_feed_url('http://feeds.feedburner.com/Templatic');
		$trss->strip_htmltags(array_merge($trss->strip_htmltags, array('h1', 'a')));
		$trss->enable_cache(false);
		$trss->init();
		
		if ( is_wp_error($trss) ) {
			 if ( is_admin() || current_user_can('manage_options') ) {
				  echo '<div class="rss-widget"><p>';
				  printf(__('<strong>RSS Error</strong>: %s','templatic'), $trss->get_error_message());
				  echo '</p></div>';
			 }
		}
		
		$items = $trss->get_items(0, 6);
		$cached = array();
		
		foreach ($items as $item) { 
			 preg_match('/(.{128}.*?)\b/', $item->get_content(), $matches);
			 $cached[] = array(
							'url' => $item->get_permalink(),
							'title' => $item->get_title(),
							'date' => $item->get_date("d M Y"),
							'content' => rtrim($matches[1]) . '...'
					   );
		}
		$items = $cached;
		set_transient('templatic_dashboard_news', $cached, 60 * 60 * 24);
   }
               ?>
    <ul class="news">
      <?php foreach ($items as $item): ?>
      <li class="post"> <a href="<?php echo $item['url']; ?>" class="rsswidget"><?php echo $item['title']; ?></a> <span class="rss-date"><?php echo $item['date']; ?></span>
        <div class="rssSummary"><?php echo strip_tags($item['content']); ?></div>
      </li>
      <?php endforeach;?>
    </ul>
  </div>
</div>
<div class="t_theme">
  <div class="t_thumb">
    <?php
          $lastTheme = get_transient('templatic_dashboard_theme');
         		$lastTheme = file_get_contents('http://templatic.com/latest-theme/');
		    
		if ($lastTheme) echo $lastTheme; ?>
  </div>
  <hr/>
  <p class="sub"><strong>
    <?php echo __('More...','templatic'); ?>
    </strong></p>
  <ul id="templatic-services">
    <li><a href="http://templatic.com/support"><?php echo __('Need support?','templatic');?> </a></li>
    <li><a href="http://templatic.com/free-theme-install-service/"><?php echo __('Custom services','templatic');?></a></li>
    <li><a href="http://templatic.com/premium-themes-club"><?php echo __('Join our theme club','templatic');?></a></li>
  </ul>
</div>
<div class="clearfix"></div>
<?php
}
add_action('admin_menu', 'register_theme_settings_menu',9999);
/*Function Name: register_theme_settings_menu
Purpose		 : To create submenu for theme settings in Appearance menu
*/
if(!function_exists('register_theme_settings_menu')){
	function register_theme_settings_menu() {
		add_submenu_page('themes.php', __('Custom CSS Editor','templatic'),__('Custom CSS Editor','templatic'),'manage_options', 'templatic_custom_css_editor', 'templatic_custom_css_editor_settings', '', 100);
	}
}
/*
Name: templatic_custom_css_editor_settings
desc: save custom css in an option table
*/
function templatic_custom_css_editor_settings()
{
	$title = __('Custom CSS Editor','templatic');
	$file = get_template_directory()."/custom.css";?>
	
	
	<?php 
	$theme = 'video';
	if ( $theme )
		$stylesheet = $theme;
	else
		$stylesheet = get_stylesheet();

	$theme = wp_get_theme( $stylesheet );
	$allowed_files = $theme->get_files( 'php', 1 );
	$has_templates = ! empty( $allowed_files );
	$style_files = $theme->get_files( 'css' );
	$allowed_files['style.css'] = @$style_files['style.css'];
	$allowed_files += $style_files;
	
	$relative_file = 'custom.css';
	/* if action set to updates write custom.css file then redirect on currect place */
	if(isset($_POST['action']) && $_POST['action'] == 'update')
	{
		
		check_admin_referer( 'edit-theme_' . $file . $stylesheet );
		$newcontent = wp_unslash( $_POST['custom_css_content'] );
		update_option('directory_custom_css',$newcontent);
		$location = 'themes.php?page=templatic_custom_css_editor';
		$location .= '&updated=true';
		wp_redirect( $location );
		exit;
	}
	$content = '';
	if(file_exists($file))
	{
		if ( ! @$error && filesize( $file ) > 0 ) {
			$f = fopen($file, 'r');
			$content = fread($f, filesize($file));
	
			if ( '.php' == substr( $file, strrpos( $file, '.' ) ) ) {
				$functions = wp_doc_link_parse( $content );
	
				$docs_select = '<select name="docs-list" id="docs-list">';
				$docs_select .= '<option value="">' . esc_attr__( 'Function Name&hellip;' ) . '</option>';
				foreach ( $functions as $function ) {
					$docs_select .= '<option value="' . esc_attr( urlencode( $function ) ) . '">' . htmlspecialchars( $function ) . '()</option>';
				}
				$docs_select .= '</select>';
			}
	
			$content = esc_textarea( $content );
		}
	}
	?>
    <div class="wrap">
	<h2><?php echo esc_html( $title ); ?></h2>
	 <p> <?php echo sprintf(__('You can customize the theme by entering CSS classes in this section. Enter only the classes you want to overwrite (not the whole style.css file). For details on using custom.css open %s.','templatic'),'<a href="http://templatic.com/docs/using-custom-css-for-theme-customizations/">this article</a>');?></p>
   
   <?php if(isset($_GET['updated']) && $_GET['updated'] == 'true'){ ?>
	    <div class="updated" id="message"><p><?php echo __('File edited successfully.','templatic'); ?></p></div>
    <?php } ?>
	<form name="custom_css" id="template" action="" method="post">
	<?php wp_nonce_field( 'edit-theme_' . $file . $stylesheet ); ?>
		<div><textarea cols="70" rows="30" name="custom_css_content" id="custom_css_content" aria-describedby="newcontent-description"><?php echo $content; ?></textarea>
        <input type="hidden" name="action" value="update" />
		<input type="hidden" name="file" value="<?php echo esc_attr( $relative_file ); ?>" />
		<input type="hidden" name="theme" value="<?php echo esc_attr( $theme->get_stylesheet() ); ?>" />
		<input type="hidden" name="scrollto" id="scrollto" value="0" />
		<?php
		if(get_option('directory_custom_css'))
		{
			if ( is_writeable( $file ) ) :
				submit_button( __( 'Update File','templatic' ), 'primary', 'submit', true );
			else : ?>
		<p><em><?php __('You need to make this file writable before you can save your changes. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information in directory root folder.','templatic'); ?></em></p>
		<?php endif; 
		}
		else
		{
			submit_button( __( 'Update File', 'templatic' ), 'primary', 'submit', true );
		}?>
		</div>
	</form>
    </div>
<?php
}
/*
Save the custom.css file
*/
add_action('admin_init','save_custom_css'); /* save from admin */
add_action('init','save_custom_css');  /* save from front end  */
function save_custom_css()
{
	$file = get_template_directory()."/custom.css";
	$theme = 'video';
	if ( $theme )
		$stylesheet = $theme;
	else
		$stylesheet = get_stylesheet();
	
	/* get the teme name and data */
	$theme = wp_get_theme( $stylesheet );
	if(get_option('directory_custom_css'))
	{
		if(!file_exists($file))
		{
			fopen( $file, 'w+' );
		}
	}
	$newcontent = get_option('directory_custom_css');
	/* check  the file is writable or not means it should have 755 permition */
	if ( is_writeable( $file )) {
		//is_writable() not always reliable, check return value. see comments @ http://uk.php.net/is_writable
		$f = fopen( $file, 'w+' );
		if ( $f !== false ) {
			fwrite( $f, $newcontent );
			fclose( $f );
			$theme->cache_delete();
		}
	}
}
/*  add sub menu page for video updates  */
add_action('admin_menu','video_theme_menu',11); 
function video_theme_menu(){
	
	add_menu_page('Templatic', 'Templatic', 'administrator', 'templatic_menu', 'tmpl_theme_update', ''); 
	
}

/* Theme update login form*/
function tmpl_theme_update(){
	
	require_once(get_template_directory()."/functions/templatic_login.php");
}



function walk_category_dropdown_tree1() {
		$args = func_get_args();
		// the user's options are the third parameter
		if ( empty($args[2]['walker']) || !is_a($args[2]['walker'], 'Walker') )
				$walker = new Tmpl_walker_cat_drop;
		else
				$walker = $args[2]['walker'];

		return call_user_func_array(array( &$walker, 'walk' ), $args );
}

class Tmpl_walker_cat_drop  extends Walker_CategoryDropdown
{

	public $tree_type = 'category';
	
	/**
	 * @see Walker::$db_fields
	 * @since 2.1.0
	 * @todo Decouple this
	 */
	public $db_fields = array ('parent' => 'parent', 'id' => 'term_id');

	public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat('&nbsp;', $depth * 3);

		/** This filter is documented in wp-includes/category-template.php */
		$cat_name = apply_filters( 'list_cats', $category->name, $category );

		$output .= "\t<option data-val='test' class=\"level-$depth\" value=\"".$category->slug."\"";
		if ( $category->term_id == $args['selected'] )
				$output .= ' selected="selected"';
		$output .= '>';
		$output .= $pad.$cat_name;
		if ( $args['show_count'] )
				$output .= '&nbsp;&nbsp;('. number_format_i18n( $category->count ) .')';
		$output .= "</option>\n";
	}
}

class loginwidget_plugin extends WP_Widget {
	
	function loginwidget_plugin() {
		/*Constructor*/
		$widget_ops = array('classname' => 'Login Dashboard wizard', 'description' => __('The widget shows account-related links to logged-in visitors. Visitors that are not logged-in will see a login form. Works best in sidebar areas.','templatic') );		
		$this->WP_Widget('widget_login', __('T &rarr; Login Box','templatic'), $widget_ops);
	}
	
	function widget($args, $instance) {

		/* prints the widget*/
		extract($args, EXTR_SKIP);
		if(isset($_REQUEST['widgetptype']) && $_REQUEST['widgetptype'] == 'forgetpass')
		{
			$errors = templatic_widget_retrieve_password();
			if ( !is_wp_error($errors) ) {
				$for_msg = __('Check your e-mail for the new password.','templatic');
			}
		} 
		$login_page_id=get_option('tevolution_login');
		$register_page_id=get_option('tevolution_register');
		global $post;
		
		/*condition to check whether the page is login or not*/
		if($post->ID != $login_page_id && $post->ID != $register_page_id && get_post_meta($post->ID,'is_tevolution_submit_form',true) != 1 || is_user_logged_in())
		{
		?>	
		<div class="widget login_widget" id="login_widget">
          <?php
			global $current_user;
			if($current_user->ID && is_user_logged_in())/* user loged in*/
			{
			?>
                    <h3  class="widget-title"><?php echo $title;?></h3>
                    <ul class="xoxo blogroll">
                    <?php 
                         
                        echo '<li><a href="'. get_author_posts_url($current_user->ID).'">'; _e('Dashboard','templatic'); echo '</a></li>';
                        $profile_page_id = get_option('tevolution_profile_page');				
                        if($profile_page_id == ''){
                            $profile_url = get_permalink( get_page_by_path('edit-profile'));
                        }else{
                            $profile_url = get_permalink($profile_page_id);
                        }
                        if($profile_url!=''){
                            echo '<li><a href="'.$profile_url.'">'; _e('Edit profile','templatic'); echo '</a></li>';
                            echo '<li><a href="'.$profile_url.'#chngpwdform">'; _e('Change password','templatic'); echo '</a></li>';
                        }
                        
                         $user_link = get_author_posts_url($current_user->ID);
                         if(strstr($user_link,'?') ){$user_link = $user_link.'&list=favourite';}else{$user_link = $user_link.'?list=favourite';}
                         do_action('tevolution_login_dashboard_content');
                         echo '<li><a href="'.wp_logout_url(get_option('siteurl')."/").'">'; _e('Logout','templatic'); echo '</a></li>';
                         ?>
                    </ul>
			<?php
			}else/* user not logend in*/
			{?>
                            <h3  class="widget-title"><?php echo $title;?></h3>
                            <ul class="xoxo blogroll">
                            <?php 
                                if($current_user->ID){
                                    echo '<li class="tmpl-login' . ((is_home())? ' ' : '') . '"><a href="' .wp_logout_url(home_url()). '">' . __('Log out','templatic') . '</a></li>';
                                }else{
                                    echo '<li class="tmpl-login' . (($_REQUEST['ptype']=='login')? ' current_page_item' : '') . '" >  <a href="'.site_url().'/?ptype=login" title='. __('Login','templatic') .'>' . __('Login','templatic') . '</a></li>';
                                }
                                if($current_user->ID){
                                    echo '<li class="tmpl-login' . ((is_author())? ' current-menu-item ' : '') . '"><a href="' . get_author_posts_url($current_user->ID) . '">' . $current_user->display_name . '</a></li>';
                                }

                                $submit_video_id = get_option('tevolution_submit_video');
                                $submit_video_url=get_permalink($submit_video_id);
                                if($submit_video_url != ''){
                                    echo "<li class='listing-btn'><a href='$submit_video_url'>". __('Add Video','templatic'). "</a></li>";
                                }
                            echo '</ul>';	
			}/* finish user logged in condition*/
                        echo '</div>'; 
		}
	}
	
	function update($new_instance, $old_instance) {
		/*save the widget		*/
		return $new_instance;
	}
	function form($instance) {
		/*widgetform in backend*/
		$instance = wp_parse_args( (array) $instance, array( 'title' => __("Dashboard",'templatic') ) );		
		$title = strip_tags($instance['title']);		
		?>
		<p>
          	<label for="<?php echo $this->get_field_id('title'); ?>">
				<?php echo __('Login Box Title','templatic');?>: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
               </label>
          </p>
		<?php
	}
}	
/**- function to add facebook login EOF -**/
add_action( 'widgets_init', create_function('', 'return register_widget("loginwidget_plugin");') );
?>