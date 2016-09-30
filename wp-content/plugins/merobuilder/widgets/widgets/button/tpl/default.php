<a class="btn-color btn-color-1d <?php echo (empty($instance['bstyle']) ? '' : $instance['bstyle']) ; ?>" href="<?php echo esc_url($instance['url']) ?>" <?php if(!empty($instance['new_window'])) echo 'target="_blank"'; ?>>
	<?php echo esc_html($instance['text']) ?>
</a>