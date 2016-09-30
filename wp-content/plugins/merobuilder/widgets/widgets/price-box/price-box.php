<?php

class SiteOrigin_Panels_Widget_Price_Box extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Price Box (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('Displays a price box', 'siteorigin-panels'),
				'default_style' => 'default',
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __('Title', 'siteorigin-panels'),
				),
				'price' => array(
					'type' => 'text',
					'label' => __('Price', 'siteorigin-panels'),
				),
				'per' => array(
					'type' => 'text',
					'label' => __('Per', 'siteorigin-panels'),
				),
				'information' => array(
					'type' => 'text',
					'label' => __('Information Text', 'siteorigin-panels'),
				),
				'features' => array(
					'type' => 'textarea',
					'label' => __('Features Text', 'siteorigin-panels'),
					'description' => __('Start each new point with an asterisk (*)', 'siteorigin-panels'),
				),
				'button_text' => array(
					'type' => 'text',
					'label' => __('Button Text', 'siteorigin-panels'),
				),
				'button_url' => array(
					'type' => 'text',
					'label' => __('Button URL', 'siteorigin-panels'),
				),
				'button_new_window' => array(
					'type' => 'checkbox',
					'label' => __('Open In New Window', 'siteorigin-panels'),
				),
				'animation' => array(
					'type' => 'select',
					'label' => __('Box animation', 'siteorigin-panels'),
					'options' => array(
						'none' => __('none', 'siteorigin-panels'),
						'bounce' => __('bounce', 'siteorigin-panels'),
						'flash' => __('flash', 'siteorigin-panels'),
						'pulse' => __('pulse', 'siteorigin-panels'),
						'rubberBand' => __('rubberBand', 'siteorigin-panels'),
						'shake' => __('shake', 'siteorigin-panels'),
						'swing' => __('swing', 'siteorigin-panels'),
						'tada' => __('tada', 'siteorigin-panels'),
						'wobble' => __('wobble', 'siteorigin-panels'),
						'bounceIn' => __('bounceIn', 'siteorigin-panels'),
						'bounceInDown' => __('bounceInDown', 'siteorigin-panels'),
						'bounceInLeft' => __('bounceInLeft', 'siteorigin-panels'),
						'bounceInRight' => __('bounceInRight', 'siteorigin-panels'),
						'bounceInUp' => __('bounceInUp', 'siteorigin-panels'),
						'fadeIn' => __('fadeIn', 'siteorigin-panels'),
						'fadeInDown' => __('fadeInDown', 'siteorigin-panels'),
						'fadeInDownBig' => __('fadeInDownBig', 'siteorigin-panels'),
						'fadeInLeft' => __('fadeInLeft', 'siteorigin-panels'),
						'fadeInLeftBig' => __('fadeInLeftBig', 'siteorigin-panels'),
						'fadeInRight' => __('fadeInRight', 'siteorigin-panels'),
						'fadeInRightBig' => __('fadeInRightBig', 'siteorigin-panels'),
						'fadeInUp' => __('fadeInUp', 'siteorigin-panels'),
						'fadeInUpBig' => __('fadeInUpBig', 'siteorigin-panels'),
						'flip' => __('flip', 'siteorigin-panels'),
						'flipInX' => __('flipInX', 'siteorigin-panels'),
						'flipInY' => __('flipInY', 'siteorigin-panels'),
						'rotateIn' => __('rotateIn', 'siteorigin-panels'),
						'rotateInDownLeft' => __('rotateInDownLeft', 'siteorigin-panels'),
						'rotateInDownRight' => __('rotateInDownRight', 'siteorigin-panels'),
						'rotateInUpLeft' => __('rotateInUpLeft', 'siteorigin-panels'),
						'rotateInUpRight' => __('rotateInUpRight', 'siteorigin-panels'),
						'slideInDown' => __('slideInDown', 'siteorigin-panels'),
						'slideInLeft' => __('slideInLeft', 'siteorigin-panels'),
						'slideInRight' => __('slideInRight', 'siteorigin-panels'),
						'hinge' => __('hinge', 'siteorigin-panels'),
						'rollIn' => __('rollIn', 'siteorigin-panels'),
					)
				),
			)
		);

		$this->add_sub_widget('button', __('Button', 'siteorigin-panels'), 'SiteOrigin_Panels_Widget_Button');
		$this->add_sub_widget('list', __('Feature List', 'siteorigin-panels'), 'SiteOrigin_Panels_Widget_List');
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'animated '.(empty($instance['animation']) ? 'none' : $instance['animation']);
		return $classes;
	}
}