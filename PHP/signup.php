<?php
global $cbb_conn, $suelect_conn;
session_start();
include 'Includes/db.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_nummer = trim($_POST['id_nummer']);
    $voornaam = trim($_POST['voornaam']);
    $achternaam = trim($_POST['achternaam']);
    $geboorte_datum = trim($_POST['geboorte_datum']);
    $email = trim($_POST['email']);
    $wachtwoord = trim($_POST['wachtwoord']);
    $bevestig_wachtwoord = trim($_POST['bevestig_wachtwoord']);
    
    if (empty($id_nummer) || empty($voornaam) || empty($achternaam) || 
        empty($geboorte_datum) || empty($email) || empty($wachtwoord) || empty($bevestig_wachtwoord)) {
        $error_message = "Alle velden zijn verplicht.";
    } elseif ($wachtwoord !== $bevestig_wachtwoord) {
        $error_message = "Wachtwoorden komen niet overeen.";
    } elseif (strlen($wachtwoord) < 8) {
        $error_message = "Wachtwoord moet minimaal 8 karakters bevatten.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Ongeldig e-mailadres.";
    } else {
        // Check of gebruiker bestaat in CBB db en mag stemmen
        $stmt = $cbb_conn->prepare("
            SELECT b.burger_id, b.id_nummer, b.voornaam, b.achternaam, b.geboorte_datum, b.status, s.heeft_stemrecht 
            FROM CBB_Burger b
            LEFT JOIN CBB_Stemrecht s ON b.burger_id = s.burger_id
            WHERE b.id_nummer = ? AND b.voornaam = ? AND b.achternaam = ? AND b.geboorte_datum = ?
        ");
        
        $stmt->bind_param("ssss", $id_nummer, $voornaam, $achternaam, $geboorte_datum);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            $error_message = "Geen overeenkomende burger gevonden in het CBB-systeem.";
        } else {
            $burger = $result->fetch_assoc();
            
            if ($burger['status'] !== 'ACTIEF') {
                $error_message = "Uw CBB-status is niet actief.";
            } elseif (!$burger['heeft_stemrecht']) {
                $error_message = "U heeft geen stemrecht volgens het CBB-systeem.";
            } else {
  
                // Check of gebruiker bestaat in Suelect db
                $stmt = $suelect_conn->prepare("SELECT gebruiker_id FROM Gebruiker WHERE id_nummer = ? OR email = ?");
                $stmt->bind_param("ss", $id_nummer, $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    $error_message = "Er bestaat al een account met dit ID-nummer of e-mailadres.";
                } else {
                    $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
                    
                    $stmt = $suelect_conn->prepare("
                        INSERT INTO Gebruiker (voornaam, achternaam, id_nummer, wachtwoord, email, geboorte_datum) 
                        VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    
                    $stmt->bind_param("ssssss", $voornaam, $achternaam, $id_nummer, $hashed_password, $email, $geboorte_datum);
                    
                    if ($stmt->execute()) {
                        header("Location: login.php");
                    } else {
                        $error_message = "Er is een fout opgetreden: " . $stmt->error;
                    }
                }
                
                $suelect_conn->close();
            }
        }
        
        $stmt->close();
        $cbb_conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../CSS/login_signup.css">
    <style>

    </style>
</head>
<body>
    <div class="container signup">
        <div class="left">
            <div class="header">
                <a href="Index.php"><i class="fas fa-arrow-left"></i></a>
                <a href="login.php">Heeft u al een account? <span style="color: var(--primary-color);">Login</span></a>
            </div>
            <div class="form-container">
                <h1>Registreer</h1>
                <p>Creëer een account voor het bezichtigen van onze Dashboard!</p>
                
                <?php if (!empty($error_message)): ?>
                    <div class="error-message">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success_message)): ?>
                    <div class="success-message">
                        <?php echo $success_message; ?>
                    </div>
                <?php else: ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div id="step1" class="step">
                        <div class="form-group">
                            <input placeholder="ID Nummer" type="text" name="id_nummer" required>
                        </div>

                        <div class="form-group">
                            <input placeholder="Voornaam" type="text" name="voornaam" required>
                        </div>
                        
                        <div class="form-group">
                            <input placeholder="Achternaam" type="text" name="achternaam" required>
                        </div>
                        
                        <div class="form-group">
                            <input placeholder="E-mailaddres" type="email" name="email" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                        
                        <div class="form-group">
                            <input placeholder="Geboortedatum" type="date" style="padding: 16px;" name="geboorte_datum" required>
                        </div>
                        
                        <button type="button" id="nextBtn" class="signup-button">Next <i class="fas fa-arrow-right"></i></button>
                    </div>
                    
                    <div id="step2" class="step hidden">
                        <div class="form-group">
                            <input placeholder="Wachtwoord" type="password" name="wachtwoord" id="password" required>
                            <i class="fas fa-eye" id="togglePassword"></i>
                        </div>
                        
                        <div class="form-group">
                            <input placeholder="Bevestig wachtwoord" type="password" name="bevestig_wachtwoord" required>
                            <i class="fas fa-lock"></i>
                        </div>
                        
                        <div class="password-requirements">
                            <p><span id="length-check" class="requirement">✔</span> Least 8 characters</p>
                            <p><span id="number-check" class="requirement">✔</span> Least one number (0-9) or a symbol</p>
                            <p><span id="case-check" class="requirement">✔</span> Lowercase (a-z) and uppercase (A-Z)</p>
                        </div>
                        
                        <button type="button" id="prevBtn" class="back-button">Back</button>
                        <button type="submit" class="signup-button">Sign Up <i class="fas fa-arrow-right"></i></button>
                    </div>
                </form>
                
                <?php endif; ?>
            </div>
        </div>
        <div class="right">
        </div>
    </div>

    <script src="../JS/Script.js"></script>
</body>
</html>