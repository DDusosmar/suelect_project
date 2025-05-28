<?php
/**
 * SuElect - Voting System Functions
 * 
 * This file contains all helper functions for the SuElect voting system
 */

/**
 * Get database connection
 *
 * @return PDO Database connection
 */
function getConnection() {
    try {
        $conn = new PDO(
            "mysql:host=localhost;dbname=suelect_db;charset=utf8mb4", 
            "root", 
            "",
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $conn;
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}

/**
 * Get admin by ID
 * 
 * @param int $admin_id Admin ID
 * @return array|bool Admin data or false if not found
 */
function getAdminById($admin_id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM Admin WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->execute();
        $admin = $stmt->fetch();
        return $admin ? $admin : false;
    } catch (PDOException $e) {
        logError("Database error in getAdminById: " . $e->getMessage());
        return false;
    }
}

/**
 * Get admin by username
 * 
 * @param string $username Username
 * @return array|bool Admin data or false if not found
 */
function getAdminByUsername($username) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM Admin WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $admin = $stmt->fetch();
        return $admin ? $admin : false;
    } catch (PDOException $e) {
        logError("Database error in getAdminByUsername: " . $e->getMessage());
        return false;
    }
}

/**
 * Get user by ID
 * 
 * @param int $gebruiker_id User ID
 * @return array|bool User data or false if not found
 */
function getGebruikerById($gebruiker_id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM Gebruiker WHERE gebruiker_id = :gebruiker_id");
        $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $stmt->execute();
        $gebruiker = $stmt->fetch();
        return $gebruiker ? $gebruiker : false;
    } catch (PDOException $e) {
        logError("Database error in getGebruikerById: " . $e->getMessage());
        return false;
    }
}

/**
 * Get user by email
 * 
 * @param string $email User email
 * @return array|bool User data or false if not found
 */
function getGebruikerByEmail($email) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM Gebruiker WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $gebruiker = $stmt->fetch();
        return $gebruiker ? $gebruiker : false;
    } catch (PDOException $e) {
        logError("Database error in getGebruikerByEmail: " . $e->getMessage());
        return false;
    }
}

/**
 * Get user by ID number
 * 
 * @param string $id_nummer ID number
 * @return array|bool User data or false if not found
 */
function getGebruikerByIdNummer($id_nummer) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("SELECT * FROM Gebruiker WHERE id_nummer = :id_nummer");
        $stmt->bindParam(':id_nummer', $id_nummer);
        $stmt->execute();
        $gebruiker = $stmt->fetch();
        return $gebruiker ? $gebruiker : false;
    } catch (PDOException $e) {
        logError("Database error in getGebruikerByIdNummer: " . $e->getMessage());
        return false;
    }
}

/**
 * Log admin login attempt
 * 
 * @param PDO $conn Database connection
 * @param int|null $admin_id Admin ID or null if no admin found
 * @param string $username Attempted username
 * @param bool $success Whether login was successful
 * @return bool Whether log was successful
 */
function logAdminLoginAttempt($conn, $admin_id, $username, $success) {
    try {
        $stmt = $conn->prepare("INSERT INTO AdminInlogpogingen (admin_id, username, succes, poging_datum) 
                               VALUES (:admin_id, :username, :succes, CURRENT_TIMESTAMP)");
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':succes', $success, PDO::PARAM_BOOL);
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in logAdminLoginAttempt: " . $e->getMessage());
        return false;
    }
}

/**
 * Log user login attempt
 * 
 * @param PDO $conn Database connection
 * @param int|null $gebruiker_id User ID or null if no user found
 * @param bool $success Whether login was successful
 * @return bool Whether log was successful
 */
