<?php require_once('header.php'); 

    
if (isset($_POST["commit"])) {

include("inc/log_helper.php");

$flat_number = $_POST["flat_number"];
// $minarea = $_POST["area_min"];
$size= $_POST["area_max"];
$floor = $_POST["floor"];
$toilets= $_POST["toilets"];
$bed = $_POST["bedConfig"];
$totalConfig = $_POST["totalConfig"];
$avaliable = $_POST["avaliable"];
$tableid = $_REQUEST["id"];






 // $files = isset($_FILES["name"]["layout"])? $_FILES["name"]["layout"]: null; 

    $files = $_FILES['layout']['name'];


  if (!empty($files)) {

        $path = $_FILES['layout']['name'];
        $path_tmp = $_FILES["layout"]["tmp_name"];
 
        if ($path == "") {
            $valid = 0;
            $error_message .= "You must have to select a photo<br>";
        } else {
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $file_name = basename($path, "." . $ext);
        }
        $uniqueId = time() . "-" . mt_rand();
         $flatphoto = "flats-layout-" . $uniqueId . "." . $ext;
        



        move_uploaded_file(
            $path_tmp,
            "../assets/uploads/project-images/" . $flatphoto
        );


        $query_new = "UPDATE tbl_flats SET flat_number=:flat_number, size=:size,  floor=:floor,bed=:bed
        ,toilets=:toilets,totalconfig=:totalconfig,layout=:flatphoto,avaliable=:avaliable
        WHERE id=:p_id LIMIT 1";

        $statement_new = $pdo->prepare($query_new);

         $data_new = [
        ":flat_number" => $flat_number,
        ":size" => $size,
        ":floor" => $floor,
        ":bed" => $bed,
        ":toilets" => $toilets,
        ":totalconfig" => $totalConfig,
        ":flatphoto" => $flatphoto,
        ":avaliable" => $avaliable,
        ":p_id" => $tableid,
      ];
          $query_execute = $statement_new->execute($data_new);

  } else {

         
        $query_new = "UPDATE tbl_flats SET flat_number=:flat_number, size=:size,  floor=:floor,bed=:bed
        ,toilets=:toilets,totalconfig=:totalconfig,avaliable=:avaliable
        WHERE id=:p_id LIMIT 1";

        $statement_new = $pdo->prepare($query_new);

         $data_new = [
        ":flat_number" => $flat_number,
        ":size" => $size,
        ":floor" => $floor,
        ":bed" => $bed,
        ":toilets" => $toilets,
        ":totalconfig" => $totalConfig,
        ":avaliable" => $avaliable,
        ":p_id" => $tableid,
      ];

 

          $query_execute = $statement_new->execute($data_new);

  }
  
  
             $update_success = true;
                
                $new_name =$flat_number;
                
                $old_name = "";
                
                if ($update_success) {
                    
                    log_admin_action(
                    $_SESSION['userid'],
                    $_SESSION['username'],
                    'Inventory flats Updated',
                    'Inventory',
                    $last_id,
                    $old_name,
                    $new_name
                    );   
                }


  
     echo '<script>alert("Apartment details is Updated Successfully");
     location.href="manageflats.php?id='.$_GET['back'].'";</script>';
     

   }

    $statement = $pdo->prepare("SELECT * FROM tbl_flats WHERE id=?");
    $statement->execute(array($_REQUEST['id']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC); 

    $flat_number=$result[0]['flat_number'];
    // $minarea=$result[0]['minarea'];
    $size=$result[0]['size'];

    $floor=$result[0]['floor']; $layout=$result[0]['layout'];

    $facing=$result[0]['facing'];

    $totalconfig=$result[0]['totalconfig'];

    $avaliable=$result[0]['avaliable'];

    $bed=$result[0]['bed']; $toilets=$result[0]['toilets'];
    
    
        $statement = $pdo->prepare("SELECT number_of_flats,title,sales_flats FROM tbl_projects WHERE p_id=?");
    $statement->execute(array($_REQUEST['back']));
    $flat_count = $statement->fetchAll(PDO::FETCH_ASSOC);
    
?>

<section class="content-header box box-info">
<div class="content-header-left">


<h1>Edit Apartment Information</h1>

</div>
<div class="content-header-right">

</div>
<?php if ($error_message): ?>
            <div class="callout callout-danger">
            
            <p>
            <?php echo $error_message; ?>
            </p>
            </div>
            <?php endif; ?>

            <?php if ($success_message): ?>
            <div class="callout callout-success">
            
            <p><?php echo $success_message; ?></p>
            </div>
            <?php endif; ?>

</section>

         
        <h2 style="text-align:center;"><b><?php echo $flat_count[0]['title']; ?></b></h2>
     
        <form name="flatsadd" method="post" enctype="multipart/form-data" >



            <section class="content-header">
                <div class="row">
                    <div class="col-md-3 mb-3">
                         <label class="form-label" for="flat_flat_number">Apt # </label>
                        <input class="form-control" type="text" name="flat_number" id="flat_flat_number" value="<?php echo $flat_number; ?>">
                    </div>

                    <div class="col-md-3  mb-3">

                    <strong><label class="form-label" for="flat_area" style="text-transform:none !important;">
                        Size  (Saleable Area in Sq FT) </label></strong>

                    <input type="number" name="area_max" required id="area_max" class="form-control"  value="<?php echo $size; ?>">

                  
                    </div>

                    <div class="col-md-3  mb-3">
                        <strong><label class="form-label" for="flat_floor">Floor</label></strong>
                        <select class="form-select" name="floor" id="flat_floor" style="width:100%;">
                     <option value="1" <?php if($floor == 1) { echo 'selected=selected'; }?>>1</option>
                            <option value="2" <?php if($floor == 2) { echo 'selected=selected'; }?>>2</option>
                            <option value="3" <?php if($floor == 3) { echo 'selected=selected'; }?>>3</option>
                            <option value="4" <?php if($floor == 4) { echo 'selected=selected'; }?>>4</option>
                            <option value="5" <?php if($floor == 5) { echo 'selected=selected'; }?>>5</option>
                            <option value="6" <?php if($floor == 6) { echo 'selected=selected'; }?>>6</option>
                            <option value="7" <?php if($floor == 7) { echo 'selected=selected'; }?>>7</option>
                            <option value="8" <?php if($floor == 8) { echo 'selected=selected'; }?>>8</option>
                            <option value="9" <?php if($floor == 9) { echo 'selected=selected'; }?>>9</option>
                            <option value="10" <?php if($floor == 10) { echo 'selected=selected'; }?>>10</option>

                             <option value="11" <?php if($floor == 11) { echo 'selected=selected'; }?>>11</option>

                              <option value="12" <?php if($floor == 12) { echo 'selected=selected'; }?>>12</option>

                             <option value="13" <?php if($floor == 13) { echo 'selected=selected'; }?>>13</option>

                              <option value="14" <?php if($floor == 14) { echo 'selected=selected'; }?>>14</option>

                            <option value="15" <?php if($floor == 15) { echo 'selected=selected'; }?>>15</option>

                        </select>
                    </div>

                     <div class="col-md-3  mb-3 ">
                            <strong><label class="form-label" for="flat_facing">Bed Config</label></strong>
                            <select class="form-select" required name="bedConfig" id="flat_bedconfig" style="width:100%;">
                                <option value="">Select Bed </option>
                                <option value="1BHK" <?php if($bed == '1BHK') { echo 'selected=selected'; }?>>1BHK</option>
                                <option value="2BHK" <?php if($bed == '2BHK') { echo 'selected=selected'; }?>>2BHK</option>
                                <option value="3BHK" <?php if($bed == '3BHK') { echo 'selected=selected'; }?>>3BHK</option>
                                <option value="4BHK" <?php if($bed == '4BHK') { echo 'selected=selected'; }?> >4BHK</option>
                            </select>
                        </div>
                </div>

                <div class="">&nbsp;</div>

                <div class="row">

                       <div class="mb-3 col-md-3 d-inline-block">

                        <strong><label class="form-label" for="flat_terrace">Toilets</label></strong>

                        <select class="form-select" name="toilets" id="flat_toilets" style="width:100%;" >

                            <option value="1T" <?php if($toilets == '1T') { echo 'selected=selected'; }?>>1T</option>
                            <option value="2T" <?php if($toilets == '2T') { echo 'selected=selected'; }?>>2T</option>
                            <option value="3T" <?php if($toilets == '3T') { echo 'selected=selected'; }?>>3T</option>
                            <option value="4T" <?php if($toilets == '4T') { echo 'selected=selected'; }?>>4T</option>
                            <option value="5T" <?php if($toilets == '5T') { echo 'selected=selected'; }?>>5T</option>
                        </select>
                    </div>

                     <div class="mb-3 col-md-3 d-inline-block">

                        <strong><label class="form-label" for="flat_type">Total Config</label></strong>

                         <input class="form-control" type="text" value="<?php echo $totalconfig; ?>" name="totalConfig" id="totalConfig">

  
                    </div>

                 
                    <div class="mb-3 col-md-3 d-inline-block">
                        <div class="mb-3">
                            <strong><label class="form-label">Layout</label></strong>

                            <div>
                                <input type="file" name="layout" id="flat_layout">

                                <?php if($layout !="") {?>
                                   <p>Filename: <?php echo  $layout; ?> </p>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label><br>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/project-images/<?php echo $layout ; ?>" class="existing-photo" width="140">
                                        </div>
                                    </div>
                                
                                <?php } else {
                                
                                echo "<b>File Not uploaded</b> ";
                                } ?> 

                            </div>

                        </div>
                    </div>

                    <div class="mb-3 col-md-3 d-inline-block">

                        <div class="mb-3 form-normal-padding form-check form-switch">
                            <strong><label class="form-label float-start" for="flat_available">Available</label></strong>
                            <select class="form-select" name="avaliable" id="flat_terrace" style="width:100%;">
                                <option value="Avaliable" <?php if($avaliable == 'Avaliable') { echo 'selected=selected'; }?>>Avaliable</option>
                                <option value="Sold" <?php if($avaliable =='Sold') { echo 'selected=selected'; }?>>Sold</option>



                            </select>
                        </div>

                    </div>
                </div>
              
                <div>&nbsp;</div>
                <input type="submit" name="commit" value="Save Changes" class="btn text-white bg-brick-red rounded ps-4 pe-4" data-disable-with="Create Flat">
                <a href="manageflats.php?id=<?php echo $_GET['back']; ?>" class="mb-4 width-fit-content text-decoration-none  mb-3">
<input type="button" name="commit" value="Discard Changes" class="btn text-white bg-brick-red rounded ps-4 pe-4" >
</a>

            </section>

        </form>

  <?php require_once('footer.php'); ?>

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

// Onchange validation for area_min
// document.getElementById("area_min").addEventListener("change", function() {
//     const value = parseInt(this.value);
//     if (value < 300 || value > 5000) {
//         alert("Min value must be between 300 and 5000.");
//         this.value = ""; // optional: clear invalid input
//     }
// });

// Onchange validation for area_max
document.getElementById("area_max").addEventListener("change", function() {
    const value = parseInt(this.value);

    if (value < 300 || value > 5000) {
        alert("Max value must be between 300 and 5000.");
        this.value = ""; // optional: clear invalid input
    }
});

</script>

    

      





      