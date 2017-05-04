<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('category-sp'); ?>
<?php else : ?>
	<?php get_template_part('category-pc'); ?>
<?php endif; ?>
