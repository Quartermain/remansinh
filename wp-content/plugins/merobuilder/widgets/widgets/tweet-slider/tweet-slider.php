<?php

class SiteOrigin_Panels_Widget_Tweet_Slider extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Tweet Slider (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Full Tweet Slider ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array()
		);
	}

}