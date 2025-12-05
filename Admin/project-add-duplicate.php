<?php require_once('header.php'); ?>
    <?php
if (isset($_POST['commit'])) {   


    // $adadadad= $_POST['property']['amenities'];
    if (!empty($_POST['choices'])) {
     echo "<pre>";
    $selected_values = implode(", ",$_POST['choices']); // Convert array to comma-separated string
    print_r($selected_values);
    echo "</pre>";
     die();
    }
   
    require_once "form/db.php";

 
    // Sanitize Input
    $status = isset($_POST['property']['status']) ? mysqli_real_escape_string($con, $_POST['property']['status']) : null;

    $title = mysqli_real_escape_string($con, $_POST['property']['title']);
    $url = mysqli_real_escape_string($con, $_POST['property']['url']);
    $location = mysqli_real_escape_string($con, $_POST['property']['location']);
    $map_location = mysqli_real_escape_string($con, $_POST['property']['map_location']);
    $amenities = mysqli_real_escape_string($con, $_POST['amenities']['amenities']);
    $area = mysqli_real_escape_string($con, $_POST['property']['area']);
    $floors = mysqli_real_escape_string($con, $_POST['property']['floors']);
    $number_of_flats = mysqli_real_escape_string($con, $_POST['property']['number_of_flats']);
    $overview = mysqli_real_escape_string($con, $_POST['property']['overview']);
    $planning_permit_no = mysqli_real_escape_string($con, $_POST['government_approvals']['planning_permit_no']);
    $planning_permit_date = mysqli_real_escape_string($con, $_POST['government_approvals']['planning_permit_date']);
    $building_permission_no = mysqli_real_escape_string($con, $_POST['government_approvals']['building_permission_no']);
    $building_permission_date = mysqli_real_escape_string($con, $_POST['government_approvals']['building_permission_date']);
    $tnrera = mysqli_real_escape_string($con, $_POST['government_approvals']['tnrera']);
    $tnrera_date = mysqli_real_escape_string($con, $_POST['government_approvals']['tnrera_date']);
    $meta_title = mysqli_real_escape_string($con, $_POST['property']['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['property']['meta_description']);
    $meta_keyword = mysqli_real_escape_string($con, $_POST['property']['meta_keywords']);

    $card_image = isset($_FILES['property']['name']['card_image']) ? $_FILES['property']['name']['card_image'] : null;
    $brochure = isset($_FILES['property']['name']['brochure']) ? $_FILES['property']['name']['brochure'] : null;
    $layouts = isset($_FILES['property']['name']['layouts']) ? $_FILES['property']['name']['layouts'] : null;


    // Use mysqli_real_escape_string only for strings, not arrays
    // $header_image = $header_image ? mysqli_real_escape_string($con, $header_image) : null;
    // $card_image = $card_image ? mysqli_real_escape_string($con, $card_image) : null;
    // $brochure = $brochure ? mysqli_real_escape_string($con, $brochure) : null;
    // $layouts_str = $layouts_str ? mysqli_real_escape_string($con, $layouts) : null;

    // header image upload //
    $header_image = isset($_FILES['property']['name']['header_image']) ? $_FILES['property']['name']['header_image'] : null;
    if($header_image != '') {

    $path = $_FILES['property']['name']['header_image'];
    $path_tmp = $_FILES['property']['tmp_name']['header_image'];
  
    if($path == '') {
    	$valid = 0;
        $error_message .= "You must have to select a photo<br>";
    } else {
    	$ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }  
        $uniqueId= time().'-'.mt_rand();
        $header_final_name = 'header-image-'.$uniqueId.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/project-images/'.$header_final_name );
    }

     //end header image upload end//

    // card image upload //
    $card_image= isset($_FILES['property']['name']['card_image']) ? $_FILES['property']['name']['card_image'] : null;
    if($card_image != '') {

    $path = $_FILES['property']['name']['card_image'];
    $path_tmp = $_FILES['property']['tmp_name']['card_image'];
  
    if($path == '') {
    	$valid = 0;
        $error_message .= "You must have to select a photo<br>";
    } else {
    	$ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }  
        $uniqueId= time().'-'.mt_rand();
        $card_final_name = 'project-front-image-'.$uniqueId.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/project-images/'.$card_final_name );
    }
 //end card image upload end//

    // brochure image upload //
    $brochure = isset($_FILES['property']['name']['brochure']) ? $_FILES['property']['name']['brochure'] : null;
    if($brochure != '') {

    $path = $_FILES['property']['name']['brochure'];
    $path_tmp = $_FILES['property']['tmp_name']['brochure'];
  
    if($path == '') {
    	$valid = 0;
        $error_message .= "You must have to select a photo<br>";
    } else {
    	$ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp' && $ext!='pdf') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }  
        $uniqueId= time().'-'.mt_rand();
        $pdf_headerimage = 'pdf-front-'.$uniqueId.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/project-images/'.$pdf_headerimage );
    }

     //end brocherue image upload end//

    // layouts image upload //
    $layouts = isset($_FILES['layouts']['name']['card_image']) ? $_FILES['property']['name']['layouts'] : null;
    if($layouts != '') {

    $path = $_FILES['property']['name']['layouts'];
    $path_tmp = $_FILES['property']['tmp_name']['layouts'];
  
    if($path == '') {
    	$valid = 0;
        $error_message .= "You must have to select a photo<br>";
    } else {
    	$ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp' && $ext!='pdf') {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }  
        $uniqueId= time().'-'.mt_rand();
        $layouts = 'layout-image-'.$uniqueId.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/project-images/'.$layouts );
    }

     //end brocherue image upload end//
    // Set timezone and date
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');
  // Check if title already exists
    $check_sql = "SELECT COUNT(*) as count FROM tbl_projects WHERE title = '$title'";
    $result = mysqli_query($con, $check_sql);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

        if ($count == 0) {
             $sql = "INSERT INTO tbl_projects ( title, url, location, map_location,amenities, area, floors, number_of_flats, overview, planning_permit_no, planning_permit_date, building_permission_no, building_permission_date, tnrera, tnrera_date, meta_title, meta_description, meta_keyword, header_image, card_image, brochure, layouts, status) VALUES (
                    '$title', '$url', '$location', '$map_location', 'amenities','$area', '$floors', '$number_of_flats', 
                    '$overview', '$planning_permit_no', '$planning_permit_date', '$building_permission_no', 
                    '$building_permission_date', '$tnrera', '$tnrera_date', '$meta_title', '$meta_description', 
                    '$meta_keyword', '$header_image', '$card_image', '$brochure', '$layouts', '$status'
                )";

                  if (mysqli_query($con, $sql)) {
                    $last_id = mysqli_insert_id($con); // Fixed incorrect connection variable
                    echo "Project added successfully!";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($con);
                }

                        } else {
                        echo '<script>alert("Entered title already exists. Kindly enter a new title."); location.href="../project-add.php";</script>';
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
                <a href="projects.php" class="btn btn-primary btn-sm">View All</a>
            </div>
        </section>


        <section class="content">

            <div class="row">
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
                                    <h2 class="pl-3">Basic Information</h2>
                                    <div class="row pb-2">
                                        <div class="col-sm-4 pl-3">
                                            <label for="" class="control-label">Project Status <span>*</span></label>
                                            <select name="property[status]" required="required" class="form-control select2 top-cat">
                                                <option value="">Select Project Status</option>
                                                <?php
													$statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
													$statement->execute();
													$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
													foreach ($result as $row) {
													?>
                                                    <option value="<?php echo $row['tcat_id']; ?>">
                                                        <?php echo $row['tcat_name']; ?>
                                                    </option>
                                                    <?php
													}?>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="" class=" control-label">Title <span>*</span></label>
                                            <input class="form-control" required="required" type="text" name="property[title]" id="property_title">
                                        </div>
                                        <div class="col-sm-4 pr-3">
                                            <label for="" class=" control-label">URL Slug<span>*</span></label>
                                            <input class="form-control" required="required" type="text" name="property[url]" id="property_title">
                                        </div>

                                        <div class="col-sm-4 pl-3">
                                            <label for="" class=" control-label">Location <span>*</span></label>

                                            <input class="form-control" required="required" type="text" name="property[location]" id="property_location">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="" class=" control-label">Map location <span>*</span></label>
                                            <textarea class="form-control" required="required" name="property[map_location]" id="property_map_location"></textarea>
                                        </div>
                                        <div class="col-sm-4 pr-3">
                                            <label for="" class=" control-label">Area <span>*</span></label>
                                            <input class="form-control" required="required" type="text" name="property[area]" id="property_title">
                                        </div>

                                        <div style="clear:both"></div>

                                        <div class="col-sm-4 pl-3">
                                            <label for="" class=" control-label">Floors <span>*</span></label>

                                            <input class="form-control" required="required" type="number" name="property[floors]" id="property_floors"> </div>

                                        <div class="col-sm-4 ">
                                            <label for="" class=" control-label">Number of flats <span>*</span></label>

                                            <input class="form-control" required="required" type="number" name="property[number_of_flats]" id="property_number_of_flats"> </div>


                                        <div class="col-sm-4 pr-3">
                                            <label for="" class=" control-label">Overview <span>*</span></label>

                                            <textarea class="form-control" required="required" name="property[overview]" id="property_overview"></textarea>
                                        </div>
                                    </div>
                                </div>


                                 <!--amnenitites-start-->
                                 <div class="row"> 
                                            <div class="col-sm-12">
                                                    <div class="amenities-fields mb-5 pl-3 px-5 mt-5">
                                                        <h4 class="mb-4 text-brick-red underline-brick-red">Amenities</h4>                                                
                                                        <div class="amenities-multi-select">
                                                        <label><input type="checkbox" name="choices[]" value="Apple"> Apple</label>
                                                        <label><input type="checkbox" name="choices[]" value="Banana"> Banana</label>
                                                        <label><input type="checkbox" name="choices[]" value="Orange"> Orange</label>
                                                        <label><input type="checkbox" name="choices[]" value="Grapes"> Grapes</label>
                                                    </div> 
                                            </div>
                                            </div>
                                        </div>  
                                        <!--amnenitites-end-->
                                <section class="content">

                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- Government Approvals -->
                                            <div class="government-approval-fields px-5 row  pl-3">
                                                <h4 class="mb-4 text-brick-red underline-brick-red">Government Approvals</h4>

                                                <div class="mb-3 col-md-6 ">
                                                    <label class="form-label" for="government_approvals_planning_permit_no">Planning permit no</label>
                                                    <input class="form-control" required="required" type="varchar" name="government_approvals[planning_permit_no]" id="government_approvals_planning_permit_no">
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label" for="government_approvals_date_of_permit">Date of permit</label>
                                                    <input class="form-control" required="required" type="date" name="government_approvals[planning_permit_date]" id="government_approvals_planning_permit_date">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label" for="government_approvals_building_permission_no">Building permission no</label>
                                                    <input class="form-control" required="required" type="varchar" name="government_approvals[building_permission_no]" id="government_approvals_building_permission_no">
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label" for="government_approvals_date_of_permit">Date of permit</label>
                                                    <input class="form-control" required="required" type="date" name="government_approvals[building_permission_date]" id="government_approvals_building_permission_date">
                                                </div>
                                                <div class="mb-3 col-md-6">
                                                    <label class="form-label text-uppercase" for="government_approvals_tnrera">Tnrera</label>
                                                    <input class="form-control" required="required" type="varchar" name="government_approvals[tnrera]" id="government_approvals_tnrera">
                                                </div>
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label" for="government_approvals_dated">Dated</label>
                                                    <input class="form-control" required="required" type="date" name="government_approvals[tnrera_date]" id="government_approvals_tnrera_date">
                                                </div>
                                            </div>

                                            <!-- seo -->

                                            <div class="seo-fields px-5 mt-5 row pl-3">
                                                <h4 class="mb-4 text-brick-red underline-brick-red">SEO Properties</h4>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label" for="property_meta_title">Meta title</label>
                                                    <textarea class="form-control" required="required" name="property[meta_title]" id="property_meta_title"></textarea>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label" for="property_meta_description">Meta description</label>
                                                    <textarea class="form-control" required="required" name="property[meta_description]" id="property_meta_description"></textarea>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label" for="property_meta_keywords">Meta keywords</label>
                                                    <textarea class="form-control" required="required" name="property[meta_keywords]" id="property_meta_keywords"></textarea>
                                                </div>
                                            </div>
                                            <div class="row attachment-fields d-flex flex-row justify-space-between mt-4 pl-3 pr-3">
                                                <div class="col-md-3 header d-flex flex-column">
                                                    <label class="mb-3 fw-bold" for="property_residence_header_image">Residence header image</label>
                                                    <input type="file" required="required" name="property[header_image]" id="property_header_image">
                                                </div>

                                                <div class="col-md-3 header d-flex flex-column">
                                                    <label class="mb-3 fw-bold" for="property_residence_card_image">Residence card image</label>
                                                    <input type="file" required="required" name="property[card_image]" id="property_card_image">
                                                </div>

                                                <div class="col-md-3 header d-flex flex-column">
                                                    <label class="mb-3 fw-bold" for="property_brochure">Brochure</label>
                                                    <input type="file" required="required" name="property[brochure]" id="property_brochure">
                                                </div>

                                                <div class="col-md-3 header d-flex flex-column ">
                                                    <label class="mb-3 fw-bold" for="property_layouts">Layouts</label>
                                                    <input name="property[layouts][]" required="required" type="hidden" value="" autocomplete="off">
                                                    <input multiple="multiple" type="file" name="property[layouts]" id="property_layouts">
                                                </div>
                                            </div>
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
                            </section>
                        </section>

        <?php require_once('footer.php'); ?>