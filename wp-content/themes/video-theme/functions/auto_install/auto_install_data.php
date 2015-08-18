<?php 
global $upload_folder_path,$wpdb,$blog_id;
if(get_option('upload_path') && !strstr(get_option('upload_path'),WP_CONTENT_DIR.'/uploads')){
	$upload_folder_path = WP_CONTENT_DIR."/blogs.dir/$blog_id/files/";
}else{
	$upload_folder_path = WP_CONTENT_DIR."/uploads/";
}
global $blog_id;
if($blog_id){ $thumb_url = "&amp;bid=$blog_id";}
$folderpath = $upload_folder_path . "dummy/";
$strpost = strpos(get_template_directory(),WP_CONTENT_DIR);
$dirinfo = wp_upload_dir();
$target =$dirinfo['basedir']."/dummy"; 
$templatic_theme_setting = get_option('templatic_theme_settings');
$theme_setting = array(
		'tmpl_logo_url' 					=> get_template_directory_uri()."/library/images/logo.png",
		'display_header_text'				=> 1,
		'theme_site_description'			=> 1,
		'footer_insert'						=> '<p class="right"><a href="http://templatic.com/">Video</a> theme designed by <a href="http://templatic.com/">Templatic</a>.</p>'
	);
update_option('templatic_theme_settings',$theme_setting);
update_option('posts_per_page',5);

/* theme option setting */
$theme_options['video_default_status'] = 'draft';
$theme_options['fileupload_video'] = rtrim(ini_get('post_max_size'),'M');
$theme_options['fileupload_image'] = rtrim(ini_get('post_max_size'),'M');
$theme_options['video_google_analytics'] = '';
update_option('video_theme_settings', $theme_options);


