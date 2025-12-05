<?php require_once "header.php"; ?>

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

// Make sure session is started if you're using $_SESSION variables
session_start();


if (isset($_POST["commit"])) {
    require_once "form/db.php";
    include("inc/log_helper.php");
    error_reporting(1);

    // Collect inputs safely
    function sanitize($con, $value) {
        return mysqli_real_escape_string($con, trim($value));
    }



    $p_id = sanitize($con, $_POST["property"]["p_id"]);
    $p_name = sanitize($con, $_POST["property"]["title"]);

    $location = sanitize($con, $_POST["property"]["location"]);
    
   $map_location_raw = $_POST["property"]["map_location"];

// Step 1: Remove backslashes added by HTML form submission
$map_location_stripped = stripslashes($map_location_raw);

// Step 2: Optionally remove extra unwanted whitespace
$map_location_trimmed = trim($map_location_stripped);

// Step 3: Sanitize it to prevent SQL injection (PDO Example shown)
$map_location = htmlspecialchars($map_location_trimmed, ENT_QUOTES, 'UTF-8');
    
    
    $floors = sanitize($con, $_POST["property"]["floors"]);
    $number_of_flats = sanitize($con, $_POST["property"]["number_of_flats"]);
    $sales_flats = sanitize($con, $_POST["property"]["sales_flats"]);
    $overview = sanitize($con, $_POST["property"]["overview"]);
    $meta_title = sanitize($con, $_POST["property"]["meta_title"]);
    $meta_description = sanitize($con, $_POST["property"]["meta_description"]);
    $meta_keyword = sanitize($con, $_POST["property"]["meta_keywords"]);
    $area_min = intval($_POST["property"]["area_min"]);
    $area_max = intval($_POST["property"]["area_max"]);

    $project_status = sanitize($con, $_POST["property"]["project_status"]);
    $project_stage = sanitize($con, $_POST["property"]["project_staging"]);
    $project_type = sanitize($con, $_POST["property"]["type"]);
    
    // $project_availability = sanitize($con, $_POST["property"]["avaliablity"]);
    $vicinity = sanitize($con, $_POST["property"]["vicinity"]);
    $street = sanitize($con, $_POST["property"]["street"]);
    $tagline = sanitize($con, $_POST["property"]["tagline"]);
    $senior_living = isset($_POST["property"]["senior_living"]) ? 1 : 0;
    $featured = isset($_POST["property"]["featured"]) ? 1 : 0;


    $one_drawing = sanitize($con, $_POST["property"]["one_drawing"]);
    $two_drawing = sanitize($con, $_POST["property"]["two_drawing"]);
    $three_drawing = sanitize($con, $_POST["property"]["three_drawing"]);
    $four_drawing = sanitize($con, $_POST["property"]["four_drawing"]);
    $five_drawing = sanitize($con, $_POST["property"]["five_drawing"]);
    $six_drawing = sanitize($con, $_POST["property"]["six_drawing"]);

  

    // Government approvals
    $gov = $_POST["government_approvals"];
    $planning_permit_no = sanitize($con, $gov["planning_permit_no"]);
    $planning_permit_date = sanitize($con, $gov["planning_permit_date"]);
    $building_permission_no = sanitize($con, $gov["building_permission_no"]);
    $building_permission_date = sanitize($con, $gov["building_permission_date"]);
    $tnrera = sanitize($con, $gov["tnrera"]);
    $tnrera_date = sanitize($con, $gov["tnrera_date"]);
    $ccertificate = sanitize($con, $gov["ccertificate"]);
    $ccertificate_date = sanitize($con, $gov["ccertificate_date"]);
    $selected_values = isset($_POST['amenities']) ? implode(",", $_POST['amenities']) : '';
    $selected_attributes = isset($_POST['attributes']) ? implode(",", $_POST['attributes']) : '';
    
    $uploadDir = "../assets/uploads/project-images/";


 
    $fileFields = [
    "thumb_image"        => "thumb_image",
    "card_image"         => "card_image",
    "overview_image"     => "overview_image",
    "brochure"           => "brochure",
    "ppermit_doc"        => "planning_permit_doc",
    "buildingpermit_doc" => "building_permit_doc",
    "tnrera_doc"         => "rera_doc",
    "ccertificate_doc"   => "completion_doc",

    // Drawing image fields
    "Drawingone_img"     => "drawing1_image",
    "Drawingtwo_img"     => "drawing2_image",
    "Drawingthree_img"   => "drawing3_image",
    "Drawingfour_img"    => "drawing4_image",
    "Drawingfive_img"    => "drawing5_image",
    "Drawingsix_img"     => "drawing6_image",
];

$fileParams = [];


foreach ($fileFields as $input => $column) {
    // Determine file source based on category
    $fileGroup = null;

    if (isset($_FILES['property']['name'][$input])) {
        $fileGroup = 'property';
    } elseif (isset($_FILES['government_approvals']['name'][$input])) {
        $fileGroup = 'government_approvals';
    }

    if ($fileGroup !== null) {
        $fileName = $_FILES[$fileGroup]['name'][$input];
        $tmpName = $_FILES[$fileGroup]['tmp_name'][$input];
        $error = $_FILES[$fileGroup]['error'][$input];

        if (!empty($fileName) && $error === UPLOAD_ERR_OK) {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $newName = $column . "-" . time() . "-" . mt_rand() . "." . $ext;

            if (move_uploaded_file($tmpName, $uploadDir . $newName)) {
                $fileParams[$column] = $newName;
            } else {
                error_log("Move failed for $column ($fileName)");
            }
        } else {
            error_log("File not uploaded or error for $input — error code: $error");
        }
    } else {
        error_log("Unknown file input: $input");
    }
}


    // Handle multiple floorplan uploads
    $floorplanNames = [];
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['files']['error'][$key] === UPLOAD_ERR_OK) {
                $fileExt = pathinfo($_FILES['files']['name'][$key], PATHINFO_EXTENSION);
                $fileName = time() . '_' . uniqid() . '.' . $fileExt;
                if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                    $floorplanNames[] = $fileName;
                }
            }
        }
        if (!empty($floorplanNames)) {
            $fileParams["header_image"] = implode(",", $floorplanNames);
        }
    }

    // Base fields
    $updateFields = [
        "title" => $p_name,
        "location" => $location,
        "url" => $url,
        "amenities" => $selected_values,
        "map_location" => $map_location,
        "area_min" => $area_min,
        "area_max" => $area_max,
        "floors" => $floors,
        "number_of_flats" => $number_of_flats,
        "sales_flats" => $sales_flats,
        "overview" => $overview,
        "planning_permit_no" => $planning_permit_no,
        "planning_permit_date" => $planning_permit_date,
        "building_permission_no" => $building_permission_no,
        "building_permission_date" => $building_permission_date,
        "tnrera" => $tnrera,
        "tnrera_date" => $tnrera_date,
        "ccertificate" => $ccertificate,
        "ccertificate_date" => $ccertificate_date,
        "project_status" => $project_status,
        "project_stage" => $project_stage,
        "project_type" => $project_type,
        "vicinity" => $vicinity,
        "street" => $street,
        "tag_line" => $tagline,
        "attributes" => $selected_attributes,
        "meta_title" => $meta_title,
        "meta_description" => $meta_description,
        "meta_keyword" => $meta_keyword,
        "drawing1"=>$one_drawing,
        "drawing2"=>$two_drawing,
        "drawing3"=>$three_drawing,
        "drawing4"=>$four_drawing,
        "drawing5"=>$five_drawing,
        "drawing6"=>$six_drawing
    ];

    // Merge uploaded files into the main update
    $updateFields = array_merge($updateFields, $fileParams);

  
    // Build query dynamically
    $queryParts = [];
    foreach ($updateFields as $col => $val) {
        $queryParts[] = "$col = :$col";
    }
     $queryString = "UPDATE tbl_projects SET " . implode(", ", $queryParts) . " WHERE p_id = :p_id LIMIT 1";

    // Prepare and bind
    $stmt = $pdo->prepare($queryString);
    foreach ($updateFields as $col => $val) {
        $stmt->bindValue(":$col", $val);
    }
    $stmt->bindValue(":p_id", $p_id);
    $query_execute = $stmt->execute();

    // Log
    if ($query_execute) {
        $new_name = $p_name;
        log_admin_action($_SESSION['userid'], $_SESSION['username'], 'Project Updated', 'Project', $p_id, '', $new_name);

          echo '<script>alert("Property Details updated successfully."); location.href="projects.php";</script>';
    } else {
        $success_message = "Error in updating project.";
    }
}


