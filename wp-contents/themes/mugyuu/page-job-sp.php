<?php
/*
Template Name: ライター・編集者募集
*/
?>
       <?php get_header(); ?>
        <div id="sb-site" class="wrapper job">
            <?php breadcrumb(); ?>
            <section class="jobArea">
                <h1 class="ttl"><img src="<?php echo get_template_directory_uri(); ?>/images/bnrJob.png" alt="ライター・編集者募集"></h1>
                <p>
                    MUGYUU!では一緒にMUGYUU!を作って頂けるライター・編集者さんを募集しております！<br>
                    MUGYUU!自体が子育てや育児に関するサイトですので、子育てや育児経験をされたママさん、現在子育て真っ只中というママさんを募集しています！<br>
                    特にお子さんの子育てで苦労された経験があったり、これからお子さんの生まれるママさんたちへ為になる情報を発信したい！という想いでお仕事をして頂ける方大募集です＾＾<br>
                    ご自身の経験をそのまま是非サイトへ反映して下さい♪
                </p>
                <div class="snsArea">
                    <div class="web">
                        <a href="https://mugyuu.jp">
                            <i class="fa fa-desktop" aria-hidden="true"></i>https://mugyuu.jp
                        </a>
                    </div>
                    <div class="fb">
                        <a href="https://www.facebook.com/mugyuuuu/">
                            <i class="fa fa-facebook-square" aria-hidden="true"></i>https://www.facebook.com/mugyuuuu/
                        </a>
                    </div>
                    <div class="inst">
                        <a href="https://www.instagram.com/mugyuu1/">
                            <i class="fa fa-instagram" aria-hidden="true"></i>https://www.instagram.com/mugyuu1/
                        </a>
                    </div>
                </div>
                <div class="content">
                    <section>
                        <h1>主な業務内容</h1>
                        <ul>
                            <li>① MUGYUU!のライティング作業や編集作業・運営に関わる業務</li>
                            <li>② 広告コラムのライティング業務</li>
                        </ul>
                    </section>
                    <section>
                        <h1>条件面</h1>
                        <table>
                            <tbody>
                                <tr>
                                    <th>雇用形態</th>
                                    <td>業務委託</td>
                                </tr>
                                <tr>
                                    <th>報酬</th>
                                    <td>経験や能力、記事の内容によって応相談</td>
                                </tr>
                            </tbody>
                        </table>
                    </section>
                    <section>
                        <h1>優遇面</h1>
                        <ul>
                            <li>
                                ・外注サービスでライティング経験のある方優遇
                            </li>
                            <li>
                                ・長くお仕事に携われそうな方
                            </li>
                            <li>
                                ・過去の子育て経験から大変だった思いやもっとこうしておけば良かったなどがある方
                            </li>
                            <li>
                                ・過去にサイト運営やディレクションなどの経験をされた事のある方
                            </li>
                        </ul>
                    </section>
                </div>
                <section class="formArea">
                    <h1>応募フォーム</h1>
                    <p><span>※</span>は必須項目になります。</p>
                    <?php echo do_shortcode('[contact-form-7 id="899" title="求人の応募"]'); ?>
                </section>
            </section>
            <?php get_footer(); ?>
