<?php 
/* get the color settings from customizer and write in theme_options.css file located in functions */
function video_hex2rgb($hex='') {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

/*
    File contain the code for color options in customizer 
*/	

global $wpdb;
/* get the different colors */
if(function_exists('templatic_theme_settings')){
	$color1 = templatic_theme_settings( 'color_picker_color1' );
	$color2 = templatic_theme_settings( 'color_picker_color2' );
	$color3 = templatic_theme_settings( 'color_picker_color3' );
	$color4 = templatic_theme_settings( 'color_picker_color4' );
	$color5 = templatic_theme_settings( 'color_picker_color5' );
	$color6 = templatic_theme_settings( 'color_picker_color6' );
	
}else{
	$templatic_theme_settings = get_option('templatic_theme_settings');
	if(isset($templatic_theme_settings[ 'color_picker_color1' ]) && $templatic_theme_settings[ 'color_picker_color1' ] !=''):
		$color1 = $templatic_theme_settings[ 'color_picker_color1' ];
	else:
		$color1 ='';
	endif;
	
	if(isset($templatic_theme_settings[ 'color_picker_color2' ]) && $templatic_theme_settings[ 'color_picker_color2' ] !=''):
		$color2 = $templatic_theme_settings[ 'color_picker_color2' ];
	else:
		$color2 = '';
	endif;
	
	if(isset($templatic_theme_settings[ 'color_picker_color3' ]) && $templatic_theme_settings[ 'color_picker_color3' ] !=''):
		$color3 = $templatic_theme_settings[ 'color_picker_color3' ];
	else:
		$color3 ='';
	endif;
	
	if(isset($templatic_theme_settings[ 'color_picker_color4' ]) && $templatic_theme_settings[ 'color_picker_color4' ] !=''):
		$color4 = $templatic_theme_settings[ 'color_picker_color4' ];
	else:
		$color4 = '';
	endif;
	
	if(isset($templatic_theme_settings[ 'color_picker_color5' ]) && $templatic_theme_settings[ 'color_picker_color5' ] !=''):
		$color5 = $templatic_theme_settings[ 'color_picker_color5' ];
	else:
		$color5 ='';
	endif;
}

//Change color of body background
if($color1 != "#" || $color1 != ""){
	$color1_rgba = video_hex2rgb($color1);
	$none = '';
	if($color1 != '') {
		$none = 'none';
	}
$backgroundcolor1 = '';
$background_color1 = '';
$background_color_imp1 = '';
if(!empty($color1))
{	
	$backgroundcolor1 = 'background: '.$color1;
	$background_color1 = 'background-color: '.$color1;
	$background_color_imp1 = 'background-color: '.$color1.' !important';
}
	
	$color_data=<<<COLOR1
.top-bar-section li.active:not(.has-form) a:not(.button), .top-bar-section > ul > li.active:not(.has-form) > a:hover:not(.button) {
	border-bottom:$none;
}

body, .accordion .content.active, .f-dropdown, .f-dropdown.content, fieldset legend, [data-magellan-expedition], div.switch, div.switch span:last-child, div.switch:hover span:last-child, div.switch:focus span:last-child, table, .tabs dd.active a, .commentlist .vcard img.avatar, .respond-form form input[type=text]:focus, .respond-form form input[type=email]:focus, .respond-form form input[type=url]:focus, .respond-form form textarea:focus  {
  $backgroundcolor1;
}
input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .pricing-table .description, .pricing-table .bullet-item, .pricing-table .cta-button, dialog, .reveal-modal, .tabs.radius dd > a:focus, .tabs.radius dd > a:active, .tabs.radius dd.active a, .widget_tabs .tabs.radius dd.active a, .joyride-expose-wrapper, .breadcrumbs,
.meta-transparent-buttons a.button, .meta-transparent-buttons .button, .meta-transparent-buttons span.button,
.panel {
  $background_color1;	
}


.top-bar-section li.active:not(.has-form) a:not(.button),
.sub-nav dt.active a, .sub-nav dd.active a, .sub-nav li.active a,
.top-bar-section ul li.active > a,
header .top-nav .sub-nav li a:hover,
body .top-bar-section ul li:hover:not(.has-form) > a,
.top-bar-section li.active:not(.has-form) a:not(.button), .top-bar-section li.current_page_item:not(.has-form) a:not(.button) {
	color: $color1 !important;
}  
button, .button,
.orbit-caption a.button,
.header .menu ul li.listing-btn a {
	color: $color1;
}
body .widget_video_slider .orbit-caption a.button:hover {
	color:$color1 !important;
}
.widget_contact_info .social li a {
	color:$color1;
}
.widget_contact_info .social li a:hover {
	$background_color_imp1;
}

.orbit-container .orbit-prev > span, .orbit-container .orbit-prev:hover > span, .preloader {
  border-right-color: $color1;
}
.orbit-container .orbit-next > span, .orbit-container .orbit-next:hover > span, .preloader {
  border-left-color: $color1;	
}
.progress, .th, .orbit-container .orbit-timer > span, .breadcrumbs {
  border-color: $color1;	
  }
.side-nav li.divider {
  border-top-color: $color1;
}

.more-social ul.more {
	border-color:$color1;
	box-shadow:$none;
}
.tabs.radius dd.active a,
.tabs.radius dd.active a:focus, .tabs.radius dd.active a:active, .tabs.radius dd.active a:hover {
	$background_color1;
	border-bottom-color:$color1;
}
input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea, .respond-form form input[type="text"], .respond-form form input[type="email"], .respond-form form input[type="url"], .respond-form form textarea {
	box-shadow:$none;
}
input[type="text"]:focus, input[type="password"]:focus, input[type="date"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, textarea:focus, .respond-form form input[type="text"], .respond-form form input[type="email"], .respond-form form input[type="url"], .respond-form form textarea, .entry-content pre,

input[type="text"]:focus, input[type="text"]:active, input[type="password"]:focus, input[type="password"]:active, input[type="date"]:focus, input[type="date"]:active, input[type="datetime"]:focus, input[type="datetime"]:active, input[type="datetime-local"]:focus, input[type="datetime-local"]:active, input[type="month"]:focus, input[type="month"]:active, input[type="week"]:focus, input[type="week"]:active, input[type="email"]:focus, input[type="email"]:active, input[type="number"]:focus, input[type="number"]:active, input[type="search"]:focus, input[type="search"]:active, input[type="tel"]:focus, input[type="tel"]:active, input[type="time"]:focus, input[type="time"]:active, input[type="url"]:focus, input[type="url"]:active, textarea:focus, textarea:active, .respond-form form input[type="text"]:focus, .respond-form form input[type="text"]:active, .respond-form form input[type="email"]:focus, .respond-form form input[type="email"]:active, .respond-form form input[type="url"]:focus, .respond-form form input[type="url"]:active, .respond-form form textarea:focus, .respond-form form textarea:active {
	background:$none;
}
.top-bar .top-bar-section #searchform input[type="text"]:focus,
.top-bar .top-bar-section #searchform input[type="text"]:active,
.left-off-canvas-menu #searchform input[type="text"]:focus,
.left-off-canvas-menu #searchform input[type="text"]:active {
	$background_color1;
}
.sub-nav dt.active a, .sub-nav dd.active a, .sub-nav li.active a, .top-bar .toggle-topbar a, .top-bar .toggle-topbar.menu-icon a, .top-bar-section ul li > a, .top-bar-section ul li:hover > a, .top-bar-section ul li.active > a, .top-bar-section ul li.active > a:hover, .top-bar-section .dropdown li.title h5 a, .top-bar-section li.hover > a:not(.button), .top-bar-section li.active:not(.has-form) a:not(.button), .top-bar-section .dropdown li a, .no-js .top-bar-section ul li:hover > a, .no-js .top-bar-section ul li:active > a, .tab-bar, .tab-bar h1, .tab-bar h2, .tab-bar h3, .tab-bar h4, .tab-bar h5, .tab-bar h6, header .top-nav .sub-nav li a{
	color:$color1;
}
COLOR1;
}// Finish Color 1 if condition


//Change blue color 
if($color2 != "#" || $color2 != ""){
	$color2_rgba = video_hex2rgb($color2);
	$color2_1 = '0';
	$color2_2 = 0;
	$color2_3 = 0;
	if($color2_rgba[0] >= 0 && $color2_rgba[1] > 0)
	{
		$color2_1 = $color2_rgba[0];
	}
	if($color2_rgba[1] > 0 )
	{
		$color2_2 = $color2_rgba[1];
	}
	if($color2_rgba[2] > 0 )
	{
		$color2_3 = $color2_rgba[2];
	}

	if($color2 != '') {
		$none = 'none';
	}

	$color_data.=<<<COLOR2
body, .accordion dd > a, .breadcrumbs > *.current, .breadcrumbs > *.current a, .keystroke, kbd , ul.pagination li, table thead tr th, table thead tr td, table tfoot tr th, table tfoot tr td, table tr th, table tr td , .tabs dd > a,  abbr, acronym, .comment-author cite, .comment_content p, .filter .custom-select select, #content .grid-list-btn .button-group li > button, #content .grid-list-btn .button-group li .button, .tabs.radius dd > a:focus, .tabs.radius dd > a:active, #content .grid-list-btn .button-group li > button, #content .grid-list-btn .button-group li .button,


ul.pagination li.current a, ul.pagination li.current a:hover, ul.pagination li.current a:focus, .progress .meter, .top-bar-section ul li > a.button, .top-bar-section ul li.active > a, .no-js .top-bar-section ul li:active > a, .top-bar-section li.active:not(.has-form) a:hover:not(.button),



#content .grid-list-btn .button-group li > button.active i, 
#content .grid-list-btn .button-group li .button.active i, 
#content .grid-list-btn .button-group li > button:hover i, 
#content .grid-list-btn .button-group li .button:hover i,
.more-social ul.more li a,
.breadcrumbs > *
.page-nav .prev-icon a, .page-nav .next-icon a,
input.cancel-btn[type="button"]:hover, input.cancel-btn[type="button"]:focus,
.top-bar-section li.active:not(.has-form) a:not(.button), .sub-nav dt.active a, .sub-nav dd.active a, .sub-nav li.active a, .top-bar-section ul li.active > a, header .top-nav .sub-nav li a:hover, button, .button, input[type="submit"], .top-nav .sub-nav dt.active a, .top-nav .sub-nav dd.active a, .top-nav .sub-nav li.active a,
.right_box .user_dsb_cf span{
  color: $color2;	
}
.autho-post-view button, .autho-post-view .button {color: $color2 !important;}
.transparent-btn a.button:hover,
.meta-transparent-buttons a.button:hover,
.top-bar-section li.active:not(.has-form) a:hover:not(.button),
.top-bar-section li:not(.has-form) a:hover:not(.button),
.meta-transparent-buttons a.button:hover, .meta-transparent-buttons .button:hover, .meta-transparent-buttons span.button:hover,
.more-social ul.more li a:hover,
input.cancel-btn[type="button"]	{ 
  background-color: $color2; 
}

.transparent-btn a.button:hover,
.meta-transparent-buttons a.button:hover, .meta-transparent-buttons a.button:hover, .meta-transparent-buttons .button:hover, .meta-transparent-buttons span.button:hover {
  border-color: $color2; 
}
.meta-transparent-buttons li:first-child a.button:hover {
  border-left-color: $color2; 
}


#post-author, 
.meta-transparent-buttons a.button, 
.meta-transparent-buttons .button, 
.meta-transparent-buttons span.button,
.tabs.radius dd > a,
#content .grid-list-btn .button-group li > button, #content .grid-list-btn .button-group li .button,
.meta-transparent-buttons .disabled-btn
	 {
	 	background-color:rgba($color2_1,$color2_2,$color2_3,0.03);
	 	color:$color2;
	 }



.meta-transparent-buttons .disabled-btn ,
#content .grid-list-btn .button-group li > button.active, #content .grid-list-btn .button-group li .button.active,
#content .grid-list-btn .button-group li > button:hover, #content .grid-list-btn .button-group li .button:hover,
.tabs.radius dd > a:focus, .tabs.radius dd > a:active, .tabs.radius dd > a:hover
	{background-color:rgba($color2_1,$color2_2,$color2_3,0.12);}

#post-author,
.meta-transparent-buttons a.button, 
.meta-transparent-buttons .button, 
.meta-transparent-buttons span.button,
.meta-transparent-buttons .disabled-btn {border-color:rgba($color2_1,$color2_2,$color2_3,0.2);}

.tabs.radius dd a,
.tabs.radius dd > a:focus, .tabs.radius dd > a:active, .tabs.radius dd > a:hover,
.widget_tabs .tabs.radius dd a {
	border-left-color:rgba($color2_1,$color2_2,$color2_3,0.2);
	border-top-color:rgba($color2_1,$color2_2,$color2_3,0.2);
	border-right-color:rgba($color2_1,$color2_2,$color2_3,0.2);
	background-color:rgba($color2_1,$color2_2,$color2_3,0.1);
	box-shadow:$none;
	-webkit-box-shadow:$none;
	color:rgba($color2_1,$color2_2,$color2_3,0.5);
}

.tabs.radius dd.active a,
.widget_tabs .tabs.radius dd.active a {
	border-left-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	border-top-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	border-right-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	box-shadow:$none;
	-webkit-box-shadow:$none;
	color:$color2;
}

.widget_tabs .tabs-content {
	border-left-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	border-bottom-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	border-right-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
.tabs.radius {
	border-bottom-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}


.meta-transparent-buttons li:first-child a.button, .meta-transparent-buttons li:first-child .button, .meta-transparent-buttons li:first-child span.button 
	{border-left-color:rgba($color2_1,$color2_2,$color2_3,0.2);}



input[type="text"], input[type="password"], input[type="date"], input[type="datetime"], input[type="datetime-local"], input[type="month"], input[type="week"], input[type="email"], input[type="number"], input[type="search"], input[type="tel"], input[type="time"], input[type="url"], textarea,
#content .grid-list-btn .button-group li > button, #content .grid-list-btn .button-group li .button,
#content .grid-list-btn .button-group li > button:hover, #content .grid-list-btn .button-group li .button:hover,
#content .grid-list-btn .button-group li > button.active, #content .grid-list-btn .button-group li .button.active,
.respond-form form input[type="text"], .respond-form form input[type="email"], .respond-form form input[type="url"], .respond-form form textarea,
.entry-content pre,.panel,
#submit_form .cf_checkbox {
	border-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	color:$color2;
	text-shadow:$none;
}
#content .grid-list-btn .button-group li > button.active i, #content .grid-list-btn .button-group li .button.active i,
#content .grid-list-btn .button-group li > button.active:hover i, #content .grid-list-btn .button-group li .button.active:hover i,
.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button  {
	color:$color2;	
}

input[type="text"]:focus, input[type="password"]:focus, input[type="date"]:focus, input[type="datetime"]:focus, input[type="datetime-local"]:focus, input[type="month"]:focus, input[type="week"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="search"]:focus, input[type="tel"]:focus, input[type="time"]:focus, input[type="url"]:focus, textarea:focus,
.respond-form form input[type="text"], .respond-form form input[type="email"], .respond-form form input[type="url"], .respond-form form textarea,
.entry-content pre {
	background-color:rgba($color2_1,$color2_2,$color2_3,0.02);
	border-color:rgba($color2_1,$color2_2,$color2_3,0.5);
	box-shadow:$none;
}
input[type="text"]:focus, input[type="text"]:active, input[type="password"]:focus, input[type="password"]:active, input[type="date"]:focus, input[type="date"]:active, input[type="datetime"]:focus, input[type="datetime"]:active, input[type="datetime-local"]:focus, input[type="datetime-local"]:active, input[type="month"]:focus, input[type="month"]:active, input[type="week"]:focus, input[type="week"]:active, input[type="email"]:focus, input[type="email"]:active, input[type="number"]:focus, input[type="number"]:active, input[type="search"]:focus, input[type="search"]:active, input[type="tel"]:focus, input[type="tel"]:active, input[type="time"]:focus, input[type="time"]:active, input[type="url"]:focus, input[type="url"]:active, textarea:focus, textarea:active, .respond-form form input[type="text"]:focus, .respond-form form input[type="text"]:active, .respond-form form input[type="email"]:focus, .respond-form form input[type="email"]:active, .respond-form form input[type="url"]:focus, .respond-form form input[type="url"]:active, .respond-form form textarea:focus, .respond-form form textarea:active {
	border-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}

h2.title-border:before, .sidebar h3.widget-title:before, .footer h3.widget-title:before, .h2:before, .title-custom-border:before {
	background-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
h2.title-border, .sidebar h3.widget-title, .footer h3.widget-title, .h2, .title-custom-border {
	border-color:rgba($color2_1,$color2_2,$color2_3,0.2);
}
.footer-bottom .footer-meta {
	border-top-color:rgba($color2_1,$color2_2,$color2_3,0.2);
}
hr,
fieldset {
	border-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
.widget.widget_categories ul li {
	border-bottom-color:rgba($color2_1,$color2_2,$color2_3,0.2);
	color:rgba($color2_1,$color2_2,$color2_3,0.8);
}
.widget.widget_categories ul li, .byline {
	color:rgba($color2_1,$color2_2,$color2_3,0.8);
}
input[type="submit"]:hover, input[type="submit"]:focus{
	color: $color2;
}
.list .main-view,
.sidebar .widget .grid .main-view, 
.sidebar .widget .list .main-view,
.pricing-table .bullet-item,
.pricing-table .description {
	border-bottom-color:rgba($color2_1,$color2_2,$color2_3,0.2);
}
blockquote {
	border-left-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
ol.commentlist li.panel,
table tr.even, table tr.alt, table tr:nth-of-type(2n),
table,
.pricing-table,
.vcard {
	border-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
.progress,
.accordion dd > a,
.tabs dd > a {
	background-color:rgba($color2_1,$color2_2,$color2_3,0.5);
}
table tr.even, table tr.alt, table tr:nth-of-type(2n),
table thead, table tfoot {
	background-color:rgba($color2_1,$color2_2,$color2_3,0.2);
}
footer.footer {
	background-color:rgba($color2_1,$color2_2,$color2_3,0.02);
	border-top-color:rgba(0, 0, 0, 0.2);
	box-shadow:$none;
}
*::-moz-placeholder {
	color:rgba($color2_1,$color2_2,$color2_3,0.5);
}

COLOR2;
}// Finish Color 2 if condition



//Change color of page content
if($color3 != "#" || $color3 != ""){
	$color3_rgba = video_hex2rgb($color3);
	$color3_1 = '';
	$color3_2 = 0;
	$color3_3 = 0;
	if($color3_rgba[0] >= 0 && $color3_rgba[1] > 0)
	{
		$color3_1 = $color3_rgba[0];
	}
	if($color3_rgba[1] > 0 )
	{
		$color3_2 = $color3_rgba[1];
	}
	if($color3_rgba[2] > 0 )
	{
		$color3_3 = $color3_rgba[2];
	}

	$color_data.=<<<COLOR3


.top-bar-section li.active:not(.has-form) a:not(.button),
.sub-nav dt.active a, .sub-nav dd.active a, .sub-nav li.active a,
.top-bar-section ul li.active > a,
header .top-nav .sub-nav li a:hover,
button, .button, input[type="submit"],
.top-nav .sub-nav dt.active a, .top-nav .sub-nav dd.active a, .top-nav .sub-nav li.active a,
.ajax-file-upload > span,
input.cancel-btn[type="button"]:hover, input.cancel-btn[type="button"]:focus,
.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
	background: $color3;
}

button:hover, button:focus, .button:hover, .button:focus, input[type="submit"]:hover, input[type="submit"]:focus,
.ajax-file-upload > span:hover {
	background:rgba($color3_1,$color3_2,$color3_3,0.8);
}
body .top-bar-section ul li:hover:not(.has-form) > a,
.top-bar-section li.active:not(.has-form) a:not(.button),
.top-bar-section li.current_page_item:not(.has-form) a:not(.button),
.header .menu ul li.listing-btn a:hover{
	background:rgba($color3_1,$color3_2,$color3_3,0.8) !important;
}

body .top-bar-section ul li:hover:not(.has-form) > a, .top-bar-section li.active:not(.has-form) a:not(.button), .top-bar-section li.current_page_item:not(.has-form) a:not(.button),
.header .menu ul li.listing-btn a {
	background: $color3 !important;
}
.alert-box , button.disabled, button[disabled], .button.disabled, .button[disabled], button.disabled:hover, button.disabled:focus, button[disabled]:hover, button[disabled]:focus, .button.disabled:hover, .button.disabled:focus, .button[disabled]:hover, .button[disabled]:focus, .label, .view-img:hover .social-overlay,
.more-social ul.more {
  background-color: $color3;
}

.alert-box,
.alert-box.success,
.alert-box.alert,
.alert-box.warning,
button:hover,
button:focus,
.button:hover,
.button:focus,
button.success,
.button.success,
button.success:hover,
button.success:focus,
.button.success:hover,
.button.success:focus,
button.alert,
.button.alert,
button.alert:hover,
button.alert:focus,
.button.alert:hover,
.button.alert:focus,
button.disabled,
button[disabled],
.button.disabled,
.button[disabled],
button.disabled:hover,
button.disabled:focus,
button[disabled]:hover,
button[disabled]:focus,
.button.disabled:hover,
.button.disabled:focus,
.button[disabled]:hover,
.button[disabled]:focus,
button.disabled.success,
button[disabled].success,
.button.disabled.success,
.button[disabled].success,
button.disabled.success:hover,
button.disabled.success:focus,
button[disabled].success:hover,
button[disabled].success:focus,
.button.disabled.success:hover,
.button.disabled.success:focus,
.button[disabled].success:hover,
.button[disabled].success:focus,
button.disabled.alert,
button[disabled].alert,
.button.disabled.alert,
.button[disabled].alert,
button.disabled.alert:hover,
button.disabled.alert:focus,
button[disabled].alert:hover,
button[disabled].alert:focus,
.button.disabled.alert:hover,
.button.disabled.alert:focus,
.button[disabled].alert:hover,
.button[disabled].alert:focus,
[data-abide] .error small.error,
[data-abide] span.error,
[data-abide] small.error,
span.error,
small.error,
.error small.error,
.joyride-tip-guide,

.label,
.label.alert,
.label.success,
.orbit-container .orbit-slides-container > * .orbit-caption,
.orbit-container .orbit-slide-number,
.orbit-container .orbit-prev,
.orbit-container .orbit-next,
ul.pagination li.current a,
.menu-icon,
.commentlist .comment-reply-link:hover,
.commentlist .comment-reply-link:focus,
.tooltip,
.top-bar .name h1 a,
#content a:hover,
#content a:focus,
#sidebar-offcanvas .widgettitle,
.transparent-btn a.button:hover,
.meta-transparent-buttons a.button:hover,
ol.commentlist .comment-reply-link:hover,
.video-length span,
.view-img .social-overlay ul li a,
ul.pagination li a,
.more-social ul.more:before,
label,
.accordion .accordion-navigation > a,
.accordion dd > a,
input.cancel-btn[type="button"],
blockquote,
blockquote p,
.panel h1,
.panel h2,
.panel h3,
.panel h4,
.panel h5,
.panel h6,
.panel p,
.panel li,
.panel dl,
.right_box .user_dsb_cf > div label,
.right_box .user_dsb_cf > p label {
	color: $color3;
}
.transparent-btn a.button:hover,
.author_cont .author_photo,
.accordion,.accordion .accordion-navigation > a span:first-child, .accordion dd > a span:first-child,
.accordion .accordion-navigation > div, .accordion dd > div {
  border-color: $color3;
}
a, .more-social ul.more li a:hover, ol.commentlist .comment-reply-link, .view-img a .video-overlay i, .breadcrumbs > * a, .breadcrumbs > * span,
.side-nav li a:not(.button){
  color: $color3;  
}
.side-nav li.active > a:first-child:not(.button), .side-nav li a:hover:not(.button), .side-nav li a:focus:not(.button) {
	color:rgba($color3_1,$color3_2,$color3_3,0.8);
}
a:hover, a:focus,
body .tabs.radius dd > a:hover, .tabs.radius dd > a:focus,
.meta-transparent-buttons a.button:hover, .meta-transparent-buttons .button:hover, .meta-transparent-buttons span.button:hover {
	color: $color3;
}
.more-social ul.more:before{text-shadow:0 0 0; top:-18px;}
.view-img:hover .social-overlay {
  border-left-color:$color3;  
  border-right-color:$color3;  
  border-bottom-color:$color3;  
}
button, .button {
  border-bottom-color:$color3;
}
.top-bar-section li.active:not(.has-form) a:not(.button),
.top-bar-section > ul > li.active:not(.has-form) > a:hover:not(.button) {
	border-bottom-color:$color3 ;
}
COLOR3;
}// Finish Color 3 if condition





//Change color of lighter-gray
if($color4 != "#" || $color4 != ""){
	if($color4 != '') {
		$none = 'none';
	}
	$color4_rgba = video_hex2rgb($color4);
	$color4_1 = '';
	$color4_2 = 0;
	$color4_3 = 0;
	if($color4_rgba[0] >= 0 && $color4_rgba[1] > 0)
	{
		$color4_1 = $color4_rgba[0];
	}
	if($color4_rgba[1] > 0 )
	{
		$color4_2 = $color4_rgba[1];
	}
	if($color4_rgba[2] > 0 )
	{
		$color4_3 = $color4_rgba[2];
	}
	$color_data.=<<<COLOR4

.clearing-blackout, .clearing-caption, .clearing-assembled .clearing-container .visible-img, .joyride-tip-guide, .tooltip, .contain-to-grid, .top-bar, .top-bar.expanded .title-area, .top-bar-section ul, .top-bar-section ul li > a, .top-bar, .top-bar.expanded, .top-bar-section li:not(.has-form) a:not(.button), .top-bar-section .dropdown li a, .top-bar-section .dropdown li label, .top-bar-section .has-form, .tab-bar, .left-off-canvas-menu, .right-off-canvas-menu {
  background: $color4;	
}
.pricing-table .title, header .top-nav,
.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover {
  background-color: $color4;
}
ol.commentlist .comment-reply-link:hover{color:$color4;}
.joyride-tip-guide .joyride-nub, .joyride-tip-guide .joyride-nub.top {
  	border-color: $color4;	
}
.joyride-tip-guide .joyride-nub.bottom {
  	border-color: $color4 !important;	
}
.dropdown.button.secondary:before, button.dropdown.secondary:before, .split.button.secondary span:before, .tooltip.tip-top > .nub,
.woocommerce nav.woocommerce-pagination ul li {
  	border-top-color: $color4;	
}
.orbit-container .orbit-timer.paused > span.dark, .tooltip > .nub {
  	border-bottom-color: $color4;	
}
.tooltip.tip-left > .nub {
	border-left-color: $color4;	
}

.tooltip.tip-right > .nub {
	border-right-color: $color4;
}
 .progress .meter, .top-bar-section ul li > a.button, .top-bar-section ul li.active > a, .no-js .top-bar-section ul li:active > a, .top-bar-section li.active:not(.has-form) a:hover:not(.button), ul.pagination li a {
	background-color: $color4;	
}
ul.pagination li.current a, ul.pagination li.current a:hover, ul.pagination li.current a:focus,
ul.pagination li:hover a, ul.pagination li a:focus,
.woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current {
	background-color: rgba($color4_1,$color4_2,$color4_3,0.8);
}
.top-bar {
	box-shadow:$none;
}
.orbit-bullets li {
	background:rgba($color4_1,$color4_2,$color4_3,0.5);
}
input[type="submit"]:hover, 
input[type="submit"]:focus,
.header .menu ul li.listing-btn a:hover {
	background:rgba($color4_1,$color4_2,$color4_3,0.8);
}

.orbit-bullets li.active {
	background:$color4;
}
COLOR4;
}// Finish Color 4 if condition



//Change color of h1,h2...h6 - heading 
if($color5 != "#" || $color5 != ""){
	$color_data.=<<<COLOR5
h1, h2, h3, h4, h5, h6,
.panel h1, .panel h2, .panel h3, .panel h4, .panel h5, .panel h6,
.joyride-tip-guide h1,
.joyride-tip-guide h2,
.joyride-tip-guide h3,
.joyride-tip-guide h4,
.joyride-tip-guide h5,
.joyride-tip-guide h6, 
h1 a, 
h2 a, 
h3 a, 
h4 a, 
h5 a, 
h6 a  {
	 color: $color5;
}
COLOR5;
}// Finish If Condition

/* Write/Put the content in css file*/
if(isset($_POST['wp_customize']) && $_POST['wp_customize']=='on'){
	if(is_writable(trailingslashit(get_template_directory())."/functions/theme_options.css")){
		file_put_contents(trailingslashit(get_template_directory())."/functions/theme_options.css" , $color_data); 
	}

}
