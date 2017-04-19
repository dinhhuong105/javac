<?php
/*
Template Name: 商品検索
*/
?>
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

<?php breadcrumb(); ?>
<div class="mainWrap itemSearchList">
		<div class="mainArea">
			<h1 class="heading">
				商品を探す
			</h1>
			<p class="ttl">
				商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ商品検索の説明だよ
			</p>
			<section class="searchArea">
				<h2>商品の絞り込み</h2>
				<div class="searchWrap">
					<form action="">
						<dl class="catArea">
							<dt>
								<i class="fa fa-star" aria-hidden="true"></i>商品のカテゴリ
							</dt>
							<dd class="select">
								<select id="itemCat" name="cat[]">
									<option value="">選択してください</option>
									<?php
									   $args = array(
										   'get' => 'all',//指定したタクソノミーの全情報を取得
										   'parent' => 0,
									   );
									   $terms = get_terms( 'item_cat', $args );
									   $termChild = get_term_children($terms,'item_cat');
									   foreach($terms as $term){
										   echo '<option value="' . $term->term_id . '">' . $term -> name .'</option>';
									   }
								  　?>
								</select>
							</dd>
						</dl>
						<dl class="tagArea">
							<dt><i class="fa fa-tags" aria-hidden="true"></i>さらに絞り込む</dt>
							<dd id="search-detail"></dd>
							<!--<dd class="detail">
								<?php
				                    $args = array(
				                        'get' => 'all',//指定したタクソノミーの全情報を取得
				                    );
				                    $terms = get_terms( 'item_cat', $args );
									for($i = 0; $i < count($terms); $i++) {
										$parent = $terms[$i]->parent;
				                        if($parent !== 0) {
				                            echo '<label for="cat' . $i . '"><input type="checkbox" id="cat' . $i . '" >' . esc_html($terms[$i]->name) . '</label>';
				                        }
									}
				                ?>
							</dd>
							-->
						</dl>
						<button type="submit" name="action" value="send">絞り込む</button>
					</form>
				</div>
			</section>
			<section class="searchResultsArea">
			<?php
            $disp_conditions = ""; 
            $args = array(
                'post_type' => 'item_post',
                'paged' => $paged,
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
					<span class="babyIcon"></span>
					<div class="balloonArea">
						<h1>
							<i class="fa fa-search" aria-hidden="true"></i>現在の絞り込み条件
						</h1>
						<div class="cat">
						 <?php echo($disp_conditions); ?>
						</div>
					</div>
				</div>
				<div class="resultsSort">
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
						$image = wp_get_attachment_image_src( $thumbnail_id, 'pcList_thumbnail' );
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
							</div>
							<h2><?php the_title(); ?></h2>
							<p class="price">
								¥<?php echo( get_post_meta($post->ID, 'item', true)); ?>
							</p>
							<div class="overlay">
								<div class="ovWrap">
									<i class="fa fa-shopping-cart" aria-hidden="true"></i>
									<p>READ MORE</p>
									<div class="bd bdT"></div>
									<div class="bd bdB"></div>
									<div class="bd bdR"></div>
									<div class="bd bdL"></div>
								</div>
							</div>
						</a>
					</li>
				<?php endwhile; else: ?>
				<li class="none">該当する記事がありません。</li>
				<?php endif; ?>
				<?php wp_reset_postdata(); ?>
				</ul>
			</section>
			<?php if (function_exists("pagination")) {
                    pagination($query->max_num_pages);
                }
            ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
<?php get_footer(); ?>
