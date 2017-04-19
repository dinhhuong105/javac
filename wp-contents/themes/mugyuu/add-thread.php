<?php
/*
Template Name: Add Thread
*/
?>
<?php $spc_option = get_option('spc_options'); ?>
<?php if( $spc_option['allowpost']) :?>
    <?php if( cf_is_mobile()) : ?>
    	<?php get_template_part('add-thread-sp'); ?>
    <?php else : ?>
    	<?php get_template_part('add-thread-pc'); ?>
    <?php endif; ?>
<?php else : ?>
	<?php get_template_part('404'); ?>
<?php endif; ?>