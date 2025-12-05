<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM tbl_projects WHERE p_id=?");
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
	$statement = $pdo->prepare("SELECT * FROM tbl_projects WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));
	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
	foreach ($result as $row) {
		$p_featured_photo = $row['card_image'];
		
		$card_image = $row['header_image'];
		
		unlink('../assets/uploads/project-images/'.$p_featured_photo);
		unlink('../assets/uploads/project-images/'.$card_image);
	}

	




	// Delete from tbl_order
	$statement = $pdo->prepare("DELETE FROM tbl_projects WHERE p_id=?");
	$statement->execute(array($_REQUEST['id']));

	header('location: projects.php');
?>