<?php 
$host = "localhost";
$cbb_db = "cbb_db";
$suelect_db = "suelect_db";
$username = "root";
$password = "";


 // CBB database
$cbb_conn = new mysqli($host, $username, $password, $cbb_db);

if ($cbb_conn->connect_error) {
    die("CBB database connectie mislukt: " . $cbb_conn->connect_error);
}

// Suelect database
$suelect_conn = new mysqli($host, $username, $password, $suelect_db);
                
 if ($suelect_conn->connect_error) {
    die("Suelect database connectie mislukt: " . $suelect_conn->connect_error);
}
              
?>