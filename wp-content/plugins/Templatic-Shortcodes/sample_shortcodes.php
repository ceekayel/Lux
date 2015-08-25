<?php ob_start();
global $wpdb,$blog_id;

//GETTING UPLOADS FOLDER PATH


global $upload_folder_path;
global $blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
$folderpath = $upload_folder_path . "images/";
$strpost = strpos(get_stylesheet_directory(),'wp-content');
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/images"; 
full_copy( plugin_dir_path( __FILE__ )."images/", $target );


/* 
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads'))
{
	$upload_folder_path = "wp-content/blogs.dir/$blog_id/files/";
}else
{
	$upload_folder_path = "wp-content/uploads/";
}
$folderpath = $upload_folder_path . "images/";
$strpost = strpos(plugin_dir_path( __FILE__ ),'wp-content');
$target = substr(plugin_dir_path( __FILE__ ),0,$strpost).$folderpath;
$img = plugin_dir_path( __FILE__ )."images/";
full_copy( $img , $target );
 */
// Create post object
$image_array[] = "images/h1.jpg";
$image_array[] = "images/h2.jpg";
$image_array[] = "images/h3.jpg";
$image_array[] = "images/h4.jpg";
$image_array[] = "images/h5.jpg";
$page_meta = array('_wp_page_template'=>'page-templates/page-full-width.php','Layout'=>'default');
$shortcode_data = array(
	'post_title'    => 'Shortcodes',
	'post_content'  => '
					<div class="shortcodes_wrap">
				<h2>Alerts Styles for success, warning, and error messages</h2>
                <h4>Default alert</h4>
				[templatic_msg_box type="alert"]<strong>Warning!</strong> Best check yorself, you"re not looking too good.[/templatic_msg_box]
				<h4>Error or danger</h4>
				[templatic_msg_box type="error"]<strong>Oh snap!</strong> Change a few things up and try submitting again.[/templatic_msg_box]
				<h4>Success</h4>
				[templatic_msg_box type="success"]<strong>Well done!</strong> You successfully read this important alert message.[/templatic_msg_box]
				<h4>Information</h4>
				[templatic_msg_box type="info"]<strong>Heads up!</strong> This alert needs your attention, but it"s not super important.[/templatic_msg_box]
		</div>
			<div class="shortcodes_wrap clearfix">
					<h2>Buttons - In 4 sizes, 7 colors</h2>
					<div class="one_fourth">[templatic_button link="#" size="large" type="basic"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="primary"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="info"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="success"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="warning"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="danger"] Button Example [/templatic_button]
					[templatic_button link="#" size="large" type="inverse"] Button Example [/templatic_button]</div>
					<div class="one_fourth">[templatic_button link="#" size="medium" type="basic"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="primary"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="info"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="success"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="warning"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="danger"] Button Example [/templatic_button]
					[templatic_button link="#" size="medium" type="inverse"] Button Example [/templatic_button]</div>
					<div class="one_fourth">[templatic_button link="#" size="small" type="basic"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="primary"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="info"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="success"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="warning"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="danger"] Button Example [/templatic_button]
					[templatic_button link="#" size="small" type="inverse"] Button Example [/templatic_button]</div>
					<div class="one_fourth last">[templatic_button link="#" size="mini" type="basic"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="primary"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="info"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="success"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="warning"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="danger"] Button Example [/templatic_button]
					[templatic_button link="#" size="mini" type="inverse"] Button Example [/templatic_button]</div>
					</div>
		<div class="shortcodes_wrap clearfix">
				<h2>Progress bars For loading, redirecting, or action status</h2>
				[templatic_progressbar type="strip_active" percent="50"][/templatic_progressbar][templatic_progressbar type="normal" percent="10"][/templatic_progressbar][templatic_progressbar type="strip" percent="30"][/templatic_progressbar][templatic_progressbar type="progress" percent="30,20,10"][/templatic_progressbar]
			</div>			<div class="shortcodes_wrap clearfix">
                <h2>Tooltips</h2>
				[templatic_tooltip] [tooltip_li position="top" text="This is a tooltip"] Top [/tooltip_li] [tooltip_li position="bottom" text="This is a tooltip"] Bottom[/tooltip_li][tooltip_li position="left" text="This is a tooltip"] Left [/tooltip_li][tooltip_li position="right" text="This is a tooltip"] Right [/tooltip_li][/templatic_tooltip]
				
				[templatic_popover data_content="And here is some amazing content. It is very engaging. right?" data_original_title="A Title" placement="left"] Popover Left [/templatic_popover]&nbsp;[templatic_popover data_content="And here is some amazing content. It is very engaging. right?" data_original_title="A Title" placement="top"] Popover Top [/templatic_popover]&nbsp;[templatic_popover data_content="And here is some amazing content. It is very engaging. right?" data_original_title="A Title" placement="bottom"] Popover Bottom [/templatic_popover]&nbsp;[templatic_popover data_content="And here is some amazing content. It is very engaging. right?" data_original_title="A Title" placement="right"] Popover Right [/templatic_popover]
			</div><div class="shortcodes_wrap clearfix">
                <h2>Modal</h2>
					[templatic_modal button_link="Launch demo modal"]
                   	<h3 id="myModalLabel">Modal Heading</h3>
                    <div class="modal-body">
                        <h4>Text in a modal</h4>
                        <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem.</p>
                        <h4>Overflowing text to show optional scrollbar</h4>
                        <p>We set a fixed <code>max-height</code> on the <code>.modal-body</code>. Watch it overflow with all this extra lorem ipsum text we"ve included.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                        <p>Cras mattis consectetur purus sit amet fermentum. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>
                        <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor.</p>
                        <p>Aenean lacinia bibendum nulla sed consectetur. Praesent commodo cursus magna, vel scelerisque nisl consectetur et. Donec sed odio dui. Donec ullamcorper nulla non metus auctor fringilla.</p>
                    </div>
				[/templatic_modal]
			</div>
			<div class="shortcodes_wrap">
				<h2>Code Optional max-height with scroll.</h2>
				 [templatic_scroll] This is a place for code. You can set it to scroll which will put a max height of 350px on this window. [/templatic_scroll]
			</div>			<div class="shortcodes_wrap">
                <h2>Tabs</h2>
				[templatic_tabs] [templatic_tab title="Section 1"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. [/templatic_tab] [templatic_tab title="Section 2"] Howdy, I am in Section 2. [/templatic_tab] [templatic_tab title="Section 3"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. [/templatic_tab] [/templatic_tabs]
			</div>
			<div class="shortcodes_wrap">
                <h2>Accordion</h2>
				[templatic_accordion] [accordion title="Collapsible Group Item #1"] Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven not heard of them accusamus labore sustainable VHS. [/accordion] [accordion title="Collapsible Group Item #2"] Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven not heard of them accusamus labore sustainable VHS. [/accordion] [accordion title="Collapsible Group Item #3"] Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven not heard of them accusamus labore sustainable VHS. [/accordion] [/templatic_accordion]
			</div><div class="shortcodes_wrap clearfix">
                <h2>Custom Icon Lists</h2><div class="grid_3">[templatic_icons type="basic"] [LI] list item 1 [/LI] [LI] list item 2 <ul> <li>list item 1</li><li>list item 2</li></ul> [/LI] [LI] list item 3 [/LI][LI] list item 4 [/LI][/templatic_icons]</div>
				<div class="grid_3">[templatic_icons type="cancel"] [LI] list item 1 [/LI] [LI] list item 2 <ul><li>list item 1</li><li>list item 2</li></ul> [/LI] [LI] list item 3 [/LI][LI] list item 4 [/LI][/templatic_icons]</div>
				<div class="grid_3">[templatic_icons type="dot"] [LI] list item 1 [/LI] [LI] list item 2 <ul><li>list item 1</li><li>list item 2</li></ul> [/LI] [LI] list item 3 [/LI][LI] list item 4 [/LI][/templatic_icons]</div>
			</div><div class="shortcodes_wrap">[templatic_contentbox type="author" title="Author Box"] Use me for adding more information about the author. You can use me anywhere within a post or a page, i am just awesome. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. [/templatic_contentbox]</div>
			<div class="shortcodes_wrap">[templatic_contentbox type="normal" title="Normal Box"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. [/templatic_contentbox]</div>
			<div class="shortcodes_wrap">[templatic_contentbox type="warning" title="Warning Box"] This is how a warning content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. [/templatic_contentbox]</div>
			<div class="shortcodes_wrap">[templatic_contentbox type="download" title="Download Box"] This is how a download content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy. [/templatic_contentbox]</div>
			<div class="shortcodes_wrap">[templatic_contentbox type="about" title="About Box"] This is how about content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. [/templatic_contentbox]</div><div class="shortcodes_wrap">[templatic_contentbox type="info" title="Info Box"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy.[/templatic_contentbox]</div><div class="shortcodes_wrap">[templatic_contentbox type="alert" title="Alert Box"]This is how alert content box will look like. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, commodo porttitor, felis. Nam blandit quam ut lacus. Quisque ornare risus quis ligula. Phasellus tristique purus a augue condimentum adipiscing. Aenean sagittis. Etiam leo pede, rhoncus venenatis, tristique in, vulputate at, odio. Donec et ipsum et sapien vehicula nonummy.[/templatic_contentbox]</div>
			<div class="shortcodes_wrap clearfix">
                <h2>Small Content Boxes</h2>
				[templatic_smallcontentbox type="info" title="Info Box"] Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. [/templatic_smallcontentbox][templatic_smallcontentbox type="alert" title="Alert Box"] Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. [/templatic_smallcontentbox][templatic_smallcontentbox type="about" title="About Box"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.[/templatic_smallcontentbox]
			</div>
			<div class="shortcodes_wrap clearfix">
                <h2>Dropcaps</h2>[templatic_dropcaps color="color1" letter="L"] orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.[/templatic_dropcaps][templatic_dropcaps color="color2" letter="L"] orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.[/templatic_dropcaps][templatic_dropcaps color="color3" letter="L"] orem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. [/templatic_dropcaps]
			</div>
			<div class="shortcodes_wrap clearfix">
                <h2>Column Layouts</h2>
				[templatic_columns layout="one_half" title="one half"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_half_last" title="one half last"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns]
			</div>
			<div class="shortcodes_wrap clearfix">[templatic_columns layout="one_third" title="one third"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_third" title="one third"] Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_third_last" title="one third last"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns]</div>
			<div class="shortcodes_wrap clearfix">[templatic_columns layout="one_fourth" title="one fourth"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_fourth" title="one fourth"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_fourth" title="one fourth"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_fourth_last" title="one fourth last"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns]</div>
			<div class="shortcodes_wrap clearfix">[templatic_columns layout="one_third" title="one third"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="two_third_last" title="two third last"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns]</div>
			<div class="shortcodes_wrap clearfix">[templatic_columns layout="two_third" title="two third"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus.[/templatic_columns][templatic_columns layout="one_third_last" title="one third"]Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Praesent aliquam, justo convallis luctus rutrum, erat nulla fermentum diam, at nonummy quam ante ac quam. Maecenas urna purus, fermentum id, molestie in, felis. Nam blandit quam ut lacus. [/templatic_columns]</div>',
	"post_status"   => 'publish',
	'post_meta'		=> $page_meta,
	'post_author'   => 1,
	'post_type'	  => 'page',
	"post_image"	=>	$image_array,
);

$results = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type='page' AND post_title='Shortcodes' AND post_status='publish'");
if(count($results) == '')
{
	// Insert the post into the database
	$last_postid = wp_insert_post( $shortcode_data );
	$post_image1 = $shortcode_data['post_image'];
	add_post_meta($last_postid,'Layout','1c');
	update_post_meta($last_postid,'Layout','1c');
	for( $m=0; $m<count($post_image1); $m++ )
	{
		$menu_order1 = $m+1;
		$image_name_arr1 = explode('/',$post_image1[$m]);
		$img_name1 = $image_name_arr1[count($image_name_arr1)-1];
		$img_name_arr1 = explode('.',$img_name1);
		$post_img1 = array();
		$post_img1['post_title'] = $img_name_arr1[0];
		$post_img1['post_status'] = 'inherit';
		$post_img1['post_parent'] = $last_postid;
		$post_img1['post_type'] = 'attachment';
		$post_img1['post_mime_type'] = 'image/jpeg';
		$post_img1['menu_order'] = $menu_order1;
		$last_postimage_id2 = wp_insert_post( $post_img1 );
		update_post_meta($last_postimage_id2, '_wp_attached_file', $post_image1[$m]);
		$post_attach_arr = array(
							"width"	=>	242,
							"height" =>	180,
							"file"	=> $post_image1[$m],
						);
		wp_update_attachment_metadata( $last_postimage_id2, $post_attach_arr );
	}
	wp_redirect(site_url().'/wp-admin/post.php?post='.$last_postid.'&action=edit');
}

/* NAME : COPY IMAGES FOLDER
DESCRIPTION : THIS FUNCTION WILL COPY IMAGES FOLDER IN UPLOADS FOLDER */
function full_copy( $source, $target ) 
{
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");
	$year_path = ABSPATH;
	for($i=0;$i<count($imagepatharr);$i++)
	{
	  if($imagepatharr[$i])
	  {
		  $year_path .= $imagepatharr[$i]."/";
		  if (!file_exists($year_path)){
			  mkdir($year_path, 0777);
		  }     
		}
	}
	@mkdir( $target );
		$d = dir( $source );
		
	if ( is_dir( $source ) ) {
		@mkdir( $target );
		$d = dir( $source );
		while ( FALSE !== ( $entry = $d->read() ) ) {
			if ( $entry == '.' || $entry == '..' ) {
				continue;
			}
			$Entry = $source . '/' . $entry; 
			if ( is_dir( $Entry ) ) {
				full_copy( $Entry, $target . '/' . $entry );
				continue;
			}
			copy( $Entry, $target . '/' . $entry );
		}
	
		$d->close();
	}else {
		copy( $source, $target );
	}
}
?>