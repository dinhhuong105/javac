<?php
/*
Template Name: List NoticeBoard
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-notice-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-notice-pc'); ?>
<?php endif; ?>
