<?php
/*
Template Name: 運営会社
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-company-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-company-pc'); ?>
<?php endif; ?>
