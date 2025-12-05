<?php require_once('header.php'); ?>


   <?php


///contactus

        ///about us
    if(isset($_POST['form_home'])) {
            
        $valid = 1;
        if($valid == 1) {
            $statement = $pdo->prepare("UPDATE tbl_seo SET home_meta_title=?,home_meta_keyword=?,home_meta_description=?  ");
            $statement->execute(array($_POST['home_meta_title'],$_POST['home_meta_keyword'],$_POST['home_meta_description']));
        } 

        $success_message = 'Home SEO Meta details  Information is updated successfully.';

    }  
//aboutus
    if(isset($_POST['form_about'])) {
            
        $valid = 1;
        if($valid == 1) {
            $statement = $pdo->prepare("UPDATE tbl_seo SET about_meta_title=?,about_meta_keyword=?,about_meta_description=?  ");
            $statement->execute(array($_POST['about_meta_title'],$_POST['about_meta_keyword'],$_POST['about_meta_description']));
        } 

        $success_message = 'About SEO Meta details  Information is updated successfully.';

    }  
//Teams
if(isset($_POST['form_team'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET team_meta_title=?,team_meta_keyword=?,team_meta_description=?  ");
        $statement->execute(array($_POST['team_meta_title'],$_POST['team_meta_keyword'],$_POST['team_meta_description']));
    } 
    $success_message = 'Team Metadetails  Information is updated successfully.';
}  
//awards
if(isset($_POST['form_awards'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET awards_meta_title=?,awards_meta_keyword=?,awards_meta_description=?  ");
        $statement->execute(array($_POST['awards_meta_title'],$_POST['awards_meta_keyword'],$_POST['awards_meta_description']));
    } 

    $success_message = 'Awards Metadetails  Information is updated successfully.';
}  
//Project
if(isset($_POST['form_project'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET project_meta_title=?,Project_meta_keyword=?,project_meta_description=?  ");
        $statement->execute(array($_POST['project_meta_title'],$_POST['project_meta_keyword'],$_POST['project_meta_description']));
    } 

    $success_message = 'project Metadetails  Information is updated successfully.';
}  

//ongoing
if(isset($_POST['form_ongoing'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET ongoing_meta_title=?,ongoing_meta_keyword=?,ongoing_meta_description=?  ");
        $statement->execute(array($_POST['ongoing_meta_title'],$_POST['ongoing_meta_keyword'],$_POST['ongoing_meta_description']));
    } 

    $success_message = 'Ongoing Metadetails  Information is updated successfully.';
}  
//readytooccupy_meta_keyword
if(isset($_POST['form_readytooccupy'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET readytooccupy_meta_title=?,readytooccupy_meta_keyword=?,readytooccupy_meta_description=?  ");
        $statement->execute(array($_POST['readytooccupy_meta_title'],$_POST['readytooccupy_meta_keyword'],$_POST['readytooccupy_meta_description']));
    } 
 $success_message = 'Ready To Occupy Metadetails  Information is updated successfully.';
} 
//completed
if(isset($_POST['form_completed'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET completed_meta_title=?,completed_meta_keyword=?,completed_meta_description=?  ");
        $statement->execute(array($_POST['completed_meta_title'],$_POST['completed_meta_keyword'],$_POST['completed_meta_description']));
    } 

    $success_message = 'Completed Metadetails  Information is updated successfully.';
}
//contact
if(isset($_POST['form_contact'])) {
    $valid = 1;
    if($valid == 1) {
        $statement = $pdo->prepare("UPDATE tbl_seo SET contact_meta_title=?,contact_meta_keyword=?,contact_meta_description=?  ");
        $statement->execute(array($_POST['contact_meta_title'],$_POST['contact_meta_keyword'],$_POST['contact_meta_description']));
    } 

    $success_message = 'Contact Metadetails  Information is updated successfully.';
} 
  
            ?>
    <section class="content-header">
                <div class="content-header-left">
                    <h1>seo Settings</h1>
                </div>
        </section>                                      

                            <?php
                if (isset($_POST['commit'])) {   
                    require_once "form/db.php";
                $row = $statement->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    die("No record found.");
                }
                }

                // Assign variables safely
                $about_meta_title = $row['about_meta_title'] ?? '';
                $about_meta_keyword = $row['about_meta_keyword'] ?? '';
                $about_meta_description = $row['about_meta_description'] ?? '';
                $awards_meta_title = $row['awards_meta_title'] ?? '';
                $awards_meta_keyword = $row['awards_meta_keyword'] ?? '';
                $awards_meta_description = $row['awards_meta_description'] ?? '';
                $team_meta_title = $row['team_meta_title'] ?? '';
                $team_meta_keyword = $row['team_meta_keyword'] ?? '';
                $team_meta_description = $row['team_meta_description'] ?? '';
                $readytooccupy_meta_title = $row['readytooccupy_meta_title'] ?? '';
                $readytooccupy_meta_keyword = $row['readytooccupy_meta_keyword'] ?? '';
                $readytooccupy_meta_description = $row['readytooccupy_meta_description'] ?? '';
                $contact_meta_title = $row['contact_meta_title'] ?? '';
                $contact_meta_keyword = $row['contact_meta_keyword'] ?? '';
                $contact_meta_description = $row['contact_meta_description'] ?? '';
                $completed_meta_title = $row['completed_meta_title'] ?? '';
                $completed_meta_keyword = $row['completed_meta_keyword'] ?? '';
                $completed_meta_description = $row['completed_meta_description'] ?? '';
                $ongoing_meta_title = $row['ongoing_meta_title'] ?? '';
                $ongoing_meta_keyword = $row['ongoing_meta_keyword'] ?? '';
                $ongoing_meta_description = $row['ongoing_meta_description'] ?? '';
                $project_meta_title = $row['project_meta_title'] ?? '';
                $project_meta_keyword = $row['project_meta_keyword'] ?? '';
                $project_meta_description = $row['project_meta_description'] ?? '';
                // Fetch home meta details from the database
                $statement = $pdo->prepare("SELECT home_meta_title, home_meta_keyword, home_meta_description FROM tbl_seo");
                $statement->execute();
                $row = $statement->fetch(PDO::FETCH_ASSOC);

                // Store values in variables with fallback
                $home_meta_title = $row['home_meta_title'] ?? '';
                $home_meta_keyword = $row['home_meta_keyword'] ?? '';
                $home_meta_description = $row['home_meta_description'] ?? '';

                ?>


                <section class="content" style="min-height:auto;margin-bottom: -30px;">
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

                                            <p>
                                                <?php echo $success_message; ?>
                                            </p>
                                        </div>
                                        <?php endif; ?>
                        </div>
                    </div>
                </section>

                <section class="content">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab">Home</a></li>
                        <li><a href="#tab_2" data-toggle="tab">About us</a></li>
                        <li><a href="#tab_3" data-toggle="tab">Team</a></li>
                        <li><a href="#tab_4" data-toggle="tab">Projects</a></li>
                        <li><a href="#tab_5" data-toggle="tab">Awards</a></li>
                        <li><a href="#tab_6" data-toggle="tab">Ongoing</a></li>
                        <li><a href="#tab_7" data-toggle="tab">Ready to occupy</a></li>
                        <li><a href="#tab_8" data-toggle="tab">Completed</a></li>
                        <li><a href="#tab_9" data-toggle="tab">Contact</a></li>
                    </ul>
        <!-- About us seo Content -->

                                <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="home_meta_title" value="<?php echo $home_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="home_meta_keyword" style="height:100px;">
                                                                <?php echo $home_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="home_meta_description" style="height:100px;">
                                                                <?php echo $home_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_home">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane " id="tab_2">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="about_meta_title" value="<?php echo $about_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="about_meta_keyword" style="height:100px;">
                                                                <?php echo $about_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="about_meta_description" style="height:100px;">
                                                                <?php echo $about_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_about">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- about seo Content -->
                                    <div class="tab-pane" id="tab_3">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="team_meta_title" value="<?php echo $team_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="team_meta_keyword" style="height:100px;">
                                                                <?php echo $team_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="team_meta_description" style="height:100px;">
                                                                <?php echo $team_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_team">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--projects-->
                                       <div class="tab-pane" id="tab_4">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="project_meta_title" value="<?php echo $project_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="project_meta_keyword" style="height:100px;">
                                                                <?php echo $project_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="project_meta_description" style="height:100px;">
                                                                <?php echo $project_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_project">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                  <!--award-->
                                    <div class="tab-pane" id="tab_5">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="awards_meta_title" value="<?php echo $awards_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="awards_meta_keyword" style="height:100px;">
                                                                <?php echo $awards_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="awards_meta_description" style="height:100px;">
                                                                <?php echo $awards_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_awards">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="6">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="ongoing_meta_title" value="<?php echo $ongoing_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="ongoing_meta_keyword" style="height:100px;">
                                                                <?php echo $ongoing_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="ongoing_meta_description" style="height:100px;">
                                                                <?php echo $ongoing_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_ongoing">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                             <!--award-->
                                    <div class="tab-pane" id="tab_7">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="readytooccupy_meta_title" value="<?php echo $readytooccupy_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="readytooccupy_meta_keyword" style="height:100px;">
                                                                <?php echo $readytooccupy_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="readytooccupy_meta_description" style="height:100px;">
                                                                <?php echo $readytooccupy_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_readytooccupy">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane" id="tab_8">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="contact_meta_title" value="<?php echo $contact_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="contact_meta_keyword" style="height:100px;">
                                                                <?php echo $contact_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="contact_meta_description" style="height:100px;">
                                                                <?php echo $contact_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_contact">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- completed -->

                                    <div class="tab-pane" id="tab_9">
                                        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                                            <div class="box box-info">
                                                <div class="box-body">

                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Title*</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control" type="text" name="completed_meta_title" value="<?php echo $completed_meta_title; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Keyword*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="completed_meta_keyword" style="height:100px;">
                                                                <?php echo $completed_meta_keyword; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label">Meta Description*</label>
                                                        <div class="col-sm-8">
                                                            <textarea class="form-control" name="completed_meta_description" style="height:100px;">
                                                                <?php echo $completed_meta_description; ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="" class="col-sm-3 control-label"></label>
                                                        <div class="col-sm-6">
                                                            <button type="submit" class="btn btn-success pull-left" name="form_completed">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- ongoing -->
                                
                                    </form>
                                </div>
                            </div>

                </section>

                <?php require_once('footer.php'); ?>