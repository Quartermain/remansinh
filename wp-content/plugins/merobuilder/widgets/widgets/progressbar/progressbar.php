<?php

class SiteOrigin_Panels_Widget_Progressbar extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Progressbar (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('A Progress bar ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-panels'),
				),

				'percent' => array(
					'type' => 'text',
					'label' => __('Percentage (only number)', 'siteorigin-panels'),
				),
				
			)
		);
	}

}