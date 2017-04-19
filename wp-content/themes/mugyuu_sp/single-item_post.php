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
               <div class="imgArea">
                   <?php the_post_thumbnail(); ?>
               </div>
               <p class="price">
                   ¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
               </p>
           </div>
            <div class="itemDescription">
                <h2>商品について</h2>
                    <?php the_content(); ?>
            </div>
            <div class="official">
                <a href="<?php echo( get_post_meta($post->ID, 'url', true)); ?>">公式ページ</a>
            </div>
            <?php endwhile; ?>
            <?php else : ?>
            <p class="none">記事が見つかりませんでした。</p>
            <?php endif; ?>
        </section>
    </article>
    <?php comments_template(); ?>

<!--
    <section class="reviewsArea">
        <h1>口コミ</h1>
        <ul class="reviewList">
            <li>
                <div class="userData">
                    <div class="dataArea">
                        <p class="name">
                            <i class="fa fa-user" aria-hidden="true"></i>口コミ投稿者名前
                        </p>
                        <p class="date">
                            2016/00/00
                        </p>
                    </div>
                    <div class="starArea">
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="contentArea">
                    <p class="title">
                        口コミのタイトル
                    </p>
                    <p class="comment">
                        口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ
                    </p>
                </div>
            </li>
            <li>
                <div class="userData">
                    <div class="dataArea">
                        <p class="name">
                            <i class="fa fa-user" aria-hidden="true"></i>口コミ投稿者名前
                        </p>
                        <p class="date">
                            2016/00/00
                        </p>
                    </div>
                    <div class="starArea">
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star on" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="contentArea">
                    <p class="title">
                        口コミのタイトル
                    </p>
                    <p class="comment">
                        口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ口コミの本文だよ
                    </p>
                </div>
            </li>
        </ul>
-->
        <?php
//            if(function_exists("pagination")) {
//                pagination($query->max_num_pages);
//            }
        ?>
<!--    </section>   -->
<!--
    <section class="reviewPostingArea">
        <h1>口コミを投稿する</h1>
        <form action="">
            <label for="name">
               <p>ニックネーム</p>
                <input type="text" placeholder="ニックネームを入力してください" id="name">
            </label>
            <div class="userStar">
                <p>評価</p>
                <div id="default"></div>
            </div>
            <label for="comment" class="comment">
               <p>コメント</p>
                <textarea id="comment" name="comment" cols="30" rows="5" placeholder="コメントを入力してください"></textarea>
            </label>
            <button type="submit" name="action" value="send">口コミを投稿</button>
        </form>
    </section>
-->




<?php get_template_part('related-entries'); ?>
<?php get_footer(); ?>
