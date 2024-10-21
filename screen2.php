<?php 
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_GET['id']))){
	header('Location: ' .'index.html');
	exit();
}
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
    
    <div><a href="add_record.php">Add new record</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="search.php">Search</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="mylist.php">Caller History</a> &nbsp;&nbsp;|<?php if ($_SESSION['type']=='Lead Counselor'){ ?> &nbsp;&nbsp;<a href="add_user.php">Add User</a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="report1.php">Report 1</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="report2.php">Report 2</a>&nbsp;&nbsp;|&nbsp;|<?php }?>&nbsp;&nbsp; <a href="login.php">Log Out</a></div>
    
    <form method="post" action="add_record.php">
	<fieldset>
    <table border="0" cellpadding="0" cellspacing="0">
    
      <tr>
        <td width="823" height="68" valign="top">
        	<fieldset>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                      		<td height="68"><strong>Details have been added sucesfully!</strong> &nbsp;&nbsp;&nbsp;<a href="profile_view1.php?id=<?php echo $_GET['id']?>">View record &raquo;</a></td>
                      </tr>
                      <tr>
                      		 <td valign="top"><input type="submit" id="name" name="name" value="Add New" /></td>
                      </tr>
                </table>
			</fieldset>
        </td>
      </tr>
      
      
    </table>
    </fieldset>
    </form>
</div>

</body>
</html>
