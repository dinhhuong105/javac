            <footer>
                <div class="bnr writerBnr">
                    <a href="<?php echo home_url('/'); ?>author"><img src="<?php echo bloginfo('template_directory'); ?>/images/bnr.png" width="300" height="100"></a>
                </div>
                <!-- <div class="bnr qaBnr">
                    <a href="<?php /*echo home_url('/');*/ ?>questionary/"><img src="<?php /*echo bloginfo('template_directory');*/ ?>/images/bnrQa.png" width="300" height="100"></a>
                </div> -->
                <div class="fb">
                    <p><i class="fa fa-facebook-official"></i>Facebook</p>
                    <div class="fb-page" data-href="https://www.facebook.com/mugyuuuu/" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/mugyuuuu/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/mugyuuuu/">Mugyuu</a></blockquote></div>
                </div>
                <ul class="infoList">
                    <li><a href="<?php echo home_url('/'); ?>about-us">MUGYUU!について</a></li>
                    <li><a href="<?php echo home_url('/'); ?>company">運営会社</a></li>
                    <li><a href="<?php echo home_url('/'); ?>privacy-policy">プライバシーポリシー</a></li>
                    <li><a href="<?php echo home_url('/'); ?>disclaimer">免責事項・知的財産権</a></li>
                    <li><a href="<?php echo home_url('/'); ?>contact">お問い合わせ</a></li>
                    <li><a href="<?php echo home_url('/'); ?>writer-recruit">求人募集</a></li>
                </ul>
                <div class="copy">
                    <small>
                        &copy;2016 MUGYUU!
                    </small>
                </div>
            </footer>
            <div id="page-top">
                <a href="#sb-site">
                    <img src="<?php echo bloginfo('template_directory'); ?>/images/top.png" alt="TOPへ戻る" width="30" height="83">
                </a>
            </div>
        </div>


        <!-- menu -->
        <script>
            $(document).ready(function() {
                $.slidebars();
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
                centerPadding: '60px',// 中央のpadding

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

        <!-- topcat sidecat -->
        <script>
            $('.bigCat').on('click', function() {
                $(this).next().slideToggle();
                $(this).toggleClass('active');
            });
            $('.catList li').on('click', function() {
                $(this).children().slideToggle();
                $(this).toggleClass('active');
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

        <?php wp_footer(); ?>
<!--pt-->
<script type="text/javascript">
	  window._pt_lt = new Date().getTime();
	  window._pt_sp_2 = [];
	  _pt_sp_2.push('setAccount,1f03f11e');
	  var _protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
	  (function() {
		var atag = document.createElement('script'); atag.type = 'text/javascript'; atag.async = true;
		atag.src = _protocol + 'js.ptengine.jp/pta.js';
		var stag = document.createElement('script'); stag.type = 'text/javascript'; stag.async = true;
		stag.src = _protocol + 'js.ptengine.jp/pts.js';
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(atag, s);s.parentNode.insertBefore(stag, s);
	  })();
</script>

    </body>
</html>
