<?php

class SiteOrigin_Panels_Widget_Button extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Button (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('A button block', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(
				'text' => array(
					'type' => 'text',
					'label' => __('Text', 'siteorigin-panels'),
				),
				'url' => array(
					'type' => 'text',
					'label' => __('Destination URL', 'siteorigin-panels'),
				),
				'new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'siteorigin-panels'),
				),
				'align' => array(
					'type' => 'select',
					'label' => __('Button Alignment', 'siteorigin-panels'),
					'options' => array(
						'left' => __('Left', 'siteorigin-panels'),
						'right' => __('Right', 'siteorigin-panels'),
						'center' => __('Center', 'siteorigin-panels'),
						'justify' => __('Justify', 'siteorigin-panels'),
					)
				),
				'bstyle' => array(
					'type' => 'select',
					'label' => __('Button Alignment', 'siteorigin-panels'),
					'options' => array(
						'tp-button green' => __('green', 'siteorigin-panels'),
						'tp-button blue' => __('blue', 'siteorigin-panels'),
						'tp-button red' => __('red', 'siteorigin-panels'),
						'tp-button orange' => __('orange', 'siteorigin-panels'),
						'tp-button darkgrey' => __('darkgrey', 'siteorigin-panels'),
						'tp-button lightgrey' => __('lightgrey', 'siteorigin-panels'),
						'tp-button green-fill' => __('green filled', 'siteorigin-panels'),
						'tp-button blue-fill' => __('blue filled', 'siteorigin-panels'),
						'tp-button red-fill' => __('red filled', 'siteorigin-panels'),
						'tp-button orange-fill' => __('orange filled', 'siteorigin-panels'),
						'tp-button darkgrey-fill' => __('darkgrey filled', 'siteorigin-panels'),
						'tp-button lightgrey-fill' => __('lightgrey filled', 'siteorigin-panels'),
						

					)
				),
			)
		);
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'align-'.(empty($instance['align']) ? 'none' : $instance['align']);
		return $classes;
	}
}