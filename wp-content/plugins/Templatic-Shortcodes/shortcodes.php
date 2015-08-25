<?php
/*
 * shortcodes - provided by templatic - code starts 
 *
 * name : alert styles for success, warning and error messeges
 * example : [templatic_msg_box type = "alert"] 
 * message box  type: alert, error, success, info
 * default message box type alert
 */

function templatic_msg_box( $atts, $content = null )
{
	/* get user defined attributes 
	 * here we have used type for all the messege boxes
	 * user just needs to define the type while useing the shortcode 
	 */
	extract(shortcode_atts(array(	"type" => 'alery'), $atts));
	add_action('wp_footer','add_script_alert');
		
	$tab_titles = array();
	if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
	
	if($type == 'alert') /* for type = alert */
	{
		$html =  '<div class="alert"><button type="button" class="close" data-dismiss="alert" onClick="close_box(this.id);" id="alert">&times;</button>' .do_shortcode( $content ).'</div>';
	}
	else// error, success, info
	{
		$html =  '<div class="alert alert-'.$type.'"><button data-dismiss="alert" class="close" type="button" onClick="close_box(this.id);" id="error">&times;</button>' .do_shortcode( $content ) .'</div>';
	}
	
	return $html;
}
function add_script_alert()
{
	echo "<script>
		function close_box(str)
		{
			jQuery('#'+str).alert('close');
		}
		</script>";
}


/* 
 * NAME : BUTTONS WITH 4 SIZE AND 7 TYPES
 * EXAMPLE : [templatic_button size="medium" type="basic"] 
 * Button size list: large, medium, small, mini
 * Button type list: basic, primary, info, success, warning, danger, inverse
 * Default parametter size=medium, link=#, type basic
 */
function templatic_add_shortcode_button( $atts, $content = null )
{
	/* get user defined attributes 
	 * here we have used type, link and size for all the buttons
	 * user just needs to define the type, link and size of the button while useing the shortcode 
	 */
	extract(shortcode_atts(array(
	"size" => 'medium',
	"link" => '#',
	"type" => 'basic'
	), $atts));
	$html = '';
	
	if($type=='basic'){
		if($size=='medium')
			$html =  '<a class="btn  " target="_self" href="'.$link.'"><i class="fa fa-hdd-o"></i>'.do_shortcode( $content ).'</a>';
		else
			$html =  '<a class="btn btn-'.$size.'" target="_self" href="'.$link.'">'.do_shortcode( $content ).'</a>';
	}else{
		if($size=='medium')
			$html =  '<a class="btn btn-'.$type.' " href="'.$link.'"><i class="fa fa-tags"></i>'.do_shortcode( $content ).'</a>';
		else
			$html =  '<a class="btn btn-'.$size.' btn-'.$type.'" href="'.$link.'">'.do_shortcode( $content ).'</a>';		
	}
	return $html;
}


/* 
 * NAME : LABELS AND BADGES
 * EXAMPLE : [templatic_label type="label" class="success"] 
 * Default type: label and default class: default
 */
function templatic_add_shortcode_label( $atts, $content = null )
{
	/* get user defined attributes 
	 * here we have used type and class for all the buttons
	 * user just needs to define the type and class of the labels while useing the shortcode 
	 */
	extract(shortcode_atts(array(
	"class" => 'default',
	"type" => 'label'
	), $atts));
	if( $type == 'label' ) /* for type = label */
	{
		if( $class == 'default' ) :
			$html =  '<span class="label ">'.do_shortcode( $content ).'</span>';
		else:
			$html = '<span class="label label-'.$class.'">'.do_shortcode( $content ).'</span>';
		endif;		
	}
	elseif( $type == 'badge' ) /* for type = badge */
	{
		if( $class == 'default' ) :
			$html = '<span class="badge ">'.do_shortcode( $content ).'</span>';
		else:
			$html = '<span class="badge label-'.$class.'">'.do_shortcode( $content ).'</span>';
		endif;
	}
	return $html;
}


