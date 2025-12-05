<?php require_once('header.php'); ?>

    <?php
error_reporting(0);


if (isset($_POST["commit"])) {

    $valid = 1;

    $pid=$_GET['id'];

    $construction = $_POST['construction'];
    $walls = $_POST['walls'];
    $flooring = $_POST['flooring'];
    $doors =$_POST['doors'];
    $windowsventilators =$_POST['windowsventilators'];
    $plumbing =$_POST['plumbing'];
    $watersupply =$_POST['watersupply'];
    $kitchen =$_POST['kitchen'];
    $electrical =$_POST['electrical'];
    $others =$_POST['others'];

    // Getting photo ID to unlink from folder
    $statement = $pdo->prepare("SELECT * FROM tbl_spefications WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $rowCount = $statement->rowCount(); // number of rows found
    $result = $statement->fetch(PDO::FETCH_ASSOC);                           

// Unlink the photo
if($rowCount >= 0 ) {


      $query = "UPDATE tbl_spefications SET construction=:construction, walls=:walls, flooring=:flooring,doors=:doors
        ,windows=:windowsventilators,kitchen=:kitchen,plumbing=:plumbing,watersupply=:watersupply,
        electrical=:electrical,others=:others, p_id=:p_id

        WHERE p_id=:p_id LIMIT 1";
        $statement = $pdo->prepare($query);

        $data = [
            ':construction' => $construction,
            ':walls' => $walls,
            ':flooring' => $flooring,
            ':doors' => $doors,
            ':windowsventilators' => $windowsventilators,
            ':plumbing' => $plumbing,
            ':kitchen' => $kitchen,
            ':watersupply' => $watersupply,
            ':electrical' => $electrical,
            ':others' => $others,
            ':p_id' => $pid
        ];
        $query_execute = $statement->execute($data);
    
        $success_message = 'Specifications details is updated successfully!';

      
} else {

 $statement = $pdo->prepare("INSERT INTO  tbl_spefications (p_id,construction,walls,flooring,doors,windows,kitchen,plumbing,watersupply,electrical,others) VALUES (?,?,?,?,?,?,?,?,?,?,?)");

 $statement->execute(array($pid,$construction,$walls,$flooring,$doors,$windowsventilators,$plumbing,$watersupply,$kitchen,$electrical,$others));

  $success_message = 'Specifications details is updated successfully!';

}

          

   } 


        $statement_show = $pdo->prepare("SELECT * FROM tbl_spefications WHERE p_id=?");
        $statement_show->execute(array($_REQUEST['id']));
        $rowCount = $statement_show->rowCount(); // number of rows found
        $result_row = $statement_show->fetch(PDO::FETCH_ASSOC);



    /**************************end ********************/   


?>
<style type="text/css">
    
    .information-section {
    background-color: #f5f5f5;
    padding: 2%;
    box-shadow: 0 3px 10px rgba(50, 50, 50, 0.17);

    .padding-left-new {

        padding-left: 20px !important;
    }
}
</style>


     <section class="content-header">
	<div class="content-header-left">
	</div>
	<div class="content-header-right">
		<a href="projects.php" class="mb-4 width-fit-content text-decoration-none d-flex flex-row justify-content-start align-items-center mb-3">
       <input type="button" name="commit" value="Back to properties" class="btn text-white bg-brick-red rounded ps-4 pe-4" data-disable-with="Create Flat">
      </a>
	</div>
</section>

            <?php if($error_message): ?>
            <div class="callout callout-danger">
                <p>
                <?php echo $error_message; ?>
                </p>
            </div>
            <?php endif; ?>

            <?php if($success_message): ?>
            <div class="callout callout-success">
                <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

        <form name="flatsadd" method="post" enctype="multipart/form-data" >

            <section class="content-header">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="flat_flat_number">TYPE OF CONSTRUCTION</label>
                         <textarea name="construction"  id="editor1" class="form-control" ><?php echo $result_row['construction']; ?></textarea>
                    </div>

                    <div class="col-md-3  mb-3">
                        <strong><label class="form-label" for="flat_area">WALLS</label></strong>
                        <textarea name="walls" id="editor2" class="form-control"><?php echo $result_row['walls']; ?></textarea>

                    </div>

                    <div class="col-md-3  mb-3">
                        <strong><label class="form-label" for="flat_area">FLOORING</label></strong>
                        <textarea name="flooring" id="editor3" class="form-control"><?php echo $result_row['flooring']; ?></textarea>

                    </div>

                   <div class="col-md-3  mb-3">

                        <strong><label class="form-label" for="flat_area">DOORS</label></strong>

                <textarea name="doors" id="editor4" class="form-control"><?php echo $result_row['doors']; ?></textarea>

                    </div>
                </div>

                <div class="">&nbsp;</div>

                <div class="row">

                     <div class="mb-3 col-md-3 d-inline-block">

                        <strong><label class="form-label" for="flat_type">WINDOWS AND VENTILATORS</label></strong>

            <textarea name="windowsventilators" id="editor5" class="form-control"><?php echo $result_row['windows']; ?></textarea>
  
                    </div>

                    <div class="mb-3 col-md-3 d-inline-block">

                        <strong><label class="form-label" for="flat_terrace">KITCHEN</label></strong>

        <textarea name="kitchen" id="editor6" class="form-control"><?php echo $result_row['walls']; ?></textarea>
                    </div>

                    <div class="mb-3 col-md-3 d-inline-block">
                        <div class="mb-3">
                            <strong><label class="form-label">PLUMBING AND SANITARY FITTINGS</label></strong>

                         <div>

                        <textarea name="plumbing" id="editor7" class="form-control"><?php echo $result_row['kitchen']; ?></textarea>  
                        
                        </div>

                        </div>
                    </div>

                    <div class="mb-3 col-md-3 d-inline-block">

                        <div class="mb-3 form-normal-padding form-check form-switch">
                            <strong><label class="form-label float-start" for="flat_available"> WATER SUPPLY</label></strong>

               <textarea name="watersupply" id="editor8" class="form-control"><?php echo $result_row['watersupply']; ?></textarea> 

                        </div>

                    </div>



                    <div class="mb-3 col-md-3 d-inline-block">

                        <div class="mb-3 form-normal-padding form-check form-switch">
                            <strong><label class="form-label float-start" for="flat_available"> ELECTRICAL </label></strong>

                <textarea name="electrical" id="editor9" class="form-control"><?php echo $result_row['electrical']; ?></textarea> 
                    
                        </div>

                    </div>


                      <div class="mb-3 col-md-3 d-inline-block">

                        <div class="mb-3 form-normal-padding form-check form-switch">
                            <strong><label class="form-label float-start" for="flat_available">     OTHERS </label></strong>
                           <textarea name="others" id="editor10" class="form-control"><?php echo $result_row['others']; ?></textarea> 
                        </div>

                    </div>


                </div>
              
                <div>&nbsp;</div>

                <input type="submit" name="commit" value="Update Specfications" class="btn text-white bg-brick-red rounded ps-4 pe-4" data-disable-with="Create Specfications">


            </section>

        </form>

     


        <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure want to delete this item?</p>
                        <!-- <p style="color:red;">Be careful! This product will be deleted from the order table, payment table, size table, color table and rating table also.</p> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <a class="btn btn-danger btn-ok">Delete</a>
                    </div>
                </div>
            </div>
        </div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="modal-body">
                <form id="updateForm" enctype="multipart/form-data">
                    <input type="hidden" id="table_id" name="table_id">

                    <label>Flat number</label>
                    <input type="date" name="flat_number" class="form-control" required>
                    <label>Area</label>
                    <input type="text" class="form-control" name="area">

                    <label> floor</label>
                   <select class="form-select" name="floor" id="flat_floor" style="width:100%;">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>

                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php require_once('footer.php'); ?>



      