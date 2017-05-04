<?php get_header(); ?>
<?php breadcrumb(); ?>
<script type="text/javascript">
$(function(){
    $("form").submit(function(){
        var error="";

        if( !$("#author").val()){
            error = "<p>ニックネームが記入されていません</p>";
        }
        if( !$("#title").val() ){
            error += "<p>タイトルが記入されていません</p>";
        }
        if( !$("#comment").val() ){
            error += "<p>コメントが記入されていません</p>";
        }
        if(!error){
            return true;
        }else{
            $("#comment-error-area").html(error).attr('id', 'comment-error');
            return false;
        }
    });
});
</script>
<div class="mainWrap itemPost">
   <div class="mainArea">
        <section class="itemData">
            <?php if (have_posts()) :
                  while (have_posts()) : the_post(); ?>
            <?php
                 $item_cat = get_the_terms($post->ID, 'item_cat');
                 if( is_array($item_cat) ){
                     usort( $item_cat , '_usort_terms_by_ID');
                     $catName = current($item_cat)->name;
                 }
                 $thumbnail_id = get_post_thumbnail_id();
                 $image = wp_get_attachment_image_src( $thumbnail_id, '300_thumbnail' );
             ?>
            <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
            </div>
            <div class="itemDetail">
                <h1>
                    <?php the_title(); ?>
                </h1>
                <div class="starArea">
                    <i class="fa fa-star on" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <span class="number"><?php comments_number('(0件)','(1件)','(%件)'); ?></span>
                </div>
                <p class="price">
                    ¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
                </p>
                <h2>
                    この商品について
                </h2>
                <div class="itemText">
                    <?php the_content(); ?>
                </div>
                <div class="officialBtn">
                    <a href="<?php echo( get_post_meta($post->ID, 'url', true)); ?>" target="_blank">
                        公式ページ
                    </a>
                </div>
            </div>
        </section>
        <?php endwhile; ?>
        <?php else : ?>
        <p class="none">記事が見つかりませんでした。</p>
        <?php endif; ?>
        <?php comments_template(); ?>
        <?php get_template_part('related-entries'); ?>
    </div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
