<?php require_once('header.php'); ?>

<?php

error_reporting(0);

if(isset($_GET['delete_id'])){
// Getting photo ID to unlink from folder
$statement = $pdo->prepare("SELECT * FROM tbl_flats WHERE id=?");
$statement->execute(array($_REQUEST['delete_id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);                           
foreach ($result as $row) {
    $photo = $row['layout'];
}

// Unlink the photo
if($photo!='') {
    unlink('../assets/uploads/project-images/'.$photo);
}

// Delete from tbl_photo
 $statement = $pdo->prepare("DELETE FROM tbl_flats WHERE id=?");
$statement->execute(array($_REQUEST['delete_id']));

}



if (isset($_POST["commit"])) {



    include("inc/log_helper.php");

error_reporting(0);


   $valid = 1;
$error_message = '';
$success_message = '';
$header_final_name = '';
$add_success = false;

$pid = $_GET['id'];

// File Upload
$path = $_FILES['flat']['name']['layout'];
$path_tmp = $_FILES['flat']['tmp_name']['layout'];

if ($path == '') {
    $valid = 1;
    $error_message .= "You must have to select a photo<br>";
} else {
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $file_name = basename($path, '.' . $ext);

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif'])) {
        $valid = 0;
        $error_message .= 'You must upload jpg, jpeg, gif, png, webp, or jfif file<br>';
    } else {
        $uniqueId = time() . '-' . mt_rand();
        $header_final_name = 'flats-layout-' . $uniqueId . '.' . $ext;
        move_uploaded_file($path_tmp, '../assets/uploads/project-images/' . $header_final_name);
    }
}


// If valid, insert into database

    $flat_number = $_POST['flat']['flat_number'];
    // $area = $_POST['flat']['area_min'];
    $size = $_POST['flat']['area_max'];
    $floor = $_POST['flat']['floor'];
    $bed = $_POST['flat']['bedConfig'];
    $toilets = $_POST['flat']['toilets'];
    $totalConfig = $_POST['flat']['totalConfig'];
    $avaliable = $_POST['flat']['avaliable'];

  

    $statement = $pdo->prepare("INSERT INTO tbl_flats (p_id, flat_number, size, floor, bed, toilets, totalconfig, layout, avaliable) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $add_success = $statement->execute([
        $pid, $flat_number, $size, $floor, $bed, $toilets, $totalConfig, $header_final_name, $avaliable
    ]);

   
    // Get last inserted ID for logging
    $last_id = $pdo->lastInsertId();

    $new_name = $flat_number;
    $old_name = "";

    if ($add_success) {
        log_admin_action(
            $_SESSION['userid'],
            $_SESSION['username'],
            'Inventory flats Added',
            'Inventory',
            $last_id,
            $old_name,
            $new_name
        );

        $success_message = 'Flat Details Added successfully!';

         echo '<script>alert("Apartment Details Added Successfully.");</script>';


    } else {
        $error_message .= "Something went wrong while inserting data.<br>";
    }
}



   /**********listing flat details**************/
    $statement = $pdo->prepare("SELECT * FROM tbl_flats WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
     // $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    /************************start*********************/
    
    $statement = $pdo->prepare("SELECT number_of_flats,title,sales_flats FROM tbl_projects WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $flat_count = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    


    $statement = $pdo->prepare("SELECT count(p_id) as countid FROM tbl_flats WHERE p_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $countid = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    
$statement_avaliable = $pdo->prepare("SELECT count(avaliable) as avaliabity FROM tbl_flats WHERE p_id=? AND avaliable=?");
$statement_avaliable->execute(array($_REQUEST['id'], 'Avaliable'));
$row = $statement_avaliable->fetch(PDO::FETCH_ASSOC);
 $total_avaliable = $row['avaliabity'];


    /**************************end ********************/   


?>
            <style type="text/css">
                
                .information-section {
                /*background-color: #f5f5f5;*/
                padding: 1%;
                /*box-shadow: 0 3px 10px rgba(50, 50, 50, 0.17);*/

                .padding-left-new {

                    padding-left: 20px !important;
                }
            }
            </style>


<section class="content-header box box-info">

<div class="content-header-left">
<h1>Add/Manage Inventory </h1>
</div>
<div class="content-header-right">
<a href="projects.php" class="mb-4 width-fit-content text-decoration-none d-flex flex-row justify-content-start align-items-center mb-3">
<input type="button" name="commit" value="Back to properties" class="btn text-white bg-brick-red rounded ps-4 pe-4" data-disable-with="Create Flat">
</a>
</div>
</section>

<section class="content-header box box-info">
    <div class="row">
 
         <div class="col-md-12">
            <div class="row">
             <div class="col-md-4">
            <h2 >Basic Information</h2>
            </div>
             <div class="col-md-8 text-left">
            <h2><b><?php echo $flat_count[0]['title']; ?></b></h2>
            </div>
            </div>
            </div>
            <hr>

        <div class="col-md-12">
            <div class="information-section  ">
                <div class="row">

                     <!--<div class="col-md-3"></div>-->

                     <div class="col-md-12">

                    <div class="row ">
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <button class="number-card bg-brick-red text-white rounded">
                                <?php echo $flat_count[0]['number_of_flats']; ?>
                            </button>
                            <span class="ms-2 text-small-caps padding-left-new">Total Apartments </span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <button class="number-card bg-brick-red text-white rounded">
                                <?php echo $flat_count[0]['sales_flats']; ?>
                            </button>
                            <span class="ms-2 text-small-caps padding-left-new">For Sale </span>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <button class="number-card bg-brick-red text-white rounded">
                                <?php echo $countid[0]['countid']; ?>
                            </button>
                            <span class="ms-2 text-small-caps padding-left-new">Inventory Added</span>
                        </div>
                    </div>
                     </div>
                     
                     <div class="row  mt-4">
                       <div class="col-md-4 mb-3">
                        <div class="d-flex align-items-center">
                            <button class="number-card bg-brick-red text-white rounded">
                                <?php echo $total_avaliable; ?>
                            </button>
                            <span class="ms-2 text-small-caps padding-left-new">
                         

                            <?php  if($total_avaliable <= 0) {

                                    echo "No Inventory ";

                                } else {  echo "Available Apartments";   } ?>


                        </span>
                        </div>
                    </div>
                  
                     </div>   


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
         
            <form name="flatsadd" method="post" enctype="multipart/form-data" >
                  <h2 class="pl-3">Apartment Information</h2>

                <section class="content-header pl-3">
                    <div class="row">

                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="flat_flat_number">Apt # </label>
                            <input class="form-control" type="text" required name="flat[flat_number]" maxlength="6" id="flat_flat_number">
                            (Note - Apt number will include Block Number also)
                        </div>

                        <div class="col-md-3  mb-3">
                            <strong><label class="form-label" for="flat_area" style="text-transform:none !important;" >Size (Saleable Area in Sq Ft)</label></strong>
                                        <input type="number" name="flat[area_max]" required id="area_max" class="form-control" placeholder="">
                        </div>

                        <div class="col-md-3  mb-3">
                            <strong><label class="form-label" for="flat_floor">Floor</label></strong>
                            <select class="form-select" name="flat[floor]" id="flat_floor" style="width:100%;">
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
                                <option value="11">11</option>
                                <option value="12">12</option>
                                <option value="13">13</option>
                                <option value="14">14</option>
                                <option value="15">15</option>
                            </select>
                        </div>

                        <div class="col-md-3  mb-3 ">
                            <strong><label class="form-label" for="flat_facing">Bed Config</label></strong>
                            <select class="form-select" required name="flat[bedConfig]" id="flat_bedconfig" style="width:100%;">
                                <option value="">Select Bed </option>
                                <option value="1BHK">1BHK</option>
                                <option value="2BHK">2BHK</option>
                                <option value="3BHK">3BHK</option>
                                <option value="4BHK">4BHK</option>
                            </select>
                        </div>
                    </div>

                    <div class="">&nbsp;</div>

                    <div class="row">

                                  <div class="mb-3 col-md-3 d-inline-block">

                            <strong><label class="form-label" for="flat_terrace">Toilets</label></strong>

                            <select class="form-select" name="flat[toilets]" id="flat_toilets" style="width:100%;">
                                <option>Select Toilets</option>
                                <option value="1T" selected>1T</option>
                                <option value="2T">2T</option>
                                <option value="3T">3T</option>
                                <option value="4T">4T</option>
                                <option value="5T">5T</option>
                            </select>
                        </div>

                         <div class="mb-3 col-md-3 d-inline-block">

                            <strong><label class="form-label" for="flat_type">Total Config</label></strong>

                            <input class="form-control" type="text" name="flat[totalConfig]" id="totalConfig">

                        </div>

              
                        <div class="mb-3 col-md-3 d-inline-block">
                            <div class="mb-3">
                                <strong><label class="form-label">Layout</label></strong>
                                <div>
                                    <input type="file" name="flat[layout]" id="flat_layout">
                                </div>

                            </div>
                        </div>

                        <div class="mb-3 col-md-3 d-inline-block">

                            <div class="mb-3 form-normal-padding form-check form-switch">
                                <strong><label class="form-label float-start" for="flat_available">Availability</label></strong>
                                <select class="form-select" name="flat[avaliable]" id="flat_terrace" style="width:100%;">
                                    <option value="Avaliable">Avaliable</option>
                                    <option value="Sold">Sold</option>
                                </select>
                            </div>

                        </div>
                    </div>
                  
                    <div>&nbsp;</div>
                    
                      <?php 
                      
                      $compare = (int)$flat_count[0]['sales_flats'] - (int)$countid[0]['countid'];
                       if($compare <=0) {    $data="disabled";  } else { $data=""; }  
                      
                      ?>

                    <input type="submit" name="commit" <?php echo $data; ?> value="Create Apartment" class="btn text-white bg-brick-red rounded ps-4 pe-4" data-disable-with="Create Flat">
        
                </section>
            </form>

            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info">
                            <p style="color:red; font-size:16px;">
                                <?php if($errmsg){ echo $errmsg; } ?>
                            </p>
                            <form name="multipledeletion" method="post">
                                <!-- <input type="submit" name="submit" value="Delete" class="btn btn-primary btn-md pull-left" onClick="return confirm('Are you sure you want to delete?');"> -->
                                <div class="box-body table-responsive">

                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="20">#</th>


                                                <th width="50">Apt # </th>
                                                <th width="60">Size (Sq Ft)</th>

                                                <th width="50">Floor</th>
                                                <th width="60">Total (Bed+Toilets)</th>
                                                <th width="60">Layout</th>
                                                <th width="60">Availability</th>
                                                <th width="40">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
        			
        						 foreach ($result as $row) {
        							$i++;
           

        							?>
                                                <tr>
                                                    <td style="width:20px;">
                                                        <?php echo $i; ?>
                                                    </td>


                                                
                                                    <td>
                                                        <?php echo $row['flat_number']; ?>
                                                    </td>
                                                    <td>
                                 <?php echo $row['size']; ?> 
                                                    </td>
                                                    <td>
                                                        <?php echo $row['floor']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['totalconfig']; ?>
                                                    </td>
                                                     <td>
                                                        
                                        <?php

                            if($row['layout']!="") { ?>
                                                 
                <img src="../assets/uploads/project-images/<?php echo $row['layout'];?> " style="width: 100%;">  

                                           <?php } else { echo "No Image"; } ?> 

                                                    </td>

                                                    
                                                    <td>
                                                        <?php echo $row['avaliable']; ?>
                                                    </td>

                                                    <td>
                                                        
                        <a href=editmanageflats.php?id=<?= $row['id']; ?>&back=<?= $_GET['id']; ?> >

                                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                                            </svg></a>
                                  

                                    <a href="manageflats.php?id=<?php echo $_GET['id']?>&delete_id=<?php echo $row['id']; ?> "  onclick="return confirm('Are you sure?');">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-trash" viewBox="0 0 16 16">
                                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                                                            </svg>
                                                        </a>

                                                    </td>

                                                </tr>
                                                <?php
        						}
        						?>
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

  </div>

  <script>
  function updateTotalConfig() {
    var bed = document.getElementById("flat_bedconfig").value;
    var toilet = document.getElementById("flat_toilets").value;
    document.getElementById("totalConfig").value = bed + " + " + toilet;
  }

  // Attach event listeners on DOM load
  window.onload = function () {
    document.getElementById("flat_bedconfig").addEventListener("change", updateTotalConfig);
    document.getElementById("flat_toilets").addEventListener("change", updateTotalConfig);
  };
</script>

<script>


document.getElementById("area_max").addEventListener("change", function() {
    const value = parseInt(this.value);

    if (value < 300 || value > 5000) {
        alert("Max value must be between 300 and 5000.");
        this.value = ""; // optional: clear invalid input
    }
});

</script>


  <?php require_once('footer.php'); ?>