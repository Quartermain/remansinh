<?php

class SiteOrigin_Panels_Widget_Testimonial_Slider extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Testimonial Slider (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Full testimonial Slider ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array()
		);
	}

}