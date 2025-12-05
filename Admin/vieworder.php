<?php require_once('header.php'); ?>


<?php

 if(isset($_POST['history'])) {
    


     if($_POST['order_status_id']!="") {
         
        $statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status=?,payment_status=? WHERE id=?");
        $statement->execute(array($_REQUEST['order_status_id'],$_REQUEST['payment_status_id'],$_REQUEST['order_id']));
        $success_message = 'Order Details  updated successfully!';

    //   $invoice=$_POST['invoiceno'];

    //   $stmt = $pdo->prepare("SELECT * from tbl_payment WHERE order_id=?");
    //   $stmt->execute(array($invoice));
    //   $result = $stmt->fetchAll();
    //   if (!empty($result) ) {
    //   $error_message='Invoice already exists in the database';

     

    //  } else {
         
      

    // $statement = $pdo->prepare("UPDATE tbl_payment SET shipping_status=?,payment_status=?  WHERE id=?");

    // $statement->execute(array($_POST['order_status_id'],$_POST['payment_status_id'],$_REQUEST['id']));

    //   $success_message = 'Order Details  updated successfully!';
    //  }
        
}

}
/****************************** view order customer Details *****************/

$statement1_customer = $pdo->prepare("SELECT * FROM tbl_customer INNER JOIN tbl_payment ON tbl_customer.cust_id=tbl_payment.customer_id WHERE tbl_customer.cust_id = ?");
$statement1_customer->execute(array($_GET['id']));
$result1_customer = $statement1_customer->fetchAll(PDO::FETCH_ASSOC);



$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
$statement1->execute(array($_REQUEST['order_id']));
$result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);


$statement1 = $pdo->prepare("SELECT * FROM tbl_payment WHERE id=?");
$statement1->execute(array($_REQUEST['order_id']));
$result_payment = $statement1->fetchAll(PDO::FETCH_ASSOC);


$shipping_status=$result_payment[0]['shipping_status'];
$payment_status=$result_payment[0]['payment_status'];




/*********************************end***************************************/

?>

