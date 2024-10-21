<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_SESSION['fname']) && isset($_SESSION['lname']) && ($_SESSION['type']=='Lead Counselor' || $_SESSION['type']=='IT admin'))){
	header('Location: ' .'index.html');
	exit();
}
require_once 'navbar.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prayer Seeker</title>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
<!-- Include jQuery and jQuery UI for the date picker -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(function() {
        // Initialize datepickers for From and To fields
        $("#fdate").datepicker({ dateFormat: 'yy-mm-dd' });
        $("#tdate").datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>
</head>
<body>

<div id="outter_div">


    <table class="report" cellpadding="5">
        <tr>
        <td width="800" valign="top" colspan="3">
        		<fieldset class="report_filter">
                	<legend>Fitter</legend>
                	<form action="report1.php" method="post">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">From</td>
                                <td valign="top">
                                    <input type="text" id="fdate" name="fdate" placeholder="Select Date" required />
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">To</td>
                                <td valign="top">
                                    <input type="text" id="tdate" name="tdate" placeholder="Select Date" required />
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">Filter by</td>
                                <td valign="top">
                                    <label>Marriage</label><input type="checkbox" id="marriage" name="marriage" />
                                    <label>Financial</label><input type="checkbox" id="financial" name="financial" />
                                    <label>Family</label><input type="checkbox" id="family" name="family" />
                                    <label>Addiction</label><input type="checkbox" id="addiction" name="addiction" />
                                    <label>Personal</label><input type="checkbox" id="personal" name="personal" />
                                    <label>Sickness</label><input type="checkbox" id="sickness" name="sickness" />
                                    <label>Other</label><input type="checkbox" id="other" name="other" />
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" id="name" name="name" value="Show Report" /></td>
                              </tr>
                    </table>
                    </form>
        		</fieldset>
			</td>
           </tr>        
    	<tr>
        	<th>Ref#</th>
            <th>Name</th>
            <th>Counselor</th>
            <tr>
            <?php
            if(count($_POST) && !empty($_POST['fdate']) && !empty($_POST['tdate'])) {
				require_once 'db_dps.class.php';
				$mysqli = Db::connection();

				// Prepare dates for query
				$fdate = new DateTime($_POST['fdate']);
				$tdate = new DateTime($_POST['tdate']);
				$fdatets = $fdate->format('Y-m-d H:i:s');
				$tdatets = $tdate->format('Y-m-d H:i:s');
				
				$wherecls = '';
				$ptypes = array('marriage','financial','family','addiction','personal','sickness','other');
				foreach ($ptypes as $value) {
					if(isset($_POST[$value])){
						$wherecls .= " AND s.$value = 1 ";
					}
				}
				
				$query = "SELECT p.id, s.id as sid, p.name, s.cname 
                          FROM prayer p 
                          LEFT JOIN psession s ON p.id = s.pid 
                          WHERE p.ts >= ? AND p.ts <= ? $wherecls 
                          GROUP BY p.id";
				
				if ($stmt = $mysqli->prepare($query)) {
					$stmt->bind_param("ss", $fdatets, $tdatets);
					$stmt->execute();
					$stmt->bind_result($id, $sid, $name, $cname);
					
					while ($stmt->fetch()) {
						echo "<tr><td><a href='profile_view.php?id=$id'>$id</a></td><td>$name</td><td>$cname</td></tr>";
					}
					$stmt->close();
				}
				$mysqli->close();
			}
			?>  
        <tr><td colspan="3" align="center">-- End Of Report --</td></tr>
    </table>
</div>
</body>
</html>
