<?php
/* =============================== Social widget START ====================================== */
if(!class_exists('social_media')){
	class social_media extends WP_Widget {
		function social_media() {
		//Constructor
			$widget_ops = array('classname' => 'widget social_media', 'description' => 'Provide a link to your account on various social media sites, Use in: After Header, Primary, Subsidiary area.' );		
			$this->WP_Widget('social_media', 'T &rarr; Social Media', $widget_ops);
		}
		function widget($args, $instance) {
		// prints the widget
			extract($args, EXTR_SKIP);
			echo $before_widget;
			echo '<div class="social_media" >';
			$title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$social_description = empty($instance['social_description']) ? '' : apply_filters('widget_title', $instance['social_description']);
			
			$social_link = empty($instance['social_link']) ? '' : apply_filters('widget_social_link', $instance['social_link']);
			$social_icon = empty($instance['social_icon']) ? '' : apply_filters('widget_social_icon', $instance['social_icon']);
			$social_text = empty($instance['social_text']) ? '' : apply_filters('widget_social_text', $instance['social_text']);
			
			if($title!="")
			echo $before_title;
				echo $title;
			echo $after_title;
			if($social_description!=""): ?>
				<p class="social_description"><?php echo stripcslashes($social_description);?></p>
               <?php endif;?>
			<div class="social_media">
                 <ul class="social_media_list">
					<?php 
					if(count($social_icon) >0){
					for($c=0; $c < count($social_icon); $c++){
							?>	
								<li><a href="<?php echo @$social_link[$c]; ?>" target="_blank" ><?php if(@$social_icon[$c]!=''):?><span class="social_icon"><img src="<?php echo @$social_icon[$c];?>" alt="<?php echo @$social_text[$c];?>" /></span><?php endif;?><span class="social_text"><?php echo sprintf(__('%s','supreme'), @$social_text[$c]);?></span></a></li>
                     <?php 
						  }
						 }
					 ?> 
                 </ul>
             </div>
		<?php
			echo '</div>';
			echo $after_widget;
		}
		function update($new_instance, $old_instance) {
		//save the widget
			return $new_instance;
		}
		function form($instance) {
			//widgetform in backend
			$instance = wp_parse_args((array) $instance, array( 'title' => '', 'social_description' => '', 'social_link' => '', 'social_icon' => '','social_text'=>''));		
			$title = strip_tags($instance['title']);
			$social_description = strip_tags($instance['social_description']);
			$social_link1 = ($instance['social_link']);
			$social_icon1 = ($instance['social_icon']);
			$social_text1 = ($instance['social_text']);
			
			global $social_link,$social_icon,$social_text;
			$text_social_link=$this->get_field_name('social_link');
			$text_social_icon=$this->get_field_name('social_icon');
			$text_social_text=$this->get_field_name('social_text');
		
		
	?>
    <p>
        <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','supreme');?>: 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
    </p>
    
				<p>
        <label for="<?php echo $this->get_field_id('social_description'); ?>"><?php _e('Description','supreme');?>: 
        <input class="widefat" id="<?php echo $this->get_field_id('social_description'); ?>" name="<?php echo $this->get_field_name('social_description'); ?>" type="text" value="<?php echo esc_attr($social_description); ?>" /></label>
    </p>
				
    <p><i>specify full URL to your profiles.</i></p>
     
    <p>
		<label for="<?php echo $this->get_field_id('social_link'); ?>">
			<?php _e('Social Link','supreme');?>: <input class="widefat" id="<?php echo $this->get_field_id('social_link'); ?>" name="<?php echo $text_social_link; ?>[]" type="text" value="<?php echo esc_attr($social_link1[0]); ?>" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('social_icon'); ?>">
			<?php _e('Social Icon','supreme');?>: <input class="widefat" id="<?php echo $this->get_field_id('social_icon'); ?>" name="<?php echo $text_social_icon; ?>[]" type="text" value="<?php echo esc_attr($social_icon1[0]); ?>" />
		</label>
	</p>
	
	<p>
		<label for="<?php echo $this->get_field_id('social_text1'); ?>">
			<?php _e('Social Text','supreme');?>: <input class="widefat" id="<?php echo $this->get_field_id('social_text1'); ?>" name="<?php echo $text_social_text; ?>[]" type="text" value="<?php echo esc_attr($social_text1[0]); ?>" />
		</label>
	</p>
	<div id="social_tGroup" class="social_tGroup">
		<?php
			for($i=1;$i<count($social_link1);$i++){							
				if($social_link1[$i]!=""){
					$j=$i+1;
					echo '<div  class="SocialTextDiv'.$j.'">';
					
					echo '<p>';
					echo '<label>Social Link '.$j;
					echo '<input class="widefat" name="'.$text_social_link.'[]" type="text" value="'.esc_attr($social_link1[$i]).'" />';
					echo '</label>';
					echo '</p>';
					
					echo '<p>';
					echo '<label>Social Icon '.$j;
					echo ' <input type="text" class="widefat"  name="'.$text_social_icon.'[]" value="'.esc_attr($social_icon1[$i]).'">';
					echo '</label>';
					echo '</p>';
					
					echo '<p>';
					echo '<label>Social Text '.$j;
					echo ' <input type="text" class="widefat"  name="'.$text_social_text.'[]" value="'.esc_attr($social_text1[$i]).'">';
					echo '</label>';
					echo '</p>';
					
					echo '</div>';
				}
			}
		?>
	</div>
	<p>	
		<a href="javascript:void(0);" id="addtButton" class="addButton" onclick="social_add_tfields('<?php echo $text_social_link; ?>','<?php echo $text_social_icon; ?>','<?php echo $text_social_text; ?>');">Add more</a> &nbsp;&nbsp;
		<a href="javascript:void(0);" id="removetButton" class="removeButton"  onclick="social_remove_tfields();">Remove</a>
	</p>	
	<?php
		}
	}
	register_widget('social_media');
}
/* =============================== Social widget START ====================================== */

add_action('admin_head','supreme_add_script_addnew_');
if(!function_exists('supreme_add_script_addnew_')){
	function supreme_add_script_addnew_(){
		global $social_link,$social_icon,$social_text;
		?>
		  <script type="application/javascript">			
			var social_counter = 2;
			function social_add_tfields(name,ilname,sname)
			{
				var SocialTextDiv = jQuery(document.createElement('div')).attr("class", 'SocialTextDiv' + social_counter);
				
				SocialTextDiv.html('<p><label>Social Link '+ social_counter +' </label>'+'<input type="text" class="widefat" name="'+name+'[]" id="textbox' + social_counter + '" value="" /></p>');
				
				SocialTextDiv.append('<p><label>Social Icon '+ social_counter + '</label>'+'<input type="text" class="widefat" name="'+ilname+'[]" id="textbox' + social_counter + '" value="" ></p>');
				SocialTextDiv.append('<p><label>Social Text '+ social_counter + '</label>'+'<input type="text" class="widefat" name="'+sname+'[]" id="textbox' + social_counter + '" value="" ></p>');
				SocialTextDiv.appendTo(".social_tGroup");
					
				social_counter++;
			}
			function social_remove_tfields()
			{	
				if(social_counter-1==1){
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
?>