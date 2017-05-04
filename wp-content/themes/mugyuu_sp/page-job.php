<?php
/*
Template Name: ライター・編集者募集
*/
?>
       <?php get_header(); ?>
        <div id="sb-site" class="wrapper job">
            <?php breadcrumb(); ?>
<!--
            <ul class="breadcrumbList">
                <li>
                    <a href="/">
                        トップ
                    </a>
                </li>
                <li class="arrow">
                    <i class="fa fa-chevron-right arrowIcon"></i>
                </li>
                <li>
                    ライター・編集者募集
                </li>
            </ul>
-->
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
                                    <td>パート・アルバイト</td>
                                </tr>
                                <tr>
                                    <th>時給</th>
                                    <td>1,000円〜</td>
                                </tr>
                                <tr>
                                    <th>就業時間</th>
                                    <td>シフト制（土日祝日休み）</td>
                                </tr>
                                <tr>
                                    <th>勤務地</th>
                                    <td>川崎市中原区丸子通 2-682 新丸子センチュリープラザ21 201</td>
                                </tr>
                            </tbody>
                        </table>
                        <p>
                            ※お子様のいらっしゃるママさんなので勤務時間は柔軟に対応させて頂きます。<br>
                            週○回以上、何時～何時まで、この日はお休みを～などご提示頂いた状況に合わせて可能な限り調整させて頂く予定ですので、ライフスタイルに合わせた勤務が可能です。
                        </p>
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
                                    希望雇用形態<span>※</span><br>
                                    <select name="type">
                                        <option value="">選択してください</option>
                                        <option value="baito">アルバイト</option>
                                        <option value="part">パート</option>
                                    </select>
                                </label>

                            </li>
                            <li>

                                扶養の範囲内希望<span>※</span><br>
                                <label class="radio"><input id="support" type="radio" name="support" value="はい" checked>はい</label>
                                <label class="radio"><input type="radio" name="support" value="いいえ">いいえ</label>

                            </li>
                            <li>
                                <label class="select">
                                    1週間の勤務可能日数（目安）<span>※</span><br>
                                    <select name="day">
                                        <option value="">選択してください</option>
                                        <option value="one">1日〜2日</option>
                                        <option value="three">3日〜4日</option>
                                        <option value="four">4日〜5日</option>
                                    </select>
                                </label>
                            </li>
                            <li>
                                <label class="select">
                                    勤務可能な時間帯（目安）<span>※</span><br>
                                    <select name="time">
                                        <option value="">選択してください</option>
                                        <option value="am">午前中</option>
                                        <option value="pm">午後</option>
                                        <option value="evening">夕方</option>
                                        <option value="full">いつでも</option>
                                    </select>
                                </label>
                            </li>
                            <li>
                                <label class="select">
                                    勤務開始可能日<span>※</span><br>
                                    <select name="start">
                                        <option value="">選択してください</option>
                                        <option value="soon">すぐにでも</option>
                                        <option value="oneMonth">１ヶ月以内</option>
                                        <option value="twoMonth">２ヶ月以内</option>
                                        <option value="other">その他</option>
                                    </select>
                                </label>
                            </li>
                            <li>
                                <label>
                                    お子様の人数と年齢<br>
                                    <textarea id="childData" name="childData" cols="30" rows="10"></textarea>
                                </label>
                            </li>
                            <li>
                                <label>
                                    ご自身のライティング等の経験があればそれがわかるもの<br>
                                    <textarea name="career" cols="30" rows="10"></textarea>
                                </label>
                            </li>
                            <li>
                                <label>
                                    その他、ご不明な点や質問等<br>
                                    <textarea name="other" cols="30" rows="10"></textarea>
                                </label>
                            </li>
                            <li>
                                <p><a href="">プライバシーポリシー</a>を一読のうえ、下記のボタンを押してください。</p>
                                <button type="submit" name="action" value="send">応募する</button>
                            </li>
                        </ul>
                    </form>
-->
                </section>
            </section>
            <?php get_footer(); ?>