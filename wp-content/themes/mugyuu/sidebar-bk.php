
<div class="sideArea">
    <section class="sideCatArea">
        <h1 class="heading">
            <span>C</span><span>A</span><span>T</span><span>E</span><span>G</span><span>O</span><span>R</span><span>Y</span>
        </h1>
        <?php
            $args = array(
                'post_type' => 'post',
                'meta_key' => '_myplg_toppage',
                'meta_value' => 'on',
            );
            $topPosts = get_posts($args);
            $transformed_cats = [];
            // foreach ($topPosts as $topPost) {
            //     $cats = get_the_category($topPost->ID);
            //     usort($cats , '_usort_terms_by_ID');
            //     $transformed_cats = array_merge_recursive($transformed_cats, category_transform($cats));
            // }
                // category_transform($topPosts);
        ?>
        <?php
            //var_dump($topPosts);
        ?>
        <?php transformed_category_view($transformed_cats, 1); ?>

        <?php function transformed_category_view($cats, $level){ ?>
            <?php $l = $level; ?>
            <?php foreach ($cats as $key => $cat) { ?>
                <?php if($key === 'こどものこと') { ?>
                    <section class="sideCat sideChildCat">
                <?php } elseif($key === 'ママのこと') { ?>
                    <section class="sideCat sideMamaCat">
                <?php } elseif($l === 3) { ?>
                    <li><a href="<?php echo home_url('/'); ?>">
                <?php }else{ ?>
                    <li>
                <?php } ?>
                <?php //var_dump($cat);?>
                    <?php if(is_array($cat)) {?>
                        <?php if($l === 1) {?>
                            <h2 class="bigCat"><?php echo $l.':'.$key; ?></h2>
                            <ul class="catList">
                        <?php }else{ ?>
                            <h3><?php echo $l.':'.$key; ?></h3>
                            <ul class="grandsonCatList">
                        <?php }?>
                            <?php transformed_category_view($cat, $l + 1);?>
                        </ul>
            		<?php } else {?>
                        <?php echo $l.':'.$cat; ?>
            		<?php } ?>

                <?php if($key === 'こどものこと' || $key === 'ママのこと') { ?>
                    </section>
                <?php } elseif($l === 3) { ?>
                    </a></li>
                <?php } else { ?>
                    </li>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <section class="sideCat sideAgeCat">
            <h2 class="bigCat">年齢のこと<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <li>
                    <a href="<?php echo home_url('/'); ?>category/age/0yearold">
                        0歳
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/'); ?>category/age/1-3yearold">
                        1歳〜3歳
                    </a>
                </li>
                <li>
                    <a href="<?php echo home_url('/'); ?>category/age/4-6yearold">
                        4歳〜6歳
                    </a>
                </li>
            </ul>
        </section>
        <section class="sideCat sideMovieCat">
            <h2 class="bigCat">MUGYUU!動画<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <li>
                    <h3>レシピ</h3>
                    <ul class="grandsonCatList">
                        <?php
                            $args = array(
                                'order' => 'ASC',
                                'hide_empty' => 1,
                                'child_of' => 41,
                            );
                            $cats = get_terms('movingimage_cat' ,$args);
                            usort( $cats , '_usort_terms_by_ID');
                             foreach($cats as $cat):
                        ?>
                            <li>
                                <a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name;?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>
                    <h3>節約</h3>
                    <ul class="grandsonCatList">
                        <?php
                            $args = array(
                                'order' => 'ASC',
                                'hide_empty' => 1,
                                'child_of' => 68,
                            );
                            $cats = get_terms('movingimage_cat' ,$args);
                            usort( $cats , '_usort_terms_by_ID');
                             foreach($cats as $cat):
                        ?>
                            <li>
                                <a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name;?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
                <li>
                    <h3>マッサージ</h3>
                    <ul class="grandsonCatList">
                        <?php
                            $args = array(
                                'order' => 'ASC',
                                'hide_empty' => 1,
                                'child_of' => 65,
                            );
                            $cats = get_terms('movingimage_cat' ,$args);
                            usort( $cats , '_usort_terms_by_ID');
                             foreach($cats as $cat):
                        ?>
                            <li>
                                <a href="<?php echo get_category_link($cat->term_id); ?>"><?php echo $cat->name;?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </section>
        <!-- <section class="sideCat sideQaCat">
            <h2><a href="<?php //echo home_url('/'); ?>questionary/public/">質問掲示板</a></h2>
        </section> -->
        <section class="sideCat sideItemCat">
            <h2><a href="<?php echo home_url('/'); ?>item-search">商品を探す</a></h2>
        </section>
    </section>

    <?php if(!is_home() && !is_page( array('ranking') ) ) {
        echo get_template_part('side-ranking');
    }
    ?>
	<?php if(!is_page( array('author-list') ) ) {
		echo get_template_part('side-author');
	}
	?>
</div>
