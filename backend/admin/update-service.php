<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
    
    if (isset($_SESSION['ad_id'])) {
        // code...
        $id_user=$_SESSION['ad_id'];

    }
		if(isset($_POST['update_service']))
		{

            $id_service =$_POST['id_service'];
			$description=$_POST['description'];
			$prix=$_POST['prix'];
            $type_money=$_POST['type_money'];
           
            //sql to update captured values

        $query="UPDATE prix_service SET description=?, prix=?, type_money=?, date_update=now() WHERE id_service = ?";

			$stmt = $mysqli->prepare($query);
$rc=$stmt->bind_param('sssi', $description, $prix, $type_money, $id_service);

            
			$stmt->execute();
			/*
			*Use Sweet Alerts Instead Of This Fucked Up Javascript Alerts
			*echo"<script>alert('Successfully Created Account Proceed To Log In ');</script>";
			*/ 
			//declare a varible which will be passed to alert function
			if($stmt)
			{
				$success = "Service Updated";
                //header('location:gestion-services.php');
                
			}
			else {
				$err = "Please Try Again Or Try Later";
			}
			
			
		}
?>
<!--End Server Side-->
<!--End service Registration-->
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Service</a></li>
                                            <li class="breadcrumb-item active">Update Service</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Update Service Details</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <?php
                            $service_id=$_GET['service_id'];
                        $ret="SELECT * FROM prix_service WHERE id_service=?";
                            $stmt= $mysqli->prepare($ret) ;
                            $stmt->bind_param('i',$service_id);
                            $stmt->execute() ;//ok
                            $res=$stmt->get_result();
                            //$cnt=1;
                            while($row=$res->fetch_object())
                            {
                        ?>
                        <!-- Form row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        
                                        <!--Add Patient Form-->
                                        <form method="post">
                                            <input type="hidden" required="required" name="id_service" class="form-control" id="inputEmail4" placeholder="" value="<?php echo $row->id_service;?>">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="inputEmail4" class="col-form-label">Description</label>
                                                <input type="text" required="required" name="description" class="form-control" id="inputEmail4" placeholder="Description" value="<?php echo $row->description;?>">
                                                </div>

                                                 <div class="form-group col-md-2">
                                                    <label for="inputState" class="col-form-label">Type de Money</label>
                                                    <select id="inputState" required="required" name="type_money" class="form-control">
                                                    <option value="">Choose</option>
                                                    <option value="usd">$</option>
                                                <option value="fc">Fc</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <label for="inputPassword4" class="col-form-label">Prix</label>
                                                    <input required="required" type="text" name="prix" class="form-control"  id="inputPassword4" placeholder="Montant" value="<?php echo $row->prix;?>">
                                                </div>
                                                
                                            </div>

                                            <button type="submit" name="update_service" class="ladda-button btn btn-info" data-style="expand-right">Update Service</button>
                                            <a href="gestion-services.php" class="ladda-button btn btn-primary" data-style="expand-right">Voir la liste</a>

                                        </form>

                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->
                 <?php  }?>
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