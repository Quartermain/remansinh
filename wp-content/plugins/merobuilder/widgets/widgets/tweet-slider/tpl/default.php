<?php
global $elano_options;
?>
<?php if(isset($elano_options['twitter_username']) && $elano_options['twitter_username']!='') : ?>
<div class="icon-author">
	<div class="bird"><i class="fa fa-twitter"></i></div>
	<p class="twitter-author">Follow<a href="http://twitter.com/<?php echo $elano_options['twitter_username']; ?>" target="_blank"><b> @<?php echo $elano_options['twitter_username'];?></b></a></p>
	
</div>
<!-- Twitter Slider -->       
<div class="twitter-slider">              
	<div id="twitter-feed"></div>  
</div>
<?php endif; ?>