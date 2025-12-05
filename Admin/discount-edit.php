<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['code'])) {
        $valid = 0;
        $error_message .= "Dicount Code can not be empty<br>";
    } else {
		// Duplicate Country checking
    	// current Country name that is in the database
    	$statement = $pdo->prepare("SELECT * FROM discount_codes WHERE id=?");
		$statement->execute(array($_REQUEST['id']));
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($result as $row) {
			$code = $row['code'];
		}

		$statement = $pdo->prepare("SELECT * FROM discount_codes WHERE code=? and code!=?");
    	$statement->execute(array($_POST['code'],$code));
    	$total = $statement->rowCount();							
    	if($total) {
    		$valid = 0;
        	$error_message .= 'Discount Code already exists <br>';
    	}
    }

    if($valid == 1) { 

        $date=date_create($_POST['valid_from_date']);
        $datefrom=date_format($date,"Y-m-d H:i:s");

        $date_to=date_create($_POST['valid_to_date']);
        $dateto=date_format($date_to,"Y-m-d H:i:s");   	
		// updating into the database
		$statement = $pdo->prepare("UPDATE discount_codes SET code=?,amount=?,valid_from_date=?,valid_to_date=?
         WHERE id=?");
		$statement->execute(array($_POST['code'],$_POST['amount'],$datefrom,$dateto,$_REQUEST['id']));

    	$success_message = 'Dicount is updated successfully.';
    }
}
?>

<?php
if(!isset($_REQUEST['id'])) {
	header('location: logout.php');
	exit;
} else {
	// Check the id is valid or not
	$statement = $pdo->prepare("SELECT * FROM discount_codes WHERE id=?");
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
		<h1>Edit Discount</h1>
	</div>
	<div class="content-header-right">
		<a href="discount.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<?php							
foreach ($result as $row) {
	$type = $row['type'];$code = $row['code'];
    $amount = $row['amount'];$valid_from_date = $row['valid_from_date'];
    $valid_to_date = $row['valid_to_date']; 
}
?>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css" >
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" >

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

        <form class="form-horizontal" action="" method="post">

        <div class="box box-info">

            <div class="box-body">
               <div class="form-group">
                            <label for="" class="col-sm-2 control-label">Discount Name <span>*</span></label>
                            <div class="col-sm-4">
                            <select class="selectpicker form-control show-tick show-menu-arrow" name="type">
                                <option value="percent" <?php if($type == 'percent') {echo 'selected';} ?>>%</option>
                                
                            </select>
                        </div>
                        </div>
                        <div class="form-group">
                        <label for="" class="col-sm-2 control-label">Discount Amount  <span>*</span></label>
                        <div class="col-sm-4">

                         <input class="form-control" name="amount" value="<?php echo $amount; ?>" type="text">

                        </div>

                        </div>
                       <div class="form-group" style="position: relative;">
                 <label for="" class="col-sm-2 control-label">Discount code  <span>*</span></label>
                                         <div class="col-sm-4">

                        <input class="form-control" name="code" value="<?php echo $code; ?>" type="text">
                        <div style="position: absolute; right:5px; top:10px;">
                            <input type="text" data-toggle="tooltip" title="" data-placement="top" class="codeLength" value="6" style="border: 1px solid #dadada;float: left;height: 20px; margin-right: 4px; text-align: center; margin-top: 1px; width: 20px;" data-original-title="Set length of code">
                            <a href="javascript:void(0);" onclick="generateDiscountCode()" class="btn btn-xs btn-default">Generate</a>
                        </div></div>
                    </div>
                    <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Date Valid  From  <span>*</span></label>
                    <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker">
                    <input type="text" name="valid_from_date" value="<?php echo $valid_from_date ?>" class="form-control">
                    <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                    </div>
                    </div>                   
                    </div>
                    </div>
                      <div class="form-group">
                    <label for="" class="col-sm-2 control-label">Date Valid  To  <span>*</span></label>
                    <div class="col-sm-4">
                    <div class="input-group date" data-provide="datepicker">
                    <input type="text" name="valid_to_date" value="<?php echo $valid_to_date ?>" class="form-control">
                    <div class="input-group-addon">
                    <span class="glyphicon glyphicon-th"></span>
                    </div>
                    </div>                   
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

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
            </div>
            <div class="modal-body">
                Are you sure want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


    
 

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.en-GB.min.js" charset="UTF-8"></script>

<script>
$( document ).ready(function() {
  $('#datepicker').datepicker();
});

function generateDiscountCode() {
    var length = $('.codeLength').val();
    if (length < 3 || length == '') {
        alert('Too short discount code!');
    } else {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < length; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        $('[name="code"]').val(text.toUpperCase());
    }
}   

</script>

<?php require_once('footer.php'); ?>



