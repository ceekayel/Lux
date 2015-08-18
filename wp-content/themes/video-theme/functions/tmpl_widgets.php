<?php
/*
* Custom widgets Settings
*/

add_action('widgets_init','tmpl_custom_widgets'); // register new widgets

function tmpl_custom_widgets(){
 	register_widget('Tmpl_Widget_Popular_Posts');
 	register_widget('Tmpl_Widget_Per_Cat_Popular_Posts');
 	register_widget('Tmpl_Widget_Latest_Videos');
 	register_widget('Tmpl_Video_Slider_Widget');
 	register_widget('Tmpl_Adv_Widget');
 	register_widget('Tmpl_Social_Media');
 	register_widget('Tmpl_Subscriber_Widget');
 	register_widget('Tmpl_Author_Widget');
 	register_widget('Tmpl_Realted_Plopular_Latest_Widget');
 	register_widget('Tmpl_Categories_Widget');
	register_widget('Tmpl_Widget_Related_Posts');
}

/**
 * Popular post widget class
 *
 */
class Tmpl_Widget_Popular_Posts extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_popular_posts', 'description' => __( "Your site&#8217;s most popular Posts.","templatic") );
		parent::__construct('Tmpl_Widget_Popular_Posts', __('T &rarr; Popular Posts',"templatic"), $widget_ops);
		$this->alt_option_name = 'widget_per_cat_popular_posts';
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_popular_entries', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Popular Posts',"templatic" );
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 8;
		$popular_per = ( ! empty( $instance['popular_per'] ) ) ? $instance['popular_per'] : 'comments';
		$post_type = ( ! empty( $instance['post_type'] ) ) ? $instance['post_type'] : 'post';
		$view = empty($instance['view']) ? 'list' : apply_filters('widget_show_view', $instance['view']);

		if($view =='grid'){ $class='grid'; }else{ $class="list"; }
		if ( ! $number )
 			$number = 10;
		$show_excerpt = isset( $instance['show_excerpt'] ) ? $instance['show_excerpt'] : false;

		/* popular posts query */
		if($popular_per =='views'){
			$r = new WP_Query( array( 'post_type'=> $post_type , 'posts_per_page' => $number, 'meta_key' => 'post_views_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'  ) ); /* Query to fetch per view */
		}else{
			$r = new WP_Query( array( 'post_type'=> $post_type ,'orderby' => 'comment_count','order' => 'DESC','posts_per_page' => $number,'no_found_rows' => true,  'post_status' => 'publish') ); /* Query to fetch per comments count  */
		}
		
		/* Loop start */
		global $post;
		if ($r->have_posts()) :
		
		echo $args['before_widget']; ?>
		<?php if ( $title ) echo $args['before_title']. esc_html($title) .$args['after_title'] ; ?>
		<ul class="<?php echo $view; ?> row">
		<?php 
		/* Loop to display popular posts */
		while ( $r->have_posts() ) : $r->the_post();
			$post_rel_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb'); 
			$post_rel_img_x2 =  tmpl_get_image_withinfo($post->ID,'listing-post-retina-thumb'); // - retina
			$post_rel_img =$post_rel_img[0]['file'];
			$post_rel_img_x2 =$post_rel_img_x2[0]['file'];
		?>
		
			<li class="main-view clearfix">
				<div class="view-img">
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><img class="thumb-img" data-interchange="[<?php echo $post_rel_img; ?>, (default)], [<?php echo $post_rel_img_x2; ?>, (retina)]">
					<?php if($post_type == CUSTOM_POST_TYPE){ ?>
						<span class="video-overlay"><i class="fa fa-play-circle-o"></i></span>
					<?php } ?>
					</a>
					
					
				</div>
				<div class="view-desc">
					<h6><a href="#"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
					<span class="byline"><?php echo '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>'. tmpl_get_post_view($post->ID).'</span></span> '; ?> <cite class="fn"><i class="fa fa-clock-o"></i> <?php echo get_the_time(get_option('date_format')); ?></cite></span>
					<?php if ( $show_excerpt ) : ?>
						<span class="post-excerpt"><?php the_excerpt(); ?></span>
					<?php endif; ?>
				</div>
			</li>

			
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		else:
			echo "<p>"; _e('No Popular Videos.','templatic'); echo "</p>";
		endif;
		/* Loop End */

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_popular_entries', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$this->flush_widget_cache();

		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_popular_entries']) )
			delete_option('widget_popular_entries');

		return $new_instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_popular_entries', 'widget');
	}

	function form( $instance ) {
		
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$show_excerpt = isset( $instance['show_excerpt'] ) ? (bool) $instance['show_excerpt'] : false;
		$popular_per = isset( $instance['popular_per'] ) ? esc_attr( $instance['popular_per'] ) : 'comments';
		$post_type = isset( $instance['post_type'] ) ? esc_attr( $instance['post_type'] ) : 'post';
		$view = strip_tags(@$instance['view']);
		 ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title',"templatic" ); ?>: </label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show',"templatic" ); ?>: </label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

		<p><input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" />
		
		  <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Display post excerpt?',"templatic" ); ?></label></p>

		 <!-- Select post type option in back end -->
		 <p>
		 	<label for="<?php echo $this->get_field_id('post_type');  ?>"><?php _e('Select Post type','templatic'); ?>: </label>
		 	<select class="widefat" name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php  echo $this->get_field_id('post_type'); ?>" >
		 		<option value="post" <?php if($post_type =='post'){ echo "selected=selected"; }?>><?php _e('Posts','templatic'); ?></option>
		 		<option value="videos" <?php if($post_type =='videos'){ echo "selected=selected"; }?>><?php _e('Videos','templatic'); ?></option>
		 	</select>
		 </p>
		 <p>
		 	<label for="<?php echo $this->get_field_id('view');  ?>"><?php _e('Select view: (not applicable in sidebars) ','templatic'); ?> </label>
		 	<select class="widefat" name="<?php echo $this->get_field_name('view'); ?>" id="<?php  echo $this->get_field_id('view'); ?>" >
		 		<option value="list" <?php if($view =='list'){ echo "selected=selected"; }?>><?php _e('List','templatic'); ?></option>
		 		<option value="grid" <?php if($view =='grid'){ echo "selected=selected"; }?>><?php _e('Grid','templatic'); ?></option>
		 	</select>
		 </p>
		<!-- Select popularity option in back end -->
		<p>
		  <label for="<?php  echo $this->get_field_id('popular_per'); ?>">
			  <?php echo __('Shows post as per view counting/comments','templatic');?>: </label>
			    <select class="widefat" id="<?php  echo $this->get_field_id('popular_per'); ?>" onchange="show_hide_info(this.value,'<?php echo $this->get_field_id('daily_view'); ?>')" name="<?php echo $this->get_field_name('popular_per'); ?>">
			      <option value="views" <?php
			 if($popular_per == 'views')
			{ ?>selected='selected'<?php } ?>>
			      <?php echo __('Total views','templatic'); ?>
			      </option>
			      <option value="comments" <?php
			 if($popular_per == 'comments')
			{ ?>selected='selected'<?php } ?>>
			      <?php echo __('Total comments','templatic'); ?>
			      </option>
			    </select>
		
		</p>
	<?php
	}
}


/**
 * Popular post As per category widget class
 *
 */
