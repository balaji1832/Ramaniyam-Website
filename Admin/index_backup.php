<?php require_once('header.php'); ?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>

<script src="highcharts/highcharts.js"></script>
<script src="highcharts/data.js"></script>
<script src="highcharts/drilldown.js"></script>

<section class="content-header">
	<h1>Dashboard</h1>
</section>

<?php
$statement = $pdo->prepare("SELECT * FROM tbl_top_category");
$statement->execute();
$total_top_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_mid_category");
$statement->execute();
$total_mid_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_end_category");
$statement->execute();
$total_end_category = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_product");
$statement->execute();
$total_product = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Completed'));
$total_order_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE shipping_status=?");
$statement->execute(array('Completed'));
$total_shipping_completed = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=?");
$statement->execute(array('Pending'));
$total_order_pending = $statement->rowCount();

$statement = $pdo->prepare("SELECT * FROM tbl_payment WHERE payment_status=? AND shipping_status=?");
$statement->execute(array('Completed','Pending'));
$total_order_complete_shipping_pending = $statement->rowCount();



$statement = $pdo->prepare("SELECT * FROM userlog");
$statement->execute();
$total_userlog = $statement->rowCount();



?>

<?php



$statement =$pdo->prepare("SELECT YEAR(FROM_UNIXTIME(date)) as year, MONTH(FROM_UNIXTIME(date)) as month, COUNT(id) as num FROM tbl_order GROUP BY YEAR(FROM_UNIXTIME(date)), MONTH(FROM_UNIXTIME(date)) ASC");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);   


	$orders = array();
	$years = array();
	foreach ($result as $res) {
	if (!isset($orders[$res['year']])) {
	for ($i = 1; $i <= 12; $i++) {
	$orders[$res['year']][$i] = 0;
	}
	}
	$years[] = $res['year'];
	$orders[$res['year']][$res['month']] = $res['num'];
	}

  $data['ordersByMonth']=  array(
            'years' => array_unique($years),
            'orders' => $orders
        );




  /* Getting demo_click table data */
  $statement =$pdo->prepare("SELECT count(cust_id) as count FROM tbl_customer 
       ORDER BY created_at");
  $statement->execute();
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);   
  $customer = json_encode(array_column($result, 'count'),JSON_NUMERIC_CHECK);



    $statement_count =$pdo->prepare("SELECT count(payment_method) as count FROM tbl_payment 
       ORDER BY payment_date");
  $statement_count->execute();
  $result_code = $statement_count->fetchAll(PDO::FETCH_ASSOC);   
  

?>

  <div class="continer">
    <div class="row" >
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart - Orders By Month</h3>
                </div>
                <div class="panel-body">
                    <div id="container-by-month" style="min-width: 310px; height: 400px; margin: 0 auto;">

                    </div>
                </div>
            </div>
        </div>

          <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Area Chart - Orders From Referrer</h3>
                </div>
                <div class="panel-body">
                    <div id="container-by-referrer" style="min-width: 310px; height: 400px; margin: 0 auto;">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> Most Orders By Payment Type</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Payment type</th>
                                <th>Num Orders</th>
                            </tr>
                        </thead>
                        <tbody>
                                                                <tr>
                                        <td>cashOnDelivery</td>
                                        <td><?php echo  $result_code[0]['count'];  ?></td>
                                    </tr>
                                                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o fa-fw"></i> Last Activity Log</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>User</th>
                                   <th>Login Time in/out </th>
                                                                       <th>Action</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                            $i=0;
                            $statement = $pdo->prepare("SELECT *  FROM  userlog  limit 0,10 ");
                            $statement->execute();
                            $result = $statement->fetchAll(PDO::FETCH_ASSOC);                       
                            foreach ($result as $row) {
                                $i++;
                                ?>
                                <tr>
                                <td><i class="fa fa-user" aria-hidden="true"></i> <b><?php echo $row['username']; ?></b></td>

                                <?php

if(function_exists('date_default_timezone_set'))
{
    date_default_timezone_set("Asia/Kolkata");
}
                                ?>
                                <td><?php  echo date('Y-m-d h:i:s',$row['loginTime']);
 ?>  </td>

                                 <td><?php echo $row['action'];  ?>  </td>
                                </tr>

                            <?php }?>
                                                                               
                                                                    </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Most Sold</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Sales</th>
                                    <th>Url</th>
                                </tr>
                            </thead>
                            <tbody>
                                                                        <tr>
                                            <td>5</td>
                                            <td><a target="_blank" href="#">sdsadasd</a></td>
                                        </tr>
                                                                                <tr>
                                            <td>1</td>
                                            <td><a target="_blank" href="#">sadsdsdsd</a></td>
                                        </tr>
                                                                    </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        <a href="#">View All Products <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
    
    $(function () {
    Highcharts.chart('container-by-month', {
    title: {
    text: 'Monthly Orders',
            x: - 20
    },
            subtitle: {
            text: 'Source: Orders table',
                    x: - 20
            },
            xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            yAxis: {
            title: {
            text: 'Orders'
            },
                    plotLines: [{
                    value: 0,
                            width: 1,
                            color: '#808080'
                    }]
            },
            tooltip: {
            valueSuffix: ' Orders'
            },
            legend: {
            layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0
            },
            series: [
<?php foreach ($data['ordersByMonth']['years'] as $year) { 

             
    ?>
                {
                name: '<?= $year ?>',
                        data: [<?= implode(',', $data['ordersByMonth']['orders'][$year]) ?>]
                },
<?php } ?>
            ]
    });
    });
</script>

<section class="content">

<?php require_once('footer.php'); ?>