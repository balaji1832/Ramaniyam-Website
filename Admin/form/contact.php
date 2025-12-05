
<?php


if (isset($_POST['submit'])) {   
    require_once "db.php";



    // Check if form data is received
    echo "<h4>POST Data:</h4><pre>";
    print_r($_POST);
    echo "</pre>";

    // Sanitize Input
    $p_id = mysqli_real_escape_string($con, $_POST['p_id']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $url = mysqli_real_escape_string($con, $_POST['url']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $map_location = mysqli_real_escape_string($con, $_POST['map_location']);
    $area = mysqli_real_escape_string($con, $_POST['area']);
    $floors = mysqli_real_escape_string($con, $_POST['floors']);
    $number_of_flats = mysqli_real_escape_string($con, $_POST['number_of_flats']);
    $overview = mysqli_real_escape_string($con, $_POST['overview']);
    $amenities = mysqli_real_escape_string($con, $_POST['amenities']);
    $planning_permit_no = mysqli_real_escape_string($con, $_POST['planning_permit_no']);
    $planning_permit_date = mysqli_real_escape_string($con, $_POST['planning_permit_date']);
    $building_permission_no = mysqli_real_escape_string($con, $_POST['building_permission_no']);
    $building_permission_date = mysqli_real_escape_string($con, $_POST['building_permission_date']);
    $tnrera = mysqli_real_escape_string($con, $_POST['tnrera']);
    $tnrera_date = mysqli_real_escape_string($con, $_POST['tnrera_date']);
    $meta_title = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keyword = mysqli_real_escape_string($con, $_POST['meta_keyword']);

    // File Upload Handling
    function uploadFile($file) {
        if (!empty($file['tmp_name'])) {
            return mysqli_real_escape_string($GLOBALS['con'], file_get_contents($file['tmp_name']));
        }
        return NULL;
    } $header_image = uploadFile($_FILES['header_image']);
    $card_image = uploadFile($_FILES['card_image']);
    $brochure = uploadFile($_FILES['brochure']);
    $layouts = uploadFile($_FILES['layouts']);

    // Set timezone and date
    date_default_timezone_set('Asia/Kolkata');
    $date = date('Y-m-d H:i:s');

    // Check if p_id already exists
    $count_query = "SELECT COUNT(*) as count FROM ramaniyam-db WHERE p_id = '$p_id'";
    $count_result = mysqli_query($con, $count_query);
    $row = mysqli_fetch_assoc($count_result);
    $count = $row['count'];

    // Insert only if p_id is not present
    if ($count == 0) {
        $sql = "INSERT INTO ramaniyam-db (
            p_id, status, title, url, location, map_location, area, floors, number_of_flats, overview, amenities, 
            planning_permit_no, planning_permit_date, building_permission_no, building_permission_date, tnrera, tnrera_date, 
            meta_title, meta_description, meta_keyword, header_image, card_image, brochure, layouts, created_at
        ) VALUES (
            '$p_id', '$status', '$title', '$url', '$location', '$map_location', '$area', '$floors', '$number_of_flats', 
            '$overview', '$amenities', '$planning_permit_no', '$planning_permit_date', '$building_permission_no', 
            '$building_permission_date', '$tnrera', '$tnrera_date', '$meta_title', '$meta_description', '$meta_keyword', 
            '$header_image', '$card_image', '$brochure', '$layouts', '$date'
        )";

        if (mysqli_query($con, $sql)) {
            echo "Project added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($con);
        }
    } else {
        echo '<script>alert("Entered ID already exists. Kindly enter a new ID."); location.href="../index.php";</script>';
    }

    // Close connection
    mysqli_close($con);
}
?>