delete_transient( 'latest_video_resultsvideos');
$dummy_image_path = get_template_directory_uri().'/images/dummy/';
$post_info = array();
$category_array = array('Blog','Alignment','Codex','Comments','Content','Embeds');
insert_taxonomy_category($category_array);
function insert_taxonomy_category($category_array){
	global $wpdb;
	for($i=0;$i<count($category_array);$i++)	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)			{
				$catname = $cat_name_arr[$j];
				if($j>1){
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)					{
					$last_catid = wp_insert_term( $catname, 'category' );
					}					
				}else				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'category');
					}
				}
			}
		}else		{
			$catname = $category_array[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'category');
			}
		}
	}
	for($i=0;$i<count($category_array);$i++)	{
		$parent_catid = 0;
		if(is_array($category_array[$i]))		{
			$cat_name_arr = $category_array[$i];
			for($j=0;$j<count($cat_name_arr);$j++)			{
				$catname = $cat_name_arr[$j];
				if($j>0)				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'category', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

////post end///
//====================================================================================//
////post start 19///
$image_array = array();
$post_meta = array(  'tl_dummy_content' => 1      );

$post_info[] = array(
					"post_title" =>	'10 reasons why you would love this theme',
					"post_content" =>	'<h2>1. Helps you create a beautiful Video site</h2>
This theme will help you create a beautiful video portal where you can embed videos from different video sharing websites or you can also upload your own video using the WordPress media uploader. A new custom post type is created for Videos so that will help you separate your blog posts from videos.


<h2>2. Embed Different video types</h2>
We have provided oEmbed support which will help you embed videos from different websites. Here&lsquo;s a <a title="oembed" href="https://codex.wordpress.org/Embeds#oEmbed">list of websites</a> which will work with oEmbed. Let&lsquo;s see some examples:
<h3>YouTube</h3>
<iframe src="//www.youtube.com/embed/YrtANPtnhyg" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
<h3>Vimeo</h3>
<iframe src="//player.vimeo.com/video/4880153" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>

<h3>DailyMotion</h3>
<iframe src="http://www.dailymotion.com/embed/video/x1mwf0a" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>

<h3>Blip.tv</h3>
<iframe src="http://blip.tv/play/AYLZq0gC.x?p=1" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe><embed style="display: none;" width="300" height="150" type="application/x-shockwave-flash" src="http://blip.tv/api.swf#AYLZq0gC"></embed>
<h3>WordPress.tv</h3>
<embed width="560" height="315" type="application/x-shockwave-flash" src="http://s0.videopress.com/player.swf?v=1.03" wmode="direct" seamlesstabbing="true" allowfullscreen="allowfullscreen" allowscriptaccess="always" overstretch="true" flashvars="guid=fZ6Lyv37&amp;isDynamicSeeking=true"></embed>
<h3>Metacafe</h3>
<iframe src="http://www.metacafe.com/embed/11281375/" width="560" height="315" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
<h3>Spotify</h3>
<iframe src="https://embed.spotify.com/?uri=spotify:track:4bz7uB4edifWKJXSDxwHcs" width="560" height="315" frameborder="0"></iframe>
<h2>3. Beautiful blog</h2>
Along with the video portal you can create a beautiful blog too, yes like always we did not forget the blog! Every element like different headings, lists(ordered, unordered), blockquote, different HTML tags, post formats, image alignments, text alignments are designed with special care to make your blog look beautiful. You name an element and we have designed it for you.
<h2>4. Different sidebars for blog/video</h2>
We have given different custom sidebars which will help you showcase relevant content in the sidebar on all pages. You can have different sidebars on the following pages: home page, blog listing page, blog detail page, video listing page, video detail page, and all other WordPress pages. We have given different custom sidebars which will help you showcase relevant content in the sidebar on all pages. You can have different sidebars on the following pages: home page, blog listing page, blog detail page, video listing page, video detail page, and all other WordPress pages.
<h2>5. Customize the theme without touching code - color customizer, body background image, header background image</h2>
You read it correct, with the inbuilt color customizer you can literally change colors of all the elements of your website. 5 color options are given which will help you create unlimited color schemes of this theme. You read it correct, with the inbuilt color customizer you can literally change colors of all the elements of your website. 5 color options are given which will help you create unlimited color schemes of this theme. Along with the colors you can also have a beautiful body background image and a header image for your website and remember all of this can be done from theme options without touching a single line of code.

Along with the colors you can also have a beautiful body background image and a header image for your website and remember all of this can be done from theme options without touching a single line of code.
<h2>6. Video Slider</h2>
With the help of an awesome looking slider you can show videos in slider on your home page, there is an option to select the number of videos you can display in the slider. You can also select specific categories from which you want to display videos in the slider.


<h2>7. Different widgets for showing posts/videos</h2>
We have created a few custom widgets which will help you showcase posts and videos in different way. Here&lsquo;s a list of the widgets:
<ol>
	<li><strong>T → All Categories First Post</strong>: Helps you display all your video categories in home page content area along with the thumb of latest video in that category</li>
        <li><strong>T → Latest Posts/Videos</strong>: Helps you display latest posts/videos along with their thumbnail in list/grid view on home page. There are options in the widget to limit the number of posts and also from which categories the posts/videos should come</li>
        <li><strong>T → Popular Posts</strong>: Can be used to display popular posts/videos either by number of comments or by total page views. Can be used in both sidebar and home page content area.</li>
        <li><strong>T → Related, Popular, Latest Posts/Videos</strong>: This widget will display Related, popular and latest posts in the sidebar in different tabs. Ideal to have in the sidebar of your blog.</li>

</ol>
<h2>8. Custom.css editor in backend</h2>
You think you are good with CSS and want to make some customization in the theme? We have given an option in the backend where you can write your custom CSS. You must be wondering how this is different from a custom.css file? Well the problem with the custom.css file is theme updates. While updating the theme you need to make sure that you backup your custom.css before updating the theme and put it back again after updating. With custom.css editor in backend we will save your custom CSS in database so you will not have to worry about the theme updates. You can update your theme without backing up the custom.css file and all your customization will be intact.

<h2>9. Localization and WPML ready</h2>
Like all of our recent themes, this theme is also localization ready and also WPML compatible which will allow you to create a website in multiple languages. Like all of our recent themes, this theme is also localization ready and also WPML compatible which will allow you to create a website in multiple languages. Like all of our recent themes, this theme is also localization ready and also WPML compatible which will allow you to create a website in multiple languages.

<h2>10. Automatic updates and unlimited support for a year</h2>
The Automatic updates feature will allow you to update your theme directly from your WordPress backend without having a hard time playing with an FTP program to upload the updated files. By purchasing the theme you also get unlimited support for a year from our <a href="http://templatic.com/forums">support forums</a> and helpdesk. The Automatic updates feature will allow you to update your theme directly from your WordPress backend without having a hard time playing with an FTP program to upload the updated files. By purchasing the theme you also get unlimited support for a year from our <a href="http://templatic.com/forums">support forums</a> and helpdesk.
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Alignment','Codex','Comments','Content','Embeds'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 20///
$image_array = array();
$post_meta = array( 'tl_dummy_content' => 1 );

$post_info[] = array(
					"post_title" =>	'Sample text only post',
					"post_content" =>	'<h5>Praesent posuere libero eu justo tristique, vitae ultricies justo volutpat. Integer convallis convallis interdum. Ut luctus justo elit, sit amet sodales purus vulputate non.</h5>
Nullam lorem eros, posuere nec sodales at, aliquet gravida dui. Aenean id tellus in libero porta ultricies. Donec viverra interdum bibendum. Sed varius nunc tortor, tempus accumsan massa aliquam sed. Quisque a turpis ut dolor porta auctor a sed risus. Quisque turpis arcu, congue in tincidunt quis, feugiat a erat. Vivamus tincidunt semper ultricies. Integer sit amet facilisis quam. Sed vitae nibh odio. Sed nec neque id nunc ornare rhoncus. Donec congue accumsan justo, vitae mollis ipsum pharetra eu.
<blockquote>Donec lacus nunc, viverra nec, blandit vel, egestas et, augue. Vestibulum tincidunt malesuada tellus. Ut ultrices ultrices enim.</blockquote>
Praesent posuere libero eu justo tristique, vitae ultricies justo volutpat. Sed pellentesque neque eu neque adipiscing condimentum. In hac habitasse platea dictumst. Aliquam fermentum mollis orci aliquam dictum. Proin auctor quis enim ut tempor. Integer convallis convallis interdum. Quisque eget libero ac dolor pharetra vestibulum. Nulla posuere orci at justo vehicula porta.<!--more-->



Mauris ut nibh enim. In feugiat sagittis varius. Praesent pharetra ipsum enim, a fermentum arcu lobortis ut. Vestibulum cursus risus at massa faucibus consectetur.
<h3>In hac habitasse platea dictumst</h3>
Vivamus et eleifend massa. Suspendisse nec arcu et ligula posuere aliquam. Integer quis arcu vitae nisi sodales tincidunt.
<ul>
	<li>Proin elementum ante quis mauris</li>
	<li>Integer dictum magna vitae ullamcorper sodales</li>
	<li>Integer non placerat diam, id ornare est. Curabitur sit amet lectus vitae urna dictum tincidunt vel vitae velit</li>
	<li>Vestibulum ante ipsum primis in faucibus</li>
</ul>
Praesent pretium, massa ut consequat commodo, libero turpis dignissim lacus, facilisis porttitor risus mi vitae purus.

',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Alignment','Codex','Comments','Content','Embeds'),
					"post_tags" =>	array('Tags','Sample Tags')

					);
////post end///
//====================================================================================//
////post start 21///
$image_array = array();
$post_meta = array( 'tl_dummy_content' => 1 );

$post_info[] = array(
					"post_title" =>	'10 Outstanding Facts About Estonia',
					"post_content" =>	'Estonia is a Northern European country that has suffered more than its fair share of occupation. Centuries ago, Estonia had to deal with rule by the Danish, then the Swedish, and—more recently—the Soviet Union. However, despite these challenges, Estonia has thrived and came into its own as an independent, democratic country. The most extraordinary thing about Estonia is its grasp of technology. When it comes to Internet access, Estonia is one of the most connected countries in the world, and its education is also top-notch.

<h2>10. Kiiking</h2>
</p>
When we were kids, just about all of us probably used a swing-set at some point. They are at found in most public parks and are a pretty ubiquitous part of everyone’s childhood. However, in Estonia, swinging is much more than just something children do to pass the time. As children, we probably all tried to swing over the bars at some point, and found it was pretty much impossible, due to the design of our swing-sets. We would compromise by simply getting really high and then seeing how far we could leap out.<!--more-->
The Estonians, however, were not to be deterred from flipping all the way over their swings. Being a huge fan of swing-sets, one Estonian <a href="http://www.globaltravelerusa.com/estonia-kiiking/" target="_blank">invented a new sport</a> that has become quite popular. Essentially, he built a better frame, designed solely for the purpose of going all the way over the bars—and doing so is basically the entire point of the sport. It is extreme, insane, and incredibly cool.



<h2>9. Free Public Transportation</h2>
<img class="alignnone size-full wp-image-62442" style="font-weight: inherit; font-style: inherit;" src="http://i1.wp.com/listverse.com/wp-content/uploads/2014/01/9_178592301.jpg?resize=632%2C507" alt="9_178592301" /></p>
In Estonia’s capital city of Tallinn, the local political leadership came up with a genius idea that would make everyone happy. Just like in any city in the world, some of the citizens are poor. Also, removing cars from the roads is generally seen as good for the environment. The mayor of Tallinn figured he could kill two birds with one stone, and offered<a href="http://www.foxnews.com/world/2013/04/04/estonian-capital-world-first-to-give-its-residents-free-ride/" target="_blank">free public transportation</a> to anyone who is a registered resident of his city.</p>
The plan is genius: Despite the costs to the city for providing the initial transport, it also means more people register as residents. This, in turn, means more tax revenue for Tallinn’s administration. Not only that, but—because people can move so freely and cheaply around the city—it appears the program, at least initially, is actually improving the business of local shop owners. Due to the program, more people are using public transport and fewer cars are on the road, so the environment wins too.

<h2>8. Eurovision Song Contest</h2>
<iframe id="fitvid185746" class="youtube-player" style="font-weight: inherit; font-style: inherit;" src="http://www.youtube.com/embed/4iW5zTxHGE8?version=3&amp;rel=1&amp;fs=1&amp;showsearch=0&amp;showinfo=1&amp;iv_load_policy=1&amp;wmode=transparent" width="800" height="500" frameborder="0"></iframe>

<p>For those of you who aren’t aware (especially if you don’t live in Europe), there is an annual entertainment event, known as the Eurovision Song Contest. Countries from all over Europe send in their best song for the televised competition, and it is often a launching pad for musicians’ future careers. Back in 2001, Estonia<a href="http://www.billboard.com/articles/news/79751/estonias-everybody-erupts-at-eurovision" target="_blank">surprised pretty much everyone</a> by taking the win with the song “Everybody,” which was sung by Dave Benton and Tanel Padar.</p>
<p>This made history, because no other black performer had ever won the Eurovision Song Contest. Some songs are so popular with record executives that contracts are written up and signed before the contest is over. Yet, that was not the case with “Everybody.” It seems even Estonians didn’t really expect to win; they just struck gold with a really good song.</p>

<h2>7. Online Voting</h2>
<img class="alignleft size-full wp-image-62440" style= "width:390px" src="http://i2.wp.com/listverse.com/wp-content/uploads/2014/01/7_121037774.jpg?resize=632%2C420" alt="7_121037774"  /></p>
While many countries are still debating the concept of online voting due to security concerns, Estonia has already been at it <a href="http://www.washingtonpost.com/blogs/wonkblog/wp/2012/11/06/estonians-get-to-vote-online-why-cant-america/" target="_blank">since 2005</a>. Estonia is a very tech-savvy country, with most classrooms and homes having an Internet connection. For the sake of convenience, then, Estonians decided to automate voting.</p>
The most obvious concern with such a system is that it might be hacked, installing a candidate against the will of the people. However, despite such possibilities, it seems the Estonian system has avoided fraud thus far, and people are pretty happy with it. And, so far, they have every reason to be pleased with the system. The Estonian government issues all citizens unique pins and logins for online government services, so they already have a secure infrastructure in place. Clearly, Estonians are early adopters of this technology, and—despite its flaws—it will likely be the way of the future.

<h2>6. Invention Of Skype</h2>
<img class="alignright size-full wp-image-62439" style= "width:390px" src="http://i0.wp.com/listverse.com/wp-content/uploads/2014/01/6_153004544.jpg?resize=632%2C421" alt="6_153004544" /></p>
As we mentioned, Estonian people are pretty quick when it comes to understanding computers, and are usually on the cutting edge of technology. Back in the early days of the Internet, there was another file-sharing service that emerged in the waning days of Napster. This service was called Kazaa, and it was actually designed by Estonians, who ended up selling the rights to the product they had created.
<p>Years later, it was again Estonian programmers that took what Kaaza had done for file-sharing, but arrived at a genius idea of <a href="http://techland.time.com/2011/05/10/a-brief-history-of-skype/" target="_blank">mixing it with voice calling</a>. This meant people could make practically free calls, voice or otherwise, as long as they had an Internet connection. A technological revolution was born. While there are similar services now, Skype is still the original, and a source of national pride for Estonians.</p>

<h2>5. Safety Reflectors</h2>
<img class="alignnone size-full wp-image-62438" src="http://i0.wp.com/listverse.com/wp-content/uploads/2014/01/5_101729806.jpg?resize=632%2C420" alt="5_101729806" width="632" height="420" /></p>
Estonia is pretty concerned with keeping their roads safe. While Estonians drink, just like anywhere else in the world they won’t allow you to drive with any alcohol in your system. However, due to Estonia spending a lot of time in darkness, the authorities are often worried about pedestrians getting hit by vehicles. To avoid this, it is actually the law in Estonia that—whether you are biking or just walking—you <a href="http://www.visitestonia.com/en/about-estonia/traveller-information/safety-tips" target="_blank">must have safety reflectors</a> attached, to make sure that people can see you.</p>
Estonia expects responsibility from pedestrians, and you can be fined quite a bit if you don’t have your reflectors. Unfortunately, oftentimes tourists <a href="http://www.baltic-course.com/eng/tourism/?doc=50664" target="_blank">aren’t fully aware</a> of this requirement, which can put them at risk of more than just fines, if they aren’t watching for vehicles.</p>

<h2>4. High-Tech Education</h2>
<img class="alignncenter size-full wp-image-62437" src="http://i2.wp.com/listverse.com/wp-content/uploads/2014/01/4_89904856.jpg?resize=632%2C422" alt="4_89904856" /></p>
Estonia is known for being one of the most linked-up countries, when it comes to Internet connections. Most of the population has access to the Internet at home, and if not, they probably use it at school. Estonians are usually ahead of the curve when it comes to technology, and part of that is due to their enterprising spirit. Estonians believe that creating a better relationship with technology <a href="http://www.forbes.com/sites/parmyolson/2012/09/06/why-estonia-has-started-teaching-its-first-graders-to-code/" target="_blank">at a younger age</a> will help people interact with it better.</p>
This has led to the creation of a new program, intended to start teaching kids the skills necessary for programming while they are still in the first grade. Now mind you, they aren’t going to tell a kid to design a program at the age of six, but they can start teaching them the foundations they will need. This can-do approach to education has been very successful for Estonia, considering they have one of the highest literacy rates in the world. For Estonian adults, the literacy rate is <a href="http://books.google.com/books?id=T4ulqwBynCIC&amp;pg=PA422&amp;lpg=PA422&amp;dq=estonia+99.8%25+literacy+rate&amp;source=bl&amp;ots=JZPtOA6yWm&amp;sig=-qs58cfVf9U3ggtHCYNOmIrtxCk&amp;hl=en&amp;sa=X&amp;ei=rr-uUuKJCsbIsASE84KoBw&amp;ved=0CH4Q6AEwCQ#v=onepage&amp;q=estonia%2099.8%25%20literacy%20rate&amp;f=false" target="_blank">just shy of 100 percent</a>.

<h2>3. Flat Tax</h2>
<img class="alignnone size-full wp-image-62436" src="http://i1.wp.com/listverse.com/wp-content/uploads/2014/01/3_97994357.jpg?resize=632%2C422" alt="3_97994357"  /></p>
The Estonian government was the first in Europe to put a flat tax system into practice. For a long time, certain economists have touted flat tax as the perfect system, but it was only recently that we got to see how it would turn out in reality. While Estonia is a fairly small sample, the results have been pretty good so far. However, many countries that adopted a flat tax after Estonia, have not done very well in the economic crisis, and they have now <a href="http://www.businessweek.com/articles/2013-05-15/flat-tax-wave-ebbs-in-eastern-europe" target="_blank">switched their tax systems</a>back.
<p>Estonia, on the other hand, believes that the flat tax is still the best system, and Estonian economy has recovered from the crisis. Of course, Estonians weren’t able to accomplish this by simply letting the system do its work. To begin ameliorating the effects of the crisis, the Estonian government increased the value added tax, and also used the good old-fashioned tactic of drawing the purse strings tighter.</p>

<h2>2. World Wife-Carrying Champions</h2>
<iframe width="800" height="500" src="//www.youtube.com/embed/-aouBn7IKIo" frameborder="0" allowfullscreen></iframe>

<p>Every single year, several European countries get together for a rather strange sport, called “wife-carrying.” The sport sounds pretty odd, and it is exactly as odd as it sounds. The idea is that the male contestants actually carry their wives or girlfriends, and try to get the best time possible on the course. Some people claim that the roots of the game have to do with an old gang initiation, where men would carry off someone else’s wives.</p>
<p>Whatever the origins, the couples have a lot of fun playing the game, and Estonians are pretty much the best at it. This can be illustrated by the simple fact that the go-to way to carry your wife is called the <a href="http://www.telegraph.co.uk/news/worldnews/europe/finland/10170324/Finland-hosts-annual-wife-carrying-world-championships.html" target="_blank">“Estonian” method</a>; this method basically involves the woman using her legs to grip onto the man’s neck, and hanging over his back like a prize catch. The record for the fastest time ever is still credited to <a href="http://www.eukonkanto.fi/en/" target="_blank">an Estonian couple</a>, who made the run through the obstacle course in 55.5 seconds.</p>

<h2>1. Preserved Medieval Architecture</h2>
<img class="alignnone size-full wp-image-62433" src="http://i2.wp.com/listverse.com/wp-content/uploads/2014/01/1_453252029.jpg?resize=632%2C421" alt="1_453252029" /></p>
By far the best tourist attraction in Estonia, however, is the Old Town portion of the capital city of Tallinn. While much of the old medieval architecture in Europe was lost, a large portion of the structures and streets in the Old Town are remarkably well preserved. The Old Town sector is under the aegis of the UNESCO<a href="http://www.visitestonia.com/en/things-to-see-do/cultural-holiday/medieval-history-hanseatic-league" target="_blank">World Heritage Center</a>. This town is a better-kept example of old architecture and roads than anywhere else in Europe, and has an atmosphere unlike anywhere in the world.
<p>The <a href="http://www.visitestonia.com/en/holiday-destinations/city-guides/tallinn-the-capital/medieval-old-town" target="_blank">town square</a> is often alive with festivals or other activities, and you will find many different old churches and other interesting old buildings. The Old Town is not just a tourist attraction that closes down at night—it is a truly living, breathing place. The medieval Old Town in Tallinn is truly a place where the past and the future intersect.</p>
',
					"post_meta" =>	$post_meta,
					"post_image" =>	$image_array,
					"post_category" =>	array('Blog','Alignment','Codex','Comments','Content','Embeds'),
					"post_tags" =>	array('Tags','Sample Tags')
        
					);
////post end///
//====================================================================================//
insert_posts($post_info);
function insert_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='post' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			if($post_info_arr['post_category'])
			{
				for($c=0;$c<count($post_info_arr['post_category']);$c++)
				{
					$catids_arr[] = get_cat_ID($post_info_arr['post_category'][$c]);
				}
			}else
			{
				$catids_arr[] = 1;
			}
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			if($post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $catids_arr;
			$my_post['tags_input'] = $post_info_arr['post_tags'];
			$last_postid = wp_insert_post( $my_post );
			$post_meta = $post_info_arr['post_meta'];
			
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			
			$post_image = $post_info_arr['post_image'];
			if($post_image)
			{
				for($m=0;$m<count($post_image);$m++)
				{
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
										"width"	=>	580,
										"height" =>	480,
										"hwstring_small"=> "height='150' width='150'",
										"file"	=> $post_image[$m],
										//"sizes"=> $sizes_info_array,
										);
					wp_update_attachment_metadata( $last_postimage_id, $post_attach_arr );
				}
			}
		}
	}
}
//=============================PAGES ENTRY START=======================================================//
$post_info = array();
$pages_array = array(array('About','Home','Wp Themes Club'));
$page_info_arr = array();
$page_meta = array( 'tl_dummy_content' => 1);
$page_info_arr[] = array('post_title'=>'About',
						 'post_content' =>'<a title="WP Test - The Best Tests For WordPress" href="http://wptest.io" target="_blank">WP Test</a> is a fantastically exhaustive set of test data to measure the integrity of your plugins and themes.

The foundation of these tests are derived from <a title="Theme Unit Test" href="http://codex.wordpress.org/Theme_Unit_Test" target="_blank">WordPress’ Theme Unit Test Codex</a> data. It’s paired with lessons learned from over three years of theme and plugin support, and baffling corner cases, to create a potent cocktail of simulated, quirky user content.

The word "comprehensive" was purposely left off this description. It&lsquo;s not. There will always be something new squarely scenario to test. That&lsquo;s where you come in. <a title="Contact" href="http://wptest.io/contact/">Let us know</a> of a test we&lsquo;re not covering. We&lsquo;d love to squash it.

Let’s make WordPress testing easier and resilient together.
',
						 'post_meta'=>$page_meta);
