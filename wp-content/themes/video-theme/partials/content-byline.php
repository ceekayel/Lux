<p class="byline">
	<?php
	if($post->post_type =='post'){
	 printf(__('Posted by <span class="author">%3$s</span> on <time class="updated" datetime="%1$s" pubdate>%2$s</time> in %4$s', 'templatic'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), tmpl_author_posts_link(), get_the_category_list(', '));
	}else{
		$term_list = wp_get_post_terms($post->ID, CUSTOM_CATEGORY_SLUG, array("fields" => "all")); // fetch categories of video
		
		 printf(__('Posted by <span class="author">%3$s</span> on <time class="updated" datetime="%1$s" pubdate>%2$s</time>', 'templatic'), get_the_time('Y-m-j'), get_the_time(get_option('date_format')), tmpl_author_posts_link());
		 // start to fetch catgories
		 if(!empty($term_list)){
		 		$cats='';
		 		$sep=', ';
		 		for($c=0; $c< count($term_list); $c++){ echo $c;
		 				if($c == (count($term_list[$c])) || count($term_list) ==1){
		 					$sep =' ';	
		 				}
		 				$cats .= "<a href='".get_term_link($term_list[$c]->term_id,$term_list[$c]->taxonomy)."'>".$term_list[$c]->name."</a>".$sep; // give link to terms

		 		}
		 		echo " ".__('in','templatic')." ".$cats;
		 }

	}
	 ?>
</p>	