  <?php  
 //fetch.php  


 $connect = mysqli_connect("localhost", "ramaniyamnewayat_user", "=AX;D=Mlq5IG", "ramaniyamnewayat_dbase");  




 if(isset($_POST["id"]))  
 {  
        $query = "SELECT * FROM tbl_project_updation WHERE id = '".$_POST["id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>