$page_meta = array('_wp_page_template'=>'page-templates/front-page.php', 'tl_dummy_content' => 1);
$page_info_arr[] = array('post_title'=>'Home',
						 'post_content' =>"",
						 'post_meta'=>$page_meta);

$page_meta = array('_wp_page_template'=>'page-templates/page-full-width.php', 'tl_dummy_content' => 1);
$page_info_arr[] = array('post_title'=>'Wp Themes Club',
						'post_content'=>'<p>The Templatic <a href="http://templatic.com/premium-themes-club/">Wordpress Themes Club</a> membership is ideal for any WordPress developer and freelancer that needs access to a wide variety of Wordpress themes. This themes collection saves you hundreds of dollars and also gives you the fantastic deal of allowing you to install any of our themes on unlimited domains.

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



See the full collection of the <a href="http://templatic.com/premium-themes-club/">WordPress Themes Club Membership</a></p>
',
						'post_meta'=>$page_meta);

/* submit video post */						
$page_meta = array('_wp_page_template'=>'default', 'tl_dummy_content' => 1,'is_video_submit_form' => 1);
$page_info_arr[] = array(   'post_title'=>'Submit Video',
                            'post_content' => '<p>This is your video submission form from where users will be able to add their video listings on your website. </p>  [submit_video_form post_type="videos"]',
                            'post_category' =>	'',
                            'post_name'     =>	'submit-video',
                            'post_meta'     =>  $page_meta);
