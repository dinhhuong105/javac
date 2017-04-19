<?php
/*
Template Name: お問い合わせ
*/
?>
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
<!--
                <form action="">
                    <ul>
                        <li>
                            <label>
                                お名前<span>※</span><br>
                                <input type="text" placeholder="お名前を入力してください">
                            </label>
                        </li>
                        <li>
                            <label>
                                メールアドレス<span>※</span><br>
                                <input type="email" placeholder="メールアドレスを入力してください">
                            </label>
                        </li>
                        <li>
                            <label class="select">
                                お問い合わせ内容<span>※</span><br>
                                <select name="type">
                                    <option value="">選択してください</option>
                                    <option value="site">サイトについて</option>
                                    <option value="request">記事のリクエスト</option>
                                    <option value="ad">広告、取材について</option>
                                    <option value="other">その他</option>
                                </select>
                            </label>
                        </li>
                        <li>
                            <label>
                                本文<br>
                                <textarea name="career" cols="30" rows="10"></textarea>
                            </label>
                        </li>
                        <li>
                            <p><a href="">プライバシーポリシー</a>を一読のうえ、下記のボタンを押してください。</p>
                            <button type="submit" name="action" value="send">送信する</button>
                        </li>
                    </ul>
                </form>
-->
            </section>
    <?php get_footer(); ?>