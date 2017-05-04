<?php
/*
Template Name: MUGYUU!について
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-about-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-about-pc'); ?>
<?php endif; ?>
