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

<section class="content-header">
	<div class="content-header-left">
		<h1>View Admin Users</h1>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="30">#</th>
								<th width="180">Name</th>
								<th width="180">Email Address</th>
								<th width="180">Role</th>
								<th>Status</th>
								<th width="180">Change Status</th>
								<th width="100">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$i=1;
							$statement = $pdo->prepare("SELECT * 
														FROM tbl_user 
														 
													");
							$statement->execute();
							$result = $statement->fetchAll(PDO::FETCH_ASSOC);						
							foreach ($result as $row) {
								$i++;
								?>
								<tr class="<?php if($row['cust_status']==1) {echo 'bg-g';}else {echo 'bg-r';} ?>">
									<td><?php echo $i; ?></td>
									<td><?php echo $row['full_name']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td>
										<?php echo $row['role']; ?>
									
									</td>
									<td><?php if($row['status']==1) {
									echo 'Active';} else {echo 'Inactive';} ?></td>
									<td>
									    
									    <?php if($row['status']==1) {?>
										<a href="user-change-status.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-xs">Active</a>
										
										<?php } else { ?>
										    
											<a href="user-change-status.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-xs">Inactive</a>    
										<?php  } ?>
									</td>
								   <td>
										<a href="user_log.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-xs"  >View Logs </a>
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