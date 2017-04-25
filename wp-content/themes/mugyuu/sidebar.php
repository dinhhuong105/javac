
<div class="sideArea">
    <section>
    	<?php $spc_option = get_option('spc_options'); ?>
		<?php if( $spc_option['allowpost']) :?>
        	<div class="threadAdd"><a href="<?php echo home_url(); ?>/add-thread">＋トピックを投稿する</a></div>
        <?php endif; ?>
    </section>
    <section class="sideCatArea">
        <h2 class="heading">
            <span>C</span><span>A</span><span>T</span><span>E</span><span>G</span><span>O</span><span>R</span><span>Y</span>
        </h2>
        <section class="sideCat sideChildCat">
            <h2 class="bigCat">こどものこと<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>

            <ul class="catList">
                <?php
                    $args = array(
                        'post_type' => 'post',
                        'parent' => 2, //こどものこと
                    );
                    $cats = get_categories($args);
                ?>
                <?php foreach ($cats as $cat ) { ?>
                    <li>
                        <h3><?php echo $cat->name; ?></h3>
                        <?php
                            $child_cat_num = get_term_children($cat->cat_ID,'category');
                            $child_count = count($child_cat_num);
                            if($child_cat_num > 0) {
                         ?>
                            <ul class="grandsonCatList">
                                <?php
                                    $cat_children_args = array(
                                        'parent' => $cat->cat_ID,
                                        'post_type' => 'post',
                                        'hide_empty' => 1,
                                    );
                                    $cat_children = get_categories($cat_children_args);
                                    foreach ($cat_children as $cat_child) {
                                        $cat_link = get_category_link($cat_child->cat_ID);
                                ?>
                                    <li>
                                        <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </section>
        <section class="sideCat sideMamaCat">
            <h2 class="bigCat">ママのこと<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <?php
                    $args = array(
                        'post_type' => 'post',
                        'parent' => 3, //ママのこと
                    );
                    $cats = get_categories($args);
                ?>
                <?php foreach ($cats as $cat ) { ?>
                    <li>
                        <h3><?php echo $cat->name; ?></h3>
                        <?php
                            $child_cat_num = get_term_children($cat->cat_ID,'category');
                            $child_count = count($child_cat_num);
                            if($child_cat_num > 0) {
                         ?>
                            <ul class="grandsonCatList">
                                <?php
                                    $cat_children_args = array(
                                        'parent' => $cat->cat_ID,
                                        'post_type' => 'post',
                                        'hide_empty' => 1,
                                    );
                                    $cat_children = get_categories($cat_children_args);
                                    foreach ($cat_children as $cat_child) {
                                        $cat_link = get_category_link($cat_child->cat_ID);
                                ?>
                                    <li>
                                        <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </section>
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
        <section class="sideCat sideRecipeCat">
            <h2 class="bigCat">レシピ<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
            <?php
                $args = array(
                    'post_type' => 'movingimage_post',
                    'taxonomy' => 'movingimage_cat',
                    'parent' => 0,//レシピ
                    'hide_empty' => 1,
                );
                $cats = get_categories($args);
            ?>
            <?php foreach ($cats as $cat ) { ?>
                <li>
                    <h3><?php echo $cat->name;?></h3>
                    <?php
                        $child_cat_num = get_term_children($cat->cat_ID,'category');
                        $child_count = count($child_cat_num);
                        if($child_cat_num > 0) {
                     ?>
                    <ul class="grandsonCatList">
                        <?php
                            $cat_children_args = array(
                                'parent' => $cat->cat_ID,
                                'post_type' => 'movingimage_post',
                                'taxonomy' => 'movingimage_cat',
                            );
                            $cat_children = get_categories($cat_children_args);
                            foreach ($cat_children as $cat_child) {
                                $cat_link = get_category_link($cat_child->cat_ID);
                        ?>
                            <li>
                                <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                            </li>
                            <?php } ?>
                    </ul>
                <?php } ?>
                </li>
            <?php } ?>
            </ul>
        </section>
        <section class="sideCat sideMovieCat">
            <h2 class="bigCat">動画<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <?php
                    $args = array(
                        'post_type' => 'movie_post',
                        'taxonomy' => 'movie_cat',
                        'parent' => 0,
                        'hide_empty' => 1,
                    );
                    $cats = get_categories($args);
                ?>
                <?php foreach ($cats as $cat ) { ?>
                    <li>
                        <h3><?php echo $cat->name;?></h3>
                        <?php
                            $child_cat_num = get_term_children($cat->cat_ID,'category');
                            $child_count = count($child_cat_num);
                            if($child_cat_num > 0) {
                         ?>
                        <ul class="grandsonCatList">
                            <?php
                                $cat_children_args = array(
                                    'parent' => $cat->cat_ID,
                                    'post_type' => 'movie_post',
                                    'taxonomy' => 'movie_cat',
                                );
                                $cat_children = get_categories($cat_children_args);
                                foreach ($cat_children as $cat_child) {
                                    $cat_link = get_category_link($cat_child->cat_ID);
                            ?>
                                <li>
                                    <a href="<?php echo $cat_link; ?>"><?php echo $cat_child->name;?></a>
                                </li>
                                <?php } ?>
                        </ul>
                    <?php } ?>
                    </li>
                <?php } ?>
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
