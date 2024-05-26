<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
    
    if (isset($_SESSION['ad_id'])) {
        // code...
        $id_user=$_SESSION['ad_id'];

    }
		if(isset($_POST['add_patient']))
		{

			$pat_nom=$_POST['pat_nom'];
			$pat_postnom=$_POST['pat_postnom'];
            $pat_prenom=$_POST['pat_prenom'];
            $pat_sexe=$_POST['pat_sexe'];
			$pat_number=$_POST['pat_number'];
            $pat_phone=$_POST['pat_phone'];
            $pat_daten=$_POST['pat_daten'];
            $pat_addr=$_POST['pat_addr'];
            $pat_age = $_POST['pat_age'];
            $pat_emploi = $_POST['pat_emploi'];

            
            //sql to insert captured values
			$query="insert into patients (pat_nom,pat_postnom,pat_prenom,pat_sexe,pat_emploi,pat_age,pat_daten,pat_number,pat_addr,pat_phone,pat_date_create,pat_date_update,id_user) values(?,?,?,?,?,?,?,?,?,?,now(),now(),?)";

			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssssssss', $pat_nom, $pat_postnom, $pat_prenom, $pat_sexe, $pat_emploi, $pat_age, $pat_daten, $pat_number, $pat_addr, $pat_phone, $id_user);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Details Added";
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End Patient Registration-->
<!DOCTYPE html>
<html lang="en">
    
    <!--Head-->
    <?php include('assets/inc/head.php');?>
    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
            <?php include("assets/inc/nav.php");?>
            <!-- end Topbar -->

            <!-- ========== Left Sidebar Start ========== -->
            <?php include("assets/inc/sidebar.php");?>
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="his_admin_dashboard.php">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Patients</a></li>
                                            <li class="breadcrumb-item active">Add Patient</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Add Patient Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Fill all fields</h4>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Nom</label>
                                                    <input type="text" required="required" name="pat_nom" class="form-control" id="inputEmail4" placeholder="Patient's Name">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Post-nom</label>
                                                    <input required="required" type="text" name="pat_postnom" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>
                                                 <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Prenom</label>
                                                    <input required="required" type="text" name="pat_prenom" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                    <div class="form-group col-md-4">
                                                    <label for="inputState" class="col-form-label">Sexe</label>
                                                    <select id="inputState" required="required" name="pat_sexe" class="form-control">
                                                    <option value="">Choose</option>
                                                    <option value="M">Masculin</option>
                                                <option value="F">Feminin</option>
                                                    </select>
                                        </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Date de naissance</label>
                                                    <input type="date" required="required" name="pat_daten" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Age</label>
                                                    <input required="required" type="Number" name="pat_age" class="form-control"  id="inputPassword4" placeholder="Patient`s Age">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Mobile Number</label>
                                                    <input required="required" type="text" name="pat_phone" class="form-control" id="inputCity">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Emploi</label>
                                                    <input required="required" type="text" name="pat_emploi" class="form-control" id="inputCity">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="inputAddress" class="col-form-label">Addresse physique</label>
                                                <input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress" placeholder="Patient's Addresss">
                                                </div>
                                                
                                                <div class="form-group col-md-2" style="display:none">
                                                    <?php 
                                                        $length = 5;    
                                                        $patient_number =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,$length);
                                                    ?>
                                                    <label for="inputZip" class="col-form-label">Patient Number</label>
                                                    <input type="text" name="pat_number" value="<?php echo $patient_number;?>" class="form-control" id="inputZip">
                                                </div>
                                            </div>


                                            <button type="submit" name="add_patient" class="ladda-button btn btn-info" data-style="expand-right">Add Patient</button>

                                            <a href="admin_manage_patient.php" class="ladda-button btn btn-primary" data-style="expand-right">voir la liste</a>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <?php include('assets/inc/footer.php');?>
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

       
        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- Vendor js -->
        <script src="assets/js/vendor.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.min.js"></script>

        <!-- Loading buttons js -->
        <script src="assets/libs/ladda/spin.js"></script>
        <script src="assets/libs/ladda/ladda.js"></script>

        <!-- Buttons init js-->
        <script src="assets/js/pages/loading-btn.init.js"></script>
        
    </body>

</html>