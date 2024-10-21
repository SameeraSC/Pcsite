<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']))){
	header('Location: ' .'index.html');
	exit();
}

require_once 'db.class.php';
$mysql = Db::connection();
$prayer=$summary=null;
if(isset($_GET['id'])) {
	
	$resoc = mysql_query("select id,name,age,address,gender,tel,tel2,tel3,language,religion,workplace,other,ts from prayer where id='".$_GET['id']."'");	
	if (mysql_num_rows($resoc)) {
		while ($row = mysql_fetch_array($resoc, MYSQL_BOTH)) {
			$prayer = $row;
		}
	}
}

if (isset($_GET['ref'])) {
	
	$resocSum = mysql_query("select id as sid,marriage,financial,family,addiction,personal,sickness,other,problem,solutions,response,comments,followup,cname from psession where id='".$_GET['ref']."'");	
	if (mysql_num_rows($resocSum)) {
		while ($row = mysql_fetch_array($resocSum, MYSQL_BOTH)) {
			$summary = $row;			
		}
	}
}
mysql_close($mysql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prayer Seeker</title>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>
<body>

<div id="outter_div">
	<h2>Prayer Seeker</h2>
    
    <div><a href="add_record.php">Add new record</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="search.php">Search</a> &nbsp;&nbsp;|<?php if ($_SESSION['type']=='Lead Counselor'){ ?> &nbsp;&nbsp;<a href="add_user.php">Add User</a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="report1.php">Report 1</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="report2.php">Report 2</a>&nbsp;&nbsp;|<?php }?>&nbsp;&nbsp; <a href="login.php">Log Out</a></div>
    

	<fieldset>
    <table border="0" cellpadding="0" cellspacing="0">
    
      <tr>
        <td width="823" height="68" valign="top">
        	<fieldset>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                      		<td height="68">Details of &nbsp;<strong>Prayer Seeker</strong></td>
                      </tr>
                </table>
			</fieldset>
        </td>
      </tr>
      
      <tr>
        <td height="526" valign="top">
        
        		<fieldset>
                	<legend>Main Details</legend>
                	<form method="post" action="edit_prayer.php" onsubmit="return confirm('Are you sure you want to submit this data?');" >
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                    		  <tr>
                              	<td class="number" valign="top">&nbsp; </td>
                                <td class="label" valign="top">Ref. No.</td>
                                <td valign="top"><?php echo $prayer['id'];?></td>
                                <td><input type="hidden" name="ep" value="<?php echo $prayer['id'];?>"/></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Name</td>
                                <td valign="top"><input type="text" id="name" name="name" value="<?php echo $prayer['name'];?>"/></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Age</td>
                                <td valign="top">
                                    <label>Youth</label><input type="radio" <?php if($prayer['age'] == 'youth'){echo 'checked="checked"';}?> id="youth" name="age" value="youth" />
                                	<label>Young adult</label><input type="radio" <?php if($prayer['age'] =='young_adult'){echo 'checked="checked"';}?> id="young_adult" name="age" value="young_adult" />
                                	<label>Adult</label><input type="radio" <?php if($prayer['age'] == 'adult'){echo 'checked="checked"';}?> id="adult" name="age" value="adult" />
                                	<label>Senior</label><input type="radio" <?php if($prayer['age'] == 'senior'){echo 'checked="checked"';}?> id="senior" name="age" value="senior" />
								</td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Address</td>
                                <td valign="top"><input type="text" id="address" name="address" value="<?php echo $prayer['address'];?>"/></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Gender</td>
                                <td valign="top">
									<label>Female</label><input type="radio" <?php if($prayer['gender'] == 'female'){echo 'checked="checked"';}?> id="female" name="gender" value="female" />
                                	<label>Male</label><input type="radio" <?php if($prayer['gender'] == 'male'){echo 'checked="checked"';}?> id="male" name="gender" value="male" />
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Religion</td>                                
                                <td valign="top">
                                	<input type="text" id="religion" name="religion" value="<?php echo $prayer['religion'];?>" /></td>
                             	</tr>
                              <tr>
                              	<td class="number" valign="top">6. </td>
                                <td class="label" valign="top">Contact Number</td>                                
                                <td valign="top">
                                	<input type="text" id="tel" name="tel" value="<?php echo $prayer['tel'];?>" /></td>
                             	</tr>
                              <tr>
				<td class="number" valign="top">7. </td>
                                <td class="label" valign="top">Province</td>                                
                                <td valign="top">
				<input type="text" id="tel2" name="tel2" value="<?php echo $prayer['tel2'];?>" /></td>
                                </tr>
                              <tr>	
				<td class="number" valign="top">8. </td>
                                <td class="label" valign="top">District</td>                                
                                <td valign="top">		
				<input type="text" id="tel3" name="tel3" value="<?php echo $prayer['tel3'];?>"/></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">9. </td>
                                <td class="label" valign="top">Place of Work</td>                                
                                 <td valign="top">
				<input type="text" id="workplace" name="workplace" value="<?php echo $prayer['workplace'];?>" /></td>
                         

				</tr>
                              
				<tr>
                              	<td class="number" valign="top">10. </td>
                                <td class="label" valign="top">Prefrred Language</td>
                                <td valign="top">
				<input type="text" id="language" name="language"value="<?php echo $prayer['language'];?>"/></td>
			
				</tr>
				<tr>
                              	<td class="number" valign="top">11. </td>
                                <td class="label" valign="top">Prayer/Counseliing Friend/Other</td>
                                <td valign="top"><input type="text" id="pcfo" name="pcfo" value="<?php echo $prayer['other'];?>" /></td>
                              </tr>
				<tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" name="add" value="Update" /></td>
                              </tr>
                    </table>
                    </form>
        		</fieldset>
        </td>
      </tr>
    </table>
    </fieldset>

</div>

</body>
</html>
