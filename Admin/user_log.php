<?php require_once('header.php'); ?>

<style type="text/css">

.cloned-header {
  position: fixed;
  top: 0;
  z-index: 1000;
  background-color: #932223 !important;
  display: none;
  overflow: hidden;
  border-collapse: collapse;
}

.cloned-header th {
  background-color: #932223 !important;
  border: 1px solid #ddd;
}  

.main-header {
    
    position:relative !important;
}

  .filter-buttons a button { padding: 10px 15px; margin: 0 5px; cursor: pointer;color:#000; }
        .filter-buttons a button.active { background-color: #932223; color: white; border: none;

</style>
<?php

// Your database connection setup (as provided in your last snippet)
// This part should ideally be in a separate file like 'inc/config.php'
// and then required here: require_once 'inc/config.php';
$servername = "localhost"; // Your database host
$username = "ramaniyamnewayat_user"; // Your database username
$password = "=AX;D=Mlq5IG"; // Your database password
$dbname = "ramaniyamnewayat_dbase"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Log the error (do NOT display sensitive info in production)
    error_log("Database Connection Failed: " . $conn->connect_error);
    // In production, you might show a generic error message or redirect
    die("Sorry, there was a problem connecting to the database. Please try again later.");
}

// Optional: Set character set
$conn->set_charset("utf8mb4");

// --- IMPORTANT DEBUGGING STEP ---
// This check was for a previous error. Keep it for initial testing if needed,
// but it will likely pass now. Can be removed in production.
if (!isset($conn) || $conn === null || !($conn instanceof mysqli)) {
    die("Error: Database connection variable \$conn is not properly set up.");
}
// --- END DEBUGGING STEP ---

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- Pagination Variables ---
$records_per_page = 20; // Number of log entries per page
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// --- Filtering Variables ---
$filter_username = $_GET['username'] ?? '';
$filter_action = $_GET['action'] ?? '';
$filter_module = $_GET['module'] ?? '';
$filter_status = $_GET['status'] ?? '';
$filter_start_date = $_GET['start_date'] ?? '';
$filter_end_date = $_GET['end_date'] ?? '';

// Safely get user_id from GET, default to null if not set or not an integer
$user_id_filter = isset($_GET['id']) ? (int)$_GET['id'] : null;


// --- Build SQL Query with Filtering and Ordering ---
$sql = "SELECT * FROM admin_log WHERE 1=1"; // Start with a true condition to easily append AND clauses

$params = [];
$param_types = "";

// ADD THIS BLOCK: Handle user_id filter securely
if ($user_id_filter !== null) {
    $sql .= " AND user_id = ?";
    $params[] = $user_id_filter;
    $param_types .= "i"; // 'i' for integer
}


if (!empty($filter_username)) {
    $sql .= " AND username LIKE ?";
    $params[] = '%' . $filter_username . '%';
    $param_types .= "s";
}
if (!empty($filter_action)) {
    $sql .= " AND action LIKE ?";
    $params[] = '%' . $filter_action . '%';
    $param_types .= "s";
}
if (!empty($filter_module)) {
    $sql .= " AND module LIKE ?";
    $params[] = '%' . $filter_module . '%';
    $param_types .= "s";
}
if (!empty($filter_status)) {
    $sql .= " AND status = ?";
    $params[] = $filter_status;
    $param_types .= "s";
}
if (!empty($filter_start_date)) {
    $sql .= " AND timestamp >= ?";
    $params[] = $filter_start_date . ' 00:00:00'; // Start of the day
    $param_types .= "s";
}
if (!empty($filter_end_date)) {
    $sql .= " AND timestamp <= ?";
    $params[] = $filter_end_date . ' 23:59:59'; // End of the day
    $param_types .= "s";
}

$sql .= " ORDER BY timestamp DESC LIMIT ?, ?"; // Always order by timestamp DESC
$params[] = $offset;
$params[] = $records_per_page;
$param_types .= "ii"; // Add types for LIMIT parameters

// --- Prepare and Execute Statement for Log Data ---
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement for log data: " . $conn->error . "<br>SQL Query: " . htmlspecialchars($sql));
}

// Bind parameters dynamically
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
$log_entries = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// --- Get Total Records for Pagination ---
$count_sql = "SELECT COUNT(*) AS total_records FROM admin_log WHERE 1=1"; // Base for count
$count_params = [];
$count_param_types = "";

// ADD THIS BLOCK: Handle user_id filter securely for count query
if ($user_id_filter !== null) {
    $count_sql .= " AND user_id = ?";
    $count_params[] = $user_id_filter;
    $count_param_types .= "i"; // 'i' for integer
}

// Re-apply filtering conditions for the count query (without LIMIT)
if (!empty($filter_username)) {
    $count_sql .= " AND username LIKE ?";
    $count_params[] = '%' . $filter_username . '%';
    $count_param_types .= "s";
}
if (!empty($filter_action)) {
    $count_sql .= " AND action LIKE ?";
    $count_params[] = '%' . $filter_action . '%';
    $count_param_types .= "s";
}
if (!empty($filter_module)) {
    $count_sql .= " AND module LIKE ?";
    $count_params[] = '%' . $filter_module . '%';
    $count_param_types .= "s";
}
if (!empty($filter_status)) {
    $count_sql .= " AND status = ?";
    $count_params[] = $filter_status;
    $count_param_types .= "s";
}
if (!empty($filter_start_date)) {
    $count_sql .= " AND timestamp >= ?";
    $count_params[] = $filter_start_date . ' 00:00:00';
    $count_param_types .= "s";
}
if (!empty($filter_end_date)) {
    $count_sql .= " AND timestamp <= ?";
    $count_params[] = $filter_end_date . ' 23:59:59';
    $count_param_types .= "s";
}

