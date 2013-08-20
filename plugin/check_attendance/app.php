<?php
/*** 
	TeamToy extenstion info block
	##name check attendance
	##folder_name check_attendance
	##author Ljr
	##email XXXX
	##reversion 1
	##desp check_attendance 考勤的插件。 
	##update_url http://tt2net.sinaapp.com/?c=plugin&a=update_package&name=todo_flow 
	##reverison_url http://tt2net.sinaapp.com/?c=plugin&a=latest_reversion&name=todo_flow 
	***/
$plugin_lang = array ();
$plugin_lang ['zh_cn'] = array ( // 标题
		'PL_CHECK_TITLE' => '考勤' 
);

$plugin_lang ['zh_tw'] = array (
		'PL_CHECK_TITLE' => '考勤' 
);

$plugin_lang ['us_en'] = array (
		'PL_CHECK_TITLE' => 'check attendance' 
);

plugin_append_lang ( $plugin_lang );
add_action ( 'UI_NAVLIST_LAST', 'check_attendance' ); // 增加功能栏，设置图标
function check_attendance() {
	?><li
	<?php if( g('c') == 'plugin' && g('a') == 'check_attendance_new' ): ?>
	class="active" <?php endif; ?>><a
	href="?c=plugin&a=check_attendance_new" title="<?=__(PL_CHECK_TITLE)?>">
		<div>
			<img src="plugin/check_attendance/appicon.png" />
		</div>
</a></li>
<?php
}

// -------------------------------------------------------------------add action------------------------------------------------------------------------

// 主界面
add_action ( 'PLUGIN_CHECK_ATTENDANCE', 'check_attendance_view' );
function check_attendance_view() {
	$data ['time'] = get_data ( "SELECT distinct time_code FROM user_attendance_new ua order by time_code" ); // 获取数据库存在的月份数据
	
	if (isset ( $_GET ['time_code'] )) {
		$data ['time_code'] = $_GET ['time_code'];
		if (! is_numeric ( $data ['time_code'] ))
			return;
	} else
		$data ['time_code'] = $data ['time'] [count ( $data ['time'] ) - 1] ['time_code']; // 默认调用最后一张考勤表
	$data ['countData'] = getCountData ( $data ['time_code'] );
	return render ( $data, 'web', 'plugin', 'check_attendance' );
}



// 使一列成为正常假期
add_action ( 'PLUGIN_CHANGE_VACATION', 'change_vacation_view' );
function change_vacation_view() {
	if (isset ( $_GET ['day'] ) && isset ( $_GET ['time_code'] )) {
		run_sql ( "update user_attendance_new set d" . $_GET ['day'] . "=4.4 WHERE `time_code`='" . $_GET ['time_code'] . "'" );
		// changeOld();
		echo "修改成功";
	} else
		"修改失败";
}

// 使旧数据转换成新格式
add_action ( 'PLUGIN_CHANGE_NEW', 'change_new_view' );
function change_new_view() {
	$data = get_data ( "SELECT * FROM user_attendance ua where time_code<201307" );
	
	for($i = 0; $i < count ( $data ); $i ++) { // 转化成新规则
		$time = $data [$i] ['time_code'];
		run_sql ( "update user_attendance_new set `d1`= " . changeNew ( $data [$i] ['d1'], $time, 1 ) . ",`d2`= " . changeNew ( $data [$i] ['d2'], $time, 2 ) . ",`d3`= " . changeNew ( $data [$i] ['d3'], $time, 3 ) . ",`d4`= " . changeNew ( $data [$i] ['d4'], $time, 4 ) . ",`d5`= " . changeNew ( $data [$i] ['d5'], $time, 5 ) . ",`d6`= " . changeNew ( $data [$i] ['d6'], $time, 6 ) . ",`d7`= " . changeNew ( $data [$i] ['d7'], $time, 7 ) . ",`d8`= " . changeNew ( $data [$i] ['d8'], $time, 8 ) . ",`d9`= " . changeNew ( $data [$i] ['d9'], $time, 9 ) . ",`d10`= " . changeNew ( $data [$i] ['d10'], $time, 10 ) . ",`d11`= " . changeNew ( $data [$i] ['d11'], $time, 11 ) . ",`d12`= " . changeNew ( $data [$i] ['d12'], $time, 12 ) . ",`d13`= " . changeNew ( $data [$i] ['d13'], $time, 13 ) . ",`d14`= " . changeNew ( $data [$i] ['d14'], $time, 14 ) . ",`d15`= " . changeNew ( $data [$i] ['d15'], $time, 15 ) . ",`d16`= " . changeNew ( $data [$i] ['d16'], $time, 16 ) . ",`d17`= " . changeNew ( $data [$i] ['d17'], $time, 17 ) . ",`d18`= " . changeNew ( $data [$i] ['d18'], $time, 18 ) . ",`d19`= " . changeNew ( $data [$i] ['d19'], $time, 19 ) . ",`d20`= " . changeNew ( $data [$i] ['d20'], $time, 20 ) . ",`d21`= " . changeNew ( $data [$i] ['d21'], $time, 21 ) . ",`d22`= " . changeNew ( $data [$i] ['d22'], $time, 22 ) . ",`d23`= " . changeNew ( $data [$i] ['d23'], $time, 23 ) . ",`d24`= " . changeNew ( $data [$i] ['d24'], $time, 24 ) . ",`d25`= " . changeNew ( $data [$i] ['d25'], $time, 25 ) . ",`d26`= " . changeNew ( $data [$i] ['d26'], $time, 26 ) . ",`d27`= " . changeNew ( $data [$i] ['d27'], $time, 27 ) . ",`d28`= " . changeNew ( $data [$i] ['d28'], $time, 28 ) . ",`d29`= " . changeNew ( $data [$i] ['d29'], $time, 29 ) . ",`d30`= " . changeNew ( $data [$i] ['d30'], $time, 30 ) . ",`d31`= " . changeNew ( $data [$i] ['d31'], $time, 31 ) . " WHERE `uid`=" . $data [$i] ['uid'] . " and time_code='" . $data [$i] ['time_code'] . "'" );
	}
	echo "转换成功";
}

// 获取数据时调用
add_action ( 'PLUGIN_DATA_ATTENDANCE', 'data_attendance_view' );
function data_attendance_view() {
	if (isset ( $_GET ['time_code'] ))
		$time_code = $_GET ['time_code'];
	else
		$time_code = date ( 'Ym' );
	$data ['dataRows'] = getMonthData ( $time_code ); // 转换成显示格式
	$data1 = $data ['dataRows'];
	
	if (($time_code - 1) % 100 != 0) // 判断是否跨年，读取上个月数据，关于考核周期统计
		$data2 = getMonthData ( $time_code - 1, 0 );
	else
		$data2 = getMonthData ( (substr ( $time_code, 0, 4 ) - 1) . "12", 0 );
	
	$data ['dataRows'] = getCountData ( $time_code );
	$data ['page'] = "1"; // jqgrid要求的参数：page:当前页数，因为不要求翻页所以为1
	$d = get_data ( "SELECT count(1) FROM user_attendance_new WHERE `time_code`='" . $time_code . "'" );
	$data ['rows'] = $d [0] ['count(1)']; // jqgrid要求的参数：rows:行数
	$data ['total'] = "1"; // jqgrid要求的参数：total:总页数
	$json_string = json_encode ( $data ); // 转换成json格式
	echo $json_string;
}

