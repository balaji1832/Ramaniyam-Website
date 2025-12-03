<?php

// ===========================================
// CONFIG
// ===========================================
$imageDir = "Ramaniyam-Home-images/";    // folder for images
$maxFileSize = 5 * 1024 * 1024;          // 5 MB
$allowedExt  = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

// Make sure the directory exists
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
}

// Small helper: check extension
function is_allowed_extension($filename, $allowedExt)
{
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    return in_array($ext, $allowedExt);
}

/* ===========================================
   1) HANDLE EDIT / REPLACE EXISTING IMAGE
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
            // overwrite the existing image with the new uploaded image
            $target = $imageDir . $oldName;
            move_uploaded_file($tmpName, $target);
        }
    }

    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   2) HANDLE NEW UPLOADS
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
                continue; // skip too large
            }
            if (!is_allowed_extension($originalName, $allowedExt)) {
                continue; // skip bad extension
            }

            $originalBase = basename($originalName);
            // add time to filename to avoid duplicates
            $newName = time() . "-" . preg_replace("/\s+/", "-", $originalBase);
            $target  = $imageDir . $newName;

            move_uploaded_file($tmpName, $target);
        }
    }
    // Reload page so new images show
    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   3) HANDLE DELETE
   =========================================== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_file'])) {
    $fileToDelete = $imageDir . basename($_POST['delete_file']);
    if (file_exists($fileToDelete)) {
        unlink($fileToDelete);
    }
    header("Location: admin-images.php");
    exit;
}

/* ===========================================
   4) GET ALL IMAGES TO SHOW IN ADMIN
   =========================================== */
$images = glob($imageDir . "*.{png,jpg,jpeg,JPG,JPEG,PNG}", GLOB_BRACE);
// sort alphabetically so order is stable
sort($images);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Carousel Image Admin</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { margin-bottom: 15px; }
        .upload-box { margin-bottom: 25px; padding: 15px; border: 1px solid #ddd; border-radius: 8px; }
        .img-grid { display: flex; flex-wrap: wrap; gap: 15px; }
        .img-item { width: 150px; text-align: center; }
        .img-item img { width: 150px; height: 150px; object-fit: cover; border-radius: 8px; border: 1px solid #ccc; }
        button { margin-top: 5px; padding: 6px 10px; border: none; border-radius: 4px; cursor: pointer; }
        .btn-delete { background: #d72638; color: #fff; }
        .btn-upload { background: #218838; color: #fff; padding: 8px 14px; }
        .btn-edit   { background: #007bff; color: #fff; }
        /* hide the real file input used for editing */
        .hidden-file-input {
            display: none;
        }
    </style>
</head>
<body>

<h1>Carousel Image Admin</h1>

<!-- UPLOAD FORM -->
<div class="upload-box">
    <h3>Upload New Images</h3>
    <form action="admin-images.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="images[]" multiple required accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG">
        <button type="submit" class="btn-upload">Upload</button>
    </form>
    <p style="font-size: 13px; color:#555;">
        Tip: Upload JPG/PNG images up to 5MB. They will appear automatically in the website carousel.
    </p>
</div>

<!-- IMAGE LIST -->
<h3>Current Images</h3>
<div class="img-grid">
    <?php if (empty($images)): ?>
        <p>No images uploaded yet.</p>
    <?php else: ?>
        <?php foreach ($images as $index => $imgPath):
            $fileName = basename($imgPath);
            $id = 'img' . $index; // unique id for JS
        ?>
            <div class="img-item">
                <img src="<?php echo $imgPath; ?>" alt="<?php echo $fileName; ?>">

                <!-- Delete button -->
                <form action="admin-images.php" method="POST" style="margin-bottom:4px;"
                      onsubmit="return confirm('Delete this image?');">
                    <input type="hidden" name="delete_file" value="<?php echo $fileName; ?>">
                    <button type="submit" class="btn-delete">Delete</button>
                </form>

                <!-- Edit: hidden input + visible Edit button -->
                <form id="edit-form-<?php echo $id; ?>" action="admin-images.php"
                      method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="replace_file" value="<?php echo $fileName; ?>">
                    <input
                        id="edit-input-<?php echo $id; ?>"
                        type="file"
                        name="edit_image"
                        accept=".jpg,.jpeg,.png,.JPG,.JPEG,.PNG"
                        class="hidden-file-input"
                        onchange="submitEditForm('<?php echo $id; ?>')"
                    >
                    <button type="button" class="btn-edit"
                            onclick="triggerEditInput('<?php echo $id; ?>')">
                        Edit
                    </button>
                </form>

                <div style="font-size: 11px; margin-top:4px;"><?php echo $fileName; ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    function triggerEditInput(id) {
        // open file chooser for that specific image
        document.getElementById('edit-input-' + id).click();
    }

    function submitEditForm(id) {
        // after a file is selected, submit the form automatically
        const input = document.getElementById('edit-input-' + id);
        if (input && input.files && input.files.length > 0) {
            document.getElementById('edit-form-' + id).submit();
        }
    }
</script>

</body>
</html>
