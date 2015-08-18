<?php
/*
    This file is for author archive listing only video posts.
 *  */
?>

<?php get_header(); ?>

<div id="content">

    <div id="inner-content" class="row clearfix">

        <div id="main" class="large-9 medium-12 columns first clearfix" role="main">
            <?php if (current_theme_supports('breadcrumb-trail')) breadcrumb_trail(array('separator' => '&raquo;')); ?>
            <?php
            global $current_user, $wp_query, $wpdb;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $qvar = $wp_query->query_vars;            
            $author = $qvar['author'];
            if (isset($_POST['auth_csutom_post'])) {
                update_user_meta($_POST['author_id'], 'author_custom_post', $_POST['author_custom_post']);
            }
            if (isset($author) && $author != '') :
                $curauth = get_userdata($qvar['author']);
            else :
                $curauth = get_userdata(intval($_REQUEST['author']));
            endif;

            $dirinfo = wp_upload_dir();
            $user_info = get_userdata($current_user->ID);
            ?>

            <div class="author_cont">
                <div class="author_photo">
                    <?php
                    /* seet profile photo if not available than show avtar image */
                    if(get_user_meta($curauth->ID,'profile_photo',true) != ""){
                        $image_url = get_user_meta($curauth->ID,'profile_photo',true);

                        $check_other_img = explode('.',$image_url);
                        $image_url_new = $check_other_img[0].'-300x225.'.$check_other_img[1];
                        if($is_image = @getimagesize($image_url_new)){
                            $image_url = $image_url_new;
                        }
                    
                        echo '<img src="' . $image_url . '" alt="' . $curauth->display_name . '" title="' . $curauth->display_name . '"/>';
                    } else {
                        echo get_avatar($curauth->ID, apply_filters('tev_gravtar_size', 240));
                    }
                    
                    /* show edit profile page link only for current user */
                    if ($current_user->ID == $curauth->ID) {
                        $profile_page_id = get_option('tevolution_profile_page');				
                        if($profile_page_id == ''){
                            $profile_url = get_permalink( get_page_by_path('edit-profile'));
                        }else{
                            $profile_url = get_permalink($profile_page_id);
                        }
                        if($profile_url!=''){
                        ?>
                            <div class="editProfile"><a href="<?php echo $profile_url; ?>" ><?php _e('Edit Profile', 'templatic'); ?> </a> </div>
                        <?php }
                    }?>
                </div>
                <!-- Author photo on left side and other details right side  start -->
                <div class="right_box">
                    <h2><?php echo $current_user->display_name;?></h2>	
                    <div class="user_dsb_cf">
                        <?php if(isset($user_info->description) && $user_info->description !='') { ?>
                        <div>
                            <label><?php _e('Author Biography:', 'templatic'); ?></label>
                            <span><?php echo $user_info->description;?></span>
                        </div>
                        <?php } ?>
                        <div>
                            <label><?php _e('Total Submissions:', 'templatic'); ?> </label>
                             <b><?php echo count_user_posts( $curauth->ID , 'videos' ); ?></b>
                        </div>
                        <?php if(isset($user_info->user_url) && $user_info->user_url !='') { ?>
                        <div>
                            <label><?php _e('Website:', 'templatic'); ?> </label>
                            <a href="<?php echo $user_info->user_url; ?>" target="_blank"><?php echo $user_info->user_url; ?></a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>				    
            <?php
            global $post;
            $author_id = $post->post_author;
            ?>
            <h1 class="h2">
                <span><?php _e("Posts By:", "templatic"); ?></span> <?php echo get_the_author_meta('display_name', $author_id); ?>
            </h1>					    

            <?php if (have_posts()) : ?>
                <div  class="tabs-content row grid" id="autho-post-view">

                    <?php
                    while (have_posts()) : the_post();
                            /* Video image of listing-post-thumb size as defined in functions.php */
                            $video_img = tmpl_get_image_withinfo($post->ID, 'listing-post-thumb');
                            $video_img_x2 = tmpl_get_image_withinfo($post->ID, 'listing-post-retina-thumb'); // -retina

                            $byline = '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>' . tmpl_get_post_view($post->ID) . '</span></span><cite class="fn"><i class="fa fa-clock-o"></i> ' . get_the_time(get_option('date_format')) . '</cite>';
                            ?>
                            <div class="main-view clearfix">
                                <div class="hover-overlay">
                                    <div class="view-img">
                                        <a href="<?php echo get_permalink($post->ID); ?>"><img data-interchange="[<?php echo $video_img[0]['file']; ?>, (default)], [<?php echo $video_img_x2[0]['file']; ?>, (retina)]" class="thumb-img" /><span class="video-overlay"><i class="fa fa-play-circle-o"></i></span></a>
                                    </div>
                                    <!-- Show video meta -->
                                    <div class='view-desc'>
                                        <h6><a href="<?php echo get_permalink($post->ID); ?>"><?php the_title(); ?></a></h6>
                                        <span class="byline"><?php echo $byline; ?></span>
                                        <p class="clearfix"><?php the_excerpt(); ?></p>
                                        <?php
                                        if($post->post_status == 'draft')
                                        {
                                            echo '<span class="post_in_draft"><strong>'.__('Pending Approval','templatic').'</strong></span>';
                                        }
                                         echo tmpl_video_edit_link($post); ?>
                                        <?php 
                                        global $post,$current_user,$wpdb;
                                        get_currentuserinfo();
                                        if ($post->post_author == $current_user->ID) {
                                            echo '<a class="button secondary_btn tiny_btn post-edit-link autor_delete_link" title="Delete Entry" data-deleteid="'.$post->ID.'" href="#">' . __('Delete', 'templatic') . '</a>'; 
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>

                                        <?php 
                    endwhile;

                    /* pagination start */
                    if (function_exists('tmpl_page_navi')) {
                        tmpl_page_navi();
                    } else {
                        ?>
                        <nav class="wp-prev-next">
                            <ul class="clearfix">
                                <li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', "templatic")) ?></li>
                                <li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', "templatic")) ?></li>
                            </ul>
                        </nav>
                        <?php
                    }
                    /* pagination emd */
                    ?>		
                </div>
                <?php
            else :
                get_template_part('partials/content', 'missing');

            endif;
            ?>

        </div> <!-- end #main -->

        <?php get_sidebar(); ?>

    </div> <!-- end #inner-content -->

</div> <!-- end #content -->

<?php get_footer(); ?>