class Tmpl_Widget_Per_Cat_Popular_Posts extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_per_cat_popular_posts', 'description' => __( "This widget will display a thumbnail of latest post/video","templatic") );
		parent::__construct('Tmpl_Widget_Per_Cat_Popular_Posts', __('T &rarr; All Categories First Video',"templatic"), $widget_ops);
		$this->alt_option_name = 'widget_per_cat_popular_posts';
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_per_cat_popular_posts', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		extract($args, EXTR_SKIP);
		echo $args['before_widget'];
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);		
		$show_excerpt = empty($instance['show_excerpt']) ? '' : apply_filters('widget_show_excerpt', $instance['show_excerpt']);
		$view = empty($instance['view']) ? 'list' : apply_filters('widget_show_view', $instance['view']);

		if($view =='grid'){ $class='grid'; }else{ $class="list"; }
		echo '';

		$catCounter = 0;
		
		 if($title !=''){
				echo $args['before_title']. esc_html($title) .$args['after_title'] ;
		 } ?>
		 <!-- Article start -->
         <div class="row col4-thumb <?php echo $class; ?>">
        
         <?php 
	
		 $sub_sql_cat='';
		 if(@$category)
		 {
			$catids = rtrim(implode(',',$category),','); 
			$sub_sql_cat = " and t.term_id in ($catids)";
		 }
			global $wpdb;
			/* qet transient of category results - save results in cache */
			if (function_exists('icl_object_id') && @$category )
			{
				global $sitepress;
				foreach ($category as $key => $value ) {
					$category[$key] = icl_object_id($value, 'videoscategory', true);
					if($category[$key]!=$value && $sitepress->get_default_language() != ICL_LANGUAGE_CODE){
						$wpml_latest_category[] = $category[$key];
					}
					elseif($sitepress->get_default_language() == ICL_LANGUAGE_CODE )
					{
						$wpml_latest_category[] =  $category[$key];
					}
				}
				$catids = rtrim(implode(',',$wpml_latest_category),','); 
				$sub_sql_cat = " and t.term_id in ($catids)";
			}
	  			$catQuery = $wpdb->get_results("select t.* from $wpdb->terms t join $wpdb->term_taxonomy tt on tt.term_id=t.term_id where tt.taxonomy=\"videoscategory\"   $sub_sql_cat order by t.name");
			
			$catCounter = 0;
			
			global $post,$wpdb;
			foreach ($catQuery as $category) {
			$catCounter++;
	
				$posts = get_posts(
							array(
								 'posts_per_page' => 1,
								 'post_type' => CUSTOM_POST_TYPE,
								 'post_status' => 'publish',
								 'tax_query' => array(
									array(
										'taxonomy' => CUSTOM_CATEGORY_SLUG,
										'field' => 'slug',
										'terms' => $category->slug
									)
								))
				);
				set_transient( 'category_first_post'.$category->slug, $posts, 12 * HOUR_IN_SECONDS );
			
			if(!empty($posts))
			$posts = $posts[0];
			
			$post_rel_img =  tmpl_get_image_withinfo($posts->ID,'listing-post-thumb'); 
			$post_rel_img_x2 =  tmpl_get_image_withinfo($posts->ID,'listing-post-retina-thumb'); // retina
			$post_rel_img =$post_rel_img[0]['file'];
			$post_rel_img_x2 =$post_rel_img_x2[0]['file'];
			$time = get_post_meta($post->ID,'time',true);
			$cmt_count = wp_count_comments( $posts->ID );
			?>

			<div class="main-view clearfix">
				<h6><a href="<?php echo get_term_link($category->slug,CUSTOM_CATEGORY_SLUG); ?>" ><?php echo $category->name ?></a></h6>
				<div class="view-img">
					<a class="video_thumb" href="<?php echo esc_url(get_permalink($posts->ID)) ?>" rel="bookmark" title="<?php get_the_title($posts->ID); ?>">		
	             		<img data-interchange="[<?php echo $post_rel_img;?>, (default)], [<?php echo $post_rel_img_x2;?>, (retina)]" alt="<?php get_the_title($posts->ID); ?>" title="<?php get_the_title($posts->ID); ?>"  /> 
	             		<span class="video-overlay"><i class="fa fa-play-circle-o"></i></span>
	           		</a>
				</div>
				<div class="view-desc">
						<span class="byline"><?php echo '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>'. tmpl_get_post_view($posts->ID).'</span></span> ';  ?> <cite class="fn"><i class="fa fa-clock-o"></i> <?php echo get_the_time(get_option('date_format'),$posts->ID); ?></cite></span>
						<?php if($show_excerpt){ ?>
							<span class="post-excerpt"><?php the_excerpt(); ?></span>
						<?php } ?>
				</div>
			</div>

		<?php } ?>
		</div>

		<!-- Article End -->
		<?php
		echo $args['after_widget'];

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_per_cat_popular_posts', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = $new_instance['category'];
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['show_excerpt'] = strip_tags($new_instance['show_excerpt']);
		$instance['view'] = strip_tags($new_instance['view']);
		$this->flush_widget_cache();
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_per_cat_popular_posts']) )
			delete_option('widget_per_cat_popular_posts');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_per_cat_popular_posts', 'widget');
	}

	function form( $instance ) {
		
		/* widgetform in backend */
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
		$title = strip_tags(@$instance['title']);
		$category = @$instance['category'];
		$number = (isset($instance['number']) && $instance['number']!=0) ? absint( $instance['number'] ) : 5;
		$show_excerpt = strip_tags(@$instance['show_excerpt']);
		$view = strip_tags(@$instance['view']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title',"templatic" ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Display post excerpt?',"templatic" ); ?></label>
		</p>
		 <!-- Select the view -->
		 <p>
		 	<label for="<?php echo $this->get_field_id('view');  ?>"><?php _e('Select View: (not applicable in sidebars)','templatic'); ?> </label>
		 	<select class="widefat" name="<?php echo $this->get_field_name('view'); ?>" id="<?php  echo $this->get_field_id('view'); ?>" >
		 		<option value="list" <?php if($view =='list'){ echo "selected=selected"; }?>><?php _e('List','templatic'); ?></option>
		 		<option value="grid" <?php if($view =='grid'){ echo "selected=selected"; }?>><?php _e('Grid','templatic'); ?></option>
		 	</select>
		 </p>
		 <!-- Select post type option in back end -->
		<p> 
		  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories','templatic'); ?>: </label>
		  <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple=multiple>
		  		<?php 
		  		$args= array();
		  		$terms_obj = get_terms( CUSTOM_CATEGORY_SLUG, @$args  );

		  		foreach($terms_obj as $terms){
		  			if(@$terms->term_id !=''){
		  				if(is_array($category) && in_array($terms->term_id,$category)){ $selected = "selected=selected"; }else{  $selected =''; } 
		  			?>
		  			<option value="<?php echo $terms->term_id; ?>" <?php echo $selected; ?>><?php echo $terms->name; ?></option>
		  		<?php } }
		  		?>		  		
		  </select>
		  <p class="description"><?php _e('Select categories that you want to display in the widget.','templatic'); ?></p>
		 </p>
		
		<?php
	}
}


/**
 * Latest Videos
 *
 */
class Tmpl_Widget_Latest_Videos extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_latest_videos', 'description' => __( "Show your latest posts or videos.","templatic") );
		parent::__construct('Tmpl_Widget_Latest_Videos', __('T &rarr; Latest Posts/Videos',"templatic"), $widget_ops);
		$this->alt_option_name = 'widget_latest_videos';
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_latest_videos', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		extract($args, EXTR_SKIP);
		echo $args['before_widget'];
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['number']) ? '4' : apply_filters('widget_post_number', $instance['number']);
		$show_excerpt = empty($instance['show_excerpt']) ? '' : apply_filters('widget_show_excerpt', $instance['show_excerpt']);
		$view = empty($instance['view']) ? 'list' : apply_filters('widget_show_view', $instance['view']);
		$post_type = empty($instance['post_type']) ? 'list' : apply_filters('widget_post_type', $instance['post_type']);

		if($view =='grid'){ $class='grid'; }else{ $class="list"; }
		echo '';

		$catCounter = 0;
		$pcount=0;
		if($title){
		 echo $args['before_title'].$title.$args['after_title']; 
		} ?>
		 <!-- Article start -->
         <div class="row col4-thumb <?php echo $class; ?>">
        
         <?php 
		//$catQuery =  get_categories('include='.$catids); 
			global $wpdb;
			/* qet transient of category results - save results in cache */
			
			$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
			/* qet transient of category results - save results in cache */
			if (function_exists('icl_object_id'))
			{
				foreach ($category as $key => $value ) {
					$category[$key] = icl_object_id($value, $taxonomies[0], true);
				}
			}

	  	
	  				if(!empty($category)){
	  					$lp = new WP_Query( array( 'post_type'=> $post_type ,
								'posts_per_page' => $post_number,
								 'tax_query' => array(
													array(
														'taxonomy' => $taxonomies[0],			
														'field' => 'term_id',
														'terms' => $category
													)
												),			
								 'orderby' => 'post_date',
								 'order' => 'DESC'  ) ); /* Query to fetch per view */
					}else{
						$lp = new WP_Query( array( 'post_type'=> $post_type ,
										 'posts_per_page' => $post_number,
										 'orderby' => 'post_date',
										 'order' => 'DESC'  ) ); /* Query to fetch per view */
				}
			global $post;
			if($lp->have_posts()){

					while($lp->have_posts()){ $lp->the_post();
							$post_rel_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb'); 
							$post_rel_img_x2 =  tmpl_get_image_withinfo($post->ID,'listing-post-retina-thumb'); // -retina
							$post_rel_img =$post_rel_img[0]['file'];
							$post_rel_img_x2 =$post_rel_img_x2[0]['file'];
							$time = get_post_meta($post->ID,'time',true);
			?>

			<div class="main-view clearfix">
				<div class="view-img">
					<a class="video_thumb" href="<?php echo esc_url(get_permalink($post->ID)); ?>" rel="bookmark" title="<?php get_the_title($post->ID); ?>">		
	             		<img data-interchange="[<?php echo $post_rel_img;?>, (default)], [<?php echo $post_rel_img_x2;?>, (retina)]" alt="<?php get_the_title($post->ID); ?>" title="<?php the_title(); ?>"  /> 
	             		<?php if($post_type == CUSTOM_POST_TYPE){ ?>
							<span class="video-overlay"><i class="fa fa-play-circle-o"></i></span>
						<?php } ?>
	           		</a>
					<?php if($post_type == CUSTOM_POST_TYPE){ ?>
					<?php } ?>
				</div>
				<div class="view-desc">
					<h6><a href="<?php echo esc_url(get_permalink($post->ID)); ?>" ><?php the_title(); ?></a></h6>
					 <span class="byline"><?php if($post_type == CUSTOM_POST_TYPE){ echo '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>'. tmpl_get_post_view($post->ID).'</span></span>'; } ?> <cite class="fn"><i class="fa fa-clock-o"></i> <?php echo get_the_time(get_option('date_format'),$post->ID); ?></cite>
					 	<?php if ( $show_excerpt ) : ?>
						<span class="post-excerpt"><?php the_excerpt(); ?></span>
					<?php endif; ?>
				</div>
			</div>

		<?php } }
			
		?>
		</div>

		<!-- Article End -->
		<?php
		echo $args['after_widget'];

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_latest_videos', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		global $wpdb;
		$instance = $old_instance;
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = $new_instance['category'];
		$instance['number'] = strip_tags($new_instance['number']);
		$instance['show_excerpt'] = strip_tags($new_instance['show_excerpt']);
		$instance['view'] = strip_tags($new_instance['view']);
		$instance['post_type'] = strip_tags($new_instance['post_type']);
		$this->flush_widget_cache();
		$wpdb->query("delete from $wpdb->options where option_name LIKE '%latest_video_results%'");
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_latest_videos']) )
			delete_option('widget_latest_videos');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_latest_videos', 'widget');
	}

	function form( $instance ) {
		
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
		$title = strip_tags(@$instance['title']);
		$category = @$instance['category'];
		$number = strip_tags(@$instance['number']);
		$show_excerpt = strip_tags(@$instance['show_excerpt']);
		$view = strip_tags(@$instance['view']);
		$post_type = strip_tags(@$instance['post_type']);


		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',"templatic" ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show',"templatic" ); ?>: </label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		 <!-- Select the view -->
		 <p>
		 	<label for="<?php echo $this->get_field_id('view');  ?>"><?php _e('Select view: (not applicable in sidebars) ','templatic'); ?></label>  
		 	<select class="widefat" name="<?php echo $this->get_field_name('view'); ?>" id="<?php  echo $this->get_field_id('view'); ?>" >
		 		<option value="list" <?php if($view =='list'){ echo "selected=selected"; }?>><?php _e('List','templatic'); ?></option>
		 		<option value="grid" <?php if($view =='grid'){ echo "selected=selected"; }?>><?php _e('Grid','templatic'); ?></option>
		 	</select>
		 </p>
		 <!-- Select post type option in back end -->
                 
                <p>
			<input class="checkbox" type="checkbox" <?php checked( $show_excerpt ); ?> id="<?php echo $this->get_field_id( 'show_excerpt' ); ?>" name="<?php echo $this->get_field_name( 'show_excerpt' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_excerpt' ); ?>"><?php _e( 'Display post excerpt?',"templatic" ); ?></label>
                    <p class="description"><?php _e('Excerpt content only show with list view.','templatic'); ?></p>
		</p>

		 <p>
		 	<label for="<?php echo $this->get_field_id('post_type');  ?>"><?php _e('Select Post type: ','templatic'); ?></label>
		 	<select class="widefat" name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php  echo $this->get_field_id('post_type'); ?>" onchange="tmpl_change_category('<?php echo $this->get_field_id('category'); ?>',this.value);" >
		 		<option value="post" <?php if($post_type =='post'){ echo "selected=selected"; }?>><?php _e('Posts','templatic'); ?></option>
		 		<option value="videos" <?php if($post_type =='videos'){ echo "selected=selected"; }?>><?php _e('Videos','templatic'); ?></option>
		 	</select>
		 </p>
		<p> 
		  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories ','templatic'); ?>: </label>
		  <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple=multiple>
		  		<?php  $args = array();
		  		if($post_type =='post'){ $category_slug = "category"; }else{ $category_slug = "videoscategory"; }
		  		$terms_obj = get_terms( $category_slug, $args );
				foreach($terms_obj as $terms)
				{
		  	 			if(@$terms->term_id != ''){
		  				if(is_array($category) && in_array($terms->term_id,$category)){ $selected = "selected=selected"; }else{  $selected =''; } 
		  			?>
		  			<option value="<?php echo $terms->term_id; ?>" <?php echo $selected; ?>><?php echo $terms->name; ?></option>
		  		<?php  }
				}
		  		?>		  		
		  </select>
		  <p class="description"><?php _e('Select categories from which you want the posts to appear in this widget.','templatic'); ?></p>
		 </p>
		<?php
	}
}