/*
 * NAME : JQUERY POPOVER SHORTCODE
 * EXAMPLE : [templatic_popover data-content="The content goes here" data-original-title="Title"] 
 * Default data_content: The content goes here
 * Default data_original_title: Title
 * Default placement: top
 */
function templatic_add_shortcode_popover( $atts, $content = null )
{
	$random = rand(1,1000);
	/* get user defined attributes 
	 * here we have date content and title for all the buttons
	 * user just needs to write the content with the title while useing the shortcode 
	 */
	extract(shortcode_atts(array(
	"data_content"        => 'The content goes here',
	"data_original_title" => 'Title',
	"placement"           => 'top',
	"id"                  => 'popup'.$random
	), $atts));
	?>
	<script type="text/javascript">
		jQuery.noConflict();
		jQuery(function(){
			jQuery('#<?php echo $id; ?>').popover();  
		});
		</script>
<?php	
	return '<a href="javascript:void(0);" id="'.$id.'" class="btn btn-info" rel="popover" data-content="'.$data_content.'" data-original-title="'.$data_original_title.'" data-placement="'.$placement.'" delay="hide: 5000">'.do_shortcode( $content ).'</a>';
		
}




/* 
 * NAME : JQUERY MODAL SHORTCODE
 * EXAMPLE : [templatic_modal] 
 * Default button_link: Launch demo modal
 */
function templatic_add_shortcode_modal( $atts, $content = null )
{
	/* get user defined attributes 
	 * here we have date content and title for all the buttons
	 * user just needs to write the content with the title while useing the shortcode
	 */
	extract(shortcode_atts(array(
	"button_link" => 'Launch demo modal'
	), $atts));
	add_action('wp_footer','add_script_modal');
	return '<button type="button" class="btn btn-large btn-warning" id="modallink" data-target="#myModal">'.$button_link.'</button><div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal hide fade" id="myModal" style="display: none;"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button><div class="modal-body">'.do_shortcode( $content ).'</div><div class="modal-footer"><button class="btn" data-dismiss="modal">Close</button></div></div>';
}
/* function that includes script for tooltip */
function add_script_modal()
{
	echo "<script>
		jQuery.noConflict();
		jQuery('#modallink').click(function($)
		{
			jQuery('#myModal').modal('toggle');
			jQuery('#myModal').css('display','block');
		});  
		</script>";
}


/* 
 * NAME : CODE OPTIONAL SCROLL SHORTCODE
 * EXAMPLE : [templatic_scroll] 
 */
function templatic_add_shortcode_scroll( $atts, $content = null )
{
	return '<pre class="pre-scrollable">'.do_shortcode( $content ).'</pre>';
}


/* 
 * NAME : TABS SHORTCODE
 * EXAMPLE : [templatic_tabs] 
 */
function templatic_add_shortcode_tabs( $atts, $content = null )
{
	$defaults = array();
	extract( shortcode_atts( $defaults, $atts ) );
	wp_enqueue_script('jquery-ui-tabs');
	
	$random = rand(1,1000);
	global $tabs_id;
	$tabs_id='tabs_'.$random;
	?>
     <script type="text/javascript">
	jQuery(function() {
		jQuery( "#<?php echo $tabs_id?>" ).tabs();
		jQuery( "#<?php echo $tabs_id?>" ).children('div').addClass('clearfix');
		
	});
    </script>
	<style type="text/css">
		.tabbable div img{
			float: left;
    		margin: 0 25px 10px 0;
		}
		@media only screen and (max-width: 320px) {
			.tabbable div img {
				float: none;
				display: block;
			}
		}
	</style>
     <?php
	// Extract the tab titles for use in the tab widget.
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );
		
	$tab_titles = array();
	if( isset($matches[1]) ){ $tab_titles = $matches[1]; }
	
	$output = '';	
	
	if( count($tab_titles) )
	{
		$output .= '<div id="'.$tabs_id.'" class="tabbable">';
		$output .= '<ul class="nav nav-tabs" id="myTab">';
		$selected='';	
		foreach( $tab_titles as $tab ){			
			$output .= '<li class="'.$selected.'" id="tab_'. sanitize_title( $tab[0] ) .'"><a href="#'. sanitize_title( $tab[0] ) .'" data-toggle="tab">' . $tab[0] . '</a></li>';			
		}
		
		$output .= '</ul>';
		$output .= do_shortcode( $content );
		$output .= '</div>';
	} else {
		$output .= do_shortcode( $content );
	}
	//return $test_out;//$output;
	return $output;
}
/*
 * Function Name: templatic_add_shortcode_tab
 * Return: tab content
 * Default title: Tab
 */
