<?php require_once('header.php'); ?>
    <?php
if (isset($_POST['commit'])) {   
    require_once "form/db.php";

    // Debugging: Check received POST data
    echo "<h4>POST Data:</h4><pre>";
    print_r($_POST);
    echo "</pre>";


    // Use mysqli_real_escape_string only for strings, not arrays
    $header_image = $header_image ? mysqli_real_escape_string($con, $header_image) : null;
    $card_image = $card_image ? mysqli_real_escape_string($con, $card_image) : null;
    $brochure = $brochure ? mysqli_real_escape_string($con, $brochure) : null;
    $layouts_str = $layouts_str ? mysqli_real_escape_string($con, $layouts) : null;

    // Set timezone and date
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');
  // Check if title already exists
    $check_sql = "SELECT COUNT(*) as count FROM tbl_product WHERE title = '$title'";
    $result = mysqli_query($con, $check_sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    if ($count == 0) {
        echo $sql = "INSERT INTO tbl_product(
          title, url, location, map_location, area, floors, number_of_flats, overview, 
            planning_permit_no, planning_permit_date, building_permission_no, building_permission_date, tnrera, tnrera_date, 
            meta_title, meta_description, meta_keyword,header_image, card_image, brochure, layouts, status
        ) VALUES (
          '$title', '$url', '$location', '$map_location', '$area', '$floors', '$number_of_flats', 
            '$overview',  '$planning_permit_no', '$planning_permit_date', '$building_permission_no', 
            '$building_permission_date', '$tnrera', '$tnrera_date', '$meta_title', '$meta_description', '$meta_keyword','$header_image','$card_image','$brochure','$layouts',' $status')";
 

        if (mysqli_query($con, $sql)) {
            $last_id = mysqli_insert_id($con); // Fixed incorrect connection variable
            echo "Project added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo '<script>alert("Entered title already exists. Kindly enter a new title."); location.href="../index.php";</script>';
    }

    // Close connection
    mysqli_close($con);
}
?>

        <section class="content-header">
            <div class="content-header-left">
                <h1>Back To property
			</h1>
            </div>
            <div class="content-header-right">
                <a href="product.php" class="btn btn-primary btn-sm">View All</a>
            </div>
        </section>


        <section class="content">

            <div class="row">
                <div class="container-fluid">
                            <!-- /////manage flats -->
                            <div class="col-md-12">
                        <?php if($error_message): ?>
                            <div class="callout callout-danger">
                                <p>
                                    <?php echo $error_message; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                    <div class="box box-info">
                                        <h2 class="pl-3"></h2>
                                        <div class="row pb-2">
                                            <div class="col-lg-4 pl-3">
                                                <div>
                                                <h2 class="pl-3">Add a Flat</h2>
                                               <label for="" class="control-label flat-title">Flat Number<span>*</span>
                                                </label>
                                                <input name=""class="pl-3" id=""></input>
                                                    </div>
                                                    <div>
                                                    <span>*<input type="checkbox"></input></span>
                                                    </div>
                                                    </div>

                          
                                       
                                            <div class="col-lg-4 col-sm-4 pl-3 ">
                                              <div class="mt-2">
                                                <label for="" class="control-label flat-title">Area<span>*</span>
                                                </label>
                                                <input name="" id=""></input>
                                                  </div>
                                                <div class="mt-2">
                                                <strong><label class="form-label flat-title" for="flat_floor">Floor</label></strong>
                                                <select class="form-select" name="flat[floor]" id="flat_floor">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <strong><label class="form-label flat-title" for="flat_floor">Terrace</label></strong>
                                                <select class="form-select" name="flat[floor]" id="flat_floor">
                                                    <option value="1">1 T</option>
                                                    <option value="2">2 T</option>
                                                    <option value="3">3 T</option>
                                                    <option value="4">4 T</option>
                                                    <option value="5">5 T</option>
                                                </select>
                                            </div>
                                            </div>
                                             <div class="col-lg-4 col-md-3 d-inline-block">
                                                    <strong><label class="form-label flat-title" for="flat_floor">Facing</label></strong>
                                                    <select class="form-select" name="flat[facing]" id="flat_facing">
                                                    <option value="1">North</option>
                                                    <option value="2">East</option>
                                                    <option value="3">West</option>
                                                    <option value="4">South</option>
                                                    
                                                </select>
                                                <div>
                                                <strong><label class="form-label flat-title" for="flat_floor">Flat Type</label></strong>
                                                <select class="form-select" name="flat[floor]" id="flat_floor">
                                                    <option value="1">1 BHK</option>
                                                    <option value="2">2 BHK</option>
                                                    <option value="3">3 BHK</option>
                                                    <option value="4">4 BHK</option>
                                                    <option value="5">5 BHK</option>
                                                </select>
                                            </div>
                                            <div class="d-flex flex-column">
                                                    <label class="mb-3 fw-bold flat-title " for="property_brochure">Layout</label>
                                                    <input type="file" required="required" name="layout" id="layout">
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </form>
                    </div>
                    <!--details-->
                    <div class="col-md-12">
                        <?php if($error_message): ?>
                            <div class="callout callout-danger">
                                <p>
                                    <?php echo $error_message; ?>
                                </p>
                            </div>
                            <?php endif; ?>
                                <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                    <div class="box box-info">
                                        <h2 class="pl-3">Abhinaya</h2>
                                        <div style="display: flex;">
                                            <p class="flat-title pl-3">Total Flats : <span class="flat-number"> 10</span></p>
                                            <p class="flat-title pl-3">Total Flats added so far : <span class="flat-number"> 10</span></p>
                                        </div>
                                        <div class="container">
                                            <table class="my_table w-100">
                                                <tr>
                                                    <th>Flat No</th>
                                                    <th>Floor</th>
                                                    <th>Type</th>
                                                    <th>Area</th>
                                                    <th>Layout</th>
                                                    <th>Available</th>
                                                    <th>Actions</th>
                                                </tr>
                                                <tbody></tbody>
                                            </table>
                                        </div>

                                    </div>
                                </form>
                    </div>
            
                </div>
            </div>
        </section>

        <?php require_once('footer.php'); ?>