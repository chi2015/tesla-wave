<?php
/***************************************************************************\
| Sypex Dumper Lite         version 1.0.7                                   |
| (c)2003-2006 zapimir      zapimir@zapimir.net       http://sypex.net/     |
|---------------------------------------------------------------------------|
|     created: 2003.09.02 19:07              modified: 2006.03.01 16:59     |
|---------------------------------------------------------------------------|
| This program is free software; you can redistribute it and/or             |
| modify it under the terms of the GNU General Public License               |
| as published by the Free Software Foundation; either version 2            |
| of the License, or (at your option) any later version.                    |
|                                                                           |
| This program is distributed in the hope that it will be useful,           |
| but WITHOUT ANY WARRANTY; without even the implied warranty of            |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             |
| GNU General Public License for more details.                              |
|                                                                           |
| You should have received a copy of the GNU General Public License         |
| along with this program; if not, write to the Free Software               |
| Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307,USA. |
\***************************************************************************/

// ���� � URL � ������ ������
define('PATHDAMP', 'backup/');
define('URL',  'backup/');
// ������������ ����� ���������� ������� � ��������
// 0 - ��� �����������
//define('TIME_LIMIT', 600);
// ����������� ������� ������ ����������� �� ���� ��������� � �� (� ����������)
// ����� ��� ����������� ���������� ������ ���������� �������� ��� ����� ����� �������� ������
define('LIMIT', 1);
// mysql ������
define('DBHOST', 'localhost:3306');
// ���� ������, ���� ������ �� ��������� ������������� ������ ��� ������,
// � ������ �� ������������ ����� �����������. ����������� �������� ����� �������
define('DBNAMES', $dbase);
// ��������� ������ ���� ������
define('CHARSET', 'cp1251');
// �������� ���������� �������� � ��������� ��������
// ��� ���������� ���������� �������� 0
define('SC', 0);
// ���������� ����������
// ��� ���������� ���������� �������� 0
define('GS', 0);

// ��������� ����
if(function_exists('date_default_timezone_set'))
date_default_timezone_set('Europe/Moscow');

// ������ ������ ������������� �� �����
$is_safe_mode = ini_get('safe_mode') == '1' ? 1 : 0;
if (!$is_safe_mode) set_time_limit(TIME_LIMIT);

