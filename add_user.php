<?php 
session_start();

if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_SESSION['fname']) && isset($_SESSION['lname'])&& ($_SESSION['type'] == 'Lead Counselor' || $_SESSION['type'] == 'IT admin'))) {
    header('Location: index.html');
    exit();
}

require_once 'db_dps.class.php'; 
$mysqli = Db::connection(); 

if (isset($_POST['un']) && strlen(trim($_POST['un'])) > 0) {
    $un = $_POST['un'];
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];
    $pw = $_POST['pw'];
    $ut = $_POST['ur'];
    
    // Prepare and bind
    $stmt = $mysqli->prepare("SELECT id FROM user WHERE username=?");
    $stmt->bind_param("s", $un);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $stmt = $mysqli->prepare("INSERT INTO user (username, fname, lname, password, type) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $un, $fn, $ln, $pw, $ut);
        $stmt->execute();
    }

    $stmt->close();
}
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Prayer Seeker - Screen 1</title>
<link rel="stylesheet" type="text/css" href="styles/main.css" />
</head>
<body>
<div id="outter_div">
   
   
        <table border="0" cellpadding="0" cellspacing="0">      
            <tr>
                <td valign="top">        
                    <fieldset>
                        <legend>Add User</legend>
                        <form method="post" action="add_user.php" onsubmit="return confirm('Are you sure you want to submit data?');">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="elements2">
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">User ID</td>
                                <td valign="top"><input type="text" id="un" name="un" /></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">First Name</td>
                                <td valign="top"><input type="text" id="fn" name="fn" /></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">Last Name</td>
                                <td valign="top"><input type="text" id="ln" name="ln" /></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">Password</td>
                                <td valign="top"><input type="password" id="pw" name="pw" /></td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">User Role</td>
                                <td valign="top">
                                    <select name="ur">
                                        <option>Counselor</option>
                                        <option>Lead Counselor</option>
                                        <option>IT admin</option>
                                        <option>Trainee</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="number" valign="top"></td>
                                <td class="label" valign="top">&nbsp;</td>
                                <td valign="top"><input type="submit" name="update" value="Update" /></td>
                            </tr>
                        </table>
                        </form>         
                        <table class="report" cellpadding="5">
                            <tr>
                                <th>User Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                            </tr>               
                            <?php
                                $result = $mysqli->query("SELECT id, username, fname, lname FROM user");
                                while ($row = $result->fetch_array(MYSQLI_BOTH)) {
                            ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['username']); ?></td>
                                        <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                        <td><?php echo htmlspecialchars($row['lname']); ?></td>
                                    </tr>
                            <?php
                                }
                            ?>                       
                            <tr>
                                <td colspan="3" align="center">-- End Of Report --</td>
                            </tr>
                        </table>
                    </fieldset>                              
                </td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>
