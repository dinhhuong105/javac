<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('thread-sp'); ?>
<?php else : ?>
	<?php get_template_part('thread-pc'); ?>
<?php endif; ?>
