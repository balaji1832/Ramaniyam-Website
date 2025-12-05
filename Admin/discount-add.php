<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

    if(empty($_POST['code'])) {
        $valid = 0;
        $error_message .= "Discount Code can not be empty<br>";
    } else {
    	// Duplicate Category checking
    	$statement = $pdo->prepare("SELECT * FROM discount_codes WHERE code=?");
    	$statement->execute(array($_POST['code']));
    	$total = $statement->rowCount();
    	if($total)
    	{
    		$valid = 0;
        	$error_message .= "Discount  already exists <br>";
    	}
    }

    if($valid == 1) {

    	$date=date_create($_POST['valid_from_date']);
        $datefrom=date_format($date,"Y-m-d H:i:s");

        $date_to=date_create($_POST['valid_to_date']);
        $dateto=date_format($date_to,"Y-m-d H:i:s");

		// Saving data into the main table tbl_country
		$statement = $pdo->prepare("INSERT INTO discount_codes (type,amount,code,valid_from_date,valid_to_date) 
			VALUES (?,?,?,?,?)");
		$statement->execute(array($_POST['type'],$_POST['amount'],$_POST['code'],$datefrom,$dateto));
	
    	$success_message = 'Discount  is added successfully.';
    }
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add Discount Filter </h1>
	</div>
	<div class="content-header-right">
		<a href="country.php" class="btn btn-primary btn-sm">View All</a>
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

			<form class="form-horizontal" action="" method="post">

				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Disc Name <span>*</span></label>
							<div class="col-sm-4">
							<select class="selectpicker form-control show-tick show-menu-arrow" name="type">
							<option selected="" value="percent">%</option>
						<!-- 	<option  value="float">Float</option>  -->
							</select>
						</div>
						</div>
						<div class="form-group">
					    <label for="" class="col-sm-2 control-label">Discount Amount  <span>*</span></label>
						<div class="col-sm-4">

						 <input class="form-control" name="amount" value="" type="text">

						</div>

						</div>
						<div class="form-group">
							 <label for="" class="col-sm-2 control-label">Discount   <span>*</span></label>
					<div class="col-sm-4">
							<input class="form-control" name="code" value="" type="text">
							<div style="position: absolute; right:15px; top:10px;">
                            <input type="text" data-toggle="tooltip" title="" data-placement="top" class="codeLength" value="6" style="border: 1px solid #dadada;float: left;height: 20px; margin-right: 4px; text-align: center; margin-top: 1px; width: 20px;" data-original-title="Set length of code">
                            <a href="javascript:void(0);" onclick="generateDiscountCode()" class="btn btn-xs btn-default">Generate</a>
                        </div>

						</div>
						</div>
						<div class="form-group">
						<label for="" class="col-sm-2 control-label">Date Valid  From  <span>*</span></label>
						<div class="col-sm-4">
						<input class="form-control datepicker" name="valid_from_date" value="" type="date">
						</div>
						</div>
						<div class="form-group">
						<label for="" class="col-sm-2 control-label">Date Valid  To  <span>*</span></label>
						<div class="col-sm-4">
						<input class="form-control datepicker" name="valid_to_date" value="" type="date">
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

<script >
	
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