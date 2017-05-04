<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('comments-sp'); ?>
<?php else : ?>
	<?php get_template_part('comments-pc'); ?>
<?php endif; ?>
