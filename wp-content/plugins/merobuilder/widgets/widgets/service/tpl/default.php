<div class="hi-icon-wrap hi-icon-effect-1 hi-icon-effect-1a">
<div class="hi-icon <?php if(!empty($instance['animation']) && $instance['animation']!='none') : echo 'animated '.$instance['animation']; endif; ?>">
		<!-- Icon here -->
	      <i class="fa fa-<?php echo $instance['icon'] ?>"></i>
	      <!-- Description Tooltip here -->
	      <div class="tooltip-desc">
		      <span class="tooltip-arrow-down"></span>
		      <div class="tooltip-content">
			      <p><?php echo wp_kses_post($instance['description']) ?></p>
		      </div>
		  </div>
	     <h6><?php echo esc_html($instance['title']) ?></h6>
  </div>
</div>