<?php if( cf_is_mobile()) : ?>
    <?php if( in_category( array('top') ) ) { ?>
	       <?php get_template_part('single-top-sp'); ?>
    <?php }else{ ?>
	       <?php get_template_part('single-sp'); ?>
    <?php } ?>
<?php else : ?>
    <?php if( in_category( array('top') ) ) { ?>
            <?php get_template_part('single-top-pc'); ?>
    <?php }else{ ?>
	          <?php get_template_part('single-pc'); ?>
    <?php } ?>
<?php endif; ?>