/* edit profile page */
$page_meta = array('_wp_page_template'=>'default', 'tl_dummy_content' => 1, 'is_edit_profile_form' => 1);
$page_info_arr[] = array(   'post_title'=>'Edit Profile',
                            'post_content' => '[tevolution_profile]',
                            'post_category' =>	'',
                            'post_name'     =>	'edit-profile',
                            'post_meta' => $page_meta);

						 
set_page_info_autorun($pages_array,$page_info_arr);
$args = array(
			'post_type' => 'page',
			'meta_key' => '_wp_page_template',
			'meta_value' => 'page-templates/front-page.php'
			);
update_option('show_on_front','page');
$page_query = new WP_Query($args);
$front_page_id = $page_query->post->ID;
update_option('page_on_front',$front_page_id);
$photo_page_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts where post_title like 'Wp Themes Club' and post_type='page'");
update_post_meta( $photo_page_id, 'Layout', '1c' );

/* set edit profile Page in option*/
$profile_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = 'edit-profile'" );
if($profile_id!=''){	
	update_option('tevolution_profile_page',$profile_id);
}

$submit_video_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = 'submit-video'" );
if($submit_video_id!=''){	
	update_option('tevolution_submit_video',$submit_video_id);
}

/* ========================================== VIDEOS SETTING STARTS ================================== */

$category_array1 = array();
$category_array1 = array('Music','Life','Nature','Other','Science','Sports');
insert_taxonomy_category1($category_array1);
/*--Function to insert taxonomy category BOF-*/
function insert_taxonomy_category1($category_array1)
{
	global $wpdb;
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>1)
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'videoscategory' );
					}					
				}else
				{
					$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					if(!$catid)
					{
						$last_catid = wp_insert_term( $catname, 'videoscategory');
					}
				}
			}
			
		}else
		{
			$catname = $category_array1[$i];
			$catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
			if(!$catid)
			{
				wp_insert_term( $catname, 'videoscategory');
			}
		}
	}
	
	for($i=0;$i<count($category_array1);$i++)
	{
		$parent_catid = 0;
		if(is_array($category_array1[$i]))
		{
			$cat_name_arr = $category_array1[$i];
			for($j=0;$j<count($cat_name_arr);$j++)
			{
				$catname = $cat_name_arr[$j];
				if($j>0)
				{
					$parentcatname = $cat_name_arr[0];
					$parent_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$parentcatname\"");
					$last_catid = $wpdb->get_var("select term_id from $wpdb->terms where name=\"$catname\"");
					wp_update_term( $last_catid, 'videoscategory', $args = array('parent'=>$parent_catid) );
				}
			}
			
		}
	}
}

//===================== Add some Videos ======================//
$post_info = array();
$today = date('Y-m-d');
////Video 1 start///
$image_array = array();
$image_array[] = "http://templatic.net/images/video/video1.jpg";
$post_meta = array(
					"video"		=> '<iframe width="560" height="315" src="//www.youtube.com/embed/syjEN3peCJw" frameborder="0" allowfullscreen></iframe>',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
    
				);
$post_info[] = array(
					"post_title"	=>	'Fun is the Future: Mastering Gamification',
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it </li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Life','Nature','Other','Science','Sports'),
					);
////video 1 end///
////video 2 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video2.jpg";
$post_meta = array(
					"video"			=> '<iframe width="560" height="315" src="//www.youtube.com/embed/YrtANPtnhyg" frameborder="0" allowfullscreen></iframe>',
					"time"			=> '15:19',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
				);
$post_info[] = array(
					"post_title"	=>	'Pranav Mistry: The thrilling potential of SixthSense technology',
					"post_content"	=>	'WTF TV hits the streets to set a world record for how many times one guy can get women on the street to kick him in the nuts. So painful, so funny.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Life','Nature','Other','Science','Sports'),
					);
////Event 2 end///
////Event 3 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video3.jpg";
$post_meta = array(
					"video"		=> '<iframe width="560" height="315" src="//www.youtube.com/embed/jc_-Y9rDN2g" frameborder="0" allowfullscreen></iframe>>',
					"time"		=> '8:22',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'The Philosophical Breakfast Club',
					"post_content"	=>	'This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it</li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Life','Nature','Other','Science','Sports')
					);
////Video 3 end///
////Video 4 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video4.jpg";
$post_meta = array(
					"video"	=> '<iframe width="560" height="315" src="//www.youtube.com/embed/cXQrbxD9_Ng" frameborder="0" allowfullscreen></iframe>',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'What will future jobs look like?',
					"post_content"	=>	"<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style='text-decoration: underline;'>Underline</span> options, you can also use ordered and un-ordered lists:</p>

<a title='link' href='http://templatic.com' target='_blank'>Hyperlinks</a>, images and basic HTML can also be added in your video description.",
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Life','Nature','Other','Science','Sports'),
					);
////Video 4 end///
////Video 5 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video5.jpg";
$post_meta = array(
					"video"		=> '<iframe width="560" height="315" src="//www.youtube.com/embed/0Y8-IzP01lw" frameborder="0" allowfullscreen></iframe>',	
					"time"		=> '13:45',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	"Puppies! Now that I've got your attention, complexity theory",
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it </li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category"	=>	array('Music','Life','Nature','Other','Science'),
					);
////Video 5 end///
////Video 6 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video6.jpg";
$post_meta = array(
					"video"	=> '<iframe src="//player.vimeo.com/video/36970827" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="http://vimeo.com/36970827">Campagnolo. Technologies</a> from <a href="http://vimeo.com/nudesignchannel">NudesignMovies</a> on <a href="https://vimeo.com">Vimeo</a>.</p>',	
					"time"		=> '3:02',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'Campagnolo. Technologies',
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it </li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category" =>	array('Music','Life','Nature','Other'),
					);
////Video 6 end///
////Video 7 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video7.jpg";
$post_meta = array(
					"video"		=> '<iframe width="560" height="315" src="//www.youtube.com/embed/tH5iEf9oxaI" frameborder="0" allowfullscreen></iframe>',	
					"time"		=> '',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'Anne-Marie Slaughter: Can we all "have it all"?',
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>


<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category" =>	array('Music','Life','Nature'),
					);
