<?php require_once('header.php'); ?>
    
<style>
   .horizontal-categories {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 30px;
        margin-bottom: 2rem;
    }

    .horizontal-categories .category-column {
        flex: 1 1 22%;
        min-width: 200px;
    }

    .category-column h4 {
        font-size: 1.25rem;       /* Bigger text */
        font-weight: 700;         /* Bolder */
        margin-bottom: 1rem;
        text-transform: uppercase; /* Optional: uppercase titles */
        color: #222;              /* Darker color for visibility */
    }

    .checkbox-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .checkbox-list label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 500;
    }

    @media screen and (max-width: 768px) {
        .horizontal-categories {
            flex-direction: column;
        }

        .horizontal-categories .category-column {
            width: 100%;
        }
    }
</style>

<?php
if (isset($_POST['commit'])) {
    require_once "form/db.php";
    include("inc/log_helper.php");

    // Common Upload Function
    function uploadFile($field, $prefix) {
        $uploadDir = '../assets/uploads/project-images/';
        if (!isset($_FILES['property']['name'][$field])) return null;

        $path = $_FILES['property']['name'][$field];
        $tmp = $_FILES['property']['tmp_name'][$field];
        if ($path == '') return null;

        $ext = pathinfo($path, PATHINFO_EXTENSION);
        if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf', 'jfif'])) return null;

        $unique = time() . '-' . mt_rand();
        $finalName = $prefix . '-' . $unique . '.' . $ext;
        move_uploaded_file($tmp, $uploadDir . $finalName);

        return $finalName;
    }

    // Sanitize Inputs
    $title = mysqli_real_escape_string($con, $_POST['property']['title']);
    $url = mysqli_real_escape_string($con, $_POST['property']['url']);
    $location = mysqli_real_escape_string($con, $_POST['property']['location']);
    $map_location = mysqli_real_escape_string($con, $_POST['property']['map_location']);
    $area = mysqli_real_escape_string($con, $_POST['property']['area']);
    $floors = mysqli_real_escape_string($con, $_POST['property']['floors']);
    $number_of_flats = mysqli_real_escape_string($con, $_POST['property']['number_of_flats']);
    $sales = mysqli_real_escape_string($con, $_POST['property']['sales_flats']);
    $overview = mysqli_real_escape_string($con, $_POST['property']['overview']);
    $meta_title = mysqli_real_escape_string($con, $_POST['property']['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['property']['meta_description']);
    $meta_keyword = mysqli_real_escape_string($con, $_POST['property']['meta_keywords']);
    $project_status = mysqli_real_escape_string($con, $_POST['property']['project_status']);
    $stage = mysqli_real_escape_string($con, $_POST['property']['stage']);

    // New Fields
    $project_type = mysqli_real_escape_string($con, $_POST['property']['type']);
    // $project_availability = mysqli_real_escape_string($con, $_POST['property']['avaliablity']);
    $vicinity = mysqli_real_escape_string($con, $_POST['property']['vicinity']);
    $locality = mysqli_real_escape_string($con, $_POST['property']['locality']);
    $street = mysqli_real_escape_string($con, $_POST['property']['street']);
    $tag_line = mysqli_real_escape_string($con, $_POST['property']['tag_line']);
    $for_sale = mysqli_real_escape_string($con, $_POST['property']['for_sale']);
    $senior_living = isset($_POST['property']['senior_living']) ? 1 : 0;
    $featured = isset($_POST['property']['featured']) ? 1 : 0;


    $attributes = !empty($_POST['attributes']) ? implode(",", $_POST['attributes']) : '';

    // Approval Fields
    $planning_permit_no = mysqli_real_escape_string($con, $_POST['government_approvals']['planning_permit_no']);
    $planning_permit_date = mysqli_real_escape_string($con, $_POST['government_approvals']['planning_permit_date']);
    $building_permission_no = mysqli_real_escape_string($con, $_POST['government_approvals']['building_permission_no']);
    $building_permission_date = mysqli_real_escape_string($con, $_POST['government_approvals']['building_permission_date']);
    $tnrera = mysqli_real_escape_string($con, $_POST['government_approvals']['tnrera']);
    $tnrera_date = mysqli_real_escape_string($con, $_POST['government_approvals']['tnrera_date']);
    $ccertificate = mysqli_real_escape_string($con, $_POST['government_approvals']['ccertificate']);
    $ccertificate_date = mysqli_real_escape_string($con, $_POST['government_approvals']['ccertificate_date']);

    $area_min = intval($_POST["property"]["area_min"]);
    $area_max = intval($_POST["property"]["area_max"]);

    $one_draw = mysqli_real_escape_string($con, $_POST['property']['one_drawing']);
    $two_drawing2 = mysqli_real_escape_string($con, $_POST['property']['two_drawing']);
    $three_drawing3 = mysqli_real_escape_string($con, $_POST['property']['three_drawing']);
    $four_drawing4 = mysqli_real_escape_string($con, $_POST['property']['four_drawing']);
    $five_drawing5 = mysqli_real_escape_string($con, $_POST['property']['five_drawing']);
    $six_drawing6 = mysqli_real_escape_string($con, $_POST['property']['six_drawing']);





    // Image Uploads
    $header_image = null;
    $uploadedFiles = [];
    if (isset($_FILES['header_image']['tmp_name'])) {
        foreach ($_FILES['header_image']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['header_image']['error'][$key] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['header_image']['name'][$key], PATHINFO_EXTENSION);
                $uniqueID = time() . '_' . uniqid();
                $fileName = $uniqueID . '.' . $ext;
                $targetPath = '../assets/uploads/project-images/' . $fileName;
                if (move_uploaded_file($tmpName, $targetPath)) {
                    $uploadedFiles[] = $fileName;
                }
            }
        }
        $header_image = implode(",", $uploadedFiles);
    }

    // Other File Uploads
    $thumb_final_name = uploadFile('thumb_image', 'thumb-image');
    
    $card_final_name = uploadFile('card_image', 'card-image');
    
    $overview_final_name = uploadFile('overview_image', 'overview-image');
    
    $pdf_headerimage = uploadFile('brochure', 'brochure');
    

    $planning_permit_doc = uploadFile('planning_permit_doc', 'planning-permit');
    
    $building_permit_doc = uploadFile('building_permit_doc', 'building-permit');
    
    $rera_doc = uploadFile('tnrera_doc', 'rera');
    
    $completion_doc = uploadFile('completion_certificate_doc', 'completion');

    // Drawing Uploads
    $drawing1_img = uploadFile('Drawingone_img', 'drawing1-image');

    $drawing2_img = uploadFile('Drawingtwo_img', 'drawing2-image');

    $drawing3_img = uploadFile('Drawingthree_img', 'drawing3-image');

    $drawing4_img = uploadFile('DrawingFour_img', 'drawing4-image');

    $drawing5_img = uploadFile('Drawingfive_img', 'drawing5-image');

    $drawing6_img = uploadFile('Drawingsix_img', 'drawing6-image');

    // Floor Plan Multiple Uploads
    // $floorplan = null;
    // $uploadedFloorplans = [];
    // if (isset($_FILES['files']['tmp_name'])) {
    //     foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
    //         if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
    //             $ext = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);
    //             $uniqueID = time() . '_' . uniqid();
    //             $fileName = $uniqueID . '.' . $ext;
    //             $targetPath = '../assets/uploads/project-images/' . $fileName;
    //             if (move_uploaded_file($tmpName, $targetPath)) {
    //                 $uploadedFloorplans[] = $fileName;
    //             }
    //         }
    //     }
    //     $floorplan = implode(",", $uploadedFloorplans);
    // }

    // Check for duplicate title
    $check_sql = "SELECT COUNT(*) as count FROM tbl_projects WHERE title = '$title'";
    $result = mysqli_query($con, $check_sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] == 0) {
        $amenities = !empty($_POST['amenities']) ? implode(",", $_POST['amenities']) : '';

$sql = "INSERT INTO tbl_projects (
    title, project_status, project_stage, url, location, map_location, project_type, amenities, floors, number_of_flats, sales_flats,
    overview, planning_permit_no, planning_permit_date, building_permission_no, building_permission_date,
    tnrera, tnrera_date, ccertificate, ccertificate_date,
    meta_title, meta_description, meta_keyword, thumb_image, card_image, overview_image, header_image,
    brochure, floorplan, vicinity, locality, street, tag_line, for_sale,
    attributes,
    planning_permit_doc, building_permit_doc, rera_doc, completion_doc,
    drawing1, drawing1_image, drawing2, drawing2_image,
    drawing3, drawing3_image, drawing4, drawing4_image,
    drawing5, drawing5_image, drawing6, drawing6_image
) VALUES (
    '$title', '$project_status', '$stage', '$url', '$location', '$map_location', 
    '$project_type', '$amenities', '$floors', '$number_of_flats', '$sales',
    '$overview', '$planning_permit_no', '$planning_permit_date', '$building_permission_no', '$building_permission_date',
    '$tnrera', '$tnrera_date', '$ccertificate', '$ccertificate_date',
    '$meta_title', '$meta_description', '$meta_keyword', '$thumb_final_name', '$card_final_name', '$overview_final_name', '$header_image',
    '$pdf_headerimage', '$floorplan', '$vicinity', '$locality', '$street', '$tag_line', '$for_sale',
    '$attributes', '$planning_permit_doc', '$building_permit_doc', '$rera_doc', '$completion_doc',
    '$one_draw', '$drawing1_img', '$two_drawing2', '$drawing2_img',
    '$three_drawing3', '$drawing3_img', '$four_drawing4', '$drawing4_img',
    '$five_drawing5', '$drawing5_img', '$six_drawing6', '$drawing6_img'
)";

    

        if (mysqli_query($con, $sql)) {
            $last_id = mysqli_insert_id($con);
            log_admin_action($_SESSION['userid'], $_SESSION['username'], 'Project Added', 'Project', $last_id, '', $title);
            echo '<script>alert("Project Details Added successfully."); location.href="projects.php";</script>';
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }

    } else {
        echo '<script>alert("Entered title already exists. Kindly enter a new title."); location.href="../project-add.php";</script>';
    }

    mysqli_close($con);
}
?>







