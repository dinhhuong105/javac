<?php get_header(); ?>
        <div id="sb-site" class="wrapper info contact">
            <?php breadcrumb(); ?>
            <section class="contactArea infoArea">
                <h1>お問い合わせ</h1>
                <p>
                    下記フォームにて必要事項をご記入の上、送信してください。
                </p>
            </section>
            <section class="formArea">
                <h1>お問い合わせフォーム</h1>
                <p><span>※</span>は必須項目になります。</p>
                <?php echo do_shortcode('[contact-form-7 id="140" title="お問い合わせ"]'); ?>
            </section>
    <?php get_footer(); ?>