////Video 7 end///
////Video 8 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video8.jpg";
$post_meta = array(
					"video"		=> '<iframe src="//player.vimeo.com/video/7079347" width="500" height="275" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="http://vimeo.com/7079347">10 tactics for turning information into action (Trailer)</a> from <a href="http://vimeo.com/tacticaltech">Tactical Technology Collective</a> on <a href="https://vimeo.com">Vimeo</a>.</p>',	
					"time"		=> '',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'10 tactics for turning information into action',
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it </li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category" =>	array('Music','Life'),
					);
////Video 8 end///
////Video 9 start///
$image_array = array();
$post_meta = array();
$image_array[] = "http://templatic.net/images/video/video9.jpg";
$post_meta = array(
					"video"		=> '<iframe src="//player.vimeo.com/video/44658040?color=ffffff" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe> <p><a href="http://vimeo.com/44658040">The Future is Ours</a> from <a href="http://vimeo.com/michaelmarantz">Michael Marantz</a> on <a href="https://vimeo.com">Vimeo</a>.</p>',
					"time"		=> '2:53',
                                        "video_upload"=> 'ptthemes_video',
                                        "tl_dummy_content" => 1 
					);
$post_info[] = array(
					"post_title"	=>	'The Future is Ours',
					"post_content"	=>	'<p>This is your <strong>video description</strong> section where you can explain this video in brief. This section can be edited easily from <em>Dashboard&gt;&gt; Video&gt;&gt; Edit</em>. WordPress provides a visual editor to enter this description with a lot of formatting options, You can highlight important content with <strong>Bold</strong>, <em>Italic</em>, <span style="text-decoration: underline;">Underline</span> options, you can also use ordered and un-ordered lists:</p>

<strong>Ordered theme feature list:</strong>
<ol>
<ol>
	<li>Embed <strong>YouTube</strong>, <strong>Vimeo</strong>,<strong> Daily Motion</strong>, etc Videos easily on your website using the embed code they provide</li>
	<li>Upload a video file from your computer using the <strong>WordPress Media Uploader</strong></li>
	<li>Along with the embed code you can also use a <strong>direct URL</strong> to of your Video to embed it </li>
</ol>
</ol>
<strong>Unordered theme feature list:</strong>
<ul>
<ul>
	<li>Theme comes with in built customization options which will allow you to <strong>change colors</strong>, add a <strong>background image</strong>, <strong>header image</strong>, etc.</li>
	<li>We have provided a <strong>custom.css editor</strong> in the back-end which will help you manage your CSS customization easily</li>
	<li>Theme also comes with <strong>Automatic Updates</strong> which will allow you to update your theme directly from dashboard.</li>
</ul>
</ul>
<a title="link" href="http://templatic.com" target="_blank">Hyperlinks</a>, images and basic HTML can also be added in your video description.',
					"post_meta"		=>	$post_meta,
					"post_image"	=>	$image_array,
					"post_category" =>	array('Music'),
					);
////Video 9 end///
update_option('tevolution_cache_disable',1);
wp_schedule_event( time(), 'daily', 'daily_schedule_expire_session');

/* Set On anyone can register at the time of plugin activate */
update_option('users_can_register',1);
        
insert_taxonomy_posts($post_info);
function insert_taxonomy_posts($post_info)
{
	global $wpdb,$current_user;
	for($i=0;$i<count($post_info);$i++)
	{
		$post_title = $post_info[$i]['post_title'];
		$post_count = $wpdb->get_var("SELECT count(ID) FROM $wpdb->posts where post_title like \"$post_title\" and post_type='videos' and post_status in ('publish','draft')");
		if(!$post_count)
		{
			$post_info_arr = array();
			$catids_arr = array();
			$my_post = array();
			$post_info_arr = $post_info[$i];
			$my_post['post_title'] = $post_info_arr['post_title'];
			$my_post['post_content'] = $post_info_arr['post_content'];
			$my_post['post_type'] = "videos";
			if(@$post_info_arr['post_author'])
			{
				$my_post['post_author'] = $post_info_arr['post_author'];
			}else
			{
				$my_post['post_author'] = 1;
			}
			$my_post['post_status'] = 'publish';
			$my_post['post_category'] = $post_info_arr['post_category'];
			$last_postid = wp_insert_post( $my_post );
			add_post_meta($last_postid,'auto_install', "auto_install");
			wp_set_object_terms($last_postid,$post_info_arr['post_category'], $taxonomy = 'videoscategory');
			wp_set_post_terms($last_postid,$post_info_arr['tags_input'],'videostags');
			$post_meta = $post_info_arr['post_meta'];
			if($post_meta)
			{
				foreach($post_meta as $mkey=>$mval)
				{
					update_post_meta($last_postid, $mkey, $mval);
				}
			}
			$post_image1 = $post_info_arr['post_image'];
			set_as_featured_image($last_postid,$post_image1[0]);
		}
	}
}



//Sidebar widget settings: start
$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
$sidebars_widgets = array();

//==============================FRONT BANNER WIDGET AREA SETTINGS START=========================//
//Banner widget settings start
$video_banner = array();
$video_banner[1] = array(
					"title"				=>	'',
					"number"			=>	5,
					"category"			=>	''
					);						
$video_banner['_multiwidget'] = '1';
update_option('widget_tmpl_video_slider_widget', $video_banner);
$video_banner = get_option('widget_tmpl_video_slider_widget');
krsort($video_banner);
foreach($video_banner as $key1=>$val1)
{
	$video_banner_key1 = $key1;
	if(is_int($video_banner_key1))
	{
		break;
	}
}
//Banner widget settings end
$sidebars_widgets["front_banner"] = array("tmpl_video_slider_widget-{$video_banner_key1}");
//==============================FRONT BANNER WIDGET AREA SETTINGS END=========================//
//==============================HOME PAGE CONTENT WIDGET AREA SETTINGS START=========================//
//All Category First Post widget settings start
$category_first_post_widget = array();
$category_first_post_widget[1] = array(
					"title"				=>	'Video Categories',
					"number"			=>	8,
					"view"				=>	'grid',
					"category"			=> ''
					);						
$category_first_post_widget['_multiwidget'] = '1';
update_option('widget_tmpl_widget_per_cat_popular_posts', $category_first_post_widget);
$category_first_post_widget = get_option('widget_tmpl_widget_per_cat_popular_posts');
krsort($category_first_post_widget);
foreach($category_first_post_widget as $key1=>$val1)
{
	$category_first_post_widget_key1 = $key1;
	if(is_int($category_first_post_widget_key1))
	{
		break;
	}
}
//All Category First Post widget settings end
//Latest video widget settings start
$tmpl_widget_latest_videos = array();
$tmpl_widget_latest_videos[1] = array(
					"title"				=>	'Latest Videos',
					"number"			=>	9,
					"post_type"			=>	'videos',
					"view"				=> 'grid',
					"category"			=> ''
					);						