/**
 * Video Slider Widget
 *
 */
class Tmpl_Video_Slider_Widget extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_video_slider', 'description' => "" );
		parent::__construct('Tmpl_Video_Slider_Widget', __('T &rarr; Video Slider',"templatic"), $widget_ops);
		$this->alt_option_name = 'widget_video_slider';
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_video_slider', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		extract($args, EXTR_SKIP);
		echo $args['before_widget'];
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);	
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['number']) ? '4' : apply_filters('widget_post_number', $instance['number']);
		$view = empty($instance['view']) ? 'list' : apply_filters('widget_show_view', $instance['view']);

		if($view =='grid'){ $class='grid'; }else{ $class="list"; }
		echo '';

		$catCounter = 0;
		$pcount=0;
		 if($title){
			 echo $args['before_title'].$title.$args['after_title']; 
		 } ?>
		 <!-- Article start -->
         <ul class="example-orbit" data-orbit>
        
         <?php 
		//$catQuery =  get_categories('include='.$catids); 
			global $wpdb;
			/* qet transient of category results - save results in cache */
                        
			if ($category!='' && function_exists('icl_object_id'))
			{
				foreach ($category as $key => $value ) {
					$category[$key] = icl_object_id($value, 'videoscategory', true);
				}
			}
			delete_transient('latest_video_slider');
			/* qet transient of category results - save results in cache */
	  		if(false == get_transient('latest_video_slider')){

	  				if(!empty($category)){
	  					$lps = new WP_Query( array( 'post_type'=> CUSTOM_POST_TYPE ,
								'posts_per_page' => $post_number,
								 'tax_query' => array(
													array(
														'taxonomy' => CUSTOM_CATEGORY_SLUG,			
														'field' => 'term_id',
														'terms' => $category
													)
												),			
								 'orderby' => 'post_date',
								 'post_status' => 'publish',
								 'order' => 'DESC'  ) ); /* Query to fetch per view */
					}else{
						$lps = new WP_Query( array( 'post_type'=> CUSTOM_POST_TYPE ,
										 'posts_per_page' => $post_number,
										 'orderby' => 'post_date',
                                                                                 'post_status' => 'publish',
										 'order' => 'DESC'  ) ); /* Query to fetch per view */
					}
				set_transient( 'latest_video_slider', $lps, 12 * HOUR_IN_SECONDS );
			}else{
				$lps = get_transient('latest_video_slider');
			}

			global $post;
			if($lps->have_posts()){

			while($lps->have_posts()){ $lps->the_post(); ?>

 			<li>
				<div class="flex-video">	
						<?php 

					 $media = get_attached_media( 'video', $post->ID);
					 if(!empty( $media )){
						$count=0;
						foreach ( $media as $attachment ) {
								$count++;
								$class = "post-attachment mime-".$attachment->ID.sanitize_title( $attachment->post_mime_type );
								$link = wp_get_attachment_url( $attachment->ID,'','','', false );	
								$mimetype = tmpl_mime_content_type($link);
								echo $video_link='<video width="100%" height="100%" controls><source src="'.$link.'" type="'.$mimetype.'"></video> ';												
								if($count ==1){
									break;
								}
						}
					 }elseif(get_post_meta($post->ID,'video',true) !=''){
							echo get_post_meta($post->ID,'video',true);
						}elseif(get_post_meta($post->ID,'oembed',true) !=''){
							echo wp_oembed_get(get_post_meta($post->ID,'oembed',true),array( 'rel' => 0) );	
						}
						else{
							echo "<p>"; _e('No Video Available.','templatic'); echo "</p>"; 
						} ?>
				</div>
				<div class="orbit-caption">
						<h2><a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php the_title(); ?></a></h2>
						<?php the_excerpt(); ?>
						<a class="button medium" href="<?php echo esc_url(get_permalink($post->ID)); ?>"><?php _e('Read More','templatic'); ?></a>
				</div>
			</li>

		<?php } }
			
		?>
		</ul>

		<!-- Article End -->
		<?php
		echo $args['after_widget'];

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_video_slider', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['category'] = $new_instance['category'];
		$instance['number'] = strip_tags($new_instance['number']);
		delete_transient('latest_video_slider');
		$this->flush_widget_cache();
		delete_option('latest_video_slider');
		$alloptions = wp_cache_get( 'alloptions', 'options' );
		if ( isset($alloptions['widget_video_slider']) )
			delete_option('widget_video_slider');

		return $instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_video_slider', 'widget');
	}

	function form( $instance ) {
		
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
		$title = strip_tags(@$instance['title']);
		$category = @$instance['category'];
		$number = strip_tags(@$instance['number']); ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',"templatic" ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of videos to show',"templatic" ); ?>: </label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>
		<p> 
		  <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('Categories','templatic'); ?>: </label>
		  <select class="widefat" id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>[]" multiple=multiple>
		  		<?php  $args = array();
		  		
		  		$terms = get_terms( 'videoscategory', $args );
				foreach ($terms as $term) {
					$i++; 
					if(is_array($category) && in_array($term->term_id,$category)){ $selected = "selected=selected"; }else{  $selected =''; } 
					?>
					<option value="<?php echo $term->term_id; ?>" <?php echo $selected; ?>><?php echo $term->name; ?></option>
					<?php
		 	}
		  		?>		  		
		  </select>
		  <p class="description"><?php _e('Select categories from which you want videos to appear in the slider.','templatic'); ?></p>
		 </p>
		<?php
	}
}

/*
* Advertisement Widget
*/
class Tmpl_Adv_Widget extends WP_Widget {
	function Tmpl_Adv_Widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Advertise', 'description' => __('common advertise widget in sidebar, bottom section',"templatic") );		
		$this->WP_Widget('Tmpl_Adv_Widget', __('T &rarr; Advertisement Widget',"templatic"), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$desc1 = empty($instance['desc1']) ? '&nbsp;' : apply_filters('widget_desc1', $instance['desc1']);
		$double = empty($instance['double']) ? '' : apply_filters('widget_double', $instance['double']);
		$desc2 = empty($instance['desc2']) ? '&nbsp;' : apply_filters('widget_desc2', $instance['desc2']); 
		echo $args['before_widget']; ?>          
       <div class="advt <?php if(@$double){echo 'advt-2c';} else {echo 'advt-1c'; } ?>">
        <?php if ( $desc1 <> "" ) { ?>	
         <?php echo $desc1; ?> 
         <?php } ?>
         <?php if ( $desc2 <> "" && @$double !='') { ?>	
         <?php echo $desc2; ?> 
         <?php } ?>
       </div>  
    <?php echo $args['after_widget'];
	}
	function update($new_instance, $old_instance) {
	//save the widget
		return $new_instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'double' => '', 'desc1' => '', 'desc2' => '' ) );		
		$double = ($instance['double']);
		$desc1 = ($instance['desc1']);
		$desc2 = ($instance['desc2']);
