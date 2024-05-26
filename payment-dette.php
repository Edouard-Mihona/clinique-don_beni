<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
    // include('assets/inc/conPDO.php');

$sql = "SELECT * FROM mode_paiement";
$result = $mysqli->query($sql);

$sql1 = "SELECT * FROM prix_service";
$result1 = $mysqli->query($sql1);


                            $pat_id=$_GET['pat_id'];
                            $ret="SELECT * FROM patients WHERE pat_id=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$pat_id);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            $rowp=$res->fetch_object();
                        

                            
    if (isset($_SESSION['ad_id'])) {
        // code...
        $id_user=$_SESSION['ad_id'];

    }
		  if(isset($_POST['paiement_service']))
        {
 
              $id_paiement_service=$_POST['id_paiement_service'];
              $id_mode_paiement='4';
              

            //sql to insert captured values
           $query="UPDATE paiement_service SET id_mode_paiement = ? WHERE id_paiement_service = ?";
            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('ss', $id_mode_paiement, $id_paiement_service);
            $stmt->execute();   
            /*
            *Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
            *echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
            */ 
            //declare a varible which will be passed to alert function
            if($stmt)
            {
                $success = "Félicitation, Opération a été effectuée avec succes";
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
                                    <h4 class="page-title">Page pour le paiement d'un service</h4>
                                </div>
                            </div>
                        </div> 

                        <!-- end page title --> 
                        <!-- Form row -->
                        <!--LETS GET DETAILS OF SINGLE PATIENT GIVEN THEIR ID-->
                      
 
                         <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    <strong><h4 class="header-title" style="color:red;">Information du patient N°<?php echo $rowp->pat_number;?>
                                        </h4></strong>
                                    <h4>Noms : <?php echo $rowp->pat_prenom;?>
                                     <?php echo $rowp->pat_nom;?><br>
                                        Age :  <?php echo $rowp->pat_age;?><br>
                                     Sexe :  <?php echo $rowp->pat_sexe;?><br>
                                        Tél :  <?php echo $rowp->pat_phone;?>
                                    </h4>
                                        <!--Add Patient Form-->

    <?php
                            $pat_id=$_GET['pat_id'];
                            $ret="SELECT * FROM paiement_service, patients, prix_service, mode_paiement WHERE paiement_service.id_service = prix_service.id_service AND paiement_service.pat_id = patients.pat_id AND paiement_service.id_mode_paiement = mode_paiement.id_mode_paiement AND mode_paiement.type !='cash' AND patients.pat_id = ?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$pat_id);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
                        ?>
    ==========================================================================================================================
                                        <form method="post">

<input type="hidden" required="required" name="id_paiement_service" class="form-control" id="inputEmail4" placeholder="" value="<?php echo $row->id_paiement_service;?>">
       <div>Dette de <?php  echo $row->prix; ?> <?php  echo $row->type_money; ?> du Service <?php  echo $row->description; ?> en date du <?php  echo $row->date_update; ?>   </div>        
                                      
                                <button type="submit" name="paiement_service" class="ladda-button btn btn-primary" data-style="expand-right">Payer</button>

                                        </form>
<?php }?>
                                     
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