<!DOCTYPE html>
<html <?php language_attributes() ?>>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?php my_description(); ?>
        <?php get_template_part('ogp');?>
        <?php get_template_part('twitter-card');?>
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<!--        <link rel="stylesheet" href="--><?php //bloginfo('template_directory'); ?><!--/css/style_sp.css" rel="stylesheet" type="text/css">-->
        <!--  <link rel="stylesheet" href="<?php //bloginfo('template_directory'); ?>/css/style_notice-sp.min.css" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style_sp.css" rel="stylesheet" type="text/css">-->
        <?php
            if (is_home()) {
            	$canonical_url = get_bloginfo('url');
            } elseif (is_category()) {
            	$canonical_url=get_category_link(get_query_var('cat'));
            } elseif(is_page('author-more')) {//ライター個人ページ一覧（author-more）
                $author_id = $_GET['uID'];
                $author_data = get_userdata($author_id);
                $canonical_url = get_permalink() . '?uID=' . $author_data->ID . '&uNAME=' . $author_data->display_name;
            } elseif (is_page() || is_single()) {
            	$canonical_url = get_permalink();
            } elseif(is_tax()) {
                $tax = get_queried_object();
                $canonical_url = home_url('/') . $tax->taxonomy . '/' . $tax->slug;
            } elseif(is_author()) { //authorテンプレ用
                $author_name = $_GET['uNAME'];
                $canonical_url = get_permalink();
                $user_data = get_userdata($author);
                $canonical_url =  home_url('/') . 'author/' . $user_data->user_nicename;
            }
            // if ( $paged >= 2 || $page >= 2) {
            if ( $paged > 2 ) {
                $canonical_url = $canonical_url.'/page/'.max( $paged, $page ).'/';
            } elseif(is_404()) {
            	$canonical_url = get_bloginfo('url')."/404";
            }
        ?>
        <link rel="canonical" href="<?php echo $canonical_url; ?>">
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery-3.1.0.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/slidebars.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/slick.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery.raty.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/uri.js"></script>
        <script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-79726825-1', 'auto');
          ga('send', 'pageview');

        </script>
        <meta name="google-site-verification" content="zF6hAqNsZAQMp8hjJoYzRniUck9SeERNt_R4MHYEsIw" />
        <?php wp_head(); ?>
		<!-- User Heat Tag -->
		<script type="text/javascript">
		(function(add, cla){window['UserHeatTag']=cla;window[cla]=window[cla]||function(){(window[cla].q=window[cla].q||[]).push(arguments)},window[cla].l=1*new Date();var ul=document.createElement('script');var tag = document.getElementsByTagName('script')[0];ul.async=1;ul.src=add;tag.parentNode.insertBefore(ul,tag);})('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');_uhtracker({id:'uhdHJCGCds'});
		</script>
		<!-- End User Heat Tag -->

        <!-- Begin Mieruca Embed Code -->
        <script type="text/javascript" id="mierucajs">
        window.__fid = window.__fid || [];__fid.push([113138971]);
        (function() {
        function mieruca(){if(typeof window.__fjsld != "undefined") return; window.__fjsld = 1; var fjs = document.createElement('script'); fjs.type = 'text/javascript'; fjs.async = true; fjs.id = "fjssync"; var timestamp = new Date;fjs.src = ('https:' == document.location.protocol ? 'https' : 'http') + '://hm.mieru-ca.com/service/js/mieruca-hm.js?v='+ timestamp.getTime(); var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(fjs, x); };
        setTimeout(mieruca, 500); document.readyState != "complete" ? (window.attachEvent ? window.attachEvent("onload", mieruca) : window.addEventListener("load", mieruca, false)) : mieruca();
        })();
        </script>
        <!-- End Mieruca Embed Code -->
    </head>
    <body>
        <!-- User Insight PCDF Code Start : mugyuu.jp -->
            <script type="text/javascript">
            var _uic = _uic ||{}; var _uih = _uih ||{};_uih['id'] = 52342;
            _uih['lg_id'] = '';
            _uih['fb_id'] = '';
            _uih['tw_id'] = '';
            _uih['uigr_1'] = ''; _uih['uigr_2'] = ''; _uih['uigr_3'] = ''; _uih['uigr_4'] = ''; _uih['uigr_5'] = '';
            _uih['uigr_6'] = ''; _uih['uigr_7'] = ''; _uih['uigr_8'] = ''; _uih['uigr_9'] = ''; _uih['uigr_10'] = '';

            /* DO NOT ALTER BELOW THIS LINE */
            /* WITH FIRST PARTY COOKIE */
            (function() {
            var bi = document.createElement('script');bi.type = 'text/javascript'; bi.async = true;
            bi.src = '//cs.nakanohito.jp/b3/bi.js';
            var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(bi, s);
            })();
            </script>
        <!-- User Insight PCDF Code End : mugyuu.jp -->
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
              js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.7";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
        <header>
            <div class="sb-slide">
                <div class="sb-toggle-left menuIcon"><i class="fa fa-bars" aria-hidden="true"></i></div>
                <h1><a href="<?php echo home_url('/'); ?>"><img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" alt="MUGYUU!ロゴ" width="175" height="40"></a></h1>
                <div class="sb-toggle-right shareIcon"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
            </div>
            <nav>
                <div class="sb-slidebar sb-right">
                    <ul>
                        <li><a href="https://www.facebook.com/mugyuuuu/" target="_blank"><i class="fa fa-facebook fb" aria-hidden="true"></i>Facebook</a></li>