?>
		<p>
			<input class="checkbox" onclick="return show_twice_adv('<?php echo $this->get_field_id( 'double' ); ?>','<?php echo $this->get_field_id('desc2'); ?>');" type="checkbox" <?php checked( $double ); ?> id="<?php echo $this->get_field_id( 'double' ); ?>" name="<?php echo $this->get_field_name( 'double' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'double' ); ?>"><?php _e( 'Display twice  advertisement?',"templatic" ); ?></label>
		</p>
		<p><label for="<?php echo $this->get_field_id('desc1'); ?>"><?php _e('your advt code (ex.google adsense etc.)','templatic'); ?>: </label>
        <textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc1'); ?>" name="<?php echo $this->get_field_name('desc1'); ?>"><?php echo esc_attr($desc1); ?></textarea></p>
		<p <?php if(@!$double){?> style="display:none;" <?php } ?> id="<?php echo $this->get_field_id('desc2'); ?>"><label for="<?php echo $this->get_field_id('desc2'); ?>"><?php _e('your advt code (ex.google adsense etc.)','templatic'); ?>
			<textarea class="widefat" rows="6" cols="20" id="<?php echo $this->get_field_id('desc2'); ?>" name="<?php echo $this->get_field_name('desc2'); ?>"><?php echo esc_attr($desc2); ?></textarea></label></p>
		
        
		<script type="text/javascript">
		function show_twice_adv(twice,textid)
		{
			if(document.getElementById(twice).checked)
			{
				document.getElementById(textid).style.display = 'block';
			}else
			{
				document.getElementById(textid).style.display = 'none';
			}
		}
		</script>   
       
<?php
	}}

/*-------------------------------------------------------------------
Social widget START
--------------------------------------------------------------------*/
if(!class_exists('Tmpl_Social_Media'))
{
	class Tmpl_Social_Media extends WP_Widget
	{
		function Tmpl_Social_Media()
		{
			//Constructor
			$widget_ops = array('classname'  => 'widget social_media','description'=> apply_filters('tmpl_social_media_description',__('Add icons and links to your social media accounts. Works in header, footer, main content and sidebar widget areas.','templatic')) );
			$this->WP_Widget('social_media', __('T &rarr; Social Media','templatic'), $widget_ops);
		}
		function widget($args, $instance)
		{
			// prints the widget
			extract($args, EXTR_SKIP);
			echo $args['before_widget'];
			echo '<div class="social_media" >';
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$social_description = empty($instance['social_description']) ? '' : apply_filters('widget_title', $instance['social_description']);
			$social_link = empty($instance['social_link']) ? '' : apply_filters('widget_social_link', $instance['social_link']);
			$social_icon = empty($instance['social_icon']) ? '' : apply_filters('widget_social_icon', $instance['social_icon']);
			$social_text = empty($instance['social_text']) ? '' : apply_filters('widget_social_text', $instance['social_text']);
			if(function_exists('icl_register_string'))
			{
				icl_register_string('templatic','social_media_title',$title);
				$title              = icl_t('templatic','social_media_title',$title);
				icl_register_string('templatic','social_description',$social_description);
				$social_description = icl_t('templatic','social_description',$social_description);
			}
			if($title != "")
			{
				echo $args['before_title'];
				echo $title;
				echo $args['after_title'];
			}
			if($social_description != ""): ?>
				<p class="social_description"> <?php echo stripcslashes($social_description);?> </p>
				<?php endif;?>
				<div class="social_media widget_contact_info">
					<div class="widget-wrap widget-inside">		
					<ul class="social_media_list inline-list social">
					<?php
									for($c = 0; $c < count($social_icon); $c++)
									{
										if(function_exists('icl_register_string'))
										{
											icl_register_string('templatic',@$social_text[$c],@$social_text[$c]);
											$social_text[$c] = icl_t('templatic',@$social_text[$c],@$social_text[$c]);
										}
										?>
										<li> <a href="<?php echo @$social_link[$c]; ?>" class="<?php echo $social_text[$c]; ?>" target="_blank" >
										<?php
												if( @$social_icon[$c] != ''): 
													echo @$social_icon[$c];
												endif;
										?></a> </li>
								<?php
									}
									?>
						</ul>
					</div>
				</div>
				<?php
			echo '</div>';
			echo $args['after_widget'];
		}
		function update($new_instance, $old_instance)
		{
			//save the widget
			return $new_instance;
		}
		function form($instance)
		{
			//widget form in backend
			$instance = wp_parse_args((array) $instance, array('title' => 'Connect To Us','social_description'=> 'Find Us On Social Sites','social_link'=> array('http://facebook.com/templatic','http://twitter.com/templatic','http://www.youtube.com/user/templatic'),'social_icon'=> array('<i class="fa fa-facebook"></i>','<i class="fa fa-twitter"></i>','<i class="fa fa-linkedin"></i>'),'social_text'=>array('facebook','twitter','linkedin')));
			$title              = strip_tags($instance['title']);
			$social_description = strip_tags($instance['social_description']);
			$social_link1       = ($instance['social_link']);
			$social_icon1       = ($instance['social_icon']);
			$social_text1       = ($instance['social_text']);
			global $social_link,$social_icon,$social_text;
			$text_social_link = $this->get_field_name('social_link');
			$text_social_icon = $this->get_field_name('social_icon');
			$text_social_text = $this->get_field_name('social_text');
			?>
<p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
    <?php echo __('Title','templatic');?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_description'); ?>">
    <?php echo __('Description','templatic');?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('social_description'); ?>" name="<?php echo $this->get_field_name('social_description'); ?>" type="text" value="<?php echo esc_attr($social_description); ?>" />
  </label>
</p>
<p> <i><?php  _e('Please enter full URL to your profiles.','templatic'); ?> </i> </p>
<p>
  <label for="<?php echo $this->get_field_id('social_link'); ?>">
    <?php echo __('Social Link','templatic');?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('social_link'); ?>" name="<?php echo $text_social_link; ?>[]" type="text" value="<?php echo esc_attr( @$social_link1[0]); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_icon'); ?>">
    <?php echo __('Social Icon','templatic');?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('social_icon'); ?>" name="<?php echo $text_social_icon; ?>[]" type="text" value="<?php echo esc_attr( @$social_icon1[0]); ?>" />
  </label>
</p>
<p>
  <label for="<?php echo $this->get_field_id('social_text1'); ?>">
    <?php echo __('Social Class','templatic');?>
    :
    <input class="widefat" id="<?php echo $this->get_field_id('social_text1'); ?>" name="<?php echo $text_social_text; ?>[]" type="text" value="<?php echo esc_attr( @$social_text1[0]); ?>" />
  </label>
</p>
<div id="social_tGroup" class="social_tGroup">
  <?php
				for($i = 1;$i < count($social_link1);$i++)
				{
					if($social_link1[$i] != "")
					{
						$j = $i + 1;
						echo '<div  class="SocialTextDiv'.$j.'">';
						echo '<p>';
						echo '<label>Social Link '.$j;
						echo '<input class="widefat" name="'.@$text_social_link.'[]" type="text" value="'.esc_attr($social_link1[$i]).'" />';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>Social Icon '.$j;
						echo ' <input type="text" class="widefat"  name="'.@$text_social_icon.'[]" value="'.esc_attr($social_icon1[$i]).'">';
						echo '</label>';
						echo '</p>';
						echo '<p>';
						echo '<label>Social Class '.$j;
						echo ' <input type="text" class="widefat"  name="'.@$text_social_text.'[]" value="'.esc_attr($social_text1[$i]).'">';
						echo '</label>';
						echo '</p>';
						echo '</div>';
					}
				}
				
				?>
</div>
	<script type="text/javascript">
	var social_counter = <?php echo $j+1;?>;
	</script>
<a	href="javascript:void(0);" id="addtButton" class="addButton" onclick="social_add_tfields('<?php echo $text_social_link; ?>','<?php echo $text_social_icon; ?>','<?php echo $text_social_text; ?>');"> + Add more </a> &nbsp; | &nbsp; <a
				href="javascript:void(0);" id="removetButton" class="removeButton" onclick="social_remove_tfields();">- Remove </a>
<?php
		}
	}
	add_action('admin_head','tmpl_add_script_addnew_1');
	if(!function_exists('tmpl_add_script_addnew_1'))
	{
		function tmpl_add_script_addnew_1()
		{
			global $social_link,$social_icon,$social_text;
			?>
			<script type="application/javascript">
					
					function social_add_tfields(name,ilname,sname)
					{
						var SocialTextDiv = jQuery(document.createElement('div')).attr("class", 'SocialTextDiv' + social_counter);
						SocialTextDiv.html('<p><label>Social Link '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+name+'[]" id="textbox' + social_counter + '" value="" /></p>');
						SocialTextDiv.append('<p><label>Social Icon '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+ilname+'[]" id="textbox' + social_counter + '" value="" ></p>');
						SocialTextDiv.append('<p><label>Social Class '+ social_counter+': </label>'+'<input type="text" class="widefat" name="'+sname+'[]" id="textbox' + social_counter + '" value="" ></p>');
						SocialTextDiv.appendTo(".social_tGroup");
						social_counter++;
					}
					function social_remove_tfields()
					{
						if(social_counter-1==1)
						{
							alert("you need one textbox required.");
							return false;
						}
						social_counter--;
						jQuery(".SocialTextDiv" + social_counter).remove();
					}
		</script>
<?php
		}
	}
}

