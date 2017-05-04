<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('notice_comments-sp'); ?>
<?php else : ?>
	<?php get_template_part('notice_comments-pc'); ?>
<?php endif; ?>