<!--                        <li><a href="/" target="_blank"><i class="fa fa-twitter tw" aria-hidden="true"></i>Twitter</a></li>-->
                        <li><a href="https://www.instagram.com/mugyuu1/" target="_blank"><i class="fa fa-instagram inst" aria-hidden="true"></i>Instagram</a></li>
                    </ul>
                </div>
                <div class="sb-slidebar sb-left">
                    <?php get_search_form(); ?>
                    <section class="catArea childArea">
                        <h2 class="bigCat"><span class="icon icon-baby"></span>こどものこと</h2>
                        <ul class="catList">
                            <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'parent' => 2, //こどものこと
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat) { ?>
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
                    <section class="catArea mamaArea">
                        <h2 class="bigCat"><span class="icon icon-mama"></span>ママのこと</h2>
                        <ul class="catList">
                            <?php
                                $args = array(
                                    'post_type' => 'post',
                                    'parent' => 3, //ママのこと
                                    'hide_empty' => 1,
                                );
                                $cats = get_categories($args);
                            ?>
                            <?php foreach ($cats as $cat) { ?>
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
                    <section class="catArea ageArea">
                        <h2 class="bigCat"><i class="icon fa fa-heart-o" aria-hidden="true"></i>年齢のこと</h2>
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
                    <section class="catArea recipeArea">
                        <h2 class="bigCat"><span class="icon icon-recipe"></span>レシピ</h2>
                        <ul class="catList">
                            <?php
                                $args = array(
                                    'post_type' => 'movingimage_post',
                                    'taxonomy' => 'movingimage_cat',
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
                    <section class="catArea movieArea">
                        <h2 class="bigCat"><i class="icon fa fa-video-camera" aria-hidden="true"></i>MUGYUU!動画</h2>
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
                    <section class="catArea qaArea">
                        <h2><a href="<?php echo home_url('/'); ?>notice/"><i class="icon fa fa-pencil-square-o" aria-hidden="true"></i>質問掲示板</a></h2>
                    </section>
                    <section class="catArea itemArea">
                        <h2><a href="<?php echo home_url('/'); ?>item-search"><i class="icon fa fa-shopping-cart" aria-hidden="true"></i>商品を探す</a></h2>
                    </section>
                    <section class="catArea mugyuuArea">
                        <h2><a href="<?php echo home_url('/'); ?>about-us"><span class="icon icon-mugyuu"></span>MUGYUU!について</a></h2>
                    </section>
                    <section class="catArea infoArea">
                        <h2><a href="<?php echo home_url('/'); ?>contact"><i class="icon fa fa-comments" aria-hidden="true"></i>お問い合わせ</a></h2>
                    </section>
                    <!-- <section class="catArea recruitArea">
                        <h2><a href="<?php //echo home_url('/'); ?>writer-recruit"><span class="icon icon-important_devices"></span>求人募集</a></h2>
                    </section> -->
                    <ul class="shareList">
                        <li class="fd"><a href="http://cloud.feedly.com/#subscription%2Ffeed%2F<?php rawurlencode( bloginfo('atom_url') ); ?>" target="_blank"><span class="icon icon-feedly"></span>feedly</a></li>
                        <li class="rss"><a href="<?php bloginfo('atom_url'); ?>" target="_blank"><i class="icon fa fa-rss" aria-hidden="true"></i>rss</a></li>
                    </ul>
                </div>
            </nav>
        </header>