$count_stmt = $conn->prepare($count_sql);

if ($count_stmt === false) {
    die("Error preparing count statement: " . $conn->error . "<br>SQL Count Query: " . htmlspecialchars($count_sql));
}

if (!empty($count_params)) {
    $count_stmt->bind_param($count_param_types, ...$count_params);
}

$count_stmt->execute();
$count_result = $count_stmt->get_result();
$total_records = $count_result->fetch_assoc()['total_records'];
$count_stmt->close();

$total_pages = ceil($total_records / $records_per_page);

$conn->close();

?>


<section class="content-header">
	<div class="content-header-left">
		<h1>View UserLog Activities </h1>
	</div>
	<div class="content-header-right">
		<a href="user.php" class="btn btn-primary btn-sm">Back To User </a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
				    
				     <form action="user_log.php" method="GET">
				    
                     <div class="filter-form">
                        
                             <div class="row">
                            <div class="col-md-4 pl-3"> 
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($filter_username); ?>">
                            </div>
                             <div class="col-md-4 pl-3"> 
                            <label for="action">Action:</label>
                            <input type="text" id="action" name="action" value="<?php echo htmlspecialchars($filter_action); ?>">
                            </div>
                            <div class="col-md-4 pl-3"> 
                            <label for="module">Module:</label>
            <input type="text" id="module" name="module" value="<?php echo htmlspecialchars($filter_module); ?>">
                            </div>

                            </div>
                            <div>&nbsp;</div>
                             <div class="row pt-4">
                            <div class="col-md-4 pl-3"> 
                             <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($filter_start_date); ?>">
                            </div>
                             <div class="col-md-4 pl-3"> 
                            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($filter_end_date); ?>">
                            </div>
                            
                            <div class="col-md-4">
                            <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                            <button class="btn btn-danger btn-sm" type="button" onclick="window.location.href='user_log.php'">Clear Filters</button>
                            </div>

                            </div>
                    
                    </div>
                    
                    </form>
                    
                    <div>&nbsp;</div>

               <table id="example1" class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>#</th>
                <th>Timestamp</th>
                <th>Username</th>
                <th>Action</th>
                <th>Module</th>
                <!--<th>Item ID</th>-->
                <!--<th>Old Value</th>-->
                <!--<th>New Value</th>-->
                <th>IP Address</th>
                <th>User Agent</th>
                <!--<th>Status</th>-->
            </tr>
        </thead>
        <tbody>
            
            <?php if (!empty($log_entries)): ?>
                <?php
                
                
                $i=1;
                foreach ($log_entries as $entry): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td>
                            <?php echo htmlspecialchars($entry['timestamp']);
                            
                            
                            
                            
                            
                            
                            ?></td>
                        <td><?php echo htmlspecialchars($entry['username']); ?></td>
                        <td><?php echo htmlspecialchars($entry['action']); ?></td>
                        <td><?php echo htmlspecialchars($entry['module']); ?></td>
                        <!--<td><?php echo htmlspecialchars($entry['item_id']); ?></td>-->
                        <!--<td style="white-space: pre-wrap;"><?php echo htmlspecialchars($entry['old_value']); ?></td>-->
                        <!--<td style="white-space: pre-wrap;"><?php echo htmlspecialchars($entry['new_value']); ?></td>-->
                        <td><?php echo htmlspecialchars($entry['ip_address']); ?></td>
                        <td title="<?php echo htmlspecialchars($entry['user_agent']); ?>">
                            <?php echo strlen($entry['user_agent']) > 50 ? htmlspecialchars(substr($entry['user_agent'], 0, 50)) . '...' : htmlspecialchars($entry['user_agent']); ?>
                        </td>
                        <!--<td><?php echo htmlspecialchars($entry['status']); ?></td>-->
                    </tr>
                <?php $i++; endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11">No log entries found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

				
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("example1");
    const thead = table.querySelector("thead");
    
    // Clone the thead
    const clonedHeader = thead.cloneNode(true);
    const clonedTable = document.createElement("table");
    clonedTable.className = "cloned-header table table-bordered table-striped";
    clonedTable.appendChild(clonedHeader);
    document.body.appendChild(clonedTable);

    // Match column widths
    function matchColumnWidths() {
      const originalThs = thead.querySelectorAll("th");
      const clonedThs = clonedHeader.querySelectorAll("th");
      clonedTable.style.width = `${table.offsetWidth}px`;
      originalThs.forEach((th, i) => {
        clonedThs[i].style.width = `${th.offsetWidth}px`;
      });
    }

    // Scroll behavior
    window.addEventListener("scroll", function () {
      const rect = table.getBoundingClientRect();
      const isVisible = rect.top <= 0 && rect.bottom > clonedHeader.offsetHeight;

      if (isVisible) {
        clonedTable.style.display = "table";
        clonedTable.style.left = `${table.getBoundingClientRect().left}px`;
        matchColumnWidths();
      } else {
        clonedTable.style.display = "none";
      }
    });

    window.addEventListener("resize", matchColumnWidths);
  });
</script>


<?php require_once('footer.php'); ?>