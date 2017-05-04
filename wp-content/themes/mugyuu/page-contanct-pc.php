<?php get_header(); ?>
<?php breadcrumb(); ?>
<div class="mainWrap about contact">
    <div class="mainArea">
        <section class="contactArea">
            <h1>お問い合わせ</h1>
            <p class="text">
                サイトについてお気付きの点や質問、リクエスト等ございましたら下記お問い合わせフォームよりお願いいたします。<br>
                <span>※ 記事についての個別の質問は差し控えておりますのでご了承ください。</span><br>
                <span>※ 内容によっては対応できない場合がございますのでご了承ください。</span>
            </p>
        </section>
        <div class="form">
           <div class="formArea">
               <?php echo do_shortcode('[contact-form-7 id="3501" title="お問い合わせpc"]'); ?>
           </div>
        </div>
    </div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
