<footer>
    <section class="aboutArea">
        <div class="left">
            <h2>ABOUT US</h2>
            <ul class="aboutList">
                <li><a href="<?php echo home_url('/'); ?>about-us">MUGYUU!について</a></li>
                <li><a href="<?php echo home_url('/'); ?>company">運営会社</a></li>
                <li><a href="<?php echo home_url('/'); ?>privacy-policy">プライバシーポリシー</a></li>
                <li><a href="<?php echo home_url('/'); ?>disclaimer">免責事項・知的財産権</a></li>
                <li><a href="<?php echo home_url('/'); ?>contact">お問い合わせ</a></li>
                <!-- <li><a href="<?php //echo home_url('/'); ?>writer-recruit">求人募集</a></li> -->
            </ul>
            <div class="otherArea">
                <div class="fbArea">
                    <div class="fb-page" data-href="https://www.facebook.com/mugyuuuu/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/mugyuuuu/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/mugyuuuu/">Mugyuu</a></blockquote></div>
                </div>
                <div class="bnrArea">
                    <div class="bnr">
                        <a href="<?php echo home_url('/'); ?>author"><img src="<?php echo bloginfo('template_directory'); ?>/images/bnr.png" alt="ライター募集" width="300" height="100"></a>
                    </div>
                    <!-- <div class="bnr">
                        <a href="<?php //echo home_url('/'); ?>questionary/public/"><img src="<?php echo bloginfo('template_directory'); ?>/images/bnrQa.png" alt="質問掲示板" width="300" height="100"></a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="snsArea">
            <div class="fb">
                <a href="https://www.facebook.com/mugyuuuu/">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                </a>
            </div>
            <div class="inst">
                <a href="https://www.instagram.com/mugyuu1/">
                    <i class="fa fa-instagram" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </section>
    <p class="copy"><small>&copy;2016 MUGYUU!</small></p>
    <div id="page-top">
        <a href="/">
            <img src="<?php echo bloginfo('template_directory'); ?>/images/balloon.png" alt="TOPへ戻る" width="48" height="132">
        </a>
    </div>
</footer>

<!-- search -->
<script>
    $('.searchArea input').focus(function() {
        $(this).toggleClass('focus');
    }).blur(function(){
        $(this).toggleClass('focus');
  });
</script>

<!-- slider -->
<script>
    $('.slider').slick({
        accessibility: true, //左右ボタンで画像の切り替え
        autoplay: true, //自動再生
        autoplaySpeed: 3000, // 自動再生や左右の矢印でスライドするスピード
        speed: 400, // 自動再生や左右の矢印でスライドするスピード
        pauseOnHover: false, // 自動再生時にスライドのエリアにマウスオンで一時停止するかどうか
        cssEase: 'ease',// 切り替えのアニメーション。ease,linear,ease-in,ease-out,ease-in-out
        dots: true, // 画像下にページ送りを表示
        dotsClass: 'dot-class',　//ドットのclass名をつける
        draggable: true,　// ドラッグができるかどうか
        fade: false,　// 切り替え時のフェードイン設定。trueでon
        arrows: false,　// 左右の次へ、前へボタンを表示するかどうか
        infinite: true,  // 無限スクロールにするかどうか。最後の画像の次は最初の画像が表示される。
        initialSlide: 0, // 最初のスライダーの位置
        lazyLoad: 'ondemand', // 画像の遅延表示。‘ondemand’or'progressive'
        pauseOnHover: false, // スライドのエリアにマウスオーバーしている間、自動再生を止めるかどうか。
        slidesToShow: 1, // スライドのエリアに画像がいくつ表示されるかを指定
        slidesToScroll: 1, // 一度にスライドする数
        swipe: true, // タッチスワイプに対応するかどうか
        touchMove: true, //タッチでスライドの有/無
        vertical: false,// 縦方向へのスライド
        centerMode: true, // 表示中の画像を中央へ
        centerPadding: '0',// 中央のpadding
    });
</script>

