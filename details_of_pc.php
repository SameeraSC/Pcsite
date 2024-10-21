<?php
session_start();
if (!(isset($_SESSION['user']) && isset($_SESSION['type']) && isset($_SESSION['fname']) && isset($_SESSION['lname']) && $_SESSION['type'] == 'IT admin')) {
    header('Location: index.html');
    exit();
}
error_reporting(0);
$welcomeMessage = $_SESSION['fname'] . " " . $_SESSION['lname'];

// Include database connection class
require_once 'db_dps.class.php';

// Establish database connection
$conn = Db::connection();
include 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>DPS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
       
<style>
       <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        #outer_div {
            margin-top: 50px;
            padding: 20px;
        }

        .table-container {
            width: 100%;
            overflow-y: auto;
            max-height: 400px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 6px;
            text-align: left;
        }

        .table th {
            background-color: rgb(37,37, 37);
            font-weight: bold;
            font-size: 14px;
            position: sticky;
            top: 0;
            z-index: 10;
            color: white;
        }

        .table td {
            background-color: #ffffff;
            font-size: 13px;
        }
       

        .form-control-sm {
            font-size: 11px;
            padding: .25rem .5rem;
        }

        .modal-body {
            padding: 20px;
        }

        .table tbody tr {
            cursor: pointer; /* Show pointer cursor on hover */
            transition: background-color 0.3s ease; /* Smooth background transition */
        }

        .table tbody tr.highlighted {
            background-color: #e9ecef; /* Light grey background for highlighting */
         }

        .table tbody tr:hover {
            background-color: #f1f1f1; /* Slightly darker grey on hover */
         }
 
        .custom-button {
        border: 2px solid #3b3b3b; /* Custom border color */
        border-left: 0; /* Remove left border to connect seamlessly with input */
        border-radius: 0 4px 4px 0; /* Custom border radius */
        background-color: #3b3b3b; /* Custom background color */
        color: #fff; /* Custom text color */
        width: 58px; /* Custom width */
        height: 27px; /* Custom height */
        font-size:12px;
        }

         .custom-button:hover {
         background-color:red; /* Darker background color on hover */
        border-color: red; /* Matching border color on hover */
          }
        .menubar {
        position: absolute;
   
             top:20px;
             left:20px;
             cursor: pointer;
             }
        .btnmenu{
         font-famliy: 'Georgia, serif';
             font-size:14px;
             }

             
</style>
</head>
<body>


<div class="container-md ">
  <div class="container p-3 my-3 border">
    <div class="row mb-3">
        <div class="col-md-6">
            <form id="regNumberForm" action="" method="POST">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="fromRegNo">From:</label>
                        <input type="text" class="form-control form-control-sm" id="fromRegNo" name="fromRegNo" required>
                    </div>

                     
                    <div class="form-group col-md-6">
                             <label for="toRegNo">To:</label>
                            <div class="input-group mb-3">
                                 <input type="text" class="form-control form-control-sm" id="toRegNo" name="toRegNo" required>
                               
                                 <div class="input-group-append">
                              
                                <button type="button" id="selectLastRegNo" class="btn btn-outline-secondary btn-sm custom-button">Last ID</button>
                                </div>
                            </div>
                           
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Generate List</button>
                
                 </div>
                
             </form> 
        </div>
        
            <div class="col-md-6">
            <form id="dateRangeForm" action="" method="POST">
            
                <div class="form-row">
                    <div class="form-group col-md-6 ">
                        <label for="fromDate">From:</label>
                        <input type="date" class="form-control form-control-sm"  id="fromDate" name="fromDate">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="toDate">To:</label>
                        <input type="date" class="form-control form-control-sm" id="toDate" name="toDate">
                    </div>
                    
               
                </div>
                    <button type="submit" class="btn btn-primary btn-sm">Generate List</button>
                    
            </form>
        </div>
    </div>
</div>

                        
<?php
session_start(); // Start session at the beginning

