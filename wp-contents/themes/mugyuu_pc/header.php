<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta name="format-detection" content="telephone=no">
        <?php my_description(); ?>
        <?php get_template_part('ogp');?>
        <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico">
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/style.min.css" rel="stylesheet" type="text/css">
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery-3.1.0.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/slick.min.js"></script>
        <script src="<?php bloginfo('template_directory'); ?>/js/jquery.raty.js"></script>
        <?php wp_head(); ?>
    </head>
    <body>
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
