<!DOCTYPE html>
<html <?php language_attributes() ?>>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?php my_description(); ?>
        <?php get_template_part('ogp');?>
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" rel="stylesheet" type="text/css">
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery-3.1.0.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/slidebars.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/slick.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery.raty.js"></script>
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
    </head>
<?php if (wp_is_mobile()) :?>
    <body>
    <?php else: ?>
    <body class="pc">
<?php endif; ?>
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
                    <section class="catArea mamaArea">
                        <h2 class="bigCat"><span class="icon icon-mama"></span>ママのこと</h2>
                        <ul class="catList">
                            <li>
                                該当の記事がありません。
                            </li>
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
                    <section class="catArea movieArea">
                        <h2 class="bigCat"><span class="icon icon-play"></span>MUGYUU!動画</h2>
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
                    <!-- <section class="catArea qaArea">
                        <h2><a href="<?php /*echo home_url('/');*/ ?>questionary/"><i class="icon fa fa-pencil-square-o" aria-hidden="true"></i>質問掲示板</a></h2>
                    </section> -->
                    <section class="catArea itemArea">
                        <h2><a href="<?php echo home_url('/'); ?>item-search"><i class="icon fa fa-shopping-cart" aria-hidden="true"></i>商品を探す</a></h2>
                    </section>
                    <section class="catArea mugyuuArea">
                        <h2><a href="<?php echo home_url('/'); ?>about-us"><span class="icon icon-mugyuu"></span>MUGYUU!について</a></h2>
                    </section>
                    <section class="catArea infoArea">
                        <h2><a href="<?php echo home_url('/'); ?>contact"><span class="icon icon-bubbles2"></span>お問い合わせ</a></h2>
                    </section>
                    <section class="catArea recruitArea">
                        <h2><a href="<?php echo home_url('/'); ?>writer-recruit"><span class="icon icon-important_devices"></span>求人募集</a></h2>
                    </section>
                    <ul class="shareList">
                        <li class="fd"><a href="http://cloud.feedly.com/#subscription%2Ffeed%2F<?php rawurlencode( bloginfo('atom_url') ); ?>" target="_blank"><span class="icon icon-feedly"></span>feedly</a></li>
                        <li class="rss"><a href="<?php bloginfo('atom_url'); ?>" target="_blank"><i class="icon fa fa-rss" aria-hidden="true"></i>rss</a></li>
                    </ul>
                </div>
            </nav>
        </header>
