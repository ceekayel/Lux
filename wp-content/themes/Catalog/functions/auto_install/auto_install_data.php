<?php
set_time_limit(0);
global  $wpdb,$one_time_insert;
$dummy_image_path = TEMPLATE_CHILD_DIRECTORY_PATH.'images/dummy/';

/* ====================================== Design related settings ================================== */
update_option("posts_per_page",'10');
update_option("thumbnail_size_w",'60');
update_option("thumbnail_size_h",'60');
update_option("medium_size_w",'120');
update_option("medium_size_h",'150');
update_option("large_size_w",'980');
update_option("large_size_h",'425');
$a = get_option('supreme_theme_settings');
$b = array(
		'supreme_logo_url' 					=> TEMPLATE_CHILD_DIRECTORY_PATH."images/logo.png",
		'supreme_site_description' 			=> $a['supreme_site_description'],
		'supreme_archive_display_excerpt' 	=> $a['supreme_archive_display_excerpt'],
		'supreme_frontpage_display_excerpt' => $a['supreme_frontpage_display_excerpt'],
		'supreme_search_display_excerpt' 	=> $a['supreme_search_display_excerpt'],
		'supreme_header_primary_search' 	=> $a['supreme_header_primary_search'],
		'supreme_header_secondary_search' 	=> $a['supreme_header_secondary_search'],
		'supreme_author_bio_posts' 			=> $a['supreme_author_bio_posts'],
		'supreme_author_bio_pages' 			=> $a['supreme_author_bio_pages'],

		'footer_insert' 					=> '<div class="copyright"><p class="left">Copyright &copy; 2014 <a href="http://templatic.com/demos/Catalog">Catalog</a> All rights reserved.</p><p class="right"> Designed by <a href="http://templatic.com" alt="wordpress themes" title="wordpress themes"><img src="'.get_stylesheet_directory_uri().'/images/templatic-wordpress-themes.png" alt="wordpress themes"></a></p><p class="clearfix"></p></div>',
		
		
		
		'supreme_global_layout' 			=> $a['supreme_global_layout'],
		'supreme_bbpress_layout' 			=> $a['supreme_bbpress_layout'],
		'supreme_buddypress_layout' 		=> $a['supreme_buddypress_layout']
);
update_option('supreme_theme_settings',$b);
update_option("supreme_logo_url",TEMPLATE_CHILD_DIRECTORY_PATH."images/logo.png");
update_option("supreme_theme_settings-supreme_logo_url",TEMPLATE_CHILD_DIRECTORY_PATH."images/logo.png");

/* =============================== Design settings end ========================================== */

/* ========================================== ADD POSTS ============================================ */

// ADD POST CATEGORIES
$post_info = array();
$category_array = array('Blog','News');
insert_post_category($category_array);
function insert_post_category($category_array){
	global $wpdb;
	for($i=0;$i<count($category_array);$i++){
		$parent_catid = 0;
		if(is_array($category_array[$i])){
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++){
				$catname = $cat_name_arr[$j];
				if($j>1){
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid){
						$last_catid = wp_insert_term( $catname, 'category' );
					}
				}else{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid){
						$last_catid = wp_insert_term( $catname, 'category');
					}
				}
			}
		}else{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid){
				wp_insert_term( $catname, 'category');
			}
		}
	}
	
	for($i=0;$i<count($category_array);$i++){
		$parent_catid = 0;
		if(is_array($category_array[$i])){
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++){
				$catname = $cat_name_arr[$j];
				if($j>0){
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'category', $args = array('parent'=>$parent_catid) );
				}
			}
		}
	}
}

// ================================ ADD BLOG POSTS ================================= //

$post_array = array();
$blog_image = array();
$post_author = $wpdb->get_var("SELECT ID FROM $wpdb->users order by ID asc limit 1");
$post_info = array();
$post_meta = array();
$blog_image[] = "dummy/blg1.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'Sample Lorem Ipsum Post',
					"post_content"	=>	'What is Lorem Ipsum?<br /><br />
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br /><br />It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &acute;Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &acute;lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br /><br />Where does it come from?',
					"post_meta" =>	$post_meta,
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/blg2.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'Sample Blog Post',
					"post_content"	=>	'orem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
					"post_meta" =>	$post_meta,
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/blg5.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'What is Lorem Ipsum?',
					"post_content"	=>	'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br /><br />It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &acute;Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &acute;lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
