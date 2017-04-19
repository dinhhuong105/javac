<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('search-sp'); ?>
<?php else : ?>
	<?php get_template_part('search-pc'); ?>
<?php endif; ?>
