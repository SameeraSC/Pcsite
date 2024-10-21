<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && $_SESSION['type']=='Lead Counselor'||$_SESSION['type']=='IT admin')){
	header('Location: ' .'index.html');
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="js/jquery-1.3.2.js"></script> 
    <script type="text/javascript" src="js/jquery.form.js"></script> 
        <script type="text/javascript"> 
        $(document).ready(function() { 
    		$(".addcomment").ajaxForm({    			
    			type:"POST",
    			dataType:"json"
    		}); 
        });
    </script> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prayer Seeker</title>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>
<body>
<div id="outter_div">
	<h2>Prayer Seeker</h2>    
    <div><a href="add_record.php">Add new record</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="search.php">Search</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="cv.php">CH</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="report1.php">Report 1</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="report2.php">Report 2</a>&nbsp;&nbsp;|<?php if ($_SESSION['type']=='Lead Counselor'||$_SESSION['type']=='IT admin'){ echo '&nbsp;&nbsp;<a href="add_user.php">Add User</a>&nbsp;&nbsp;|';} if($_SESSION['type']=='IT admin'){echo'&nbsp;&nbsp<a href="details_of_pc.php">DSP</a>&nbsp;&nbsp;|';}?> &nbsp;&nbsp; <a href="login.php">Log Out</a></div>
    <table class="report" cellpadding="5">    	
        <tr>
        <td width="900" valign="top" colspan="6">        
        		<fieldset class="report_filter">
                	<legend>Main Details</legend>
                	<form action="report2.php" method="post">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">From</td>
                                <td valign="top">
                                	<select name="fmm">
                                    	<option>mm</option>
                                        <option>01</option>
                                        <option>05</option>
                                        <option>10</option>
                                        <option>15</option>
                                        <option>20</option>
                                       	<option>25</option>
                                        <option>30</option>
                                        <option>35</option>
                                        <option>40</option>
                                        <option>45</option>
                                        <option>50</option>
                                        <option>55</option>
                                    </select>
                                    :                                    
                                    <select name="fhh">
                                    	<option>hh</option>
                                    	<option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>                                    
                                    <select name="fap">
                                    	<option>AM</option>
                                        <option>PM</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="fdate">
                                    	<option>-- date --</option>
                                    	<option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                        <option>31</option>
                                    </select>
                                    <select name="fmonth">
                                    	<option value="0">-- Month --</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>                                    
                                    <select name="fyear" >
                                    	<option>-- Year --</option>
										<?php 
                                    	for ($i = 2011; $i <= date('Y') ; $i++) {
                                    	?> 
                                    		<option><?php echo $i; ?></option>
                                    	<?php 
                                    	}
                                    	?>
                                    </select>
                                </td>
                              </tr>                              
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">To</td>
                                <td valign="top">
                                    <select name="tmm">
                                    	<option>mm</option>
                                    	<option>01</option>
                                        <option>05</option>
                                        <option>10</option>
                                        <option>15</option>
                                        <option>20</option>
                                       	<option>25</option>
                                        <option>30</option>
                                        <option>35</option>
                                        <option>40</option>
                                        <option>45</option>
                                        <option>50</option>
                                        <option>55</option>
                                    </select>
                                    :                                    
                                    <select name="thh">
                                    	<option>hh</option>
                                    	<option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>                                    
                                    <select name="tap">
                                    	<option>AM</option>
                                        <option>PM</option>
                                    </select>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <select name="tdate">
                                    	<option>-- date --</option>
                                    	<option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                        <option>13</option>
                                        <option>14</option>
                                        <option>15</option>
                                        <option>16</option>
                                        <option>17</option>
                                        <option>18</option>
                                        <option>19</option>
                                        <option>20</option>
                                        <option>21</option>
                                        <option>22</option>
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        <option>29</option>
                                        <option>30</option>
                                        <option>31</option>
                                    </select>
                                    <select name="tmonth">
                                    	<option value="0">-- Month --</option>
                                        <option value="1">January</option>
                                        <option value="2">February</option>
                                        <option value="3">March</option>
                                        <option value="4">April</option>
                                        <option value="5">May</option>
                                        <option value="6">June</option>
                                        <option value="7">July</option>
                                        <option value="8">August</option>
                                        <option value="9">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>                                    
                                    <select name="tyear">
                                    	<option>-- Year --</option>
										<?php 
                                    	for ($i = 2011; $i <= date('Y') ; $i++) {
                                    	?> 
                                    		<option><?php echo $i; ?></option>
                                    	<?php 
                                    	}
                                    	?>
                                    </select>
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" id="name" name="submit" value="Show Report" /></td>
                              </tr>
                    	</table>
                    </form>
        		</fieldset>
			</td>            
           </tr>
    	<tr>
        	<th style="width:50px;">Date - Time</th>
            <th style="width:50px;">Ref No.</th>
            <th style="width:80px;">Name</th>
            <th style="width:80px;">Conselor's Name</th>
            <th style="width:250px;">Suggested Follow Up Measures</th>
            <?php if ($_SESSION['type']=='Lead Counselor'){ ?><th>Update</th><?php }?>
        </tr>        
        <?php
        if(count($_POST) && (int)$_POST['fyear'] > 0 && (int)$_POST['fmonth'] > 0 && (int)$_POST['fdate'] > 0 && (int)$_POST['fhh'] > 0 && (int)$_POST['tyear'] > 0 && (int)$_POST['tmonth'] > 0 && (int)$_POST['tdate'] > 0 && (int)$_POST['thh'] > 0 ) {
			require_once 'db.class.php';
			$mysqli = Db::connection();
			$tmm=$fmm='00';
			if($_POST['fmm']!='mm'){$fmm=$_POST['fmm'];};
			if($_POST['tmm']!='mm'){$tmm=$_POST['tmm'];};
			$fdate = new DateTime($_POST['fyear'].'-'.$_POST['fmonth'].'-'.$_POST['fdate'].' '.$_POST['fhh'].':'.$fmm.' '.$_POST['fap']);
			$tdate = new DateTime($_POST['tyear'].'-'.$_POST['tmonth'].'-'.$_POST['tdate'].' '.$_POST['thh'].':'.$tmm.' '.$_POST['tap']);	
			$fdatets = $fdate->getTimestamp();
			$tdatets = $tdate->getTimestamp();
			
			$resoc = mysql_query('select p.id,s.id as sid,p.name,s.cname,s.followup,s.comments,s.ts from prayer p left join psession s on p.id=s.pid where unix_timestamp(s.ts) >='.$fdatets.' and unix_timestamp(s.ts) <='.$tdatets.' order by s.id desc');
			$result = array();
			//$count  = 1;
			if (mysql_num_rows($resoc)) {
				while ($row = mysql_fetch_array($resoc, MYSQL_BOTH)) {
				//	$comments = (string)$row['comments'];
				//	$ctextarea = 'commment'.$count;
				//	$count += 1; 
		?>
		<tr>
			<td><?php echo date("Y-m-d",strtotime($row['ts']));?><br /><?php echo date("H:i A",strtotime($row['ts']));?></td>
			<td><a href="profile_view.php?id=<?php echo $row['id'];?>#<?php echo $row['sid']; ?>"><?php echo $row['sid'];?></a></td>
			<td><?php echo $row['name'];?></td><td><?php echo $row['cname'];?></td><td><?php echo $row['followup'];?> </td>
			<td>
				<form method="post" id="addcomment" class="addcomment" action="addcomment.php">
					<input type="hidden" name="ref" value="<?php echo $row['sid'];?>"/>
					<?php if ($_SESSION['type']=='Lead Counselor'){ ?>
					<textarea name="comment" rows="3" cols="26"><?php echo (string)$row['comments'];?></textarea>
					<input type="submit" value="update" /><?php }?>
				</form>
			</td>
		</tr>
		<?php	
			}
		}
		mysql_close($mysql);
	}
	?> 
    <tr><td colspan="6" align="center">-- End Of Report --</td></tr>
   </table>
</div>
</body>
</html>