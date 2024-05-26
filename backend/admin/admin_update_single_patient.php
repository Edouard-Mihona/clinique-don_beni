<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
    if (isset($_SESSION['ad_id'])) {
        // code...
        $id_user=$_SESSION['ad_id'];

    }
		if(isset($_POST['update_patient']))
		{
          
            $pat_id = $_GET['pat_id'];
            $pat_nom=$_POST['pat_nom'];
            $pat_postnom=$_POST['pat_postnom'];
            $pat_prenom=$_POST['pat_prenom'];
            $pat_sexe=$_POST['pat_sexe'];
            $pat_date_create=$_POST['pat_date_create'];
            $pat_phone=$_POST['pat_phone'];
            $pat_daten=$_POST['pat_daten'];
            $pat_addr=$_POST['pat_addr'];
            $pat_age = $_POST['pat_age'];
            $pat_emploi = $_POST['pat_emploi'];


            //sql to insert captured values
		$query="UPDATE patients SET pat_nom=?, pat_postnom=?, pat_prenom=?, pat_sexe=?, pat_emploi=?, pat_age=?, pat_daten=?, pat_addr=?, pat_phone=?, pat_date_create=?, pat_date_update=now(), id_user=? WHERE pat_id = ?";

			$stmt = $mysqli->prepare($query);
			$rc=$stmt->bind_param('sssssssssssi', $pat_nom, $pat_postnom, $pat_prenom, $pat_sexe, $pat_emploi, $pat_age, $pat_daten, $pat_addr, $pat_phone, $pat_date_create, $id_user, $pat_id);
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Patient Details Updated";
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
                                            <li class="breadcrumb-item active">Manage Patients</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Update Patient Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 
                        <!-- Form row -->
                        <!--LETS GET DETAILS OF SINGLE PATIENT GIVEN THEIR ID-->
                        <?php
                            $pat_id=$_GET['pat_id'];
                            $ret="SELECT  * FROM patients WHERE pat_id=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$pat_id);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
                        ?>
 
                         <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <strong><h4 class="header-title" style="color:red;">N°<?php echo $row->pat_number;?></h4></strong>
                                        <!--Add Patient Form-->
                                        <form method="post">
                                             <input type="hidden" required="required" name="pat_id" class="form-control" id="inputEmail4" placeholder="Patient's Name" value="<?php echo $row->pat_id;?>">
                                              <input type="hidden" required="" name="pat_date_create" class="form-control" id="inputEmail4" placeholder="Patient's Name" value="<?php echo $row->pat_date_create;?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Nom</label>
                                                    <input type="text" required="required" name="pat_nom" class="form-control" id="inputEmail4" placeholder="Patient's Name" value="<?php echo $row->pat_nom;?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Post-nom</label>
                                                    <input required="required" type="text" name="pat_postnom" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name" value="<?php echo $row->pat_postnom;?>">
                                                </div>
                                                 <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Prenom</label>
                                                    <input required="required" type="text" name="pat_prenom" class="form-control"  id="inputPassword4" placeholder="Patient`s Last Name" value="<?php echo $row->pat_prenom;?>">
                                                </div>
                                            </div>

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputState" class="col-form-label">Sexe</label>
                                                    <select id="inputState" required="required" name="pat_sexe" class="form-control">
                                        
                                        <option <?php if ($row->pat_sexe==="M") {
                                            // code...
                                            echo "selected";
                                        }?> value="M">Masculin</option>
                                        <option value="F">Feminin</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputEmail4" class="col-form-label">Date de naissance</label>
                                                    <input type="date" required="required" name="pat_daten" class="form-control" id="inputEmail4" placeholder="DD/MM/YYYY" value="<?php echo $row->pat_daten;?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Age</label>
                                                    <input required="required" type="Number" name="pat_age" class="form-control"  id="inputPassword4" placeholder="Patient`s Age" value="<?php echo $row->pat_age;?>">
                                                </div>
                                            </div>

                                        

                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Mobile Number</label>
                                                    <input required="required" type="text" name="pat_phone" class="form-control" id="inputCity" value="<?php echo $row->pat_phone;?>">
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputCity" class="col-form-label">Emploi</label>
                                                    <input required="required" type="text" name="pat_emploi" class="form-control" id="inputCity" value="<?php echo $row->pat_emploi;?>">
                                                </div>

                                                <div class="form-group col-md-4">
                                                    <label for="inputAddress" class="col-form-label">Addresse physique</label>
                                                <input required="required" type="text" class="form-control" name="pat_addr" id="inputAddress" placeholder="Patient's Addresss" value="<?php echo $row->pat_addr;?>">
                                                </div>
                                                
                                               
                                            </div>

                                            <button type="submit" name="update_patient" class="ladda-button btn btn-primary" data-style="expand-right">Modifier Patient</button>

                                        </form>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>

                        <?php  }?>
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