<?php get_header(); ?>
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
<div id="sb-site" class="wrapper single item">
    <?php breadcrumb(); ?>
    <article class="singleArea">
        <?php if (have_posts()) : ?>
        <?php while (have_posts()) : the_post(); ?>
        <?php
            $item_cat = get_the_terms($post->ID, 'item_cat');
            if( is_array($item_cat) ){
                usort( $item_cat , '_usort_terms_by_ID');
                $catName = current($item_cat)->name;
            }
			$thumbnail_id = get_post_thumbnail_id();
			$image = wp_get_attachment_image_src( $thumbnail_id, '600_thumbnail' );
        ?>
        <section class="detailArea">
           <div class="itemDataArea">
               <h1>
                   <?php the_title(); ?>
               </h1>
               <div class="starAll">
                   <div class="starArea">
                        <?php  $score = get_post_meta($post->ID, 'average_score', true);?>
                        <?php  for($i=0;$i<$score;$i++){ ?>
                           <i class="fa fa-star on" aria-hidden="true"></i>
                        <?php } ?>
                        <?php for($i=5;$score<$i;$i--){?>
                            <i class="fa fa-star" aria-hidden="true"></i>
                        <?php } ?>
                   </div>
                   <p class="number">
                       <?php comments_number('(0件)','(1件)','(%件)'); ?>
                   </p>
               </div>
			   <div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
                   <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
               </div>
               <p class="price">
                   ¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
               </p>
           </div>
            <div class="itemDescription">
                <h2>商品について</h2>
                    <?php the_content(); ?>
            </div>
            <div class="btnArea">
                <div class="official">
                    <a href="<?php echo( get_post_meta($post->ID, 'url', true)); ?>">公式ページ</a>
                </div>
                <div class="sendBtn">
                    <a href="#send">口コミを投稿する</a>
                </div>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p class="none">記事が見つかりませんでした。</p>
            <?php endif; ?>
        </section>
    </article>
    <?php comments_template(); ?>

<?php get_template_part('related-entries'); ?>
<?php get_footer(); ?>
