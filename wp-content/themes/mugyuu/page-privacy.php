<?php
/*
Template Name: プライバシーポリシー
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-privacy-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-privacy-pc'); ?>
<?php endif; ?>