$tmpl_widget_latest_videos['_multiwidget'] = '1';
update_option('widget_tmpl_widget_latest_videos', $tmpl_widget_latest_videos);
$tmpl_widget_latest_videos = get_option('widget_tmpl_widget_latest_videos');
krsort($tmpl_widget_latest_videos);
foreach($tmpl_widget_latest_videos as $key1=>$val1)
{
	$tmpl_widget_latest_videos_key1 = $key1;
	if(is_int($tmpl_widget_latest_videos_key1))
	{
		break;
	}
}
//Latest video widget settings end
$sidebars_widgets["front_content"] = array("tmpl_widget_per_cat_popular_posts-{$category_first_post_widget_key1}","tmpl_widget_latest_videos-{$tmpl_widget_latest_videos_key1}");
//==============================HOME PAGE CONTENT WIDGET AREA SETTINGS END=========================//
//==============================PRIMARY SIDEBAR WIDGET AREA SETTINGS START=========================//
//Advertisement widget settings start
$tmpl_adv_widget = array();
$tmpl_adv_widget[1] = array(
					"double"			=>	'',
					"desc1"				=>	'<a href="http://templatic.com"><img src="'.get_template_directory_uri().'/library/images/advt.png"/></a>'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Subscriber widget settings start
$tmpl_subscriber_widget = array();
$tmpl_subscriber_widget[1] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'mailchimp',
					"mailchimp_api_key"		=> '',
					"mailchimp_list_id"		=> ''
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end
//Popular post widget settings start
$tmpl_widget_popular_posts = array();
$tmpl_widget_popular_posts[1] = array(
					"title"					=>	'Popular Videos',
					"number"				=>	5,
					"show_excerpt"			=>	'',
					"post_type"				=> 'videos',
					"view"					=> 'list',
					"popular_per"			=> 'comments'
					);						
$tmpl_widget_popular_posts['_multiwidget'] = '1';
update_option('widget_tmpl_widget_popular_posts', $tmpl_widget_popular_posts);
$tmpl_widget_popular_posts = get_option('widget_tmpl_widget_popular_posts');
krsort($tmpl_widget_popular_posts);
foreach($tmpl_widget_popular_posts as $key1=>$val1)
{
	$tmpl_widget_popular_posts_key1 = $key1;
	if(is_int($tmpl_widget_popular_posts_key1))
	{
		break;
	}
}
//Popular post widget settings end
$sidebars_widgets["sidebar1"] = array("tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}","tmpl_widget_popular_posts-{$tmpl_widget_popular_posts_key1}");
//==============================PRIMARY SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================HOME PAGE SIDEBAR WIDGET AREA SETTINGS START=========================//
//Advertisement widget settings start
$tmpl_adv_widget[2] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[3] = array(
					"double"			=>	'',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key2=>$val1)
{
	$tmpl_adv_widget_key2 = $key2;
	if(is_int($tmpl_adv_widget_key2))
	{
		break;
	}
}
//Advertisement widget settings end
//Popular post widget settings start
$tmpl_widget_popular_posts[2] = array(
					"title"					=>	'Popular Videos',
					"number"				=>	8,
					"show_excerpt"			=>	'',
					"post_type"				=> 'videos',
					"view"					=> 'grid',
					"popular_per"			=> 'views'
					);						
$tmpl_widget_popular_posts['_multiwidget'] = '1';
update_option('widget_tmpl_widget_popular_posts', $tmpl_widget_popular_posts);
$tmpl_widget_popular_posts = get_option('widget_tmpl_widget_popular_posts');
krsort($tmpl_widget_popular_posts);
foreach($tmpl_widget_popular_posts as $key1=>$val1)
{
	$tmpl_widget_popular_posts_key1 = $key1;
	if(is_int($tmpl_widget_popular_posts_key1))
	{
		break;
	}
}
//Popular post widget settings end
//Video Category widget settings start
$tmpl_categories_widget = array();
$tmpl_categories_widget[1] = array(
					"title"					=>	'',
					"dropdown"				=>	'',
					"count"					=>	1,
					"hierarchical"			=> ''
					);						
$tmpl_categories_widget['_multiwidget'] = '1';
update_option('widget_tmpl_categories_widget', $tmpl_categories_widget);
$tmpl_categories_widget = get_option('widget_tmpl_categories_widget');
krsort($tmpl_categories_widget);
foreach($tmpl_categories_widget as $key1=>$val1)
{
	$tmpl_categories_widget_key1 = $key1;
	if(is_int($tmpl_categories_widget_key1))
	{
		break;
	}
}
//Video Category widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[4] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key3=>$val1)
{
	$tmpl_adv_widget_key3 = $key3;
	if(is_int($tmpl_adv_widget_key3))
	{
		break;
	}
}
//Advertisement widget settings end
//Recent comment widget settings start
$recent_comments_widget = array();
$recent_comments_widget[1] = array(
					"title"				=>	'',
					"number"			=>	5
					);						
$recent_comments_widget['_multiwidget'] = '1';
update_option('widget_recent-comments', $recent_comments_widget);
$recent_comments_widget = get_option('widget_recent-comments');
krsort($recent_comments_widget);
foreach($recent_comments_widget as $key1=>$val1)
{
	$recent_comments_widget_key1 = $key1;
	if(is_int($recent_comments_widget_key1))
	{
		break;
	}
}
//Recent comment widget settings end
$sidebars_widgets["front_sidebar"] = array("tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key2}","tmpl_widget_popular_posts-{$tmpl_widget_popular_posts_key1}","tmpl_categories_widget-{$tmpl_categories_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key3}","recent-comments-{$recent_comments_widget_key1}");
//==============================HOME PAGE SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================BLOG LISTING PAGE SIDEBAR WIDGET AREA SETTINGS START=========================//
//Author widget settings start
$tmpl_author_widget = array();
$tmpl_author_widget[1] = array(
					"title"				=>	''
					);						
$tmpl_author_widget['_multiwidget'] = '1';
update_option('widget_tmpl_author_widget', $tmpl_author_widget);
$recent_comments_widget = get_option('widget_tmpl_author_widget');
krsort($tmpl_author_widget);
foreach($tmpl_author_widget as $key1=>$val1)
{
	$tmpl_author_widget_key1 = $key1;
	if(is_int($tmpl_author_widget_key1))
	{
		break;
	}
}
//Author widget settings end
//Subscriber widget settings start
$tmpl_subscriber_widget[2] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'feedburner',
					"feedburner_id"			=> 'templatic'
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end
//Social Media widget settings start
$social_media = array();
$social_media[1] = array(
				"title"						=>	'Connect With US',
				"social_description"		=>	'',
				"social_link"				=>	array('http://facebook.com/templatic','http://twitter.com/templatic','http://www.youtube.com/user/templatic','http://www.youtube.com/user/templatic','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com'),
				"social_icon"				=>	array('<i class="fa fa-facebook"></i>','<i class="fa fa-twitter"></i>','<i class="fa fa-linkedin"></i>','<i class="fa fa-youtube"></i>','<i class="fa fa-google-plus"></i>','<i class="fa fa-pinterest"></i>','<i class="fa fa-dribbble"></i>','<i class="fa fa-flickr"></i>','<i class="fa fa-github"></i>','<i class="fa fa-instagram"></i>','<i class="fa fa-skype"></i>','<i class="fa fa-tumblr"></i>'),
				"social_text"				=>	array('facebook','twitter','linkedin','youtube','google-plus','pinterest','dribbble','flickr','github','instagram','skype','tumblr')
				);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key=>$val)
{
	$social_media_key1 = $key;
	if(is_int($social_media_key1))
	{
		break;
	}
}
//Social Media widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[5] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[6] = array(
					"double"			=>	'',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key2=>$val1)
{
	$tmpl_adv_widget_key2 = $key2;
	if(is_int($tmpl_adv_widget_key2))
	{
		break;
	}
}
//Advertisement widget settings end
//Categories widget settings start
$categories = array();
$categories[1] = array(
					"title"					=>	'',
					"dropdown"				=>	'',
					"count"					=>	1,
					"hierarchical"			=> '1'
					);						
$categories['_multiwidget'] = '1';
update_option('widget_categories', $categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key1 = $key1;
	if(is_int($categories_key1))
	{
		break;
	}
}
//Categories widget settings end
//Related,Popular,Latest tab widget settings start
$tmpl_realted_plopular_latest_widget = array();
$tmpl_realted_plopular_latest_widget[1] = array(
					"title"					=>	'',
					"number"				=>	6,
					"post_type"				=>	'post',
					"show_related"			=>  1,
					"show_popular"			=>  1,
					"show_latest"			=>  1,
					"show_tag"				=>  1
					);						
$tmpl_realted_plopular_latest_widget['_multiwidget'] = '1';
update_option('widget_tmpl_realted_plopular_latest_widget', $tmpl_realted_plopular_latest_widget);
$tmpl_realted_plopular_latest_widget = get_option('widget_tmpl_realted_plopular_latest_widget');
krsort($tmpl_realted_plopular_latest_widget);
foreach($tmpl_realted_plopular_latest_widget as $key1=>$val1)
{
	$tmpl_realted_plopular_latest_widget_key1 = $key1;
	if(is_int($tmpl_realted_plopular_latest_widget_key1))
	{
		break;
	}
}
//Related,Popular,Latest tab widget settings end

$sidebars_widgets["post_category_sidebar"] = array("tmpl_author_widget-{$tmpl_author_widget_key1}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}","social_media-{$social_media_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key2}","categories-{$categories_key1}","$tmpl_realted_plopular_latest_widget-{$tmpl_realted_plopular_latest_widget_key1}");
//==============================BLOG LISTING PAGE SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================BLOG DETAIL PAGE SIDEBAR WIDGET AREA SETTINGS START=========================//
//Author widget settings start
$tmpl_author_widget[2] = array(
					"title"				=>	''
					);						
