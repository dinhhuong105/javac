<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('ranking-sp'); ?>
<?php else : ?>
	<?php get_template_part('ranking-pc'); ?>
<?php endif; ?>
