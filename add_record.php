<?php 
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_SESSION['fname']) && isset($_SESSION['lname']))) {
    header('Location: index.html');
    exit();
}

$welcomeMessage =  $_SESSION['fname'] . " " . $_SESSION['lname'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Prayer Seeker - Screen 1</title>
<script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<style> #country {display: none;}</style>

<script type="text/javascript">
	$(function(){
		$("#addrecord").validate();
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

<style>
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
<h2>Add New</h2>
<div class="user-info">
            <div class="user-badge">
                <span class="user-initials"><?php echo substr($_SESSION['fname'], 0, 1) . substr($_SESSION['lname'], 0, 1); ?></span>
                <span class="user-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></span>
            </div>
   
    <div><a href="add_record.php">Add new record</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="search.php">Search</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="mylist.php">Caller History</a> &nbsp;&nbsp;|
	<?php if ($_SESSION['type']=='Lead Counselor'||$_SESSION['type']=='IT admin')
	{ echo '&nbsp;&nbsp;<a href="add_user.php">Add User</a>&nbsp;&nbsp;|&nbsp;&nbsp; <a href="report1.php">Report 1</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="report2.php">Report 2</a>&nbsp;&nbsp;'; }
	
	if ($_SESSION['type'] == 'IT admin') {
        echo '|&nbsp;&nbsp;<a href="details_of_pc.php">DPS</a>&nbsp;&nbsp;|';
    }?>
	
	&nbsp;&nbsp; <a href="login.php">Log Out</a></div>
	<fieldset style="font-size:13px">
	<form id="addrecord" method="post" action="prayer.php">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="823" height="68" valign="top">
        	<fieldset>
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                      		<td height="68">Details of<strong><label for="prayer_seeker">Prayer Seeker</label></strong><input type="radio" id="prayer_seeker" name="detailof" value="prayer_seeker" class="required" /> <strong><label for="counseling">Counseling</label></strong><input type="radio" id="counseling" name="detailof" value="counseling" /> (Via Phone)</td>
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
                              	<td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Name</td>
                                <td valign="top"><input type="text" id="name" name="name" class="required" /></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Age</td>
                                <td valign="top">
                                	<label>Youth</label><input type="radio" id="youth" name="age" value="youth"  class="required" />
                                	<label>Young adult</label><input type="radio" id="young_adult" name="age" value="young_adult" />
                                	<label>Adult</label><input type="radio" id="adult" name="age" value="adult" />
                                	<label>Senior</label><input type="radio" id="senior" name="age" value="senior" />
                                </td>
                             
                              <tr>
                              	<td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Gender</td>
                                <td valign="top">
                                	<label>Female</label><input type="radio" id="female" name="gender" value="female" class="required" />
                                	<label>Male</label><input type="radio" id="male" name="gender" value="male" />
                                </td>
                              </tr>

							  </tr>
                              <tr>
                              	<td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Address</td>
                                <td valign="top"><input type="text" id="address" name="address" class="required" /></td>
                              </tr>
							  <tr>
								
							<td class="number" valign="top">5. </td>
							<td class="label" valign="top">District</td>
							<td valign="top">					  
							<select id="tel2" name="tel2"  onchange="handleProvinceChange()">
								<option value="">Select District</option>
								<option value="Colombo">Colombo</option>
								<option value="Gampaha">Gampaha</option>
								<option value="Kalutara">Kalutara</option>
								<option value="Kandy">Kandy</option>
								<option value="Nuwara eliya">Nuwara Eliya</option>
								<option value="Matale">Matale</option>
								<option value="Puttalam">Puttalam</option>
								<option value="Kurunegala">Kurunegala</option>
								<option value="Galle">Galle	</option>
								<option value="Matara">Matara</option>
								<option value="Hambantota">Hambantota</option>
								<option value="Anuradhapura">Anuradhapura</option>
								<option value="Polonnaruwa">Polonnaruwa</option>
								<option value="Kegalle">Kegalle</option>
								<option value="Ratnapura">Ratnapura</option>
								<option value="Trincomalee">Trincomalee</option>
								<option value="Batticaloa">Batticaloa</option>
								<option value="Ampara">Ampara</option>
								<option value="Badulla">Badulla</option>
								<option value="Monaragala">Monaragala</option>
								<option value="Ratnapura">Ratnapura</option>
								<option value="Jaffna">Jaffna</option>
								<option value="Kilinochchi">Kilinochchi</option>
								<option value="Mannar">Mannar</option>
								<option value="Mullaitivu">Mullaitivu</option>
								<option value="Vavuniya">Vavuniya</option>
								<option value="Abroad">Abroad</option>


							</select>

							<br><br>
   								 <input type="text" id="country" name="country"placeholder="Enter Country">
							</td> 
							<script>
									function handleProvinceChange() {

										var provinceSelect = document.getElementById('tel2');
										
										var countryTextbox = document.getElementById('country');


										var selectedOption = tel2.value;
        
										if (selectedOption === 'Abroad') {
											
											country.style.display = 'block';
											country.class='required'
											country.value = '';
											countryTextbox.setAttribute('required', '');
										} else {
											
											countryTextbox.style.display = 'none';
											countryTextbox.removeAttribute('required', '');
										}
									}


							</script>

							<tr>
							<td class="number" valign="top">6. </td>
							<td class="label" valign="top">Province</td>
								<td> <input type="text" id="tel3" name="tel3" size="10" readonly ></td>
							</tr>
						</form>

						<script>
							
					document.addEventListener('DOMContentLoaded', function() {
						const districtSelect = document.getElementById('tel2');
						const provinceInput = document.getElementById('tel3');

						// Define a mapping of districts to provinces
						const districtToProvince = {
							'Jaffna':'Northern',
							'Kilinochchi':'Northern',
							'Mannar':'Northern',
							'Mullaitivu':'Northern',
							'Vavuniya':'Northern',
							'Puttalam':'NorthWestern',
							'Kurunegala':'NorthWestern',
							'Gampaha':'Western',
							'Colombo':'Western',
							'Kalutara':'Western',
							'Anuradhapura':'NorthCentral',
							'Polonnaruwa':'NorthCentral',
							'Matale':'Central',
							'Kandy':'Central',
							'Nuwara eliya':'Central',
							'Kegalle':'Sabaragamuwa',
							'Ratnapura':'Sabaragamuwa',
							'Trincomalee':'Eastern',
							'Batticaloa':'Eastern',
							'Ampara':'Eastern',
							'Badulla':'Uva',	
							'Monaragala':'Uva',	
							'Hambantota':'Southern',
							'Matara':'Southern',	
							'Galle':'Southern',
							'Abroad':'Abroad' 
						};

						// Function to update province based on selected district
						function updateProvince() {
							const selectedDistrict = districtSelect.value;

							if (selectedDistrict in districtToProvince) {
								const province = districtToProvince[selectedDistrict];
								provinceInput.value = province;
							} else {
								provinceInput.value = ''; // Clear province field if district not found
							}
						}

						// Event listener to update province on district selection change
						districtSelect.addEventListener('change', updateProvince);
					});

    </script>

						</tr>
							 <tr>
                              	<td class="number" valign="top">7. </td>
                                <td class="label" valign="top">Contact Number</td>
                                <td valign="top"><input type="text" id="tel" name="tel" class="required" /><br /><br />
				    
							</tr>

							<tr>
											<td class="number" valign="top">8. </td>
											<td class="label" valign="top">Religion</td>
											<td valign="top">
											<select name="religion" id="religion" class="required">
											<option value="Buddhist">Buddhist</option>
											<option value="Christian"selected>Christian</option>
											<option value="Roman Catholic">Romancatolic</option>
											<option value="Hindu">Hindu</option>
											<option value="Islam">Islam</option>
											<option value="Other">Other</option>
											</select>
							</tr>


							<tr>
											
								<td class="number" valign="top">9. </td>
								<td class="label" valign="top">Prefrred Language</td>
								<td valign="top">
								<select name="language" id="Language" class="required">
								<option value="Sinhala"selected>Sinhala</option>
								<option value="Tamil">Tamil</option>
								<option value="English">English</option>
								<option value="Other">Other</option>
								</select>
								</tr>
								
								<tr>
                              	<td class="number" valign="top">10.</td>
                                <td class="label" valign="top">Place of Work</td>
                                <td valign="top"><input type="text" id="workplace" name="workplace" class="required" /></td>
                              </tr>
							  
							 

                              <tr>
                              	<td class="number" valign="top">11. </td>
                                <td class="label" valign="top">Prayer/Counseliing Friend/Other</td>
                                <td valign="top"><input type="text" id="pcfo" name="pcfo" class="required" /></td>
                              </tr>
                    </table>
        		</fieldset>
                <fieldset>
                	<legend>Summary Of The Prayer Session </legend>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                              <tr>
                              	<td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Problem Definition
								<div style="padding-top:90px;">Case Study</div>
								</td>
                                <td valign="top">
                                	<label>Marriage</label><input type="checkbox" id="marriage" name="marriage" />
                                    <label>Financial</label><input type="checkbox" id="financil" name="financil" />
                                    <label>Family</label><input type="checkbox" id="family" name="family" />
                                    <label>Addiction</label><input type="checkbox" id="addiction" name="addiction" />
                                    <label>Personal</label><input type="checkbox" id="personal" name="personal" />
                                    <label>Sickness</label><input type="checkbox" id="sickness" name="sickness" />
                                    <label>Other</label><input type="checkbox" id="other" name="other" />
                                    <br /><br /><br />
                                    <textarea cols="30" name="problem" id="problem" rows="6" class="required"></textarea>
                                    <script type="text/javascript">
										CKEDITOR.replace( 'problem',{toolbar : 'seekerTools'});
									    CKEDITOR.instances["problem"].on("instanceReady", function(){this.document.on("keyup", updateproblem);});		
									</script>
                                </td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Solutions</td>
                                <td valign="top"><textarea name="solutions" id="solutions" cols="30" rows="6" class="required"></textarea></td>
                              </tr>
								<script type="text/javascript">
									CKEDITOR.replace( 'solutions',{toolbar : 'seekerTools'});
									 CKEDITOR.instances["solutions"].on("instanceReady", function(){this.document.on("keyup", updatesolutions);});				
								</script>
                              <tr>
                              	<td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Response of the Prayer Seeker : </td>
                                <td valign="top"><textarea name="response" id="response" cols="30" rows="6" class="required"></textarea></td>
                              </tr>
								<script type="text/javascript">
									CKEDITOR.replace( 'response',{toolbar : 'seekerTools'});
									 CKEDITOR.instances["response"].on("instanceReady", function(){this.document.on("keyup", updateresponse);});
								</script>
                              <tr>
                              	<td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Comments From Leader Of Counselors
								</td>
								<?php if ($_SESSION['type']=='Lead Counselor'){ ?> <td valign="top"><textarea name="comments" id="comments" cols="30" rows="6"></textarea></td><?php }?>
                                <td valign="top"><p>This field can be added only by the <strong>Leader Of Counselors (user role)</strong></p></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Goal / Follow up measures  </td>
                                <td valign="top"><textarea name="followup" id="followup" cols="30" rows="6" class="required"></textarea></td>
                              </tr>
								<script type="text/javascript">
									CKEDITOR.replace( 'followup',{toolbar : 'seekerTools'});
									CKEDITOR.instances["followup"].on("instanceReady", function(){this.document.on("keyup", updatefollowup);});		
								</script>
                              <tr>
                              	<td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Counselor's Name</td>
                                <td valign="top"><input name="cname" type="text" id="cname" class="required"/></td>
                              </tr>
                              <tr>
                              	<td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" name="add" id="add" value="Add" /></td>
                              </tr>

							  <input type="hidden" name="ass_counselor" value="non" />
							  <input type="hidden" name="status" value="a0" />
                    </table>
        		</fieldset>
        </td>
      </tr>
    </table>
    </form>
    </fieldset>
</div>
</body>
</html>