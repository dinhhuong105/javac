<?php
/*
Plugin Name: Heatmap UserHeat
Plugin URI: http://userheat.com
Description: heatmap analytics tool quick install
Version: 1.1.5
Author: User Local Inc
Author URI: http://www.userlocal.jp/
License: 
License URI: 
*/

/*
Copyright 2015 YusukeHarada (email : harada+wp@userlocal.jp)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class UserHeat{
    /**
     * コンストラクタ
     * 各アクションを設定する
     */
    public function __construct(){
        error_reporting(0);

        add_action('admin_init', array($this, 'i18n'));
        add_action('admin_menu', array($this,'addPage'));
        add_action('wp_footer', array($this, 'pushTag'));
    }

    /**
     * ページにタグを挿入する
     */
    public function pushTag(){
        $groupid = @get_option('uh_groupid');

        // groupidが設定されていないときは出力しない
        if(empty($groupid)){
            return ;
        }

        $tag = <<< EOF
<!-- User Heat Tag -->
<script type="text/javascript">
(function(add, cla){window['UserHeatTag']=cla;window[cla]=window[cla]||function(){(window[cla].q=window[cla].q||[]).push(arguments)},window[cla].l=1*new Date();var ul=document.createElement('script');var tag = document.getElementsByTagName('script')[0];ul.async=1;ul.src=add;tag.parentNode.insertBefore(ul,tag);})('//uh.nakanohito.jp/uhj2/uh.js', '_uhtracker');_uhtracker({id:'${groupid}'});
</script>
<!-- End User Heat Tag -->
EOF;
        echo $tag;
    }

    /**
     * 管理メニューにUserHeatの設定ページを追加する
     */
    public function addPage(){
        add_menu_page(__('UserHeat', 'userheat'), __('UserHeat', 'userheat'),  'level_8', __FILE__, array($this,'settingPage'), '', 26);
    }

    /**
     * 多言語化を有効にする
     */
    public function i18n(){
        load_plugin_textdomain( 'userheat' ) or load_plugin_textdomain( 'userheat', false, 'userheat/languages');
    }

    /**
     * 設定ページ
     */
    public function settingPage(){
        $pluginDir = plugins_url('userheat');
        $pluginName = 'userheat';

        // 言語ごとのサイトドメインの設定
        if('ja' === get_locale()){
            $siteDomain = 'userheat.com';
        }else{
            $siteDomain = 'en.userheat.com';
        }

        // CSSとJSの読み込み
        wp_enqueue_style('uh-css-bootstrap', "${pluginDir}/css/bootstrap.min.css");
        wp_enqueue_style('uh-css-site', "${pluginDir}/css/site.css");
        wp_enqueue_style('uh-css-admin', "${pluginDir}/css/admin.css");
        wp_enqueue_script('uh-js-site', "${pluginDir}/js/site.min.js");


        global $wpdb;

        if(isset($_POST['groupid'])){
            // フォームから値が送信している場合は、groupidをDBに登録
            update_option('uh_groupid', $_POST['groupid']);
            $groupid = $_POST['groupid'];
            $message = __('complete your ID', $pluginName);
        }else{
            // それ以外の場合はDBからgroupidを取ってくる
            $groupid = get_option('uh_groupid');
        }

        require(plugin_dir_path(__FILE__).'/admin.php');
    }
}

$UserHeat = new UserHeat();

