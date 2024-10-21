<?php 
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']))){
    header('Location: index.html');
    exit();
}

if(isset($_GET['id'])) {
    $prayer = null;
    require_once 'db_dps.class.php';
    $mysqli = Db::connection();
    $mysqli->set_charset('utf8mb4');

    $id = $mysqli->real_escape_string($_GET['id']);
    $query = "SELECT p.id, p.name, p.age, p.address, p.gender, p.tel, p.tel2, p.tel3, p.language, p.religion, p.workplace, p.other, p.ts, p.language AS pts, s.cname, s.ts AS sts 
              FROM prayer p 
              LEFT JOIN psession s ON p.id = s.pid 
              WHERE p.id = $id";
    $result = $mysqli->query($query);

    if ($result && $result->num_rows > 0) {
        $prayer = $result->fetch_assoc();
    } else {
        header('Location: report1.php');
        exit();
    }
} else {
    header('Location: report1.php');
    exit();
} header('Content-Type: text/html; charset=UTF-8');
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Prayer Seeker</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" type="text/css" href="styles/main.css">
   
</head>
<body>
    <div id="outter_div" style="font-size:15px">
    <fieldset>
        <table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial">
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
                <td height="526" valign="top" >
                    <fieldset>
                        <legend>Main Details</legend>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                            <tr>
                                <td class="number" valign="top">&nbsp; </td>
                                <td class="label" valign="top">Ref.No</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Name</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Age</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['age'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Address</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['address'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Gender</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['gender'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Religion</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['religion'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr> 
                            <tr>
                                <td class="number" valign="top">6. </td>
                                <td class="label" valign="top">Contact Number</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['tel'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr> 
                            <tr>
                                <td class="number" valign="top">7. </td>
                                <td class="label" valign="top">District</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['tel2'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr> 
                            <tr>
                                <td class="number" valign="top">8. </td>
                                <td class="label" valign="top">Province</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['tel3'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr> 
                            <tr>
                                <td class="number" valign="top">9. </td>
                                <td class="label" valign="top">Preferred Language</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['language'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>                    
                            <tr>
                                <td class="number" valign="top">10. </td>
                                <td class="label" valign="top">Place of Work</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['workplace'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">11. </td>
                                <td class="label" valign="top">Prayer/Counseling Friend/Other</td>
                                <td valign="top"><?php echo htmlspecialchars($prayer['other'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td valign="top"><a href="edit_record.php?id=<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'); ?>">Edit</a></td>
                            </tr>
                        </table>
                    </fieldset>
                
                    <fieldset>
                        <legend>Summary Of The Prayer Session</legend>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                            <tr>
                                <td valign="top"><a href="add_summary.php?id=<?php echo htmlspecialchars($prayer['id'], ENT_QUOTES, 'UTF-8'); ?>">Add New Summary</a></td>
                            </tr>
                        </table>
                    </fieldset>

                    <?php
                    $query = "SELECT id AS sid, marriage, financial, family, addiction, personal, sickness, other, problem, solutions, response, comments, followup, cname, ts AS sts, user 
                              FROM psession 
                              WHERE pid = $id";
                    $result = $mysqli->query($query);
                    
                    if ($result && $result->num_rows > 0) {
                        while ($psummary = $result->fetch_assoc()) {
                    ?>
                    <fieldset class="summary">
                        <legend id="<?php echo htmlspecialchars($psummary['sid'], ENT_QUOTES, 'UTF-8'); ?>">Summary Of The Prayer Session</legend>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                            <tr>
                                <td class="number" valign="top"> </td>
                                <td class="label" valign="top">Time / Date</td>
                                <td valign="top"><?php echo date("H:i A", strtotime($psummary['sts'])); ?> &nbsp;&nbsp; <?php echo date("Y-m-d", strtotime($psummary['sts'])); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"> </td>
                                <td class="label" valign="top">Counselor's Name</td>
                                <td valign="top"><?php echo htmlspecialchars($psummary['cname'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">1. </td>
                                <td class="label" valign="top">Problem Definition <br /><br /><br />
                                    Case Study <br />
                                </td>
                                <td valign="top">
                                    <?php 
                                    $ptypes = array('marriage', 'financial', 'family', 'addiction', 'personal', 'sickness', 'other');
                                    foreach ($ptypes as $value) {
                                        if((bool)($psummary[$value])){
                                            echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8') . '  ';
                                        }
                                    }
                                    ?>
                                    <br /><br /><br />
                                    <?php if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $psummary['problem']))
                                 {
                                        echo $psummary['problem'];
                                } else { echo nl2br(htmlspecialchars($psummary['problem'], ENT_QUOTES, 'UTF-8'));} ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">2. </td>
                                <td class="label" valign="top">Solutions</td>
                                <td valign="top"><?php if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $psummary['solutions']))
                                 {
                                        echo $psummary['solutions'];
                                } else { echo nl2br(htmlspecialchars($psummary['solutions'], ENT_QUOTES, 'UTF-8'));} ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">3. </td>
                                <td class="label" valign="top">Response of the Prayer Seeker:</td>
                                <td valign="top"><?php if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $psummary['response']))
                                 {
                                        echo $psummary['response'];
                                } else { echo nl2br(htmlspecialchars($psummary['response'], ENT_QUOTES, 'UTF-8'));} ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top">4. </td>
                                <td class="label" valign="top">Comments From Leader Of Counselors</td>
                                <td valign="top"><?php  echo nl2br($psummary['comments']);?></td> 
                            </tr>
                            <tr>
                                <td class="number" valign="top">5. </td>
                                <td class="label" valign="top">Goal / Follow up measures</td>
                                <td valign="top"><?php if (preg_match("/([\<])([^\>]{1,})*([\>])/i", $psummary['followup']))
                                 {
                                        echo $psummary['followup'];
                                } else { echo nl2br(htmlspecialchars($psummary['followup'], ENT_QUOTES, 'UTF-8'));} ?></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top"></td>
                                <?php if(($_SESSION['type'] == 'Lead Counselor' || $_SESSION['user'] == $psummary['user']) &&  (strtotime($psummary['sts']) + 604800) >= time()) {?>
                                    <td valign="top"><a href="add_summary.php?ref=<?php echo htmlspecialchars($psummary['sid'], ENT_QUOTES, 'UTF-8') . '&id=' . htmlspecialchars($_GET['id'], ENT_QUOTES, 'UTF-8'); ?>">Edit</a></td>
                                <?php } ?>
                            </tr>
                        </table>
                    </fieldset> 
                    <?php 
                        }
                    }
                    $mysqli->close();
                    ?>
                    
                </td>
            </tr>
        </table>
    </fieldset>
</div>

</body>
</html>
