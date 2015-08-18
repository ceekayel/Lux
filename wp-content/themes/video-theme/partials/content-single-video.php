    <!-- display video -->	
    <?php 
	$media = get_attached_media( 'video', $post->ID);
	 if(!empty( $media )){
		$count=0;
		foreach ( $media as $attachment ) {
				$count++;
				$class = "post-attachment mime-".$attachment->ID.sanitize_title( $attachment->post_mime_type );
				$link = wp_get_attachment_url( $attachment->ID,'','','', false );
				$mimetype = $attachment->post_mime_type;
                                $autoplay = '';
                                if(@get_post_meta($post->ID,'autoplay',true) == 'on'){
                                    $autoplay = 'autoplay';
                                }
				$video_link="<video width='100%' height='100%' controls $autoplay><source src='$link' type='$mimetype'></video>";
				if($count ==1){
					break;
				}
		}
	 }else{
		if(get_post_meta($post->ID,'video',true) !='') {
			$video_link=get_post_meta($post->ID,'video',true);
		}
		elseif(get_post_meta($post->ID,'oembed',true) !='') {
			$autoplay = 0;
			if(@get_post_meta($post->ID,'autoplay',true) == 'on')
				$autoplay = 1;
			$video_link=wp_oembed_get(get_post_meta($post->ID,'oembed',true),array( 'autoplay' => $autoplay, 'rel' => 0) );	
		}
		
	 }
	 if(@$video_link){             
	  ?>
    <!-- display video end -->

	<article class="row detail-video">
	<div class="large-12 columns">
		<div class="flex-video">
			<?php echo $video_link; ?>
		</div>
	</div>
            
	</article>
	<!-- display video slider-->
         <?php } ?>
	<header class="row detail-title-gravitar">	
		<!-- Show gravtar -->
		<!-- Show title end  -->
		<div class="medium-10 small-12  columns detail-title">
			<h1 itemprop="headline"><?php the_title(); ?></h1>
			<?php 	 $post_byline=sprintf(__('Posted by <span itemprop="author" itemscope itemtype="http://schema.org/Person" class="author">%3$s</span> on <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'templatic'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), tmpl_author_posts_link());
					$term_list = wp_get_post_terms($post->ID, CUSTOM_CATEGORY_SLUG, array("fields" => "all")); // fetch categories of video
					if(!empty($term_list)){
						$cats='';
						$sep=', ';
						for($c=0; $c< count($term_list); $c++){
							if($c == (count($term_list) - 1) || count($term_list) ==1){
								$sep =' ';	
							}
							$cats .= '<a href="'.get_term_link($term_list[$c]->term_id,$term_list[$c]->taxonomy).'">'.$term_list[$c]->name.'</a>'.$sep; // give link to terms

						}
						$post_byline.= " ".__('in','templatic')." ".$cats;
					}
			echo $post_byline;
			?>
		</div>
    </header> <!-- end article header -->
	
    <?php $content=''; ?> 
	<!-- display video slider end -->
    <!-- Show views and share button -->
    <article class="row meta-transparent-buttons">
		 <div class="medium-5 small-12 columns">
			<ul class="button-group">
				<?php
				/* Display comment count */
				$comments_count = wp_count_comments($post->ID); /* egt comments ( approved )*/
				if($comments_count->approved >= 0){
					if($comments_count->approved ==0){ $href = "#respond"; }else{  $href = "#comments"; }
				?>
					<li><a class="button" href="<?php echo $href; ?>"><i class="step fa fa-comment"></i><span><?php echo $comments_count->approved; ?></span></a></li>
				<?php } ?>

				<?php
				/* Show post totla views */
				 tmpl_set_post_views($post->ID); /* set total views */?>
				<li class="disabled-btn"><i class="step fa fa-eye"></i><span><?php echo tmpl_get_post_views($post->ID); /* get total views */ ?></span></li>
				
			</ul>
		 </div>
		 <!-- Social media share buttons -->
		 <div class="medium-7 small-12 columns">    
			<ul class="button-group right social-media-links">
							 <?php 
           						  /* generate download link */
           						  do_action('video_download_link');
           					?>
							<li><a class="button" href="http://twitter.com/home?status=Reading: <?php the_permalink(); ?>" title="<?php _e('Share this post on Twitter!','templatic'); ?>" target="_blank"><i class="step fa fa-twitter"></i> </a></li> 
					
							<li><a class="button" href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&amp;t=<?php the_title(); ?>" title="<?php _e('Share this post on Facebook!','templatic'); ?>" target="_blank"> <i class="step fa fa-facebook"></i> </a></li>

							<li class="share-reddit"><a rel="nofollow" class="share-reddit sd-button share-icon no-text" href="http://blog.ted.com/2013/12/05/tedwomen-2013-session-3/?share=reddit" target="_blank" title="Click to share on Reddit"><span></span></a></li>
							
							<li class="share-email"><a rel="nofollow" class="share-email sd-button share-icon no-text" href="http://blog.ted.com/2013/12/05/tedwomen-2013-session-3/?share=email" target="_blank" title="Click to email this to a friend"><span></span></a></li> 							
							<li class="more-social">
								<span class="button"><i class="fa fa-ellipsis-h"></i></span>
								<ul class="no-style more">
									<li><a class="google-plus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>"><i class="fa fa-google-plus"></i> <?php _e('Google+','templatic'); ?></a></li>
									<li><a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"  count-layout="none"><i class="fa fa-pinterest"></i> <?php _e('Pin It','templatic'); ?></a></li>
									<li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=<?php the_title(); ?>&source=<?php echo home_url(); ?>"  count-layout="none"><i class="fa fa-linkedin"></i> <?php _e('LinkedIn','templatic');?></a></li>
									<li><a href="mailto:<?php echo json_encode(antispambot(get_the_author_meta('email'))); ?>"><i class="fa fa-envelope"></i><?php _e('Email','templatic'); ?></a></li>
								</ul>
							</li>
					<!--  <a class="google-plus" target="_blank" href="https://plus.google.com/share?url=<?php //the_permalink(); ?>">Google+</a> // Remove it to enable google plus -->
			</ul>
		</div>
		 <!-- Social media share buttons end -->
	</article>
	<!-- Video Description -->
	<article class="row description">
			<div class="large-12 columns">
				<h2 class="title-custom-border"><?php _e('Details','templatic'); ?></h2>
				<?php the_content(); ?>
			</div>
	</article>
   
	<!-- pagination start -->
	<article class="row page-nav">
		<?php tmpl_get_post_pagination($post); ?>
	</article>
					  
	<!-- pagination end -->
	
	

	<!-- Get related Post-->
	<footer class="article-footer row">
		<div class="column"><p class="tags"><?php the_tags('<span class="tags-title">' . __('Tags:', 'templatic') . '</span> ', ', ', ''); ?></p></div>
	</footer> <!-- end article footer -->
									
	<?php comments_template(); ?>	
