<?php require_once('header.php'); ?>

<?php
error_reporting(0);
if (isset($_GET['delete_id'])) {
    $statement = $pdo->prepare("SELECT * FROM tbl_project_updation WHERE id=?");
    $statement->execute([$_REQUEST['delete_id']]);
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['layout'] != '') {
        unlink('../assets/uploads/project-images/' . $result['layout']);
    }
    $statement = $pdo->prepare("DELETE FROM tbl_project_updation WHERE id=?");
    $statement->execute([$_REQUEST['delete_id']]);
}



$statement = $pdo->prepare("SELECT * FROM tbl_project_updation WHERE p_id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);


$statement_projects = $pdo->prepare("SELECT number_of_flats,title FROM tbl_projects WHERE p_id=?");
$statement_projects->execute(array($_REQUEST['id']));
$flat_count = $statement_projects->fetchAll(PDO::FETCH_ASSOC);

?>

<style type="text/css">
    
.information-section {
    background-color: #f5f5f5;
    padding: 2%;
    box-shadow: 0 3px 10px rgba(50, 50, 50, 0.17);
}

.padding-left-new {
    
    padding-left:20px;
}


  .image-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  .image-grid img {
    width: 120px;
    height: auto;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  .caption-list {
    line-height: 1.6;
  }
    
</style>

<section class="content-header">
    <div class="content-header-right">

          <a href="addupdateprojectimages.php?id=<?php echo $_GET['id'] ?>" class="btn btn-danger">Add Project Updates</a>

        <a href="projects.php" class="btn btn-danger">Back to Properties</a>
    </div>
</section>

    <section class="content-header">

    <div class="row">

    <div class="col-md-6">
    <div class="information-section mb-4 rounded ">
    <div class="row">
    <h2 class="text-small-caps padding-left-new"> <strong><?php echo $flat_count[0]['title']; ?></strong></h2>
    </div>
    </div>
    </div>
    </div>
    </section>


<section class="content">
    <div class="row">
        <div class="col-md-12">
             <table id="exampleproject" class="table table-bordered table-striped">
  <thead style="background-color: #800000; color: white;">
    <tr>
      <th>Updated On</th>
      <th>Images</th>
      <th>Image Captions</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>


    <?php foreach ($result as $row):

     ?>
      
        <tr>
          <td><?= $row['project_date']; ?></td>
           <td>
          <div class="image-grid">
            <?php for ($i = 1; $i <= 5; $i++): ?>
              <?php if (!empty($row["Image$i"])): ?>
                <div>
                  <strong>Image <?= $i; ?>:</strong><br>
                  <img src="../assets/uploads/project-images/<?= htmlspecialchars($row["Image$i"]); ?>" alt="Image<?= $i; ?>">
                </div>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
        </td>
        <td>
            <div class="caption-list">
            <?php for ($i = 1; $i <= 5; $i++): ?>
            <?php
            $caption = trim($row["Image{$i}caption"]);
            if (!empty($caption)):
            ?>
            <strong>Image <?= $i; ?> Caption:</strong> <?= htmlspecialchars($caption); ?><br>
            <?php endif; ?>
            <?php endfor; ?>
            </div>
        </td>
          
          <td> <a href="editupdateimages.php?id=<?php echo $_GET['id']?>&editid=<?php echo $row['id'];  ?>">
               <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#932223" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                                    </svg>
              </a></td>
        </tr>


      <?php endforeach; ?>


  </tbody>
</table>

   
        </div>
    </div>
</section>





<?php require_once('footer.php'); ?>