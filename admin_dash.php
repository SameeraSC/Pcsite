<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['type'] !== 'IT admin') {
    header('Location: index.html');
    exit();
}

require_once 'db_dps.class.php';
$mysql = Db::connection();
$mysql->set_charset('utf8');

// Fetch new enrollments with counselor assignment pending
$query = "
    SELECT p.id, p.name, p.tel, p.religion, p.language, p.ass_counselor,
           COALESCE((SELECT GROUP_CONCAT(DISTINCT cname SEPARATOR ', ') FROM psession WHERE pid = p.id), 'non') AS canvassed_counselors
    FROM prayer p
    WHERE p.ass_counselor IS NULL OR p.ass_counselor = 'non'
    GROUP BY p.id
    ORDER BY p.id ASC";
$result = $mysql->query($query);


// Fetch list of counselors from the user table
$counselorQuery = "SELECT fname FROM user WHERE type IN ('Counselor', 'IT admin', 'Lead Counselor')";
$counselors = $mysql->query($counselorQuery);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Assign Counselors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .table { margin-left: 20px; font-size: 12px; }
        .table th, .table td { padding: 5px; }
    </style>
</head>
<body>

<p>New enrollments Review</p>

<form method="POST" action="assign_counselor.php">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Canvassed Counselor</th>
               
        </thead>
        <tbody>
            
            <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td><?php echo htmlspecialchars($row['canvassed_counselors']); ?></td>
        <td>
            <select name="counselor[<?php echo $row['id']; ?>]" class="form-control">
                <option value="">Select Counselor</option>
                <?php while ($counselor = $counselors->fetch_assoc()) { ?>
                <option value="<?php echo htmlspecialchars($counselor['fname']); ?>">
                    <?php echo htmlspecialchars($counselor['fname']); ?>
                </option>
                <?php } ?>
            </select>
        </td>
    </tr>
<?php }

            ?>
        </tbody>
    </table>
    <input type="submit" value="Assign Counselors" class="btn btn-primary">
</form>

</body>
</html>
<?php
$mysql->close();
?>
