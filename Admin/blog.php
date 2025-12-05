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
  
      $statement = $pdo->prepare("UPDATE tbl_post SET is_archived=? WHERE post_id=?");
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
		<h1>View Blogs</h1>
	</div>
	<div class="content-header-right">
		<a href="blog-add.php" class="btn btn-primary btn-sm">Add Blog</a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
		    
		    <?php if($filter!="") {
             
               $msg="Selected Blog $_GET[action] Successfully";  
               echo '<p  id="activemsg" style="color:red;font-size:16px;">'.$msg.'</p>';
            
            } ?>
            <div class="filter-buttons">
            <label>Sort by Filter</label>
            <a href="?filter=all">
            <button class="<?php if($_GET['filter']=='all') { echo 'active'; } ?>">All Blogs</button></a>
            <a href="?filter=active"><button class="<?php if($_GET['filter']=='active') { echo 'active'; } ?>">Active Blogs </button></a>
            <a href="?filter=archived"><button class="<?php if($_GET['filter']=='archived') { echo 'active'; } ?>">Archived Blogs</button></a>
            </div>
            
            <div>&nbsp;</div>
		     
		    
		 <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
			<div class="box box-info">
				<div class="box-body table-responsive">
					<table id="blog" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th width="30">#</th>
								<th>Photo</th>
								<th >Title</th>
								 <th>Date</th> 
									<!-- <th>Blog Comments Count </th> -->
								<th>Action</th>
							
									
								</tr>
								</thead>
								<tbody>
								<?php
								// $i=0;
								// $statement = $pdo->prepare("SELECT * FROM tbl_post");
								// $statement->execute();
								// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
								
								 $i=0;
                            $filter = $_GET['filter'] ?? 'all';
                            switch ($filter) {
                            case 'archived':
                            $stmt = $pdo->prepare("SELECT * FROM tbl_post WHERE   is_archived = 1 order by post_id DESC ");
                            break;
                            case 'active':
                            $stmt = $pdo->prepare("SELECT * FROM tbl_post WHERE    is_archived = 0 order by post_id DESC");
                            break;
                            case 'msg':
                            $stmt = $pdo->prepare("SELECT * FROM tbl_post WHERE    is_archived = 0 order by post_id DESC");
                            break;
                            default:
                            $stmt = $pdo->prepare("SELECT * FROM tbl_post order by post_id DESC   ");
                            break;
                            }
							$stmt->execute();
							$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
								
								foreach ($result as $row) {
								// $sql =
								// "SELECT count(postid) as countpost FROM `comments` WHERE postid = '".$row['post_id']." '";
								// $result = $pdo->prepare($sql); 
								// $result -> execute();
								// $row_count = $result->fetch(PDO::FETCH_ASSOC);
								$i++;
								?>
								<tr>
								<td><?php echo $i; ?></td>
								<td><img src="../assets/uploads/<?php echo $row['photo']; ?>" 
									alt="" 
									style="width:150px;"></td>
								<td><?php echo $row['post_title']; ?></td>
								<td><?php echo $row['post_date']; ?></td>
								<!-- <td><?php echo substr ($row['post_content'],0,150); ?></td>  -->
								<!-- <td><a href="view-comments.php?id=<?php echo $row['post_id']; ?>"><?php echo $row_count['countpost']; ?></a></td> -->
								
								<td>										
							
							   
							   
							   <?php if ($row['is_archived']): ?>
							   
							    
                                          

                                       <p>	<a href="blog-edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Edit</a></p>

							    	  <p><a href="blog-copy.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Copy</a> </p>
                                           
                                          <p>    <a  class="btn btn-danger btn-xs" href="blog.php?action=unarchive&id=<?php echo $row['post_id']; ?>" onclick="return confirm('Are You Sure You Want to Unarchive this Blog?')" >UnArchive</a> </p>




                                           
                                            
                                            
                                            <?php else: ?>

                                            	<p><a href="blog-edit.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Edit</a></p>

                                            	 <p> <a href="blog-copy.php?id=<?php echo $row['post_id']; ?>" class="btn btn-primary btn-xs">Copy</a></p>
                                           
                                             <p><a  class="btn btn-danger btn-xs" href="blog.php?action=archive&id=<?php echo $row['post_id']; ?>" onclick="return confirm('Are You Sure You Want to Archive this Blog?')" >Archive</a>


                                               </p>
                                            
                                            <?php endif; ?>
							   
							   
								<!-- <a href="#" class="btn btn-danger btn-xs" data-href="service-delete.php?id=<?php echo $row['post_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a> -->
								</td>
							
								</tr>
								<?php
								}
								?>							
						</tbody>
					</table>
				</div>
			</div>
			</form>
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
                <a class="btn btn-danger btn-ok ">Delete</a>
				<!-- <a href="#" class="btn btn-danger btn-xs btn-danger btn-ok" data-href="service-delete.php?id=<?php echo $row['post_id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a> -->
            </div>
        </div>
    </div>
</div>





<?php require_once('footer.php'); ?>


<script>
    function changeStatus(id, action) {
        if (confirm("Are you sure you want to " + action + " this Blog?")) {
            window.location.href = `blog?action=${action}&id=${id}`;
        }
    }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("blog");
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
