<?php require_once('header.php'); ?>

  <?php

if (isset($_POST["commit"])) {

    error_reporting(1);
    require_once "form/db.php";
    include("inc/log_helper.php");

    $valid = 1;
    $error_message = '';
    $pid = $_GET['id'];
    $uploadDir = '../assets/uploads/project-images/';

    $imageCaptions = $_POST['addimage'];
    $image_date = $_POST['addimage']['image_date'];

    // Sanitize all captions
    $captions = [
        'Imagefirstcaption'  => mysqli_real_escape_string($con, $imageCaptions['Imagefirstcaption']),
        'Imagetwocaption'    => mysqli_real_escape_string($con, $imageCaptions['Imagetwocaption']),
        'Imagethreecaption'  => mysqli_real_escape_string($con, $imageCaptions['Imagethreecaption']),
        'Imagefourcaption'   => mysqli_real_escape_string($con, $imageCaptions['Imagefourcaption']),
        'Imagefivecaption'   => mysqli_real_escape_string($con, $imageCaptions['Imagefivecaption'])
    ];

    // Upload handler
    function handleImageUpload($inputName, $imageKey, $prefix, $uploadDir, &$error_message, &$valid) {
        if (!empty($_FILES[$inputName]['name'][$imageKey])) {
            $fileName = $_FILES[$inputName]['name'][$imageKey];
            $tmpName = $_FILES[$inputName]['tmp_name'][$imageKey];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'jfif'];

            if (!in_array($ext, $allowedExts)) {
                $valid = 0;
                $error_message .= "Invalid file type for $imageKey. Allowed: jpg, jpeg, png, gif, webp, jfif<br>";
                return null;
            }

            $uniqueId = time() . '-' . mt_rand();
            $finalFileName = $prefix . '-' . $uniqueId . '.' . $ext;

            if (!move_uploaded_file($tmpName, $uploadDir . $finalFileName)) {
                $valid = 0;
                $error_message .= "Failed to upload $fileName<br>";
                return null;
            }

            return $finalFileName;
        }
        return null;
    }

    // Validate and upload image + caption pairs
    $imageNames = [];
    $requiredPairs = [
        ['Imagefirst', 'Imagefirstcaption', 'Add-construct-image1', 'Image1', true],  // Required
        ['Imagetwo', 'Imagetwocaption', 'Add-construct-image2', 'Image2', false],
        ['Imagethree', 'Imagethreecaption', 'Add-construct-image3', 'Image3', false],
        ['Imagefour', 'Imagefourcaption', 'Add-construct-image4', 'Image4', false],
        ['Imagefive', 'Imagefivecaption', 'Add-construct-image5', 'Image5', false]
    ];

    foreach ($requiredPairs as [$imageField, $captionField, $prefix, $imageKey, $isRequired]) {
        $hasImage = !empty($_FILES['addimage']['name'][$imageField]);
        $hasCaption = !empty($captions[$captionField]);

        if ($isRequired) {
            if (!$hasImage || !$hasCaption) {
                $valid = 0;
                $error_message .= "Image1 and its caption are required.<br>";
                continue;
            }
        }

        if ($hasImage && !$hasCaption) {
            $valid = 0;
            $error_message .= "Caption required for $imageKey<br>";
            continue;
        }

        if (!$hasImage && $hasCaption) {
            $valid = 0;
            $error_message .= "Image required for $imageKey caption<br>";
            continue;
        }

        if ($hasImage && $hasCaption) {
            $imageNames[$imageKey] = handleImageUpload('addimage', $imageField, $prefix, $uploadDir, $error_message, $valid);
        } else {
            $imageNames[$imageKey] = ''; // Skip if both empty
        }
    }

    if ($valid === 0) {
      echo '<script>alert("'. strip_tags($error_message) .'"); history.back();</script>';
        return;
    }

    // Check for duplicate project date
    $check_sql = "SELECT COUNT(*) as count FROM tbl_project_updation WHERE project_date = '$image_date'";
    $result = mysqli_query($con, $check_sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        echo '<script>alert("Entered Project Date Already exists. Kindly enter a new Date."); location.href="addupdateprojectimages.php?id='.$_GET['id'].'"; </script>';
        exit;
    }

    // Insert into DB
    $sql = "INSERT INTO tbl_project_updation (
        project_date, Image1, Image1caption, Image2, Image2caption,
        Image3, Image3caption, Image4, Image4caption, Image5, Image5caption, p_id
    ) VALUES (
        '$image_date',
        '{$imageNames['Image1']}', '{$captions['Imagefirstcaption']}',
        '{$imageNames['Image2']}', '{$captions['Imagetwocaption']}',
        '{$imageNames['Image3']}', '{$captions['Imagethreecaption']}',
        '{$imageNames['Image4']}', '{$captions['Imagefourcaption']}',
        '{$imageNames['Image5']}', '{$captions['Imagefivecaption']}',
        '$pid'
    )";

    if (mysqli_query($con, $sql)) {
        $last_id = mysqli_insert_id($con);

        log_admin_action(
            $_SESSION['userid'],
            $_SESSION['username'],
            'Property Construction Images Added',
            'Images',
            $last_id,
            '', '', ''
        );

        echo '<script>alert("Project Images Added Successfully"); location.href="updateprojectimages.php?id='.$_GET['id'].'";</script>';
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}