/* -------------------------------------------------
Subscriber widget
---------------------------------------------------*/
if(!class_exists('Tmpl_Subscriber_Widget'))
{
	class Tmpl_Subscriber_Widget extends WP_Widget
	{
		function Tmpl_Subscriber_Widget()
		{
			//Constructor
			$widget_ops = array('classname'  => 'widget Newsletter subscribe','description'=> apply_filters('tmpl_subscriber_widget_title',__('Shows a subscribe box with which users can subscribe to your newsletter. Works best in main content, subsidiary and footer areas.','templatic') ));
			$this->WP_Widget('Tmpl_Subscriber_Widget',apply_filters('subscribewidget_filter',__('T &rarr; Newsletter','templatic')), $widget_ops);
		}
		function widget($args, $instance)
		{
			// prints the widget
			extract($args, EXTR_SKIP);
			global $mailchimp_api_key,$mailchimp_list_id;
			$feedburner_id = empty($instance['feedburner_id']) ? '' : apply_filters('widget_feedburner_id', $instance['feedburner_id']);
			$title = empty($instance['title']) ? __("Subscribe To Newsletter",'templatic') : apply_filters('widget_title', $instance['title']);
			$text = empty($instance['text']) ? __("Subscribe to get our latest news",'templatic') : apply_filters('widget_text', $instance['text']);
			$newsletter_provider = empty($instance['newsletter_provider']) ? 'feedburner' : apply_filters('widget_newsletter_provider', $instance['newsletter_provider']);
			$mailchimp_api_key = empty($instance['mailchimp_api_key']) ? '' : apply_filters('widget_mailchimp_api_key', $instance['mailchimp_api_key']);
			$mailchimp_list_id = empty($instance['mailchimp_list_id']) ? '' : apply_filters('widget_mailchimp_list_id', $instance['mailchimp_list_id']);
			$aweber_list_name = empty($instance['aweber_list_name']) ? '' : apply_filters('widget_aweber_list_name', $instance['aweber_list_name']);
			$feedblitz_list_id = empty($instance['feedblitz_list_id']) ? '' : apply_filters('widget_feedblitz_list_id', $instance['feedblitz_list_id']);
			add_action('wp_footer','attach_mailchimp_js');
			echo $args['before_widget'];
			?>
		<div class="subscribe newsletter_subscribe_footer_widget">
		  <div class="subscribe_wall">
			<?php
					if(function_exists('icl_register_string'))
					{
						icl_register_string('templatic',$title,$title);
						$title1 = icl_t('templatic',$title,$title);
					}
					else
					{
						$title1 = $title;
					}
					if($title1 && current_theme_supports('newsletter_title_abodediv'))
					{
						echo $args['before_title'].$title1.$args['after_title']; 
					}  ?>
			<div class="subscribe_cont">
					<?php
						if($title1 && !current_theme_supports('newsletter_title_abodediv'))
						{
							echo $args['before_title'].$title1.$args['after_title']; 
						}
						if(function_exists('icl_register_string'))
						{
							icl_register_string('templatic',$text,$text);
							$text1 = icl_t('templatic',$text,$text);
						}
						else
						{
							$text1 = $text;
						}
						?>
      <?php
						if($text1)
						{
							?>
      <p> <?php echo $text1; ?> </p>
      <?php
						}?>
      <span class="newsletter_msg" id="newsletter_msg"> </span>
      <?php
						if($newsletter_provider == 'feedburner')
						{
							?>
      <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/mailverify?uri=<?php echo $feedburner_id; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true" >
        <input type="text" id="newsletter_name" name="name" value="" class="field" onfocus="if (this.placeholder == '<?php _e('Your Name','templatic');?>') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = '<?php _e('Your Name','templatic');?>';}" placeholder ="<?php _e('Your Name','templatic'); ?>"  />
        <input type="text" id="newsletter_email" name="email" value="" class="field" onfocus="if (this.placeholder == '<?php _e('Your Email Address','templatic');?>') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = '<?php _e('Your Email Address','templatic');?>';}" placeholder="<?php _e('Your Email Address','templatic'); ?>"/>
        <input type="hidden" value="<?php echo $feedburner_id; ?>" name="uri"   />
        <input type="hidden" value="<?php bloginfo('name'); ?>" name="title" />
        <input type="hidden" name="loc" value="en_US"/>
        <input class="replace button" type="submit" name="submit" value="<?php _e('Subscribe','templatic');?>" />
      </form>
      <?php
						}
						elseif($newsletter_provider == 'mailchimp')
						{
							?>
      <input type="text" name="name" id="name" value="" class="field" onfocus="if (this.placeholder == '<?php _e('Name','templatic');?>') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = '<?php _e('Name','templatic');?>';}"  placeholder="<?php _e('Name','templatic');?>"/>
      <input type="text" name="email" id="email" value="" class="field" onfocus="if (this.placeholder == '<?php _e('Your Email Address','templatic');?>') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = '<?php _e('Your Email Address','templatic');?>';}" placeholder="<?php _e('Your Email Address','templatic'); ?>"/>
      <input class="replace button" type="submit" name="mailchimp_submit" id="mailchimp_submit" value="<?php _e('Subscribe','templatic');?>" />
      <?php
						}
						elseif($newsletter_provider == 'feedblitz')
						{
							?>
      <form Method="POST" action="http://www.feedblitz.com/f/f.fbz?AddNewUserDirect" target="popupwindow" onsubmit="window.open('http://www.feedblitz.com/f/f.fbz?AddNewUserDirect', 'popupwindow', 'scrollbars=yes,width=600,height=730');return true" >
        <input type="text" name="email" id="email" value="" class="field" onfocus="if (this.placeholder == '<?php _e('Your Email Address','templatic');?>') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = '<?php _e('Your Email Address','templatic');?>';}" placeholder="<?php _e('Your Email Address','templatic');?>"/>
        <input name="FEEDID" type="hidden" value="<?php echo $feedblitz_list_id;?>">
        <input type="submit" class="button" name="feedblitz_submit" value="<?php _e("Subscribe",'templatic');?>">
      </form>
      <?php
						}
						elseif($newsletter_provider == 'aweber')
						{
							?>
      <form method="post" action="http://www.aweber.com/scripts/addlead.pl">
        <input type="hidden" name="listname" value="<?php echo $aweber_list_name;?>" />
        <input type="hidden" name="redirect" value="<?php echo $_SERVER['REQUEST_URI'];?>" />
        <input type="hidden" name="meta_adtracking" value="custom form" />
        <input type="hidden" name="meta_message" value="1" />
        <input type="hidden" name="meta_required" value="name,email" />
        <input type="hidden" name="meta_forward_vars" value="1" />
        <input type="text" name="name" id="name" value="" class="field" onfocus="if (this.placeholder == 'Name') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = 'Name';}"  placeholder="<?php _e('Name','templatic');?>"/>
        <input type="text" name="email" id="email" value="" class="field" onfocus="if (this.placeholder == 'Your Email Address') {this.placeholder = '';}" onblur="if (this.placeholder == '') {this.placeholder = 'Your Email Address';}"  placeholder="<?php _e('Your Email Address','templatic');?>"/>
        <input type="submit" class="button" name="aweber_submit" value="Subscribe" />
      </form>
      <?php
							}	?>
		</div>
	  </div>
	</div>
<!--End mc_embed_signup-->
<?php
			echo $args['after_widget'];
		}
		function update($new_instance, $old_instance)
		{
			//save the widget			
			return $new_instance;
		}
		function form($instance)
		{
			//widgetform in backend
			$instance = wp_parse_args( (array) $instance, array('title' => __("Subscribe To Newsletter",'templatic'),'text' => __("Subscribe to get our latest news",'templatic'),'newsletter_provider'=> 'mailchimp','feedburner_id'=> '','mailchimp_api_key'  => '','mailchimp_list_id'  => '','aweber_list_name'   => '','feedblitz_list_id'  => '') );
			$feedburner_id       = strip_tags($instance['feedburner_id']);
			$title               = strip_tags($instance['title']);
			$text                = strip_tags($instance['text']);
			$newsletter_provider = strip_tags($instance['newsletter_provider']);
			$mailchimp_api_key   = strip_tags($instance['mailchimp_api_key']);
			$mailchimp_list_id   = strip_tags($instance['mailchimp_list_id']);
			$aweber_list_name    = strip_tags($instance['aweber_list_name']);
			$feedblitz_list_id   = strip_tags($instance['feedblitz_list_id']);?>
			<p>
			  <label for="<?php echo $this->get_field_id('title'); ?>">
				<?php echo __('Title:','templatic');?>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('text'); ?>">
				<?php echo __('Text Below Title:','templatic');?>
				<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo esc_attr($text); ?>" />
			  </label>
			</p>
			<p>
			  <label for="<?php echo $this->get_field_id('newsletter_provider'); ?>">
				<?php echo __("Newsletter Provider",'templatic');?>
				:
				<select id="<?php echo $this->get_field_id('newsletter_provider'); ?>" name="<?php echo $this->get_field_name('newsletter_provider'); ?>" onchange="show_hide_divs(this.value,'<?php echo $this->get_field_id('feedburner_id1'); ?>','<?php echo $this->get_field_id('mailchimp_id1'); ?>','<?php echo $this->get_field_id('feedblitz_id1'); ?>','<?php echo $this->get_field_id('aweber_id1'); ?>');" >
				  <option value="">
				  <?php echo __("Please select",'templatic');?>
				  </option>
				  <option value="feedburner" <?php
			 if("feedburner" == $newsletter_provider)
			{echo "selected=selected";}?>>
				  <?php echo __("Feedburner",'templatic');?>
				  </option>
				  <option value="mailchimp" <?php
			 if("mailchimp" == $newsletter_provider)
			{echo "selected=selected";}?>>
				  <?php echo __("MailChimp",'templatic');?>
				  </option>
				  <option value="feedblitz" <?php
			 if("feedblitz" == $newsletter_provider)
			{echo "selected=selected";}?>>
				  <?php echo __("FeedBlitz",'templatic');?>
				  </option>
				  <option value="aweber" <?php
			 if("aweber" == $newsletter_provider)
			{echo "selected=selected";}?>>
				  <?php echo __("Aweber",'templatic');?>
				  </option>
				</select>
			  </label>
			</p>
			<p id="<?php echo $this->get_field_id('feedburner_id1'); ?>" style="<?php
			 if($newsletter_provider == 'feedburner')
			{echo 'display:block';}
			else
			{echo 'display:none';};?>">
			  <label for="<?php echo $this->get_field_id('feedburner_id'); ?>">
				<?php echo __('ID:','templatic');?>
				<input class="widefat" id="<?php echo $this->get_field_id('feedburner_id'); ?>" name="<?php echo $this->get_field_name('feedburner_id'); ?>" type="text" value="<?php echo esc_attr($feedburner_id); ?>" />
			  </label>
			</p>
			<p id="<?php echo $this->get_field_id('mailchimp_id1'); ?>" style="<?php
			 if($newsletter_provider == 'mailchimp')
			{echo 'display:block';}
			else
			{echo 'display:none';};?>">
			  <label for="<?php echo $this->get_field_id('mailchimp_api_key'); ?>">
				<?php echo __('Mailchimp API Key:','templatic');?>
				<a href="https://us1.admin.mailchimp.com/account/api/" target="_blank"> (?) </a>
				<input class="widefat" id="<?php echo $this->get_field_id('mailchimp_api_key'); ?>" name="<?php echo $this->get_field_name('mailchimp_api_key'); ?>" type="text" value="<?php echo esc_attr($mailchimp_api_key); ?>" />
			  </label>
			  <label for="<?php echo $this->get_field_id('mailchimp_list_id'); ?>">
				<?php echo __('List Id:','templatic');?>
				<a href="http://kb.mailchimp.com/article/how-can-i-find-my-list-id" target="_blank"> (?) </a>
				<input class="widefat" id="<?php echo $this->get_field_id('mailchimp_list_id'); ?>" name="<?php echo $this->get_field_name('mailchimp_list_id'); ?>" type="text" value="<?php echo esc_attr($mailchimp_list_id); ?>" />
			  </label>
			</p>
			<p id="<?php echo $this->get_field_id('feedblitz_id1'); ?>" style="<?php
			 if($newsletter_provider == 'feedblitz')
			{echo 'display:block';}
			else
			{echo 'display:none';};?>">
			  <label for="<?php echo $this->get_field_id('feedblitz_list_id'); ?>">
				<?php echo __('List ID:','templatic');?>
				<input class="widefat" id="<?php echo $this->get_field_id('feedblitz_list_id'); ?>" name="<?php echo $this->get_field_name('feedblitz_list_id'); ?>" type="text" value="<?php echo esc_attr($feedblitz_list_id); ?>" />
			  </label>
			</p>
			<p id="<?php echo $this->get_field_id('aweber_id1'); ?>" style="<?php
			 if($newsletter_provider == 'aweber')
			{echo 'display:block';}
			else
			{echo 'display:none';};?>">
			  <label for="<?php echo $this->get_field_id('aweber_list_name'); ?>">
				<?php echo __('List Name:','templatic');?>
				<input class="widefat" id="<?php echo $this->get_field_id('aweber_list_name'); ?>" name="<?php echo $this->get_field_name('aweber_list_name'); ?>" type="text" value="<?php echo esc_attr($aweber_list_name); ?>" />
			  </label>
			</p>
		<?php add_action('admin_footer','tmpl_shohide_change_script');
		}
	}
/* Add newsletter show hide script in footer */
function tmpl_shohide_change_script(){ ?>
		<script type="text/javascript">
		function show_hide_divs(newsletter_provider,feedburner_id,mailchimp_id,feedblitz_id,aweber_id)
		{
			if(newsletter_provider == 'feedburner')
			{
				jQuery('#'+feedburner_id).show('slow');
				jQuery('#'+mailchimp_id).hide('slow');
				jQuery('#'+feedblitz_id).hide('slow');
				jQuery('#'+aweber_id).hide('slow');
			}else if(newsletter_provider == 'mailchimp')
			{
				jQuery('#'+mailchimp_id).show('slow');
				jQuery('#'+feedburner_id).hide('slow');
				jQuery('#'+feedblitz_id).hide('slow');
				jQuery('#'+aweber_id).hide('slow');
			}else if(newsletter_provider == 'feedblitz')
			{
				jQuery('#'+feedblitz_id).show('slow');
				jQuery('#'+mailchimp_id).hide('slow');
				jQuery('#'+feedburner_id).hide('slow');
				jQuery('#'+aweber_id).hide('slow');
			}else if(newsletter_provider == 'aweber')
			{
				jQuery('#'+aweber_id).show('slow');
				jQuery('#'+feedblitz_id).hide('slow');
				jQuery('#'+mailchimp_id).hide('slow');
				jQuery('#'+feedburner_id).hide('slow');
			}
		}
	</script>

<?php }
	/* Script for mail chimp script */
if(!function_exists('attach_mailchimp_js'))
{
	function attach_mailchimp_js()
	{
		global $mailchimp_api_key,$mailchimp_list_id;
		?>
		<script type="text/javascript">
			jQuery.noConflict();
			jQuery(document).ready(function()
				{
				jQuery('#mailchimp_submit').click(function()
						{
						jQuery('#process').css('display','block');
						var datastring = '&name=' + escape(jQuery('#name').val()) + '&email=' + escape(jQuery('#email').val()) + '&api_key=<?php echo $mailchimp_api_key;?>&list_id=<?php echo $mailchimp_list_id;?>';
						jQuery.ajax({
						url: '<?php echo get_template_directory_uri().'/library/classes/process_mailchimp.php';?>',
						data: datastring,
						success: function(msg)
						{
							jQuery('#process').css('display','none');
							jQuery('#newsletter_msg').html(msg);
						},
						error: function(msg)
						{
							jQuery('#process').css('display','none');
							jQuery('#newsletter_msg').html(msg);
						}
						});
						return false;
					});
				});
		</script>
<?php
	}
}
}

