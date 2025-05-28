<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Stem Commissie - Stemmen Telsysteem</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="../CSS/Prev_dash.css">
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
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">2.432.766</div>
                    <div class="stat-label">Totaal Getelde Stemmen</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">10</div>
                    <div class="stat-label">Politieke Partijen</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">5</div>
                    <div class="stat-label">Verkiezingsregio's</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">127</div>
                    <div class="stat-label">Kandidaten</div>
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
</body>
</html>