<?php

/*
Widget Name: TinyMCE Widget
Description: A widget which allows editing of content using the TinyMCE editor.
Author: SiteOrigin
Author URI: https://siteorigin.com
*/

class SiteOrigin_Widget_TinyMCE_Widget extends SiteOrigin_Widget {

	function __construct() {

		parent::__construct(
			'sow-tinymce',
			__('SiteOrigin Visual Editor', 'siteorigin-widgets'),
			array(
				'description' => __('A TinyMCE Widget.', 'siteorigin-widgets'),
			),
			array(),
			array(
				'text' => array(
					'type' => 'tinymce',
					'rows' => 20,
					'button_filters' => array(
						'mce_buttons' => array( $this, 'mce_buttons_filter'),
						'quicktags_settings' => array( $this, 'quicktags_settings'),
					)
				),
			),
			plugin_dir_path(__FILE__)
		);
	}

	public function mce_buttons_filter( $buttons, $editor_id ) {
		if (($key = array_search('fullscreen', $buttons)) !== false) {
			unset($buttons[$key]);
		}
		return $buttons;
	}

	public function quicktags_settings( $settings, $editor_id ) {
		$settings['buttons'] = preg_replace( '/,fullscreen/', '', $settings['buttons'] );
		$settings['buttons'] = preg_replace( '/,dfw/', '', $settings['buttons'] );
		return $settings;
	}

	public function get_template_variables( $instance, $args ) {
		$instance = wp_parse_args(
			$instance,
			array(
				'text' => ''
			)
		);

		$instance['text'] = do_shortcode( $instance['text'] );
		$instance['text'] = wpautop( $instance['text'] );

		return array(
			'text' => $instance['text']
		);
	}


	function get_template_name($instance) {
		return 'tinymce';
	}

	function get_style_name($instance) {
		return '';
	}
}

siteorigin_widget_register( 'tinymce', __FILE__ );