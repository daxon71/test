<?
function getArray($table, $sql = null){
	$where_sql = $table=='articles' ? "WHERE `visibility`!='hidden'" : "";
	$sql ? $sql = $sql : $sql = "SELECT * FROM $table $where_sql ORDER BY `sort`";
	$query = mysql_query($sql);
	if($query){
		$array = mysql_fetch_assoc($query);

		for ($i=0; is_array($array); $i++) { 
			$res[$i] = $array;
			$array = mysql_fetch_assoc($query);
		}
	}
	return $res;
}

function isHome(){	
	return $_SERVER['REQUEST_URI'] == '/' || $_SERVER['REQUEST_URI'] == '/index.php' || $_SERVER['REQUEST_URI'] == '/?edit';
}

function isDenwer(){
	return $_SERVER['REMOTE_ADDR'] == '127.0.0.1';
}

function addBreadcrumb($url, $title){
	global $breadcrumbs;
	if($url=='/') {
		$breadcrumbs[] = array('url'=> $url,'title'=> $title);
	}
	else {
		$breadcrumbs[] = array('url'=> $breadcrumbs[count($breadcrumbs)-1]['url'].$url.'/','title'=> $title);
	};
}