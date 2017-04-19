<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('taxonomy-movie_cat-sp'); ?>
<?php else : ?>
	<?php get_template_part('taxonomy-movie_cat-pc'); ?>
<?php endif; ?>
