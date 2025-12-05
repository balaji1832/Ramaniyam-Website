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


// if (isset($_POST["submit"])) {
// if (count($_POST["ids"]) > 0 ) {

// $ids = $_POST["ids"]; // An array of IDs from the form
// $placeholders = implode(",", array_fill(0, count($ids), "?")); // Generate placeholders (?, ?, ...)

// $stmt = $pdo->prepare("DELETE FROM tbl_projects WHERE p_id IN ($placeholders)");
// $stmt->execute($ids); // Pass the array of IDs

// if( ! $stmt->rowCount() )  {
// $errmsg ="Deletion failed";
// } else {
// $errmsg ="Data has been deleted successfully";
// }
// } else {
// $errmsg = "You need to select atleast one checkbox to delete!";
// }
// }

 error_reporting(0);


if (isset($_GET['action']) && isset($_GET['id'])) {
    

    $id = (int) $_GET['id'];
    $action = $_GET['action'] === 'archive' ? 1 : 0;
  
     $statement = $pdo->prepare("UPDATE tbl_projects SET is_archived=? WHERE p_id=?");
    $statement->execute(array($action,$_REQUEST['id']));
    
       $filter=($_GET['action'] === 'archive' ? 'active' : 'archived');

}



?>

<section class="content-header">
	<div class="content-header-left">
		<h1> Properties</h1>
	</div>
	<div class="content-header-right">
		<a href="project-add.php" class="btn btn-primary btn-sm">Add New Property</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
		    
            <?php if($filter!="") {
             
               $msg="Selected Project $_GET[action] Successfully";  
               echo '<p  id="activemsg" style="color:red;font-size:16px;">'.$msg.'</p>';
            
            } ?>
            <div class="filter-buttons">
            <label>Sort By Filter</label>
            <a href="?filter=all">
            <button class="<?php if($_GET['filter']=='all') { echo 'active'; } ?>">All Projects</button></a>
            <a href="?filter=active"><button class="<?php if($_GET['filter']=='active') { echo 'active'; } ?>">Active Projects </button></a>
            <a href="?filter=archived"><button class="<?php if($_GET['filter']=='archived') { echo 'active'; } ?>">Archived Projects</button></a>
            </div>
            <div>&nbsp;</div>
		    
			<div class="box box-info">
			    <p style="color:red; font-size:16px;"><?php if($errmsg){ echo $errmsg; } ?> </p>
                    <form name="multipledeletion" method="post">
				<!--<input type="submit" name="submit" value="Delete" class="btn btn-primary btn-md pull-left" onClick="return confirm('Are you sure you want to delete?');" >-->
			<div class="table-responsive-new" >
  <table id="details" class="table table-bordered table-striped" >
    <thead>
      <tr>
        <th width="20">#</th>
        <th width="50">Photo</th>
        <th width="150">Project Name</th>
        <th width="100">Status</th>
        <th width="150">Stage</th>
        <th width="120">Availability</th>
        <th width="200">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $i = 0;
      $filter = $_GET['filter'] ?? 'all';
      switch ($filter) {
        case 'archived':
          $stmt = $pdo->prepare("SELECT * FROM tbl_projects WHERE is_archived = 1");
          break;
        case 'active':
          $stmt = $pdo->prepare("SELECT * FROM tbl_projects WHERE is_archived = 0 ORDER BY sales_flats DESC");
          break;
        case 'msg':
          $stmt = $pdo->prepare("SELECT * FROM tbl_projects WHERE is_archived = 0");
          break;
        default:
          $stmt = $pdo->prepare("SELECT * FROM tbl_projects ORDER BY sales_flats DESC");
          break;
      }

      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row) {
        $i++;
      ?>
        <tr>
          <td><?php echo $i; ?></td>
          <td>
            <img src="../assets/uploads/project-images/<?php echo $row['card_image']; ?>" alt="<?php echo $row['p_name']; ?>" style="width: 100px;">
          </td>
          <td><?php echo $row['title']; ?></td>
          <td>
              <?php
               $project_stage = $row["project_status"];
   echo $project_status = str_replace('-', ' ', $project_stage);
              ?>
          
          
          </td>
          <td><?php echo $row['project_stage']; ?></td>
          
          <td>
              
        
    <?php
    $stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM tbl_flats WHERE p_id = ?");
    $stmt->execute([$row['p_id']]);
     $total = $stmt->fetchColumn();

    if ($total == 0) {
        echo "To Be Updated";
    } else {
        
      $stmtAvailable = $pdo->prepare("SELECT COUNT(*) FROM tbl_flats WHERE p_id = ? AND avaliable = 'Avaliable'");
      
      $stmtAvailable->execute([$row['p_id']]);
      
       $available = $stmtAvailable->fetchColumn();
       
       echo ($available > 0) ? "Available" : "Sold Out";

    }
?>
          
          
          </td>
          <td style="text-align:center;">
            <?php if ($row['is_archived']): ?>
              <a href="projects.php?action=unarchive&id=<?php echo $row['p_id']; ?>&filter=archived" onclick="return confirm('Are You Sure You Want to Unarchive this project?')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-archive-fill-up" viewBox="0 0 16 16">
                  <path d="M12.643 2.5H3.357A1.357 1.357 0 0 0 2 3.857v.786c0 .2.16.357.357.357h11.286a.357.357 0 0 0 .357-.357v-.786A1.357 1.357 0 0 0 12.643 2.5z"/>
                  <path d="M2 5.286V12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5.286H2zm6 2.707V12a.5.5 0 0 1-1 0V8.293L5.354 9.939a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 1 1-.708.708L8 8.293z"/>
                </svg>
              </a>
            <?php else: ?>
              <a href="project-edit.php?id=<?php echo $row['p_id']; ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-pencil-square" viewBox="0 0 16 16">
                  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293z"/>
                  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </a>
              <br>
              <a href="projects.php?action=archive&id=<?php echo $row['p_id']; ?>&filter=active" onclick="return confirm('Are you sure you want to Archive this Project?')">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-archive" viewBox="0 0 16 16">
                  <path d="M12.643 2.5H3.357A1.357 1.357 0 0 0 2 3.857v.786c0 .2.16.357.357.357h11.286a.357.357 0 0 0 .357-.357v-.786A1.357 1.357 0 0 0 12.643 2.5zM2 5.286V12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V5.286H2zM5.5 9.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                </svg>
              </a>
            <?php endif; ?>
            <p><a class="btn" style="background-color: #932223; color: #fff; width: 125px;" href="manageflats.php?id=<?php echo $row['p_id']; ?>">Inventory</a></p>
            <p><a class="btn" style="background-color: #932223; color: #fff; width: 125px;" href="updateprojectimages.php?id=<?php echo $row['p_id']; ?>">Images</a></p>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

				</form>
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
                <!--<p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>


<script type="text/javascript">
$(document).ready(function(){
$('#select_all').on('click',function(){
if(this.checked){
$('.checkbox').each(function(){
this.checked = true;
});
}else{
$('.checkbox').each(function(){
this.checked = false;
});
}
});
$('.checkbox').on('click',function(){
if($('.checkbox:checked').length == $('.checkbox').length){
$('#select_all').prop('checked',true);
}else{
$('#select_all').prop('checked',false);
}
});
});
</script>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("details");
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

<script>
  setTimeout(function() {
    var msg = document.getElementById("activemsg");
    if (msg) {
      msg.style.display = "none";
    }
  }, 5000); // 5000 milliseconds = 5 seconds
</script>


<!-- Bottom of your PHP file, just before </body> -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const tableContainer = document.querySelector(".table-responsive-new");
    const table = document.getElementById("details");

    if (table) {
      table.style.minWidth = "1000px"; // Ensure overflow
    }

    function applyScroll() {
      if (tableContainer.scrollWidth > tableContainer.clientWidth) {
        tableContainer.style.overflowX = "auto";
      } else {
        tableContainer.style.overflowX = "hidden";
      }
    }

    applyScroll();
    window.addEventListener("resize", applyScroll);
  });
</script>