function logUserLoginAttempt($conn, $gebruiker_id, $success) {
    try {
        $stmt = $conn->prepare("INSERT INTO Inlogpogingen (gebruiker_id, succes, poging_datum) 
                               VALUES (:gebruiker_id, :succes, CURRENT_TIMESTAMP)");
        $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $stmt->bindParam(':succes', $success, PDO::PARAM_BOOL);
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in logUserLoginAttempt: " . $e->getMessage());
        return false;
    }
}

/**
 * Update admin last login time
 * 
 * @param int $admin_id Admin ID
 * @return bool Whether update was successful
 */
function updateAdminLastLogin($admin_id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE Admin SET laatste_login = CURRENT_TIMESTAMP WHERE admin_id = :admin_id");
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateAdminLastLogin: " . $e->getMessage());
        return false;
    }
}

/**
 * Update user last login time
 * 
 * @param int $gebruiker_id User ID
 * @return bool Whether update was successful
 */
function updateUserLastLogin($gebruiker_id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE Gebruiker SET laatste_login = CURRENT_TIMESTAMP WHERE gebruiker_id = :gebruiker_id");
        $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateUserLastLogin: " . $e->getMessage());
        return false;
    }
}

/**
 * Get count of total rows in a table
 * 
 * @param PDO $conn Database connection
 * @param string $table Table name
 * @return int Row count
 */