function templatic_add_shortcode_tab( $atts, $content = null )
{
	$defaults = array( 'title' => 'Tab' );
	extract( shortcode_atts( $defaults, $atts ) );
	return '<div class="tab-pane" id="'. sanitize_title( $title ) .'">'. do_shortcode( $content ) .'</div>';
	
}

/*
 * NAME : ICON LISTS SHORTCODE
 * EXAMPLE : [templatic_icons type="basic"][LI]
 * Default icons type : basic
 */
function templatic_add_shortcode_icons( $atts, $content = null )
{
	/* get the user defined value for the type of the list */
	extract(shortcode_atts(array(
	"type" => 'basic'
	), $atts));
	$list = explode('[LI]',$content);
	$items = count($list);
	$li='';
	for($i = 1; $i <= ($items - 1); $i++)
	{
		$li_content = explode('[/LI]',$list[$i]);
		$li .= '<li>'.$li_content[0] .'</li>';
	}
	if($type == 'basic') :
		$html = '<div class="custom_icon_list"><ul>'.$li.'</ul></div>';
	elseif($type == 'cancel') :
		$html = ' <div class="custom_icon_list customlist_x"><ul>'.$li.'</ul></div>';
	elseif($type == 'dot') :
		$html = '<div class="custom_icon_list customlist_dot"><ul>'.$li.'</ul></div>';
	endif;
	return $html;
}
function templatic_add_shortcode_icons_li( $atts, $content = null )
{
	return do_shortcode($content);
}

/*
 * NAME : TOOLTIP SHORTCODE
 * EXAMPLE : [templatic_tooltip position="top" text="This is tooltip"] 
 *
 */
function templatic_add_shortcode_tooltip( $atts, $content = null )
{
	return '<div class="bs-docs-example tooltip-demo">
				<ul class="bs-docs-tooltip-examples">
					'.do_shortcode($content).'
				</ul>
			</div>';
}
/*
 * NAME : templatic_add_shortcode_tooltip_li
 * EXAMPLE : [tooltip_li position="top" text="This is tooltip"] 
 * Default tooltip li position: top
 * Default tooltip text = This is tooltip
 */
function templatic_add_shortcode_tooltip_li( $atts, $content = null )
{
	$ran1 = rand(1001, 10000);
	extract(shortcode_atts(array(
				"position" => 'top',
				"text"     => 'This is a tooltip',
				'tipid'    => 'tip'.$ran1,
				), $atts)
		   );

	add_action('wp_footer','add_script_tooltip'); /* call jquery script to show the tooltip */
	return '<li><a data-placement="'.$position.'" rel="tooltip" href="#" data-original-title="'.$text.'" id="'.$tipid.'" onmouseover="show_tooltip(this.id);">'.do_shortcode( $content ).'</a></li>';
}


/* function that includes script for tooltip */
function add_script_tooltip()
{
	echo "<script> 
	function show_tooltip(ran1)
	{
		jQuery.noConflict();
		jQuery('#'+ran1).tooltip('show');		
	}
	</script>";
}


/* 
 * NAME : ACCORDION SHORTCODE
 * EXAMPLE : [templatic_accordion] 
 */
