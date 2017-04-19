
<div class="sideArea">
    <section class="sideCatArea">
        <h1 class="heading">
            <span>C</span><span>A</span><span>T</span><span>E</span><span>G</span><span>O</span><span>R</span><span>Y</span>
        </h1>
        <section class="sideCat sideChildCat">
            <h2 class="bigCat">こどものこと<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <li>
                    教育
                    <ul class="grandsonCatList">
                        <li><a href="<?php echo home_url('/'); ?>kodomo-yomikikase">読み聞かせ</a></li>
                    </ul>
                </li>
                <li>
                    肌
                    <ul class="grandsonCatList">
                        <li><a href="<?php echo home_url('/'); ?>akachan-asemo">あせも</a></li>
                    </ul>
                </li>
                <li>
                    育児
                    <ul class="grandsonCatList">
                        <li><a href="<?php echo home_url('/'); ?>akachan-haihai">はいはい</a></li>
                    </ul>
                </li>
            </ul>
        </section>
        <section class="sideCat sideMamaCat">
            <h2 class="bigCat">ママのこと<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <li>
                    病気
                    <ul class="grandsonCatList">
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">便秘</a></li>
                    </ul>
                </li>
                <li>
                    知育
                    <ul class="grandsonCatList">
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">国語</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">算数理科</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">社会</a></li>
                        <li><a href="<?php echo home_url('/'); ?>category/child/sick/benpi">家庭科体育</a></li>
                    </ul>
                </li>
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
        <section class="sideCat sideMovieCat">
            <h2 class="bigCat">MUGYUU!動画<i class="arrow fa fa-angle-down" aria-hidden="true"></i></h2>
            <ul class="catList">
                <li>
                   <a href="">
                       カテゴリ
                   </a>
                </li>
                <li>
                    <a href="">
                        カテゴリ
                    </a>
                </li>
            </ul>
        </section>
        <section class="sideCat sideQaCat">
            <h2><a href="<?php echo home_url('/'); ?>questionary/">質問掲示板</a></h2>
        </section>
        <section class="sideCat sideItemCat">
            <h2><a href="<?php echo home_url('/'); ?>item-search">商品を探す</a></h2>
        </section>
    </section>

    <?php if(!is_home() && !is_page( array('ranking') ) ) {
        echo get_template_part('side-ranking');
    }
    ?>
    <?php get_template_part('side-author'); ?>
</div>
