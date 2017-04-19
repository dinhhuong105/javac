<?php
/*
Template Name: ライター一覧
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-author-list-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-author-list-pc'); ?>
<?php endif; ?>
