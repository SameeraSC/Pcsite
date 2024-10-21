<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']))){
	header('Location: ' .'index.html');
	exit();
}

	require_once 'db.class.php';
	$mysql = Db::connection();
	
	$refId = $_POST['ref'];
	$comment = $_POST['comment'];
	$id=null;
	
	$query = sprintf("update psession set comments='%s' where id='%d'",mysql_real_escape_string($comment),mysql_real_escape_string($refId));
	$resoc = mysql_query($query);				
	if (mysql_affected_rows() >= 1) {
		$query = sprintf("select id,pid from psession where id='%d'",mysql_real_escape_string($refId));
		$resocUpdated = mysql_query($query);
		if (mysql_num_rows($resocUpdated)) {
			while ($row = mysql_fetch_array($resocUpdated, MYSQL_BOTH)) {
				$id = $row['pid'];
				$refId = $row['id'];
			}
		}
	}	
	mysql_close($mysql);
	return json_encode("ok");
	//header('Location: ' .'profile_view.php?id='.$id);
	//require_once 'profile_view.php?ref='.$refId;
?>