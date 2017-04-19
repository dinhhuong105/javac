<?php
/*
Template Name: お問い合わせ
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-contanct-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-contanct-pc'); ?>
<?php endif; ?>
