<?php
/*
Template Name: 特集記事一覧
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-special-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-special-pc'); ?>
<?php endif; ?>