<?php

$options = [
    35 => "Access Controlled Entry",
    17 => "Amphitheatre",
    18 => "Badminton Court",
    19 => "Basketball Court",
    20 => "Billiards Table with Room",
    36 => "Boom Barrier - Access Controlled",
    37 => "Boom Barrier - Manual",
    8  => "Business Centre/ Co-Working Lounge",
    9  => "Car Wash Area",
    21 => "Children's Play Area",
    22 => "Club House",
    23 => "Cricket Net Practice",
    24 => "Cycling Track",
    38 => "CCTV Surveillance",
    10 => "Crèche / Daycare Facility",
    1  => "Drip Irrigation for Landscaping",
    2  => "Energy-Efficient Building Design",
    25 => "Exercise Hall/ Studio",
    39 => "Fire Alarm",
    40 => "Fire Fighting Sprinkler System",
    41 => "Fire Safety Equipment",
    26 => "Fitness Centre/ Gym",
    11 => "First Aid Room/ Infirmary",
    12 => "Garbage Collection Room",
    13 => "Guest Rooms",
    27 => "Indoor Games Room",
    42 => "Intercom System",
    28 => "Jogging / Walking Track",
    29 => "Meeting/ Party/ Banquet Hall",
    30 => "Mini Theatre",
    43 => "Power Backup - 100% Full Load",
    44 => "Power Backup - Common Amenities",
    31 => "Pool Table with Room",
    45 => "Remote-Controlled Gates",
    3  => "Smart Home Automation",
    4  => "Solar Power for Common Amenities",
    5  => "Solar Water Heaters",
    14 => "Staff Waiting Areas & Rest Rooms",
    15 => "Supermarket/ Grocery Store",
    32 => "Swimming Pool",
    33 => "Tennis Court",
    46 => "Video Door Phone System",
    6  => "Water Meters per Apartment",
    7  => "Water Recyling & STP",
    16 => "Water Treatment Plant",
    34 => "Yoga / Meditation Room"
];

