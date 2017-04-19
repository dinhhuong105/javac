<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('single-thread_post-sp'); ?>
<?php else : ?>
	<?php get_template_part('single-thread_post-pc'); ?>
<?php endif; ?>
