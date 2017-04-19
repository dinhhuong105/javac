<?php
/*
Template Name: レシピ一覧
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-recipe-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-recipe-pc'); ?>
<?php endif; ?>
