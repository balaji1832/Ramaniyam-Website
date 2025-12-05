<?php require_once('header.php'); ?>

<style type="text/css">
    
.pl-2 {

    padding-left: 20px;
}

</style>

    <?php


error_reporting(0);
if (isset($_GET['delete_id'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_project_updation WHERE id=?");
    $statement->execute([$_REQUEST['delete_id']]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['layout'] != '') {
        unlink('../assets/uploads/project-images/' . $result['layout']);
    }
    $statement = $pdo->prepare("DELETE FROM tbl_project_updation WHERE id=?");
    $statement->execute([$_REQUEST['delete_id']]);
}



if (isset($_POST["commit"])) {
    error_reporting(1);

    require_once "form/db.php";
    include("inc/log_helper.php");

    $valid = 1;
    $error_message = '';
    $pid = $_GET['id'];
    $editid = $_GET['editid'];
    $uploadDir = '../assets/uploads/project-images/';
    $imageCaptions = $_POST['addimage'];
    $image_date = $_POST['addimage']['image_date'];

    // Sanitize captions
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

    // Get current images
    $existing_sql = "SELECT * FROM tbl_project_updation WHERE project_date = '$image_date' AND p_id = '$pid' LIMIT 1";
    $existing_result = mysqli_query($con, $existing_sql);
    $existing = mysqli_fetch_assoc($existing_result);

    if (!$existing) {
        echo '<script>alert("No matching project update found to update."); location.href="addupdateprojectimages.php";</script>';
        exit;
    }

    // Map image keys
    $imageKeys = [
        'Image1' => ['file' => 'Imagefirst',  'caption' => 'Imagefirstcaption'],
        'Image2' => ['file' => 'Imagetwo',    'caption' => 'Imagetwocaption'],
        'Image3' => ['file' => 'Imagethree',  'caption' => 'Imagethreecaption'],
        'Image4' => ['file' => 'Imagefour',   'caption' => 'Imagefourcaption'],
        'Image5' => ['file' => 'Imagefive',   'caption' => 'Imagefivecaption']
    ];

    $imageNames = [];

    foreach ($imageKeys as $dbKey => $info) {
        $fileInput = $_FILES['addimage']['name'][$info['file']] ?? '';
        $caption = trim($captions[$info['caption']]);
        $hasExistingImage = !empty($existing[$dbKey]);

        if (!empty($fileInput)) {
            if (empty($caption)) {
                $valid = 0;
                $error_message .= "$dbKey caption is required when uploading image.<br>";
            } else {
                $uploaded = handleImageUpload('addimage', $info['file'], 'Upd-construct-' . strtolower($dbKey), $uploadDir, $error_message, $valid);
                $imageNames[$dbKey] = $uploaded ?: $existing[$dbKey];
            }
        } elseif (!empty($caption)) {
            if (!$hasExistingImage) {
                $valid = 0;
                $error_message .= "$dbKey image is required when caption is entered.<br>";
            } else {
                $imageNames[$dbKey] = $existing[$dbKey];
            }
        } else {
            $imageNames[$dbKey] = $existing[$dbKey];
        }
    }

    if ($valid === 0) {
        echo '<script>alert("'. strip_tags($error_message) .'"); history.back();</script>';
        return;
    }

    // Update query
    $sql = "UPDATE tbl_project_updation SET 
        Image1 = '{$imageNames['Image1']}', Image1caption = '{$captions['Imagefirstcaption']}',
        Image2 = '{$imageNames['Image2']}', Image2caption = '{$captions['Imagetwocaption']}',
        Image3 = '{$imageNames['Image3']}', Image3caption = '{$captions['Imagethreecaption']}',
        Image4 = '{$imageNames['Image4']}', Image4caption = '{$captions['Imagefourcaption']}',
        Image5 = '{$imageNames['Image5']}', Image5caption = '{$captions['Imagefivecaption']}'
        WHERE project_date = '$image_date' AND id = '$editid'";

   if (mysqli_query($con, $sql)) {
    log_admin_action(
        $_SESSION['userid'],
        $_SESSION['username'],
        'Property Construction Images Updated',
        'Images',
        $existing['id'],
        '', '' // Optional: old/new values
    );

    echo '<script>alert("Project Images Updated Successfully"); location.href="updateprojectimages.php?id='.$_GET['id'].'";</script>';
    exit;
} else {
    echo "Error updating record: " . mysqli_error($con);
}
}





  



if(!isset($_REQUEST['id'])) {
    header('location: logout.php');
    exit;
} else {
    // Check the id is valid or not
    $statement = $pdo->prepare("SELECT * FROM tbl_project_updation WHERE id=?");
    $statement->execute(array($_REQUEST['editid']));
    $total = $statement->rowCount();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

  
    $photos = explode(",", $result[0]["photos"]);

    if( $total == 0 ) {
        header('location: logout.php');
        exit;
    }
}

$statement_projects = $pdo->prepare("SELECT number_of_flats,title FROM tbl_projects WHERE p_id=?");
$statement_projects->execute(array($_REQUEST['id']));
$flat_count = $statement_projects->fetchAll(PDO::FETCH_ASSOC);

?>

        <section class="content-header">
            <div class="content-header-left">
                <h1>Update Image</h1>
            </div>
            <!--<div class="content-header-right">-->
            <!--    <a href="updateprojectimages.php?id=<?php echo $_GET['id'] ?>" class="btn btn-danger">Back </a>-->
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

                            <?php if($success_message): ?>
                                <div class="callout callout-success">
                                    <p>
                                        <?php echo $success_message; ?>
                                    </p>
                                </div>
                                <?php endif; ?>

                                    <form name="updateForm" method="post" enctype="multipart/form-data">
                                        <input type="hidden" id="table_id" name="table_id" value="<?php echo  $result[0]['id']; ?>">
                                        <input type="hidden" id="projectid" name="projectid" value="<?php echo  $_GET['id']; ?>">
                                        <input type="hidden" id="userid" name="userid" value="<?php echo  $_SESSION['userid']; ?>">


                                        <div class="box box-info">
                                         <h2 class="pl-2">Basic Information</h2>
                                         <hr>
                                            <div class="row pb-2">

                                                 <div class="col-sm-4 pl-3">
    <h2 class="text-small-caps padding-left-new"> <strong><?php echo $flat_count[0]['title']; ?></strong></h2>
                                                </div>  

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Date of Update<span>*</span></label>
                                                    <input type="date" name="addimage[image_date]" id="image_date" class="form-control" value="<?php echo $result[0]['project_date'];  ?>" >
                                                </div>

                                                 <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Last Update<span>*</span>&nbsp;</label>
                                                   <p><?php echo $result[0]['updateddate'];  ?></p>
                                                </div>

                                            </div>

                                      <hr>
                               <h2 class="pl-2">Update Information</h2>
                                         <hr>

                                            <div class="row pb-2">

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image1<span>*</span></label>
                                                    <input type="file"  name="addimage[Imagefirst]" id="Imagefirst">
                                                
                                                Uploaded Filename: <?php echo $result[0]['Image1'];  ?>   

                                                </div>





                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image1 Caption <span>*</span></label><br>
                                                   

            <textarea name="addimage[Imagefirstcaption]" style="height: 100px; width: 100%; resize: none;"> <?php echo $post_msg = htmlentities(trim(strip_tags(@$result[0]['Image1caption']))); ?>
            </textarea>                                 </div>
                                            </div>
                                            <div class="row pb-2">

                                                <div class="col-sm-4 pl-3">

                                                    <label for="" class="control-label">Image2<span></span></label>

                                                    <input type="file" name="addimage[Imagetwo]" id="Imagetwo">
                                              
                                              <?php if($result[0]['Image2'] !="") { ?>
                                                Uploaded Filename: <?php echo $result[0]['Image2'];  ?> 

                                                <?php }?>  

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image2 Caption <span></span></label>
                                                    
<textarea name="addimage[Imagetwocaption]" id="addimage[Imagetwocaption]" style="height: 100px; width: 100%; resize: none;"> <?php echo $post_msg = htmlentities(trim(strip_tags(@$result[0]['Image2caption']))); ?>
            </textarea> 

                                                </div>
                                            </div>
                                            <div class="row pb-2">

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image3<span></span></label>
                                                    <input type="file" name="addimage[Imagethree]" id="Imagethree">
                                                   
                                              <?php if($result[0]['Image3'] !="") { ?>
                                                Uploaded Filename: <?php echo $result[0]['Image3'];  ?> 

                                                <?php }?>  

                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image3 Caption <span></span></label>
                               
                    <textarea name="addimage[Imagethreecaption]" id="addimage[Imagethreecaption]" style="height: 100px; width: 100%; resize: none;"> <?php echo $post_msg = htmlentities(trim(strip_tags(@$result[0]['Image3caption']))); ?></textarea>
            


                                                </div>
                                            </div>
                                            <div class="row pb-2">

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image4<span></span></label>
                                                    <input type="file" name="addimage[Imagefour]" id="Imagefour">
                                                <?php if($result[0]['Image4'] !="") { ?>
                                                Uploaded Filename: <?php echo $result[0]['Image4'];  ?> 

                                                <?php }?>  
                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image4 Caption <span></span></label>
                                                   
                             <textarea name="addimage[Imagefourcaption]" id="addimage[Imagefourcaption]" style="height: 100px; width: 100%; resize: none;"> <?php echo $post_msg = htmlentities(trim(strip_tags(@$result[0]['Image4caption']))); ?></textarea>
            

                                                </div>
                                            </div>
                                            <div class="row pb-2">

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image5<span></span></label>
                                                    <input type="file" name="addimage[Imagefive]" id="Imagefive">
                                                <?php if($result[0]['Image5'] !="") { ?>
                                                Uploaded Filename: <?php echo $result[0]['Image5'];  ?> 

                                                <?php }?>  
                                                </div>

                                                <div class="col-sm-4 pl-3">
                                                    <label for="" class="control-label">Image5 Caption <span></span></label>
                                                 
<textarea name="addimage[Imagefivecaption]" id="addimage[Imagefivecaption]" style="height: 100px; width: 100%; resize: none;"> <?php echo $post_msg = htmlentities(trim(strip_tags(@$result[0]['Image5caption']))); ?></textarea>

                                                </div>
                                            </div>

                                            <div class="row form-actions d-flex flex-row justify-content-center gap-4 mt-4 pb-2">
                                                <div class="col-md-8 text-center">
                                                    <div>
                                                        <input type="submit" name="commit" value="Update Changes" class="btn text-white bg-brick-red rounded mb-5" data-disable-with="Update">
                                                       

                                            <a href="updateprojectimages.php?id=<?php echo $_GET['id'] ?>" class="btn text-white bg-brick-red rounded mb-5">Discard Changes </a>

                                                    </div>
                                                </div>
                                            </div>

                                    </form>


                                    </div>
                </div>




                <!--<div id="editModal" class="modal fade" role="dialog">-->
                <!--    <div class="modal-dialog">-->
                <!--        <div class="modal-content">-->
                <!--            <div class="modal-header">-->
                <!--                <button type="button" class="close" data-dismiss="modal">&times;</button>-->
                <!--                <h4 class="modal-title">Edit project Images</h4>-->
                <!--            </div>-->
                <!--            <div class="modal-body">-->

                <!--            </div>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->

                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


                <script>
                    $(document).ready(function() {
                        $('.edit-btn').click(function() {
                            var user_id = $(this).data('id');
                            $.ajax({
                                url: "fetch_new",
                                type: "POST",
                                data: { id: user_id },
                                dataType: "json",
                                success: function(data) {
                                    $('#table_id').val(data.id);
                                    $('input[name="image_date_new"]').val(data.project_date);
                                    $('#desc').val(data.updated);
                    
                                    
                    
                                }
                            });
                        });
                    
                        $('#updateForm').submit(function(e) {
                            e.preventDefault();
                            $.ajax({
                                url: "update_project_images",
                                type: "POST",
                                data: new FormData(this),
                                contentType: false,
                                processData: false,
                                success: function(response) {
                                    alert(response);
                                    $('#editModal').modal('hide');
                                    location.reload();
                                }
                            });
                        });
                    });
                </script>




                <?php require_once('footer.php'); ?>