$statement_projects = $pdo->prepare("SELECT number_of_flats,title FROM tbl_projects WHERE p_id=?");
$statement_projects->execute(array($_REQUEST['id']));
$flat_count = $statement_projects->fetchAll(PDO::FETCH_ASSOC);

?>


        <section class="content-header">
            <div class="content-header-left">
                <h1>Add Update Image</h1>
            </div>
            <div class="content-header-right">
                <a href="updateprojectimages.php?id=<?php echo $_GET['id'];  ?>" class="btn btn-primary btn-sm">Back </a>
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

                            <?php if($success_message): ?>
                                <div class="callout callout-success">

                                    <p>
                                        <?php echo $success_message; ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                    <form name="flatsconstructionimage" method="post" enctype="multipart/form-data">
                                        <div class="box box-info">
                                            <!-- <h2 class="pl-3">Basic Information</h2> -->
                                            <div class="row pb-2">

                                               <div class="col-sm-4 pl-3">
    <h2 class="text-small-caps padding-left-new"> <strong><?php echo $flat_count[0]['title']; ?></strong></h2>
                                                </div>  

                                            <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Date of Update<span>*</span></label>
                                                    <input type="date" name="addimage[image_date]" id="image_date" class="form-control" required>
                                                </div>

                                                </div>
                                            <div class="row pb-2">
                                                
                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image1<span>*</span></label>
                                                    <input type="file" required name="addimage[Imagefirst]" id="Imagefirst">
                                                
                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image1 Caption <span>*</span></label>
                                                    <textarea class="form-control" name="addimage[Imagefirstcaption]" id="addimage[Imagefirstcaption]" required></textarea>
                                                </div>
                                              
                                            </div>
                                              <div class="row pb-2">
                                               
                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image2<span></span></label>
                                                    <input type="file"  name="addimage[Imagetwo]" id="Imagetwo">

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image2 Caption <span></span></label>
                                                    <textarea class="form-control" name="addimage[Imagetwocaption]" id="addimage[Imagetwocaption]"></textarea>


                                                </div>
                                            </div>
                                               <div class="row pb-2">
                                               
                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image3<span></span></label>
                                                    <input type="file"  name="addimage[Imagethree]" id="Imagethree">

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image3 Caption <span></span></label>
                                                    <textarea class="form-control" name="addimage[Imagethreecaption]" id="addimage[Imagethreecaption]"></textarea>


                                                </div>
                                            </div>
                                               <div class="row pb-2">
                                               
                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image4<span></span></label>
                                                    <input type="file"  name="addimage[Imagefour]" id="Imagefour">

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image4 Caption <span></span></label>
                                                    <textarea class="form-control" name="addimage[Imagefourcaption]" id="addimage[Imagefourcaption]"></textarea>


                                                </div>
                                            </div>
                                               <div class="row pb-2">
                                               
                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image5<span></span></label>
                                                    <input type="file"  name="addimage[Imagefive]" id="Imagefive">

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image5 Caption <span></span></label>
                                                    <textarea class="form-control" name="addimage[Imagefivecaption]" id="addimage[Imagefivecaption]"></textarea>


                                                </div>
                                            </div>

                                              <div class="row form-actions d-flex flex-row justify-content-center gap-4 mt-4 pb-2">
                                                <div class="col-md-8 text-center">
                                                    <div>
                                                        <input type="submit" name="commit" value="ADD Update" class="btn text-white bg-brick-red rounded mb-5" data-disable-with="Create Property">
                                                        <button type="reset" class="btn text-white bg-brick-red rounded mb-5">Discard</button>

                                                        
                                                        
                                                        </div>
                                                </div>
                                            </div>

                                    </form>


                                    </div>
                </div>

        </section>    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("image_date").value = today;
  });
</script>



<script>
  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split("T")[0];

    // List of date input IDs
    const dateFields = [
      { id: "image_date", label: "Date of Update" }
     
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

        <?php require_once('footer.php'); ?>