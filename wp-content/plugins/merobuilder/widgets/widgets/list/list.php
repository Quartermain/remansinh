<?php

class SiteOrigin_Panels_Widget_List extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('List (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a bullet list of elements', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-panels'),
				),
				'text' => array(
					'type' => 'textarea',
					'label' => __('Body', 'siteorigin-panels'),
					'description' => __('Start each new point with an asterisk (*)', 'siteorigin-panels'),
				),
				'listicon' => array(
					'type' => 'select',
					'label' => __('List Icon', 'siteorigin-panels'),
					'options' => array(
						'check' => __('Check', 'siteorigin-panels'),
						'check-square' => __('Check Square', 'siteorigin-panels'),	
						'check-square-o' => __('Check Square Hollow', 'siteorigin-panels'),
						'check-circle' => __('Check Circle', 'siteorigin-panels'),
						'check-circle-o' => __('Check Circle Hollow', 'siteorigin-panels'),
						'star' => __('Star', 'siteorigin-panels'),
						'circle' => __('Circle', 'siteorigin-panels'),
						'angle-right' => __('Angle', 'siteorigin-panels'),
					)
				),
			)
		);
	}

	static function create_list($text,$icon){
		// Add the list items
		$text = preg_replace( "/\*+(.*)?/i", "<ul><li><i class='icon-".$icon."'></i>$1</li></ul>", $text );
		$text = preg_replace( "/(\<\/ul\>\n(.*)\<ul\>*)+/", "", $text );
		$text = wpautop( $text );

		// Return sanitized version of the list
		return wp_kses_post($text);
	}
}