<br /><br />Where does it come from?',
					"post_meta" =>	$post_meta,
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/dummy1.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'Letraset sheets',
					"post_content"	=>	'When an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br /><br />It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &acute;Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &acute;lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).<br /><br />Where does it come from?',
					"post_meta" =>	$post_meta,
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/dummy3.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'Why do we use it?',
					"post_content"	=>	' It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
Why do we use it?<br /><br />It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &acute;Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &acute;lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).',
					"post_meta" =>	$post_meta,
					"post_category"	=>	array('Blog'),
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/blg2.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	"Celebrating Founder's Day",
					"post_content"	=>	"Founder's Day is commemorated every year on September 13, the day Claude Martin died. Some of the traditions of this day include an extended formal assembly in the morning with a faculty march, a speech by a prominent guest or alumnus, the playing of bagpipes, singing of the school song and other selected hymns by the College choir, and the laying of a wreath at Claude Martin's tomb. For the Founder's Day dinner the entire senior school and staff are treated to an elaborate sit-down dinner in the afternoon. Claude Martin had apparently listed in his will that his death should not be commemorated as a day of mourning but one of celebration of his life. He had also written out a menu for the meal to be served. Although today, the menu does not remain the same, the tradition of the Founder's Day dinner is still preserved. A Founder's Day Social is held in the evening for the senior school. Classes are suspended on Founder's Day, which is generally followed by a school holiday.",
					"post_category"	=>	array('News'),
					"post_meta" =>	$post_meta,
					"post_image"	=>	$blog_image,
					);
$blog_image = array();
$post_meta = array();
$blog_image[] = "dummy/blg5	.jpg";
$post_meta = array(
				   "tl_dummy_content"	  => '1',
				 );
$post_info[] = array(
					"post_title"	=>	'Convocation 2012',
					"post_content"	=>	"In some universities, the term 'convocation' refers specifically to the entirety of the alumni of a college which function as one of the university's representative bodies. Due to its inordinate size, the Convocation will elect a standing committee, which is responsible for making representations concerning the views of the alumni to the university administration. The convocation also, however, can hold general meetings, at which any alumnus can attend. The main function of the convocation is to represent the views of the alumni to the university administration, to encourage co-operation among alumni (esp. in regard to donations), and to elect members of the University's governing body (known variously as the Senate, Council, Board, etc., depending on the particular institution, but basically equivalent to a board of directors of a corporation.). In the University of Oxford, Convocation was originally the main governing body of the University, consisting of all doctors and masters of the University, but it now comprises all graduates of the university and its only remaining function is to elect the Chancellor of the University and the Professor of Poetry.",
					"post_category"	=>	array('Blog'),
					"post_meta" =>	$post_meta,
					"post_image"	=>	$blog_image,
					);