function templatic_add_shortcode_accordion( $atts, $content = null )
{
	wp_enqueue_script('jquery-ui-accordion');
	
	$ran = rand(1, 1000);
	extract(shortcode_atts(array(
	"title" => '',
	'id' => 'id'.$ran,
	), $atts));
	remove_filter( 'the_content', 'wpautop' , 12);
	?>
	 <script>
		jQuery(function() {
			jQuery( "#accordion_<?php echo $ran;?>" ).accordion();
		});
	</script>
<?php
	
	return str_replace("\r\n", '', '<div id="accordion_'.$ran.'" class="accordions-shortcode">'.do_shortcode( $content ).'</div>');
}
function templatic_add_shortcode_accordion_content( $atts, $content = null )
{
	global $post;
		
		extract(shortcode_atts(array(
					'title' => null,
					'class' => null,
				), $atts) );

		ob_start();

		if($title): ?>
			<h3 ><?php echo $title; ?></a></h3>

			<div class="accordion-shortcode-content <?php echo $class; ?> clearfix" >
				<?php echo do_shortcode( $content ); ?>
			</div>
		<?php elseif($post->post_title): ?>
			<h3><?php echo $post->post_title; ?></h3>

			<div class="accordion-shortcode-content <?php echo $class; ?> clearfix">
				<?php echo do_shortcode( $content ); ?>
			</div>
	    <?php else: ?>
			<span style="color:red">Please enter a title attribute like [accordion title="title name"]accordion content[accordion]</span>
		<?php endif;
		
		return ob_get_clean();
	
}


/* 
 * NAME : CODE CONTENT BOX SHORTCODE
 * EXAMPLE : [templatic_contentbox] 
 * Default type: normal and default title: Normal Box
 */
function templatic_add_shortcode_contentbox( $atts, $content = null )
{
	extract(shortcode_atts(array(
				"type"    => 'normal',
				"title"   => 'Normal Box'
				), $atts));
	if($type == 'normal') :
		$html = '<div class="boxes normal_box"><div><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div></div>';
	elseif($type == 'author') :
		$html = '<div class="about_author"><img alt="" src="'.TEMPL_IMAGE_URI.'user_64.png"><div><h4>'.$title.'</h4><p>'.do_shortcode($content).'</p></div></div>';
	else:
		$html = '<div class="boxes '.$type.'_box"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';	
	endif;
	return $html;
}


/*
 * NAME : CODE SMALL CONTENT BOX SHORTCODE
 * EXAMPLE : [templatic_smallcontentbox] 
 * Default type: info and default title: Info Box
 */
function templatic_add_shortcode_small_content_box( $atts, $content = null )
{
	extract(shortcode_atts(array(
	"type" => 'info',
	"title" => 'Info box'
	), $atts));
	if($type == 'about') :
		$html = '<div class="boxes about_box small small_right"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($type == 'info') :
		$html = '<div class="boxes info_box small"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($type == 'alert') :
		$html = '<div class="boxes alert_box small"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	endif;
	return $html;
}


/* 
 * NAME : CODE DROPCAPS SHORTCODE
 * EXAMPLE : [templatic_dropcaps] 
 * Default color: color1 and default latter: L
 */
function templatic_add_shortcode_dropcaps( $atts, $content = null )
{
	extract(shortcode_atts(array(
			"color" => 'color1',
			"letter" => 'L'
			), $atts));
	
	$html = '<div class="one_third"><p><span class="dropcaps '.$color.'">'.$letter.'</span>'.do_shortcode($content).'</p></div>';
	
	return $html;
}


/*
 * NAME : CODE COLUMN LAYOUTS SHORTCODE
 * EXAMPLE : [templatic_columns] 
 * Default layout: one_half and default title: Half Columns
 */
function templatic_add_shortcode_columns( $atts, $content = null )
{
	extract(shortcode_atts(array(
	"layout" => 'one_half',
	"title" => 'Half Columns'
	), $atts));
	if($layout == 'one_half') :
		$html = '<div class="one_half"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'one_half_last') :
		$html = '<div class="one_half last"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'one_third') :
		$html = '<div class="one_third"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'one_third_last') :
		$html = '<div class="one_third last"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'one_fourth') :
		$html = '<div class="one_fourth"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'one_fourth_last') :
		$html = '<div class="one_fourth last"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'two_third') :
		$html = '<div class="two_third"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	elseif($layout == 'two_third_last') :
		$html = '<div class="two_third last"><h3>'.$title.'</h3><p>'.do_shortcode($content).'</p></div>';
	endif;
	return $html;
}

