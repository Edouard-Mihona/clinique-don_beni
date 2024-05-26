<?php
    $host = 'localhost';
    $dbname = 'db_donbeni';
    $username = 'root';
    $password = '';
 
  try {
  
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    //echo "Connecté à $dbname sur $host avec succès.";
    
  } catch (PDOException $e) {
  
    die("Impossible de se connecter à la base de données $dbname :" . $e->getMessage());
    
  }
?>
