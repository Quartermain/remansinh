<?php

class SiteOrigin_Panels_Widget_Portfolio extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Portfolio Block (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Compelte Portfolio Block ', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'pstyle' => array(
					'type' => 'select',
					'label' => __('Portfolio Style', 'siteorigin-panels'),
					'options' => array(
						'light' => __('Lightbox', 'siteorigin-panels'),
						'ajax' => __('Ajax', 'siteorigin-panels'),
						'newpage' => __('New page', 'siteorigin-panels'),
					)
				),
				'playout' => array(
					'type' => 'select',
					'label' => __('Portfolio Style', 'siteorigin-panels'),
					'options' => array(
						'masonry' => __('Masonry', 'siteorigin-panels'),
						'fullscreen' => __('Fullscreen', 'siteorigin-panels'),
						'box' => __('Boxed', 'siteorigin-panels'),
					)
				),				
				)
		);
	}

}