<section class="content-header">
	<div class="content-header-left">
		<h1>View Orders</h1>
	</div>
	<div class="content-header-right">
		<a href="order.php" class="btn btn-primary btn-sm"> Orders </a>
	</div>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
		    
		    <div class="pull-right">

        <a target="_blank" href="printinvoice.php?order_id=<?php echo $_GET['order_id'];?>" target="_blank" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Print Invoice"><i class="fa fa-print"></i></a>

         <a  href="vieworder.php?order_id=<?php echo $_GET['order_id'];?>&id=<?php echo $_GET['id'];?>&txtid=<?php echo $result1_customer[0]['txnid']; ?>"  data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Shipping"><i class="fa fa-truck" aria-hidden="true"></i></a>
 
        <!--<a  href="PrintShipment.php?order_id=<?php echo $_GET['order_id'];?>&id=<?php echo $_GET['id']; ?>" target="_blank" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Print Shipping List"><i class="fa fa-truck"></i></a>-->
    
        <a href="order.php" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="Cancel"><i class="fa fa-reply"></i></a>
              </div>
			<!--<div class="box box-info">-->
			<!--	<div class="box-body table-responsive">-->
			<!--	</div>-->
			<!--</div>-->
			
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-shopping-cart"></i> Order Details</h3>
          </div>
          <table class="table">
            <tbody>
              <tr>
                <td style="width: 1%;"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Store" aria-describedby="tooltip885649"><i class="fa fa-shopping-cart fa-fw"></i></button></td>
                <td><a href="#" >Angels Egmore  </a></td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Date Added"><i class="fa fa-calendar fa-fw"></i></button></td>
                <td>  <?php echo  $result1_customer[0]['created_at'];  ?>  </td>
              </tr>
              <tr>
                <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Payment Method"><i class="fa fa-credit-card fa-fw"></i></button></td>
                <td><?php   if($result1_customer[0]['payment_method']=="") {

                         echo "Cash on Delivery";
                } else {

                  echo $result1_customer[0]['payment_method'];
                }  ?>  </td>
              </tr>
                              <!-- <tr>
                  <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Shipping Method"><i class="fa fa-truck fa-fw"></i></button></td>
                  <td>Shipping</td>
                </tr> -->
                          </tbody>

          </table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-user"></i> Customer Details</h3>
          </div>
          <table class="table">
            <tbody><tr>
              <td style="width: 1%;"><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Customer"><i class="fa fa-user fa-fw"></i></button></td>
              <td> <a href="#" target="_blank"><?php echo $result1_customer[0]['cust_name'];  ?></a> </td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Customer Group"><i class="fa fa-group fa-fw"></i></button></td>
              <td><?php echo $result1_customer[0]['cust_cname'];  ?></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="E-Mail"><i class="fa fa-envelope-o fa-fw"></i></button></td>
              <td><a href="mailto:<?php echo $result1_customer[0]['cust_email'];  ?>"><?php echo $result1_customer[0]['cust_email'];  ?></a></td>
            </tr>
            <tr>
              <td><button data-toggle="tooltip" title="" class="btn btn-info btn-xs" data-original-title="Telephone"><i class="fa fa-phone fa-fw"></i></button></td>
              <td>+91<?php echo $result1_customer[0]['cust_phone'];  ?></td>
            </tr>
          </tbody></table>
        </div>
      </div>
      <div class="col-md-4">
        <div class="panel panel-default">
          <!--<div class="panel-heading">-->
          <!--  <h3 class="panel-title"><i class="fa fa-cog"></i> Options</h3>-->
          <!--</div>-->
          <table class="table">
            <tbody>
              <!--<tr>-->
              <!--  <td>Invoice</td>-->
              <!--  <td id="invoice" class="text-right">IF-2021-10</td>-->
              <!--  <td style="width: 1%;" class="text-center">                    <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-refresh"></i></button>-->
              <!--    </td>-->
              <!--</tr>-->
              <!--<tr>
                <td>Reward Points</td>
                <td class="text-right">0</td>
                <td class="text-center">                    <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  </td>
              </tr>
              <tr>
                <td>Affiliate
                  </td>
                <td class="text-right">₹ 0.00</td>
                <td class="text-center">                    <button disabled="disabled" class="btn btn-success btn-xs"><i class="fa fa-plus-circle"></i></button>
                  </td>
              </tr>-->
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-info-circle"></i> Order (#<?php echo $_GET['order_id'];?>)</h3>
      </div>
      <div class="panel-body">
        <table class="table table-bordered">
          <thead>
            <tr>
              <td style="width: 50%;" class="text-left">Billing Address</td>
                              <td style="width: 50%;" class="text-left">Shipping Address</td>
               </tr>
          </thead>
          <tbody>
            <tr>
              <td class="text-left">
                  
                  <?php
                 
                  echo $result1_customer[0]['cust_name'];  ?> <br>
                  
                 <?php
                 
                  echo $result1_customer[0]['cust_shipping_address'];  ?><br>
                  
                  <?php
                 
                  echo $result1_customer[0]['cust_s_city'];  ?><br>
                  
                  <?php
                 
                  echo $result1_customer[0]['cust_s_zip'];  ?>
                 
                  
                  
              </td>
              
              
                              <td class="text-left">
                                  
                                   <?php
                 
                  echo $result1_customer[0]['cust_name'];  ?> <br>
                  
                 <?php
                 
                  echo $result1_customer[0]['cust_shipping_address'];  ?><br>
                  
                  <?php
                 
                  echo $result1_customer[0]['cust_s_city'];  ?><br>
                  
                  <?php
                 
                  echo $result1_customer[0]['cust_s_zip'];  ?>
                              </td>
               </tr>
          </tbody>
        </table>
        <table class="table table-bordered">
          <thead>
            <tr>
              <td class="text-left">Product Description</td>
              <td class="text-left">Model</td>
              <td class="text-right">Quantity</td>
              <td class="text-right">Unit Price</td>
                            <td class="text-right">CGST</td>
              <td class="text-right">SGST</td>
                            <td class="text-right">Total</td>
            </tr>
          </thead>
          <tbody>
              
        <?php
        
        $subtotal=0; 
        
        foreach ($result1 as $row1) {
        
        $totalAll = $totalAll + ($row1['quantity']*$row1['unit_price']);
        
        
        $subtotal  =$row1['unit_price'];
        
        
        // $taxable +=round($taxable_new); 
        
        // $gst +=$row1['unit_price'] - ($row1['unit_price'] * (100/ (100 +18)));
        
        
        // $sgst +=$row1['unit_price'] - ($row1['unit_price'] * (100/ (100 +9)));
        
        ?>

<tr>
<td class="text-left"><a href=""><?php echo $row1['product_name'];  ?></a> 

</td>
<td class="text-left">&nbsp;</td>
<td class="text-right"><?php echo $row1['quantity'];  ?></td>
<td class="text-right">₹ <?php 


  echo $subtotal = number_format($subtotal, 2);

   $subtotal = (float) str_replace(',', '', $subtotal);

?></td>
<td class="text-right">9%</td>
<td class="text-right">9%</td>
            <td class="text-right">₹ <?php 
            
             $total +=$subtotal * $row1['quantity'];
            
             echo $subtotal_new =$subtotal * $row1['quantity'];
            
          
            
            ?></td>
              </tr>
             
             <?php   }?> 
             
             

            <!--   <tr>
                <td colspan="6" class="text-right">Shipping Charges</td>
                <td class="text-right">₹ <?php 
 
 echo $shippingcharges;

 $total=$total+$shippingcharges;
  

 ?> </td>
              </tr> -->
            
                 <tr>
                <td colspan="6" class="text-right">Sub-Total</td>
                <td class="text-right">₹ <?php echo $total;
                ?></td>
              </tr>
              
               
                          
                         <!--  <tr>
                <td colspan="6" class="text-right"> CGST  </td>
        <td class="text-right"> ₹  <?php echo $percentcgst;?>
        </td>
              </tr>
                
               <tr>
                <td colspan="6" class="text-right"> SGST </td>
                <td class="text-right">₹  <?php echo $percentsgst;?> 
                 </td>
              </tr>

              <?php


                $toal=number_format($total,2);

               $total=str_replace(",", "", $total);

                 
               ?>

                <tr>
                <td colspan="6" class="text-right">Total</td>
                <td class="text-right">₹ 

              <?php   echo $var = intval(preg_replace('/[^\d.]/', '', $total));

                              
    
            ?></td>
              </tr> -->

                  
                
              
              
             
              </tbody>

        </table>
         </div>
    </div>
    
   

   
    
 
    
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-comment-o"></i> Order History</h3>
      </div>
      <div class="panel-body">
        <ul class="nav nav-tabs">
          <!--<li class="active"><a href="#tab-history" data-toggle="tab">History</a></li>-->
        
                  </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab-history">
              
              <?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

       <?php if($error_message): ?>
      <div class="callout callout-warning">
        <p><?php echo $error_message; ?></p>
      </div>
      <?php endif; ?>
              
              <fieldset>
              <legend>Update Order details</legend>
              <form class="form-horizontal" method="POST">
                <div class="form-group" >
                  <label class="col-sm-2 control-label" for="input-order-status">Shipping Status</label>
                  <div class="col-sm-4">
                    <select name="order_status_id" id="input-order-status" class="form-control">

                          <option value="Pending" <?php if($shipping_status == 'Pending') { echo 'selected=selected'; } ?>>Pending</option>
                          
                          <option value="Accepted" <?php if($shipping_status == 'Accepted') { echo 'selected=selected'; } ?>>Accepted</option>

                          <option value="Processing" <?php if($shipping_status == 'Processing') { echo 'selected=selected'; } ?>>Processing</option>
                                      
                          <option value="Processed" <?php if($shipping_status == 'Processed') { echo 'selected=selected'; } ?>>Processed</option>

                          <option value="Ready to shipping" <?php if($shipping_status == 'Ready to shipping') { echo 'selected=selected'; } ?>>Ready to shipping</option>

                          <option value="Shipped" <?php if($shipping_status == 'Shipped') { echo 'selected=selected'; } ?>>Shipped</option>

                          <option value="Completed"<?php if($shipping_status == 'Completed') { echo 'selected=selected'; } ?> >Completed</option>

                          <option value="Canceled" <?php if($shipping_status == 'Canceled') { echo 'selected=selected'; } ?>>Canceled</option>

                          <option value="Denied" <?php if($shipping_status == 'Denied') { echo 'selected=selected'; } ?>>Denied</option>

                    </select>
                  </div>
                   <label class="col-sm-2 control-label" for="input-order-status">Payment Status</label>
                   <div class="col-sm-4">
                    <select name="payment_status_id" id="input-order-status" class="form-control">

                          <option value="Pending" <?php if($payment_status == 'Pending') { echo 'selected=selected'; } ?>>Pending</option>
                          
                          <option value="Success" <?php if($payment_status == 'Success') { echo 'selected=selected'; } ?>>Success</option>

                          <option value="Canceled" <?php if($payment_status == 'Canceled') { echo 'selected=selected'; } ?>>Canceled</option>
                          
                          
                    </select>
                  </div>
                </div>
                  <!--<div class="form-group" >-->
                  <!--<label class="col-sm-2 control-label" for="input-order-status">order No</label>-->
                  <!--<div class="col-sm-4">-->
                  <!--  <input type="text" name="invoiceno" class="form-control" required>-->
                  <!--</div>-->
                   <!-- <label class="col-sm-2 control-label" for="input-order-status">Shipping address</label>
                   <div class="col-sm-4">
                    <textarea name="shipping_address" class="form-control" required></textarea>
                  </div> -->
                </div>
               
                <!--<div class="form-group">-->
                <!--  <label class="col-sm-2 control-label" for="input-comment">Comment</label>-->
                <!--  <div class="col-sm-10">-->
                <!--    <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>-->
                <!--  </div>-->
                <!--</div>-->
            
            </fieldset>
            
            <div class="text-right">
                
              <input type="submit" name="history" id="button-history"  data-loading-text="Loading..." class="btn btn-primary" value="Update">
            </div>
              </form>
            <div>&nbsp;</div>
              
