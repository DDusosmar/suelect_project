<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
    <style>
        :root {
            --primary-color:rgb(255, 0, 0);
            --secondary-color: #0056b3;
            --background-color: #f5f5f5;
            --text-color: #333333;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--background-color);
            color: var(--text-color);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .welcome-message {
            background-color: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
            margin-top: 2rem;
        }
        
        h1 {
            color: var(--primary-color);
            font-family: 'Bebas Neue', sans-serif;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .user-name {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--secondary-color);
        }
    </style>
</head>
<body>
    <?php
    // Start session if not already started
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    // Check if user is logged in
    if (!isset($_SESSION['gebruiker_id']) || $_SESSION['user_type'] != 'gebruiker') {
        // Redirect to login page if not logged in or not a regular user
        header("Location: ../login.php");
        exit();
    }
    
    // Get user information from session
    $voornaam = $_SESSION['voornaam'];
    $achternaam = $_SESSION['achternaam'];
    $fullName = $voornaam . " " . $achternaam;
    ?>
    
    <div class="container">
        <div class="welcome-message">
            <h1>Welkom, Gebruiker!</h1>
            <p class="user-name"><?php echo htmlspecialchars($fullName); ?></p>
            <p>Je bent succesvol ingelogd als gebruiker.</p>
        </div>
    </div>
</body>
</html>