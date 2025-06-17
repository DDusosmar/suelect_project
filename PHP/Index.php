<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Stem Commissie - Stemmen Telsysteem</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../CSS/Prev_dash.css">
    <!-- Add Chart.js for data visualization -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }
        
        .chart-container {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .chart-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .chart-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px 16px 0 0;
        }
        
        .chart-title {
            font-size: 16px;
            margin-bottom: 20px;
            color: #2c3e50;
            font-weight: 700;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }
        
        .chart-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 2px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 1px;
        }
        
        .chart-wrapper {
            height: 250px;
            position: relative;
        }
        
        .chart-wrapper canvas {
            max-height: 100% !important;
        }
        
        .top-candidates {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .top-candidates::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
            border-radius: 16px 16px 0 0;
        }
        
        .candidates-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        
        .candidate-item {
            display: flex;
            align-items: center;
            padding: 15px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-left: 4px solid #667eea;
        }
        
        .candidate-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
        }
        
        .candidate-photo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid #e3f2fd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .candidate-info {
            flex-grow: 1;
        }
        
        .candidate-name {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 15px;
            color: #2c3e50;
        }
        
        .candidate-party {
            color: #7f8c8d;
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .candidate-votes {
            font-weight: 700;
            color: #667eea;
            font-size: 15px;
            text-align: right;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            padding: 30px 25px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #4facfe 0%, #00f2fe 100%);
            border-radius: 16px 16px 0 0;
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: 800;
            color: #2c3e50;
            margin-bottom: 8px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .stat-label {
            font-size: 14px;
            color: #7f8c8d;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .section-heading p {
            text-align: center;
            color: #7f8c8d;
            font-size: 18px;
            max-width: 600px;
            margin: 0 auto 30px;
            line-height: 1.6;
        }
        
        /* New layout for region and candidates */
        .region-candidates-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-top: 40px;
        }
        
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .region-candidates-container {
                grid-template-columns: 1fr;
            }
            
            .chart-wrapper {
                height: 200px;
            }
            
            .stat-number {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="container hero-content">
            <img src="../Images/Icons/Logo_wit.png" width="400px" height="auto" alt="Stem Commissie Logo">
            <h1>Verkiezings Dashboard</h1>
            <p>Een uitgebreid dashboard dat real-time stemmentelling en verkiezingsgegevens biedt voor het kiesdistrict Suriname</p>
            <a href="login.php" class="cta-button">Dashboard Openen</a>
        </div>
    </section>

    <section class="statistics">
        <div class="container">
            <div class="section-heading">
                <h2>Verkiezingsstatistieken</h2>
                <p>Real-time stemtelgegevens voor de huidige verkiezingscyclus</p>
            </div>
            
            <?php
include 'Includes/db.php';

// Check if database connection exists
if (!isset($suelect_conn) || !$suelect_conn) {
    die("Database connection failed");
}

// Get total votes with error handling
$total_votes_query = "SELECT SUM(aantal_stemmen) as total_votes FROM kandidaat";
$total_votes_result = $suelect_conn->query($total_votes_query);
$total_votes = 0;
if ($total_votes_result && $total_votes_result->num_rows > 0) {
    $row = $total_votes_result->fetch_assoc();
    $total_votes = $row['total_votes'] ?? 0;
}

// Get total number of candidates with error handling
$total_candidates_query = "SELECT COUNT(*) as total_candidates FROM kandidaat";
$total_candidates_result = $suelect_conn->query($total_candidates_query);
$total_candidates = 0;
if ($total_candidates_result && $total_candidates_result->num_rows > 0) {
    $row = $total_candidates_result->fetch_assoc();
    $total_candidates = $row['total_candidates'] ?? 0;
}

// Get total number of parties with error handling
$total_parties_query = "SELECT COUNT(DISTINCT partij_id) as total_parties FROM kandidaat WHERE partij_id IS NOT NULL";
$total_parties_result = $suelect_conn->query($total_parties_query);
$total_parties = 0;
if ($total_parties_result && $total_parties_result->num_rows > 0) {
    $row = $total_parties_result->fetch_assoc();
    $total_parties = $row['total_parties'] ?? 0;
}

// If no partij_id, try alternative approach
if ($total_parties == 0) {
    $total_parties_query = "SELECT COUNT(DISTINCT partij_naam) as total_parties FROM kandidaat WHERE partij_naam IS NOT NULL AND partij_naam != ''";
    $total_parties_result = $suelect_conn->query($total_parties_query);
    if ($total_parties_result && $total_parties_result->num_rows > 0) {
        $row = $total_parties_result->fetch_assoc();
        $total_parties = $row['total_parties'] ?? 5; // fallback
    } else {
        $total_parties = 5; // fallback
    }
}

// Get gender distribution of voters with error handling
$gender_query = "SELECT geslacht, COUNT(*) as count FROM gebruiker WHERE geslacht IS NOT NULL GROUP BY geslacht";
$gender_result = $suelect_conn->query($gender_query);
$gender_data = [];
if ($gender_result && $gender_result->num_rows > 0) {
    while ($row = $gender_result->fetch_assoc()) {
        $gender_data[$row['geslacht']] = $row['count'];
    }
}

// Get age distribution of voters with error handling
$age_query = "SELECT 
                CASE 
                    WHEN TIMESTAMPDIFF(YEAR, geboorte_datum, CURDATE()) BETWEEN 18 AND 24 THEN '18-24'
                    WHEN TIMESTAMPDIFF(YEAR, geboorte_datum, CURDATE()) BETWEEN 25 AND 34 THEN '25-34'
                    WHEN TIMESTAMPDIFF(YEAR, geboorte_datum, CURDATE()) BETWEEN 35 AND 44 THEN '35-44'
                    WHEN TIMESTAMPDIFF(YEAR, geboorte_datum, CURDATE()) BETWEEN 45 AND 54 THEN '45-54'
                    WHEN TIMESTAMPDIFF(YEAR, geboorte_datum, CURDATE()) BETWEEN 55 AND 64 THEN '55-64'
                    ELSE '65+'
                END as age_group,
                COUNT(*) as count
              FROM gebruiker
              WHERE geboorte_datum IS NOT NULL
              GROUP BY age_group";
$age_result = $suelect_conn->query($age_query);
$age_data = [];
if ($age_result && $age_result->num_rows > 0) {
    while ($row = $age_result->fetch_assoc()) {
        $age_data[$row['age_group']] = $row['count'];
    }
}

// Add default data if no age data exists
if (empty($age_data)) {
    $age_data = [
        '18-24' => 15,
        '25-34' => 25,
        '35-44' => 22,
        '45-54' => 18,
        '55-64' => 12,
        '65+' => 8
    ];
}

// Get party data from database with error handling
$party_query = "SELECT 
                p.afkorting as party_name,
                SUM(k.aantal_stemmen) as total_votes
              FROM kandidaat k
              JOIN partij p ON k.partij_id = p.partij_id
              GROUP BY p.afkorting
              ORDER BY total_votes DESC";
$party_result = $suelect_conn->query($party_query);
$party_data = [];
if ($party_result && $party_result->num_rows > 0) {
    while ($row = $party_result->fetch_assoc()) {
        $party_data[$row['party_name']] = intval($row['total_votes']);
    }
}

// Get top candidates from database with error handling
$candidates_query = "SELECT 
                    k.naam as candidate_name,
                    p.naam as party_name,
                    k.aantal_stemmen as votes,
                    k.foto_url
                  FROM kandidaat k
                  JOIN partij p ON k.partij_id = p.partij_id
                  WHERE k.aantal_stemmen > 0
                  ORDER BY k.aantal_stemmen DESC
                  LIMIT 3";
$candidates_result = $suelect_conn->query($candidates_query);
$top_candidates = [];
if ($candidates_result && $candidates_result->num_rows > 0) {
    while ($row = $candidates_result->fetch_assoc()) {
        // Shorten party names to just the acronym (text before parenthesis)
        $party_name = preg_replace('/\(([^)]+)\)/', '', $row['party_name']);
        $party_name = trim($party_name);
        
        $top_candidates[] = [
            'name' => $row['candidate_name'],
            'party' => $party_name,
            'votes' => intval($row['votes']),
            'photo' => $row['foto_url'] ?? '../Images/default-avatar.png'
        ];
    }
}

// Get regional data with error handling
$region_query = "SELECT 
                d.naam as region_name,
                COUNT(g.gebruiker_id) as voter_count
              FROM gebruiker g
              JOIN distrikt d ON g.distrikt_id = d.distrikt_id
              GROUP BY d.naam
              ORDER BY voter_count DESC";
$region_result = $suelect_conn->query($region_query);
$region_data = [];
if ($region_result && $region_result->num_rows > 0) {
    while ($row = $region_result->fetch_assoc()) {
        $region_data[$row['region_name']] = intval($row['voter_count']);
    }
}

// Optional: Add error logging
if ($suelect_conn->error) {
    error_log("Database error: " . $suelect_conn->error);
}
?>
            
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number"><?php echo number_format($total_votes); ?></div>
                    <div class="stat-label">Totaal Getelde Stemmen</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_parties; ?></div>
                    <div class="stat-label">Politieke Partijen</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo count($region_data); ?></div>
                    <div class="stat-label">Verkiezingsregio's</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number"><?php echo $total_candidates; ?></div>
                    <div class="stat-label">Kandidaten</div>
                </div>
            </div>
            
            <div class="dashboard-grid">
                <div class="chart-container">
                    <div class="chart-title">Stemverdeling per Partij</div>
                    <div class="chart-wrapper">
                        <canvas id="partyChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-title">Geslacht Verdeling Kiezers</div>
                    <div class="chart-wrapper">
                        <canvas id="genderChart"></canvas>
                    </div>
                </div>
                
                <div class="chart-container">
                    <div class="chart-title">Leeftijdsverdeling Kiezers</div>
                    <div class="chart-wrapper">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="region-candidates-container">
                <div class="chart-container">
                    <div class="chart-title">Stemmen per Regio</div>
                    <div class="chart-wrapper">
                        <canvas id="regionChart"></canvas>
                    </div>
                </div>
                
                <div class="top-candidates">
                    <div class="chart-title">Top Kandidaten</div>
                    <div class="candidates-grid">
                        <?php foreach ($top_candidates as $candidate): ?>
                            <div class="candidate-item">
                                <img src="<?php echo $candidate['photo']; ?>" alt="<?php echo $candidate['name']; ?>" class="candidate-photo">
                                <div class="candidate-info">
                                    <div class="candidate-name"><?php echo htmlspecialchars($candidate['name']); ?></div>
                                    <div class="candidate-party"><?php echo htmlspecialchars($candidate['party']); ?></div>
                                </div>
                                <div class="candidate-votes"><?php echo number_format($candidate['votes']); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features">
        <div class="container">
            <div class="section-heading">
                <h2>Platform Functies</h2>
                <p>Ontdek de krachtige tools beschikbaar in ons verkiezingsdashboard</p>
            </div>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-chart-bar"></i></div>
                    <h3 class="feature-title">Real-Time Analyse</h3>
                    <p class="feature-description">Directe stemregistratie en uitgebreide visualisatie van verkiezingsgegevens met dynamische updates.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <h3 class="feature-title">Regionale Uitsplitsing</h3>
                    <p class="feature-description">Gedetailleerde inzichten in de stemverdeling over alle districten in Jawa Barat Regio-1.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                    <h3 class="feature-title">Beveiligde Toegang</h3>
                    <p class="feature-description">Robuuste authenticatie en gegevensbescherming voor gevoelige verkiezingsinformatie.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <div class="section-heading">
                <h2>Maak Kennis Met Ons Team</h2>
                <p>De toegewijde professionals achter het Stemmen Telsysteem</p>
            </div>
            <div class="team-grid">
                <div class="team-member">
                    <img src="../Images/default-avatar.png" alt="Denzel Daal">
                    <div class="info">
                        <h3>Denzel Daal</h3>
                        <h4>Projectleider & Back-end Ontwikkelaar</h4>
                        <p>Ervaren projectmanager met expertise in database-architectuur en server-side ontwikkeling. Gespecialiseerd in het creëren van robuuste, schaalbare systemen voor verkiezingsgegevensbeheer.</p>
                        <div class="icons">
                            <a href="#" class="icon" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="#" class="icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="icon" title="Portfolio"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <img src="../Images/default-avatar.png" alt="Mighaisa Gau Gau">
                    <div class="info">
                        <h3>Mighaisa Gau Gau</h3>
                        <h4>Back-end Ontwikkelaar & Ontwerper</h4>
                        <p>Getalenteerde ontwikkelaar met een sterke achtergrond in gegevensvisualisatie en API-ontwikkeling. Combineert technische vaardigheden met ontwerpgevoeligheid om intuïtieve gebruikerservaringen te creëren.</p>
                        <div class="icons">
                            <a href="#" class="icon" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="#" class="icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="icon" title="Portfolio"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="team-member">
                    <img src="../Images/default-avatar.png" alt="Chivar Slijngard">
                    <div class="info">
                        <h3>Chivar Slijngard</h3>
                        <h4>Front-end Ontwikkelaar & Ontwerper</h4>
                        <p>Toegewijde ICT-student aan het NATIN, gespecialiseerd in webontwerp en ontwikkeling. Gepassioneerd over het creëren van aantrekkelijke gebruikersinterfaces en responsieve webapplicaties.</p>
                        <div class="icons">
                            <a href="#" class="icon" title="GitHub"><i class="fab fa-github"></i></a>
                            <a href="#" class="icon" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="icon" title="Portfolio"><i class="fas fa-globe"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="accountPopup" class="popup-overlay">
        <div class="popup-container">
            <button id="closePopup" class="popup-close">&times;</button>
            <img src="../Images/Icons/Logo.png" class="popup-logo" alt="Stem Commissie Logo">
            <h2 class="popup-title">Welkom bij Su.Elect</h2>
            <p class="popup-text">Heeft u al een account bij ons systeem?</p>
            <div class="popup-buttons">
                <button id="yesButton" class="popup-button btn-yes">Ja, ik heb een account</button>
                <button id="noButton" class="popup-button btn-no">Nee, nog niet</button>
            </div>
        </div>
    </div>
        
    <footer>
        <div class="footer-container">
            <div class="footer-column">
                <h3>Over Ons</h3>
                <p>Su.Elect biedt een uitgebreid overzichtelijk verkiezings dasboard.</p>
            </div>
            <div class="footer-column">
                <h3>Snelle Links</h3>
                <a href="#">Dashboard</a>
                <a href="#">Onze Diensten</a>
                <a href="#">Ons Team</a>
                <a href="#">Help</a>
            </div>
            <div class="footer-column">
                <h3>Verbind Met Ons</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            © 2025 Su.Elect. Alle rechten voorbehouden.
        </div>
    </footer>

    <script src="../JS/Script.js"></script>

    <script>
        // Enhanced chart configurations with better styling
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: {
                            size: 12,
                            family: "'Inter', sans-serif"
                        }
                    }
                }
            }
        };

        // Party Chart
        const partyCtx = document.getElementById('partyChart').getContext('2d');
        const partyChart = new Chart(partyCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_keys($party_data)); ?>,
                datasets: [{
                    label: 'Aantal Stemmen',
                    data: <?php echo json_encode(array_values($party_data)); ?>,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(118, 75, 162, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(118, 75, 162, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            lineWidth: 1
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            }
                        }
                    }
                }
            }
        });

        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode(array_keys($gender_data)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($gender_data)); ?>,
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 206, 86, 0.8)'
                    ],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                ...chartOptions,
                cutout: '60%',
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        ...chartOptions.plugins.legend,
                        position: 'right'
                    }
                }
            }
        });

        // Age Chart
        const ageCtx = document.getElementById('ageChart').getContext('2d');
        const ageChart = new Chart(ageCtx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($age_data)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($age_data)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 206, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(255, 159, 64, 0.8)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 8
                }]
            },
            options: {
                ...chartOptions,
                plugins: {
                    ...chartOptions.plugins,
                    legend: {
                        ...chartOptions.plugins.legend,
                        position: 'right'
                    }
                }
            }
        });

        // Region Chart
        const regionCtx = document.getElementById('regionChart').getContext('2d');
        const regionChart = new Chart(regionCtx, {
            type: 'polarArea',
            data: {
                labels: <?php echo json_encode(array_keys($region_data)); ?>,
                datasets: [{
                    data: <?php echo json_encode(array_values($region_data)); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(102, 126, 234, 0.7)',
                        'rgba(118, 75, 162, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(102, 126, 234, 1)',
                        'rgba(118, 75, 162, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                ...chartOptions,
                scales: {
                    r: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        },
                        pointLabels: {
                            font: {
                                size: 11
                            }
                        },
                        ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>