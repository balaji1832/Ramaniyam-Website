<?php require_once('header.php'); ?>

<?php


if(isset($_REQUEST['tostatus'])) {

    $statement = $pdo->prepare("UPDATE discount_codes SET status=? WHERE id=?");
    $statement->execute(array($_REQUEST['tostatus'],$_REQUEST['codeid']));

}

?>

<section class="content-header">
	<div class="content-header-left">
		<h1> Discount Management </h1>
	</div>
	<div class="content-header-right">
		<a href="discount-add.php" class="btn btn-primary btn-sm">Add New</a>
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
			        <th>SL</th>
                    <th>Discount Code</th>
                    <th>Amount </th>
                    <th>Discount Type</th>
                    <th>Date Valid From  </th>
                    <th>Date Valid To </th>
                     <th>Status </th>

                    <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM discount_codes ORDER BY id ASC");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		?>
					<tr>
                    <td><?php echo $i; ?></td>

                    <td><?php echo $row['code']; ?></td>
                    <td><?php echo $row['amount']; ?></td>
                    <td><?php echo $row['type']; ?></td>

                    <td><?php echo $row['valid_from_date']; ?></td>
                    <td><?php echo $row['valid_to_date']; ?></td>
       
                    <td class="text-center">
                    <?php
                    if($row['status']==1) {
                       $status=0;
                     ?> 
                    <a href="discount.php?codeid=<?php echo $row['id']; ?>&amp;tostatus=<?php echo $status; ?>">
                    <span class="label label-success">Enabled</span> 
                    </a>

                    <?php } else {
                     $status=1;
                        ?>
                    <a href="discount.php?codeid=<?php echo $row['id']; ?>&amp;tostatus=<?php echo $status; ?>">
                    <span class="label label-danger">Disabled</span> 
                    </a>
                    <?php }?>
                    </td> 
    <td>
	                        <a href="discount-edit.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
	                        <a href="#" class="btn btn-danger btn-xs" data-href="discount-delete.php?id=<?php echo $row['id']; ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>
	                    </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
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
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>