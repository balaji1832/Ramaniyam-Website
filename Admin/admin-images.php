<?php
// 1) Load common header (does login check and opens layout)
include("header.php");

// ===========================================
// 2) CONFIG
// ===========================================

// For filesystem operations (upload/delete/replace)
$fsDir = __DIR__ . '/../Ramaniyam-Home-images/';

// For browser URLs (<img src="...">) – relative to /Admin/
$urlDir = '../Ramaniyam-Home-images/';

$maxFileSize = 5 * 1024 * 1024;            // 5 MB
$allowedExt  = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

// Make sure the directory exists
if (!is_dir($fsDir)) {
    mkdir($fsDir, 0755, true);
}

// Helper: check extension
function is_allowed_extension($filename, $allowedExt)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array($ext, $allowedExt);
}

/* ===========================================
   3) HANDLE EDIT / REPLACE EXISTING IMAGE
   =========================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_POST['replace_file'])
    && isset($_FILES['edit_image'])) {

    $oldName = basename($_POST['replace_file']); // existing file name
    $tmpName = $_FILES['edit_image']['tmp_name'];
    $size    = $_FILES['edit_image']['size'];
    $name    = $_FILES['edit_image']['name'];

    if (!empty($tmpName) && is_uploaded_file($tmpName)) {
        if ($size <= $maxFileSize && is_allowed_extension($name, $allowedExt)) {
            // overwrite existing file
            $target = $fsDir . $oldName;
            move_uploaded_file($tmpName, $target);
        }
    }

    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   4) HANDLE NEW UPLOADS
   =========================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && isset($_FILES['images'])
    && isset($_FILES['images']['tmp_name'])) {

    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
        if (!empty($tmpName) && is_uploaded_file($tmpName)) {

            $originalName = $_FILES['images']['name'][$key];
            $size         = $_FILES['images']['size'][$key];

            // validate
            if ($size > $maxFileSize) {
                continue; // too large
            }
            if (!is_allowed_extension($originalName, $allowedExt)) {
                continue; // not jpg/png
            }

            $originalBase = basename($originalName);
            $newName = time() . "-" . preg_replace("/\s+/", "-", $originalBase);
            $target  = $fsDir . $newName;

            move_uploaded_file($tmpName, $target);
        }
    }

    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   5) HANDLE DELETE
   =========================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $fileToDelete = $fsDir . basename($_POST['delete_file']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
    }
    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   6) GET ALL IMAGES TO SHOW IN ADMIN
   =========================================== */
$images = glob($fsDir . "*.{png,jpg,jpeg,JPG,JPEG,PNG}", GLOB_BRACE);
sort($images); // stable order
?>

<style>
    .banner-grid .banner-card {
        background: #ffffff;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .banner-grid .banner-card img {
        width: 70%;
        height: 350px;            /* taller image */
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .banner-grid .btn {
        margin-top: 3px;
    }

    .banner-grid small {
        display: block;
        margin-top: 4px;
        font-size: 11px;
        color: #555;
        word-break: break-all;
    }

    @media (min-width: 768px) and (max-width:1000px) {
        .banner-grid .banner-card img {
            height: 270px;
            width: 85%;
        }
    }
    @media (min-width: 1001px) {
        
        .banner-grid .banner-card img {
        width: 92%;
        height: 330px;            /* taller image */
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    }
     @media (min-width: 1440px) {
        
        .banner-grid .banner-card img {
        width: 92%;
        height: 390px;            /* taller image */
        object-fit: cover;
        border-radius: 4px;
        margin-bottom: 8px;
    }
    }
</style>

<!-- 7) PAGE CONTENT INSIDE EXISTING content-wrapper FROM header.php -->

<section class="content-header">
    <h1>Home-page Banner Images</h1>
</section>

<section class="content">

    <!-- Upload box -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Upload New Images</h3>
        </div>
        <div class="box-body">
            <form action="admin-images.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Select Images</label>
                    <input type="file"
                           name="images[]"
                           multiple
                           required
                           accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG"
                           class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Upload</button>
                <p class="help-block">
                    JPG/PNG only, max 5MB each. These images will be used in the homepage banner/carousel.
                </p>
            </form>
        </div>
    </div>

    <!-- Image list -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Current Images</h3>
        </div>
        <div class="box-body">

            <?php if (empty($images)): ?>
                <p>No images uploaded yet.</p>
            <?php else: ?>
                <div class="row banner-grid">
                    <?php foreach ($images as $index => $imgPath):
                        $fileName = basename($imgPath);
                        $id = 'img' . $index;
                        $version = filemtime($fsDir . $fileName); // cache-buster
                    ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="banner-card text-center">
                                <img src="<?php echo $urlDir . $fileName . '?v=' . $version; ?>"
                                     alt="<?php echo $fileName; ?>">

                                <!-- Delete -->
                                <form action="admin-images.php"
                                      method="POST"
                                      onsubmit="return confirm('Delete this image?');">
                                    <input type="hidden" name="delete_file" value="<?php echo $fileName; ?>">
                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                </form>

                                <!-- Edit -->
                                <form id="edit-form-<?php echo $id; ?>"
                                      action="admin-images.php"
                                      method="POST"
                                      enctype="multipart/form-data">
                                    <input type="hidden" name="replace_file" value="<?php echo $fileName; ?>">
                                    <input id="edit-input-<?php echo $id; ?>"
                                           type="file"
                                           name="edit_image"
                                           accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG"
                                           style="display:none"
                                           onchange="submitEditForm('<?php echo $id; ?>')">
                                    <button type="button"
                                            class="btn btn-primary btn-xs"
                                            onclick="triggerEditInput('<?php echo $id; ?>')">
                                        Edit
                                    </button>
                                </form>

                                <small><?php echo $fileName; ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>

</section>

<script>
    function triggerEditInput(id) {
        document.getElementById('edit-input-' + id).click();
    }

    function submitEditForm(id) {
        const input = document.getElementById('edit-input-' + id);
        if (input && input.files && input.files.length > 0) {
            document.getElementById('edit-form-' + id).submit();
        }
    }
</script>

<?php include("footer.php"); ?>
