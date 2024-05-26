<?php

include('assets/inc/config.php');
    $id_service = $_GET['id'];
    
    $sql = "SELECT prix,type_money FROM prix_service WHERE id_service = $id_service";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['type_money'] =='usd') {

            // code...
  $devise = "USD";
  $prix = $row['prix'];
            $resultat = ['prix_d' => $prix . ' ' . $devise];

// Conversion du tableau associatif en JSON
          $json_resultat = json_encode($resultat);

// Affichage du JSON
            echo $json_resultat;
            //echo json_encode(['prix_d' => $row['prix']]);
            // echo json_encode(['type' => "$"]);
        }else{
          //echo json_encode(['prix_fc' => $row['prix']]);  
            $devise = "fc";
  $prix = $row['prix'];
            $resultat = ['prix_d' => $prix . ' ' . $devise];

// Conversion du tableau associatif en JSON
          $json_resultat = json_encode($resultat);

// Affichage du JSON
            echo $json_resultat;
        }
        
    } else {
        echo json_encode(['prix' => 'N/A']);
    }

?>
