<?php
/*
Template Name: 新着記事一覧
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-new-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-new-pc'); ?>
<?php endif; ?>