// Define categories
$categoryMap = [
    "Environment" => [1, 2, 3, 4, 5, 6, 7],
    "Miscellaneous" => [8, 9, 10, 11, 12, 13, 14, 15,16],
    "Recreation" => [17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34],
    "Safety / Security" => [35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46]
];

// Group and sort
$categorizedOptions = [];
foreach ($categoryMap as $category => $ids) {
    $group = [];
    foreach ($ids as $id) {
        if (isset($options[$id])) {
            $group[$id] = $options[$id];
        }
    }
    asort($group); // sort alphabetically
    $categorizedOptions[$category] = $group;
}

 $newoptions = [
    1  => "Senior Living",
    2  => "Featured"
];
?>




        <section class="content-header">
            <div class="content-header-left">
                <h1>Add Property
			</h1>
            </div>
            <!--<div class="content-header-right">-->
            <!--    <a href="projects.php" class="btn btn-primary btn-sm">View All</a>-->
            <!--</div>-->
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
                 <div class="box-info">
                   <h4 class="mb-4 text-brick-red underline-brick-red">Basic Information</h4>
                   <div class="row pb-2">
                     <!-- Project Name -->
                     <div class="col-sm-4 pl-3">
                       <label>Project Name <span>*</span>
                       </label>
                       <input class="form-control" pattern="[A-Za-z ]{1,30}" required type="text" name="property[title]" id="property_title" onkeypress="return alphabhets(event);" title="Only Alphabets and Spaces allowed">
                       <small>(Notes: Enter Only Alphabets, max 30 characters)</small>
                     </div>
                     <!-- Project Status -->
                     <div class="col-sm-4">
                       <label>Project Status <span>*</span>
                       </label>
                       <select name="property[project_status]" required class="form-control select2 top-cat">
                         <option value="">Select Project Status</option> 
                          <option value="Upcoming">Upcoming</option>
                         <option value="Newly-Launched">Newly Launched</option>
                         <option value="Low-Priority">Low Priority</option>
                       </select>
                     </div>
                     <!-- Project Stage -->
                     <div class="col-sm-4">
                       <label>Project Stage <span>*</span>
                       </label>
                       <select name="property[stage]" required class="form-control select2 top-cat">
                         <option value="">Select Project Stage</option>
                         <?php
                    $statement = $pdo->prepare("SELECT * FROM tbl_top_category ORDER BY tcat_name ASC");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
                    foreach ($result as $row) {
                        echo '
                        <option value="'.$row['tcat_name'].'">'.$row['tcat_name'].'</option>';
                    }
                    ?>
                       </select>
                     </div>
                   </div>
                   <div class="row ">
                     <!--<div class="col-sm-4 pl-3">-->
                     <!--  <label>Project Availability</label>-->
                     <!--  <select name="property[avaliablity]" class="form-control select2 top-cat">-->
                     <!--    <option value="#">Select Project Availability</option>-->
                     <!--    <option value="Available">Available</option>-->
                     <!--    <option value="Sold Out">Sold Out</option>-->
                     <!--  </select>-->
                     <!--</div>-->
                     <!-- Project Type -->
                     <div class="col-sm-4 pl-3">
                       <label>Project Type <span>*</span>
                       </label>
                       <select name="property[type]" required class="form-control select2 top-cat">
                         <option value="">Select Project Type</option>
                         <option value="Apartments">Apartments</option>
                         <option value="Plots">Plots</option>
                       </select>
                     </div>
                     <!-- Vicinity -->
                     <div class="col-sm-4 pl-3">
                       <label>Vicinity <span>*</span>
                       </label>
                       <input class="form-control" required type="text" name="property[vicinity]" maxlength="30">
                       <small>(Notes: Enter Only Characters, max 30)</small>
                     </div>
                   </div>
                   <div class="row pb-2">
                     <div class="col-sm-12 pl-3 px-5 ">
                       <label>Attributes 
                       </label>
                       <div class="amenities-multi-select"> <?php
                foreach ($newoptions as $key => $label) {
                    echo "
                            <input type='checkbox' name='attributes[]' value='$key'> $label 
                                <br>";
                }
                ?> </div>
                     </div>
                   </div>
                   <div>&nbsp;</div>
                   <div class="row pb-2">
                     <!-- Locality -->
                     <div class="col-sm-4 pl-3">
                       <label>Locality </label>
                       <input class="form-control"  type="text" name="property[location]" maxlength="30">
                       <small>(Notes: Enter Only Characters, max 30)</small>
                     </div>
                     <!-- Street -->
                     <div class="col-sm-4 pl-3">
                       <label>Street</label>
                       <input class="form-control"  type="text" name="property[street]">
                     </div>
                     <!-- Map Location -->
                     <div class="col-sm-4 pl-3">
                       <label>Map Location <span>*</span>
                       </label>
                       <textarea class="form-control" required name="property[map_location]"></textarea>
                       <small>(Notes: Paste Google Maps iframe embed URL)</small>
                     </div>
                   </div>
                   <div class="row pb-2">
                     <!-- Floors -->
                     <div class="col-sm-4 pl-3">
                       <label>Floors <span>*</span>
                       </label>
                       <input class="form-control" id="floors" required type="text" name="property[floors]">
                     </div>
                     <!-- Number of Flats -->
                     <div class="col-sm-4 pl-3">
                       <label>Total Apts <span>*</span>
                       </label>
                       <input class="form-control" required type="number" id="total_apts"  name="property[number_of_flats]">
                     </div>
                     <!-- Apartments for Sale -->
                     <div class="col-sm-4 pl-3">
                       <label> For Sale <span>*</span>
                       </label>
                       <input class="form-control" id="for_sale" required type="number" name="property[sales_flats]">
                     </div>
                   </div>
                   <div class="row pb-2">
                     <!-- Overview -->
                     <div class="col-sm-4 pl-3">
                       <label>Overview</label>
                       <textarea class="form-control" name="property[overview]" maxlength="300"></textarea>
                       <small>(Max 300 characters)</small>
                     </div>
                     <div class="col-sm-4 pl-3">
                       <label>Tag Line</label>
                       <input class="form-control"  type="text" name="property[tagline]">
                       <small>(Max 10 characters)</small>
                     </div>
                   </div>
                 </div>
                 </div>
                 </div>
                 <!-- Amenities Section -->
                 <div class="row pb-2">
                   <div class="col-sm-12 pl-3 px-5 mt-5">
                     <h4 class="mb-4 text-brick-red underline-brick-red">Amenities <span>*</span>
                     </h4>
                    <div class="horizontal-categories">
                    <?php foreach ($categorizedOptions as $category => $items): ?>
                        <div class="category-column">
                            <h4><?= $category ?></h4>
                            <div class="checkbox-list">
                                <?php foreach ($items as $id => $label): ?>
                                    <label>
                                        <input type="checkbox" name="amenities[]" value="<?= $id ?>">
                                        <?= htmlspecialchars($label) ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                   </div>
                 </div>
                 <!-- Government Approvals -->
                 <div class="row pb-2 px-5 pl-3">
                   <h4 class="mb-4 text-brick-red underline-brick-red">Approval Details</h4>
                   <!-- Repeat this structure for each input as already in your form -->
                   <!-- Planning Permit -->
                   <div class="col-md-6 mb-3">
                     <label>Planning Permit #</label>
                     <input class="form-control"  type="text" name="government_approvals[planning_permit_no]">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Planning Permit Date</label>
                     <input class="form-control"  type="date" name="government_approvals[planning_permit_date]" id="planning_permit_date">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Planning Permit Image</label>
                     <input type="file"  name="government_approvals[planning_permit_doc]" >
                   </div>
                   <div class="mb-3 col-md-6">
                     <label class="form-label" for="government_approvals_building_permission_no">Building Permit #</label>
                     <input class="form-control"  type="varchar" name="government_approvals[building_permission_no]" id="government_approvals_building_permission_no">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_date_of_permit">Building Permit Date</label>
                     <input class="form-control"  type="date" name="government_approvals[building_permission_date]" id="government_approvals_building_permission_date">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Building Permit Image </label>
                     <input type="file"  name="government_approvals[building_permit_doc]" >
                   </div>
                   <div class="mb-3 col-md-6">
                     <label class="form-label text-uppercase" for="government_approvals_tnrera">TNRERA #</label>
                     <input class="form-control"  type="varchar" name="government_approvals[tnrera]" id="government_approvals_tnrera">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_dated">RERA Date </label>
                     <input class="form-control"  type="date" name="government_approvals[tnrera_date]" id="government_approvals_tnrera_date">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>RERA Image</label>
                     <input type="file"  name="government_approvals[tnrera_doc]" multiple>
                   </div>
                   <div class="mb-3 col-md-6">
                     <label class="form-label text-uppercase" for="Completion_Certificate">Completion Certificate # </label>
                     <input class="form-control"  type="varchar" name="government_approvals[ccertificate]" id="government_approvals_ccertificate" value=" ">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_dated">Completion Certificate Image</label>
                     <input class="form-control"  type="date" name="government_approvals[ccertificate_date]" id="government_approvals_ccertificate_date" value="">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Completion Certificate Image</label>
                     <input type="file"  name="government_approvals[completion_certificate_doc]" >
                   </div>
                   <!-- Add remaining government approval fields as you've added -->
                   <!-- Building permission, TNRERA, Completion certificate -->
                 </div>
                 <!-- SEO Section -->
                 <div class="row pb-2 px-5 mt-5 pl-3">
                   <h4 class="mb-4 text-brick-red underline-brick-red">SEO Properties</h4>
                   <div class="col-md-4 mb-3">
                     <label>Meta Title</label>
                     <textarea class="form-control" name="property[meta_title]"></textarea>
                   </div>
                   <div class="col-md-4 mb-3">
                     <label>Meta Description</label>
                     <textarea class="form-control" name="property[meta_description]"></textarea>
                   </div>
                   <div class="col-md-4 mb-3">
                     <label>Meta Keywords</label>
                     <textarea class="form-control" name="property[meta_keywords]"></textarea>
                   </div>
                 </div>
                 <!-- Property Media Uploads -->
                 <div class="row pb-2 px-5 pl-3">
                   <h4 class="mb-4 text-brick-red underline-brick-red">Property Media & Documents</h4>
                   
                    <div class="col-md-4 mb-3">
                     <label>Thumbnail Image</label>
                     <input type="file" required name="property[thumb_image]">
                     <small>(500x500px, max 500KB)</small>
                   </div>
                
                   <div class="col-md-4 mb-3">
                     <label>Card Image</label>
                     <input type="file" required name="property[card_image]">
                     <small>(1000x1000px, max 500KB)</small>
                   </div>
                   
                    <div class="col-md-4 mb-3">
                     <label>Overview Image</label>
                     <input type="file" required name="property[overview_image]">
                     <small>(1000x1000px, max 500KB)</small>
                   </div>
                   
                  
                 </div>
                 
                  <div class="row pb-2 px-5 pl-3">
                 
                   
                    <div class="col-md-4 mb-3 mt-3">
                     <label>Full Image </label>
                     <input type="file" required name="header_image[]" multiple>
                     <small>(1920x600px, max 500KB)</small>
                   </div>
                   
                   <div class="col-md-4 mb-3 mt-3">
                     <label>Brochure (PDF)</label>
                     <input type="file" name="property[brochure]">
                   </div>
                   
                  
                  
                 </div>
                 
                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing1</label>
                         <input class="form-control"  type="text" name="property[one_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing1 Image</label>
                         <input type="file" name="property[Drawingone_img]">
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing2</label>
                         <input class="form-control"  type="text" name="property[two_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing2 Image</label>
                         <input type="file" name="property[Drawingtwo_img]">
                       </div>
                     </div>
                   </div>
                </div>  
                
                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing3</label>
                         <input class="form-control"  type="text" name="property[three_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing3 Image</label>
                         <input type="file" name="property[Drawingthree_img]">
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing4</label>
                         <input class="form-control"  type="text" name="property[four_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing4 Image</label>
                         <input type="file" name="property[Drawingfour_img]">
                       </div>
                     </div>
                   </div>
                </div>  



                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing5</label>
                         <input class="form-control"  type="text" name="property[five_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing5 Image</label>
                         <input type="file" name="property[Drawingfive_img]">
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing6</label>
                         <input class="form-control"  type="text" name="property[six_drawing]">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing6 Image</label>
                         <input type="file" name="property[Drawingsix_img]">
                       </div>
                     </div>
                   </div>
                </div>   
                   <!-- Submit and Reset Buttons -->
                   <div class="row form-actions text-center mt-4 pb-5">
                     <div class="col-md-12">
                       <input type="submit" name="commit" value="Add Property" class="btn text-white bg-brick-red rounded">
                       <button type="reset" class="btn text-black bg-secondary rounded">Discard</button>
                     </div>
                   </div>
                 </div>
               </form>

                           
        <?php require_once('footer.php'); ?>
        
    <script>
  const minSelect = document.getElementById('area_min');
  const maxSelect = document.getElementById('area_max');
  const errorText = document.getElementById('area_error');

  function validateArea() {
    const min = parseInt(minSelect.value);
    const max = parseInt(maxSelect.value);

    if (minSelect.value && maxSelect.value && min > max) {
      errorText.style.display = 'block';
    } else {
      errorText.style.display = 'none';
    }
  }

  minSelect.addEventListener('change', validateArea);
  maxSelect.addEventListener('change', validateArea);
