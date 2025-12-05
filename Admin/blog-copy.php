<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php
   // Getting photo ID to unlink from folder
	$statement = $pdo->prepare("SELECT * FROM tbl_post WHERE post_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$photo = $row['photo'];
	}


	$total = $statement->rowCount();


	if ($total > 0) {

	 $photo = $photo;
	$title = $result['post_title'] . " (Copy)"; // Add "Copy" to title
	$content =$result['post_content'];
   $post_date = $result['post_date'];
	$post_slug = $result['post_slug'];




// Extract data
$photo = $row['photo'];
$title = $row['post_title'] . " (Copy)";
$content = $row['post_content'];
$post_date = $row['post_date'];
$post_slug = $row['post_slug']; // Optionally regenerate to ensure uniqueness

// Optional: make slug unique if needed
$post_slug .= '-' . time(); // Adds timestamp to slug for uniqueness

// Insert copy
$statement = $pdo->prepare("INSERT INTO tbl_post (post_title, post_slug, post_content, post_date, photo) VALUES (?, ?, ?, ?, ?)");
$statement->execute([$title, $post_slug, $content, $post_date, $photo]);

echo '<script>alert("Blog Copied Successfully."); location.href="blog.php?filter=all";</script>';

	  } else {

	  	   echo '<script>alert("Blog not found."); 
	  	   location.href="blog.php";</script>';
	  }



?>