/* End newslater subscriber widget */
add_action('admin_footer','tmpl_widget_script'); // add script in footer 

/*
Name:tmpl_widget_script
Desc: add script for category widget
*/
function tmpl_widget_script(){
?>
<script type='text/javascript'>
	function tmpl_change_category(eid,post_type)
	{  	
	  if (post_type=="")
	  {
	  	document.getElementById(eid).innerHTML="";
		  return;
	  }else{
	  	document.getElementById(eid).innerHTML="";
	  }
		if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
		else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
		xmlhttp.onreadystatechange=function()
	  {
	    if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
		 document.getElementById(eid).innerHTML=xmlhttp.responseText;
		}
	  } 
	  url = "<?php echo get_template_directory_uri(); ?>/functions/ajax_category_dropdown.php?post_type="+post_type+'&is_ajax=1'
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();
	}
</script>
<?php } 
/**
 * Name:Tmpl_Realted_Plopular_Latest_Widget
 * Desc:Tabbed widget for Related,Popular,Latest
 *
 */
class Tmpl_Realted_Plopular_Latest_Widget extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_related_popular_latest_videos', 'description' => __( "Display related, popular and latest posts in a tabbed widget.","templatic") );
		parent::__construct('Tmpl_Realted_Plopular_Latest_Widget', __('T &rarr; Related,Popular,Latest Posts/Videos',"templatic"), $widget_ops);
		$this->alt_option_name = 'widget_realted_plopular_latest_videos';
		add_action( 'save_post', array($this, 'flush_widget_cache') );
		add_action( 'deleted_post', array($this, 'flush_widget_cache') );
		add_action( 'switch_theme', array($this, 'flush_widget_cache') );
	}

	function widget($args, $instance) {
		$cache = wp_cache_get('widget_related_popular_latest_videos', 'widget');

		if ( !is_array($cache) )
			$cache = array();

		if ( ! isset( $args['widget_id'] ) )
			$args['widget_id'] = $this->id;

		if ( isset( $cache[ $args['widget_id'] ] ) ) {
			echo $cache[ $args['widget_id'] ];
			return;
		}

		ob_start();
		extract($args);

		extract($args, EXTR_SKIP);
		echo $args['before_widget'];
		$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
 		
		$category = empty($instance['category']) ? '' : apply_filters('widget_category', $instance['category']);
		$post_number = empty($instance['number']) ? '8' : apply_filters('widget_post_number', $instance['number']);
		$show_excerpt = empty($instance['show_excerpt']) ? '50' : apply_filters('widget_show_excerpt', $instance['show_excerpt']);
		$show_related = empty($instance['show_related']) ? '' : apply_filters('widget_show_related', $instance['show_related']);
		$show_popular = empty($instance['show_popular']) ? '' : apply_filters('widget_show_popular', $instance['show_popular']);
		$show_latest = empty($instance['show_latest']) ? '' : apply_filters('widget_show_latest', $instance['show_latest']);
		$show_tag = empty($instance['show_tag']) ? '' : apply_filters('widget_show_tag', $instance['show_tag']);
		$view = empty($instance['view']) ? 'list' : apply_filters('widget_show_view', $instance['view']);
		$post_type = empty($instance['post_type']) ? 'list' : apply_filters('widget_post_type', $instance['post_type']);

		if($view =='grid'){ $class='grid'; }else{ $class="list"; }
		echo '';
		global $wpdb;
	?>
	 <div class="row col4-thumb <?php echo $class; ?>">
			<div class="widget widget_tabs widget-widget_tabs">
					<div class="widget-wrap widget-inside">	
						<?php
							$catCounter = 0;
							$pcount=0;
							$heading = 0;
							if($title){
							echo $args['before_title'].$title.$args['after_title'];  } ?>
		 				<dl class="tabs radius" data-tab> 
						<?php if($show_related){?>
							<dd <?php if($heading == 0 ) {$show_related_heading = 1; $heading = 1;?> class="active" <?php } ?>>
								<a href="#panel2-1"><?php _e('Related',"templatic"); ?></a>
							</dd> 
							<?php } if($show_popular){?>
							<dd <?php if($heading == 0 ) {$show_popular_heading = 1; $heading = 1;?> class="active" <?php } ?>>
								<a href="#panel2-2"><?php _e('Popular','templatic'); ?></a>
							</dd> 
							<?php } if($show_latest){?>
							<dd <?php if($heading == 0 ) {$show_latest_heading = 1; $heading = 1;?> class="active" <?php } ?>>
								<a href="#panel2-3"><?php _e('Latest','templatic'); ?></a>
							</dd> 
							<?php } if($show_tag){?>
							<dd <?php if($heading == 0 ) {$show_latest_heading = 1; $heading = 1;?> class="active" <?php } ?>>
								<a href="#panel2-4"><?php _e('Tags','templatic'); ?></a>
							</dd> 
							<?php } ?>
						</dl> 
						<div class="tabs-content"> 
							<div class="content <?php if(@$show_related_heading == 1 ) {$show_related_heading = 2;?> active <?php } ?>" id="panel2-1"> 
								<ul>
									<?php
									global $post;
									$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
									/* to fetch related videos by tags */
									if(@$related_post=='tags')
									{		
										$tags = wp_get_post_terms( $post->ID , $taxonomies[1],array("fields" => "names"));		
										$postQuery=array(
												  'post_type'  => $post_type,			      
												  'tax_query' => array(                
														array(
															'taxonomy' =>$taxonomies[1],
															'field' => 'name',
															'terms' => $tags,
															'operator'  => 'IN'
														)            
													 ),  
												  'post__not_in' => array($post->ID),
												  'posts_per_page' => $post_number,
												  'caller_get_posts'=>1,
												  'orderby' => 'RAND',
												 // 'order'  => 'DESC',
												);
									}
									else
									{	 /* to fetch related videos by categories */	
										 $terms = wp_get_post_terms($post->ID, $taxonomies[0], array("fields" => "ids"));	
										 $postQuery = array(
											'post_type'    => $post_type,
											'post_status'  => 'publish',
											'tax_query' => array(                
														array(
															'taxonomy' =>$taxonomies[0],
															'field' => 'ID',
															'terms' => $terms,
															'operator'  => 'IN'
														)            
													 ),
											'posts_per_page'=> $post_number,
											'ignore_sticky_posts'=>1,
											'orderby'      => 'RAND',
											'post__not_in' => array($post->ID)
										);
									}
									$my_query = new wp_query($postQuery);					
									$postcount = count($my_query->posts);
									$posttype_obj = get_post_type_object($post->post_type);
									$type_post = "";
									if($postcount > 1 ){
										$type_post = __("Entries",'templatic');
									}else{
										$type_post = __("Entry",'templatic');
									}
									$post_lable = ($posttype_obj->labels->menu_name) ? $posttype_obj->labels->menu_name : $type_post;
									if( $my_query->have_posts() ) :
									 ?>
									 	<?php global $post;
											  while ( $my_query->have_posts() ) : $my_query->the_post();		
												$post_rel_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb'); 
												$title = @$post->post_title;
												$alt = $post->post_title;
												$time = get_post_meta($post->ID,'time',true);
											?>
											 <li class="tab-detail">
												<a href="<?php echo esc_url(get_permalink($post->ID));?>" ><strong> <?php the_title();?></strong> </a>
												<span class="byline fn clearfix"><?php echo get_the_time(get_option('date_format')); ?></span>									
											</li>
											<?php endwhile;
												wp_reset_query();
												else:
												 echo "<p> Related listing not found</p>";
												endif;	
											?>	
									</ul>
							</div> 
							<div class="content <?php if(@$show_popular_heading == 1 ) {$show_popular_heading = 2;?> active <?php } ?>" id="panel2-2"> 
								<ul>
									<?php
									/* popular posts query */
									
									$r = new WP_Query( array( 'post_type'=> $post_type ,'orderby' => 'comment_count','order' => 'DESC','posts_per_page' => $post_number,'no_found_rows' => true,  'post_status' => 'publish') ); /* Query to fetch per comments count  */
									
									
									/* Loop start */
									global $post;
									if ($r->have_posts()) :
									?>
									<?php 
									/* Loop to display popular posts */
									while ( $r->have_posts() ) : $r->the_post();
										$post_rel_img =  tmpl_get_image_withinfo($post->ID,'listing-widget-thumb'); 
										$post_rel_img =$post_rel_img[0]['file'];
									?>
									
										<li class="tab-detail">
												<a href="<?php the_permalink(); ?>"><strong><?php get_the_title() ? the_title() : the_ID(); ?></strong></a>
												<span class="byline fn clearfix"><?php echo get_the_time(get_option('date_format')); ?></span>
										</li>

									<?php endwhile;
									else:
										 echo "<p> Popular post not found</p>";
									endif;wp_reset_query(); ?>
								</ul>
							</div> 
							<div class="content <?php if(@$show_latest_heading == 1 ) {$show_latest_heading = 2;?> active <?php } ?>" id="panel2-3"> 
								<ul>
									<?php 
									global $wpdb;
									$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
									
											if(!empty($category)){
												$lp = new WP_Query( array( 'post_type'=> $post_type ,
														'posts_per_page' => $post_number,
														 'tax_query' => array(
																			array(
																				'taxonomy' => $taxonomies[0],			
																				'field' => 'term_id',
																				'terms' => $category
																			)
																		),			
														 'orderby' => 'post_date',
														 'order' => 'DESC'  ) ); /* Query to fetch per view */
											}else{
												$lp = new WP_Query( array( 'post_type'=> $post_type ,
																 'posts_per_page' => $post_number,
																 'orderby' => 'post_date',
																 'order' => 'DESC'  ) ); /* Query to fetch per view */
											}
											global $post;
											if($lp->have_posts()){

													while($lp->have_posts()){ $lp->the_post();
															$post_rel_img =  tmpl_get_image_withinfo($post->ID,'listing-post-thumb'); 
															$post_rel_img =$post_rel_img[0]['file'];
															$time = get_post_meta($post->ID,'time',true);
											?>
														<li class="tab-detail">
															<a href="<?php echo esc_url(get_permalink($post->ID)); ?>" ><strong><?php the_title(); ?></strong></a>
												 
															<span class="byline fn clearfix"><?php echo get_the_time(get_option('date_format')); ?></span>
											
														</li>
											<?php } 
										}
										else
										{
											 echo "<p> Latest post not found</p>";
										}
										?>
								</ul>
							</div> 
							<div class="content <?php if(@$show_latest_heading == 1 ) {$show_latest_heading = 2;?> active <?php } ?>" id="panel2-4"> 
									<?php 
									global $wpdb;
									$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post_type,'public'   => true, '_builtin' => true ));	
										$terms = get_terms($taxonomies[1], array(
														'orderby'    => 'count',
														'hide_empty' => 0));
											?>
										<div class="tab-detail">
										<?php
										if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
												$count = count($terms);
												$i=0;
												$term_list = '<p class="my_term-archive">';
												foreach ($terms as $term) {
													$i++;
													$term_list .= '<a href="' . get_term_link( $term ) . '" title="' . sprintf(__('View all post filed under %s', 'templatic'), $term->name) . '">' . $term->name . '</a>';
													if ($count != $i) {
														$term_list .= ' &middot; '; 
													}
													else $term_list .= '</p>';
												}
												echo $term_list;
											}else
											{
												 echo "<p> Tag not found</p>";
											}
										?>
								</div>
							</div> 
						</div>
					</div>
				</div>
			</div>

		<!-- Article End -->
		<?php
		echo $args['after_widget'];

		$cache[$args['widget_id']] = ob_get_flush();
		wp_cache_set('widget_related_popular_latest_videos', $cache, 'widget');
	}

	function update( $new_instance, $old_instance ) {
		global $wpdb;
		$wpdb->query("delete from $wpdb->options where option_name LIKE '%related_popular_latest_%'");
		return $new_instance;
	}

	function flush_widget_cache() {
		wp_cache_delete('widget_related_popular_latest_videos', 'widget');
	}

	function form( $instance ) {
		
		//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'category' => '', 'number' => '' ) );
		$title = strip_tags(@$instance['title']);
		$category = @$instance['category'];
		$number = strip_tags(@$instance['number']);
		$show_related = strip_tags(@$instance['show_related']);
		$show_popular = strip_tags(@$instance['show_popular']);
		$show_latest = strip_tags(@$instance['show_latest']);
		$show_tag = strip_tags(@$instance['show_tag']);
		$view = strip_tags(@$instance['view']);
		$post_type = strip_tags(@$instance['post_type']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',"templatic" ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show',"templatic" ); ?>: </label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		 <p>
		 	<label for="<?php echo $this->get_field_id('post_type');  ?>"></label>
		 	<select class="widefat" name="<?php echo $this->get_field_name('post_type'); ?>" id="<?php  echo $this->get_field_id('post_type'); ?>" onchange="tmpl_change_category('<?php echo $this->get_field_id('category'); ?>',this.value);" >
		 		<option value="post" <?php if($post_type =='post'){ echo "selected=selected"; }?>><?php _e('Posts','templatic'); ?></option>
		 		<option value="videos" <?php if($post_type =='videos'){ echo "selected=selected"; }?>><?php _e('Videos','templatic'); ?></option>
		 	</select>
		 </p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_related ); ?> id="<?php echo $this->get_field_id( 'show_related' ); ?>" name="<?php echo $this->get_field_name( 'show_related' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_related' ); ?>"><?php _e( 'Display related post?',"templatic" ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_popular ); ?> id="<?php echo $this->get_field_id( 'show_popular' ); ?>" name="<?php echo $this->get_field_name( 'show_popular' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_popular' ); ?>"><?php _e( 'Display popular post?',"templatic" ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_latest ); ?> id="<?php echo $this->get_field_id( 'show_latest' ); ?>" name="<?php echo $this->get_field_name( 'show_latest' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_latest' ); ?>"><?php _e( 'Display latest post?',"templatic" ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $show_tag ); ?> id="<?php echo $this->get_field_id( 'show_tag' ); ?>" name="<?php echo $this->get_field_name( 'show_tag' ); ?>" value="1"/>
		
		    <label for="<?php echo $this->get_field_id( 'show_tag' ); ?>"><?php _e( 'Display tag?',"templatic" ); ?></label>
		</p>
		<?php
	}
}
/*
*
* Author Widget
*/
class Tmpl_Author_Widget extends WP_Widget {
	function Tmpl_Author_Widget() {
	//Constructor
		$widget_ops = array('classname' => 'widget Author', 'description' => __('Shows Author information for detail page',"templatic") );		
		$this->WP_Widget('Tmpl_Author_Widget', __('T &rarr; Author Widget',"templatic"), $widget_ops);
	}
	function widget($args, $instance) {
	// prints the widget
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? 'About Me' : apply_filters('widget_title', $instance['title']);
		global $post;
		$user_info = get_userdata($post->post_author);
		echo $args['before_widget'];
		 ?>						
		<div class="widget widget_about_author widget-widget_about_author">
			<div class="widget-wrap widget-inside">	
				<?php echo $args['before_title'].esc_html($title).$args['after_title']; ?>
				<div class="author_thumb"><?php echo get_avatar($post->post_author);  ?></div>
				<h6 class="author_name"><?php echo tmpl_author_posts_link(); ?></h6>
				<p><?php echo $user_info->description; ?></p>
			</div>
		</div>
                     
	<?php echo $args['after_widget'];
	}
	function update($new_instance, $old_instance) {
	//save the widget
		return $new_instance;
	}
	function form($instance) {
	//widgetform in backend
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );		
		$title = sanitize_text_field($instance['title']);
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',"templatic" ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
<?php
	}
}

