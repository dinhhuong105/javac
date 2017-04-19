<?php
/*
Template Name: ライター個人
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-author-single-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-author-single-pc'); ?>
<?php endif; ?>