header("Expires: Tue, 1 Jul 2003 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

$timer = array_sum(explode(' ', microtime()));
ob_implicit_flush();
error_reporting(E_ALL);

$auth = 1;
$error = '';

// ������������
$_classPath="../../";
include($_classPath."class/obj.class.php");
PHPShopObj::loadClass("base");

$PHPShopBase = new PHPShopBase($_classPath."inc/config.ini");
$PHPShopBase->chekAdmin();

$host=$SysValue['connect']['host'];             
$user_db=$SysValue['connect']['user_db'];       
$pass_db=$SysValue['connect']['pass_db'];       
$dbase=$SysValue['connect']['dbase'];           


if (!file_exists(PATHDAMP) && !$is_safe_mode) {
    mkdir(PATHDAMP, 0777) || die("�� ������� ������� ������� ��� ������");
}

$SK = new dumper($dbase);
define('C_DEFAULT', 1);
define('C_RESULT', 2);
define('C_ERROR', 3);
mysql_query("/*!40101 SET NAMES '" . CHARSET . "' */") or die("Invalid query: " . mysql_error());
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

switch($action){
	case 'backup':
	if($UserChek->statusPHPSHOP == 0){
		$SK->backup();
		}else{ $UserChek->BadUserFormaWindow();
		$SK->main();}
		break;
	case 'restore':
	if($UserChek->statusPHPSHOP == 0){
		$SK->restore();
		}else{ $UserChek->BadUserFormaWindow();
		$SK->main();}
		break;
	default:
		$SK->main();
}

mysql_close();

echo "<SCRIPT>document.getElementById('timer').innerHTML = '" . round(array_sum(explode(' ', microtime())) - $timer, 4) . " ���.'</SCRIPT>";

class dumper {
    var $dbase;
	function dumper($dbase) {
	
	    $this->dbase=$dbase;
		if (file_exists(PATHDAMP . "dumper.cfg.php")) {
		    include(PATHDAMP . "dumper.cfg.php");
		}
		else{
			$this->SET['last_action'] = 0;
			$this->SET['last_db_backup'] = '';
			$this->SET['tables'] = '';
			$this->SET['comp_method'] = 2;
			$this->SET['comp_level']  = 7;
			$this->SET['last_db_restore'] = '';
		}
		$this->tabs = 0;
		$this->records = 0;
		$this->size = 0;
		$this->comp = 0;
	}

	function backup() {
		if (!isset($_POST)) {$this->main();}
		set_error_handler("SXD_errorHandler");
		$buttons = "<A ID=save HREF='' STYLE='display: none;' title=\"_blank\">������� ����</A> &nbsp; <INPUT ID=back TYPE=button  VALUE='���������' DISABLED onClick=\"history.back();\" class=but>
<INPUT TYPE=button VALUE='�������' onClick=\"return onCancel();\" class=but >
";
		echo tpl_page(tpl_process("��������� ��������� ����� ��"), $buttons);

		$this->SET['last_action']     = 0;
		$this->SET['last_db_backup']  = isset($_POST['db_backup']) ? $_POST['db_backup'] : '';
		$this->SET['tables_exclude']  = !empty($_POST['tables']) && $_POST['tables']{0} == '^' ? 1 : 0;
		$this->SET['tables']          = isset($_POST['tables']) ? $_POST['tables'] : '';
		$this->SET['comp_method']     = isset($_POST['comp_method']) ? intval($_POST['comp_method']) : 0;
		$this->SET['comp_level']      = isset($_POST['comp_level']) ? intval($_POST['comp_level']) : 0;
		$this->fn_save();

		$this->SET['tables']          = explode(",", $this->SET['tables']);
		if (!empty($_POST['tables'])) {
		    foreach($this->SET['tables'] AS $table){
    			$table = preg_replace("/[^\w*?^]/", "", $table);
				$pattern = array( "/\?/", "/\*/");
				$replace = array( ".", ".*?");
				$tbls[] = preg_replace($pattern, $replace, $table);
    		}
		}
		else{
			$this->SET['tables_exclude'] = 1;
		}

		if ($this->SET['comp_level'] == 0) {
		    $this->SET['comp_method'] = 0;
		}
		$db = $this->SET['last_db_backup'];

		if (!$db) {
			echo tpl_l("������! �� ������� ���� ������!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("����������� � �� `{$db}`.");
		mysql_select_db($db) or trigger_error ("�� ������� ������� ���� ������.<BR>" . mysql_error(), E_USER_ERROR);
		$tables = array();
        $result = mysql_query("SHOW TABLES");
		$all = 0;
        while($row = mysql_fetch_array($result)) {
			$status = 0;
			if (!empty($tbls)) {
			    foreach($tbls AS $table){
    				$exclude = preg_match("/^\^/", $table) ? true : false;
    				if (!$exclude) {
    					if (preg_match("/^{$table}$/i", $row[0])) {
    					    $status = 1;
    					}
    					$all = 1;
    				}
    				if ($exclude && preg_match("/{$table}$/i", $row[0])) {
    				    $status = -1;
    				}
    			}
			}
			else {
				$status = 1;
			}
			if ($status >= $all) {
    			$tables[] = $row[0];
    		}
        }

		$tabs = count($tables);
		// ����������� �������� ������
		$result = mysql_query("SHOW TABLE STATUS");
		$tabinfo = array();
		$tabinfo[0] = 0;
		$info = '';
		while($item = mysql_fetch_assoc($result)){
			if(in_array($item['Name'], $tables)) {
				$item['Rows'] = empty($item['Rows']) ? 0 : $item['Rows'];
				$tabinfo[0] += $item['Rows'];
				$tabinfo[$item['Name']] = $item['Rows'];
				$this->size += $item['Data_length'];
				$tabsize[$item['Name']] = 1 + round(LIMIT * 1048576 / ($item['Avg_row_length'] + 1));
				if($item['Rows']) $info .= "|" . $item['Rows'];
			}
		}
		$show = 10 + $tabinfo[0] / 50;
		$info = $tabinfo[0] . $info;
		$name = $db . '_' . date("Y-m-d_H-i_").substr(uniqid(md5(date("U"))),0,8);
        $fp = $this->fn_open($name, "w");
		echo tpl_l("�������� ����� � ��������� ������ ��:<BR>\\n  -  {$this->filename}");
		$this->fn_write($fp, "#SKD101|{$db}|{$tabs}|" . date("Y.m.d H:i:s") ."|{$info}\n\n");
		$t=0;
		echo tpl_l(str_repeat("-", 60));
		$result = mysql_query("SET SQL_QUOTE_SHOW_CREATE = 1");
        foreach ($tables AS $table){
        	echo tpl_l("��������� ������� `{$table}` [" . fn_int($tabinfo[$table]) . "].");

        	// �������� �������
			$result = mysql_query("SHOW CREATE TABLE {$table}");
        	$tab = mysql_fetch_array($result);
			$tab = preg_replace('/(default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP|DEFAULT CHARSET=\w+|COLLATE=\w+|character set \w+|collate \w+)/i', '/*!40101 \\1 */', $tab);
        	$this->fn_write($fp, "DROP TABLE IF EXISTS {$table};\n{$tab[1]};\n\n");
        	// ������������ ���� ��������
            $NumericColumn = array();
            $result = mysql_query("SHOW COLUMNS FROM {$table}");
            $field = 0;
            while($col = mysql_fetch_row($result)) {
            	$NumericColumn[$field++] = preg_match("/^(\w*int|year)/", $col[1]) ? 1 : 0;
            }
			$fields = $field;
            $from = 0;
			$limit = $tabsize[$table];
			$limit2 = round($limit / 3);
			if ($tabinfo[$table] > 0) {
			if ($tabinfo[$table] > $limit2) {
			    echo tpl_s(0, $t / $tabinfo[0]);
			}
			$i = 0;
			$this->fn_write($fp, "INSERT INTO `{$table}` VALUES");
            while(($result = mysql_query("SELECT * FROM {$table} LIMIT {$from}, {$limit}")) && ($total = mysql_num_rows($result))){
            		while($row = mysql_fetch_row($result)) {
                    	$i++;
    					$t++;

						for($k = 0; $k < $fields; $k++){
                    		if ($NumericColumn[$k])
                    		    $row[$k] = isset($row[$k]) ? $row[$k] : "NULL";
                    		else
                    			$row[$k] = isset($row[$k]) ? "'" . mysql_escape_string($row[$k]) . "'" : "NULL";
                    	}

    					$this->fn_write($fp, ($i == 1 ? "" : ",") . "\n(" . implode(", ", $row) . ")");
    					if ($i % $limit2 == 0)
    						echo tpl_s($i / $tabinfo[$table], $t / $tabinfo[0]);
               		}
					mysql_free_result($result);
					if ($total < $limit) {
					    break;
					}
    				$from += $limit;
            }

			$this->fn_write($fp, ";\n\n");
    		echo tpl_s(1, $t / $tabinfo[0]);}
		}
		$this->tabs = $tabs;
		$this->records = $tabinfo[0];
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
        echo tpl_s(1, 1);
        echo tpl_l(str_repeat("-", 60));
        $this->fn_close($fp);
		echo tpl_l("��������� ����� �� `{$db}` �������.", C_RESULT);
		echo tpl_l("������ ��:       " . round($this->size / 1048576, 2) . " ��", C_RESULT);
		$filesize = round(filesize(PATHDAMP . $this->filename) / 1048576, 2) . " ��";
		echo tpl_l("������ �����: {$filesize}", C_RESULT);
		echo tpl_l("������ ����������: {$tabs}", C_RESULT);
		echo tpl_l("����� ����������:   " . fn_int($tabinfo[0]), C_RESULT);
		echo "<SCRIPT>with (document.getElementById('save')) {style.display = ''; innerHTML = '������� ���� ({$filesize})'; href = 'backup/download.php?backup=". $this->filename . "'; target='_blank'; }document.getElementById('back').disabled = 0;</SCRIPT>";
		

	}

	function restore(){
		if (!isset($_POST)) {$this->main();}
		set_error_handler("SXD_errorHandler");
		$buttons = "<INPUT ID=back TYPE=button VALUE='���������' DISABLED onClick=\"history.back();\" class=but>
<INPUT TYPE=button VALUE='�������' onClick=\"window.close();\" class=but>";
		echo tpl_page(tpl_process("�������������� �� �� ��������� �����"), $buttons);

		$this->SET['last_action']     = 1;
		$this->SET['last_db_restore'] = isset($_POST['db_restore']) ? $_POST['db_restore'] : '';
		$file						  = isset($_POST['file']) ? $_POST['file'] : '';
		$this->fn_save();
		$db = $this->SET['last_db_restore'];

		if (!$db) {
			echo tpl_l("������! �� ������� ���� ������!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l("����������� � �� `{$db}`.");
		mysql_select_db($db) or trigger_error ("�� ������� ������� ���� ������.<BR>" . mysql_error(), E_USER_ERROR);

		preg_match("/^(\d+)\.(\d+)\.(\d+)/", mysql_get_server_info(), $m);
		$this->mysql_version = sprintf("%d%02d%02d", $m[1], $m[2], $m[3]);
		// ����������� ������� �����
		if(preg_match("/^(.+?)\.sql(\.(bz2|gz))?$/", $file, $matches)) {
			if (isset($matches[3]) && $matches[3] == 'bz2') {
			    $this->SET['comp_method'] = 2;
			}
			elseif (isset($matches[2]) &&$matches[3] == 'gz'){
				$this->SET['comp_method'] = 1;
			}
			else{
				$this->SET['comp_method'] = 0;
			}
			$this->SET['comp_level'] = '';
			if (!file_exists(PATHDAMP . "/{$file}")) {
    		    echo tpl_l("������! ���� �� ������!", C_ERROR);
				echo tpl_enableBack();
    		    exit;
    		}
			echo tpl_l("������ ����� `{$file}`.");
			$file = $matches[1];
		}
		else{
			echo tpl_l("������! �� ������ ����!", C_ERROR);
			echo tpl_enableBack();
		    exit;
		}
		echo tpl_l(str_repeat("-", 60));
		$fp = $this->fn_open($file, "r");
		$this->file_cache = $sql = $table = $insert = '';
        $is_skd = $query_len = $execute = $q =$t = $i = $aff_rows = 0;
		$limit = 300;
        $index = 4;
		$tabs = 0;
		$cache = '';
		$info = array();
		while(($str = $this->fn_read_str($fp)) !== false){
			if (empty($str) || preg_match("/^(#|--)/", $str)) {
				if (!$is_skd && preg_match("/^#SKD101\|/", $str)) {
				    $info = explode("|", $str);
					echo tpl_s(0, $t / $info[4]);
					$is_skd = 1;
				}
        	    continue;
        	}
			$query_len += strlen($str);

			if (!$insert && preg_match("/^(INSERT INTO `?([^` ]+)`? .*?VALUES)(.*)$/i", $str, $m)) {
				if ($table != $m[2]) {
				    $table = $m[2];
					$tabs++;
					echo tpl_l("������� `{$table}`.");
					$i = 0;
					if ($is_skd)
					    echo tpl_s(100 , $t / $info[4]);
				}
        	    $insert = $m[1] . ' ';
				$sql .= $m[3];
				$index++;
				$info[$index] = isset($info[$index]) ? $info[$index] : 0;
				$limit = round($info[$index] / 20);
				$limit = $limit < 300 ? 300 : $limit;
				if ($info[$index] > $limit){
					echo $cache;
					$cache = '';
					echo tpl_s(0 / $info[$index], $t / $info[4]);
				}
        	}
			else{
        		$sql .= $str;
				if ($insert) {
				    $i++;
    				$t++;
    				if ($is_skd && $info[$index] > $limit && $t % $limit == 0){
    					echo tpl_s($i / $info[$index], $t / $info[4]);
    				}
				}
        	}

			if (!$insert && preg_match("/^CREATE TABLE (IF NOT EXISTS )?`?([^` ]+)`?/i", $str, $m) && $table != $m[2]){
				$table = $m[2];
				$insert = '';
				$tabs++;
				$cache .= tpl_l("������� `{$table}`.");
				$i = 0;
			}
			if ($sql) {
			    if (preg_match("/;$/", $str)) {
            		$sql = rtrim($insert . $sql, ";");
					if (empty($insert)) {
						if ($this->mysql_version < 40101) {
				    		$sql = preg_replace("/ENGINE\s?=/", "TYPE=", $sql);
						}
					}
            		$insert = '';
            	    $execute = 1;
            	}
            	if ($query_len >= 65536 && preg_match("/,$/", $str)) {
            		$sql = rtrim($insert . $sql, ",");
            	    $execute = 1;
            	}
    			if ($execute) {
            		$q++;
            		mysql_query($sql) or trigger_error ("������������ ������.<BR>" . mysql_error(), E_USER_ERROR);
					if (preg_match("/^insert/i", $sql)) {
            		    $aff_rows += mysql_affected_rows();
            		}
            		$sql = '';
            		$query_len = 0;
            		$execute = 0;
            	}
			}
		}
		echo $cache;
		echo tpl_s(1 , 1);
		echo tpl_l(str_repeat("-", 60));
		echo tpl_l("�� ������������� �� ��������� �����.", C_RESULT);
		if (isset($info[3])) echo tpl_l("���� �������� �����: {$info[3]}", C_RESULT);
		echo tpl_l("�������� � ��: {$q}", C_RESULT);
		echo tpl_l("������ �������: {$tabs}", C_RESULT);
		echo tpl_l("����� ���������: {$aff_rows}", C_RESULT);

		$this->tabs = $tabs;
		$this->records = $aff_rows;
		$this->size = filesize(PATHDAMP . $this->filename);
		$this->comp = $this->SET['comp_method'] * 10 + $this->SET['comp_level'];
		echo "<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>";
		// �������� ������ ��� ���������� ����������
		if (GS) echo "<SCRIPT>document.getElementById('GS').src = 'http://sypex.net/gs.php?r={$this->tabs},{$this->records},{$this->size},{$this->comp},107';</SCRIPT>";

		$this->fn_close($fp);
	}

	function main(){
		$this->comp_levels = array('9' => '9 (������������)', '8' => '8', '7' => '7', '6' => '6', '5' => '5 (�������)', '4' => '4', '3' => '3', '2' => '2', '1' => '1 (�����������)','0' => '��� ������');

		if (function_exists("gzopen")) {
		    $this->comp_methods[1] = 'GZip';
		}
		$this->comp_methods[0] = '��� ������';
		if (count($this->comp_methods) == 1) {
		    $this->comp_levels = array('0' =>'��� ������');
		}

		$dbs = $this->db_select();
		$this->vars['db_backup']    = $this->fn_select($dbs, $this->SET['last_db_backup']);
		$this->vars['db_restore']   = $this->fn_select($dbs, $this->SET['last_db_restore']);
		$this->vars['comp_levels']  = $this->fn_select($this->comp_levels, $this->SET['comp_level']);
		$this->vars['comp_methods'] = $this->fn_select($this->comp_methods, $this->SET['comp_method']);
		$this->vars['tables']       = $this->SET['tables'];
		$this->vars['files']        = $this->fn_select($this->file_select(), '');
		$buttons = "
		
		<INPUT TYPE=submit VALUE=�� class=but>
		<INPUT TYPE=button VALUE=������ onClick=\"return onCancel();\" class=but name=btnLang>";
		echo tpl_page(tpl_main(), $buttons);
	}

	function db_select(){
	/*
		if (DBNAMES != '') {
			$items = explode(',', trim(DBNAMES));
			foreach($items AS $item){
    			if (mysql_select_db($item)) {
    				$tables = mysql_query("SHOW TABLES");
    				if ($tables) {
    	  			    $tabs = mysql_num_rows($tables);
    	  				$dbs[$item] = "{$item} ({$tabs})";
    	  			}
    			}
			}
		}
		else {
    		$result = mysql_query("SHOW DATABASES");
    		$dbs = array();
    		while($item = mysql_fetch_array($result)){
    			if (mysql_select_db($item[0])) {
    				$tables = mysql_query("SHOW TABLES");
    				if ($tables) {
    	  			    $tabs = mysql_num_rows($tables);
    	  				$dbs[$item[0]] = "{$item[0]} ({$tabs})";
    	  			}
    			}
    		}
		}
		*/
		$dbs[$this->dbase]=$this->dbase;
	    return $dbs;
	}

	function file_select(){
		$files = array('');
		if (is_dir(PATHDAMP) && $handle = opendir(PATHDAMP)) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match("/^.+?\.sql(\.(gz|bz2))?$/", $file)) {
                    $files[$file] = $file;
                }
            }
            closedir($handle);
        }
		return $files;
	}

	function fn_open($name, $mode){
		if ($this->SET['comp_method'] == 2) {
			$this->filename = "{$name}.sql.bz2";
		    return bzopen(PATHDAMP . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		elseif ($this->SET['comp_method'] == 1) {
			$this->filename = "{$name}.sql.gz";
		    return gzopen(PATHDAMP . $this->filename, "{$mode}b{$this->SET['comp_level']}");
		}
		else{
			$this->filename = "{$name}.sql";
			return fopen(PATHDAMP . $this->filename, "{$mode}b");
		}
	}

	function fn_write($fp, $str){
		if ($this->SET['comp_method'] == 2) {
		    bzwrite($fp, $str);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzwrite($fp, $str);
		}
		else{
			fwrite($fp, $str);
		}
	}

	function fn_read($fp){
		if ($this->SET['comp_method'] == 2) {
		    return bzread($fp, 4096);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    return gzread($fp, 4096);
		}
		else{
			return fread($fp, 4096);
		}
	}

	function fn_read_str($fp){
		$string = '';
		$this->file_cache = ltrim($this->file_cache);
		$pos = strpos($this->file_cache, "\n", 0);
		if ($pos < 1) {
			while (!$string && ($str = $this->fn_read($fp))){
    			$pos = strpos($str, "\n", 0);
    			if ($pos === false) {
    			    $this->file_cache .= $str;
    			}
    			else{
    				$string = $this->file_cache . substr($str, 0, $pos);
    				$this->file_cache = substr($str, $pos + 1);
    			}
    		}
			if (!$str) {
			    if ($this->file_cache) {
					$string = $this->file_cache;
					$this->file_cache = '';
				    return trim($string);
				}
			    return false;
			}
		}
		else {
  			$string = substr($this->file_cache, 0, $pos);
  			$this->file_cache = substr($this->file_cache, $pos + 1);
		}
		return trim($string);
	}

	function fn_close($fp){
		if ($this->SET['comp_method'] == 2) {
		    bzclose($fp);
		}
		elseif ($this->SET['comp_method'] == 1) {
		    gzclose($fp);
		}
		else{
			fclose($fp);
		}
		@chmod(PATHDAMP . $this->filename, 0666);
		$this->fn_index();
	}

	function fn_select($items, $selected){
		$select = '';
		foreach($items AS $key => $value){
			$select .= $key == $selected ? "<OPTION VALUE='{$key}' SELECTED>{$value}" : "<OPTION VALUE='{$key}'>{$value}";
		}
		return $select;
	}

	function fn_save(){
		if (SC) {
			$ne = !file_exists(PATHDAMP . "dumper.cfg.php");
		    $fp = fopen(PATHDAMP . "dumper.cfg.php", "wb");
        	fwrite($fp, "<?php\n\$this->SET = " . fn_arr2str($this->SET) . "\n?>");
        	fclose($fp);
			if ($ne) @chmod(PATHDAMP . "dumper.cfg.php", 0666);
			$this->fn_index();
		}
	}

	function fn_index(){
		if (!file_exists(PATHDAMP . 'index.html')) {
		    $fh = fopen(PATHDAMP . 'index.html', 'wb');
			fwrite($fh, tpl_backup_index());
			fclose($fh);
			@chmod(PATHDAMP . 'index.html', 0666);
		}
	}
}

function fn_int($num){
	return number_format($num, 0, ',', ' ');
}

function fn_arr2str($array) {
	$str = "array(\n";
	foreach ($array as $key => $value) {
		if (is_array($value)) {
			$str .= "'$key' => " . fn_arr2str($value) . ",\n\n";
		}
		else {
			$str .= "'$key' => '" . str_replace("'", "\'", $value) . "',\n";
		}
	}
	return $str . ")";
}

// �������

function tpl_page($content = '', $buttons = ''){
global $Lang;




return <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<TITLE>������ � �����</TITLE>
<META HTTP-EQUIV=Content-Type CONTENT="text/html; charset=windows-1251">
<LINK href="../skins/{$_SESSION['theme']}/texts.css" type=text/css rel=stylesheet>
<script language="JavaScript1.2" src="../java/phpshop.js" type="text/javascript"></script>
<STYLE TYPE="TEXT/CSS">
<!--
body{
	overflow: auto;
}
select, div {
	font: 11px tahoma, verdana, arial;
}
input.text, select {
	width: 100%;
}
fieldset {
	margin-bottom: 10px;
}
-->
</STYLE>
<script>
function getInfo(){
var str = new String();
str = "�������\\n\\n� ������� ������ ����������� ����������� ������� �� ������� ���������� �������. � �������� ����� ������������ ��������� ����������� �������:������ � �������� ����� ���������� ��������.\\n\\n������ * � �������� ����� ���������� �������� \\n������ ? � �������� ���� ����� ������ \\n������ ^ � �������� ���������� �� ������ ������� ��� ������\\n\\n�������: \\n\\nib_* - ��� ������� ������������ � 'ib_' (��� ������� ������ invision board) \\nib_*, ^ib_sessions - ��� ������� ������������ � 'ib_', ����� 'ib_sessions' \\nib_s*s, ^ib_sessions - ��� ������� ������������ � 'ib_s' � ��������������� ������ 's', ����� 'ib_sessions' \\n^*s - ��� �������, ����� ������ ��������������� ������ 's' \\n^ib_???? - ��� �������, ����� ������, ������� ���������� � 'ib_' � �������� 4 ������� ����� ����� �������������";
confirm(str);
}
</script>

</HEAD>

<BODY bottommargin="0"  topmargin="0" leftmargin="0" rightmargin="0">
<table cellpadding="0" cellspacing="0" width="100%" height="50" id="title">
<tr bgcolor="#ffffff">
	<td style="padding:10">
	<b><span name=txtLang id=txtLang>������ � �����</span></b><br>
	&nbsp;&nbsp;&nbsp;<span name=txtLang id=txtLang>������� ������� ��</span>.
	</td>
	<td align="right">
	<img src="../img/i_databases_med[1].gif" border="0" hspace="10">
	</td>
</tr>
</table>
<br>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD style=padding:10>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD VALIGN=TOP>
<TABLE WIDTH=100% HEIGHT=100% BORDER=0 CELLSPACING=1 CELLPADDING=0>
<TR>
<FORM NAME=skb METHOD=POST ACTION=dumper.php>
<TD VALIGN=TOP>
{$content}
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD STYLE='color: #CECECE' ID=timer></TD>
<TD ALIGN=RIGHT>{$buttons}</TD>
</TR>
</TABLE></TD>
</FORM>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
</TD>
</TR>
</TABLE>
</BODY>
</HTML>
HTML;
}

function tpl_main(){
global $SK,$SysValue;
return <<<HTML
<FIELDSET onClick="document.skb.action[0].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=backup>
<span name=txtLang id=txtLang>�������� ��������� ����� ��</span>&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=5 CELLPADDING=2>
<TR>
<TD WIDTH=35%><span name=txtLang id=txtLang>��</span>:</TD>
<TD WIDTH=65%><SELECT NAME=db_backup>
{$SK->vars['db_backup']}
</SELECT></TD>
</TR>
<TR>
<TD><span name=txtLang id=txtLang>������ ������</span>:<img src="../img/btn_help[1].gif" alt="" border="0" onclick="getInfo()" align="absmiddle" hspace="5" style="cursor: pointer;"></TD>
<TD><INPUT NAME=tables TYPE=text CLASS=text VALUE='{$SK->vars['tables']}'></TD>
</TR>
<TR>
<TD><span name=txtLang id=txtLang>����� ������</span>:</TD>
<TD><SELECT NAME=comp_method>
{$SK->vars['comp_methods']}
</SELECT></TD>
</TR>
<TR>
<TD><span name=txtLang id=txtLang>������� ������</span>:</TD>
<TD><SELECT NAME=comp_level>
{$SK->vars['comp_levels']}
</SELECT></TD>
</TR>
</TABLE>
</FIELDSET>
<FIELDSET onClick="document.skb.action[1].checked = 1;">
<LEGEND>
<INPUT TYPE=radio NAME=action VALUE=restore>
<span name=txtLang id=txtLang>�������������� �� �� ��������� �����</span>&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=5 CELLPADDING=2>
<TR>
<TD><span name=txtLang id=txtLang>��</span>:</TD>
<TD><SELECT NAME=db_restore>
{$SK->vars['db_restore']}
</SELECT></TD>
</TR>
<TR>
<TD WIDTH=35%><span name=txtLang id=txtLang>����</span>:</TD>
<TD WIDTH=65%><SELECT NAME=file>
{$SK->vars['files']}
</SELECT></TD>
</TR>
</TABLE>
</FIELDSET>
</SPAN>
<div style="padding-top:30"><hr></div>
<SCRIPT>
document.skb.action[{$SK->SET['last_action']}].checked = 1;
</SCRIPT>

HTML;
}

function tpl_process($title){
return <<<HTML
<FIELDSET>
<LEGEND>{$title}&nbsp;</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR><TD COLSPAN=2><DIV ID=logarea STYLE="width: 100%; height: 220px; border: 0px solid #7F9DB9; padding: 3px; overflow: auto;"></DIV></TD></TR>
<TR><TD WIDTH=31%>������ �������:</TD><TD WIDTH=69%><TABLE WIDTH=100% BORDER=1 CELLPADDING=0 CELLSPACING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#5555CC ID=st_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCCCFF,endColorStr=#5555CC);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD></TR></TABLE></TD></TR>
<TR><TD>����� ������:</TD><TD><TABLE WIDTH=100% BORDER=1 CELLSPACING=0 CELLPADDING=0>
<TR><TD BGCOLOR=#FFFFFF><TABLE WIDTH=1 BORDER=0 CELLPADDING=0 CELLSPACING=0 BGCOLOR=#00AA00 ID=so_tab
STYLE="FILTER: progid:DXImageTransform.Microsoft.Gradient(gradientType=0,startColorStr=#CCFFCC,endColorStr=#00AA00);
border-right: 1px solid #AAAAAA"><TR><TD HEIGHT=12></TD></TR></TABLE></TD>
</TR></TABLE></TD></TR></TABLE>
</FIELDSET>
<div style="padding-top:0px"><hr></div>
<SCRIPT>
var WidthLocked = false;
function s(st, so){
	document.getElementById('st_tab').width = st ? st + '%' : '1';
	document.getElementById('so_tab').width = so ? so + '%' : '1';
}
function l(str, color){
	switch(color){
		case 2: color = 'navy'; break;
		case 3: color = 'red'; break;
		default: color = 'black';
	}
	with(document.getElementById('logarea')){
		if (!WidthLocked){
			style.width = clientWidth;
			WidthLocked = true;
		}
		str = '<FONT COLOR=' + color + '>' + str + '</FONT>';
		innerHTML += innerHTML ? "<BR>\\n" + str : str;
		scrollTop += 14;
	}
}
</SCRIPT>
HTML;
}


function tpl_l($str, $color = C_DEFAULT){
$str = preg_replace("/\s{2}/", " &nbsp;", $str);
return <<<HTML
<SCRIPT>l('{$str}', $color);</SCRIPT>

HTML;
}

function tpl_enableBack(){
return <<<HTML
<SCRIPT>document.getElementById('back').disabled = 0;</SCRIPT>

HTML;
}

function tpl_s($st, $so){
$st = round($st * 100);
$st = $st > 100 ? 100 : $st;
$so = round($so * 100);
$so = $so > 100 ? 100 : $so;
return <<<HTML
<SCRIPT>s({$st},{$so});</SCRIPT>

HTML;
}

function tpl_backup_index(){
return <<<HTML
<CENTER>
<H1>� ��� ��� ���� ��� ��������� ����� ��������</H1>
</CENTER>

HTML;
}

function tpl_error($error){
return <<<HTML
<FIELDSET>
<LEGEND>������ ��� ����������� � ��</LEGEND>
<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=2>
<TR>
<TD ALIGN=center>{$error}</TD>
</TR>
</TABLE>
</FIELDSET>

HTML;
}

function SXD_errorHandler($errno, $errmsg, $filename, $linenum, $vars) {
	if ($errno == 2048) return true;
	if (preg_match("/chmod\(\): Operation not permitted/", $errmsg)) return true;
    $dt = date("Y.m.d H:i:s");
    $errmsg = addslashes($errmsg);

	echo tpl_l("{$dt}<BR><B>�������� ������!</B>", C_ERROR);
	echo tpl_l("{$errmsg} ({$errno})", C_ERROR);
	echo tpl_enableBack();
	die();
}
?>