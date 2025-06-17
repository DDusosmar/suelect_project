<?php
session_start();

include 'Includes/db.php';

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $wachtwoord = trim($_POST['wachtwoord']);
    
    if (empty($email) || empty($wachtwoord)) {
        $error_message = "Alle velden zijn verplicht.";
    } else {
        // gebruiker validatie
        $stmt = $suelect_conn->prepare("SELECT gebruiker_id, voornaam, achternaam, id_nummer, wachtwoord, email, gestemd FROM Gebruiker WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $gebruiker = $result->fetch_assoc();
            
            if (password_verify($wachtwoord, $gebruiker['wachtwoord'])) {
                $stmt_update = $suelect_conn->prepare("UPDATE Gebruiker SET laatste_login = CURRENT_TIMESTAMP WHERE gebruiker_id = ?");
                $stmt_update->bind_param("i", $gebruiker['gebruiker_id']);
                $stmt_update->execute();
                $stmt_update->close();
                
                $stmt_log = $suelect_conn->prepare("INSERT INTO Inlogpogingen (gebruiker_id, succes) VALUES (?, 1)");
                $stmt_log->bind_param("i", $gebruiker['gebruiker_id']);
                $stmt_log->execute();
                $stmt_log->close();
                
                $_SESSION['gebruiker_id'] = $gebruiker['gebruiker_id'];
                $_SESSION['voornaam'] = $gebruiker['voornaam'];
                $_SESSION['achternaam'] = $gebruiker['achternaam'];
                $_SESSION['id_nummer'] = $gebruiker['id_nummer'];
                $_SESSION['email'] = $gebruiker['email'];
                $_SESSION['gestemd'] = $gebruiker['gestemd'];
                $_SESSION['user_type'] = 'gebruiker';
                
                header("Location: User/user_dash_test.php");
                exit();
            } else {
                $stmt_log = $suelect_conn->prepare("INSERT INTO Inlogpogingen (gebruiker_id, succes) VALUES (?, 0)");
                $stmt_log->bind_param("i", $gebruiker['gebruiker_id']);
                $stmt_log->execute();
                $stmt_log->close();
                
                $error_message = "Ongeldige inloggegevens.";
            }
            
            $stmt->close();
        } else {
            $stmt->close();
            
             // Admin validatie
            $stmt_admin = $suelect_conn->prepare("SELECT admin_id, username, volledige_naam, wachtwoord, email FROM Admin WHERE email = ?");
            $stmt_admin->bind_param("s", $email);
            $stmt_admin->execute();
            $admin_result = $stmt_admin->get_result();
            
            if ($admin_result->num_rows === 1) {
                $admin = $admin_result->fetch_assoc();
                
                if (password_verify($wachtwoord, $admin['wachtwoord'])) {
                    $stmt_update = $suelect_conn->prepare("UPDATE Admin SET laatste_login = CURRENT_TIMESTAMP WHERE admin_id = ?");
                    $stmt_update->bind_param("i", $admin['admin_id']);
                    $stmt_update->execute();
                    $stmt_update->close();
                    
                    $stmt_log = $suelect_conn->prepare("INSERT INTO AdminInlogpogingen (admin_id, username, succes) VALUES (?, ?, 1)");
                    $stmt_log->bind_param("is", $admin['admin_id'], $admin['username']);
                    $stmt_log->execute();
                    $stmt_log->close();
                    
                    $_SESSION['admin_id'] = $admin['admin_id'];
                    $_SESSION['username'] = $admin['username'];
                    $_SESSION['volledige_naam'] = $admin['volledige_naam'];
                    $_SESSION['email'] = $admin['email'];
                    $_SESSION['user_type'] = 'admin';
                    
                    header("Location: Admin/admin_dashboard.php");
                    exit();
                } else {
                    $stmt_log = $suelect_conn->prepare("INSERT INTO AdminInlogpogingen (admin_id, username, succes) VALUES (?, ?, 0)");
                    $stmt_log->bind_param("is", $admin['admin_id'], $admin['username']);
                    $stmt_log->execute();
                    $stmt_log->close();
                    
                    $error_message = "Ongeldige inloggegevens.";
                }
                
                $stmt_admin->close();
            } else {
                $stmt_admin->close();
                $stmt_log = $suelect_conn->prepare("INSERT INTO Inlogpogingen (gebruiker_id, succes) VALUES (NULL, 0)");
                $stmt_log->execute();
                $stmt_log->close();  
                $error_message = "Ongeldige inloggegevens.";
            }
        }
        
        $suelect_conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../CSS/login_signup.css">
</head>
<body>
    <div class="container login">
        <div class="left">
            <div class="header">
                <a href="Index.php"><i class="fas fa-arrow-left"></i></a>
                <a href="signup.php">Nog geen account? <span style="color: var(--primary-color);">Registreer</span></a>
            </div>
            <div class="form-container">
                <h1>logIn</h1>
                <p>Welkom beste gebruiker!</p>
                
                <?php if (!empty($error_message)): ?>
                    <div style="color: red; margin-bottom: 15px;">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <input placeholder="email" type="email" name="email" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <input placeholder="Password" type="password" name="wachtwoord" id="password" required>
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    <button type="submit" class="signin-button">Sign In <i class="fas fa-arrow-right"></i></button>
                </form>
            </div>
        </div>
        <div class="right">
        </div>
    </div>

<script src="../JS/Script.js"></script>
</body>
</html>