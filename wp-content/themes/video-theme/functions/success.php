<?php
/*
 * success page after successful submission.
 */
session_start();
$order_id = $_REQUEST['pid'];
global $page_title,$wpdb;

/* add background color and image set in customizer */
add_action('wp_head','show_background_color');
if(!function_exists('show_background_color'))
{
	function show_background_color()
	{
	/* Get the background image. */
		$image = get_background_image();
		/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
		if ( !empty( $image ) ) {
			_custom_background_cb();
			return;
		}
		/* Get the background color. */
		$color = get_background_color();
		/* If no background color, return. */
		if ( empty( $color ) )
			return;
		/* Use 'background' instead of 'background-color'. */
		$style = "background: #{$color};";
	?>
		<style type="text/css">
			body.custom-background {
				<?php echo trim( $style );?>
			}
		</style>
	<?php
	}
}
global $wpdb;
if($_REQUEST['pid']){
	$post_type = get_post_type($_REQUEST['pid']);
	$post_type_object = get_post_type_object($post_type);
	$post_type_label =   __('Video','templatic');
}
if($_REQUEST['action']=='edit'){
	
	$page_title = $post_type_label.' '.__('Updated Successfully','templatic');
	if(function_exists('icl_register_string')){
		$context = get_option('blogname');
		icl_register_string($context,$post_type_label." Updated",$post_type_label." Updated");
		$page_tile = icl_t($context,$post_type_label." Updated",$post_type_label." Updated");
	}
}else{
	if(function_exists('icl_register_string')){
		icl_register_string('templatic',$post_type_label."success",$post_type_label);
		 $post_type_label = icl_t('templatic',$post_type_label."success",$post_type_label);
	    }
	if($_REQUEST['pid'] && !isset($_REQUEST['action_edit']))
		$page_title = $post_type_label.' '.__('Submitted Successfully','templatic');
	elseif(isset($_REQUEST['action_edit']))
		$page_title = $post_type_label.' '.__('Updated Successfully','templatic');
	else
		$page_title = $post_type_label.' '.__('Thank you for purchasing a subscription plan','templatic');
}
get_header(); 
do_action('templ_before_success_container_breadcrumb');

global $upload_folder_path,$wpdb;
?>
    <div id="content">
    <div class="row clearfix" id="inner-content">
    <div role="main" class="large-9 medium-12 columns first clearfix" id="main">
        <h1 class="page-title"><?php echo $page_title; ?></h1>
        <?php if(isset($_SESSION['new_user_register']) && $_SESSION['new_user_register'] == 1){ ?>
        <div class='new_user_login'>
            
            <?php 
                global $current_user;
                get_currentuserinfo();
                echo '<p class="text-green">'. __('Your username and password have been sent to your email address.','templatic').'</p>';
                echo '<p>'. __('Your login information','templatic'). '<p/>';
                echo '<p>'. __('Username:','templatic').' '. $current_user->user_login . "<p/>";
                echo '<p>'. __('User email:','templatic').' '. $current_user->user_email. "<p/>";                             
                	
            ?>
        </div>    
            
        <?php unset($_SESSION['new_user_register']); } ?>
        
        <div class="posted_successful">
	 <?php
		do_action('video_posts_before_submition_success_msg');
		do_action('video_posts_submition_success_msg');
		do_action('video_posts_after_submition_success_msg');
	 ?> 
	</div>
        <?php if((isset($_REQUEST['pid']) && $_REQUEST['pid'] != ''))
        {
                do_action('video_posts_submition_success_post_content'); 
        }?>
    </div>
<?php 
	if(isset($_REQUEST['pid']) && $_REQUEST['pid']!=""){
		$ptype = $wpdb->get_var("select post_type from $wpdb->posts where $wpdb->posts.ID = '".$_REQUEST['pid']."'");
		$cus_post_type = apply_filters('success_page_sidebar_post_type',$ptype);
	}	
?>

<div role="complementary" class="sidebar large-3 medium-12 columns" id="sidebar1">

<?php 
	if(isset($cus_post_type) && $cus_post_type!="" && is_active_sidebar($cus_post_type.'_detail_sidebar')){
		dynamic_sidebar($cus_post_type.'_detail_sidebar');
	}else{ 
		dynamic_sidebar('primary-sidebar');
	}
?>
</div>
</div>
</div> <!-- content #end -->
<?php get_footer(); ?>