/* 
 * NAME : CODE PROGRESS BAR SHORTCODE
 * EXAMPLE : [templatic_progressbar] 
 */
function templatic_add_shortcode_progressbar( $atts, $content = null )
{
	extract(shortcode_atts(array(
	"type" => '',
	"percent" => ''
	), $atts));
	
	if($type == 'normal') :
		$html = '<div class="progress"><div class="bar" style="width: '.$percent.'%;"></div></div>';
	elseif($type == 'strip') :
		$html = '<div class="progress progress-striped"><div class="bar" style="width: '.$percent.'%;"></div></div>';
	elseif($type == 'strip_active') :
		$html = '<div class="progress progress-striped active"><div class="bar" style="width: '.$percent.'%;"></div></div>';
	elseif($type == 'progress') :
		$per = explode(",",$percent);
		$html = '<div class="progress"><div class="bar bar-success" style="width: '.$per[0].'%;"></div><div class="bar bar-warning" style="width: '.$per[1].'%;"></div><div class="bar bar-danger" style="width: '.$per[2].'%;"></div></div>';
	endif;
	
	return $html;
}

/* END OF CODE PROGRESS BAR SHORTCODE */


function templatic_yes($atts, $content = null) {
    return '<li class="yes">' . $content . '</li>';
}

function templatic_no($atts, $content = null) {
    return '<li class="no">' . $content . '</li>';
}
function templatic_ame_list($atts, $content = null) {
    return '<ul class="amenities_info">'.do_shortcode($content).'</ul>';
}
//remove_filter( 'the_content', 'wpautop' );
//add_filter( 'the_content', 'wpautop' , 12);
/**
 * Shortcode creation
 */

add_shortcode("ame_list", "templatic_ame_list");
add_shortcode("yes", "templatic_yes");
add_shortcode("no", "templatic_no");
add_shortcode( 'templatic_msg_box', 'templatic_msg_box' );
add_shortcode( 'templatic_button', 'templatic_add_shortcode_button' );
add_shortcode( 'templatic_label', 'templatic_add_shortcode_label' );
add_shortcode( 'templatic_progressbar', 'templatic_add_shortcode_progressbar' );
/*Tool Tip */
add_shortcode( 'templatic_tooltip', 'templatic_add_shortcode_tooltip' );
add_shortcode( 'tooltip_li', 'templatic_add_shortcode_tooltip_li' );
/*End Tool Tip */
add_shortcode( 'templatic_popover', 'templatic_add_shortcode_popover' );
add_shortcode( 'templatic_modal', 'templatic_add_shortcode_modal' );
add_shortcode( 'templatic_scroll', 'templatic_add_shortcode_scroll' );

add_shortcode( 'templatic_tabs', 'templatic_add_shortcode_tabs' );
add_shortcode( 'templatic_tab', 'templatic_add_shortcode_tab' );
add_shortcode( 'templatic_accordion', 'templatic_add_shortcode_accordion' );
add_shortcode( 'accordion', 'templatic_add_shortcode_accordion_content' );
add_shortcode( 'templatic_icons', 'templatic_add_shortcode_icons' );
add_shortcode( 'LI', 'templatic_add_shortcode_icons_li' );
add_shortcode( 'templatic_contentbox', 'templatic_add_shortcode_contentbox' );
add_shortcode( 'templatic_smallcontentbox', 'templatic_add_shortcode_small_content_box' );
add_shortcode( 'templatic_dropcaps', 'templatic_add_shortcode_dropcaps' );
add_shortcode( 'templatic_columns', 'templatic_add_shortcode_columns' );
?>