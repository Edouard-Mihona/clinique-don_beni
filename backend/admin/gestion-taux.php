<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];


if(isset($_POST['add_taux']))
        {


    $fc=$_POST['fc']; 
    $statu ='1';


    $quer="UPDATE taux_echange SET fc=?, statu=0 WHERE statu = ?";

            $stm = $mysqli->prepare($quer);
            $r=$stm->bind_param('si', $fc, $statu);
            $stm->execute();

    $query="insert into taux_echange (fc,date_update) values(?,now())";

            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('s', $fc);
            $stmt->execute();
            
            if($stmt)
            {
                $success = "Le taux a ete mis a jour";

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
                                            <li class="breadcrumb-item active">Gestion-taux</li>
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
                                            <div class="form-group col-md-2">
                                                    <label for="inputEmail4" class="col-form-label"></label>
                                                    <input type="text" name="" class="form-control" id="inputEmail4" placeholder="1$ =" readonly>
                                                </div>

                                                 <div class="form-group col-md-10">
                                                    <label for="inputEmail4" class="col-form-label"></label>
                                                    <input type="Number" required="required" name="fc" class="form-control" id="inputEmail4" placeholder="ex : 2500">
                                                </div>
                                              
                                               
                                            </div>

                                            
                                        
                                            <button type="submit" name="add_taux" class="ladda-button btn btn-primary" data-style="expand-right">Mettre a jour le taux</button>

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
                                                            <th>Dollar</th>
                                                            <th>Fc</th>
                                                            <th>Date mise a jour</th>
                                                            
                                                            
                                                        </tr>
                                                    </thead>
                                                    <?php
                                                    
                                                        $ret="SELECT * FROM taux_echange WHERE statu=1 ";
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
                                                                <td># 1$</td>
                                                                <td><?php echo $row->fc;?> fc</td>
                                                                
                                                               
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