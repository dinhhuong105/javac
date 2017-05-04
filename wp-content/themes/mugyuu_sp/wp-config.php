<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link http://wpdocs.sourceforge.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.sourceforge.jp/Codex:%E8%AB%87%E8%A9%B1%E5%AE%A4 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define('DB_NAME', 'mugyuu');

/** MySQL データベースのユーザー名 */
define('DB_USER', 'kazepro');

/** MySQL データベースのパスワード */
define('DB_PASSWORD', 'm+xX$70I3si~)5AL');

/** MySQL のホスト名 */
define('DB_HOST', 'production.db.kazeco.io');

/** データベースのテーブルを作成する際のデータベースの文字セット */
define('DB_CHARSET', 'utf8mb4');

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
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
define('AUTH_KEY',         'G0T}N4)EyM!]u:!&u,m%e@VoEa[GfrL!{y;I^1bt/xF*Dyt5+Hn.xGR|U2MH=>o%');
define('SECURE_AUTH_KEY',  'dK5?{lf;C4AEeE|<#=S8Jt)_`ZRY`y.=,oNL*T4J*W~Uq((|~,nA,N$l=&#w1<pR');
define('LOGGED_IN_KEY',    'UO7c4C+XN]0f+wk0G/ S[oO]op|>gJo^^KST&1W21u@>u-[[Rta 3WD{AABwfj{Y');
define('NONCE_KEY',        'Sl/meCtRd-WKe#3#Ja<ht14P{sH~X(MV_;_f5Y4p[}!.72@,,Gjy4_vWZi{}:3N~');
define('AUTH_SALT',        '@61N&3eej17_,mQx_%k)!:02+sC~y<+>~Ojj?R{PDqG^&x=O+wUmAiS:y5<}~_l,');
define('SECURE_AUTH_SALT', '3(W.NYSbZz*T4<!>g1l-q/t/dTLf#^#jEk Vs028?,9izagNao? pCrc})BO$j`R');
define('LOGGED_IN_SALT',   'g7w{n00CX@>&{A;.#_IqZv6d? 1??b5fftiAw@S,/]:^r@M~2k8G|@9m~ecj8Svu');
define('NONCE_SALT',       'f_Sr|gJfp%=D$vL5`?N:xD;YOMhMeW0aBM]VAa>uZ6See[k.y3Qbn/U*@%JpFs`$');

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix  = 'wp_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', true);

/* 編集が必要なのはここまでです ! WordPress でブログをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