$tmpl_author_widget['_multiwidget'] = '1';
update_option('widget_tmpl_author_widget', $tmpl_author_widget);
$recent_comments_widget = get_option('widget_tmpl_author_widget');
krsort($tmpl_author_widget);
foreach($tmpl_author_widget as $key1=>$val1)
{
	$tmpl_author_widget_key1 = $key1;
	if(is_int($tmpl_author_widget_key1))
	{
		break;
	}
}
//Author widget settings end
//Subscriber widget settings start
$tmpl_subscriber_widget[3] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'feedburner',
					"feedburner_id"			=> 'templatic'
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end
//Social Media widget settings start
$social_media[2] = array(
				"title"						=>	'Connect With US',
				"social_description"		=>	'',
				"social_link"				=>	array('http://facebook.com/templatic','http://twitter.com/templatic','http://www.youtube.com/user/templatic','http://www.youtube.com/user/templatic','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com'),
				"social_icon"				=>	array('<i class="fa fa-facebook"></i>','<i class="fa fa-twitter"></i>','<i class="fa fa-linkedin"></i>','<i class="fa fa-youtube"></i>','<i class="fa fa-google-plus"></i>','<i class="fa fa-pinterest"></i>','<i class="fa fa-dribbble"></i>','<i class="fa fa-flickr"></i>','<i class="fa fa-github"></i>','<i class="fa fa-instagram"></i>','<i class="fa fa-skype"></i>','<i class="fa fa-tumblr"></i>'),
				"social_text"				=>	array('facebook','twitter','linkedin','youtube','google-plus','pinterest','dribbble','flickr','github','instagram','skype','tumblr')
				);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key=>$val)
{
	$social_media_key1 = $key;
	if(is_int($social_media_key1))
	{
		break;
	}
}
//Social Media widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[7] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[8] = array(
					"double"			=>	'',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key2=>$val1)
{
	$tmpl_adv_widget_key2 = $key2;
	if(is_int($tmpl_adv_widget_key2))
	{
		break;
	}
}
//Advertisement widget settings end
//Categories widget settings start
$categories[2] = array(
					"title"					=>	'',
					"dropdown"				=>	'',
					"count"					=>	1,
					"hierarchical"			=> ''
					);						
$categories['_multiwidget'] = '1';
update_option('widget_categories', $categories);
$categories = get_option('widget_categories');
krsort($categories);
foreach($categories as $key1=>$val1)
{
	$categories_key1 = $key1;
	if(is_int($categories_key1))
	{
		break;
	}
}
//Categories widget settings end
//Related,Popular,Latest tab widget settings start
$tmpl_realted_plopular_latest_widget[2] = array(
					"title"					=>	'',
					"number"				=>	6,
					"post_type"				=>	'post',
					"show_related"			=>  1,
					"show_popular"			=>  1,
					"show_latest"			=>  1,
					"show_tag"				=>  1
					);						
$tmpl_realted_plopular_latest_widget['_multiwidget'] = '1';
update_option('widget_tmpl_realted_plopular_latest_widget', $tmpl_realted_plopular_latest_widget);
$tmpl_realted_plopular_latest_widget = get_option('widget_tmpl_realted_plopular_latest_widget');
krsort($tmpl_realted_plopular_latest_widget);
foreach($tmpl_realted_plopular_latest_widget as $key1=>$val1)
{
	$tmpl_realted_plopular_latest_widget_key1 = $key1;
	if(is_int($tmpl_realted_plopular_latest_widget_key1))
	{
		break;
	}
}
//Related,Popular,Latest tab widget settings end

$sidebars_widgets["post_detail_sidebar"] = array("tmpl_author_widget-{$tmpl_author_widget_key1}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}","social_media-{$social_media_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key2}","categories-{$categories_key1}","$tmpl_realted_plopular_latest_widget-{$tmpl_realted_plopular_latest_widget_key1}");
//==============================BLOG DETAIL PAGE SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================VIDEO LISTING PAGE SIDEBAR WIDGET AREA SETTINGS START=========================//
//Categories widget settings start
$tmpl_categories_widget[2] = array(
					"title"					=>	'',
					"dropdown"				=>	'',
					"count"					=>	1,
					"hierarchical"			=> ''
					);						
$tmpl_categories_widget['_multiwidget'] = '1';
update_option('widget_tmpl_categories_widget', $tmpl_categories_widget);
$tmpl_categories_widget = get_option('widget_tmpl_categories_widget');
krsort($tmpl_categories_widget);
foreach($tmpl_categories_widget as $key1=>$val1)
{
	$tmpl_categories_widget_key1 = $key1;
	if(is_int($tmpl_categories_widget_key1))
	{
		break;
	}
}
//Video Category widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[9] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[10] = array(
					"double"			=>	'',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key2=>$val1)
{
	$tmpl_adv_widget_key2 = $key2;
	if(is_int($tmpl_adv_widget_key2))
	{
		break;
	}
}
//Advertisement widget settings end
//Subscriber widget settings start
$tmpl_subscriber_widget[4] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'mailchimp',
					"mailchimp_api_key"		=> '',
					"mailchimp_list_id"		=> ''
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end

$sidebars_widgets["video_category_sidebar"] = array("tmpl_categories_widget-{$tmpl_categories_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key2}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}");
//==============================VIDEO LISTING PAGE SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================VIDEO DETAIL PAGE SIDEBAR WIDGET AREA SETTINGS START=========================//
//Popular post widget settings start
$tmpl_widget_related_posts = array();
$tmpl_widget_related_posts[1] = array(
					"title"					=>	'Similar Videos',
					"number"				=>	5
					);						
$tmpl_widget_related_posts['_multiwidget'] = '1';
update_option('widget_tmpl_widget_related_posts', $tmpl_widget_related_posts);
$tmpl_widget_related_posts = get_option('widget_tmpl_widget_related_posts');
krsort($tmpl_widget_related_posts);
foreach($tmpl_widget_related_posts as $key1=>$val1)
{
	$tmpl_widget_related_posts_key1 = $key1;
	if(is_int($tmpl_widget_related_posts_key1))
	{
		break;
	}
}
//Subscriber widget settings start
$tmpl_subscriber_widget[5] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'mailchimp',
					"mailchimp_api_key"		=> '',
					"mailchimp_list_id"		=> ''
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end
//Social Media widget settings start
$social_media[3] = array(
				"title"						=>	'Connect With US',
				"social_description"		=>	'',
				"social_link"				=>	array('http://facebook.com/templatic','http://twitter.com/templatic','http://www.youtube.com/user/templatic','http://www.youtube.com/user/templatic','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com'),
				"social_icon"				=>	array('<i class="fa fa-facebook"></i>','<i class="fa fa-twitter"></i>','<i class="fa fa-linkedin"></i>','<i class="fa fa-youtube"></i>','<i class="fa fa-google-plus"></i>','<i class="fa fa-pinterest"></i>','<i class="fa fa-dribbble"></i>','<i class="fa fa-flickr"></i>','<i class="fa fa-github"></i>','<i class="fa fa-instagram"></i>','<i class="fa fa-skype"></i>','<i class="fa fa-tumblr"></i>'),
				"social_text"				=>	array('facebook','twitter','linkedin','youtube','google-plus','pinterest','dribbble','flickr','github','instagram','skype','tumblr')
				);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key=>$val)
{
	$social_media_key1 = $key;
	if(is_int($social_media_key1))
	{
		break;
	}
}
//Social Media widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[11] = array(
					"double"			=>	'1',
					"desc1"				=>	'<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">',
					"desc2"				=>  '<img src="http://placehold.it/121x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key1=>$val1)
{
	$tmpl_adv_widget_key1 = $key1;
	if(is_int($tmpl_adv_widget_key1))
	{
		break;
	}
}
//Advertisement widget settings end
//Advertisement widget settings start
$tmpl_adv_widget[12] = array(
					"double"			=>	'',
					"desc1"				=>	'<img src="http://placehold.it/262x121/cdcdcd/999999&text=Advt" class="thumb-img">'
					);						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key2=>$val1)
{
	$tmpl_adv_widget_key2 = $key2;
	if(is_int($tmpl_adv_widget_key2))
	{
		break;
	}
}
//Advertisement widget settings end
//Popular post widget settings end
$tmpl_categories_widget[3] = array(
					"title"					=>	'',
					"dropdown"				=>	'',
					"count"					=>	1,
					"hierarchical"			=> ''
					);						
$tmpl_categories_widget['_multiwidget'] = '1';
update_option('widget_tmpl_categories_widget', $tmpl_categories_widget);
$tmpl_categories_widget = get_option('widget_tmpl_categories_widget');
krsort($tmpl_categories_widget);
foreach($tmpl_categories_widget as $key1=>$val1)
{
	$tmpl_categories_widget_key1 = $key1;
	if(is_int($tmpl_categories_widget_key1))
	{
		break;
	}
}
//Video Category widget settings end