function getRowCount($conn, $table) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM $table");
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['count'];
    } catch (PDOException $e) {
        logError("Database error in getRowCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get count of users who have voted
 * 
 * @param PDO $conn Database connection
 * @return int Count of users who have voted
 */
function getVotedCount($conn) {
    try {
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM Gebruiker WHERE gestemd = TRUE");
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['count'];
    } catch (PDOException $e) {
        logError("Database error in getVotedCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get recent votes with candidate, party and district info
 * 
 * @param PDO $conn Database connection
 * @param int $limit Number of votes to return
 * @return array Recent votes
 */
function getRecentVotes($conn, $limit = 10) {
    try {
        $stmt = $conn->prepare("
            SELECT s.stem_id, s.gebruiker_id, s.kandidaat_id, s.gestemd_op,
                   k.naam as kandidaat_naam, p.naam as partij_naam, d.naam as distrikt_naam
            FROM Stem s
            JOIN Kandidaat k ON s.kandidaat_id = k.kandidaat_id
            JOIN Partij p ON k.partij_id = p.partij_id
            JOIN Distrikt d ON k.distrikt_id = d.distrikt_id
            ORDER BY s.gestemd_op DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getRecentVotes: " . $e->getMessage());
        return [];
    }
}

/**
 * Get top candidates by votes
 * 
 * @param PDO $conn Database connection
 * @param int $limit Number of candidates to return
 * @return array Top candidates
 */
function getTopCandidates($conn, $limit = 5) {
    try {
        $stmt = $conn->prepare("
            SELECT k.kandidaat_id, k.naam, k.aantal_stemmen,
                   p.naam as partij_naam, d.naam as distrikt_naam
            FROM Kandidaat k
            JOIN Partij p ON k.partij_id = p.partij_id
            JOIN Distrikt d ON k.distrikt_id = d.distrikt_id
            ORDER BY k.aantal_stemmen DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getTopCandidates: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all parties
 * 
 * @return array List of parties
 */
function getAllPartijen() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("SELECT * FROM Partij ORDER BY naam");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAllPartijen: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all districts
 * 
 * @return array List of districts
 */
function getAllDistrikten() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("SELECT * FROM Distrikt ORDER BY naam");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAllDistrikten: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all candidates with party and district info
 * 
 * @return array List of candidates
 */
function getAllKandidaten() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("
            SELECT k.*, p.naam as partij_naam, d.naam as distrikt_naam 
            FROM Kandidaat k
            JOIN Partij p ON k.partij_id = p.partij_id
            JOIN Distrikt d ON k.distrikt_id = d.distrikt_id
            ORDER BY k.naam
        ");
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAllKandidaten: " . $e->getMessage());
        return [];
    }
}

/**
 * Get candidates by district
 * 
 * @param int $distrikt_id District ID
 * @return array Candidates in the district
 */
function getKandidatenByDistrikt($distrikt_id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT k.*, p.naam as partij_naam 
            FROM Kandidaat k
            JOIN Partij p ON k.partij_id = p.partij_id
            WHERE k.distrikt_id = :distrikt_id
            ORDER BY k.naam
        ");
        $stmt->bindParam(':distrikt_id', $distrikt_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getKandidatenByDistrikt: " . $e->getMessage());
        return [];
    }
}

/**
 * Create new user
 * 
 * @param array $data User data
 * @return int|bool New user ID or false on failure
 */
function createGebruiker($data) {
    try {
        $conn = getConnection();
        
        // Hash password
        $hashed_password = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("
            INSERT INTO Gebruiker (voornaam, achternaam, id_nummer, wachtwoord, email, geboorte_datum)
            VALUES (:voornaam, :achternaam, :id_nummer, :wachtwoord, :email, :geboorte_datum)
        ");
        
        $stmt->bindParam(':voornaam', $data['voornaam']);
        $stmt->bindParam(':achternaam', $data['achternaam']);
        $stmt->bindParam(':id_nummer', $data['id_nummer']);
        $stmt->bindParam(':wachtwoord', $hashed_password);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':geboorte_datum', $data['geboorte_datum']);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        logError("Database error in createGebruiker: " . $e->getMessage());
        return false;
    }
}

/**
 * Update user data
 * 
 * @param int $gebruiker_id User ID
 * @param array $data Updated user data
 * @return bool Whether update was successful
 */
function updateGebruiker($gebruiker_id, $data) {
    try {
        $conn = getConnection();
        
        $sql = "UPDATE Gebruiker SET voornaam = :voornaam, achternaam = :achternaam, 
                email = :email, geboorte_datum = :geboorte_datum";
        
        // Only update password if provided
        if (!empty($data['wachtwoord'])) {
            $sql .= ", wachtwoord = :wachtwoord";
        }
        
        $sql .= " WHERE gebruiker_id = :gebruiker_id";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':voornaam', $data['voornaam']);
        $stmt->bindParam(':achternaam', $data['achternaam']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':geboorte_datum', $data['geboorte_datum']);
        $stmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        
        if (!empty($data['wachtwoord'])) {
            $hashed_password = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
            $stmt->bindParam(':wachtwoord', $hashed_password);
        }
        
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateGebruiker: " . $e->getMessage());
        return false;
    }
}

/**
 * Create new candidate
 * 
 * @param array $data Candidate data
 * @return int|bool New candidate ID or false on failure
 */
function createKandidaat($data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            INSERT INTO Kandidaat (naam, partij_id, distrikt_id, type, bio, foto_url)
            VALUES (:naam, :partij_id, :distrikt_id, :type, :bio, :foto_url)
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':partij_id', $data['partij_id'], PDO::PARAM_INT);
        $stmt->bindParam(':distrikt_id', $data['distrikt_id'], PDO::PARAM_INT);
        $stmt->bindParam(':type', $data['type'], PDO::PARAM_INT);
        $stmt->bindParam(':bio', $data['bio']);
        $stmt->bindParam(':foto_url', $data['foto_url']);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        logError("Database error in createKandidaat: " . $e->getMessage());
        return false;
    }
}

/**
 * Update candidate data
 * 
 * @param int $kandidaat_id Candidate ID
 * @param array $data Updated candidate data
 * @return bool Whether update was successful
 */
function updateKandidaat($kandidaat_id, $data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            UPDATE Kandidaat 
            SET naam = :naam, partij_id = :partij_id, distrikt_id = :distrikt_id,
                type = :type, bio = :bio, foto_url = :foto_url
            WHERE kandidaat_id = :kandidaat_id
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':partij_id', $data['partij_id'], PDO::PARAM_INT);
        $stmt->bindParam(':distrikt_id', $data['distrikt_id'], PDO::PARAM_INT);
        $stmt->bindParam(':type', $data['type'], PDO::PARAM_INT);
        $stmt->bindParam(':bio', $data['bio']);
        $stmt->bindParam(':foto_url', $data['foto_url']);
        $stmt->bindParam(':kandidaat_id', $kandidaat_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateKandidaat: " . $e->getMessage());
        return false;
    }
}

/**
 * Create new party
 * 
 * @param array $data Party data
 * @return int|bool New party ID or false on failure
 */
function createPartij($data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            INSERT INTO Partij (naam, logo_url, beschrijving)
            VALUES (:naam, :logo_url, :beschrijving)
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':logo_url', $data['logo_url']);
        $stmt->bindParam(':beschrijving', $data['beschrijving']);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        logError("Database error in createPartij: " . $e->getMessage());
        return false;
    }
}

/**
 * Update party data
 * 
 * @param int $partij_id Party ID
 * @param array $data Updated party data
 * @return bool Whether update was successful
 */
function updatePartij($partij_id, $data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            UPDATE Partij 
            SET naam = :naam, logo_url = :logo_url, beschrijving = :beschrijving
            WHERE partij_id = :partij_id
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':logo_url', $data['logo_url']);
        $stmt->bindParam(':beschrijving', $data['beschrijving']);
        $stmt->bindParam(':partij_id', $partij_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updatePartij: " . $e->getMessage());
        return false;
    }
}

/**
 * Create new district
 * 
 * @param array $data District data
 * @return int|bool New district ID or false on failure
 */
function createDistrikt($data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            INSERT INTO Distrikt (naam, aantal_zetels)
            VALUES (:naam, :aantal_zetels)
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':aantal_zetels', $data['aantal_zetels'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        logError("Database error in createDistrikt: " . $e->getMessage());
        return false;
    }
}

/**
 * Update district data
 * 
 * @param int $distrikt_id District ID
 * @param array $data Updated district data
 * @return bool Whether update was successful
 */
function updateDistrikt($distrikt_id, $data) {
    try {
        $conn = getConnection();
        
        $stmt = $conn->prepare("
            UPDATE Distrikt 
            SET naam = :naam, aantal_zetels = :aantal_zetels
            WHERE distrikt_id = :distrikt_id
        ");
        
        $stmt->bindParam(':naam', $data['naam']);
        $stmt->bindParam(':aantal_zetels', $data['aantal_zetels'], PDO::PARAM_INT);
        $stmt->bindParam(':distrikt_id', $distrikt_id, PDO::PARAM_INT);
        
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateDistrikt: " . $e->getMessage());
        return false;
    }
}

/**
 * Record a vote
 * 
 * @param int $gebruiker_id User ID
 * @param int $kandidaat_id Candidate ID
 * @return bool Whether vote was recorded successfully
 */
function recordVote($gebruiker_id, $kandidaat_id) {
    try {
        $conn = getConnection();
        
        // Start transaction
        $conn->beginTransaction();
        
        // Check if user has already voted
        $checkStmt = $conn->prepare("SELECT gestemd FROM Gebruiker WHERE gebruiker_id = :gebruiker_id");
        $checkStmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $checkStmt->execute();
        $user = $checkStmt->fetch();
        
        if ($user && $user['gestemd']) {
            // User has already voted
            $conn->rollBack();
            return false;
        }
        
        // Record the vote
        $voteStmt = $conn->prepare("
            INSERT INTO Stem (gebruiker_id, kandidaat_id)
            VALUES (:gebruiker_id, :kandidaat_id)
        ");
        $voteStmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $voteStmt->bindParam(':kandidaat_id', $kandidaat_id, PDO::PARAM_INT);
        $voteStmt->execute();
        
        // Update user's voted status
        $updateUserStmt = $conn->prepare("
            UPDATE Gebruiker SET gestemd = TRUE WHERE gebruiker_id = :gebruiker_id
        ");
        $updateUserStmt->bindParam(':gebruiker_id', $gebruiker_id, PDO::PARAM_INT);
        $updateUserStmt->execute();
        
        // Increment candidate's vote count
        $updateCandidateStmt = $conn->prepare("
            UPDATE Kandidaat SET aantal_stemmen = aantal_stemmen + 1 WHERE kandidaat_id = :kandidaat_id
        ");
        $updateCandidateStmt->bindParam(':kandidaat_id', $kandidaat_id, PDO::PARAM_INT);
        $updateCandidateStmt->execute();
        
        // Commit transaction
        $conn->commit();
        
        return true;
    } catch (PDOException $e) {
        if ($conn) {
            $conn->rollBack();
        }
        logError("Database error in recordVote: " . $e->getMessage());
        return false;
    }
}

/**
 * Get voting results by district
 * 
 * @return array Results by district
 */
function getResultsByDistrikt() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("
            SELECT d.distrikt_id, d.naam as distrikt_naam, d.aantal_zetels,
                   k.kandidaat_id, k.naam as kandidaat_naam, k.aantal_stemmen,
                   p.partij_id, p.naam as partij_naam
            FROM Distrikt d
            JOIN Kandidaat k ON d.distrikt_id = k.distrikt_id
            JOIN Partij p ON k.partij_id = p.partij_id
            ORDER BY d.naam, k.aantal_stemmen DESC
        ");
        
        $results = [];
        while ($row = $stmt->fetch()) {
            $distrikt_id = $row['distrikt_id'];
            if (!isset($results[$distrikt_id])) {
                $results[$distrikt_id] = [
                    'distrikt_id' => $distrikt_id,
                    'distrikt_naam' => $row['distrikt_naam'],
                    'aantal_zetels' => $row['aantal_zetels'],
                    'kandidaten' => []
                ];
            }
            
            $results[$distrikt_id]['kandidaten'][] = [
                'kandidaat_id' => $row['kandidaat_id'],
                'kandidaat_naam' => $row['kandidaat_naam'],
                'aantal_stemmen' => $row['aantal_stemmen'],
                'partij_id' => $row['partij_id'],
                'partij_naam' => $row['partij_naam']
            ];
        }
        
        return $results;
    } catch (PDOException $e) {
        logError("Database error in getResultsByDistrikt: " . $e->getMessage());
        return [];
    }
}

/**
 * Get voting results by party
 * 
 * @return array Results by party
 */
function getResultsByPartij() {
    try {
        $conn = getConnection();
        $stmt = $conn->query("
            SELECT p.partij_id, p.naam as partij_naam, 
                   SUM(k.aantal_stemmen) as totaal_stemmen,
                   COUNT(k.kandidaat_id) as aantal_kandidaten
            FROM Partij p
            JOIN Kandidaat k ON p.partij_id = k.partij_id
            GROUP BY p.partij_id
            ORDER BY totaal_stemmen DESC
        ");
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getResultsByPartij: " . $e->getMessage());
        return [];
    }
}

/**
 * Get login activity for users
 * 
 * @param int $days Number of days to look back
 * @return array Login activity data
 */
function getUserLoginActivity($days = 7) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT DATE(poging_datum) as datum, 
                   COUNT(*) as totaal_pogingen,
                   SUM(CASE WHEN succes = TRUE THEN 1 ELSE 0 END) as succesvolle_pogingen
            FROM Inlogpogingen
            WHERE poging_datum >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)
            GROUP BY DATE(poging_datum)
            ORDER BY datum
        ");
        $stmt->bindParam(':days', $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getUserLoginActivity: " . $e->getMessage());
        return [];
    }
}

/**
 * Get admin login activity
 * 
 * @param int $days Number of days to look back
 * @return array Login activity data
 */
function getAdminLoginActivity($days = 7) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT DATE(poging_datum) as datum, 
                   COUNT(*) as totaal_pogingen,
                   SUM(CASE WHEN succes = TRUE THEN 1 ELSE 0 END) as succesvolle_pogingen
            FROM AdminInlogpogingen
            WHERE poging_datum >= DATE_SUB(CURRENT_DATE, INTERVAL :days DAY)
            GROUP BY DATE(poging_datum)
            ORDER BY datum
        ");
        $stmt->bindParam(':days', $days, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAdminLoginActivity: " . $e->getMessage());
        return [];
    }
}

/**
 * Create new admin user
 * 
 * @param array $data Admin data
 * @return int|bool New admin ID or false on failure
 */
function createAdmin($data) {
    try {
        $conn = getConnection();
        
        // Hash password
        $hashed_password = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
        
        $stmt = $conn->prepare("
            INSERT INTO Admin (username, wachtwoord, email, volledige_naam, is_actief)
            VALUES (:username, :wachtwoord, :email, :volledige_naam, :is_actief)
        ");
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':wachtwoord', $hashed_password);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':volledige_naam', $data['volledige_naam']);
        $stmt->bindParam(':is_actief', $data['is_actief'], PDO::PARAM_BOOL);
        
        if ($stmt->execute()) {
            return $conn->lastInsertId();
        }
        return false;
    } catch (PDOException $e) {
        logError("Database error in createAdmin: " . $e->getMessage());
        return false;
    }
}

/**
 * Update admin data
 * 
 * @param int $admin_id Admin ID
 * @param array $data Updated admin data
 * @return bool Whether update was successful
 */
function updateAdmin($admin_id, $data) {
    try {
        $conn = getConnection();
        
        $sql = "UPDATE Admin SET username = :username, email = :email, 
                volledige_naam = :volledige_naam, is_actief = :is_actief";
        
        // Only update password if provided
        if (!empty($data['wachtwoord'])) {
            $sql .= ", wachtwoord = :wachtwoord";
        }
        
        $sql .= " WHERE admin_id = :admin_id";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':volledige_naam', $data['volledige_naam']);
        $stmt->bindParam(':is_actief', $data['is_actief'], PDO::PARAM_BOOL);
        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
        
        if (!empty($data['wachtwoord'])) {
            $hashed_password = password_hash($data['wachtwoord'], PASSWORD_DEFAULT);
            $stmt->bindParam(':wachtwoord', $hashed_password);
        }
        
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in updateAdmin: " . $e->getMessage());
        return false;
    }
}

