
<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
       
<style>
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


 </style>
</head>
<body>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  
    <a class="navbar-brand" href="#">
        <img src="Menubarlogo.png" alt="logo" style="width:30px;">
    </a>
  
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="add_record.php">Add new</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="search.php">Search</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="mylist.php">Caller History</a>
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

</nav><br>
</html>


