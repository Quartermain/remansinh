<div class="team-div text-center">
    <div class="team-image"><img alt="<?php echo esc_html($instance['name']) ?>" src="<?php echo esc_url($instance['image_url']) ?> " /></div>
    <div class="shadow"></div>
    <div class="team-details">
        <h4><?php echo esc_html($instance['name']) ?></h4>
        <span class="team-position"><?php echo esc_html($instance['cpost']) ?></span>
        <?php if (!empty($instance['shortintro'])) : ?>
        <p><?php echo wp_kses_post( $instance['shortintro'] ) ?></p>
        <?php endif; ?>
         <?php if (!empty($instance['facebook']) || !empty($instance['gplus']) || !empty($instance['github']) || !empty($instance['linkedin']) || !empty($instance['twitter']) ) : ?>
        <ul class="social-icomoon">
            <?php if (!empty($instance['facebook'])) : ?>
            <li><a href="<?php echo esc_url($instance['facebook']); ?>"><i class="fa fa-facebook-square"></i></a></li>
            <?php endif; ?><?php if (!empty($instance['twitter'])) : ?>
            <li><a href="<?php echo esc_url($instance['twitter']); ?>"><i class="fa fa-twitter-square"></i></a></li>
            <?php endif; ?><?php if (!empty($instance['gplus'])) : ?>
            <li><a href="<?php echo esc_url($instance['gplus']); ?>"><i class="fa fa-google-plus-square"></i></a></li>
            <?php endif; ?><?php if (!empty($instance['github'])) : ?>
            <li><a href="<?php echo esc_url($instance['github']); ?>"><i class="fa fa-github-square"></i></a></li>
            <?php endif; ?><?php if (!empty($instance['linkedin'])) : ?>
        <li><a href="<?php echo esc_url($instance['linkedin']); ?>"><i class="fa fa-linkedin-square"></i></a></li>
            <?php endif; ?>   
        </ul>
        <?php endif; ?>
    </div>
</div>


