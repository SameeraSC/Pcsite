<?php 
session_start();

if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_SESSION['fname']) && isset($_SESSION['lname']))) {
    header('Location: index.html');
    exit();
}

error_reporting(0);
require_once 'db_dps.class.php'; 
$mysqli = Db::connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $searchValue = trim($_POST['serchbox']);

    if ($searchValue !== '') {
        $stmt = null;
        $query = '';

        if (is_numeric($searchValue)) {
            // Search by reference number or contact number
            $query = "SELECT p.id, s.id AS sid, p.name, s.cname 
                      FROM prayer p 
                      LEFT JOIN psession s ON p.id = s.pid 
                      WHERE p.id = ? 
                      OR TRIM(p.tel) = ? 
                      OR TRIM(p.tel2) = ? 
                      OR TRIM(p.tel3) = ? 
                      GROUP BY p.id";
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('ssss', $searchValue, $searchValue, $searchValue, $searchValue);
        } else {
            // Search by name
            $query = "SELECT p.id, s.id AS sid, p.name, s.cname 
                      FROM prayer p 
                      LEFT JOIN psession s ON p.id = s.pid 
                      WHERE p.name LIKE ? 
                      GROUP BY p.id";
            $stmt = $mysqli->prepare($query);
            $searchValue = '%' . $searchValue . '%';
            $stmt->bind_param('s', $searchValue);
        }

        if ($stmt && $stmt->execute()) {
            $result = $stmt->get_result();
            $searchResults = $result->fetch_all(MYSQLI_ASSOC);
        } else {
            $searchResults = [];
        }

        $stmt->close();
    } else {
        $searchResults = [];
    }
} else {
    $searchResults = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Prayer Seeker - Search</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" type="text/css" href="styles/main.css">
<style>
.user-badge {
    display: inline-block;
    position: absolute;
    top: 20px;
    right: 50px;
    background-color: #007bff;
    color: #fff;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    line-height: 40px;
    text-align: center;
    font-size: 18px;
    cursor: pointer;
}
.user-name {
    font-family: Arial, sans-serif;
    display: none;
    font-size: 12px;
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    padding: 4px;
    background-color: white;
    color: #007bff;
    border-radius: 1px;
    white-space: nowrap;
}
.user-badge:hover .user-name {
    display: block;
}
</style>
</head>
<body><nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  
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

</nav>


<div id="outter_div">

    <form method="post" action="int_Serach.php">
        <fieldset>
            <legend>Search</legend>
            <input type="text" id="serchbox" name="serchbox" required placeholder="Enter name, reference number or contact number">
            <input type="submit" name="search" value="Search">
        </fieldset>
    </form>
    <table class="report" cellpadding="5">
        <tr>
            <th>Ref#</th>
            <th>Name</th>
            <th>Counselor</th>
        </tr>
        <?php if (!empty($searchResults)) {
            foreach ($searchResults as $row) { ?>
                <tr>
                    <td><a href="profile_view1.php?id=<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['id']); ?></a></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['cname']); ?></td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td colspan="3" align="center">No results found.</td>
            </tr>
        <?php } ?>
        <tr>
            <td colspan="3" align="center">-- End Of Report --</td>
        </tr>
    </table>
</div>
</body>
</html>
