<?php require_once('header.php'); ?>

<?php
if (isset($_POST['commit']))   
    require_once "form/db.php";

// Report runtime errors
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// Report all errors
error_reporting(E_ALL);

// Same as error_reporting(E_ALL);
ini_set("error_reporting", E_ALL);

// Report all errors except E_NOTICE
error_reporting(E_ALL & ~E_NOTICE);


?>
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
            <h1>Create a property
			</h1>
        </div>
        <div class="content-header-right">
            <a href="product.php" class="btn btn-primary btn-sm">View All</a>
        </div>
    </section>


    <section class="content">
    <div class="container mt-4">
   
        <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-10">
                <div class="card p-3 mb-3">
                    <h3 class="fw-bold">ABHINAYA</h3>
                    <div style="display: flex;">
                    <p class="flat-title">Total Flats : <span class="flat-number"> 10</span></p>
                    <p class="flat-title pl-3">Total Flats added so far : <span class="flat-number"> 10</span></p>
                </div>
                </div>
              </div>

                <table class="table table-bordered">
                    <thead class="table-header">
                        <tr>
                            <th>Flat No</th>
                            <th>Floor</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Facing</th>
                            <th>Layout</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Rows (Dynamic Entries) -->
                    </tbody>
                </table>
            </div>

      </div>
        
      <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title text-danger">Add a Flat</h3>
        </div>
        <div class="panel-body">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <!-- Flat Number -->
                <div class="form-group">
                    <label for="flat_number">Flat Number</label>
                    <input type="text" class="form-control" id="flat_number" name="flat_number" required="required">
                </div>

                <div class="row">
                    <!-- Area -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flat_area">Area</label>
                            <input type="text" class="form-control" id="flat_area" name="flat_area" required="required">
                        </div>
                    </div>

                    <!-- Floor -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flat_floor" >Floor</label>
                            <select class="form-control" id="flat_floor" name="floor"  required="required">
                            <option value="" disabled selected>Enter the Floor</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Facing -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flat_facing">Facing</label>
                            <select class="form-control" id="flat_facing" name="facing" required>
                            <option value="" disabled selected>Enter Your Facing Directions</option>
                                <option value="North">North</option>
                                <option value="East">East</option>
                                <option value="West">West</option>
                                <option value="South">South</option>
                            </select>
                        </div>
                    </div>

                    <!-- Flat Type -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flat_type">Flat Type</label>
                            <select class="form-control" id="flat_type" name="flat_type" required>
                            <option value="" disabled selected>Enter Your Flat Type</option>
                                <option value="1BHK">1BHK</option>
                                <option value="2BHK">2BHK</option>
                                <option value="3BHK">3BHK</option>
                                <option value="4BHK">4BHK</option>
                                <option value="5BHK">5BHK</option>
                                <option value="6BHK">6BHK</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Terrace -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="flat_terrace">Terrace</label>
                            <select class="form-control" id="flat_terrace" name="Terrace">
                            <option value="" disabled selected>Enter Your Terrace Type</option>
                                <option value="1T">1T</option>
                                <option value="2T">2T</option>
                                <option value="3T">3T</option>
                                <option value="4T">4T</option>
                                <option value="5T">5T</option>
                                <option value="6T">6T</option>
                            </select>
                        </div>
                    </div>

                    <!-- Layout Upload -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="layout">Layout</label>
                            <input type="file" class="form-control" id="layout" name="layout">
                        </div>
                    </div>
                </div>

                        <!-- Available Toggle -->
                        <div class="form-group">
                    <label>Available</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="availability" value="yes"> Yes
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="availability" value="no"> No
                        </label>
                    </div>
                </div>

                <!-- Form Actions -->
                              <div class="row form-actions d-flex flex-row justify-content-center gap-4 mt-4 pb-2">
                                                <div class="col-md-8 text-center">
                                                    <div>
                                                        <input type="submit" name="commit" value="Create Property" class="btn text-white bg-brick-red rounded mb-5" data-disable-with="Create Property">
                                                        <a class="btn text-white bg-brick-red rounded mb-5" href="/admin/properties">Cancel</a></div>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                    </div>


                            </div>
                            </div>
                            </section>

    <?php require_once('footer.php'); ?>