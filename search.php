<?php 
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type'])&& isset($_SESSION['fname']) && isset($_SESSION['lname']))){
	header('Location: ' .'index.html');
	exit();
}
error_reporting(0);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prayer Seeker</title>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
<style>
.navbar{
    font-size:14px;
    cursor: pointer;
}
.user-badge {
    display: inline-block;
    position: absolute;
    top: 20px; /* Adjust as needed */
    right: 50px;
    background-color: #007bff; /* Example background color */
    color: #fff; /* Example text color */
    border-radius: 50%;
    width: 40px; /* Adjust size as needed */
    height: 40px; /* Adjust size as needed */
    line-height: 40px;
    text-align: center;
    font-size: 18px; /* Adjust font size as needed */
    cursor: pointer;
}

.user-name { 
    font-family: Arial, sans-serif;
    display: none;
    font-size : 12px;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px;
    background-color: while; /* Same as badge background */
    color: #007bff; /* Same as badge text color */
    border-radius: 1px;
    white-space: nowrap;
}

.user-badge:hover .user-name {
    display: block;
}

</style>

</head>
<body>

<div id="outter_div">
	<h2>Search</h2>

    
<div class="user-info">
            <div class="user-badge">
                <span class="user-initials"><?php echo substr($_SESSION['fname'], 0, 1) . substr($_SESSION['lname'], 0, 1); ?></span>
                <span class="user-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></span>
            </div>
    
<div class="navbar">
    <a href="add_record.php">Add new record</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
    <a href="search.php">Search</a> &nbsp;&nbsp;
    |&nbsp;&nbsp; <a href="mylist.php">Caller History</a> 
    &nbsp;&nbsp;|<?php if ($_SESSION['type']=='Lead Counselor'||$_SESSION['type']=='IT admin')
	{ echo '&nbsp;&nbsp;<a href="add_user.php">Add User</a>&nbsp;&nbsp;
        |&nbsp;&nbsp; <a href="report1.php">Report 1</a> &nbsp;&nbsp;
        |&nbsp;&nbsp; <a href="report2.php">Report 2</a>&nbsp;&nbsp;'; }
	
	if ($_SESSION['type'] == 'IT admin') {
        echo '|&nbsp;&nbsp;<a href="details_of_pc.php">DPS</a>&nbsp;&nbsp;|';
    }?>
    &nbsp;&nbsp; <a href="login.php">Log Out</a>
</div>
    
    
    <form method="post" action="search.php">
        <fieldset>
        <table border="0" cellpadding="0" cellspacing="0">
        
          <tr>
            <td width="823" height="68" valign="top">
                <fieldset>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                             <td height="35">Search by &nbsp;<strong>
                             	<label for="prayer_seeker">Name</label>
                             </strong>
                             <input type="radio" id="prayer_seeker" name="searchtype" value="prayer" />
                             <strong><label for="counseling">Reference Number</label></strong>
                             <input type="radio" id="counseling" name="searchtype" value="ref" />
                             <strong><label for="contact_number">Contact Number</label></strong>
                             <input type="radio" id="contact_number" name="searchtype" value="tel" /></td>
                          </tr>
                          <tr>
                                <td height="35"><input type="text" id="name" name="serchbox" style="margin-left:70px;" /></td>
                          </tr>
                          <tr>
                                <td height="35"><input type="submit" id="name" name="search" value="Search" style="margin-left:70px;" /></td>
                          </tr>
                    </table>
                </fieldset>
            </td>
          </tr>
          
        </table>
        </fieldset>
    </form>
    
    <table class="report" cellpadding="5" >
    
    	<tr>
        	<th>Ref#</th>
            <th>Name</th>
            <th>Counseler</th>
        </tr>        
        <?php

        if (in_array($_POST['searchtype'], array('prayer','ref','tel'))) {
        	require_once 'db.class.php';
			$mysql = Db::connection();

			$resoc = null;
			if(($_POST['searchtype'] == 'prayer')  && isset($_POST['serchbox'])) {
				$query = sprintf("select p.id,s.id as sid,p.name,s.cname from prayer p left join psession s on p.id=s.pid where p.name like '%s' group by p.id",'%'.mysql_real_escape_string($_POST['serchbox']).'%');
				$resoc = mysql_query($query);
			}
			
			if(($_POST['searchtype'] == 'ref')  && isset($_POST['serchbox'])) {
				$query = sprintf("select p.id,s.id as sid,p.name,s.cname from prayer p left join psession s on p.id=s.pid where p.id='%s' group by p.id",mysql_real_escape_string($_POST['serchbox']));
				$resoc = mysql_query($query);
			}
			
			if(($_POST['searchtype'] == 'tel') && isset($_POST['serchbox'])) {
				$query = sprintf("select p.id,s.id as sid,p.name,s.cname from prayer p left join psession s on p.id=s.pid where trim(p.tel)='%s' OR trim(p.tel2)='%s' OR trim(p.tel3)='%s' group by p.id",mysql_real_escape_string(trim($_POST['serchbox'])),mysql_real_escape_string(trim($_POST['serchbox'])),mysql_real_escape_string(trim($_POST['serchbox'])));
				$resoc = mysql_query($query);
			}
			
			$result = array();

				if (mysql_num_rows($resoc)) {
					while ($row = mysql_fetch_array($resoc, MYSQL_BOTH)) {
						?>
					<tr style="font-size:14px">
                        <td><a href="profile_view1.php?id=<?php echo $row['id'];?>"><?php echo $row['id'];?></a></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['cname']; ?></td>
                    </tr>
						<?php
					}
				}
			mysql_close($mysql);
        }	
		?>
        
    </table>
</div>

</body>
</html>
