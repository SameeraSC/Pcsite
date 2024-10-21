<?php 
	session_start();
	if (!(isset($_SESSION['user']) && isset($_SESSION['type']))){
		header('Location: ' .'index.html');
		exit();
	}
	
	require_once 'db.class.php';
	$mysql = Db::connection();
	$detalof=$name=$age=$address=$gender=$tel=$tel2=$tel3=$language=$religion=$workplace=$pcfo=$country=$problem=$solutions=$response=$comments=$followup=$cname=$lastPrayerId=null;
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
	if (isset($_POST['age'])) {
		if (in_array($_POST['age'], $agearray)) {
			$age = $_POST['age'];
		}
	}
	if (isset($_POST['address'])) { $address=$_POST['address']; }
	if (isset($_POST['gender'])) { $gender=$_POST['gender'];}
	if (isset($_POST['tel'])) { $tel = $_POST['tel']; }
	if (isset($_POST['tel2'])) { $tel2 = $_POST['tel2'];}
	if (isset($_POST['tel3'])) {$tel3 = $_POST['tel3'];}
	if (isset($_POST['language'])) {$language = $_POST['language'];}
	if (isset($_POST['religion'])) {$religion = $_POST['religion'];}
	if (isset($_POST['workplace'])) { $workplace = $_POST['workplace'];}
	if (isset($_POST['pcfo'])) { $pcfo = $_POST['pcfo']; }
	if (isset($_POST['pcfo'])) { $country = $_POST['country']; }
	if (isset($_POST['problem'])) { $problem = $_POST['problem']; }
	if (isset($_POST['solutions'])) { $solutions = $_POST['solutions']; }
	if (isset($_POST['response'])) { $response = $_POST['response']; }
	if (isset($_POST['comments'])) { $comments = $_POST['comments']; }
	if (isset($_POST['followup'])) { $followup = $_POST['followup']; }
	if (isset($_POST['cname'])) { $cname = $_POST['cname']; }
	
	if (isset($_POST['ep']) && $_POST['ep'] >0) {
		$query = sprintf("UPDATE prayer SET detailof='%s',name='%s',age='%s',address='%s',gender='%s',tel='%s',tel2='%s',tel3='%s',language='%s',religion='%s',workplace='%s',other='%s' WHERE id='%s'",
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
							mysql_real_escape_string($country),
							mysql_real_escape_string($_POST['ep']));
		mysql_query($query);
		$lastPrayerId = mysql_insert_id();
	}
	
	if (isset($_POST['updateId']) && $_POST['updateId'] > 0) {
		$lastPrayerId = $_POST['updateId'];
	}
	else {
		if (strlen($name) > 1 && strlen($detalof) > 1 && strlen($address) > 1 && strlen($tel) >1 ) {
			$query = sprintf("INSERT INTO prayer (detailof,name,age,address,gender,tel,tel2,tel3,language,religion,workplace,other,country) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
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
							mysql_real_escape_string($country));
			mysql_query($query);
			$lastPrayerId = mysql_insert_id();
		}
	}
	
	if (isset($_POST['updateSid']) && $_POST['updateSid'] > 0) {
		if ($_SESSION['type']=='Lead Counselor'){
			$query = sprintf("UPDATE psession SET problem='%s',solutions='%s',response='%s',followup='%s',cname='%s',marriage='%d',financial='%d',family='%d',addiction='%d',personal='%d',sickness='%d',other='%d',comments='%s' WHERE id='%d'",					
							mysql_real_escape_string($problem),
							mysql_real_escape_string($solutions),
							mysql_real_escape_string($response),
							mysql_real_escape_string($followup),
							mysql_real_escape_string($cname),
							mysql_real_escape_string($marriage),
							mysql_real_escape_string($financil),
							mysql_real_escape_string($family),
							mysql_real_escape_string($addiction),
							mysql_real_escape_string($personal),
							mysql_real_escape_string($sickness),
							mysql_real_escape_string($other),
							mysql_real_escape_string($comments),
							$_POST['updateSid']);
			$resocB = mysql_query($query);
			$lastPrayerId = $_POST['updateId']; 
		}else{
			$query = sprintf("UPDATE psession SET problem='%s',solutions='%s',response='%s',followup='%s',cname='%s',marriage='%d',financial='%d',family='%d',addiction='%d',personal='%d',sickness='%d',other='%d' WHERE id='%d'",
					mysql_real_escape_string($problem),
					mysql_real_escape_string($solutions),
					mysql_real_escape_string($response),
					mysql_real_escape_string($followup),
					mysql_real_escape_string($cname),
					mysql_real_escape_string($marriage),
					mysql_real_escape_string($financil),
					mysql_real_escape_string($family),
					mysql_real_escape_string($addiction),
					mysql_real_escape_string($personal),
					mysql_real_escape_string($sickness),
					mysql_real_escape_string($other),
					$_POST['updateSid']);
			$resocB = mysql_query($query);			
			$lastPrayerId = $_POST['updateId'];
		}
	}
	else {
		if (strlen($problem)>1 && strlen($cname)>1 && strlen($lastPrayerId)>=1) {
			$query = sprintf("INSERT INTO psession (pid,problem,solutions,response,followup,cname,marriage,financial,family,addiction,personal,sickness,other,comments,user) 
						VALUES ('%d','%s','%s','%s','%s','%s','%d','%d','%d','%d','%d','%d','%d','%s','%s')",
					$lastPrayerId,
					mysql_real_escape_string($problem),
					mysql_real_escape_string($solutions),
					mysql_real_escape_string($response),
					mysql_real_escape_string($followup),
					mysql_real_escape_string($cname),
					mysql_real_escape_string($marriage),
					mysql_real_escape_string($financil),
					mysql_real_escape_string($family),
					mysql_real_escape_string($addiction),
					mysql_real_escape_string($personal),
					mysql_real_escape_string($sickness),
					mysql_real_escape_string($other),
					mysql_real_escape_string($comments),
					$_SESSION['user']);
			$resocB = mysql_query($query);
		}
		
	}
	
	if (strlen($lastPrayerId) < 1) {
			echo 'fill the all data';
			header('Location: ' .'add_record.php');
			exit();
	}
	header('Location: ' .'screen2.php?id='.$lastPrayerId);
?>