// Sanitize input function
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Database connection
$conn = new mysqli("localhost", "root", "", "peacecenterdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$whereClause = "";
$orderBy = "ORDER BY p.id ASC"; // Ensure results are ordered by the id column in ascending order
$limit = 50; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Current page

// Validate page number
if ($page < 1) $page = 1;

// Calculate the offset
$offset = ($page - 1) * $limit;

// Check if filter form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store filter inputs in session
    $_SESSION['fromRegNo'] = isset($_POST['fromRegNo']) ? sanitizeInput($_POST['fromRegNo']) : '';
    $_SESSION['toRegNo'] = isset($_POST['toRegNo']) ? sanitizeInput($_POST['toRegNo']) : '';
    $_SESSION['fromDate'] = isset($_POST['fromDate']) ? sanitizeInput($_POST['fromDate']) : '';
    $_SESSION['toDate'] = isset($_POST['toDate']) ? sanitizeInput($_POST['toDate']) : '';
}

// Retrieve filter inputs from session
$fromRegNo = isset($_SESSION['fromRegNo']) ? $_SESSION['fromRegNo'] : '';
$toRegNo = isset($_SESSION['toRegNo']) ? $_SESSION['toRegNo'] : '';
$fromDate = isset($_SESSION['fromDate']) ? $_SESSION['fromDate'] : '';
$toDate = isset($_SESSION['toDate']) ? $_SESSION['toDate'] : '';

