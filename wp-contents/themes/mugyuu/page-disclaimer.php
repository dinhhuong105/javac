<?php
/*
Template Name: 免責事項
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-disclaimer-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-disclaimer-pc'); ?>
<?php endif; ?>
