<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
    
      include("inc/log_helper.php");
	$valid = 1;

	if(empty($_POST['title'])) {
		$valid = 0;
		$error_message .= 'Title can not be empty<br>';
	}

	if(empty($_POST['content'])) {
		$valid = 0;
		$error_message .= 'Content can not be empty<br>';
	}

	
    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if($path!='') {
        $ext = pathinfo( $path, PATHINFO_EXTENSION );
        $file_name = basename( $path, '.' . $ext );
        if( $ext!='jpg' && $ext!='png' && $ext!='jpeg' && $ext!='gif' && $ext!='webp' ) {
            $valid = 0;
            $error_message .= 'You must have to upload jpg, jpeg, gif or png file<br>';
        }
    }

	if($valid == 1) {

		 $date=$_POST['publishdate'];

		if($path == '') {
			$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_content=? , post_date=? , post_slug=?  WHERE post_id=?");
    		$statement->execute(array($_POST['title'],$_POST['content'],$date,$_POST['postedby'],$_REQUEST['id']));
		} else {

			unlink('../assets/uploads/'.$_POST['current_photo']);

			$final_name = 'postphoto-'.$_REQUEST['id'].'.'.$ext;
        	move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );

        	$statement = $pdo->prepare("UPDATE tbl_post SET post_title=?, post_content=?, photo=? WHERE post_id=?");
    		$statement->execute(array($_POST['title'],$_POST['content'],$final_name,$_REQUEST['id']));
		}
		
		$update_success = true;
		       
                $new_name = "";
                $old_name = "";
                
                $last_id=$_GET['id'];
                
                
                if ($update_success) {
                    log_admin_action(
                    $_SESSION['userid'],
                    $_SESSION['username'],
                    'Blog Updated ',
                    'Blog',
                    $last_id,
                    $old_name,
                    $new_name
                    );   
                }

	    $success_message = 'Blog is updated successfully!';
	}
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
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
		<h1>Edit Blog</h1>
	</div>
	<div class="content-header-right">
		<a href="blog.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
	$title = $row['post_title'];
	$content = $row['post_content'];
	$photo = $row['photo'];
	$post_date = $row['post_date'];
	$post_slug = $row['post_slug'];
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
							<label for="" class="col-sm-2 control-label">Title <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="title" value="<?php echo $title; ?>">
							</div>
						</div>
						
							<div class="form-group">
							<label for="" class="col-sm-2 control-label">Published Date	 <span>*</span></label>
							<div class="col-sm-6">
								<input type="date" required="required" autocomplete="off" class="form-control" name="publishdate" id="publishdate" value="<?php echo $post_date; ?>">
							</div>
						  </div>

						
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-6">
								<textarea class="form-control" name="content" id="editor1" style="height:140px;"><?php echo $content; ?></textarea>


							</div>
						</div>	

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Posted By <span>*</span></label>
							<div class="col-sm-6">
						<input type="text" autocomplete="off" class="form-control" name="postedby" value="<?php echo $post_slug; ?>">			
							
							</div>
						</div>	

						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Existing Photo</label>
							<div class="col-sm-9" style="padding-top:5px">
								<img src="../assets/uploads/<?php echo $photo; ?>" alt="Service Photo" style="width:180px;">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo </label>
							<div class="col-sm-6" style="padding-top:5px">
								<input type="file" name="photo">(Only jpg, jpeg, gif and png are allowed)
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