<?php
Class Db{
	public static $mysql=NULL;
	
	public static function connection() {
		if (is_null(self::$mysql)) {
			$con = mysql_connect("localhost","root","");
 mysql_query ("set character_set_results='utf8'");   			if (!$con) { 
				die('Could not connect: ' . mysql_error()); 
			}
			mysql_select_db("peacecenterdb", $con);
			return self::$mysql = $con;
		}
		return self::$mysql;
	}
}
?>