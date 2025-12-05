  <?php  
 //fetch.php  


 $connect = mysqli_connect("localhost", "root", "", "ramaniyam_db");  


 if(isset($_POST["id"]))  
 {  
      $query = "SELECT * FROM tbl_flats WHERE id = '".$_POST["id"]."'";  
      $result = mysqli_query($connect, $query);  
      $row = mysqli_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>