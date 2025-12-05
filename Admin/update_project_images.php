  <?php
  //fetch.php
 // Always start session at top

$userid = $_POST['userid'] ?? 'unknown';
$username = $_POST['username'] ?? 'unknown';

  $conn = mysqli_connect("localhost", "ramaniyamnewayat_user", "=AX;D=Mlq5IG", "ramaniyamnewayat_dbase");

  $image_date_new = $_POST["image_date_new"];

  $tableid=$_POST['table_id'];
  
  $projectidd=$_POST['projectid'];
  
  $project_update_description = $_POST["project_update_description"];
  
  $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
    
  $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';

  $files = isset($_FILES["files"]) ? $_FILES["files"] : null;

  if (!empty($files)) {
      $uploadDir = "../assets/uploads/project-images/"; // Directory to store uploaded files
      $uploadedFiles = [];
      foreach ($_FILES["files"]["tmp_name"] as $key => $tmpName) {
          if ($_FILES["files"]["error"][$key] === UPLOAD_ERR_OK) {
              $fileExt = pathinfo(
                  $_FILES["files"]["name"][$key],
                  PATHINFO_EXTENSION
              );
              $uniqueID = time() . "_" . uniqid(); // Generate time-based unique ID
              $fileName = $uniqueID . "." . $fileExt; // Create unique file name
              $targetFilePath = $uploadDir . $fileName;

              // Move the file to the upload directory
              if (move_uploaded_file($tmpName, $targetFilePath)) {
                  $uploadedFiles[] = $fileName;
              }
          }
      }

      $fileNamesString = implode(",",$uploadedFiles);

      $query = "UPDATE tbl_project_updation SET project_date='$image_date_new', updated='$project_update_description', photos='$fileNamesString' WHERE id=$tableid";
      
       
      if ($conn->query($query)) {
          
          
           $sql = "INSERT INTO admin_log (user_id, username, action , module , item_id,ip_address,user_agent,status)
        
        VALUES ('$userid', '$username', 'Property Construction Images Updated ','Images','$projectidd','$ip_address','$user_agent','Success')";
        
        if (mysqli_query($conn, $sql)) {
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

           echo "Project Images updated Successfully!";
           
      } else {
          echo "Error updating user.";
      }

  } else {

       $query = "UPDATE tbl_project_updation SET project_date='$image_date_new', updated='$project_update_description' WHERE id=$tableid";
     

      if ($conn->query($query)) {
          
         $sql = "INSERT INTO admin_log (user_id, username, action , module ,item_id, ip_address,user_agent,status)
        
        VALUES ('$userid', '$username', 'Property Construction Images Updated','Images','$projectidd','$ip_address','$user_agent','Success')";
        
        if (mysqli_query($conn, $sql)) {
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }


          echo "Project details updated Successfully!";

      } else {

            echo "Error updating user.";

      }
  }

?>
