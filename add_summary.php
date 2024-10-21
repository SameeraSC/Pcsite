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
	
	$resoc = mysql_query("select id,name,age,address,gender,tel,tel2,tel3,workplace,other,ts from prayer where id='".$_GET['id']."'");	
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
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript">
	$(function(){
		$("#addsummary").validate();
	});

    function updateproblem(){
        CKEDITOR.tools.setTimeout( function(){
            $("#problem").val(CKEDITOR.instances.problem.getData());
            $("#problem").trigger('keyup');
		}, 0);  
    }

    function updatesolutions(){
        CKEDITOR.tools.setTimeout( function(){
            $("#solutions").val(CKEDITOR.instances.solutions.getData());
            $("#solutions").trigger('keyup');
		}, 0);  
    }

    function updateresponse(){
        CKEDITOR.tools.setTimeout( function(){
            $("#response").val(CKEDITOR.instances.response.getData());
            $("#response").trigger('keyup');
		}, 0);  
    }

    function updatefollowup(){
        CKEDITOR.tools.setTimeout( function(){
            $("#followup").val(CKEDITOR.instances.followup.getData());
            $("#followup").trigger('keyup');
		}, 0);  
    }	
</script>
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
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                    		  <tr>
                              	<td class="number" valign="top">&nbsp; </td>
                                <td class="label" valign="top">Ref. No.</td>
                                <td valign="top"><?php echo $prayer['id'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Name</td>
                                <td valign="top"><?php echo $prayer['name'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Age</td>
                                <td valign="top"><?php echo $prayer['age'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Address</td>
                                <td valign="top"><?php echo $prayer['address'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Gender</td>
                                <td valign="top"><?php echo $prayer['gender'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Contact Number</td>
                                <td valign="top"><?php echo $prayer['tel'];?></td>
				</tr>
				<tr>
				<td class="number" valign="top">6. </td>
                                <td class="label" valign="top">Province</td>
				<td valing="top"><?php echo $prayer['tel2'];?></td>  
				</tr>
                            	<tr>
				<td class="number" valign="top">7. </td>
                                <td class="label" valign="top">District</td>
				<td valing="top"><?php echo $prayer['tel3'];?></td>  
				</tr>
                             	 <tr>
                              	<td class="number" valign="top">8. </td>
                                <td class="label" valign="top">Place of Work</td>
                                <td valign="top"><?php echo $prayer['workplace'];?></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">9. </td>
                                <td class="label" valign="top">Prayer/Counseliing Friend/Other</td>
                                <td valign="top"><?php echo $prayer['other'];?></td>
                              </tr>
                    </table>
        		</fieldset>
        		<fieldset>
                	<legend>Summary Of The Prayer Session </legend>
                	<form method="post" action="prayer.php" id="addsummary">
                	<input type="hidden" name="updateId" value="<?php echo $prayer['id'];?>">
                	<input type="hidden" name="updateSid" value="<?php echo $summary['sid'];?>">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                              <tr>
                              	<td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Problem Definition
                                <div style="padding-top:90px;">Case Study</div>
								</td>
                                <td valign="top">
                                	<label>Marriage</label><input type="checkbox" <?php if((bool)$summary['marriage']){echo 'checked="true"';}?> id="marriage" name="marriage" />
                                    <label>Financial</label><input type="checkbox" <?php if((bool)$summary['financial']){echo 'checked="true"';}?> id="financil" name="financil" />
                                    <label>Family</label><input type="checkbox" <?php if((bool)$summary['family']){echo 'checked="true"';}?> id="family" name="family" />
                                    <label>Addiction</label><input type="checkbox" <?php if((bool)$summary['addiction']){echo 'checked="true"';}?> id="addiction" name="addiction" />
                                    <label>Personal</label><input type="checkbox" <?php if((bool)$summary['personal']){echo 'checked="true"';}?> id="personal" name="personal" />
                                    <label>Sickness</label><input type="checkbox" <?php if((bool)$summary['sickness']){echo 'checked="true"';}?> id="sickness" name="sickness" />
                                    <label>Other</label><input type="checkbox" <?php if((bool)$summary['other']){echo 'checked="true"';}?> id="other" name="other" />
                                    <br /><br /><br />
                                    <textarea cols="30" name="problem" id="problem" rows="6" class="required"><?php if(preg_match("/([\<])([^\>]{1,})*([\>])/i",$summary['problem'])){echo $summary['problem'];}else{ echo nl2br($summary['problem']);}?></textarea>
                                    <script type="text/javascript">
										CKEDITOR.replace( 'problem',{toolbar : 'seekerTools'});
									    CKEDITOR.instances["problem"].on("instanceReady", function(){this.document.on("keyup", updateproblem);});		
									</script>
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Solutions</td>
                                <td valign="top"><textarea name="solutions" id="solutions" cols="30" rows="6" class="required"><?php if(preg_match("/([\<])([^\>]{1,})*([\>])/i",$summary['solutions'])){echo $summary['solutions'];}else{echo nl2br($summary['solutions']);}?></textarea></td>
                              </tr>
								<script type="text/javascript">
									CKEDITOR.replace( 'solutions',{toolbar : 'seekerTools'});
									 CKEDITOR.instances["solutions"].on("instanceReady", function(){this.document.on("keyup", updatesolutions);});				
								</script>
                              <tr>
                              	<td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Response of the Prayer Seeker : </td>
                                <td valign="top"><textarea name="response" id="response" cols="30" rows="6" class="required"><?php if(preg_match("/([\<])([^\>]{1,})*([\>])/i",$summary['response'])){echo $summary['response'];}else{echo nl2br($summary['response']);}?></textarea></td>
                              </tr>
								<script type="text/javascript">
									CKEDITOR.replace( 'response',{toolbar : 'seekerTools'});
									 CKEDITOR.instances["response"].on("instanceReady", function(){this.document.on("keyup", updateresponse);});
								</script>
                              <tr>
                              	<td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Comments From Leader Of Counselors
								</td>
								<?php if ($_SESSION['type']=='Lead Counselor'){ ?> <td valign="top"><textarea id="comments" name="comments" cols="30" rows="6"><?php echo $summary['comments'];?></textarea></td>
								<?php }else{?>
                                	<td valign="top"><?php echo $summary['comments'];?></td>
								<?php }?>
                                <td valign="top"><p>This field can be added only by the <strong>Leader Of Counselors (user role)</strong></p></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Goal / Follow up measures  </td>
                                <td valign="top"><textarea id="followup" name="followup"cols="30" rows="6" class="required"><?php if(preg_match("/([\<])([^\>]{1,})*([\>])/i",$summary['followup'])){echo $summary['followup'];}else{echo nl2br($summary['followup']);}?></textarea></td>
                              </tr>
                              	<script type="text/javascript">
									CKEDITOR.replace( 'followup',{toolbar : 'seekerTools'});
									CKEDITOR.instances["followup"].on("instanceReady", function(){this.document.on("keyup", updatefollowup);});		
								</script>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Counselor's Name</td>
                                <td valign="top"><input name="cname" type="text" id="name" value="<?php echo $summary['cname'];?>" class="required" /></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" name="add" value="Add" /></td>
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
