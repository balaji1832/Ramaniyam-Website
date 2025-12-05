<?php require_once('header.php'); ?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM enquiry_new WHERE id=?");
	$statement->execute(array($_REQUEST['id']));
	$total = $statement->rowCount();
	if( $total == 0 ) {
		header('location: logout.php');
		exit;
	}
}
?>

<?php

  $action = $_GET['action'] === 'archive' ? 1 : 0;
	// Delete from tbl_customer
// 	$statement = $pdo->prepare("DELETE FROM enquiry_new WHERE id=?");
// 	$statement->execute(array($_REQUEST['id']));
	
    $statement = $pdo->prepare("UPDATE enquiry_new SET is_archived=? WHERE id=?");
    $statement->execute(array($action,$_REQUEST['id']));
    
	header('location: customer.php?filter='.$action.'');
?>