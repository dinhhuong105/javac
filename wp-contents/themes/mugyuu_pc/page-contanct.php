<?php
/*
Template Name: お問い合わせ
*/
?>
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
			   <?php echo do_shortcode('[contact-form-7 id="578" title="お問い合わせpc"]') ; ?>
               <!-- <form action="">
                    <dl>
                        <dt>お名前<span>※</span></dt>
                        <dd><input type="text" placeholder="お名前を入力してください"></dd>
                    </dl>
                   <dl>
                       <dt>メールアドレス<span>※</span></dt>
                       <dd><input type="email" placeholder="メールアドレスを入力してください"></dd>
                   </dl>
                   <dl class="select">
                       <dt>お問い合わせ内容<span>※</span></dt>
                       <dd>
                           <select name="type">
                               <option value="">選択してください</option>
                               <option value="site">サイトについて</option>
                               <option value="request">記事のリクエスト</option>
                               <option value="ad">広告、取材について</option>
                               <option value="other">その他</option>
                           </select>
                       </dd>
                   </dl>
                   <dl>
                       <dt>本文<span>※</span></dt>
                       <dd><textarea name="career" cols="30" rows="10"></textarea></dd>
                   </dl>
                   <p><a href="">プライバシーポリシー</a>を一読のうえ、下記のボタンを押してください。</p>
                   <button type="submit" name="action" value="send">送信する</button>
               </form> -->
           </div>
        </div>
    </div>
	<?php get_sidebar(); ?>
</div>
<?php get_footer(); ?>
