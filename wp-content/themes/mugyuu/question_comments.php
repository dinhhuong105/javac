<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('question_comments-sp'); ?>
<?php else : ?>
	<?php get_template_part('question_comments-pc'); ?>
<?php endif; ?>
