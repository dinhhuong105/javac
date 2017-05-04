<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('recipe-sp'); ?>
<?php else : ?>
	<?php get_template_part('recipe-pc'); ?>
<?php endif; ?>
