<ol class="breadcrumb">
    <li><a href="http://<?php echo $siteDomain ?>/summaries?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><?php _e('Admin', $pluginName) ?></a></li>
    <li><a href="http://<?php echo $siteDomain ?>/stage/help?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><?php _e('Help', $pluginName) ?></a></li>
    <li><a href="http://<?php echo $siteDomain ?>/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><?php _e('Website', $pluginName) ?></a></li>
    <li><a href="http://www.userlocal.jp/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><?php _e('About us', $pluginName) ?></a></li>
</ol>

<div class="content">
    <div class="clearfix">
        <h1 class="pull-left"><img src="<?php echo plugins_url('userheat') ?>/img/logo.png" alt="UserHeatPlugin" width="220"></h1>
        <?php if(!empty($groupid)): ?>
            <a class="pull-right" href="http://<?php echo $siteDomain ?>/summaries" target="_blank"><button type="button" class="btn btn-warning"><?php _e('Check report', $pluginName) ?></button></a>
        <?php endif; ?>
    </div>

    <p><?php _e('You can check your site heatmap data by free', $pluginName) ?></p>

    <?php if(empty($groupid)): ?>
        <div class="alert alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php _e('Pelese, set your Site ID.', $pluginName) ?>
        </div>
    <?php endif; ?>

    <?php if(isset($message)): ?>
        <div class="alert alert-info alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php echo $message ?>
        </div>
    <?php endif; ?>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><?php _e('Installation', $pluginName) ?> </h2>
        </div>
        <div class="panel-body">
            <ul>
                <li><?php _e('1. Free registration from', $pluginName) ?> <span class="regist-link"><a href="http://<?php echo $siteDomain ?>/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><?php _e('here.', $pluginName) ?></a></span></li>
                <li><?php _e('2. Get site ID from `Create HTML Tag` page after log in', $pluginName) ?> </li>
                <li><?php _e('3. Register site ID in below form.', $pluginName) ?> </li>
                <li><?php _e('4. Complete your registration.', $pluginName) ?></li>
            </ul>
            <br>
            <?php _e('You can check the heatmap report when access data is accumulated.', $pluginName) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h2 class="panel-title"><?php _e('ID registration', $pluginName) ?></h2>
        </div>
        <div class="panel-body">
            <form method="POST" action="admin.php?page=userheat%2Fuserheat.php">
                <label><?php _e('Site ID') ?></label>
                <input type="text" name="groupid" value="<?php echo htmlspecialchars($groupid, ENT_QUOTES) ?>" class="form-control form-groupid" placeholder="<?php _e('Site ID') ?>" maxlength="10"><br>
                <p><?php _e('* If you set invalid ID, UserHeat does not work.', $pluginName) ?></p>
                <input type="submit" value="<?php _e('registration', $pluginName) ?>" class="btn btn-success form-submit">
                <a href="<?php _e('http://en.userheat.com/groups/show_id', $pluginName) ?>" target="_blank"><?php _e('Show your Site ID.', $pluginName) ?></a>
            </form>
        </div>
    </div>

    <?php if('ja' === get_locale()): ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2 class="panel-title">有料版のご案内</h2>
            </div>
            <div class="panel-body">
                <div class="col-sm-7">
                    <p>UserHeatを提供するユーザーローカルでは、より高機能な企業向けアクセス解析ツールUserInsightを提供しています。<br><br>
                    ヒートマップだけではなくアクセス状況の把握ができ、期間や条件に応じたヒートマップの絞り込み表示も可能です。
                    UserHeatで行っていない、技術サポートもございます。</p><br>

                    <a class="ui-link" href="http://ui.userlocal.jp/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin-pr1" target="_blank">サービス概要</a><br>
                    <a class="ui-link" href="http://ui.userlocal.jp/download/new/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin-pr2" target="_blank">資料ダウンロード</a><br>
                </div>
                <a class="col-sm-5" href="http://ui.userlocal.jp/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin-pr3" target="_blank"><img src="<?php echo plugins_url('userheat') ?>/img/uipr.png" width="350px"></a><br>
            </div>
        </div>
    <?php endif; ?>

    <div class="clearfix">
        <span class="pull-right">
            <a href="http://www.userlocal.jp/?ui_medium=service&ui_source=userheat&ui_campaign=wp-admin" target="_blank"><img src="<?php echo plugins_url('userheat') ?>/img/producedby.png" width="280"></a>
        </span>
    </div>
</div>