/*
*
* Video Category Widget
*/
class Tmpl_Categories_Widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'classname' => 'widget_categories', 'description' => __( "A list or dropdown of categories.","templatic" ) );
		parent::__construct('Tmpl_Categories_Widget', __('T &rarr; Video Categories',"templatic"), $widget_ops);
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Categories',"templatic" ) : $instance['title'], $instance, $this->id_base);
		$c = ! empty( $instance['count'] ) ? '1' : '0';
		$h = ! empty( $instance['hierarchical'] ) ? '1' : '0';
		$d = ! empty( $instance['dropdown'] ) ? '1' : '0';

		echo $args['before_widget'];
		if ( $title )
			echo $args['before_title']. $title .$args['after_title'];

		$cat_args = array('taxonomy'=>'videoscategory','orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h);

		/* filter for category dropdown this filter is in same file */
		add_filter('wp_dropdown_cats','tmpl_wp_dropdown_cats',10,2);	
		
		if ( $d ) {
			$cat_args['show_option_none'] = __('Select Category',"templatic");
			wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
?>

<script type='text/javascript'>		
	jQuery(document).ready(function(){
		jQuery('#cat option').each(function(){
			if(jQuery(this).text() == '<?php single_cat_title(); ?>')
			{
				jQuery(this).attr('selected','selected');
			}
		
		});
		jQuery('#cat').bind('change',function(){
				
				var cat_slug = jQuery(this).val();
				/* for default post type category and tags */
				if('<?php echo $args['taxonomy'];?>' == 'category'){
					location.href = "<?php echo home_url(); ?>/?cat="+cat_slug;
				}else{ /* our custom post type category and tags */
					location.href = "<?php echo home_url();?>/?videoscategory="+cat_slug;
				}
		
		});
	
	});	
</script>

<?php
		} else {
?>
		<ul>
<?php
		$cat_args['title_li'] = '';
		wp_list_categories(apply_filters('widget_categories_args', $cat_args));
?>
		</ul>
<?php
		}

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = !empty($new_instance['count']) ? 1 : 0;
		$instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
		$instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => '') );
		$title = esc_attr( $instance['title'] );
		$count = isset($instance['count']) ? (bool) $instance['count'] :false;
		$hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
		$dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:','templatic' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
		<label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown','templatic' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
		<label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts','templatic' ); ?></label><br />

		<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
		<label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy','templatic' ); ?></label></p>
