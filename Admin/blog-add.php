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
    } else {
    	$valid = 0;
        $error_message .= 'You must have to select a photo<br>';
    }

	if($valid == 1) {

		// getting auto increment id
		$statement = $pdo->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$ai_id=$row[10];
		}


		$final_name = 'postphoto-'.$ai_id.'.'.$ext;
        move_uploaded_file( $path_tmp, '../assets/uploads/'.$final_name );
        $date=date("Y-m-d");

	
		$statement = $pdo->prepare("INSERT INTO tbl_post (post_title,post_slug,post_content,post_date,photo) VALUES (?,?,?,?,?)");

		$statement->execute(array($_POST['title'],$_POST['postedby'],$_POST['content'],$_POST['publishdate'],$final_name));
		
		
		       $add_success = true;
		       
                $new_name = "";
                $old_name = "";
                
                $last_id=$_GET['id'];
                
                
                if ($add_success) {
                    log_admin_action(
                    $_SESSION['userid'],
                    $_SESSION['username'],
                    'Blog Published ',
                    'Blog',
                    $last_id,
                    $old_name,
                    $new_name
                    );   
                }
		

	
		$success_message = 'Blog is added successfully!';

		unset($_POST['title']);
		unset($_POST['content']);
		unset($_POST['postedby']);
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Blog</h1>
	</div>
	<div class="content-header-right">
		<a href="blog.php" class="btn btn-primary btn-sm">View All</a>
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
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Title <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" required="required" autocomplete="off" class="form-control" name="title" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
							</div>
						</div>
						
							<div class="form-group">
							<label for="" class="col-sm-2 control-label">Published Date	 <span>*</span></label>
							<div class="col-sm-6">
								<input type="date" required="required" autocomplete="off" class="form-control" name="publishdate" id="publishdate" value="<?php if(isset($_POST['publishdate'])){echo $_POST['publishdate'];} ?>">
							</div>
						  </div>

							<div class="form-group">
							<label for="" class="col-sm-2 control-label">Posted By <span>*</span></label>
							<div class="col-sm-6">

								<input type="text" required="required" autocomplete="off" class="form-control" name="postedby" value="<?php if(isset($_POST['postedby'])){echo $_POST['postedby'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-6">
								<!-- <textarea class="form-control" name="content" style="height:200px;"></textarea> -->
					<textarea name="content" required="required" class="form-control" cols="30" rows="10" id="editor1"><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Photo <span>*</span></label>
							<div class="col-sm-9" style="padding-top:5px">
								<input type="file" required="required" name="photo">(Only jpg, jpeg, gif and png are allowed)
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

    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById("publishdate").value = today;
  });
</script>
