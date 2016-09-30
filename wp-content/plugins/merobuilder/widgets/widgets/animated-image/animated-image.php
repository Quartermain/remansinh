<?php

class SiteOrigin_Panels_Widget_Animated_Image extends SiteOrigin_Panels_Widget  {
	function __construct() {
		parent::__construct(
			__('Animated Image (Elano)', 'siteorigin-panels'),
			array(
				'description' => __('An animated image block', 'siteorigin-panels'),
				'default_style' => 'simple',
			),
			array(),
			array(
				'image' => array(
					'type' => 'text',
					'label' => __('Image URL', 'siteorigin-panels'),
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
				'animation' => array(
					'type' => 'select',
					'label' => __('Animation', 'siteorigin-panels'),
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
	}

	function widget_classes($classes, $instance) {
		$classes[] = 'align-'.(empty($instance['align']) ? 'none' : $instance['align']);
		return $classes;
	}

}