<!--<div class="row">-->
<!--  <div class="col-sm-6 text-left"></div>-->
<!--  <div class="col-sm-6 text-right">Showing 1 to 3 of 3 (1 Pages)</div>-->
<!--</div>-->
</div>
            <br>
           
            <div class="text-right">
              <!--<button id="button-history" data-loading-text="Loading..." class="btn btn-primary"><i class="fa fa-plus-circle"></i> Add History</button>-->
            </div>
          </div>
          
          <!--<div class="tab-pane " id="tab-additional">                                     <div class="table-responsive">-->
          <!--    <table class="table table-bordered">-->
          <!--      <thead>-->
          <!--        <tr>-->
          <!--          <td colspan="2">Browser</td>-->
          <!--        </tr>-->
          <!--      </thead>-->
          <!--      <tbody>-->
          <!--        <tr>-->
          <!--          <td>IP Address</td>-->
          <!--          <td>49.37.220.50</td>-->
          <!--        </tr>-->
          <!--                            <tr>-->
          <!--            <td>Forwarded IP</td>-->
          <!--            <td>49.37.220.50</td>-->
          <!--          </tr>-->
          <!--                          <tr>-->
          <!--          <td>User Agent</td>-->
          <!--          <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/102.0.0.0 Safari/537.36</td>-->
          <!--        </tr>-->
          <!--        <tr>-->
          <!--          <td>Accept Language</td>-->
          <!--          <td>en-GB,en-US;q=0.9,en;q=0.8</td>-->
          <!--        </tr>-->
          <!--      </tbody>-->

          <!--    </table>-->
          <!--  </div>-->
          <!--</div>-->
        
      </div>
    </div>
  </div>
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
                <p>Are you sure want to delete this item?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?>