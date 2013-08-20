<?php
/*** 
	TeamToy extenstion info block
	##name money data
	##folder_name money_data
	##author Ljr
	##email XXXX
	##reversion 1
	##desp money_data 显示收支。 
	##update_url http://tt2net.sinaapp.com/?c=plugin&a=update_package&name=todo_flow 
	##reverison_url http://tt2net.sinaapp.com/?c=plugin&a=latest_reversion&name=todo_flow 
	***/
$plugin_lang = array ();
$plugin_lang ['zh_cn'] = array ( // 标题
		'PL_MONEY_TITLE' => '显示收支' 
);

$plugin_lang ['zh_tw'] = array (
		'PL_MONEY_TITLE' => '显示收支' 
);

$plugin_lang ['us_en'] = array (
		'PL_MONEY_TITLE' => 'money_data' 
);

plugin_append_lang ( $plugin_lang );
add_action ( 'UI_NAVLIST_LAST', 'money_data' ); // 增加功能栏，设置图标
function money_data() {
	?><li
	<?php if( g('c') == 'plugin' && g('a') == 'money_data' ): ?>
	class="active" <?php endif; ?>><a
	href="?c=plugin&a=money_data" title="<?=__(PL_MONEY_TITLE)?>">
		<div>
			<img src="plugin/money_data/appicon.png" />
		</div>
</a></li>
<?php
}

// -------------------------------------------------------------------add action------------------------------------------------------------------------

// 主界面
add_action ( 'PLUGIN_MONEY_DATA', 'money_data_view' );
function money_data_view() {
	$data ['value'] = get_data ( "SELECT * FROM money_data m order by datatime" ); // 收入和支出汇总
	$data ['sum'] = get_data ( "select type,sum(money) as sum from money_data group by type;" ); // 收入和支出汇总

	return render ($data, 'web', 'plugin', 'money_data' );
}

// 添加收支记录
add_action ( 'PLUGIN_MONEY_ADD', 'money_add_view' );
function money_add_view() {
    try{
	run_sql ( "insert into money_data(who,datatime,money,type,content) values(" . $_POST['who']. ",'" . $_POST['datatime'] . "','" . $_POST['money'] 
	           . "','" . $_POST['type'] . "','" . $_POST['content'] . "')" );
    $data['return']="1";
	}
	catch(Exception $e){
	$data['return']="0";
	}
header("Location: ?c=plugin&a=money_data&success=".$data['return']);
}


// 删除收支记录
add_action ( 'PLUGIN_MONEY_DELETE', 'money_delete_view' );
function money_delete_view() {
    try{
	run_sql ( "delete from money_data where id= ". $_POST['id'] );
    $data['return']="1";
	}
	catch(Exception $e){
	$data['return']="0";
	}
header("Location: ?c=plugin&a=money_data&success=".$data['return']);
}