// 获取数据时调用（new）
add_action ( 'PLUGIN_DATA_ATTENDANCE_NEW', 'data_attendance_view_new' );
function data_attendance_view_new() {
	if (isset ( $_GET ['time_code'] ))
		$time_code = $_GET ['time_code'];
	else
		$time_code = date ( 'Ym' );
	$data ['data'] = getMonthData ( $time_code ); // 转换成显示格式
	$data1 = $data ['data'];
	
	if (($time_code - 1) % 100 != 0) // 判断是否跨年，读取上个月数据，关于考核周期统计
		$data2 = getMonthData ( $time_code - 1, 0 );
	else
		$data2 = getMonthData ( (substr ( $time_code, 0, 4 ) - 1) . "12", 0 );
	
	$data ['data'] = getCountData ( $time_code ); // jqgrid要求的参数：total:总页数
	$json_string = json_encode ( $data );
	// 转换成json格式
	for($i = 1; $i <= 31; $i ++) {
		$json_string = str_replace ( '"d' . $i . '":', '', $json_string );
	}
	$json_string = str_replace ( '"uid":', '', $json_string );
	$json_string = str_replace ( '"time_code":', '', $json_string );
	$json_string = str_replace ( '"id":', '', $json_string );
	$json_string = str_replace ( '"name":', '', $json_string );
	$json_string = str_replace ( '"eid":', '', $json_string );
	$json_string = str_replace ( '"S":', '', $json_string );
	$json_string = str_replace ( '"B":', '', $json_string );
	$json_string = str_replace ( '"D":', '', $json_string );
	$json_string = str_replace ( '"O":', '', $json_string );
	$json_string = str_replace ( '"CD":', '', $json_string );
	$json_string = str_replace ( '"TO":', '', $json_string );
	$json_string = str_replace ( '"K":', '', $json_string );
	$json_string = str_replace ( '{', '[', $json_string );
	$json_string = str_replace ( '}', ']', $json_string );
	$json_string = str_replace ( '}', ']', $json_string );
	$json_string = '{' . substr ( $json_string, 1, strlen ( $json_string ) - 2 ) . '}';
	echo $json_string;
}

// 编辑数据完成时调用
add_action ( 'PLUGIN_ATTENDANCE_EDIT', 'attendance_edit_view' );
function attendance_edit_view() {
	if (uid () == 6) {
		if ($_POST ['id'] > 10000)
			$id = $_POST ['id'] - 10000; // 上下午数据id相差10000
		else
			$id = $_POST ['id'];
		run_sql ( "update user_attendance_new set `d1`= " . cg ( 'd1' ) . ",`d2`= " . cg ( 'd2' ) . ",`d3`= " . cg ( 'd3' ) . ",`d4`= " . cg ( 'd4' ) . 		// 把数据存入数据库
		",`d5`= " . cg ( 'd5' ) . ",`d6`= " . cg ( 'd6' ) . ",`d7`= " . cg ( 'd7' ) . ",`d8`= " . cg ( 'd8' ) . ",`d9`= " . cg ( 'd9' ) . ",`d10`= " . cg ( 'd10' ) . ",`d11`= " . cg ( 'd11' ) . ",`d12`= " . cg ( 'd12' ) . ",`d13`= " . cg ( 'd13' ) . ",`d14`= " . cg ( 'd14' ) . ",`d15`= " . cg ( 'd15' ) . ",`d16`= " . cg ( 'd16' ) . ",`d17`= " . cg ( 'd17' ) . ",`d18`= " . cg ( 'd18' ) . ",`d19`= " . cg ( 'd19' ) . ",`d20`= " . cg ( 'd20' ) . ",`d21`= " . cg ( 'd21' ) . ",`d22`= " . cg ( 'd22' ) . ",`d23`= " . cg ( 'd23' ) . ",`d24`= " . cg ( 'd24' ) . ",`d25`= " . cg ( 'd25' ) . ",`d26`= " . cg ( 'd26' ) . ",`d27`= " . cg ( 'd27' ) . ",`d28`= " . cg ( 'd28' ) . ",`d29`= " . cg ( 'd29' ) . ",`d30`= " . cg ( 'd30' ) . ",`d31`= " . cg ( 'd31' ) . " WHERE `id`=" . $id );
		// changeOld();
	}
}








// 编辑数据完成时调用(new)
add_action ( 'PLUGIN_ATTENDANCE_SAVE', 'attendance_save_view' );
function attendance_save_view() {
	try {
		if (isset ( $_POST ['data'] )) {
			$_POST ['id'] = $_POST ['data'] [2];
			
			for($i = 5; $i <= 35; $i ++) {
				$_POST ['d' . ($i - 4)] = $_POST ['data'] [$i];
			}
			
			if ($_POST ['id'] > 10000)
				$id = $_POST ['id'] - 10000; // 上下午数据id相差10000
			else
				$id = $_POST ['id'];
			run_sql ( "update user_attendance_new set `d1`= " . cg_new ( 'd1' ) . ",`d2`= " . cg_new ( 'd2' ) . ",`d3`= " . cg_new ( 'd3' ) . ",`d4`= " . cg_new ( 'd4' ) . 			// 把数据存入数据库
			",`d5`= " . cg_new ( 'd5' ) . ",`d6`= " . cg_new ( 'd6' ) . ",`d7`= " . cg_new ( 'd7' ) . ",`d8`= " . cg_new ( 'd8' ) . ",`d9`= " . cg_new ( 'd9' ) . ",`d10`= " . cg_new ( 'd10' ) . ",`d11`= " . cg_new ( 'd11' ) . ",`d12`= " . cg_new ( 'd12' ) . ",`d13`= " . cg_new ( 'd13' ) . ",`d14`= " . cg_new ( 'd14' ) . ",`d15`= " . cg_new ( 'd15' ) . ",`d16`= " . cg_new ( 'd16' ) . ",`d17`= " . cg_new ( 'd17' ) . ",`d18`= " . cg_new ( 'd18' ) . ",`d19`= " . cg_new ( 'd19' ) . ",`d20`= " . cg_new ( 'd20' ) . ",`d21`= " . cg_new ( 'd21' ) . ",`d22`= " . cg_new ( 'd22' ) . ",`d23`= " . cg_new ( 'd23' ) . ",`d24`= " . cg_new ( 'd24' ) . ",`d25`= " . cg_new ( 'd25' ) . ",`d26`= " . cg_new ( 'd26' ) . ",`d27`= " . cg_new ( 'd27' ) . ",`d28`= " . cg_new ( 'd28' ) . ",`d29`= " . cg_new ( 'd29' ) . ",`d30`= " . cg_new ( 'd30' ) . ",`d31`= " . cg_new ( 'd31' ) . " WHERE `id`=" . $id );
		}
	} catch ( Exception $e ) {
		echo $e->getMessage ();
	}
	
	echo 'ok';
}

// 初始化月份表时调用
add_action ( 'PLUGIN_ATTENDANCE_CREATE', 'attendance_create_view' );
function attendance_create_view() {
	if (isset ( $_GET ['time_code'] )) {
		$time_code = $_GET ['time_code'];
		if (substr ( $time_code, 4, 2 ) != 12) // 判断是否跨年,因默认初始化下一个月的考勤表
			$now_time_code = $time_code + 1;
		else
			$now_time_code = (substr ( $time_code, 0, 4 ) + 1) . "01";
		$data = get_data ( "SELECT uid,name FROM user_attendance_new  WHERE time_code='" . $time_code . "'" ); // 获取存在的用户
		$data_now = get_data ( "SELECT uid,name FROM user_attendance_new  WHERE time_code='" . $now_time_code . "'" ); // 若已经初始化则不进行初始化
		
		if (count ( $data_now ) <= 1) { // 对新表操作
			for($i = 0; $i < count ( $data ); $i ++) {
				run_sql ( "insert into user_attendance_new(uid,name,time_code) values(" . $data [$i] ['uid'] . ",'" . $data [$i] ['name'] . "','" . $now_time_code . "')" );
				// run_sql("insert into user_attendance(uid,name,time_code) values(".$data[$i]['uid'].",'".$data[$i]['name']."','".$now_time_code."')");
			}
			
			// $data = get_data("SELECT uid,name FROM user_attendance WHERE time_code='".$time_code."'"); //对旧表操作
			// $data_now = get_data("SELECT uid,name FROM user_attendance WHERE time_code='".$now_time_code."'");
			
			// if(count($data_now)<=1){
			// for($i=0;$i<count($data);$i++){
			// run_sql("insert into user_attendance_new(uid,name,time_code) values(".$data[$i]['uid'].",'".$data[$i]['name']."','".$now_time_code."')");
			// run_sql("insert into user_attendance(uid,name,time_code) values(".$data[$i]['uid'].",'".$data[$i]['name']."','".$now_time_code."')");
			// }
			// }
			
			echo "初始化成功";
			return;
		}
	}
	echo "初始化失败";
}

