<?php require_once('header.php'); ?>

<?php
$error_message = '';
if(isset($_POST['form1'])) {
    $valid = 1;
    if(empty($_POST['subject_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if(empty($_POST['message_text'])) {
        $valid = 0;
        $error_message .= 'Subject can not be empty\n';
    }
    if($valid == 1) {

        $subject_text = strip_tags($_POST['subject_text']);
        $message_text = strip_tags($_POST['message_text']);

        // Getting Customer Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
        $statement->execute(array($_POST['cust_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $cust_email = $row['cust_email'];
        }

        // Getting Admin Email Address
        $statement = $pdo->prepare("SELECT * FROM tbl_settings WHERE id=1");
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $admin_email = $row['contact_email'];
        }

        $order_detail = '';
        $statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
        	
        	if($row['payment_method'] == 'PayPal'):
        		$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
        		';
        	elseif($row['payment_method'] == 'Stripe'):
				$payment_details = '
Transaction Id: '.$row['txnid'].'<br>
Card number: '.$row['card_number'].'<br>
Card CVV: '.$row['card_cvv'].'<br>
Card Month: '.$row['card_month'].'<br>
Card Year: '.$row['card_year'].'<br>
        		';
        	elseif($row['payment_method'] == 'Bank Deposit'):
				$payment_details = '
Transaction Details: <br>'.$row['bank_transaction_info'];
        	endif;

            $order_detail .= '
Customer Name: '.$row['customer_name'].'<br>
Customer Email: '.$row['customer_email'].'<br>
Payment Method: '.$row['payment_method'].'<br>
Payment Date: '.$row['payment_date'].'<br>
Payment Details: <br>'.$payment_details.'<br>
Paid Amount: '.$row['paid_amount'].'<br>
Payment Status: '.$row['payment_status'].'<br>
Shipping Status: '.$row['shipping_status'].'<br>
Payment Id: '.$row['payment_id'].'<br>
            ';
        }

        $i=0;
        $statement = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
        $statement->execute(array($_POST['payment_id']));
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);                            
        foreach ($result as $row) {
            $i++;
            $order_detail .= '
<br><b><u>Product Item '.$i.'</u></b><br>
Product Name: '.$row['product_name'].'<br>
Size: '.$row['size'].'<br>
Color: '.$row['color'].'<br>
Quantity: '.$row['quantity'].'<br>
Unit Price: '.$row['unit_price'].'<br>
            ';
        }

        $statement = $pdo->prepare("INSERT INTO tbl_customer_message (subject,message,order_detail,cust_id) VALUES (?,?,?,?)");
        $statement->execute(array($subject_text,$message_text,$order_detail,$_POST['cust_id']));

        // sending email
        $to_customer = $cust_email;
        $message = '
<html><body>
<h3>Message: </h3>
'.$message_text.'
<h3>Order Details: </h3>
'.$order_detail.'
</body></html>
';
        $headers = 'From: ' . $admin_email . "\r\n" .
                   'Reply-To: ' . $admin_email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion() . "\r\n" . 
                   "MIME-Version: 1.0\r\n" . 
                   "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Sending email to admin                  
        mail($to_customer, $subject_text, $message, $headers);
        
        $success_message = 'Your email to customer is sent successfully.';

    }
}
?>
<?php
if($error_message != '') {
    echo "<script>alert('".$error_message."')</script>";
}
if($success_message != '') {
    echo "<script>alert('".$success_message."')</script>";
}
?>

<style type="text/css">


 .red {
     
    background: #f9cccc;
    border-radius: 50%;
    height: 26px;
    width: 26px;
    line-height: 26px;
    display: inline-block;
    text-align: center;
    margin-right: 6px;
 }
  
   .yellow {
     
    background: #FFFF00;
    border-radius: 50%;
    height: 26px;
    width: 26px;
    line-height: 26px;
    display: inline-block;
    text-align: center;
    margin-right: 6px;
 }
 
  .green {
     
    background: #d3f9b4;
    border-radius: 50%;
    height: 26px;
    width: 26px;
    line-height: 26px;
    display: inline-block;
    text-align: center;
    margin-right: 6px;
 }
    
</style>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Orders</h1>
	</div>
</section>


<section class="content">

  <div class="row">
    <div class="col-md-12">
        


      <div class="box box-info">
          
                  <div class="row">
                      
                      <div class="col-md-4">  Stage1 :  <span class="red">&nbsp;</span> payment:   Pending   ,  shipping : pending </div>
                      
                      
                       
                        <div class="col-md-4"> Stage2 :  <span class="yellow">&nbsp;</span>  </a>  payment:   Completed  ,  shipping : pending </div>
                        
                         <div class="col-md-4">  Stage3 : <span class="green">&nbsp;</span>   payment:   Completed  ,  shipping : Completed  </div>
                     
                      
                      </div>
                      
                     

        
        <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped">
			<thead>
			    <tr>
			        <th>Invoice No</th>
                     <th>Customer Name </th>
			        <!-- <th>Product Details</th> -->
                  <!--   <th>
                    	Payment Information
                    </th> -->
                    <th>Paid Amount</th>
                    <th>Payment Status</th>
                   
                    <th>Shipping Status</th>

                     <th> order date </th>
                        <!-- <th>Shipping Address </th> -->
			        <th>Action</th>
			    </tr>
			</thead>
            <tbody>
            	<?php
            	$i=0;
            	$statement = $pdo->prepare("SELECT * FROM tbl_payment  order by id desc  ");
            	$statement->execute();
            	$result = $statement->fetchAll(PDO::FETCH_ASSOC);							
            	foreach ($result as $row) {
            		$i++;
            		
            		
                    $statement1_customer = $pdo->prepare("SELECT * FROM tbl_customer WHERE cust_id=?");
                    $statement1_customer->execute(array($row['customer_id']));
                    $result1_customer = $statement1_customer->fetchAll(PDO::FETCH_ASSOC);
                    
                
            		
            		?>
            		
            		<?php
            		
     if($row['payment_status']=='Pending'  && $row['shipping_status']=='Pending')
            		  
            		  {    
            		 
            		?>
					<tr class="bg-r">
					    
					     <?php } elseif($row['payment_status']=='Success'  && $row['shipping_status']=='Pending') {?>
					     
					     
					    <tr class="bg-y">
					   
					     <?php } elseif($row['payment_status']=='Success'  && $row['shipping_status']=='Completed') {?>
					     
					     
					    <tr class="bg-g">
	
					    
					    <?php }?>
					    
					   
	                    <td><?php echo $i; ?></td>
	                    <td> <?php echo $row['customer_name']; ?>  </td>
                       <!--  <td>
                           <?php
                           $statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE id=?");
                           $statement1->execute(array($row['payment_id']));
                           $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
                           foreach ($result1 as $row1) {
                                echo '<b>Product Name:</b> '.$row1['product_name'];
                                echo '<br>(<b>Size:</b> '.$row1['size'];
                                echo ', <b>Color:</b> '.$row1['color'].')';
                                echo '<br>(<b>Quantity:</b> '.$row1['quantity'];
                                echo ', <b>Unit Price:</b> '.$row1['unit_price'].')';
                                echo '<br><br>';
                           }
                           ?>
                        </td> -->
                       
                        <td><?php echo $row['paid_amount']; ?></td>
                        
                        <td>
                            <?php echo $row['payment_status']; ?>
                          
                           <!--  <?php
                                if($row['payment_status']=='Pending'){
                                    ?>
                                    <a href="order-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Make Completed</a>
                                    <?php
                                }
                            ?> -->
                        </td>
                        <td>
                            <?php echo $row['shipping_status']; ?>
                            <br><br>
                            <!-- <?php
                            if($row['payment_status']=='Success') {
                                if($row['shipping_status']=='Pending'){
                                    ?>
                                    <a href="shipping-change-status.php?id=<?php echo $row['id']; ?>&task=Completed" class="btn btn-warning btn-xs" style="width:100%;margin-bottom:4px;">Make Completed</a>
                                    <?php
                                }
                            }
                            ?> -->
                        </td>

                         <td><?php echo $row['payment_date']; ?></td>
                         
                         <!-- <td><?php echo $result1_customer[0]['cust_shipping_address'];  ?></td> -->
	                    <td><a href="vieworder.php?order_id=<?php echo $row['id'];?>&id=<?php echo $result1_customer[0]['cust_id'];?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="View"><i class="fa fa-eye"></i></a>
                    
                    <!--<a href="editshippingorder.php?order_id=<?php echo $row['id'];?>&id=<?php echo $result1_customer[0]['cust_id'];?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="View"><i class="fa fa-edit"></i></a>-->
                   </td>
	                </tr>
            		<?php
            	}
            	?>
            </tbody>
          </table>
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


<?php require_once('footer.php'); ?>