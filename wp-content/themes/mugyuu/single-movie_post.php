<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('single-movie_post-sp'); ?>
<?php else : ?>
	<?php get_template_part('single-movie_post-pc'); ?>
<?php endif; ?>
