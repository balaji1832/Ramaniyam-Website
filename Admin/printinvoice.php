<?php

include("inc/config.php");

// $statement1_customer = $pdo->prepare("SELECT * FROM tbl_payment INNER JOIN tbl_customer ON  tbl_payment.customer_id = tbl_customer.cust_id WHERE tbl_payment.customer_id = ?");


$statement1_customer = $pdo->prepare("SELECT * FROM tbl_payment INNER JOIN tbl_customer ON  tbl_payment.customer_id = tbl_customer.cust_id WHERE tbl_payment.id = ?");

$statement1_customer->execute(array($_GET['order_id']));
$result1_customer = $statement1_customer->fetchAll(PDO::FETCH_ASSOC);





// $statement_pay = $pdo->prepare("SELECT * FROM tbl_payment WHERE customer_id=?");
// $statement_pay->execute(array($result1_customer[0]['id']));
// $result_payment = $statement_pay->fetchAll(PDO::FETCH_ASSOC);


$statement1 = $pdo->prepare("SELECT * FROM tbl_order WHERE payment_id=?");
$statement1->execute(array($result1_customer[0]['id']));
$result_order = $statement1->fetchAll(PDO::FETCH_ASSOC);


// echo "<pre>";
// print_r($result_order);
// echo "</pre>";



// $state= $pdo->prepare("SELECT * FROM tbl_states WHERE id=?");
// $state->execute(array($result1_customer[0]['cust_state']));
// $result_state = $state->fetchAll(PDO::FETCH_ASSOC);



// if($result_state[0]['id']==35) {

//     $mgst="SGST";

//     $percentage="9%"; 


// }  else {

//     $mgst="IGST"; 

//     $percentage="18%";    
 
// }


?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<div class="container">
  <div class="card">
<div class="card-header">

<strong><img src="https://angelsbeautyshop.in/assets/images/angels%20logo.png" style="width:200px;"></strong> 
 
<span class="float-right"> <strong></strong> Angel Egmore <br>
Sindur Pantheon Plaza, 346, 1st floor, Pantheon Rd, opp, .Co optex, Chennai,<br>
Tamil Nadu 600008 .</span>

</div>

<div class="card-body">
<div class="row mb-4">
<div class="col-sm-4">

<h6 class="mb-3">Billing Address:</h6>

<?php if($result1_customer[0]['cust_name'] !="") { ?>

<div>
<strong><?php echo $result1_customer[0]['cust_name'] ?></strong>
</div>

<div><?php echo $result1_customer[0]['cust_shipping_address'] ?> </div>
 <div> <?php echo $result1_customer[0]['cust_s_city'];  ?> </div>

<div>Email: <?php echo $result1_customer[0]['cust_email'] ?> </div>
<div>Phone:<?php echo $result1_customer[0]['cust_phone'] ?> </div>
<div>Pincode:<?php echo $result1_customer[0]['cust_s_zip'] ?> </div>


</div>

  <?php } ?>

<div class="col-sm-4">
<h6 class="mb-3">Shipping Address:</h6>
<div>
<strong><?php echo $result1_customer[0]['cust_name'] ?></strong>
</div>
<div><?php echo $result1_customer[0]['cust_shipping_address'] ?> </div>
 <div> <?php echo $result1_customer[0]['cust_s_city'];  ?> </div>

<div>Email: <?php echo $result1_customer[0]['cust_email'] ?> </div>
<div>Phone:<?php echo $result1_customer[0]['cust_phone'] ?> </div>
  <div>Pincode:<?php echo $result1_customer[0]['cust_s_zip'] ?> </div>
                
              
</div>

<div class="col-sm-4">
<!-- <h6 class="mb-3">To:</h6>
 --><div>
<!-- <strong>Bob Mart</strong>
 --></div>
<div>Invoice No: <?php echo  $result_payment[0]['invoice_no'];  ?>  </div>
<div>order date : <?php   date("Y-m-d",$result_payment[0]['modified_at']); 

