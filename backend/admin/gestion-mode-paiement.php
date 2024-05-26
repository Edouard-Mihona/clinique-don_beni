<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];


if(isset($_POST['add_mode_paiement']))
        {

    $description = $_POST['description']; 
    $type = $_POST['type'];
     
    //$statu ='1';


    // $quer="UPDATE taux_echange SET fc=?, statu=0 WHERE statu = ?";

    //         $stm = $mysqli->prepare($quer);
    //         $r=$stm->bind_param('si', $fc, $statu);
    //         $stm->execute();

    $query="insert into mode_paiement (description_mod,type,date_create,date_update) values(?,?,now(),now())";

            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('ss', $description,$type);
            $stmt->execute();
            
            if($stmt)
            {
                $success = "Le  mode de paiement a ete mis ajoute";

            }
            else {
                $err = "Please Try Again Or Try Later";
            }
            
            
        }




?>

<!DOCTYPE html>
    <html lang="en">

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

            <!--Get Details Of A Single User And Display Them Here-->
           
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Finance</a></li>
                                            <li class="breadcrumb-item active">Gestion-mode-paiement</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title"></h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">

                            <div class="col-lg-4 col-xl-6">
                                <div class="card-box text-center">
                                    <!-- <img src="assets/images/users/patient.png" class="rounded-circle avatar-lg img-thumbnail"
                                        alt="profile-image"> -->
                                    
                                    <div class="text-left mt-3">
                                        
                                        <form method="post">
                                            <div class="form-row">
                                            <div class="form-group col-md-12">
                                    <label for="inputEmail4" class="col-form-label">Description</label>
                                         <input type="text" name="description" class="form-control" id="inputEmail4" placeholder="Description" >
                                                </div>

                                  
                                    <div class="form-group col-md-12">
                <label for="inputState" class="col-form-label">Type</label>
                                    <select id="inputState" required="required" name="type" class="form-control">
                                                    <option value="">Choose</option>
                            <option value="personnel">Personnel</option>
                                <option value="ONG">ONG</option>
                                <option value="prive">Prive</option>
                                <option value="cash">Cash</option>
                                <option value="dette">Dette</option>
                                                    </select>
                                        </div>
                                              
                                            </div>

                        <button type="submit" name="add_mode_paiement" class="ladda-button btn btn-primary" data-style="expand-right">Add Mode Paiement</button>

                                        </form>


                                    </div>

                                </div> <!-- end card-box -->

                            </div> <!-- end col-->
                            
                           
                            <div class="col-lg-8 col-xl-6">
                                <div class="card-box">
                                    
                                    <!--Medical History-->
                                    <div class="tab-content">
                                      

                                        <div class="tab-pane show active" id="timeline">
                                            <div class="table-responsive">
                                                <table class="table table-borderless mb-0">
                                                    <thead class="thead-light">
                                                        <tr>
                                                        <th>N°</th>
                                                        <th>Decription</th>
                                                            <th>Type</th>
                                                    <th>Date mise a jour</th>    
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    
                                                        $ret="SELECT * FROM mode_paiement WHERE statu=1 ";
                                                        $stmt= $mysqli->prepare($ret) ;
                                                        // $stmt->bind_param('i',$vit_pat_number );
                                                        $stmt->execute() ;//ok
                                                        $res=$stmt->get_result();
                                                        
                                                        while($row=$res->fetch_object())
                                                            {
                                                        $mysqlDateTime = $row->date_update; //trim timestamp to date


                                                    ?>
                                                        <tbody>
                                                            <tr>
                                <td><?php echo $row->id_mode_paiement;?></td>
                                    <td><?php echo $row->description_mod;?></td>
                                                                <td><?php echo $row->type;?></td>
   
                                                                <td><?php echo date("Y-m-d", strtotime($mysqlDateTime));?></td>
                                                            </tr>
                                                        </tbody>
                                                    <?php }?>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- end vitals content-->

                                      
                                        </div>
                                        <!-- end lab records content-->

                                    </div> <!-- end tab-content -->
                                </div> <!-- end card-box-->

                            </div> <!-- end col -->
                        </div>
                        <!-- end row-->

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

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>


</html>