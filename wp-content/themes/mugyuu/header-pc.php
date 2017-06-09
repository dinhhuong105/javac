<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?php my_description(); ?>
        <?php get_template_part('ogp');?>
        <?php get_template_part('twitter-card');?>
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <!--<link rel="stylesheet" href="<?php //bloginfo('template_directory'); ?>/css/style_notice-pc.min.css" rel="stylesheet" type="text/css">-->
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style.min.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="<?php //bloginfo('template_directory'); ?>/css/style_pc.css" rel="stylesheet" type="text/css">-->
        <?php
            if (is_home()) {
            	$canonical_url = get_bloginfo('url');
            } elseif (is_category()) {
            	$canonical_url=get_category_link(get_query_var('cat'));
            } elseif(is_page('author-more')) {//ライター個人ページ一覧（author-more）
                $author_id = $_GET['uID'];
                $author_data = get_userdata($author_id);
                $canonical_url = get_permalink() . '?uID=' . $author_data->ID . '&uNAME=' . $author_data->display_name;
            }elseif (is_page() || is_single()) {
            	$canonical_url = get_permalink();
            }elseif(is_tax()) {
                $tax = get_queried_object();
                $canonical_url = home_url('/') . $tax->taxonomy . '/' . $tax->slug;
            }elseif(is_author()) { //authorテンプレ用
                $author_name = $_GET['uNAME'];
                $canonical_url = get_permalink();
                $user_data = get_userdata($author);
                $canonical_url =  home_url('/') . 'author/' . $user_data->user_nicename;
            }
            // if ( $paged > 2 || $page > 2) {
            if ( $paged > 2 ) {
            	$canonical_url = $canonical_url.'/page/'.max( $paged, $page ).'/';
            } elseif(is_404()) {
            	$canonical_url = get_bloginfo('url')."/404";
            }
        ?>
        <link rel="canonical" href="<?php echo $canonical_url; ?>">
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery-3.1.0.min.js"></script>
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
            <div class="headerWrap">
                <h1><a href="<?php echo home_url('/'); ?>"><img src="<?php echo bloginfo('template_directory'); ?>/images/logo.png" alt="MUGYUU!ロゴ" width="300" height="69"></a></h1>
                <div class="otherArea">
                    <?php get_search_form(); ?>
                    <ul class="snsList">
                        <li class="fb"><a href="https://www.facebook.com/mugyuuuu/" target="_blank"><i class="icon fa fa-facebook-square fb" aria-hidden="true"></i></a></li>
                        <li class="inst"><a href="https://www.instagram.com/mugyuu1/" target="_blank"><i class="icon fa fa-instagram inst" aria-hidden="true"></i></a></li>
                        <li class="fd"><a href="http://cloud.feedly.com/#subscription%2Ffeed%2F<?php rawurlencode( bloginfo('atom_url') ); ?>" target="_blank"><span class="icon icon-feedly fd"></span></a></li>
                        <li class="rss"><a href="<?php bloginfo('atom_url'); ?>" target="_blank"><i class="icon fa fa-rss rss" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </header>
