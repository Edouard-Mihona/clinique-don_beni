<!--Server side code to handle  Patient Registration-->
<?php
	session_start();
	include('assets/inc/config.php');
    // include('assets/inc/conPDO.php');

$sql = "SELECT * FROM mode_paiement";
$result = $mysqli->query($sql);

$sql1 = "SELECT * FROM prix_service";
$result1 = $mysqli->query($sql1);

 $taux_id='1';
 $taux="SELECT * FROM taux_echange WHERE statu=?";
                            $stmt= $mysqli->prepare($taux) ;
                            $stmt->bind_param('i',$taux_id);
                            $stmt->execute() ;//ok
                            $idtaux=$stmt->get_result();
         while($row1=$idtaux->fetch_object())
                            {
                                $id_t = $row1->idtaux;
                            }

    if (isset($_SESSION['ad_id'])) {
        // code...
        $id_user=$_SESSION['ad_id'];

    }
		  if(isset($_POST['paiement_service']))
        {
 
              $pat_id=$_POST['pat_id'];
              $id_mode_paiement=$_POST['id_mode_paiement'];
              $id_service=$_POST['id_service'];

            //sql to insert captured values
$query="insert into paiement_service (id_service,pat_id,idtaux,id_mode_paiement,id_user,date_create,date_update) values(?,?,?,?,?,now(),now())";

            $stmt = $mysqli->prepare($query);
            $rc=$stmt->bind_param('sssss', $id_service, $pat_id, $id_t, $id_mode_paiement, $id_user);
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
                        <?php
                            $pat_id=$_GET['pat_id'];
                            $ret="SELECT * FROM patients WHERE pat_id=?";
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
                                    <strong><h4 class="header-title" style="color:red;">Information du patient N°<?php echo $row->pat_number;?>
                                        </h4></strong>
                                    <h4>Noms : <?php echo $row->pat_prenom;?>
                                     <?php echo $row->pat_nom;?><br>
                                        Age :  <?php echo $row->pat_age;?><br>
                                     Sexe :  <?php echo $row->pat_sexe;?><br>
                                        Tél :  <?php echo $row->pat_phone;?>
                                    </h4>
                                        <!--Add Patient Form-->
                                        <form method="post">

<input type="hidden" required="required" name="pat_id" class="form-control" id="inputEmail4" placeholder="" value="<?php echo $row->pat_id;?>">
                                             
                                            <div class="form-row">

                                            <div class="form-group col-md-4">
                <label for="inputState" class="col-form-label">Mode de paiement</label>
                    <select id="inputState" required="required" name="id_mode_paiement" class="form-control">
                        <option value="">choose payment mode</option>

                          <?php
    // Parcourir les résultats et créer les options du champ select
  if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<option value='" . $row["id_mode_paiement"] . "'>" . $row["description_mod"] . "</option>";
        }
    } else {
        echo "0 résultats trouvés";
    }
    ?>
                      
                                                    </select>
                                               </div>
   
   <div class="form-group col-md-4">

                <label for="inputState" class="col-form-label"> Service </label>

                    <select id="inputState" required="required" name="id_service" class="form-control">
                        <option value="">choose service</option>

                          <?php
    // Parcourir les résultats et créer les options du champ select
  if ($result1->num_rows > 0) {
        while($row = $result1->fetch_assoc()) {
            echo "<option value='" . $row["id_service"] . "'>" . $row["description"] . "</option>";
        }
    } else {
        echo "0 résultats trouvés";
    }
    ?>
                      
                                                    </select>

 <h4><strong style="color:red"><div id="prix_affiche_dollars"></div></strong></h4>
                                                </div>
                                                
                                      
        
                                   </div>
                                           

                                <button type="submit" name="paiement_service" class="ladda-button btn btn-primary" data-style="expand-right">Payer</button>

                                 <a href="admin_manage_patient.php" class="ladda-button btn btn-warning" data-style="expand-right">Retour sur la liste</a>

                                        </form>

                                        <script>
    document.querySelector('[name="id_service"]').addEventListener('change', function() {
        var consId = this.value;
        if (consId) {
            fetch('get_prix.php?id=' + consId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('prix_affiche_dollars').innerText = 'Prix : ' + data.prix_d ;
                });
        } else {
            document.getElementById('prix_affiche_dollars').innerText = '';
        }
    });


    // Capture de la valeur depuis la div
    var prixDollarsDiv = document.getElementById('prix_affiche_dollars');
    var prixDollarsValue = prixDollarsDiv.innerText; // ou innerHTML si nécessaire

    // Placer la valeur capturée dans le champ de formulaire caché
    document.getElementById('prix_dollars_input').value = prixDollarsValue;


</script>
                                        <!--End Patient Form-->
                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col -->
                        </div>

                        <?php }?>
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