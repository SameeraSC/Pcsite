<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']))) {
    header('Location: index.html');
    exit();
}

require_once 'db_dps.class.php';

$mysql = Db::connection();

// Set character set to UTF-8
$mysql->set_charset('utf8');

// Fetch the counselor's client list based on the ass_counselor column in the prayer table
$counselorName = $_SESSION['user'];
$query = "SELECT p.id, p.name, p.tel, p.language, p.religion, p.ass_counselor,p.status
          FROM prayer p
          WHERE p.ass_counselor = ?
          GROUP BY p.id
          ORDER BY FIELD(p.status, 'a0', 'a1', 'a2', 'a3', 'a4', 'a5', 'ina', 'dis')";
// Prepare the query
$stmt = $mysql->prepare($query);
$stmt->bind_param('s', $counselorName);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Caller History</title>    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style> 
    
    
    table {
        font-size: 11px; /* Adjust the font size */
        margin-left: 20px;
    }

    table tr {
        height: 18px; /* Adjust the row height */
    }

    table th, table td {
        padding: 3px; /* Adjust the cell padding */
    }

        .user-badge {
            font-family: Arial, sans-serif;
            display: inline-block;
            position: absolute;
            top: 10px; /* Adjust as needed */
            right: 10px; /* Adjust as needed */
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
            display: none;
            font-size: 12px;
            padding: 4px;
            background-color: white; /* Same as badge background */
            color: #007bff; /* Same as badge text color */
            border-radius: 1px;
            white-space: nowrap;
            position: absolute;
            right: 50px;
            top: 50px;
        }
        .user-badge:hover .user-name 
        
           { display: block; } 
            
    
         /* Define colors for each status */
         .status-a0 {
            background-color:#FFFFFF ; /*  */
         }
         .status-a1 {
            background-color: #c00; /* Light red */
        }
        .status-a2 {
            background-color:  #01962e; /* Light green */
        }
        .status-a3 {
            background-color: #f6fa0d; /* Light yellow */
        }
        .status-a4 {
            background-color: #c99403; /* Light orange */
        }
        .status-a5 {
            background-color:#0268ac; /* Drak Blue */
        }
        .status-ina {
            background-color: #30aafc; /* Light Blue */
        }
        .status-dis {
            background-color: purple;
             color: white; } 
    </style>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  
    <a class="navbar-brand" href="#">
        <img src="Menubarlogo.png" alt="logo" style="width:30px;">
    </a>
  
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="add_record.php">Add new record</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search.php">Search</a>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['type'] == 'IT admin' || $_SESSION['type'] == 'Lead Counselor') { ?>
            <a class="nav-link" href="report1.php">Report 1</a>
            <?php } ?>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['type'] == 'IT admin' || $_SESSION['type'] == 'Lead Counselor') { ?>
            <a class="nav-link" href="report2.php">Report 2</a>
            <?php } ?>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['type'] == 'IT admin') { ?>
            <a class="nav-link" href="int_Serach.php">Int Search</a>
            <?php } ?>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['type'] == 'IT admin' || $_SESSION['type'] == 'Lead Counselor') { ?>
            <a class="nav-link" href="add_user.php">Add User</a>
            <?php } ?>
        </li>
        <li class="nav-item">
            <?php if ($_SESSION['type'] == 'IT admin') { ?>
            <a class="nav-link" href="details_of_pc.php">DPS</a>
            <?php } ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="login.php">Log Out</a>
        </li>
    </ul>

    <div class="user-badge">
                <span class="user-initials"><?php echo substr($_SESSION['fname'], 0, 1) . substr($_SESSION['lname'], 0, 1); ?></span>
                <span class="user-name"><?php echo $_SESSION['fname'] . ' ' . $_SESSION['lname']; ?></span>
            </div>
</nav>

<div id="outter_div">
    <p style="color:red;" >&nbsp;&nbsp;Caller History&nbsp;[This page is under development]</p>  
   
    
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Ref. No</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>Religion</th>
        </tr>

       
        <?php while ($row = $result->fetch_assoc()) { 
    // Check if the status is set, otherwise assign a default
    $status = isset($row['status']) ? $row['status'] : 'unknown';
    
    // Set a CSS class for the name column based on the status value
    $nameClass = 'status-' . str_replace(' ', '-', strtolower($status));
?>
    <tr>
        <td><a href="profile_view.php?id=<?php echo $row['id']; ?>"><?php echo $row['id']; ?></a></td>
        <!-- Apply the nameClass to the <td> for the name -->
        <td class="<?php echo $nameClass; ?>"><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['tel']); ?></td>
        <td><?php echo htmlspecialchars($row['religion']); ?></td>
    </tr>
<?php } ?>

    </table>
</div>

</body>
</html>

<?php
// Close statement and connection
$stmt->close();
$mysql->close();
?>
