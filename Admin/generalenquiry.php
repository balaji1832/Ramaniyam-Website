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
error_reporting(0);
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $action = $_GET['action'] === 'archive' ? 1 : 0;
  
      $statement = $pdo->prepare("UPDATE enquiry_new SET is_archived=? WHERE id=?");
    $statement->execute(array($action,$_REQUEST['id']));
    

       $filter=($_GET['action'] === 'archive' ? 'active' : 'archived');

}

?>
<style type="text/css">


        .filter-buttons a button { padding: 10px 15px; margin: 0 5px; cursor: pointer;color:#000; }
        .filter-buttons a button.active { background-color: #932223; color: white; border: none;
    
</style>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Customer Enquiry Details</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
		    
		    <?php if($filter!="") {
             
               $msg="Selected Users $_GET[action] Successfully";  
               echo '<p  id="activemsg" style="color:red;font-size:16px;">'.$msg.'</p>';
            
            } ?>
            <div class="filter-buttons">
            <label>Sort by Filter</label>
            <a href="?filter=all">
            <button class="<?php if($_GET['filter']=='all') { echo 'active'; } ?>">All Enquiries</button></a>
            <a href="?filter=active"><button class="<?php if($_GET['filter']=='active') { echo 'active'; } ?>">Active Enquiries </button></a>
            <a href="?filter=archived"><button class="<?php if($_GET['filter']=='archived') { echo 'active'; } ?>">Archived Enquiries</button></a>
            </div>
            <div>&nbsp;</div>
		    
		    
			<div class="box box-info">
				<div class="box-body " style="overflow-x: auto; width: 100%; white-space: nowrap;">

				
					<table id="example1" class="table table-bordered table-striped " >
					    
					    
						<thead>
							<tr>
								<th width="30">#</th>
								<th width="180">Name</th>
								<th width="180">Email Address</th>
								<th width="180"> Phone</th>
								<th width="180"> Message</th>
							   <!--<th width="100">project </th>-->
							   		<th width="100">Date </th> 

						
								<th width="100">Action</th>
							
							</tr>
						</thead>
						<tbody>
							<?php
							$i=0;
				// 			$statement = $pdo->prepare("SELECT * 
				// 										FROM enquiry_new 
				// 										 where type='General'
				// 									");
				
				            $i=0;
                            $filter = $_GET['filter'] ?? 'all';
                            switch ($filter) {
                            case 'archived':
                            $stmt = $pdo->prepare("SELECT * FROM enquiry_new WHERE  type='General' and is_archived = 1 ORDER BY id DESC ");
                            break;
                            case 'active':
                            $stmt = $pdo->prepare("SELECT * FROM enquiry_new WHERE   type='General' and is_archived = 0 ORDER BY id DESC");
                            break;
                            case 'msg':
                            $stmt = $pdo->prepare("SELECT * FROM enquiry_new WHERE   type='General' and is_archived = 0 ORDER BY id DESC");
                            break;
                            default:
                            $stmt = $pdo->prepare("SELECT * FROM enquiry_new WHERE   type='General' ORDER BY id DESC ");
                            break;
                            }
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								?>
								<!-- <tr class="<?php if($row['cust_status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>"> -->
									<td><?php echo $i; ?></td>
									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td><?php echo $row['phone']; ?></td>
									<td><?php echo $row['message'];  ?></td>
									<!--<td><?php echo $row['projectname'];  ?></td>-->
									<td><?php echo $row['creationdate'];  ?></td>
									
								
									<!--<td>-->
									<!--	<a href="#" class="btn btn-danger btn-xs" data-href="customer-new-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>-->
									<!--</td>-->
									
								
                                            <td>
                                            <?php if ($row['is_archived']): ?>
                                            <button class="btn btn-danger btn-xs" onclick="changeStatus(<?php echo $row['id'] ?>, 'unarchive')">Unarchive</button>
                                            <?php else: ?>
                                            <button class="btn btn-danger btn-xs" onclick="changeStatus(<?php echo $row['id'] ?>, 'archive')">Archive</button>
                                            <?php endif; ?>
                                            
                                            </td>
									
								</tr>
								<?php
							}
							?>							
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


<?php require_once('footer.php'); ?>

<script>
    function changeStatus(id, action) {
        if (confirm("Are you sure you want to " + action + " this user?")) {
            window.location.href = `generalenquiry.php?action=${action}&id=${id}`;
        }
    }
</script>

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

<script>
  setTimeout(function() {
    var msg = document.getElementById("activemsg");
    if (msg) {
      msg.style.display = "none";
    }
  }, 5000); // 5000 milliseconds = 5 seconds
</script>
