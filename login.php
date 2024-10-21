<?php
session_start();

if (!(isset($_POST['un']) && isset($_POST['pw']))) {
    header('Location: index.html');
    exit();
}

require_once 'db.class.php'; // Assuming this file handles your database connection
$mysql = Db::connection(); // Use your method to establish a database connection

$username = trim($_POST['un']);
$password = trim($_POST['pw']);

// Example of SQL query, modify as per your database structure
$query = sprintf("SELECT id, username, type, fname, lname FROM user WHERE username='%s' AND password='%s'",
    mysql_real_escape_string($username),
    mysql_real_escape_string($password));

$resoc = mysql_query($query);

if (mysql_num_rows($resoc)) {
    while ($row = mysql_fetch_array($resoc, MYSQL_BOTH)) {
        $_SESSION['user'] = $row['username'];
        $_SESSION['type'] = $row['type'];
        $_SESSION['fname'] = $row['fname'];
        $_SESSION['lname'] = $row['lname'];
        header('Location: search.php');
        exit();
    }
} else {
    // Handle invalid credentials
    session_destroy();
    session_start();
    header('Location: index.html');
    exit();
}

mysql_close($mysql);
?>
