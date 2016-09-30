<?php $rand=rand();?>
<?php
$step_size=pow(10,(strlen($instance['number'])-3));
?>
<?php if(!empty($instance['icon'])) : ?>
<!-- Center Icon here -->
<div class="center-icon">
	<i class="fa fa-<?php echo esc_html($instance['icon']) ; ?>"></i>
</div> 
<?php endif;?>
<div class="numericals">
<script type="text/javascript">
    jQuery(window).load(function () {
        if (isScrolledIntoView("numerical-<?php echo $rand;?>")) {
            jQuery('#numerical-<?php echo $rand;?>').removeClass('notinview');
            incrementNumerical('#numerical-<?php echo $rand;?>', <?php echo esc_html($instance['number']) ?>, <?php echo $step_size;?>);
        }
    });
    jQuery(window).scroll(function () {
        if (jQuery('#numerical-<?php echo $rand;?>.notinview').length) {
            if (isScrolledIntoView("numerical-<?php echo $rand;?>")) {
                jQuery('#numerical-<?php echo $rand;?>').removeClass('notinview');
                incrementNumerical('#numerical-<?php echo $rand;?>', <?php echo esc_html($instance['number']) ?>, <?php echo $step_size;?>);
            }
        }
    });
</script>


	<div class="numerical-container">
	    <div id="numerical-<?php echo $rand;?>" class="notinview">
	        <div class="value">0</div>
	    </div>
	    <div class="numerical-content"><?php if(!empty($instance['text'])) echo esc_html($instance['text']) ; ?></div>
	</div>
</div>