$sidebars_widgets["video_detail_sidebar"] = array("tmpl_widget_related_posts-{$tmpl_widget_related_posts_key1}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}","social_media-{$social_media_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key1}","tmpl_adv_widget-{$tmpl_adv_widget_key2}","tmpl_categories_widget-{$tmpl_categories_widget_key1}");
//==============================VIDEO DETAIL PAGE SIDEBAR WIDGET AREA SETTINGS END=========================//
//==============================FOOTER WIDGET AREA SETTINGS START=========================//
//Text widget settings start
$text = array();
$text[1] = array(
					"title"					=>	'About Us',
					"text"					=>	'Create a <strong>beautiful video portal</strong> using this sleek looking theme. Best part about the theme is we have kept it as simple as we could, along with the videos the theme can be used for blogging too. Our primary goal while creating the theme was it should work faster then any theme we created till date, the demo site shows this works fast. <br/><a href="http://templatic.com/app-themes/wordpress-video-theme">Purchase this theme</a>'
					);						
$text['_multiwidget'] = '1';
update_option('widget_text', $text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key1=>$val1)
{
	$text_key1 = $key1;
	if(is_int($text_key1))
	{
		break;
	}
}
//Video Category widget settings end
$tmpl_categories_widget[4] = array(
					"title"					=>	'Video Categories',
					"dropdown"				=>	'',
					"count"					=>	'',
					"hierarchical"			=> ''
					);						
$tmpl_categories_widget['_multiwidget'] = '1';
update_option('widget_tmpl_categories_widget', $tmpl_categories_widget);
$tmpl_categories_widget = get_option('widget_tmpl_categories_widget');
krsort($tmpl_categories_widget);
foreach($tmpl_categories_widget as $key1=>$val1)
{
	$tmpl_categories_widget_key1 = $key1;
	if(is_int($tmpl_categories_widget_key1))
	{
		break;
	}
}
//Video Category widget settings end

//Subscriber widget settings start
$tmpl_subscriber_widget[6] = array(
					"title"					=>	'Subscribe To Newsletter',
					"text"					=>	'Get latest news about us directly in your inbox. We will never spam, Promise.',
					"newsletter_provider"	=>	'feedburner',
					"feedburner_id"			=>  'templatic'
					);						
$tmpl_subscriber_widget['_multiwidget'] = '1';
update_option('widget_tmpl_subscriber_widget', $tmpl_subscriber_widget);
$tmpl_subscriber_widget = get_option('widget_tmpl_subscriber_widget');
krsort($tmpl_subscriber_widget);
foreach($tmpl_subscriber_widget as $key1=>$val1)
{
	$tmpl_subscriber_widget_key1 = $key1;
	if(is_int($tmpl_subscriber_widget_key1))
	{
		break;
	}
}
//Subscriber widget settings end
//Social Media widget settings start
$social_media[4] = array(
				"title"						=>	'Connect With US',
				"social_description"		=>	'',
				"social_link"				=>	array('http://facebook.com/templatic','http://twitter.com/templatic','http://www.youtube.com/user/templatic','http://www.youtube.com/user/templatic','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com','http://templatic.com'),
				"social_icon"				=>	array('<i class="fa fa-facebook"></i>','<i class="fa fa-twitter"></i>','<i class="fa fa-linkedin"></i>','<i class="fa fa-youtube"></i>','<i class="fa fa-google-plus"></i>','<i class="fa fa-pinterest"></i>','<i class="fa fa-dribbble"></i>','<i class="fa fa-flickr"></i>','<i class="fa fa-github"></i>','<i class="fa fa-instagram"></i>','<i class="fa fa-skype"></i>','<i class="fa fa-tumblr"></i>'),
				"social_text"				=>	array('facebook','twitter','linkedin','youtube','google-plus','pinterest','dribbble','flickr','github','instagram','skype','tumblr')
				);						
$social_media['_multiwidget'] = '1';
update_option('widget_social_media',$social_media);
$social_media = get_option('widget_social_media');
krsort($social_media);
foreach($social_media as $key=>$val)
{
	$social_media_key1 = $key;
	if(is_int($social_media_key1))
	{
		break;
	}
}
//Social Media widget settings end

$sidebars_widgets["footer_content"] = array("text-{$text_key1}","tmpl_categories_widget-{$tmpl_categories_widget_key1}","tmpl_subscriber_widget-{$tmpl_subscriber_widget_key1}","social_media-{$social_media_key1}");
//==============================FOOTER WIDGET AREA SETTINGS END=========================//
//==============================SUBMIT VIDEO PAGE START=========================//
//text widget
$text[2] = array(
					"title" =>	'Submit your videos',
					"text" 	=>	'Share your videos on our popular video portal. Get maximum exposure to your videos and enjoy our friendly community. Please note that all submitted videos will require admin approval before they go live.'
					);						
$text['_multiwidget'] = '1';
update_option('widget_text', $text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key2=>$val2)
{
	$text_key2 = $key2;
	if(is_int($text_key2))
	{
		break;
	}
}

/* dashboard widget */
$widget_login = array();
$widget_login[1] = array(
					"title"				=>	__('Dashboard','templatic'),
					"hierarchical"		=>	1,
					);						
$widget_login['_multiwidget'] = '1';
update_option('widget_widget_login',$widget_login);
$widget_login = get_option('widget_widget_login');
krsort($widget_login);
foreach($widget_login as $key1=>$val1)
{
	$widget_login_key1 = $key1;
	if(is_int($widget_login_key1))
	{
		break;
	}
}

/* advertisement widget */
$tmpl_adv_widget[13] = array(
                                "double"			=>	'',
                                "desc1"				=>	'<a href="http://templatic.com"><img src="'.get_template_directory_uri().'/library/images/advt.png"/></a>'
                            );						
$tmpl_adv_widget['_multiwidget'] = '1';
update_option('widget_tmpl_adv_widget', $tmpl_adv_widget);
$tmpl_adv_widget = get_option('widget_tmpl_adv_widget');
krsort($tmpl_adv_widget);
foreach($tmpl_adv_widget as $key13=>$val13)
{
	$tmpl_adv_widget_key13 = $key13;
	if(is_int($tmpl_adv_widget_key13))
	{
		break;
	}
}
$sidebars_widgets["video_submit_page"] = array("tmpl_adv_widget-{$tmpl_adv_widget_key13}","widget_login-{$widget_login_key1}","text-{$text_key2}");

//hedaer right side widget
$text[3] = array(
					"title" =>	'',
					"text" 	=>	"[header-right-menu login='1' register='1' author_link='1' submit_video='1']"
					);						
$text['_multiwidget'] = '1';
update_option('widget_text', $text);
$text = get_option('widget_text');
krsort($text);
foreach($text as $key3=>$val3)
{
	$text_key3 = $key3;
	if(is_int($text_key3))
	{
		break;
	}
}

$sidebars_widgets["header_right"] = array("text-{$text_key3}");
//==============================SUBMIT VIDEO PAGE END=========================//
update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations 

function set_as_featured_image($post_id,$post_image1) {  
    // only want to do this if the post has no thumbnail
  if(!has_post_thumbnail($post_id)) 
  { 
        $post_array = get_post($post_id, ARRAY_A);
        $title = $post_array['post_title'];
		
		require_once(ABSPATH . "wp-admin" . '/includes/image.php');
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        // next, download the URL of the image
        $upload = media_sideload_image($post_image1, $post_id, $title);

        // find the most recent attachment for the given post
        $attachments = get_posts(
            array(
                'post_type' => 'attachment',
                'numberposts' => 1,
                'order' => 'DESC',
                'post_parent' => $post_id
            )
        );
        $attachment = $attachments[0];
        // and set it as the post thumbnail
        set_post_thumbnail( $post_id, $attachment->ID );

    } // end if

} 

// Regenerate the thumbnail.
regenerate_all_attachment_sizes();
 
function regenerate_all_attachment_sizes() {
	$args = array( 'post_type' => 'attachment', 'numberposts' => 100, 'post_status' => 'attachment'); 
	$attachments = get_posts( $args );
	if ($attachments) {
		foreach ( $attachments as $post ) {
			$file = get_attached_file( $post->ID );
			wp_update_attachment_metadata( $post->ID, wp_generate_attachment_metadata( $post->ID, $file ) );
		}
	}		
}
?>
