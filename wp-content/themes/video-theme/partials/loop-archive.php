<?php  /*call to different post formats */
		$post_format = get_post_format($post->ID); 

		get_template_part('partials/content',$post_format);
?>	
