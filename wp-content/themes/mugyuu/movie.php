<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('movie-sp'); ?>
<?php else : ?>
	<?php get_template_part('movie-pc'); ?>
<?php endif; ?>
