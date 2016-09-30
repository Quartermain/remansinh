<div class="appdesign ">
	<div class="appdesign-<?php echo $instance['icon_position'] ?>">
		<div class="app-service <?php if(!empty($instance['animation']) && $instance['animation']!='none') : echo 'animated '.$instance['animation']; endif; ?>">
			<!-- ICON -->
			<div class="icon-container">
				<div class="icon">
					<i class="fa fa-<?php echo $instance['icon'] ?>"></i>
				</div>
			</div>
			
			<!-- DESCRIPTION -->
			<div class="app-service-details">
				<h3><?php echo esc_html($instance['title']) ?></h3>
				<p><?php echo wp_kses_post($instance['description']) ?></p>
			</div>
			
		</div>
	</div>
</div>