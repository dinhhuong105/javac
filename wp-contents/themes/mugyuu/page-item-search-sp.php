<?php get_header(); ?>

<script type="text/javascript">
$(function(){
    var ajaxurl = "<?php echo admin_url('admin-ajax.php')?>";
    var sort = "<?php echo !empty($_GET['sort'])?$_GET['sort']:''; ?>";

    if( sort ){
        $('option[value="'+ sort +'"]').prop('selected', true);
    }

    $("#itemCat").change(function(){
       $.ajax({
          type: 'GET',
          url: ajaxurl,
          data: {
              'action':'itemsearch',
              'term_id':$(this).val()
          },
          success: function( res ){
            $("#search-detail").html(res);
          }
       });
    });

    $("#resultsSort").change(function(){
        var param = location.href;
        var prefix =  param.match(/\?/)?"&":"?";

        param = param.replace(/&*sort=.*/, "");
        $(location).attr("href",param + prefix + "sort=" + $(this).val());
    });
});
</script>
<div id="sb-site" class="wrapper itemSearch">
    <?php breadcrumb(); ?>
    <section class="itemSearchArea">
        <h1>商品を探す</h1>
        <p class="detail">
            <?php
                $page_info = get_page_by_path('item-search');
                $page = get_post($page_info);
                echo $page->post_content;
            ?>
        </p>
        <h2>商品の絞り込み</h2>
        <form action="">
           <div class="catArea">
               <h3><i class="fa fa-star" aria-hidden="true"></i>商品のカテゴリ</h3>
               <div class="itemSelectArea">
                   <select id="itemCat" name="cat[]">
                       <option value="">選択してください</option>
                       <?php
                            $args = array(
                                'get' => 'all',//指定したタクソノミーの全情報を取得
                                'parent' => 0,
                                'posts_per_page' => 6,
                            );
                            $terms = get_terms( 'item_cat', $args );
                            $termChild = get_term_children($terms,'item_cat');
                            foreach($terms as $term){
                                echo '<option value="' . $term->term_id . '">' . $term -> name .'</option>';
                            }
                       ?>
                   </select>
               </div>
           </div>
            <div class="tagArea">
                <h3><i class="fa fa-tags" aria-hidden="true"></i>さらに絞り込む</h3>
                    <div id="search-detail"></div>
            </div>
            <button type="submit" name="action" value="send">絞り込む</button>
        </form>
    </section>
    <section class="searchResultsArea">
        <?php
            $disp_conditions = "";
            $args = array(
                'post_type' => 'item_post',
                'paged' => $paged,
                'posts_per_page' => 6,
            );
            $sort = !empty($_GET['sort'])?$_GET['sort']:'';
            switch($sort){
                case 'review':
                    $args += array('orderby' => 'meta_value_num', 'meta_key'=>'average_score', 'order' => 'DESC');
                break;

                case 'cheap':
                    $args += array('orderby' => 'meta_value_num', 'meta_key'=>'item', 'order' => 'ASC');
                break;

                case 'expensive':
                    $args +=array('orderby' => 'meta_value_num', 'meta_key'=>'item', 'order' => 'DESC');
                break;

                case 'new' :
                    $args +=array('orderby' => 'date','order' => 'DESC');
                break;

                default:
                    $args +=array('orderby' => 'date','order' => 'DESC');
                break;
            }

            if( !empty($_GET['cat']) && !empty(current($_GET['cat']))){
                $args += array(
                    'tax_query' => array(
                          array(
                              'taxonomy' => "item_cat",
                              'field' => 'term_id',
                              'terms' => $_GET['cat'],
                              'include_children' => false,
                              'operator' => 'AND'
                          ),
                      )
                );
                $terms = get_terms( 'item_cat', array(
                    'include' => $_GET['cat'],
                    'orderby' => 'term_id',
                    'order' => 'ASC',
                ) );
                foreach($terms as $term){
                   $disp_conditions .= '<p>' . $term->name . '</p>';
                }
            }
            $query = new WP_Query($args);
        ?>
        <div class="termsArea">
            <h1>
                <i class="fa fa-search" aria-hidden="true"></i>現在の検索条件
            </h1>
            <?php echo($disp_conditions); ?>
        </div>
        <div class="sortArea">
            <select id="resultsSort" name="itemSort" class="sort">
                <option value="new">新着順</option>
                <option value="review">レビューの評価順</option>
                <option value="cheap">価格の安い順</option>
                <option value="expensive">価格の高い順</option>
            </select>
        </div>
        <ul class="itemList">
            <?php
                if ($query->have_posts()) :
                while($query->have_posts()) : $query->the_post(); ?>
				<?php
					$thumbnail_id = get_post_thumbnail_id();
					$image = wp_get_attachment_image_src( $thumbnail_id, 'medium' );
				?>
            <li>
                <a href="<?php the_permalink(); ?>">
					<div class="imgArea" style="background-image: url(<?php echo $image[0]; ?>);">
 					   <img src='data:image/gif;base64,R0lGODlhAQABAIAAAP//////zCH5BAEHAAAALAAAAAABAAEAAAICRAEAOw=='>
 				   </div>
                   <div class="starArea">
                    <?php  $score = get_post_meta($post->ID, 'average_score', true);?>
                    <?php  for($i=0;$i<$score;$i++){ ?>
                       <i class="fa fa-star on" aria-hidden="true"></i>
                    <?php } ?>
                    <?php for($i=5;$score<$i;$i--){?>
                        <i class="fa fa-star" aria-hidden="true"></i>
                    <?php } ?>
                    <p class="number"><?php comments_number('(0件)','(1件)','(%件)'); ?></p>
                   </div>
                   <h2><?php the_title(); ?></h2>
                   <p class="price">
                       ¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
                   </p>
               </a>
            </li>
            <?php endwhile; else: ?>
            <li class="none">該当する記事がありません。</li>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </ul>
        <?php
            if(function_exists("pagination")) {
                pagination($query->max_num_pages);
            }
        ?>
    </section>
    <?php get_footer(); ?>