insert_posts($post_info);
require_once(ABSPATH . 'wp-admin/includes/image.php');
function insert_posts($post_info){
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++){
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		
		if(!$post_count){
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category']){
				for($c=0;$c<count($post_info_arr['post_category']);$c++){
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author']){
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			$post_meta = $post_info_arr['post_meta'];
			$data = array(
				'comment_post_ID' => $last_postid,
				'comment_author' => 'admin',
				'comment_author_email' => get_option('admin_email'),
				'comment_author_url' => 'http://',
				'comment_content' => $post_info_arr['post_title'].'its amazing.',
				'comment_type' => '',
				'comment_parent' => 0,
				'user_id' => $current_user->ID,
				'comment_author_IP' => '127.0.0.1',
				'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
				'comment_date' => $time,
				'comment_approved' => 1,
			);
			wp_insert_comment($data);
			update_post_meta($last_postid, 'tl_dummy_content',1);
			if($post_meta){
				foreach($post_meta as $mkey=>$mval){
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			$post_image = $post_info_arr['post_image'];
			if($post_image){
				for($m=0;$m<count($post_image);$m++){
					$menu_order = $m+1;
					$image_name_arr = explode('/',$post_image[$m]);
					$img_name = $image_name_arr[count($image_name_arr)-1];
					$img_name_arr = explode('.',$img_name);
					$post_img = array();
					$post_img['post_title'] = $img_name_arr[0];
					$post_img['post_status'] = 'inherit';
					$post_img['post_parent'] = $last_postid;
					$post_img['post_type'] = 'attachment';
					$post_img['post_mime_type'] = 'image/jpeg';
					$post_img['menu_order'] = $menu_order;
					$last_postimage_id = wp_insert_post( $post_img );
					update_post_meta($last_postimage_id, '_wp_attached_file', $post_image[$m]);					
					$post_attach_arr = array(
										"width"						=>	980,
										"height" 					=>	425,
										"discount_thumbs"			=> array("file"=>$post_image[$m],"height"=>48 ,"width"=>48),
										"category_thumbs"		=>  array("file"=>$post_image[$m],"height"=>218, "width"=>242),
										"home_slider"			=> array("file"=>$post_image[$m],"height"=>980, "width"=>425),
										"small_slider_thumbs"			=> array("file"=>$post_image[$m],"height"=>170, "width"=>170),
										"file"	=> $post_image[$m],
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}



// =================================== END OF BLOG POSTS ================================ //

// =========================================== ADD PAGE TEMPLATES ===============================================//

$pages_array = array();
$pages_array = array('About Us',array('Wordpress Themes Club', 'Advanced Search', 'Contact Us', 'Archives', 'Full Width', 'Sitemap'));
$page_info_arr = array();
$page_info_arr['About Us'] = "
<p>An <strong>About Us</strong> page template where you can briefly write about your Site.</p>
<br />
<p>For Example : <strong>Who We Are ?</strong></p>
<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of 'de Finibus Bonorum et Malorum' (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, 'Lorem ipsum dolor sit amet..', comes from a line in section 1.10.32.

The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from 'de Finibus Bonorum et Malorum' by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
";
$page_info_arr['Wordpress Themes Club'] = '
<p>The Templatic <a href="http://templatic.com/premium-themes-club/">Wordpress Themes Club</a> membership is ideal for any WordPress developer and freelancer that needs access to a wide variety of Wordpress themes. This themes collection saves you hundreds of dollars and also gives you the fantastic deal of allowing you to install any of our themes on unlimited domains.

You can see below just a few of our WordPress themes that are included in the club membership

&nbsp;
<strong>GeoPlaces</strong> - <a href="http://templatic.com/app-themes/geo-places-city-directory-wordpress-theme">Business Directory Theme</a>
The popular business directory theme that lets you have your very own local business listings directory or an international companies pages directory. This elegant and responsive design theme gives you powerful admin features to run a free or paid local business directory or both. GeoPlaces even has its own integrated events section so you not only get a business directory but an events directory too.


<strong>Automotive</strong> - <a href="http://templatic.com/cms-themes/automotive-responsive-vehicle-directory">Car Classifieds Theme</a>
A responsive auto classifieds theme that gives you the ability of allowing vehicles submission on free or paid listing packages which you decide on the price and duration. This sleek auto classifieds and car directory theme is also WooCommerce compatible so you can even use part of your site to run as a car spares online store. Details


<strong>Daily Deal</strong> - <a href="http://templatic.com/app-themes/daily-deal-premium-wordpress-app-theme">Deals Theme</a>
A powerful Deals theme for WordPress which lets your visitors buy or sell deals on your deals website. Daily Deal is by far the easiest and cheapest way to create a deals site where you can earn money by creating different deals submission price packages but you can also allow free deal submissions. Details


<strong>Events V2</strong> - <a href="http://templatic.com/app-themes/events">Events Directory Theme</a>
Launch a successful Events directory portal with this elegant responsive events theme. The theme has many powerful admin features including allowing event organizers to submit events on free or paid payment packages. This theme is simple to setup and you can get your events site up in no time.


<strong>NightLife</strong> - <a href="http://templatic.com/cms-themes/nightlife-events-directory-wordpress-theme">Events Directory Theme</a>
A beautifully designed events management theme which is responsive and allows you to run an events website. Allow event organizers free or paid event listing submissions and offer online event registrations. Nightlife is feature-packed with all the features you can expect from an events directory theme.


<strong>5 Star</strong> - <a href="http://templatic.com/app-themes/5-star-responsive-hotel-theme">Online Hotel Booking and Reservations Theme</a>
A well designed hotel booking theme which is ideal for showcasing and promoting a hotel online in style. This responsive design hotel reservation Wordpress theme will surely impress your guests and is also a theme that gives you a lot of powerful features including an advanced online booking system and a booking calendar.


<strong>Job Board</strong> - <a href="http://templatic.com/app-themes/job-board">Job Classifieds Theme</a>
Start your job classifieds or job board site with this responsive premium jobs board theme. Allow employers to submit job listings for free, paid or both and also allow job seekers to apply for jobs or submit their resumes. Packed with great features you would expect from a premium jobs board theme. Details


<strong>TechNews</strong> - <a href="http://templatic.com/magazine-themes/technews-advanced-blog-theme">Blogging and News Theme</a>
A news theme that is an ideal solution for your a news blog. An elegant theme which is ideal for news blogs, magazine or newspaper sites. This mobile friendly theme is both responsive and WooCommerce compatible. Impress your visitors with the stylish layout and available color schemes. Details


<strong>Real Estate V2</strong> - <a href="http://templatic.com/app-themes/real-estate-wordpress-theme-templatic">Property Classifieds Listings Theme</a>
This powerful IDX/MLS compatible real estate classifieds theme is both unique and powerful in the features it provides. With this real estate listings theme for WordPress, you can allow estate agencies and home sellers an opportunity to submit properties to your site. This real estate theme comes with many features including powerful search filter.


<strong>e-Commerece</strong> - <a href="http://templatic.com/ecommerce-themes/e-commerce">Online Store Theme</a>
A powerful and elegant WooCoomerce compatible e-commerce WordPress theme with many features advanced features. This online store theme offers various modes of product display such as a shopping Cart, digital Shop or catalog mode. This theme for e-commerce offers multiple payment gateways, coupon codes. Details



See the full collection of the <a href="http://templatic.com/premium-themes-club/">WordPress Themes Club Membership</a></p>';
	
$page_info_arr['Advanced Search'] = 'This is Advanced Search page template. With this page template we will search our query deeply. To use this page template just select <strong>Page - Advanced Search</strong> page template from templates section and you&rsquo;re good to go.';

$page_info_arr['Contact Us'] = '
<p>Simply designed page template to display a contact form. An easy to use page template to get contacted by the users directly via an email. You can use this page template the same way mentioned in "Page Templates" page. You just need to select <strong>Contact Us</strong> template to use it.</p>';

$page_info_arr['Archives'] = 'This is Archives page template. Just select <strong>Page - Archives</strong> page template from templates section and you&rsquo;re good to go.';

$page_info_arr['Full Width'] = 'This is Full Width page template. Just select <strong>Page - Full Width</strong> page template from templates section and you&rsquo;re good to go.';

$page_info_arr['Site Map'] =  'See, how easy is to use page templates. Just add a new page and select <strong>Page - Sitemap</strong> from the page templates section. Easy easy, isn&rsquo;t it.
';

set_page_info_autorun($pages_array,$page_info_arr);
function set_page_info_autorun($pages_array,$page_info_arr_arg)
{
	global $post_author,$wpdb;
	$last_tt_id = 1;
	if(count($pages_array)>0)
	{
		$page_info_arr = array();
		for($p=0;$p<count($pages_array);$p++)
		{
			if(is_array($pages_array[$p]))
			{
				for($i=0;$i<count($pages_array[$p]);$i++)
				{
					$page_info_arr1 = array();
					$page_info_arr1['post_title'] = $pages_array[$p][$i];
					$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p][$i]];
					$page_info_arr1['post_parent'] = $pages_array[$p][0];
					$page_info_arr[] = $page_info_arr1;
				}
			}
			else
			{
				$page_info_arr1 = array();
				$page_info_arr1['post_title'] = $pages_array[$p];
				$page_info_arr1['post_content'] = $page_info_arr_arg[$pages_array[$p]];
				$page_info_arr1['post_parent'] = '';
				$page_info_arr[] = $page_info_arr1;
			}
		}

		if($page_info_arr)
		{
			for($j=0;$j<count($page_info_arr);$j++)
			{
				$post_title = $page_info_arr[$j]['post_title'];
				$post_content = addslashes($page_info_arr[$j]['post_content']);
				$post_parent = $page_info_arr[$j]['post_parent'];
				if($post_parent!='')
				{
					$post_parent_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like \"$post_parent\" and post_type='page'");
				}else
				{
					$post_parent_id = 0;
				}
				$post_date = date('Y-m-d H:s:i');
				
				$post_name = strtolower(str_replace(array('&amp;',"'",'"',"?",".","!","@","#","$","%","^","&","*","(",")","-","+","+"," ",';',',','_','/'),array('','','','','','','','','','','','','','','','','','','','',',','','',''),$post_title));
				$post_name_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title=\"$post_title\" and post_type='page'");
				if($post_name_count>0)
				{
					$post_name = $post_name.'-'.($post_name_count+1);
				}
				$post_id_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='page'");
				if($post_id_count==0)
				{
					$post_sql = "insert into $wpdb->posts (post_author,post_date,post_date_gmt,post_title,post_content,post_name,post_parent,post_type) values (\"$post_author\", \"$post_date\", \"$post_date\",  \"$post_title\", \"$post_content\", \"$post_name\",\"$post_parent_id\",'page')";
					$wpdb->query($post_sql);
					$last_post_id = $wpdb->get_var("SELECT max(ID) FROM $wpdb->posts");
					$guid = get_option('siteurl')."/?p=$last_post_id";
					$guid_sql = "update $wpdb->posts set guid=\"$guid\" where ID=\"$last_post_id\"";
					$wpdb->query($guid_sql);
					$ter_relation_sql = "insert into $wpdb->term_relationships (object_id,term_taxonomy_id) values (\"$last_post_id\",\"$last_tt_id\")";
					$wpdb->query($ter_relation_sql);
					update_post_meta( $last_post_id, 'pt_dummy_content', 1 );
				}
			}
		}
	}
}

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Advanced Search' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-template-advanced_search.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Contact Us' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-template-contact.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Archives' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-template-archives.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Full Width' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-template-full_page.php' );

$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Sitemap' and post_type='page'");
update_post_meta( $photo_page_id, '_wp_page_template', 'page-template-sitemap.php' );

$photo_page_id1 = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Short Codes' and post_type='page'");
update_post_meta( $photo_page_id1, '_wp_page_template', 'page-template-short_code.php' );


//============================================ END OF PAGE TEMPLATES ======================================== //


// ==================================== WIDGET SETTINGS START ==================================== //


$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();

//============================================= Header widgets ======================================================
//WooCommerce Shopping Cart widget
$woo_shopping_cart_info = array();
$woo_shopping_cart_info[1] = array(	"title"	=>	'');						
$woo_shopping_cart_info['_multiwidget'] = '1';
update_option('widget_woo_shopping_cart_info',$woo_shopping_cart_info);
$woo_shopping_cart_info = get_option('widget_woo_shopping_cart_info');
krsort($woo_shopping_cart_info);
foreach($woo_shopping_cart_info as $key1=>$val1)
{
	$woo_shopping_cart_info_key = $key1;
	if(is_int($woo_shopping_cart_info_key))
	{
		break;
	}
}
$sidebars_widgets["header_right"] = array("woo_shopping_cart_info-$woo_shopping_cart_info_key");
 
//Set Advertisement widget
$widget_advertisement = array();
$widget_advertisement = get_option('widget_widget_advertisement');
$widget_advertisement[1] = array(
					"title"			=>	'',
					"advertisement"	=>	'<a href="http://templatic.com"><img src="'.get_stylesheet_directory_uri().'/images/dummy/dummy_add.jpg"/></a>'
					);						
$widget_advertisement['_multiwidget'] = '1';
update_option('widget_widget_advertisement',$widget_advertisement);
$widget_advertisement = get_option('widget_widget_advertisement');
krsort($widget_advertisement);
foreach($widget_advertisement as $key1=>$val1)
{
	$widget_advertisement_key = $key1;
	if(is_int($widget_advertisement_key))
	{
		break;
	}
}

$sidebars_widgets["header_advertisement"] = array("widget_advertisement-$widget_advertisement_key");


//============================================= Primary Sidebar widgets ======================================================

//  Browse By Category Widget
$browse_by_cats = array();
$browse_by_cats[1] = array(
					"title"			=>	'Categories',
					"show_count"		=>	'0'
					);						
$browse_by_cats['_multiwidget'] = '1';
update_option('widget_browse_by_cats',$browse_by_cats);
$browse_by_cats = get_option('widget_browse_by_cats');
krsort($browse_by_cats);
foreach($browse_by_cats as $key1=>$val1)
{
	$browse_by_cats_key = $key1;
	if(is_int($browse_by_cats_key))
	{
		break;
	}
}

//  Discount Products Widget
$discount_products_widget = array();
$discount_products_widget[1] = array(
					"coupon_title"			=>	'50% Discount',
					"coupon_code"		=>	'',					
					"number_posts" 	=>	'8'							
					);						
$discount_products_widget['_multiwidget'] = '1';
update_option('widget_discount_products_widget',$discount_products_widget);
$discount_products_widget = get_option('widget_discount_products_widget');
krsort($discount_products_widget);
foreach($discount_products_widget as $key1=>$val1)
{
	$discount_products_widget_key = $key1;
	if(is_int($discount_products_widget_key))
	{
		break;
	}
}

$sidebars_widgets["primary"] = array("browse_by_cats-$browse_by_cats_key","discount_products_widget-$discount_products_widget_key");

//============================================= Front Page Slider widgets ======================================================

//  Homepage Main slider Widget
$home_main_slider = array();
$home_main_slider[1] = array(
					"category"			=>	'',
					"number"			=>	'5',					
					"animation" 		=>	'slide',
					"autoplay" 			=>	'true',
					"sliding_direction" =>	'horizontal',
					"reverse" 			=>	'false',
					"slideshowSpeed" 	=>	'4000',
					"animation_speed" 	=>	'2000',
					"item_width" 	=>	'0',
					"item_margin" 	=>	'0',
					"min_item" 	=>	'0',
					"max_items" 	=>	'0',
					"item_move" 	=>	'0',
					"custom_banner" 	=>	'1',
					"s1" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/dummy/advertise.jpg',
					"s1link" 	=>	'http://www.templatic.com',
					"s2" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img1.jpg',
					"s2link" 	=>	'http://www.templatic.com',
					"s3" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img2.jpg',
					"s3link" 	=>	'http://www.templatic.com',
					"s4" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img3.jpg',
					"s4link" 	=>	'http://www.templatic.com',
					"s5" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/dummy/advertise.jpg',
					"s5link" 	=>	'http://www.templatic.com',
					"s6" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img1.jpg',
					"s6link" 	=>	'http://www.templatic.com',
					"s7" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img2.jpg',
					"s7link" 	=>	'http://www.templatic.com',
					"s8" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img3.jpg',
					"s8link" 	=>	'http://www.templatic.com',
					"s9" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/dummy/advertise.jpg',
					"s9link" 	=>	'http://www.templatic.com',
					"s10" 	=>	TEMPLATE_CHILD_DIRECTORY_URL.'images/slider_img2.jpg',
					"s10link" 	=>	'http://www.templatic.com',
					);						
$home_main_slider['_multiwidget'] = '1';
update_option('widget_home_main_slider',$home_main_slider);
$home_main_slider = get_option('widget_home_main_slider');
krsort($home_main_slider);
foreach($home_main_slider as $key1=>$val1){
	$home_main_slider_key = $key1;
	if(is_int($home_main_slider_key))
	{
		break;
	}
}

 
//  Home page small product slider Widget
$home_small_slider = array();
$home_small_slider[1] = array(
					"title"			=>	'',
					"category"		=>	'',					
					"post_number" 		=>	'10',
					);						
$home_small_slider['_multiwidget'] = '1';
update_option('widget_home_small_slider',$home_small_slider);
$home_small_slider = get_option('widget_home_small_slider');
krsort($home_small_slider);
foreach($home_small_slider as $key1=>$val1){
	$home_small_slider_key = $key1;
	if(is_int($home_small_slider_key))
	{
		break;
	}
}
$sidebars_widgets["home-page-slider-widget"] = array("home_main_slider-$home_main_slider_key","home_small_slider-$home_small_slider_key");
 

//============================================= Front Content widgets ======================================================

//  Category Wise Product Listing Widget for men
$category_wise_product_listing = array();
$category_wise_product_listing[1] = array(
					"title"			=>	'Men',
					"category"		=>	'',
					"number" 		=>	'9',
					"post_type" 	=>	'product',
					"link" 			=>	'#',
					"text" 			=>	'Browse More',
					"order" 		=>	'rand'
					);						
$category_wise_product_listing['_multiwidget'] = '1';
update_option('widget_category_wise_product_listing',$category_wise_product_listing);
$category_wise_product_listing = get_option('widget_category_wise_product_listing');
krsort($category_wise_product_listing);
foreach($category_wise_product_listing as $key1=>$val1){
	$category_wise_product_listing_key = $key1;
	if(is_int($category_wise_product_listing_key))
	{
		break;
	}
}

$sidebars_widgets["catalog_home_content_widget_area"] = array("category_wise_product_listing-$category_wise_product_listing_key");

// ================================ Footer Widgets ===================================== //

//Newsletter Subscribe widget
$widget_subscribewidget = array();
$widget_subscribewidget = get_option('widget_widget_subscribewidget');
$widget_subscribewidget[1] = array(
					"title"			=>	'Get 5% Discount',
					"text"		    =>	'Simply Subscribe Newsletter & Get upto 5% Discount with your first purchase !',					
					"id" 			=>	''
					);						
$widget_subscribewidget['_multiwidget'] = '1';
update_option('widget_widget_subscribewidget',$widget_subscribewidget);
$widget_subscribewidget = get_option('widget_widget_subscribewidget');
krsort($widget_subscribewidget);
foreach($widget_subscribewidget as $key1=>$val1)
{
	$widget_subscribewidget_key = $key1;
	if(is_int($widget_subscribewidget_key))
	{
		break;
	}
}

$sidebars_widgets["footer1"] = array("widget_subscribewidget-$widget_subscribewidget_key");

// About Us Widget
$text_widget = array();
$text_widget = get_option('widget_text_widget');
$text_widget[1] = array(
					"title1"			=>	'About Us',
					"desc1"		  		=>	'Donec venenatis ultrices neque eu faucibus. Nulla elit ligula, condimentum ac scelerisque tempus, dictum in lacus. Morbi at justo in orci adipiscing consequat. Suspendisse et sapien eu nunc aliquam pulvinar. Suspendisse cursus molestie risus eget ultrices. Etiam sollicitudin enim nunc.',
					"read_more_text1" 	=>	'Read More',
					"read_more_link1" 	=>	'#'
					);						
$text_widget['_multiwidget'] = '1';
update_option('widget_text_widget',$text_widget);
$text_widget = get_option('widget_text_widget');
krsort($text_widget);
foreach($text_widget as $key1=>$val1)
{
	$text_widget_key = $key1;
	if(is_int($text_widget_key))
	{
		break;
	}
}
 
$sidebars_widgets["footer2"] = array("text_widget-$text_widget_key");


//Social Media widget
$social_media = array();
$social_media[1] = array(
					"title"			=>	'Connect With Us',
					"twitter"		=>	'http://twitter.com/templatic',
					"facebook" 	=>	'http://facebook.com/templatic',
					"linkedin" =>	'http://linkedin.com/templatic',
					"rss" =>	'http://feedburner.com/templatic'
					);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key1=>$val1)
{
	$social_media_key = $key1;
	if(is_int($social_media_key))
	{
		break;
	}
}
$sidebars_widgets["footer3"] = array("social_media-$social_media_key");


//===============================================================================
//////////////////////////////////////////////////////
update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations

update_option("ptthemes_bottom_options",'Two Column - Left(one third)'); 

/////////////// WIDGET SETTINGS END /////////////



if($_REQUEST['dump']==1){
echo "<script type='text/javascript'>";
echo "window.location.href='".get_option('siteurl')."/wp-admin/themes.php?dummy_insert=1'";
echo "</script>";
}
/////////////// Design Settings END ///////////////

global $upload_folder_path;
global $blog_id;
$upload_folder_path = wp_upload_dir();
if(get_option('upload_path') && !strstr(get_option('upload_path'),'wp-content/uploads')){
	$upload_folder_path = $upload_folder_path['path'];
}else{
	$upload_folder_path =  $upload_folder_path['path'];
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
$folderpath = $upload_folder_path . "dummy/";
$strpost = strpos(get_stylesheet_directory(),'wp-content');
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/dummy"; 

full_copy( get_stylesheet_directory()."/images/dummy/", $target );
function full_copy( $source, $target ){
	global $upload_folder_path;
	$imagepatharr = explode('/',$upload_folder_path."dummy");
	$year_path = ABSPATH;
	for($i=0;$i<count($imagepatharr);$i++){
	  if($imagepatharr[$i]){
		  $year_path .= $imagepatharr[$i]."/";
		  //echo "<br />";
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

regenerate_all_attachment_sizes();
 
function regenerate_all_attachment_sizes() {
	$args = array( 'post_type' => 'attachment', 'numberposts' => 100, 'post_status' => 'inherit',  'post_mime_type' => 'image' ); 
	$attachments = get_posts( $args );
	if ($attachments) {
		foreach ( $attachments as $post ) {
			$file = get_attached_file( $post->ID );
			wp_update_attachment_metadata( $post->ID, wp_generate_attachment_metadata( $post->ID, $file ) );
		}
	}		
}
?>