<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	
    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

	if($valid == 1) {

		if($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_brand_category SET  cat_id=?,  button_url=?, p_is_active=? WHERE id=?");
    		$statement->execute(array($_POST['cat_id'],$_POST['button_url'],$_POST['p_is_active'],$_REQUEST['id']));
		} else {

			unlink('../assets/uploads/home/'.$_POST['current_photo']);
			
			$time=time();

			$final_name = 'homecategoryfilter-'.$time.'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/home/'.$final_name );

        	$statement = $pdo->prepare("UPDATE tbl_brand_category SET photo=?, cat_id=?, button_url=?, p_is_active=? WHERE id=?");
    		$statement->execute(array($final_name,$_POST['cat_id'],$_POST['button_url'],$_POST['p_is_active'],$_REQUEST['id']));
		}	   

	    $success_message = 'Details is updated successfully!';
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_brand_category WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Edit Home Category Filter </h1>
	</div>
	<div class="content-header-right">
		<a href="homecategorylist.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_brand_category WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {



	$photo       = $row['photo'];
	$button_url  = $row['button_url'];
	$active    = $row['p_is_active'];
	 $cat_id    = $row['cat_id'];
}
?>

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
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<input type="hidden" name="current_photo" value="<?php echo $photo; ?>">
				<div class="box box-info">
					<div class="box-body">
					    	<div class="form-group">
							<label for="" class="col-sm-2 control-label"> Our Category <span>*</span></label>
							<div class="col-sm-6" style="padding-top:5px">

                             <select name="cat_id" class="form-control select2">
									<option value="">Select Category </option>
									<?php
									$statement = $pdo->prepare("SELECT * FROM tbl_brand ORDER BY brand_name ASC");
									$statement->execute();
									$result = $statement->fetchAll(PDO::FETCH_ASSOC);	
									foreach ($result as $row) {
										?>
										<option value="<?php echo $row['brand_name']; ?>" <?php if($cat_id==$row['brand_name']) { echo 'selected=selected'; } ?>  ><?php echo $row['brand_name']; ?></option>
										<?php
									}
									?>
								</select>
                            </div>
							</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Photo</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="../assets/uploads/home/<?php echo $photo; ?>" alt="Slider Photo" style="width:400px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
							</div>
						</div>
					<!-- 	<div class="form-group">
							<label for="" class="col-sm-2 control-label">Heading </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="heading" value="<?php echo $heading; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content </label>
							<div class="col-sm-6">
								<textarea class="form-control" name="content" style="height:140px;"><?php echo $content; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Button Text </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="button_text" value="<?php echo $button_text; ?>">
							</div>
						</div> -->
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Button URL </label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="button_url" value="<?php echo $button_url; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Status </label>
							<div class="col-sm-6">
								<select name="p_is_active" class="form-control">
									<option value="1" <?php if($active == 1) {echo 'selected';} ?>>Active</option>
									<option value="0" <?php if($active == 0) {echo 'selected';} ?>>InActive</option>
									
								</select>
							</div>
						</div>				
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>