<!-- tab -->
<script>
    $('.tabMenuList li').on("click", function() {
        $(this).siblings().removeClass('active');
        $(this).removeClass('active');
        $(this).addClass('active');
        var tab_content = $(this).attr('data-tab-content');
        $(this).parents('.tabs').find('.tabContent').removeClass('tabSelected');
        $('#' + tab_content).addClass('tabSelected');
        return false;
    });
</script>

<!-- sidetab -->
<script>
    $('.tabMenuList li').on("click", function() {
        $(this).siblings().removeClass('active');
        $(this).removeClass('active');
        $(this).addClass('active');
        var tab_content = $(this).attr('data-tab-content');
        $(this).parents('.tabs').find('.tabContent').removeClass('tabSelected');
        $('#' + tab_content).addClass('tabSelected');
        return false;
    });
</script>

<!-- sidecat -->
<script>
    $('.bigCat').on('click', function() {
        $(this).next().slideToggle();
        $(this).toggleClass('active');
    });
    $('.catList li h3').on('click', function() {
        $(this).parents('.catList li').find('.grandsonCatList').slideToggle();
        $(this).parents('.catList li').toggleClass('active');
    });
    // $('.catList li').on('click', function() {
    //     $(this).children().slideToggle();
    //     $(this).toggleClass('active');
    // });
</script>

<!-- topcat -->
<script>
    var catName = null
    $('.catIcon').mouseover( function() {
        catName = $(this).attr("data-catName");

        $('.catIcon').removeClass('active');
        $(this).addClass('active');

        $('.catList').removeClass('active');
        $('#' + catName).addClass('active');

        $('.catContent').removeClass('cat-child cat-mama cat-age cat-recipe cat-movie');
        $('.catContent').addClass(catName);

        var catContentHeight = $('#' + catName).outerHeight(true);
        $('.catContent').css({height: catContentHeight + 'px'});

        $('.catContent').removeClass('catLeave');
    });
    $('.topCatWrap').mouseleave(function() {
        $('.catIcon').removeClass('active');
        $('.catContent').removeClass('cat-child cat-mama cat-age cat-recipe cat-movie');
        $('.catContent').addClass(catName);
        $('.catList').removeClass('active');
        $('.catContent').css({height: 0 });
        $('.catContent').addClass('catLeave');
    });
</script>

<!-- SCROLL TOP -->
<script>
    var topBtn = $('#page-top');
    topBtn.hide();
    //スクロールが100に達したらボタン表示
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
    //スクロールしてトップ
    topBtn.click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 500);
        return false;
    });
</script>

<!-- 口コミ評価 -->
    <script type="text/javascript">
        $(function() {
            $.fn.raty.defaults.path = "<?php echo get_template_directory_uri(); ?>/images";
            $('#default').raty({
                number: 5,
                score : 3
            });
        });
    </script>

<!-- ページ内リンク -->
    <script type="text/javascript">
        jQuery(function(){
            jQuery('a[href^=#]:not(.noscroll)').click(function(){
                var speed = 500;
                var href= jQuery(this).attr("href");
                var target = jQuery(href == "#" || href == "" ? 'html' : href);
                var position = target.offset().top;
                jQuery("html, body").animate({scrollTop:position}, speed, "swing");
                return false;
            });
        });


    </script>
<!-- author single uri -->
<script>
	var uri = new Uri(location.href).parse();
	$('.postContent').each(function() {
		var tab = $(this).attr('id');
		var index = tab.split('-').pop();
		$(this).find('.pagination a').each(function() {
			var href = new Uri($(this).attr('href')).parse();
			var query = href['query'];
			query['tab'] = index;
			$(this).attr('href', href['without_query'] + '?' + Uri.buildQuery(query));
		});
	});
</script>

<!-- author single tab -->
<script>
    $('.postTypeList li').on("click", function() {
        $(this).siblings().removeClass('active');
        $(this).removeClass('active');
        $(this).addClass('active');
        var tab_content = $(this).attr('data-tab-content');
        $(this).parents('.tabs').find('.postContent').removeClass('selected');
        $('#' + tab_content).addClass('selected');
        return false;
    });
</script>

    <?php wp_footer(); ?>
</body>
</html>
