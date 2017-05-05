<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('searchform-sp'); ?>
<?php else : ?>
	<?php get_template_part('searchform-pc'); ?>
<?php endif; ?>