/**
 * Delete a record from a table
 * 
 * @param string $table Table name
 * @param string $id_column ID column name
 * @param int $id Record ID
 * @return bool Whether deletion was successful
 */
function deleteRecord($table, $id_column, $id) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("DELETE FROM $table WHERE $id_column = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    } catch (PDOException $e) {
        logError("Database error in deleteRecord: " . $e->getMessage());
        return false;
    }
}

/**
 * Get all login attempts (for admin view)
 * 
 * @param int $limit Number of records to return
 * @param int $offset Offset for pagination
 * @return array Login attempts
 */
function getAllLoginAttempts($limit = 100, $offset = 0) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT i.poging_id, i.gebruiker_id, i.succes, i.poging_datum, 
                   CONCAT(g.voornaam, ' ', g.achternaam) as gebruiker_naam
            FROM Inlogpogingen i
            LEFT JOIN Gebruiker g ON i.gebruiker_id = g.gebruiker_id
            ORDER BY i.poging_datum DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAllLoginAttempts: " . $e->getMessage());
        return [];
    }
}

/**
 * Get all admin login attempts (for admin view)
 * 
 * @param int $limit Number of records to return
 * @param int $offset Offset for pagination
 * @return array Admin login attempts
 */
function getAllAdminLoginAttempts($limit = 100, $offset = 0) {
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT a.poging_id, a.admin_id, a.username, a.succes, a.poging_datum,
                   ad.volledige_naam as admin_naam
            FROM AdminInlogpogingen a
            LEFT JOIN Admin ad ON a.admin_id = ad.admin_id
            ORDER BY a.poging_datum DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getAllAdminLoginAttempts: " . $e->getMessage());
        return [];
    }
}