// Check if any filter inputs are provided
if (!empty($fromRegNo) && !empty($toRegNo) || !empty($fromDate) && !empty($toDate)) {
    // Check for registration number range filter
    if (!empty($fromRegNo) && !empty($toRegNo)) {
        $whereClause = "WHERE p.id BETWEEN '$fromRegNo' AND '$toRegNo'";
    } 
    // Check for date range filter
    elseif (!empty($fromDate) && !empty($toDate)) {
        $whereClause = "WHERE DATE(p.ts) BETWEEN '$fromDate' AND '$toDate'";
    }

    // SQL query to fetch data based on selected options with pagination
    $sql = "SELECT p.id, p.name, p.ts, p.gender, p.age, p.religion, p.language, p.tel3, p.tel2,
                   MAX(s.cname) as counselor_name,
                   MAX(s.marriage) as marriage, MAX(s.financial) as financial, MAX(s.family) as family,
                   MAX(s.addiction) as addiction, MAX(s.personal) as personal, MAX(s.sickness) as sickness, MAX(s.other) as other
            FROM prayer p
            LEFT JOIN psession s ON p.id = s.pid
            $whereClause
            GROUP BY p.id
            $orderBy
            LIMIT $limit OFFSET $offset";

    // Execute the query
    $result = $conn->query($sql);

    // Total number of records (before pagination)
    $totalRecordsSql = "SELECT COUNT(DISTINCT p.id) as total FROM prayer p $whereClause";
    $totalRecordsResult = $conn->query($totalRecordsSql);
    $totalRecords = $totalRecordsResult ? $totalRecordsResult->fetch_assoc()['total'] : 0;

    // Calculate total pages
    $totalPages = ceil($totalRecords / $limit);

    echo "<div class='record-count'>Total Records:$totalRecords</div>";
    // Pagination controls (top)
    echo "<div class='pagination'>";
    if ($page > 1) {
        echo  " &nbsp <a href='?page=" . ($page - 1) . "'>&laquo; Previous</a> ";
    }
    for ($i = 1; $i <= $totalPages; $i++) {
        $activeClass = ($i == $page) ? " class='active'" : "";
        echo "&nbsp <a href='?page=$i'$activeClass>$i</a> ";
    }
    if ($page < $totalPages) {
        echo "&nbsp <a href='?page=" . ($page + 1) . "'>Next &raquo;</a>";
    }
    echo "</div>";


    // Display the report table
    if ($result && $result->num_rows > 0) {
        echo "<div class='table-container'><table class='table table-striped'>";
        echo "
            <thead>
                <tr>
                    <th style='width: 100px; white-space: nowrap;'>Date</th>
                    <th style='white-space: nowrap;'>Name</th>
                    <th>ID</th>
                    <th style='white-space: nowrap;'>Canvas by</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Religion</th>
                    <th>Language</th>
                    <th>Marriage</th>
                    <th>Financial</th>
                    <th>Family</th>
                    <th>Addiction</th>
                    <th>Personal</th>
                    <th>Sickness</th>
                    <th>Other</th>
                    <th style='white-space: nowrap;'>Province</th>
                    <th style='white-space: nowrap;'>District</th>
                </tr>
            </thead>
            <tbody>";

        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='white-space: nowrap;'>" . date("d-M-y", strtotime($row["ts"])) . "</td>";
            echo "<td style='white-space: nowrap;'>" . $row["name"] . "</td>";
            echo "<td><a href='#' class='record-link' data-id='" . $row["id"] . "'>" . $row["id"] . "</a></td>";
            echo "<td style='white-space: nowrap;'>" . $row["counselor_name"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["age"] . "</td>";
            echo "<td style='white-space: nowrap;'>" . $row["religion"] . "</td>";
            echo "<td style='white-space: nowrap;'>" . $row["language"] . "</td>";
            echo "<td>" . ($row["marriage"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["financial"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["family"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["addiction"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["personal"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["sickness"] ? '1' : '') . "</td>";
            echo "<td>" . ($row["other"] ? '1' : '') . "</td>";
            echo "<td style='white-space: nowrap;'>" . $row["tel3"] . "</td>";
            echo "<td style='white-space: nowrap;'>" . $row["tel2"] . "</td>";
            echo "</tr>";
        }
        echo "</tbody></table></div>";

        // Pagination controls (bottom)
        echo "<div class='pagination'>";
        if ($page > 1) {
            echo "&nbsp<a href='?page=" . ($page - 1) . "'>&laquo; Previous</a> ";
        }
        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = ($i == $page) ? " class='active'" : "";
            echo "&nbsp<a href='?page=$i'$activeClass>$i</a> ";
        }
        if ($page < $totalPages) {
            echo "&nbsp<a href='?page=" . ($page + 1) . "'>Next &raquo;</a>";
        }
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning'>No results found</div>";
    }
} else {
    echo "<div class='alert alert-warning'>No filters applied or no data found</div>";
}

// Close database connection
$conn->close();
?>




</div>

<!-- Modal -->
<div class="modal fade" id="recordModal" tabindex="-1" role="dialog" aria-labelledby="recordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        <div class="modal-header">
                
                <!-- Custom close button -->
                <button type="button" class="btn btn-custom-close" data-dismiss="modal" aria-label="Close">
                    Close
                </button>
            </div>
            <div class="modal-body" id="recordDetails">
                <!-- Record details will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
 $(document).ready(function() {
    // Handle table row click for highlighting
    $('.table tbody').on('click', 'tr', function() {
        $('.table tbody tr').removeClass('highlighted');
        $(this).addClass('highlighted');
    });

    // Handle record link click for AJAX loading details into modal
    $(document).on('click', '.record-link', function(e) {
        e.preventDefault();
        
        var recordId = $(this).data('id');

        $.ajax({
            url: 'fetch_record.php',
            method: 'POST',
            data: { id: recordId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $('#recordDetails').html(response.html); // Update to correct ID
                    $('#recordModal').modal('show'); // Show the modal after loading content
                } else {
                    $('#recordDetails').html('<div class="alert alert-warning">' + response.message + '</div>');
                }
            },
            error: function(xhr, status, error) {
                console.log('AJAX Error: ' + status + ' - ' + error);
                $('#recordDetails').html('<div class="alert alert-danger">An error occurred while fetching the record details.</div>');
            }
        });
    });

    // Set 'To Registration No' to the highest registration number
    $('#selectLastRegNo').on('click', function() {
        $.post('fetch_max_reg_no.php', function(data) {
            $('#toRegNo').val(data.maxRegNo);
        }, 'json');
    });
});

</script>

</body>
</html>
