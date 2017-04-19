<?php
/*
Template Name: 動画一覧
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-movie-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-movie-pc'); ?>
<?php endif; ?>
