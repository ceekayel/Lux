<!-- Primary Sidebar widget -->
<?php 
/* if submit or edit profile page than show video submit sidebar */
if((is_page( 'submit-video') || is_page('edit-profile')) && is_active_sidebar( 'video_submit_page' )){ ?>
        <div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">
            <?php dynamic_sidebar( 'video_submit_page' ); ?>
        </div>
<?php }else{ ?>
    <div id="sidebar1" class="sidebar large-3 medium-12 columns" role="complementary">

	<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar1' ); ?>
	<?php else : ?>
	
	<!-- This content shows up if there are no widgets defined in the backend. -->
						
	<div class="alert help">
		<p><?php _e("Please activate some Widgets.", "templatic");  ?></p>
	</div>

	<?php endif; ?>

    </div>
<?php } ?>