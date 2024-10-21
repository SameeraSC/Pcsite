<?php 
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']))){
	header('Location: ' .'index.html');
	exit();
}
	require_once 'db.class.php';
	$mysql = Db::connection();
	$detalof=$name=$age=$address=$gender=$tel=$tel2=$tel3=$language=$religion=$workplace=$pcfo=$problem=$solutions=$response=$comments=$followup=$cname=$lastPrayerId=null;
	$marriage=$financil=$family=$addiction=$personal=$sickness=$other=0;
	
	$ptype = array();
	$agearray = array('youth','young_adult','adult','senior');
	if (isset($_POST['marriage'])) { $marriage=(bool)$_POST['marriage']; } 
	if (isset($_POST['financil'])) { $financil=(bool)$_POST['financil']; } 
	if (isset($_POST['family'])) { $family=(bool)$_POST['family']; }
	if (isset($_POST['addiction'])) { $addiction=(bool)$_POST['addiction']; }
	if (isset($_POST['personal'])) { $personal=(bool)$_POST['personal']; }
	if (isset($_POST['sickness'])) { $sickness=(bool)$_POST['sickness']; }
	if (isset($_POST['other'])) { $other=(bool)$_POST['other']; }
	if (isset($_POST['detailof'])) { $detalof = $_POST['detailof']; }
	if (isset($_POST['name'])) { $name = $_POST['name']; }
	if (in_array($_POST['age'], $agearray)) {
		$age = $_POST['age'];
	}
	if (isset($_POST['address'])) { $address=$_POST['address']; }
	if (isset($_POST['gender'])) { $gender=$_POST['gender'];}
	if (isset($_POST['tel'])) { $tel = $_POST['tel']; }
	if (isset($_POST['tel2'])) {$tel2 = $_POST['tel2'];}
	if (isset($_POST['tel3'])) {$tel3 = $_POST['tel3'];}
	if (isset($_POST['language'])) {$language = $_POST['language'];}
	if (isset($_POST['religion'])) {$religion = $_POST['religion'];}
	if (isset($_POST['workplace'])) { $workplace = $_POST['workplace'];}
	if (isset($_POST['pcfo'])) { $pcfo = $_POST['pcfo']; }
	
	if (isset($_POST['ep']) && $_POST['ep'] >0) {
		$query = sprintf("UPDATE prayer SET detailof='%s',name='%s',age='%s',address='%s',gender='%s',tel='%s',tel2='%s',tel3='%s',language='%s',religion='%s',workplace='%s',other='%s' WHERE id='%d'",
							mysql_real_escape_string($detalof),
							mysql_real_escape_string($name),
							mysql_real_escape_string($age),
							mysql_real_escape_string($address),
							mysql_real_escape_string($gender),
							mysql_real_escape_string($tel),
							mysql_real_escape_string($tel2),
							mysql_real_escape_string($tel3),
							mysql_real_escape_string($language),
							mysql_real_escape_string($religion),
							mysql_real_escape_string($workplace),
							mysql_real_escape_string($pcfo),
							mysql_real_escape_string($_POST['ep']));
		mysql_query($query);
		$lastPrayerId = $_POST['ep'];
	}

	//echo $lastPrayerId;
	header('Location: ' .'screen2.php?id='.$lastPrayerId);
?>