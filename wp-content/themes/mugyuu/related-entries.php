<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('related-entries-sp'); ?>
<?php else : ?>
	<?php get_template_part('related-entries-pc'); ?>
<?php endif; ?>