/**
 * Get paginated list of users
 * 
 * @param int $limit Number of records per page
 * @param int $offset Offset for pagination
 * @param string $search Search term (optional)
 * @return array Users
 */
function getPaginatedGebruikers($limit = 20, $offset = 0, $search = '') {
    try {
        $conn = getConnection();
        
        $sql = "SELECT * FROM Gebruiker";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE voornaam LIKE :search OR achternaam LIKE :search OR email LIKE :search OR id_nummer LIKE :search";
            $searchTerm = "%$search%";
            $params[':search'] = $searchTerm;
        }
        
        $sql .= " ORDER BY achternaam, voornaam LIMIT :limit OFFSET :offset";
        $params[':limit'] = $limit;
        $params[':offset'] = $offset;
        
        $stmt = $conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            if ($key == ':limit' || $key == ':offset') {
                $stmt->bindValue($key, $value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue($key, $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    } catch (PDOException $e) {
        logError("Database error in getPaginatedGebruikers: " . $e->getMessage());
        return [];
    }
}

/**
 * Count total users (for pagination)
 * 
 * @param string $search Search term (optional)
 * @return int Total count
 */
function countGebruikers($search = '') {
    try {
        $conn = getConnection();
        
        $sql = "SELECT COUNT(*) as count FROM Gebruiker";
        $params = [];
        
        if (!empty($search)) {
            $sql .= " WHERE voornaam LIKE :search OR achternaam LIKE :search OR email LIKE :search OR id_nummer LIKE :search";
            $searchTerm = "%$search%";
            $params[':search'] = $searchTerm;
        }
        
        $stmt = $conn->prepare($sql);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        $stmt->execute();
        $result = $stmt->fetch();
        return (int) $result['count'];
    } catch (PDOException $e) {
        logError("Database error in countGebruikers: " . $e->getMessage());
        return 0;
    }
}

/**
 * Format date and time in Dutch format
 * 
 * @param string $dateTime Date and time string
 * @param bool $includeTime Whether to include time
 * @return string Formatted date and time
 */
function formatDateTime($dateTime, $includeTime = true) {
    if (empty($dateTime)) {
        return '';
    }
    
    $date = new DateTime($dateTime);
    if ($includeTime) {
        return $date->format('d-m-Y H:i:s');
    } else {
        return $date->format('d-m-Y');
    }
}

/**
 * Format date in Dutch format
 * 
 * @param string $date Date string
 * @return string Formatted date
 */
function formatDate($date) {
    if (empty($date)) {
        return '';
    }
    
    $date = new DateTime($date);
    return $date->format('d-m-Y');
}

/**
 * Calculate age from birthdate
 * 
 * @param string $birthdate Birthdate
 * @return int Age
 */
function calculateAge($birthdate) {
    $birth = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birth->diff($today)->y;
    return $age;
}

/**
 * Sanitize input to prevent XSS
 * 
 * @param string $input Input string
 * @return string Sanitized string
 */
function sanitizeInput($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

/**
 * Validate email address
 * 
 * @param string $email Email address
 * @return bool Whether email is valid
 */
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate date format
 * 
 * @param string $date Date string
 * @param string $format Date format
 * @return bool Whether date is valid
 */
function isValidDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

/**
 * Log error message
 * 
 * @param string $message Error message
 * @return void
 */
function logError($message) {
    $logFile = __DIR__ . '/../logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message" . PHP_EOL;
    
    // Make sure logs directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    // Append to log file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

/**
 * Log admin activity
 * 
 * @param int $admin_id Admin ID
 * @param string $action Action performed
 * @param string $details Additional details
 * @return void
 */
function logAdminActivity($admin_id, $action, $details = '') {
    $logFile = __DIR__ . '/../logs/admin_activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] Admin ID: $admin_id, Action: $action, Details: $details" . PHP_EOL;
    
    // Make sure logs directory exists
    $logDir = dirname($logFile);
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    // Append to log file
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

/**
 * Export data to CSV
 * 
 * @param array $data Data to export
 * @param string $filename Filename
 * @return bool Whether export was successful
 */
function exportToCsv($data, $filename) {
    if (empty($data)) {
        return false;
    }
    
    try {
        $output = fopen('php://output', 'w');
        
        // Set headers for download
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        // Add headers row
        fputcsv($output, array_keys(reset($data)));
        
        // Add data rows
        foreach ($data as $row) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        return true;
    } catch (Exception $e) {
        logError("Error exporting CSV: " . $e->getMessage());
        return false;
    }
}
