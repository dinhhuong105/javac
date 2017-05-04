<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('index-sp'); ?>
<?php else : ?>
	<?php get_template_part('index-pc'); ?>
<?php endif; ?>
