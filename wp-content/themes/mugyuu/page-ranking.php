<?php
/*
Template Name: ランキング
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-ranking-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-ranking-pc'); ?>
<?php endif; ?>