</script>

<script>
function alphabhets(event) {
  const char = String.fromCharCode(event.which);
  const allowed = /^[A-Za-z\s]$/; // allows letters and space

  if (!allowed.test(char)) {
    event.preventDefault();
    return false;
  }
  return true;
}
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const totalAptsInput = document.getElementById('total_apts');
    const forSaleInput = document.getElementById('for_sale');
    const floorsInput = document.getElementById('floors');

    // Validate: For Sale should not be greater than Total Apartments
    if (totalAptsInput && forSaleInput) {
      forSaleInput.addEventListener('input', function () {
        const totalApts = parseInt(totalAptsInput.value);
        const forSale = parseInt(forSaleInput.value);

        if (!isNaN(totalApts) && !isNaN(forSale) && forSale > totalApts) {
          alert("For Sale cannot be more than Total Apartments.");
          forSaleInput.value = '';
        }
      });
    }

    // Validate: Floors should not be negative
    if (floorsInput) {
      floorsInput.addEventListener('input', function () {
        const floorValue = parseInt(floorsInput.value);

        if (!isNaN(floorValue) && floorValue < 0) {
          alert("Floors value cannot be negative.");
          floorsInput.value = '';
        }
      });
    }
  });
</script>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    const totalAptsInput = document.getElementById('total_apts');

    totalAptsInput.addEventListener('input', function () {
      const val = parseInt(this.value);
      if (val < 1) {
        alert("Minimum number of flats is 1.");
        this.value = 1;
      } else if (val > 500) {
        alert("Maximum number of flats is 500.");
        this.value = 500;
      }
    });
  });
</script>
    
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split("T")[0];

    // List of date input IDs
    const dateFields = [
      { id: "planning_permit_date", label: "Planning Permit Date" },
      { id: "government_approvals_building_permission_date", label: "Building Permit Date" },
      { id: "government_approvals_tnrera_date", label: "RERA Date" },
      { id: "government_approvals_ccertificate_date", label: "Completion Certificate Date" }
    ];

    dateFields.forEach(field => {
      const input = document.getElementById(field.id);
      if (input) {
        input.setAttribute("max", today); // Restrict picker

        input.addEventListener("change", function () {
          const selectedDate = new Date(this.value);
          const currentDate = new Date();

          // Compare selected date to today
          if (selectedDate > currentDate) {
            alert(field.label + " cannot be in the future.");
            this.value = "";
          }
        });
      }
    });
  });
</script>    
        