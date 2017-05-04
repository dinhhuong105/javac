<?php
/*
Template Name: ライター・編集者募集
*/
?>
<?php if( cf_is_mobile()) : ?>
	<?php get_template_part('page-job-sp'); ?>
<?php else : ?>
	<?php get_template_part('page-job-pc'); ?>
<?php endif; ?>
