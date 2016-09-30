<?php

class SiteOrigin_Panels_Widget_Portfolio_Slider extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Portfolio Slider (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Complete Portfolio Slider', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(

				'slidesnum' => array(
					'type' => 'text',
					'label' => __('Slides number', 'siteorigin-panels'),
				),

				'portfolio_button' => array(
					'type' => 'checkbox',
					'label' => __('Show Portfolio Button? ', 'siteorigin-panels'),
				),

				'alternative_button' => array(
					'type' => 'checkbox',
					'label' => __('Alternative navigation arrows? ', 'siteorigin-panels'),
				),

				'pstyle' => array(
					'type' => 'select',
					'label' => __('Portfolio Style', 'siteorigin-panels'),
					'options' => array(
						'light' => __('Lightbox', 'siteorigin-panels'),
						'ajax' => __('Ajax', 'siteorigin-panels'),
						'newpage' => __('New page', 'siteorigin-panels'),
					)
				),
						
				)
		);
	}

	function widget_classes($classes, $instance) {
		$classes[] = ''.(empty($instance['alternative_button']) ? '' : 'nav-portfolio-slider-style2');
		return $classes;
	}

}