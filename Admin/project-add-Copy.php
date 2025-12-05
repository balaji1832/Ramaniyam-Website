<?php require_once('header.php'); ?>

<?php
include 'form/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $flat_number = $_POST['flat_number'];
    $area = $_POST['flat_area'];
    $floor = $_POST['floor'];
    $facing = $_POST['facing'];
    $type = $_POST['flat_type'];
    $terrace = $_POST['Terrace'];
    $available = isset($_POST['available']) ? 1 : 0;

    $layout = "";
    if (isset($_FILES['layout']) && $_FILES['layout']['error'] == 0) {
        $layout = "uploads/" . basename($_FILES['layout']['name']);
        move_uploaded_file($_FILES['layout']['tmp_name'], $layout);
    }

    $sql = "INSERT INTO flats (flat_number, area, floor, facing,  terrace, layout, available) 
            VALUES ('$flat_number', '$area', '$floor', '$facing',  '$terrace', '$layout', '$available')";

    // if ($conn->query($sql) === TRUE) {
    //     header("Location: index.php");
    //     exit();
    // } else {
    //     echo "Error: " . $sql . "<br>" . $conn->error;
    // }
}
?>
<head>



            <style>
                .card {
                    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                    border-radius: 10px;
                }
                .table-header {
                    background-color: #880E0E;
                    color: white;
                    font-weight: bold;
                }
                .btn-primary {
                    background-color: #880E0E;
                    border: none;
                }
                .btn-primary:hover {
                    background-color: #6E0A0A;
                }
                .toggle-switch {
                    width: 40px;
                    height: 20px;
                    position: relative;
                }
                .toggle-switch input {
                    width: 100%;
                    height: 100%;
                    opacity: 0;
                    cursor: pointer;
                }
                .toggle-switch label {
                    width: 40px;
                    height: 20px;
                    background: #ccc;
                    border-radius: 10px;
                    position: absolute;
                    top: 0;
                    left: 0;
                    transition: 0.3s;
                }
                .toggle-switch input:checked + label {
                    background: #880E0E;
                }
            </style>
          

        </head>

        <body>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <div class="container mt-4">
    <a href="#" class="text-danger fw-bold"><i class="bi bi-arrow-left"></i> Back to properties</a>
    <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
        <div class="row mt-3">
            <!-- Left Section (Flat Summary & Table) -->
            <div class="col-lg-12">
                <div class="card p-3 mb-3">
                    <h3 class="fw-bold">ABHINAYA</h3>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-danger p-3 me-3">10 <br> FLATS IN TOTAL</span>
                        <span class="badge bg-dark p-3">0 <br> FLATS HAVE BEEN ADDED SO FAR</span>
                    </div>
                </div>

                <table class="table table-bordered">
                    <thead class="table-header">
                        <tr>
                            <th>Flat No</th>
                            <th>Floor</th>
                            <th>Type</th>
                            <th>Area</th>
                            <th>Facing</th>
                            <th>Layout</th>
                            <th>Available</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data Rows (Dynamic Entries) -->
                    </tbody>
                </table>
            </div>

            <!-- Right Section (Form to Add a Flat) -->
            <div class="col-lg-12">
                <div class="card p-4">
                    <h3 class="fw-bold text-danger">Add a Flat</h3>

                    <label for="flat_number" class="form-label">Flat Number</label>
                    <input type="text" class="form-control mb-2" id="flat_number" name="flat_number" required>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="flat_area" class="form-label">Area</label>
                            <input type="text" class="form-control" id="area" name="flat_area" required>
                        </div>
                        <div class="col-md-6">
                            <label for="flat_floor" class="form-label">Floor</label>
                            <select class="form-select" id="flat_floor" name="floor" required>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="flat_facing" class="form-label">Facing</label>
                            <select class="form-select" id="flat_facing" name="facing" required>
                                <option value="North">North</option>
                                <option value="East">East</option>
                                <option value="West">West</option>
                                <option value="South">South</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="flat_type" class="form-label">Flat Type</label>
                            <select class="form-select" id="flat_type" name="flat_type" required>
                                <option value="1BHK">1BHK</option>
                                <option value="2BHK">2BHK</option>
                                <option value="3BHK">3BHK</option>
                                <option value="4BHK">4BHK</option>
                                <option value="5BHK">5BHK</option>
                                <option value="6BHK">6BHK</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="flat_terrace" class="form-label">Terrace</label>
                            <select class="form-select" id="flat_terrace" name="Terrace">
                                <option value="1T">1T</option>
                                <option value="2T">2T</option>
                                <option value="3T">3T</option>
                                <option value="4T">4T</option>
                                <option value="5T">5T</option>
                                <option value="6T">6T</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="layout" class="form-label">Layout</label>
                            <input type="file" class="form-control" id="layout" name="layout">
                        </div>
                    </div>

                    <div class="mt-3 d-flex align-items-center">
                        <label class="me-2">Available</label>
                        <div class="toggle-switch">
                            <input type="checkbox" id="available" name="available" value="1">
                            <label for="available"></label>
                        </div>
                    </div>

                     <div class="row form-actions d-flex flex-row justify-content-center gap-4 mt-4 pb-2">
                                                <div class="col-md-8 text-center">
                                                    <div>
                                                        <input type="submit" name="commit" value="Create Property" class="btn text-white bg-brick-red rounded mb-5" data-disable-with="Create Property">
                                                        <a class="btn text-white bg-brick-red rounded mb-5" href="/admin/properties">Cancel</a></div>
                                                </div>
                                            </div>

                </div>
            </div>
        </div>
    </form>
</div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php require_once('footer.php'); ?>