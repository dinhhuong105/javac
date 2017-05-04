<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('sns-sp'); ?>
<?php else : ?>
	<?php get_template_part('sns-pc'); ?>
<?php endif; ?>