?>



<?php if (!isset($_REQUEST["id"])) {
    //  header('location: logout.php');
    //  exit;
} else {
    // Check the id is valid or not

    $statement = $pdo->prepare("SELECT * FROM tbl_projects WHERE p_id =?");
    $statement->execute([$_REQUEST["id"]]);
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($total == 0) {
        header("location: logout.php");
        exit();
    }
} ?>



<?php
$statement = $pdo->prepare("SELECT * FROM tbl_projects WHERE p_id=?");
$statement->execute([$_REQUEST["id"]]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {




    $p_name = $row["title"]; 
    $p_id = $row["p_id"];
    $location = $row["location"]; 
    $project_status = $row["project_status"];

    $project_status = str_replace('-', ' ', $project_status);

    $project_stage = $row["project_stage"];
    $project_stage = str_replace('-', ' ', $project_stage);
    $project_availability = $row["project_availability"];
    $project_type = $row["project_type"];
    $vicinity = $row["vicinity"]; $locality = $row["locality"];  $street = $row["street"];
    $tag_line = $row["tag_line"];   $overview = $row["overview"];
    
    
    $url = $row["url"];
    $map_location = $row["map_location"];
    // $area = $row["area"];
    $floors = $row["floors"];
    
    $area_min = isset($row['area_min']) ? (int)$row['area_min'] : '';
    $area_max = isset($row['area_max']) ? (int)$row['area_max'] : '';
    
     $drawing1 = $row['drawing1']; $drawing1_image = $row['drawing1_image'];
     $drawing2 = $row['drawing2']; $drawing2_image = $row['drawing2_image'];
     $drawing3 = $row['drawing3']; $drawing3_image = $row['drawing3_image'];
     $drawing4 = $row['drawing4']; $drawing4_image = $row['drawing4_image'];
     $drawing5 = $row['drawing5']; $drawing5_image = $row['drawing5_image'];
     $drawing6 = $row['drawing6']; $drawing6_image = $row['drawing6_image'];


    $number_of_flats = $row["number_of_flats"];
    $overview = $row["overview"];
    $planning_permit_no = $row["planning_permit_no"];
    $planning_permit_date = $row["planning_permit_date"];
    $building_permission_no = $row["building_permission_no"];
    $building_permission_date = $row["building_permission_date"]; 
    $tnrera = $row["tnrera"];
    $tnrera_date = $row["tnrera_date"];
    $ccertificate = $row["ccertificate"];
    $ccertificate_date = $row["ccertificate_date"];
   
    $planning_permit_doc = $row["planning_permit_doc"]; 
    
    $building_permit_doc = $row["building_permit_doc"];
    
    $rera_doc = $row["rera_doc"];
    
    $completion_doc = $row["completion_doc"];
    
    $meta_title = $row["meta_title"];
    
    $meta_description = $row["meta_description"];
    
    $meta_keyword = $row["meta_keyword"];
    
    $header_image = $row["header_image"];
    
    $card_image = $row["card_image"];
    
    $thumb_image = $row["thumb_image"];
    
    $overview_image = $row["overview_image"];
    
    $header_image = $row["header_image"];
    
    $sales_flats = $row["sales_flats"];
    
    $header_image = explode(",", $header_image);

    $planning_permit_date = $row["planning_permit_date"];

    $brochure = $row["brochure"];
     
    $amenities = explode(",", $row["amenities"]);

    $attributes = explode(",", $row["attributes"]);

}

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


// $statement = $pdo->prepare("SELECT *
//                         FROM tbl_end_category t1
//                         JOIN tbl_mid_category t2
//                         ON t1.mcat_id = t2.mcat_id
//                         JOIN tbl_top_category t3
//                         ON t2.tcat_id = t3.tcat_id
//                         WHERE t1.ecat_id=?");
// $statement->execute(array($ecat_id));
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
// foreach ($result as $row) {
//  $ecat_name = $row['ecat_name'];
//     $mcat_id = $row['mcat_id'];
//     $tcat_id = $row['tcat_id'];
// }

// $statement = $pdo->prepare("SELECT * FROM tbl_product_size WHERE p_id=?");
// $statement->execute(array($_REQUEST['id']));
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
// foreach ($result as $row) {
//  $size_id[] = $row['size_id'];
// }

// $statement = $pdo->prepare("SELECT * FROM tbl_product_color WHERE p_id=?");
// $statement->execute(array($_REQUEST['id']));
// $result = $statement->fetchAll(PDO::FETCH_ASSOC);
// foreach ($result as $row) {
//  $color_id[] = $row['color_id'];
// }

if (isset($_GET["id"])) {
    $prev_value = $_GET["id"] - 1;
    $next_value = $_GET["id"] + 1;
}

$next_link = "id=" . $next_value;
$prev_link = "id=" . $prev_value;
?>


 <section class="content-header">
            <div class="content-header-left">
                <h1>Edit Property
            </h1>
            </div>
            <!--<div class="content-header-right">-->
            <!--    <a href="projects.php" class="btn btn-primary btn-sm">View All</a>-->
            <!--</div>-->
        </section>


<section >

    <div class="row">
        <div class="col-md-12">

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

        </div>
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

           <form class="form-horizontal" id="projectForm" action="" method="post" enctype="multipart/form-data" onsubmit="return validateCheckboxes();" >
             <input class="form-control" required type="hidden" name="property[p_id]" id="property_title" value="<?php echo $p_id; ?>">

            <div class="box-info">
                 <div class="box-info">
                   <h4 class="mb-4 text-brick-red underline-brick-red">Basic Information</h4>
                   <div class="row pb-2">
                     <!-- Project Name -->
                     <div class="col-sm-4 pl-3">
                       <label>Project Name <span>*</span>
                       </label>
                       <input class="form-control" pattern="[A-Za-z ]{1,30}" required type="text" name="property[title]" id="property_title" onkeypress="return alphabhets(event);" value="<?php echo $p_name; ?>" title="Only Alphabets and Spaces allowed">
                       <small>(Notes: Enter Only Alphabets, max 30 characters)</small>
                     </div>
                     <!-- Project Status -->
                     <div class="col-sm-4">
                       <label>Project Status <span>*</span>
                       </label>

                       <select name="property[project_status]" required class="form-control select2 top-cat">
                         <option value="">Select Project Status</option> 
<option value="Upcoming" <?php if ($project_status =='Upcoming') { echo "selected"; } ?>>Upcoming</option>
                         <option value="Newly-Launched" <?php if ($project_status =='Newly Launched') { echo "selected"; } ?> >Newly Launched</option>
                         <option value="Low-Priority" <?php if ($project_status =='Low Priority') { echo "selected"; } ?>>Low Priority</option>
                       </select>
                       
                     </div>
                     <!-- Project Stage -->
                     <div class="col-sm-4">
                       <label>Project Stage <span>*</span>
                       </label>
                      <select name="property[project_staging]"  required class="form-control select2 top-cat">
                            <option value="">Select Project Stage</option>
                            <?php
                            $statement = $pdo->prepare(
                            "SELECT * FROM tbl_top_category ORDER BY tcat_name ASC"
                            );
                            $statement->execute();
                            $result = $statement->fetchAll(
                            PDO::FETCH_ASSOC
                            );


                            foreach ($result as $row) { ?>
                            <option value="<?php echo $row["tcat_name"]; ?>"  
                    <?php if ($row["tcat_name"] == $project_stage) {
                            echo "selected";
                            } ?>>  <?php echo $row["tcat_name"]; ?> </option>
                                    <?php }
                                ?>
                                            </select>
                       </select>
                     </div>
                   </div>
                   <div class="row ">
                     <!-- Project Availability -->
<!--                     <div class="col-sm-4 pl-3">-->
<!--                       <label>Project Availability</label>-->
<!--                       <select name="property[avaliablity]" class="form-control select2 top-cat">-->
<!--                         <option value="#">Select Project Availability</option>-->

<!-- <option value="Available" <?php if ($project_availability =='Available') { echo "selected"; } ?> >Available</option>-->

<!--<option value="Sold Out" <?php if ($project_availability =='Sold Out') { echo "selected"; } ?> >Sold Out</option>-->

                       
<!--                       </select>-->
<!--                     </div>-->
                     <!-- Project Type -->
                     <div class="col-sm-4 pl-3">
                       <label>Project Type <span>*</span>
                       </label>
                       <select name="property[type]" required class="form-control select2 top-cat">
                         <option value="">Select Project Type</option>

                          <option value="Apartments" <?php if ($project_type =='Apartments') { echo "selected"; } ?> >Apartments</option>

<option value="Plots" <?php if ($project_type =='Plots') { echo "selected"; } ?> >Plots</option>
                       
                       </select>
                     </div>
                     <!-- Vicinity -->
                     <div class="col-sm-4 pl-3">
                       <label>Vicinity <span>*</span>
                       </label>
                       <input class="form-control" required type="text" name="property[vicinity]" maxlength="30" value="<?php echo  $vicinity; ?>" >
                       <small>(Notes: Enter Only Characters, max 30)</small>
                     </div>
                   </div>
                   <div class="row pb-2">
                     <div class="col-sm-12 pl-3 px-5 ">
                       <label>Attributes 
                       </label>
                       <div class="amenities-multi-select"> <?php
                foreach ($newoptions as $key => $label) {

                    $checked = in_array($key, $attributes) ? "checked" : "";
                    echo "
                 <input type='checkbox' name='attributes[]' value='$key' $checked> $label 
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
                       <input class="form-control"  type="text" name="property[location]" maxlength="30" value="<?php echo $location; ?>">
                       <small>(Notes: Enter Only Characters, max 30)</small>
                     </div>
                     <!-- Street -->
                     <div class="col-sm-4 pl-3">
                       <label>Street</label>
                       <input class="form-control"  type="text" name="property[street]"  value="<?php echo  $street; ?>">
                     </div>
                     <!-- Map Location -->
                     <div class="col-sm-4 pl-3">
                       <label>Map Location <span>*</span>
                       </label>
                       <textarea class="form-control" required name="property[map_location]"><?php echo  $map_location; ?></textarea>
                       <small>(Notes: Paste Google Maps iframe embed URL)</small>
                     </div>
                   </div>
                   <div class="row pb-2">
                     <!-- Floors -->
                     <div class="col-sm-4 pl-3">
                       <label>Floors <span>*</span>
                       </label>
                       <input class="form-control" required type="text" 
                       id="floors" name="property[floors]" maxlength="50" value="<?php echo  $floors; ?>" >
                     </div>
                     <!-- Number of Flats -->
                     <div class="col-sm-4 pl-3">
                       <label>Total Apts <span>*</span>
                       </label>
                       <input class="form-control" required type="number" name="property[number_of_flats]" id="total_apts" value="<?php echo  $number_of_flats; ?>"  >
                     </div>
                     <!-- Apartments for Sale -->
                     <div class="col-sm-4 pl-3">
                       <label> For Sale <span>*</span>
                       </label>
                       <input class="form-control" required type="number" name="property[sales_flats]" id="for_sale" value="<?php echo  $sales_flats; ?>">
                     </div>
                   </div>
                   <div class="row pb-2">
                     <!-- Overview -->
                     <div class="col-sm-4 pl-3">
                       <label>Overview</label>
                       <textarea class="form-control" name="property[overview]" maxlength="300"><?php echo  $overview; ?></textarea>
                       <small>(Max 300 characters)</small>
                     </div>
                     <div class="col-sm-4 pl-3">
                       <label>Tag Line</label>
                       <input class="form-control"  type="text" name="property[tagline]" value="<?php echo  $tag_line; ?>">
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
                       <div id="checkbox-error" style="color: red; display: none;">
  Please select at least one amenity.
</div>
                     <div class="horizontal-categories">
    <?php foreach ($categorizedOptions as $category => $items): ?>
        <div class="category-column">
            <h4><?= $category ?></h4>
            <div class="checkbox-list">
                <?php foreach ($items as $id => $label): ?>
                    <?php $checked = in_array($id, $amenities) ? "checked" : ""; ?>
                    <label>
                        <input type="checkbox" name="amenities[]" value="<?= $id ?>" <?= $checked ?>>
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
                     <input class="form-control"  type="text" name="government_approvals[planning_permit_no]"  value="<?php echo $planning_permit_no; ?>">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Planning Permit Date</label>
                     <input class="form-control"  type="date" name="government_approvals[planning_permit_date]" id="planning_permit_date" value="<?php echo $planning_permit_date; ?>">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Planning Permit Image</label>
                     <input type="file"  name="government_approvals[ppermit_doc]"  >
                     <?php if($planning_permit_doc !="") {?>
                                <p>Filename: <?php echo  $planning_permit_doc; ?> </p>
                                        
                                        <?php } else {
                                        
                                 
                                        } ?> 
                   </div>


                   <div class="mb-3 col-md-6">
                     <label class="form-label" for="government_approvals_building_permission_no">Building Permit #</label>
                     <input class="form-control"  type="varchar" name="government_approvals[building_permission_no]" id="government_approvals_building_permission_no" value="<?php echo $building_permission_no; ?>">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_date_of_permit">Building Permit Date</label>
                     <input class="form-control"  type="date" name="government_approvals[building_permission_date]" id="government_approvals_building_permission_date" value="<?php echo $building_permission_date; ?>">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Building Permit Image</label>
                     <input type="file"  name="government_approvals[buildingpermit_doc]" >

                    <?php if($building_permit_doc !="") {?>
                    <p>Filename: <?php echo  $building_permit_doc; ?> </p>

                    <?php } else {


                    } ?> 
                    </div>
                   <div class="mb-3 col-md-6">
                     <label class="form-label text-uppercase" for="government_approvals_tnrera">TNRERA #</label>
                     <input class="form-control"  type="varchar" name="government_approvals[tnrera]" id="government_approvals_tnrera" value="<?php echo $tnrera;  ?>">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_dated">RERA Date </label>
                     <input class="form-control"  type="date" name="government_approvals[tnrera_date]" id="government_approvals_tnrera_date" value="<?php echo $tnrera_date;  ?>">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>RERA Image</label>
                     <input type="file"  name="government_approvals[tnrera_doc]" >
                     
                     <?php if($rera_doc !="") {?>
                    <p>Filename: <?php echo  $rera_doc; ?> </p>

                    <?php } else {


                    } ?> 

                   </div>
                   <div class="mb-3 col-md-6">
                     <label class="form-label text-uppercase" for="Completion_Certificate">Completion Certificate # </label>
                     <input class="form-control"  type="varchar" name="government_approvals[ccertificate]" id="government_approvals_ccertificate" 
                     value="<?php echo $ccertificate; ?>">
                   </div>
                   <div class="mb-3 col-md-3">
                     <label class="form-label" for="government_approvals_dated">Completion Certificate Date</label>
                     <input class="form-control"  type="date" name="government_approvals[ccertificate_date]" id="government_approvals_ccertificate_date" value="<?php echo $ccertificate_date; ?>">
                   </div>
                   <div class="col-md-3 mb-3">
                     <label>Completion Certificate Image</label>
                     <input type="file"  name="government_approvals[ccertificate_doc]" >
                        <?php if($completion_doc !="") {?>
                    <p>Filename: <?php echo  $completion_doc; ?> </p>

                    <?php } else {


                    } ?> 

                   </div>
                   <!-- Add remaining government approval fields as you've added -->
                   <!-- Building permission, TNRERA, Completion certificate -->
                 </div>
                 <!-- SEO Section -->
                 <div class="row pb-2 px-5 mt-5 pl-3">
                   <h4 class="mb-4 text-brick-red underline-brick-red">SEO Properties</h4>
                   <div class="col-md-4 mb-3">
                     <label>Meta Title</label>
                     <textarea class="form-control" name="property[meta_title]"><?php echo $meta_title; ?></textarea>
                   </div>
                   <div class="col-md-4 mb-3">
                     <label>Meta Description</label>
                     <textarea class="form-control" name="property[meta_description]" ><?php echo $meta_description; ?></textarea>
                   </div>
                   <div class="col-md-4 mb-3">
                     <label>Meta Keywords</label>
                     <textarea class="form-control" name="property[meta_keywords]"><?php echo $meta_keyword; ?></textarea>
                   </div>
                 </div>
                 <!-- Property Media Uploads -->
                 <div class="row pb-2 px-5 pl-3">
                   <h4 class="mb-4 text-brick-red underline-brick-red">Property Media & Documents</h4>
                   
                   
                     <div class="col-md-4 mb-3">
                     <label>Thumbnail Image</label>
 <input type="file"    name="property[thumb_image]" id="property_card_image">                     <small>(500x500px, max 500KB)</small>

                                                  
                                <?php if($thumb_image !="") {?>
                                
                                   <p>Filename: <?php echo  $thumb_image; ?> </p>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/project-images/<?php echo $thumb_image ; ?>" class="existing-photo" width="140">
                                        </div>
                                    </div>
                                
                                <?php } else {
                                
                                echo "<b>File Not uploaded</b> ";
                                } ?> 
                                
                   </div>
                   
                   
                   <div class="col-md-4 mb-3">
                     <label>Card Image</label>
 <input type="file"    name="property[card_image]" id="property_card_image">                     <small>(1000x1000px, max 500KB)</small>

                                                  
                                <?php if($card_image !="") {?>
                                
                                   <p>Filename: <?php echo  $card_image; ?> </p>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/project-images/<?php echo $card_image ; ?>" class="existing-photo" width="140">
                                        </div>
                                    </div>
                                
                                <?php } else {
                                
                                echo "<b>File Not uploaded</b> ";
                                } ?> 
                                
                   </div>
                   
                   
                     <div class="col-md-4 mb-3">
                     <label>Overview Image</label>
 <input type="file" name="property[overview_image]" id="property_overview_image">                     <small>(1000x1000px, max 500KB)</small>

                                                  
                                <?php if($overview_image !="") {?>
                                
                                   <p>Filename: <?php echo  $overview_image; ?> </p>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Existing Photo</label>
                                        <div class="col-sm-6" style="padding-top:6px;">
                                            <img src="../assets/uploads/project-images/<?php echo $overview_image ; ?>" class="existing-photo" width="140">
                                        </div>
                                    </div>
                                
                                <?php } else {
                                
                                echo "<b>File Not uploaded</b> ";
                                } ?> 
                                
                   </div>
                   
                   
                   <div class="col-md-4 mb-3 mt-3">
                     <label>Full Image </label>
                     <input type="file"  name="files[]" multiple>

                     <small>(1920x600px, max 500KB)</small>
                       
                         <div class="row"> 
                                     
                               <?php
                        
                        foreach ($header_image as $rowdataphotos) {
                        
                        if($rowdataphotos!="") {
                        
                        ?>
                            <div class="col-md-6 ">

                        <img src="../assets/uploads/project-images/<?php echo $rowdataphotos; ?>" alt="Service Photo" style="width:180px;">
                            </div>
                        <?php }  else {?>
                        <p>No Banner Photos Uploaded </p>
                        <?php } } ?> 
                        
                                           </div>

                   </div>

                  
                   <div class="col-md-4 mb-3 mt-3">
                     <label>Brochure (PDF)</label>
                     <input type="file" name="property[brochure]">
                      <?php if($brochure !="") {?>
                                <p>Filename: <?php echo  $brochure; ?> </p>
                                        
                                        <?php } else {
                                        
                                        echo "<b>PDF Not Avaliable</b> ";
                                        } ?> 
                   </div>
                   
                   
                 </div>
                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing1</label>
                         <input class="form-control"  type="text" name="property[one_drawing]" value="<?php echo $drawing1 ;?>">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing1 Image</label>
                         <input type="file" name="property[Drawingone_img]">
                        
                        <?php if($drawing1_image !="") {?>
                        <p>Filename: <?php echo  $drawing1_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 

                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing2</label>
                         <input class="form-control"  type="text" name="property[two_drawing]" value="<?php echo $drawing2; ?>">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing2 Image</label>
                         <input type="file" name="property[Drawingtwo_img]">
                          <?php if($drawing2_image !="") {?>
                        <p>Filename: <?php echo  $drawing2_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 
                       </div>
                     </div>
                   </div>
                </div>  
                
                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing3</label>
                         <input class="form-control"  type="text" name="property[three_drawing]" value="<?php echo $drawing3 ;?>">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing3 Image</label>
                         <input type="file" name="property[Drawingthree_img]">

                          <?php if($drawing3_image !="") {?>
                        <p>Filename: <?php echo  $drawing3_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing4</label>
                         <input class="form-control"  type="text" name="property[four_drawing]" value="<?php echo $drawing4 ;?>">

                         
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing4 Image</label>
                         <input type="file" name="property[Drawingfour_img]">
                          <?php if($drawing4_image !="") {?>
                        <p>Filename: <?php echo  $drawing4_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 
                       </div>
                     </div>
                   </div>
                </div>  



                 <div class="row   px-5 pl-3">
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing5</label>
                         <input class="form-control"  type="text" name="property[five_drawing]" value="<?php echo $drawing5 ;?>">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing5 Image</label>
                         <input type="file" name="property[Drawingfive_img]">

                          <?php if($drawing5_image !="") {?>
                        <p>Filename: <?php echo  $drawing5_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 
                       </div>
                     </div>
                   </div>
                   <div class="col-md-6">
                     <div class="row">
                       <div class="col-md-6 mb-3">
                         <label>Drawing6</label>
                         <input class="form-control"  type="text" name="property[six_drawing]" value="<?php echo $drawing6 ;?>">
                       </div>
                       <div class="col-md-6 mb-3">
                         <label>Drawing6 Image</label>
                         <input type="file" name="property[Drawingsix_img]">

                          <?php if($drawing6_image !="") {?>
                        <p>Filename: <?php echo  $drawing6_image; ?> </p>

                        <?php } else {

                        echo "<b>File Name Not Avaliable</b> ";
                        } ?> 
                       </div>
                     </div>
                   </div>
                </div>   
                   <!-- Submit and Reset Buttons -->
                   <div class="row form-actions text-center mt-4 pb-5">
                     <div class="col-md-12">
                       <input type="submit" name="commit" value="Update Property" class="btn text-white bg-brick-red rounded">
                       
                <a href="projects.php" class="btn text-white bg-brick-red rounded">Discard Changes </a>
        
                       <!--<button type="button" class="btn text-black bg-secondary rounded" onclick="resetAllFields()">Reset </button>-->

                     </div>
                   </div>
                 </div>
               </form>



<?php require_once "footer.php"; ?>

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
function validateCheckboxes() {
  const checkboxes = document.querySelectorAll('input[name="amenities[]"]:checked');
  const error = document.getElementById('checkbox-error');

  if (checkboxes.length === 0) {
    error.style.display = 'block';
    return false; 
  } else {
    error.style.display = 'none';
    return true;
  }
}
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
function resetAllFields() {
  // Clear all text, number, and date inputs
  const inputs = document.querySelectorAll('input[type="text"], input[type="number"], input[type="date"], input[type="url"]');
  inputs.forEach(input => input.value = '');

  // Uncheck all checkboxes
  const checkboxes = document.querySelectorAll('input[type="checkbox"]');
  checkboxes.forEach(checkbox => checkbox.checked = false);

  // Clear all textareas
  const textareas = document.querySelectorAll('textarea');
  textareas.forEach(textarea => textarea.value = '');

  // Reset all select dropdowns
  const selects = document.querySelectorAll('select');
  selects.forEach(select => select.selectedIndex = 0);

  // Clear all file inputs
  const fileInputs = document.querySelectorAll('input[type="file"]');
  fileInputs.forEach(file => {
    file.value = '';
  });

  // Remove image previews with class 'preview'
  const previewImages = document.querySelectorAll('img.preview');
  previewImages.forEach(img => {
    img.src = '';
  });

  // Optionally show alert (can be skipped if redirecting immediately)
  // alert("All fields have been reset.");

  // Redirect to project.php after reset (small delay optional)
  setTimeout(() => {
    window.location.href = 'projects.php?filter=active';
  }, 200); // 200ms delay so reset can complete cleanly
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
        