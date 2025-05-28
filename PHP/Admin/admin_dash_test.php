<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in as admin
if (!isset($_SESSION['admin_id']) || $_SESSION['user_type'] != 'admin') {
    // Redirect to login page if not logged in or not an admin
    header("Location: ../login.php");
    exit();
}

// Get admin information from session
$username = $_SESSION['username'];
$volledige_naam = $_SESSION['volledige_naam'];

// Include database connection
require_once '../Includes/db.php';

// Fetch last 5 admin login attempts
$login_attempts = [];
try {
    $stmt = $suelect_conn->prepare("
        SELECT 
            alp.poging_id,
            alp.username,
            alp.succes,
            alp.poging_datum,
            a.volledige_naam
        FROM admininlogpogingen alp 
        LEFT JOIN admin a ON alp.admin_id = a.admin_id 
        ORDER BY alp.poging_datum DESC 
        LIMIT 5
    ");
    $stmt->execute();
    $result = $stmt->get_result();
    $login_attempts = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch counts for stats cards
    $counts = [];

    $tables = [
        'Aantal Gebruikers' => 'Gebruiker',
        'Aantal Administrators' => 'Admin',
        'Aantal Kanidaten' => 'Kandidaat',
        'Aantal Districten' => 'Distrikt',
        'Aantal Partijen' => 'Partij'
    ];

    foreach ($tables as $key => $table) {
        $count_stmt = $suelect_conn->prepare("SELECT COUNT(*) as count FROM $table");
        $count_stmt->execute();
        $count_result = $count_stmt->get_result();
        $count_row = $count_result->fetch_assoc();
        $counts[$key] = $count_row['count'] ?? 0;
        $count_stmt->close();
    }
    
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="../../CSS/Admin_dash.css">
</head>
<body>
    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
<div class="logo-container">
    <div class="logo">
        <img src="../../Images/Icons/Logo.png" alt="Su.Elect Logo">
    </div>
    
</div>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item active">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-user-tie"></i>
                <span>Kanidaten</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-map-marker-alt"></i>
                <span>Districten</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-users"></i>
                <span>partijen</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-users"></i>
                <span>Gebruikers</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <header class="header">
            <div class="header-left">
                <button class="menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h4>Dashboard</h4>
            </div>
            <div class="header-right">
                <div class="user-profile">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($volledige_naam); ?>&background=random" alt="Admin">
                    <div class="user-info">
                        <h4><?php echo htmlspecialchars($volledige_naam); ?></h4>
                        <p>Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="content-wrapper">
            
            
            <div class="welcome-card">
                <h2 class="welcome-title">Welcome, Admin!</h2>
                <p class="admin-name"><?php echo htmlspecialchars($volledige_naam); ?></p>
                <div class="admin-info">
                    <p>You have successfully logged in as an administrator.</p>
                    <p>Username: <?php echo htmlspecialchars($username); ?></p>
                </div>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
            <h3><?php echo $counts['Aantal Gebruikers'] ?? 0; ?></h3>
            <p>Aantal Gebruikers</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div class="stat-info">
            <h3><?php echo $counts['Aantal Administrators'] ?? 0; ?></h3>
            <p>Aantal Administrators</p>
                </div>
            </div>
                            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div class="stat-info">
            <h3><?php echo $counts['Aantal Kanidaten'] ?? 0; ?></h3>
            <p>Aantal Kanidaten</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="stat-info">
            <h3><?php echo $counts['Aantal Districten'] ?? 0; ?></h3>
            <p>Aantal  Districten</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="stat-info">
            <h3><?php echo $counts['Aantal Partijen'] ?? 0; ?></h3>
            <p>Aantal Partijen</p>
                </div>
            </div>
            </div>




            <!-- Login Attempts Section -->
<div class="login-attempts-section">
    <h3 class="section-title">Recent Login Attempts</h3>
    
    <?php if (!empty($login_attempts)): ?>
        <table class="login-attempts-table">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Admin Name</th>
                    <th>Status</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($login_attempts as $attempt): ?>
                    <tr>
                        <td class="username-cell" data-label="Username">
                            <?php echo htmlspecialchars($attempt['username']); ?>
                        </td>
                        <td class="admin-name-cell" data-label="Admin Name">
                            <?php echo htmlspecialchars($attempt['volledige_naam'] ?? 'Unknown'); ?>
                        </td>
                        <td data-label="Status">
                            <span class="status-badge <?php echo $attempt['succes'] ? 'status-success' : 'status-failed'; ?>">
                                <?php echo $attempt['succes'] ? 'Success' : 'Failed'; ?>
                            </span>
                        </td>
                        <td class="date-cell" data-label="Date & Time">
                            <?php 
                                $date = new DateTime($attempt['poging_datum']);
                                echo $date->format('M j, Y g:i A');
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="empty-state">
            <i class="fas fa-history"></i>
            <p>No login attempts found.</p>
        </div>
    <?php endif; ?>
</div>
        </div>



        
    </div>

    

    <script>
        // Toggle sidebar on mobile
        const menuToggle = document.querySelector('.menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            overlay.classList.toggle('active');
        });
        
        // Close sidebar when clicking outside
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
        });
        
        // Adjust sidebar on resize
        function handleResize() {
            if (window.innerWidth > 992) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }
        }
        
        window.addEventListener('resize', handleResize);
    </script>
</body>
</html>