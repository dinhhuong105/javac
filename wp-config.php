<?php

/*
 * WordPressの実行ユーザと異なる場合にFTPを使用しないでプラグインのインストール等を行いたい場合
 */
define('FS_METHOD', 'direct');

/*
 * 投稿一覧等のパジネートリンクがバックエンド側のホストを参照してしまうため，/wp-admin/以下でのみHttp-Hostをフロントエンドのホスト名で上書きする．
 */
// if (isset($_SERVER['REQUEST_URI']) && substr($_SERVER['REQUEST_URI'],  0, strlen('/wp-admin/')) === '/wp-admin/') {
//     $_SERVER['HTTP_HOST'] = 'mugyuu.jp';
//     $_SERVER['SERVER_NAME'] = 'mugyuu.jp';
//     $_ENV['HTTP_HOST'] = 'mugyuu.jp';
//     $_ENV['SERVER_NAME'] = 'mugyuu.jp';
// }

/*
 * WordPress の基本設定.
 *
 * このファイルは、MySQL、テーブル接頭辞、秘密鍵、ABSPATH の設定を含みます。
 * より詳しい情報は {@link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 * wp-config.php の編集} を参照してください。MySQL の設定情報はホスティング先より入手できます。
 *
 * このファイルはインストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さず、このファイルを "wp-config.php" という名前でコピーして直接編集し値を
 * 入力してもかまいません。
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/* WordPress のためのデータベース名 */
define('DB_NAME', 'spc_labo_kaze');

/* MySQL データベースのユーザー名 */
define('DB_USER', 'root');

/* MySQL データベースのパスワード */
define('DB_PASSWORD', '');

/* MySQL のホスト名 */
define('DB_HOST', 'localhost');

/* データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/* データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'aYde_;ZjjUTTje8fKn2frP]w%`m1dI/0lJ,L`_QT(j5a:M9+YB/r@W_jGi{>lf?I');
define('SECURE_AUTH_KEY',  'bX=,{rt[~=Y5&Y)ZA]jLeK!0:cAqb6DHV*DE%T@qCb5t!H|t,GFpz%yU]k^z=.@s');
define('LOGGED_IN_KEY',    'G*,fGv-+6/h{s-c.8:c|)K`31Y+=]BMVL>@X32fEKE25-Y=*o pkg/:SNCQ_y/TL');
define('NONCE_KEY',        'Ak[NR[NyUt.Y;wgQ48T)>,n[kNPBMk,htU6{F87+;UOaUACL8}imc`Me%&qQaZ!k');
define('AUTH_SALT',        'M$oV4g(Le$D2&#Ay,H$z@QS]xE~.B>t4o>14c2O A)|^W}{_ Y6:8-O1[8rvb6w8');
define('SECURE_AUTH_SALT', '1_?J|rE6`5qhW<!s2tr3*uIN.NX`_.7VPxMSNw4[%KvMi7hU}X9qSJ{=iDn.4q#P');
define('LOGGED_IN_SALT',   '/DpR28T@YV_6/l!;|)-57?ASPY,B_+0!|>NTo[7B54.{:g/$_YFo647T^x,#d_Cs');
define('NONCE_SALT',       '`qtO|+EyUBEnz1Sx:)N/2WtPP;*9A$[5GfESJ&(/L[*9Nn[frI5F~w)BtC>jW~~u');

/**#@-*/

/*
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'wp_';

/*
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 */
define('WP_DEBUG', false);

//define('WP_ALLOW_MULTISITE', true);
//define('WP_CACHE', true);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/* Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__).'/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH.'wp-settings.php';