<?php
	}

}
/**
 * Related post widget class
 *
 */
class Tmpl_Widget_Related_Posts extends WP_Widget {


	function __construct() {
		$widget_ops = array('classname' => 'widget_related_posts', 'description' => __( "Your site&#8217;s Related Posts/Videos For Detail Page.","templatic") );
		parent::__construct('Tmpl_Widget_Related_Posts', __('T &rarr; Related Posts/Videos',"templatic"), $widget_ops);
		
	}

	function widget($args, $instance) {
		
		ob_start();
		extract($args);

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Related Posts',"templatic" );
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 8;
		
		global $post;
		$taxonomies = get_object_taxonomies( (object) array( 'post_type' => $post->post_type,'public'   => true, '_builtin' => true ));	
		 /* to fetch related videos by categories */	
			 $terms = wp_get_post_terms($post->ID, $taxonomies[0], array("fields" => "ids"));	
			 $postQuery = array(
				'post_type'    => $post->post_type,
				'post_status'  => 'publish',
				'tax_query' => array(                
							array(
								'taxonomy' =>$taxonomies[0],
								'field' => 'ID',
								'terms' => $terms,
								'operator'  => 'IN'
							)            
						 ),
				'posts_per_page'=> $number,
				'ignore_sticky_posts'=>1,
				'orderby'      => 'RAND',
				'post__not_in' => array($post->ID)
			);
		$my_query = new wp_query($postQuery);					
		$postcount = count($my_query->posts);
		$posttype_obj = get_post_type_object($post->post_type);
		$type_post = "";
		if($postcount > 1 ){
			$type_post = __("Entries",'templatic');
		}else{
			$type_post = __("Entry",'templatic');
		}
		echo $args['before_widget'];
		if ( $title ) echo $args['before_title']. esc_html($title) .$args['after_title'] ; 
		$post_lable = ($posttype_obj->labels->menu_name) ? $posttype_obj->labels->menu_name : $type_post;
		if( $my_query->have_posts() ) :
		?>	
			<ul class="list row">
			<?php global $post;
				  while ( $my_query->have_posts() ) : $my_query->the_post();		
					$title = @$post->post_title;
					$alt = $post->post_title;
					$time = get_post_meta($post->ID,'time',true);
		
				/* Loop to display related posts */
		
			$post_rel_img =  tmpl_get_image_withinfo($post->ID,'popular-post-thumb'); 
			$post_rel_img_x2 =  tmpl_get_image_withinfo($post->ID,'popular-post-retina-thumb'); // -retina
			$post_rel_img =$post_rel_img[0]['file'];
			$post_rel_img_x2 =$post_rel_img_x2[0]['file'];
		?>
		
			<li class="main-view clearfix">
				<div class="view-img">
					<a href="<?php echo esc_url(get_permalink($post->ID)); ?>"><img class="thumb-img" data-interchange="[<?php echo $post_rel_img;?>, (default)], [<?php echo $post_rel_img_x2;?>, (retina)]">
					<?php if($post->post_type == CUSTOM_POST_TYPE){ ?>
						<span class="video-overlay"><i class="fa fa-play-circle-o"></i></span>
					<?php } ?>
					</a>
					
					
				</div>
				<div class="view-desc">
					<h6><a href="#"><a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a></h6>
					<span class="byline"><?php echo '<span class="disabled-btn"><i class="step fa fa-eye"></i> <span>'. tmpl_get_post_view($post->ID).'</span></span> '; ?> <cite class="fn"><i class="fa fa-clock-o"></i> <?php echo get_the_time(get_option('date_format')); ?></cite></span>
				</div>
			</li>

			
		<?php endwhile; ?>
		</ul>
		<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();
		else:
			echo "<p>"; _e('No Related Posts.','templatic'); echo "</p>";
		endif;
		/* Loop End */

		$cache[$args['widget_id']] = ob_get_flush();
		
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function form( $instance ) {
		
		$title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		 ?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:',"templatic" ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show',"templatic" ); ?>: </label>
		<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" /></p>

	<?php
	}
}


function tmpl_wp_dropdown_cats($output,$r){

	$option_none_value = $r['option_none_value'];

	if ( ! isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] ) {
			$r['pad_counts'] = true;
	}

	$tab_index = $r['tab_index'];

	$tab_index_attribute = '';
	if ( (int) $tab_index > 0 ) {
			$tab_index_attribute = " tabindex=\"$tab_index\"";
	}
	$categories = get_terms( $r['taxonomy'], $r );
	$name = esc_attr( $r['name'] );
	$class = esc_attr( $r['class'] );
	$id = $r['id'] ? esc_attr( $r['id'] ) : $name;

	if ( ! $r['hide_if_empty'] || ! empty( $categories ) ) {
			$output = "<select name='$name' id='$id' class='$class' $tab_index_attribute>\n";
	} else {
			$output = '';
	}
	if ( empty( $categories ) && ! $r['hide_if_empty'] && ! empty( $r['show_option_none'] ) ) {

			/**
			 * Filter a taxonomy drop-down display element.
			 *
			 * A variety of taxonomy drop-down display elements can be modified
			 * just prior to display via this filter. Filterable arguments include
			 * 'show_option_none', 'show_option_all', and various forms of the
			 * term name.
			 *
			 * @since 1.2.0
			 *
			 * @see wp_dropdown_categories()
			 *
			 * @param string $element Taxonomy element to list.
			 */
			$output .= "\t<option data-val='test' value='" . esc_attr( $option_none_value ) . "' selected='selected'>".__('Select Category',"templatic")."</option>\n";
	}

	if ( ! empty( $categories ) ) {

			if ( $r['show_option_all'] ) {

					/** This filter is documented in wp-includes/category-template.php */
					$selected = ( '0' === strval($r['selected']) ) ? " selected='selected'" : '';
					$output .= "\t<option data-val='test' value='0'$selected>$show_option_all</option>\n";
			}

			if ( $r['show_option_none'] ) {

					/** This filter is documented in wp-includes/category-template.php */
					$selected = selected( $option_none_value, $r['selected'], false );
					$output .= "\t<option data-val='test' value='" . esc_attr( $option_none_value ) . "'$selected>".__('Select Category',"templatic")."</option>\n";
			}

			if ( $r['hierarchical'] ) {
				$depth = $r['depth'];  // Walk the full depth.
			} else {
					$depth = -1; // Flat.
		}
		$output .= walk_category_dropdown_tree1( $categories, $depth, $r );
	}

	if ( ! $r['hide_if_empty'] || ! empty( $categories ) ) {
			$output .= "</select>\n";
}
return $output;
}
?>