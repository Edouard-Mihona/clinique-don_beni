<?php
  session_start();
  include('assets/inc/config.php');
  include('assets/inc/checklogin.php');
  check_login();
  $aid=$_SESSION['ad_id'];
?>

<!DOCTYPE html>
<html lang="en">
    
<?php include('assets/inc/head.php');?>

    <body>

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Topbar Start -->
                <?php include('assets/inc/nav.php');?>
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Services</a></li>
                                            <li class="breadcrumb-item active">View Services</li>
                                        </ol>

                                    </div>
                        <!-- <h4 class="page-title"><a href="add-service.php" class="ladda-button btn btn-info" data-style="expand-right">Add service</a></h4> -->

                                </div>

                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card-box">
                                    <h4 class="header-title"></h4>
                                    <div class="mb-2">
                                        <div class="row">
                                            <div class="col-12 text-sm-center form-inline" >
                                                <div class="form-group mr-2" style="display:none">
                                                    <select id="demo-foo-filter-status" class="custom-select custom-select-sm">
                                                        <option value="">Show all</option>
                                                        <option value="Discharged">Discharged</option>
                                                        <option value="OutPatients">OutPatients</option>
                                                        <option value="InPatients">InPatients</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <input id="demo-foo-search" type="text" placeholder="Search" class="form-control form-control-sm" autocomplete="on">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="table-responsive">
                                        <table id="demo-foo-filtering" class="table table-bordered toggle-circle mb-0" data-page-size="7">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                    <th data-toggle="true">Noms</th>
                                    <!-- <th data-toggle="true">Type</th> -->
                                    <!-- <th data-toggle="true">Service</th>  -->
                                    <th data-hide="phone">Prix en fc</th>
                                    <th data-hide="phone">Prix en $</th>
                                    <th data-hide="phone">En date</th>
                                            
                                        <th data-hide="phone">Action</th>
                                            </tr>
                                            </thead>
                                            <?php
                                            /*
                                                *get details of allpatients

                                                SELECT patient.idpatient,nom,postnom,prenom, telephone1, telephone2, SUM(dollars) as dollars, SUM(fc) as fc FROM payment_service,patient,prix_consultation WHERE payment_service.idpatient = patient.idpatient AND payment_service.idconsultation = prix_consultation.idconsultation AND mode_payment = 'credit'

                                                SELECT patients.pat_id,pat_nom,pat_postnom,pat_prenom,pat_mobile,pat_sexe, SUM(dollars) as dollars, SUM(fc) as fc FROM patients,paiement_service,prix_service,taux_echange,mode_paiement WHERE paiement_service.id_service=prix_service.id_service AND paiement_service.pat_id = patients.pat_id AND paiement_service.idtaux=taux_echange.idtaux AND paiement_service.id_mode_paiement = mode_paiement.id_mode_paiement AND mode_paiement.type !='cash'


                                                *
                                            */
                                                $ret="  

                                                SELECT 
    paiement_service.date_update, patients.pat_id AS id_patient,
    patients.pat_nom, 
    patients.pat_postnom, 
    patients.pat_prenom,
    SUM(CASE WHEN prix_service.type_money = 'fc' THEN prix_service.prix ELSE 0 END) AS total_fc,
    SUM(CASE WHEN prix_service.type_money = 'usd' THEN prix_service.prix ELSE 0 END) AS total_usd
FROM 
    patients
JOIN 
    paiement_service ON paiement_service.pat_id = patients.pat_id
JOIN 
    prix_service ON paiement_service.id_service = prix_service.id_service
JOIN 
    taux_echange ON paiement_service.idtaux = taux_echange.idtaux
JOIN 
    mode_paiement ON paiement_service.id_mode_paiement = mode_paiement.id_mode_paiement
WHERE 
    (prix_service.type_money = 'fc' OR prix_service.type_money = 'usd')
    AND mode_paiement.type != 'cash'
GROUP BY 
    patients.pat_id, 
    patients.pat_nom, 
    patients.pat_postnom, 
    patients.pat_prenom"; 
                                                //sql code to get to ten docs  randomly
                                                $stmt= $mysqli->prepare($ret) ;
                                                $stmt->execute() ;//ok
                                                $res=$stmt->get_result();
                                                $cnt=1;
                                        while($row=$res->fetch_object())
                                                {
                                                // $money = $row->type_money;
                                                // if ($money=="usd") {
                                                //         // code...
                                                //     $aff='$';
                                                //     }else{
                                                //    $aff='fc';
                                                //     }   
                                            ?>




                                                <tbody>
                                                <tr>
                                                <td><?php echo $cnt;?></td>
                        <td>
                            <?php echo $row->pat_nom;?> 
                            <?php echo $row->pat_postnom;?>
                            <?php echo $row->pat_prenom;?>
                    </td>
                    <!-- <td><?php echo $row->description_mod;?></td> -->
                     <!-- <td><?php echo $row->description;?></td> -->

                        <td><?php echo $row->total_fc;?> fc</td>
                        <td><?php echo $row->total_usd;?> $</td>
                                    <td><?php echo $row->date_update;?></td>
                                                                  
                                    <td><a href="payment-dette.php?pat_id=<?php echo $row->id_patient;?>" class="badge badge-primary"><i class="mdi mdi-check-box-outline "></i> update</a></td>
                                                </tr>
                                                </tbody>
                                            <?php  $cnt = $cnt +1 ; }?>
                                            <tfoot>
                                            <tr class="active">
                                                <td colspan="8">
                                                    <div class="text-right">
                                                        <ul class="pagination pagination-rounded justify-content-end footable-pagination m-t-10 mb-0"></ul>
                                                    </div>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div> <!-- end .table-responsive-->
                                </div> <!-- end card-box -->
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

        <!-- Footable js -->
        <script src="assets/libs/footable/footable.all.min.js"></script>

        <!-- Init js -->
        <script src="assets/js/pages/foo-tables.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        
    </body>

</html>