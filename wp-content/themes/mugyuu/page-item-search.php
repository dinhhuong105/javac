<?php
/*
Template Name: 商品検索
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-item-search-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-item-search-pc'); ?>
<?php endif; ?>
