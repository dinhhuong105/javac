<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('taxonomy-item_cat-sp'); ?>
<?php else : ?>
	<?php get_template_part('taxonomy-item_cat-pc'); ?>
<?php endif; ?>
