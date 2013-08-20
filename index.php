<?php

/*
Plugin Name: Ebor Video Widget
Plugin URI: http://www.madeinebor.com
Description: Adds an oEmbed widget for use in any WordPress theme.
Version: 1.2
Author: TommusRhodus
Author URI: http://www.madeinebor.com
*/	

/*-----------------------------------------------------------------------------------*/
/*	ENQUEUE STYLING
/*-----------------------------------------------------------------------------------*/
function ebor_video_widget_style() {
	wp_enqueue_style( 'ebor-video-widget-styles', plugins_url( '/ebor-video-widget.css' , __FILE__ ) );
}
add_action('wp_enqueue_scripts', 'ebor_video_widget_style', 90);

/*-----------------------------------------------------------------------------------*/
/*	VIDEO WIDGET
/*-----------------------------------------------------------------------------------*/
add_action('widgets_init', 'ebor_video_load_widgets');
function ebor_video_load_widgets()
{
	register_widget('ebor_video_widget');
}

class ebor_video_widget extends WP_Widget {
	
	function ebor_video_widget()
	{
		$widget_ops = array('classname' => 'ebor_video', 'description' => '');

		$control_ops = array('id_base' => 'ebor-video-widget');

		$this->WP_Widget('ebor-video-widget', 'Ebor: Video', $widget_ops, $control_ops);
	}
	
	function widget($args, $instance)
	{
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		if($title) {
			echo  $before_title.$title.$after_title;
		} ?>
		
			<?php echo apply_filters('the_content', $instance['oembed']); ?>
		
		<?php echo $after_widget;
	}
	
	function update($new_instance, $old_instance)
	{
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['oembed'] = esc_url($new_instance['oembed']);

		return $instance;
	}

	function form($instance)
	{
		$defaults = array('title' => 'Video Widget', 'oembed' => 'http://youtu.be/9bZkp7q19f0');
		$instance = wp_parse_args((array) $instance, $defaults); ?>
		
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('oembed'); ?>">Video URL:</label>
			<p>All available embed URL services are listed <a href="http://codex.wordpress.org/Embeds">here</a></p>
			<input class="widefat" style="width: 216px;" id="<?php echo $this->get_field_id('oembed'); ?>" name="<?php echo $this->get_field_name('oembed'); ?>" value="<?php echo $instance['oembed']; ?>" />
		</p>
	<?php
	}
}