$originalDate =$result_payment[0]['modified_at'];
echo $newDate = date("d-m-Y", strtotime($originalDate))
?> </div>
<div>payment method: <?php echo  $result_payment[0]['payment_method'];  ?></div>
</div>

</div>

<div class="table-responsive-sm">
<table class="table table-striped">
<thead>
<tr>
<th class="center">#</th>
<th>Product</th>

<th class="right">Unit Cost</th>
  <th class="center">Qty</th>
<th class="right" style="text-align: right">Total</th>
</tr>
</thead>
<tbody>

<?php 

$i=1;

$totalAll=0;

$total_price=0;

          foreach ($result_order as $row) {

    // $totalAll = $totalAll + ($row['quantity']*$row['unit_price']);
    
    $subtotal  =$row['unit_price'];

 ?>

<tr>
<td class="center"><?php echo $i; ?></td>
<td class="left strong"><?php echo  $row["product_name"];?> </td>

<td class="right"> &#x20B9; <?php 


  echo $subtotal_old_price = number_format($subtotal, 2);

?>  </td>
  <td class="center"><?php echo  $row["quantity"];?></td>
<td class="right" align="right">&#x20B9;


<?php 
            
              $total +=$subtotal * $row['quantity'];
            
              $subtotal_new =$subtotal * $row['quantity'];
            
          echo  $subtotal_new = number_format($subtotal_new, 2);
            
            ?>

</td>
</tr>

<?php  



 $i++; }?>

</tbody>
</table>
</div>
<div class="row">
<div class="col-lg-4 col-sm-5">

</div>

<div class="col-lg-4 col-sm-5 ml-auto">
<table class="table table-clear">
<tbody>

 <?php

 // $total = intval(preg_replace('/[^\d.]/', '', $total));


 // if($total < 399) { 

 //   $shippingcharges =42.51;

 // } else {

 //     $shippingcharges=0;
 // }

  ?>

<tr>
<td class="left">
<strong>Shipping Charges </strong>
</td>
<td class="right" align="right"> &#x20B9; 

  <?php 
 
 // echo $shippingcharges;

 // $total=$total+$shippingcharges;
  

 ?> 

</td>
</tr>
<tr>
<td class="left">
<strong>Subtotal</strong>
</td>
<td class="right" align="right"> &#x20B9; <?php
       echo $subtotal=$total;
  round($total=$subtotal);?> 

</td>
</tr>

<?php

// $amount=round($total);  $percent=18;

// $gst_amount = ($amount*$percent)/100;

// $total = number_format($amount+$gst_amount, 2);

 $total = intval(preg_replace('/[^\d.]/', '', $total));



   // if($mgst=='IGST') {

   //   $percentcgst = number_format($gst_amount/2, 2);
   //   $percentsgst = number_format($gst_amount/2, 2);
   //   $percentsgst = $percentcgst + $percentsgst;
        
   // } else {


   //   $percentcgst = number_format($gst_amount/2, 2);
   //   $percentsgst = number_format($gst_amount/2, 2);

   // } ?>


<!-- <?php 

   if($mgst=='SGST') {?>

<tr>
<td class="left">
<strong>CGST (9%) </strong>
</td>
<td class="right" align="right">&#x20B9;  <?php echo $percentcgst;?> </td>
</tr>


  <?php }?>



<tr>
<td class="left">
<strong><?php echo $mgst;?> (<?php echo $percentage;?>) </strong>
</td>
<td class="right" align="right"> &#x20B9;  <?php echo $percentsgst;?> </td>
</tr> -->



<tr>
<td class="left" >
<strong>Total</strong>
</td>
<td class="right" align="right">
<strong>&#x20B9; <?php echo round($total);?> </strong>
</td>
</tr>





</tbody>
</table>




</div>

</div>

</div>
</div>
</div>