// 生成EXCEL方法
add_action ( 'PLUGIN_ATTENDANCE_OUT', 'attendance_out_view' );
function attendance_out_view() {
	if (uid () == 6) { // 第一个为雷静 第2个为测试阶段使用
		require_once 'plugin/check_attendance/PHPExcel.php';
		require_once 'plugin/check_attendance/PHPExcel/Writer/Excel2007.php'; // 用于 excel-2007 格式
		$objExcel = new PHPExcel ();
		$objWriter = new PHPExcel_Writer_Excel2007 ( $objExcel ); // 用于 2007 格式
		$objWriter->setOffice2003Compatibility ( false );
		
		// *************************************
		// 设置文档基本属性
		$objProps = $objExcel->getProperties ();
		$objProps->setCreator ( "Lei Jing" );
		$objProps->setLastModifiedBy ( "Lei Jing" );
		$objProps->setTitle ( "The attendance sheet" );
		$objProps->setSubject ( "The attendance sheet" );
		$objProps->setDescription ( "The attendance sheet" );
		$objProps->setKeywords ( "The attendance sheet" );
		$objProps->setCategory ( "The attendance sheet" );
		
		// *************************************
		// 设置当前的sheet索引，用于后续的内容操作。
		$objExcel->setActiveSheetIndex ( 0 );
		$objActSheet = $objExcel->getActiveSheet ();
		// 设置当前活动sheet的名称
		$objActSheet->setTitle ( '考勤表' );
		
		if (isset ( $_GET ['time_code'] ))
			$time_code = $_GET ['time_code'];
		else
			$time_code = date ( 'Ym' );
		$data = getMonthData ( $time_code, 0 ); // 获取本月数据
		if (($time_code - 1) % 100 != 0) // 判断是否跨年
			$data2 = getMonthData ( $time_code - 1, 0 ); // 获取上月数据
		else
			$data2 = getMonthData ( (substr ( $time_code, 0, 4 ) - 1) . "12", 0 );
			
			// ************************************* 根据模板生成基本的EXCEL*************************************
		$objActSheet->mergeCells ( 'A3:A5' );
		$objActSheet->setCellValue ( 'A3', '员工代码' );
		$objActSheet->mergeCells ( 'B3:B5' );
		$objActSheet->setCellValue ( 'B3', '' );
		$objActSheet->setCellValue ( 'B2', '部   门:' );
		$objActSheet->mergeCells ( 'C2:N2' );
		$objActSheet->setCellValue ( 'C2', '企业工程&技术中心--研发部' );
		$objActSheet->mergeCells ( 'B1:AO1' );
		$objActSheet->setCellValue ( 'B1', '广州华南资讯科技有限公司考勤表' );
		$objStyleA1 = $objActSheet->getStyle ( 'B1' );
		center ( $objStyleA1 );
		$objFontA1 = $objStyleA1->getFont ();
		$objFontA1->setSize ( 24 );
		$objFontA1->setBold ( true );
		$objActSheet->mergeCells ( 'AH3:AN3' );
		$objActSheet->setCellValue ( 'AH3', '统计' );
		$objActSheet->setCellValue ( 'AH4', '年假' );
		$objActSheet->setCellValue ( 'AH5', '(天)' );
		$objActSheet->setCellValue ( 'AI4', '病假' );
		$objActSheet->setCellValue ( 'AI5', '(天)' );
		$objActSheet->setCellValue ( 'AJ4', '事假' );
		$objActSheet->setCellValue ( 'AJ5', '(天)' );
		$objActSheet->setCellValue ( 'AK4', '旷工' );
		$objActSheet->setCellValue ( 'AK5', '(天)' );
		$objActSheet->setCellValue ( 'AL4', '迟到' );
		$objActSheet->setCellValue ( 'AL5', '(类/次)' );
		$objActSheet->setCellValue ( 'AM4', '早退' );
		$objActSheet->setCellValue ( 'AM5', '(类/次)' );
		$objActSheet->setCellValue ( 'AN4', '其他' );
		$objActSheet->setCellValue ( 'AN5', '(天)' );
		$objActSheet->mergeCells ( 'AO3:AO5' );
		$objActSheet->setCellValue ( 'AO3', '备注  (上月)' );
		$objActSheet->getStyle ( 'AO3' )->getAlignment ()->setWrapText ( true );
		$objActSheet->mergeCells ( 'AP3:AQ3' );
		$objActSheet->setCellValue ( 'AP3', '部门周期考核统计' );
		$objActSheet->setCellValue ( 'AP4', '请假' );
		$objActSheet->setCellValue ( 'AP5', '(天)' );
		$objActSheet->setCellValue ( 'AQ4', '上班' );
		$objActSheet->setCellValue ( 'AQ5', '(天)' );
		$objActSheet->mergeCells ( 'AQ6:AQ' . (count ( $data ) + 5) );
		$objActSheet->getColumnDimension ( 'AH' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AI' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AJ' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AK' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AL' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AM' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AN' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AO' )->setWidth ( 7 );
		$objActSheet->getColumnDimension ( 'AP' )->setWidth ( 9 );
		$objActSheet->getColumnDimension ( 'AQ' )->setWidth ( 9 );
		$objActSheet->getColumnDimension ( 'B' )->setWidth ( 13 );
		$objActSheet->getColumnDimension ( 'A' )->setWidth ( 10 );
		$objActSheet->setCellValue ( 'B' . (6 + count ( $data )), '考勤符号:' );
		$objActSheet->mergeCells ( 'C' . (6 + count ( $data )) . ':E' . (count ( $data ) + 6) );
		$objActSheet->setCellValue ( 'C' . (6 + count ( $data )), 'B—病假' );
		$objActSheet->mergeCells ( 'G' . (6 + count ( $data )) . ':I' . (count ( $data ) + 6) );
		$objActSheet->setCellValue ( 'G' . (6 + count ( $data )), 'S—事假' );
		$objActSheet->mergeCells ( 'K' . (6 + count ( $data )) . ':N' . (count ( $data ) + 6) );
		$objActSheet->setCellValue ( 'K' . (6 + count ( $data )), 'D-带薪年休假' );
		$objActSheet->mergeCells ( 'Q' . (6 + count ( $data )) . ':X' . (count ( $data ) + 6) );
		$objActSheet->setCellValue ( 'Q' . (6 + count ( $data )), 'W—外勤（出差,公司外办事）' );
		$objActSheet->mergeCells ( 'Z' . (6 + count ( $data )) . ':AB' . (count ( $data ) + 6) );
		$objActSheet->setCellValue ( 'Z' . (6 + count ( $data )), 'SJ—丧假' );
		$objActSheet->mergeCells ( 'C' . (7 + count ( $data )) . ':E' . (count ( $data ) + 7) );
		$objActSheet->setCellValue ( 'C' . (7 + count ( $data )), 'K—旷工' );
		$objActSheet->mergeCells ( 'G' . (7 + count ( $data )) . ':I' . (count ( $data ) + 7) );
		$objActSheet->setCellValue ( 'G' . (7 + count ( $data )), 'H—婚假' );
		$objActSheet->mergeCells ( 'K' . (7 + count ( $data )) . ':N' . (count ( $data ) + 7) );
		$objActSheet->setCellValue ( 'K' . (7 + count ( $data )), 'J—计划生育假' );
		$objActSheet->mergeCells ( 'Q' . (7 + count ( $data )) . ':X' . (count ( $data ) + 7) );
		$objActSheet->setCellValue ( 'Q' . (7 + count ( $data )), 'WD—未带（打）卡' );
		$objActSheet->mergeCells ( 'Z' . (7 + count ( $data )) . ':AB' . (count ( $data ) + 7) );
		$objActSheet->setCellValue ( 'Z' . (7 + count ( $data )), 'BX—补休' );
		$objActSheet->setCellValue ( 'B' . (8 + count ( $data )), '注:' );
		$objActSheet->mergeCells ( 'C' . (8 + count ( $data )) . ':AG' . (count ( $data ) + 8) );
		$objActSheet->setCellValue ( 'C' . (8 + count ( $data )), '迟到15分钟以内（含15分钟），请填CD-A；迟到15-30分钟（含30分钟），请填CD-B；迟到30分钟以上，请填CD-C。' ); // 字符串内容
		$objActSheet->mergeCells ( 'C' . (9 + count ( $data )) . ':AG' . (count ( $data ) + 9) );
		$objActSheet->setCellValue ( 'C' . (9 + count ( $data )), '早退15分钟以内（含15分钟），请填ZT-A；早退15-30分钟（含30分钟），请填ZT-B；早退30分钟以上，请填ZT-C。' ); // 字符串内容
		$objActSheet->mergeCells ( 'AJ' . (8 + count ( $data )) . ':AO' . (count ( $data ) + 8) );
		$objActSheet->setCellValue ( 'AJ' . (8 + count ( $data )), '要求：每月1日上午10：00前交人力资源部' );
		$objActSheet->setCellValue ( 'B' . (10 + count ( $data )), '部门经理签名:' );
		$objActSheet->mergeCells ( 'H' . (10 + count ( $data )) . ':K' . (count ( $data ) + 10) );
		$objActSheet->setCellValue ( 'H' . (10 + count ( $data )), '考勤员签名：' );
		$objActSheet->mergeCells ( 'L' . (10 + count ( $data )) . ':M' . (count ( $data ) + 10) );
		$objActSheet->setCellValue ( 'L' . (10 + count ( $data )), '雷静' );
		$objActSheet->mergeCells ( 'AC' . (10 + count ( $data )) . ':AG' . (count ( $data ) + 10) );
		$objActSheet->setCellValue ( 'AC' . (10 + count ( $data )), substr ( $time_code, 0, 4 ) . "-" . substr ( $time_code, 4, 2 ) . "-" . day ( substr ( $time_code, 4, 2 ), substr ( $time_code, 0, 4 ) ) );
		$objStyleB = $objActSheet->getStyle ( 'B' . (6 + count ( $data )) . ':B' . (10 + count ( $data )) );
		$objAlignB = $objStyleB->getAlignment ();
		$objAlignB->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
		$objAlignB->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		$objStyleALL = $objActSheet->getStyle ( 'A1:AU' . (5 + count ( $data )) );
		center ( $objStyleALL );
		$objActSheet->mergeCells ( 'AH2:AO2' );
		$objActSheet->setCellValue ( 'AH2', '考勤日期:' . substr ( $time_code, 0, 4 ) . "年" . substr ( $time_code, 4, 2 ) . "月" );
		$objStyleAH = $objActSheet->getStyle ( 'AH2' );
		$objAlignAH = $objStyleAH->getAlignment ();
		$objAlignAH->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_RIGHT );
		$objAlignAH->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
		
		$objStyleALL2 = $objActSheet->getStyle ( 'A6:B' . (5 + count ( $data )) );
		$objFontALL2 = $objStyleALL2->getFont ();
		$objFontALL2->setSize ( 16 );
		$objStyleALL3 = $objActSheet->getStyle ( 'A3:AQ5' );
		$objFontALL3 = $objStyleALL3->getFont ();
		$objFontALL3->setSize ( 12 );
		$objStyleALL4 = $objActSheet->getStyle ( 'A2:AQ2' );
		$objFontALL4 = $objStyleALL4->getFont ();
		$objFontALL4->setSize ( 16 );
		
		$objDrawing = new PHPExcel_Worksheet_Drawing ();
		$objDrawing->setName ( '' );
		$objDrawing->setDescription ( '' );
		$objDrawing->setPath ( 'plugin/check_attendance/excel2.png' );
		$objDrawing->setHeight ( 50 );
		$objDrawing->setWidth ( 100 );
		$objDrawing->setCoordinates ( 'B3' );
		$objDrawing->setWorksheet ( $objActSheet );
		
		// ************************************* 存入数据到EXCEL*************************************
		
		for($j = 0; $j < count ( $data ) / 2; $j ++) {
			$objActSheet->mergeCells ( 'A' . (6 + $j * 2) . ':A' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'B' . (6 + $j * 2) . ':B' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'AH' . (6 + $j * 2) . ':AH' . (6 + $j * 2 + 1) );
			// 改 $objActSheet->setCellValue('AH'.(6+$j*2), 0);
			$objActSheet->mergeCells ( 'AI' . (6 + $j * 2) . ':AI' . (6 + $j * 2 + 1) );
			// 改 $objActSheet->setCellValue('AI'.(6+$j*2), 0);
			$objActSheet->mergeCells ( 'AJ' . (6 + $j * 2) . ':AJ' . (6 + $j * 2 + 1) );
			// 改 $objActSheet->setCellValue('AJ'.(6+$j*2), 0);
			$objActSheet->mergeCells ( 'AK' . (6 + $j * 2) . ':AK' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'AL' . (6 + $j * 2) . ':AL' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'AM' . (6 + $j * 2) . ':AM' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'AN' . (6 + $j * 2) . ':AN' . (6 + $j * 2 + 1) );
			// 改 $objActSheet->setCellValue('AN'.(6+$j*2), 0);
			// 改 $objActSheet->setCellValue('AK'.(6+$j*2), 0);
			$objActSheet->mergeCells ( 'AO' . (6 + $j * 2) . ':AO' . (6 + $j * 2 + 1) );
			$objActSheet->mergeCells ( 'AP' . (6 + $j * 2) . ':AP' . (6 + $j * 2 + 1) );
			$objActSheet->setCellValueExplicit ( 'A' . (6 + $j * 2), $data [$j * 2] ['eid'], PHPExcel_Cell_DataType::TYPE_STRING ); // 工号
			$objActSheet->setCellValue ( 'B' . (6 + $j * 2), $data [$j * 2] ['name'] ); // 名字
		}
		
		$ch = 'C';
		$head = '';
		$total = '';
		$total2 = '';
		for($i = 1; $i <= 31; $i ++) { // 本月统计
			$objActSheet->mergeCells ( $head . $ch . '3' . ':' . $head . $ch . '5' );
			$objActSheet->getColumnDimension ( $head . $ch )->setWidth ( 3.5 ); // d1~d31宽度
			$objActSheet->getColumnDimension ( 'AG' )->setWidth ( 3.5 );
			$objActSheet->setCellValue ( $head . $ch . '3', $i );
			
			for($j = 0; $j < count ( $data ); $j ++) {
				if ($data [$j] ['d' . $i] != '-') // 写入数据,正常假期不用写
					$objActSheet->setCellValue ( $head . $ch . (6 + $j), $data [$j] ['d' . $i] );
				
				if (($j == 1 || $j == 0) && $i <= 25) { // 统计本月25号前需要上班的数量
					if ($data [$j] ['d' . $i] != '-') {
						if (isset ( $total2 ['AQ'] ))
							$total2 ['AQ'] = $total2 ['AQ'] + 0.5;
						else
							$total2 ['AQ'] = 0.5;
					}
				}
				$uid = $data [$j] ['uid'];
				switch ($data [$j] ['d' . $i]) { // 统计各种请假，迟到数量
					case 'S' :
						if (isset ( $total ['AJ' . $uid] ))
							$total ['AJ' . $uid] = $total ['AJ' . $uid] + 0.5;
						else
							$total ['AJ' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AJ' . (6 + $j - $j % 2), $total ['AJ' . $uid] );
						break;
					case 'B' :
						if (isset ( $total ['AI' . $uid] ))
							$total ['AI' . $uid] = $total ['AI' . $uid] + 0.5;
						else
							$total ['AI' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AI' . (6 + $j - $j % 2), $total ['AI' . $uid] );
						break;
					case 'D' :
						if (isset ( $total ['AH' . $uid] ))
							$total ['AH' . $uid] = $total ['AH' . $uid] + 0.5;
						else
							$total ['AH' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AH' . (6 + $j - $j % 2), $total ['AH' . $uid] );
						break;
					case 'W' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						if (isset ( $total ['O' . $uid] ))
							$total ['O' . $uid] = $total ['O' . $uid] + 0.5;
						else
							$total ['O' . $uid] = 0.5; // 增
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'SJ' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'H' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'J' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'WD' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						if (isset ( $total ['O' . $uid] ))
							$total ['O' . $uid] = $total ['O' . $uid] + 0.5;
						else
							$total ['O' . $uid] = 0.5; // 改
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'BX' :
						if (isset ( $total ['AN' . $uid] ))
							$total ['AN' . $uid] = $total ['AN' . $uid] + 0.5;
						else
							$total ['AN' . $uid] = 0.5;
						if (isset ( $total ['O' . $uid] ))
							$total ['O' . $uid] = $total ['O' . $uid] + 0.5;
						else
							$total ['O' . $uid] = 0.5; // 改
						$objActSheet->setCellValue ( 'AN' . (6 + $j - $j % 2), $total ['AN' . $uid] );
						break;
					case 'CD' :
						if (isset ( $total ['AL' . $uid] ))
							$total ['AL' . $uid] = $total ['AL' . $uid] + 1;
						else
							$total ['AL' . $uid] = 1; // 改
						$objActSheet->setCellValue ( 'AL' . (6 + $j - $j % 2), $total ['AL' . $uid] );
						break;
					case 'K' :
						if (isset ( $total ['AK' . $uid] ))
							$total ['AK' . $uid] = $total ['AK' . $uid] + 0.5;
						else
							$total ['AK' . $uid] = 0.5;
						$objActSheet->setCellValue ( 'AK' . (6 + $j - $j % 2), $total ['AK' . $uid] );
						break;
					case '-' :
						$objStyle = $objActSheet->getStyle ( $head . $ch . (6 + $j) );
						$objFill = $objStyle->getFill ();
						$objFill->setFillType ( PHPExcel_Style_Fill::FILL_PATTERN_DARKDOWN );
				}
				
				if ($i == 25) { // 考核周期内统计
					if (isset ( $total ['AH' . $uid] ))
						$total2 ['AH' . $uid] = $total ['AH' . $uid];
					else
						$total2 ['AH' . $uid] = 0;
					if (isset ( $total ['AN' . $uid] ))
						$total2 ['AN' . $uid] = $total ['AN' . $uid];
					else
						$total2 ['AN' . $uid] = 0;
					if (isset ( $total ['AI' . $uid] ))
						$total2 ['AI' . $uid] = $total ['AI' . $uid];
					else
						$total2 ['AI' . $uid] = 0;
					if (isset ( $total ['AJ' . $uid] ))
						$total2 ['AJ' . $uid] = $total ['AJ' . $uid];
					else
						$total2 ['AJ' . $uid] = 0;
					if (isset ( $total ['AK' . $uid] ))
						$total2 ['AK' . $uid] = $total ['AK' . $uid];
					else
						$total2 ['AK' . $uid] = 0;
					if (isset ( $total ['O' . $uid] ))
						$total2 ['O' . $uid] = $total ['O' . $uid];
					else
						$total2 ['O' . $uid] = 0; // 改
							                          // 删
					$total2 ['AP' . $uid] = $total2 ['AJ' . $uid] + $total2 ['AI' . $uid] + $total2 ['AH' . $uid] + $total2 ['AN' . $uid] + $total2 ['AK' . $uid] - $total2 ['O' . $uid]; // 改
				}
			}
			$ich = ord ( $ch ) + 1;
			if ($ich > 90) {
				$ch = 'A';
				$head = 'A';
			} else
				$ch = chr ( $ich );
		}
		
		$t = lastMonth ( $data2, 1 ); // 上月统计
		$atotal2 = $t ['atotal2'];
		for($j = 0; $j < count ( $data ); $j ++) { // 计算考核周期内请假总数
			$uid = $data [$j] ['uid'];
			if ($j % 2 == 0)
				$objActSheet->setCellValue ( 'AP' . (6 + $j), $total2 ['AP' . $uid] + $atotal2 ['AP' . $uid] );
		}
		$objActSheet->setCellValue ( 'AQ6', $total2 ['AQ'] + $atotal2 ['AQ'] ); // 计算考核周期内上班数
		                                                                        
		// *************************************
		                                                                        // 设置边框
		$ch = 'A';
		$head = '';
		for($j = 0; $j < 43; $j ++) {
			for($i = 3; $i < count ( $data ) + 6; $i ++) {
				$objStyle = $objActSheet->getStyle ( $head . $ch . $i );
				$objBorder = $objStyle->getBorders ();
				$objBorder->getTop ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
				$objBorder->getBottom ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
				$objBorder->getLeft ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
				$objBorder->getRight ()->setBorderStyle ( PHPExcel_Style_Border::BORDER_THIN );
			}
			$ich = ord ( $ch ) + 1;
			if ($ich > 90) {
				$ch = 'A';
				$head = 'A';
			} else
				$ch = chr ( $ich );
		}
		
		// *************************************
		// 输出内容
		header ( 'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' );
		header ( 'Content-Disposition: attachment;filename="01simple.xlsx"' );
		header ( 'Cache-Control: max-age=0' );
		$objWriter = PHPExcel_IOFactory::createWriter ( $objExcel, 'Excel2007' );
		
		$outputFileName = $time_code . "考勤统计表.xlsx";
		// 到文件
		$objWriter->save ( iconv ( 'UTF-8', 'GB18030', $outputFileName ) );
		echo "生成成功";
	}
}

// -------------------------------------------------------------------方法------------------------------------------------------------------------

// ****************排序函数
function cmp($a, $b) { // 下午为上午ID+10000 此函数为排序对比函数
	$aa = $a ['id'];
	$bb = $b ['id'];
	if ($aa - 10000 > 0)
		$aa = $aa - 10000 + 0.5; // +0.5因为排序时候上午排序在下午前
	if ($bb - 10000 > 0)
		$bb = $bb - 10000 + 0.5;
	
	if ($a ['eid'] == $b ['eid']) {
		
		if ($aa == $bb) {
			return 0;
		}
		return ($aa > $bb) ? 1 : - 1;
	} else
		return ($a ['eid'] - $b ['eid'] > 0) ? 1 : - 1;
}

// ****************前台状态转换到后台存储格式 ["","-", "S", "B", "D", "W", "CD", 'SJ','H','J','WD','BX','K']
function cg_new($d) { // 前台显示到数据库的转换,增加状态必改
	switch ($_POST [$d]) {
		case '' :
			$dd = '1';
			break;
		case '-' :
			$dd = '4';
			break;
		case "S" :
			$dd = '0';
			break;
		case "B" :
			$dd = '2';
			break;
		case "D" :
			$dd = '3';
			break;
		case "W" :
			$dd = '5';
			break;
		case 'CD' :
			$dd = '6';
			break;
		case 'SJ' :
			$dd = '7';
			break;
		case 'H' :
			$dd = '8';
			break;
		case 'J' :
			$dd = '9';
			break;
		case "WD" :
			$dd = '11';
			break;
		case 'BX' :
			$dd = '12';
			break;
		case 'K' :
			$dd = '13';
			break;
	}
	if ($_POST ['id'] > 10000) { // 数据库存储规则：小数点左边代表上午状态，右边代表下午状态
		$id2 = $_POST ['id'] - 10000;
		$whole = get_var ( "select " . $d . " from user_attendance_new WHERE `id`=" . $id2 );
		$s = explode ( ".", $whole );
		return $s [0] . "." . $dd;
	} else {
		$id2 = $_POST ['id'];
		$whole = get_var ( "select " . $d . " from user_attendance_new WHERE `id`=" . $id2 );
		$s = explode ( ".", $whole );
		return $dd . "." . $s [1];
	}
}

// ****************前台状态转换到后台存储格式
function cg($d) { // 前台显示到数据库的转换,增加状态必改
	switch ($_POST [$d]) {
		case 1 :
			$dd = '1';
			break;
		case 2 :
			$dd = '4';
			break;
		case 3 :
			$dd = '0';
			break;
		case 4 :
			$dd = '2';
			break;
		case 5 :
			$dd = '3';
			break;
		case 6 :
			$dd = '5';
			break;
		case 7 :
			$dd = '6';
			break;
		case 8 :
			$dd = '7';
			break;
		case 9 :
			$dd = '8';
			break;
		case 10 :
			$dd = '9';
			break;
		case 11 :
			$dd = '11';
			break;
		case 12 :
			$dd = '12';
			break;
		case 13 :
			$dd = '13';
			break;
	}
	if ($_POST ['id'] > 10000) { // 数据库存储规则：小数点左边代表上午状态，右边代表下午状态
		$id2 = $_POST ['id'] - 10000;
		$whole = get_var ( "select " . $d . " from user_attendance_new WHERE `id`=" . $id2 );
		$s = explode ( ".", $whole );
		return $s [0] . "." . $dd;
	} else {
		$id2 = $_POST ['id'];
		$whole = get_var ( "select " . $d . " from user_attendance_new WHERE `id`=" . $id2 );
		$s = explode ( ".", $whole );
		return $dd . "." . $s [1];
	}
}

// 状态说明: S：事假 ''：正常上班 B：病假 D：年假 '-':正常假期 'W'：外勤 CD:迟到 SJ:丧假 H：婚假 J：计划生育假 WD：忘打卡 BX：补休 K：旷工
// ****************数据库状态转换到前台格式
function cg2($d) {
	if ($d % 10 == 0)
		$d = $d / 10; // 数据库状态到前台状态的转换,添加状态必改
	switch ($d) {
		case 0 :
			return 'S';
		case 1 :
			return '';
		case 2 :
			return 'B';
		case 3 :
			return 'D';
		case 4 :
			return '-';
		case 5 :
			return 'W';
		case 6 :
			return 'CD';
		case 7 :
			return 'SJ';
		case 8 :
			return 'H';
		case 9 :
			return 'J';
		case 11 :
			return 'WD';
		case 12 :
			return 'BX';
		case 13 :
			return 'K';
	}
	return '';
}

// ****************获取某月数据
function getMonthData($time_code, $type = 1) { // 从数据库拿数据并转换格式
	$morning = get_data ( "SELECT uid,time_code,ua.id,u.eid,ua.name,ua.d1,ua.d2,ua.d3,ua.d4,ua.d5,ua.d6,ua.d7,ua.d8,ua.d9,ua.d10,ua.d11,ua.d12,ua.d13,ua.d14,ua.d15,ua.d16,
	ua.d17,ua.d18,ua.d19,ua.d20,ua.d21,ua.d22,ua.d23,ua.d24,ua.d25,ua.d26,ua.d27,ua.d28,ua.d29,ua.d30,ua.d31 FROM user_attendance_new ua, user u WHERE ua.uid= u.id and `time_code`='" . $time_code . "'" );
	$afternoon = get_data ( "SELECT uid,time_code,ua.id+10000 as id,u.eid,ua.name,ua.d1,ua.d2,ua.d3,ua.d4,ua.d5,ua.d6,ua.d7,ua.d8,ua.d9,ua.d10,ua.d11,ua.d12,ua.d13,ua.d14,ua.d15,ua.d16,
	ua.d17,ua.d18,ua.d19,ua.d20,ua.d21,ua.d22,ua.d23,ua.d24,ua.d25,ua.d26,ua.d27,ua.d28,ua.d29,ua.d30,ua.d31,u.eid FROM user_attendance_new ua, user u WHERE ua.uid= u.id and `time_code`='" . $time_code . "'" );
	$d22 = array_merge ( $morning, $afternoon ); // morning上午数据 afternoon下午数据
	$d11 = array_merge ( $morning, $afternoon );
	uasort ( $d22, cmp ); // 按ID排序
	$j = 0;
	while ( list ( $key, $val ) = each ( $d22 ) ) {
		for($i = 0; $i < count ( $d11 ); $i ++) {
			if ($d11 [$i] ['id'] == $val ['id']) {
				$data ['dataRows'] [$j] = $d11 [$i];
				$j ++;
			}
		}
	}
	
	while ( list ( $key, $val ) = each ( $data ['dataRows'] ) ) {
		if ($type == 1) { // 若不是输出到前台则不用修改名称
			if ($val ['id'] > 10000) {
				$data ['dataRows'] [$key] ['name'] = $data ['dataRows'] [$key] ['name'] . "(下)";
			} else {
				$data ['dataRows'] [$key] ['name'] = $data ['dataRows'] [$key] ['name'] . "(上)";
			}
		}
		
		for($i = 1; $i <= 31; $i ++) { // 更改格式
			if ($val ['id'] > 10000) {
				$var = explode ( ".", $val ['d' . $i] );
				$s = cg2 ( $var [1] );
				$data ['dataRows'] [$key] ['d' . $i] = $s;
			} else {
				$var = explode ( ".", $val ['d' . $i] );
				$s = cg2 ( $var [0] );
				$data ['dataRows'] [$key] ['d' . $i] = $s;
			}
		}
	}
	// uasort($data['dataRows'], cmp2);
	return $data ['dataRows'];
}

// ****************EXCEL居中
function center($objStyleA1) {
	$objAlignA1 = $objStyleA1->getAlignment ();
	$objAlignA1->setHorizontal ( PHPExcel_Style_Alignment::HORIZONTAL_CENTER );
	$objAlignA1->setVertical ( PHPExcel_Style_Alignment::VERTICAL_CENTER );
}

// ****************判断一个月多少日
function day($month, $year) {
	switch ($month) {
		case 1 :
			return 31;
		case 2 :
			{
				if ($year % 4 == 0)
					return 29;
				else
					return 28;
			}
		case 3 :
			return 31;
		case 4 :
			return 30;
		case 5 :
			return 31;
		case 6 :
			return 30;
		case 7 :
			return 31;
		case 8 :
			return 31;
		case 9 :
			return 30;
		case 10 :
			return 31;
		case 11 :
			return 30;
		case 12 :
			return 31;
	}
}

// 考核周期--上月数据统计函数 参数：输入上月数据
function lastMonth($data2, $type = 0) {
	$atotal = '';
	$atotal2 = '';
	
	if ($type == 0) {
		$begin = 1;
		$end = 25;
	} else if ($type == 1) {
		$begin = 26;
		$end = 31;
	}
	
	for($i = $begin; $i <= 31; $i ++) {
		for($j = 0; $j < count ( $data2 ); $j ++) {
			
			if ($j == 1 || $j == 0) {
				if ($data2 [$j] ['d' . $i] != '-') {
					if (isset ( $atotal2 ['AQ'] ))
						$atotal2 ['AQ'] = $atotal2 ['AQ'] + 0.5;
					else
						$atotal2 ['AQ'] = 0.5;
				}
			}
			$uid = $data2 [$j] ['uid'];
			switch ($data2 [$j] ['d' . $i]) {
				case 'S' :
					if (isset ( $atotal ['AJ' . $uid] ))
						$atotal ['AJ' . $uid] = $atotal ['AJ' . $uid] + 0.5;
					else
						$atotal ['AJ' . $uid] = 0.5;
					break;
				case 'B' :
					if (isset ( $atotal ['AI' . $uid] ))
						$atotal ['AI' . $uid] = $atotal ['AI' . $uid] + 0.5;
					else
						$atotal ['AI' . $uid] = 0.5;
					break;
				case 'D' :
					if (isset ( $atotal ['AH' . $uid] ))
						$atotal ['AH' . $uid] = $atotal ['AH' . $uid] + 0.5;
					else
						$atotal ['AH' . $uid] = 0.5;
					break;
				case 'W' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					if (isset ( $atotal ['O' . $uid] ))
						$atotal ['O' . $uid] = $atotal ['O' . $uid] + 0.5;
					else
						$atotal ['O' . $uid] = 0.5; // 增
					break;
				case 'SJ' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					break;
				case 'H' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					break;
				case 'J' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					break;
				case 'WD' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					if (isset ( $atotal ['O' . $uid] ))
						$atotal ['O' . $uid] = $atotal ['O' . $uid] + 0.5;
					else
						$atotal ['O' . $uid] = 0.5; // 改
					break;
				case 'BX' :
					if (isset ( $atotal ['AN' . $uid] ))
						$atotal ['AN' . $uid] = $atotal ['AN' . $uid] + 0.5;
					else
						$atotal ['AN' . $uid] = 0.5;
					if (isset ( $atotal ['O' . $uid] ))
						$atotal ['O' . $uid] = $atotal ['O' . $uid] + 0.5;
					else
						$atotal ['O' . $uid] = 0.5; // 改
					break;
				case 'K' :
					if (isset ( $atotal ['AK' . $uid] ))
						$atotal ['AK' . $uid] = $atotal ['AK' . $uid] + 0.5;
					else
						$atotal ['AK' . $uid] = 0.5;
					break;
				case 'CD' :
					if (isset ( $atotal ['AL' . $uid] ))
						$atotal ['AL' . $uid] = $atotal ['AL' . $uid] + 1;
					else
						$atotal ['AL' . $uid] = 1; // 改 //统计整月迟到数目
					break;
			}
			if ($i == $end) {
				if (isset ( $atotal ['AN' . $uid] ))
					$atotal2 ['AN' . $uid] = $atotal ['AN' . $uid];
				else
					$atotal2 ['AN' . $uid] = 0;
				if (isset ( $atotal ['AH' . $uid] ))
					$atotal2 ['AH' . $uid] = $atotal ['AH' . $uid];
				else
					$atotal2 ['AH' . $uid] = 0;
				if (isset ( $atotal ['AI' . $uid] ))
					$atotal2 ['AI' . $uid] = $atotal ['AI' . $uid];
				else
					$atotal2 ['AI' . $uid] = 0;
				if (isset ( $atotal ['AJ' . $uid] ))
					$atotal2 ['AJ' . $uid] = $atotal ['AJ' . $uid];
				else
					$atotal2 ['AJ' . $uid] = 0;
				if (isset ( $atotal ['AK' . $uid] ))
					$atotal2 ['AK' . $uid] = $atotal ['AK' . $uid];
				else
					$atotal2 ['AK' . $uid] = 0;
				if (isset ( $atotal ['O' . $uid] ))
					$atotal2 ['O' . $uid] = $atotal ['O' . $uid];
				else
					$atotal2 ['O' . $uid] = 0; // 改
						                           // 删
				$atotal2 ['AP' . $uid] = $atotal2 ['AJ' . $uid] + $atotal2 ['AI' . $uid] + $atotal2 ['AH' . $uid] + $atotal2 ['AN' . $uid] + $atotal2 ['AK' . $uid] - $atotal2 ['O' . $uid]; // 改
			}
		}
	}
	$t ['atotal2'] = $atotal2;
	$t ['atotal'] = $atotal;
	return $t;
}

// 转换成旧格式并存在旧表中
function changeOld($now = 0) {
	if ($now != 0)
		$time = $now;
	else
		$time = $_GET ['time_code'];
	if ($time) {
		$data = get_data ( "SELECT * FROM user_attendance_new  WHERE time_code='" . $time . "'" ); // 从新表获取数据
		
		for($i = 0; $i < count ( $data ); $i ++) { // 转化成旧规则
			for($j = 1; $j <= 31; $j ++) {
				$s = explode ( ".", $data [$i] ['d' . $j] );
				if ($s [1] % 10 == 0)
					$s [1] = $s [1] / 10;
				if ($s [1] == 5 || $s [1] == 6 || $s [1] == 11 || $s [1] == 12) // 增
					$s [1] = 1; // 增
				if ($s [0] == 5 || $s [0] == 6 || $s [0] == 11 || $s [0] == 12) // 增
					$s [0] = 1; // 增
				if ($s [0] != $s [1])
					$data [$i] ['d' . $j] = 0.5;
				else if ($s [0] == 1 && $s [1] == 1)
					$data [$i] ['d' . $j] = 1.0;
				else
					$data [$i] ['d' . $j] = - 1.0;
			}
			
			if (date ( 'Ym' ) - $time == 0)
				$day_now = date ( 'd' );
			else if (date ( 'Ym' ) - $time > 0)
				$day_now = 31;
			else if (date ( 'Ym' ) - $time < 0)
				$day_now = 0;
			
			$sql = "update user_attendance set ";
			for($j = 1; $j <= $day_now; $j ++) {
				if ($day_now != $j)
					$sql = $sql . "`d" . $j . "`=" . $data [$i] ['d' . $j] . ",";
				else
					$sql = $sql . "`d" . $j . "`=" . $data [$i] ['d' . $j];
			}
			$sql = $sql . " WHERE `uid`=" . $data [$i] ['uid'] . " and time_code='" . $data [$i] ['time_code'] . "'";
			
			try {
				// run_sql("update user_attendance set `d1`= ". $data[$i]['d1']. ",`d2`= ". $data[$i]['d2']. ",`d3`= ".$data[$i]['d3']. ",`d4`= ". $data[$i]['d4']
				// . ",`d5`= ". $data[$i]['d5']. ",`d6`= ". $data[$i]['d6']. ",`d7`= ". $data[$i]['d7']. ",`d8`= ". $data[$i]['d8']. ",`d9`= ". $data[$i]['d9']. ",`d10`= ". $data[$i]['d10']
				// . ",`d11`= ". $data[$i]['d11']. ",`d12`= ".$data[$i]['d12']. ",`d13`= ".$data[$i]['d13']. ",`d14`= ". $data[$i]['d14']. ",`d15`= ".$data[$i]['d15']. ",`d16`= ". $data[$i]['d16']
				// . ",`d17`= ".$data[$i]['d17']. ",`d18`= ".$data[$i]['d18']. ",`d19`= ". $data[$i]['d19']. ",`d20`= ".$data[$i]['d20']. ",`d21`= ". $data[$i]['d21']. ",`d22`= ". $data[$i]['d22']
				// . ",`d23`= ". $data[$i]['d23']. ",`d24`= ".$data[$i]['d24']. ",`d25`= ". $data[$i]['d25'] . ",`d26`= ". $data[$i]['d26']. ",`d27`= ".$data[$i]['d27']. ",`d28`= ". $data[$i]['d28']
				// . ",`d29`= ".$data[$i]['d29']. ",`d30`= ". $data[$i]['d30']. ",`d31`= ". $data[$i]['d31'] ." WHERE `uid`=". $data[$i]['uid']." and time_code='".$data[$i]['time_code']."'" );
				run_sql ( $sql );
			} catch ( Exception $e ) {
			}
		}
	}
}

// 将旧数据转换成新格式
function changeNew($data, $time, $day) {
	switch ($data) {
		case - 1.0 :
			{
				$count = get_data ( "SELECT count(1) FROM user_attendance WHERE d" . $day . "='-1.0' and `time_code`='" . $time . "'" );
				if ($count [0] ['count(1)'] >= 10)
					return 4.4;
				else
					return 0.0;
			}
		case 0.5 :
			return 1.0;
		case 1.0 :
			return 1.1;
		case 0.0 :
			return 1.1;
		default :
			return 1.1;
	}
}

// 获取数据,并进行统计
function getCountData($time_code) {
	$data ['dataRows'] = getMonthData ( $time_code ); // 转换成显示格式
	$data1 = $data ['dataRows'];
	
	if (($time_code - 1) % 100 != 0) // 判断是否跨年，读取上个月数据，关于考核周期统计
		$data2 = getMonthData ( $time_code - 1, 0 );
	else
		$data2 = getMonthData ( (substr ( $time_code, 0, 4 ) - 1) . "12", 0 );
	
	$now = lastMonth ( $data1, 0 );
	$last = lastMonth ( $data2, 1 );
	for($j = 0; $j < count ( $data ['dataRows'] ); $j ++) { // 获取上个月的统计数据.因为要计算周期考核
		$uid = $data1 [$j] ['uid'];
		if ($j % 2 == 0) {
			if (isset ( $now ['atotal'] ['AJ' . $uid] ))
				$data ['dataRows'] [$j] ['S'] = $now ['atotal'] ['AJ' . $uid];
			else
				$data ['dataRows'] [$j] ['S'] = 0;
			if (isset ( $now ['atotal'] ['AI' . $uid] ))
				$data ['dataRows'] [$j] ['B'] = $now ['atotal'] ['AI' . $uid];
			else
				$data ['dataRows'] [$j] ['B'] = 0;
			if (isset ( $now ['atotal'] ['AH' . $uid] ))
				$data ['dataRows'] [$j] ['D'] = $now ['atotal'] ['AH' . $uid];
			else
				$data ['dataRows'] [$j] ['D'] = 0;
			if (isset ( $now ['atotal'] ['AN' . $uid] ))
				$data ['dataRows'] [$j] ['O'] = $now ['atotal'] ['AN' . $uid];
			else
				$data ['dataRows'] [$j] ['O'] = 0;
			if (isset ( $now ['atotal'] ['AL' . $uid] ))
				$data ['dataRows'] [$j] ['CD'] = $now ['atotal'] ['AL' . $uid];
			else
				$data ['dataRows'] [$j] ['CD'] = 0;
			if (isset ( $now ['atotal'] ['AK' . $uid] ))
				$data ['dataRows'] [$j] ['K'] = $now ['atotal'] ['AK' . $uid];
			else
				$data ['dataRows'] [$j] ['K'] = 0;
			$data ['dataRows'] [$j] ['TO'] = $now ['atotal2'] ['AP' . $uid] + $last ['atotal2'] ['AP' . $uid];
		} else {
			$data ['dataRows'] [$j] ['S'] = "";
			$data ['dataRows'] [$j] ['B'] = "";
			$data ['dataRows'] [$j] ['D'] = "";
			$data ['dataRows'] [$j] ['O'] = "";
			$data ['dataRows'] [$j] ['CD'] = "";
			$data ['dataRows'] [$j] ['TO'] = "";
			$data ['dataRows'] [$j] ['K'] = "";
		}
	}
	
	return $data ['dataRows'];
}

// 获取考勤信息
function get_user_attendance_by_uid($uid, $timeCode1, $timeCode2) {
	// 返回值
	// data[0]:当前实际工作日
	// data[1]:理论工作日
	// data[2]:月度评分
	// data[3]:月度评价
	$data = array ();
	// 理论工作日
	$all_work_hours = 0;
	// 当前实际工作日
	$want_work_hours = 0;
	// 上个月考勤信息
	$data1 = get_line ( "SELECT *  from user_attendance_new WHERE uid = '" . intval ( $uid ) . "' AND time_code  = '" . intval ( $timeCode2 ) . "' ", db () );
	// 这个月考勤信息
	$data2 = get_line ( "SELECT  *  from user_attendance_new  WHERE uid = '" . intval ( $uid ) . "' AND time_code  = '" . intval ( $timeCode1 ) . "' ", db () );
	$offset = get_date_offset ();
	$now = date ( 'Ym' );
	// 统计上个月26号到月底的工时
	if ($data1 ['time_code'] > 0) {
		foreach ( $data1 as $key => $value ) {
			if (preg_match ( '/^d(2[6-9]|3[0-1])$/', $key )) {
				if ($value > 0 && $value != 4.4) {
					$s = sprintf ( '%05.2f', $value );
					$array_value = explode ( '.', $s );
					if ($array_value [0] == 1 || $array_value [0] == 6 || $array_value [0] == 11) {
						$all_work_hours += 0.5;
					}
					if ($array_value [1] == 10 || $array_value [1] == 60 || $array_value [1] == 11) {
						$all_work_hours += 0.5;
					}
					if ($now === $timeCode1) {
						if ($offset > 0) {
							$want_work_hours = $all_work_hours;
						}
					} else {
						$want_work_hours = $all_work_hours;
					}
				}
				$offset --;
			}
		}
	}
	// 统计这个月1号到25号的工时
	if ($data2 ['time_code'] > 0) {
		foreach ( $data2 as $key => $value ) {
			if (preg_match ( '/^d([1-9]|1[0-9]|2[0-5])$/', $key )) {
				if ($value > 0 && $value != 4.4) {
					$s = sprintf ( '%05.2f', $value );
					$array_value = explode ( '.', $s );
					if ($array_value [0] == 1 || $array_value [0] == 6 || $array_value [0] == 11) {
						$all_work_hours += 0.5;
					}
					if ($array_value [1] == 10 || $array_value [1] == 60 || $array_value [1] == 11) {
						$all_work_hours += 0.5;
					}
					if ($now === $timeCode1) {
						if ($offset > 0) {
							$want_work_hours = $all_work_hours;
						}
					} else {
						$want_work_hours = $all_work_hours;
					}
				}
				$offset --;
			}
		}
	}
	if(date ( 'Ym' )<$timeCode1)
	return $data;
	$data [0] = $want_work_hours;
	$data [1] = $all_work_hours;
	if ($data2 ['score'] > 0) {
		$data [2] = $data2 ['score'];
	}
	$data [3] = $data2 ['month_comment'];
	
	return $data;
}

// 计算当前日期到当前考核周期开始日的天数差
function get_date_offset() {
	$day = date ( 'd' );
	$month = date ( 'm' );
	$year = date ( 'Y' );
	if ($day > 25) {
		return 31; // 当前日期超过25号时考核进入考核期，实际工作日和理论工作日相同（查询的周期已经是上个月的了）
	} else {
		return 6 + $day;
	}
	
}