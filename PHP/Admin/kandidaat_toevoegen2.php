<?php
global $suelect_conn;
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../Includes/db.php';

// Variabelen voor feedback
$success = $error = "";

// Verwerk formulierinvoer
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actie'])) {
        if ($_POST['actie'] === 'toevoegen') {
            // Toevoegen
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $partij_id = (int)$_POST['partij_id'];
            $distrikt_id = (int)$_POST['distrikt_id'];
            $type = (int)$_POST['type'];
            $bio = $suelect_conn->real_escape_string($_POST['bio']);
            $foto_url = $suelect_conn->real_escape_string($_POST['foto_url']);

            $stmt = $suelect_conn->prepare("INSERT INTO kandidaat (naam, partij_id, distrikt_id, aantal_stemmen, type, bio, foto_url) VALUES (?, ?, ?, 0, ?, ?, ?)");
            $stmt->bind_param("ssssss", $naam, $partij_id, $distrikt_id, $type, $bio, $foto_url);
            if ($stmt->execute()) {
                $success = "Kandidaat succesvol toegevoegd!";
            } else {
                $error = "Fout bij toevoegen: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($_POST['actie'] === 'bewerken') {
            // Bewerken
            $kandidaat_id = (int)$_POST['kandidaat_id'];
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $partij_id = (int)$_POST['partij_id'];
            $distrikt_id = (int)$_POST['distrikt_id'];
            $type = (int)$_POST['type'];
            $bio = $suelect_conn->real_escape_string($_POST['bio']);
            $foto_url = $suelect_conn->real_escape_string($_POST['foto_url']);

            $stmt = $suelect_conn->prepare("UPDATE kandidaat SET naam=?, partij_id=?, distrikt_id=?, type=?, bio=?, foto_url=? WHERE kandidaat_id=?");
            $stmt->bind_param("ssssssi", $naam, $partij_id, $distrikt_id, $type, $bio, $foto_url, $kandidaat_id);
            if ($stmt->execute()) {
                $success = "Kandidaat succesvol bijgewerkt!";
            } else {
                $error = "Fout bij bijwerken: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($_POST['actie'] === 'verwijderen') {
            // Verwijderen
            $kandidaat_id = (int)$_POST['kandidaat_id'];
            $stmt = $suelect_conn->prepare("DELETE FROM kandidaat WHERE kandidaat_id=?");
            $stmt->bind_param("i", $kandidaat_id);
            if ($stmt->execute()) {
                $success = "Kandidaat succesvol verwijderd!";
            } else {
                $error = "Fout bij verwijderen: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Kandidaten Beheren</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        input, textarea, select, button { display: block; margin-bottom: 10px; width: 300px; padding: 5px; }
        label { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>

<h2>Kandidaten Beheren</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php elseif ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<!-- Toevoegen -->
<h3>Voeg Nieuwe Kandidaat Toe</h3>
<form method="POST" action="">
    <input type="hidden" name="actie" value="toevoegen">
    <label for="naam">Naam:</label>
    <input type="text" name="naam" required>
    <label for="partij_id">Partij:</label>
    <select name="partij_id" required>
        <?php
        $res = $suelect_conn->query("SELECT partij_id, naam FROM partij");
        while ($row = $res->fetch_assoc()) {
            echo "<option value='{$row['partij_id']}'>{$row['naam']}</option>";
        }
        ?>
    </select>
    <label for="distrikt_id">Distrikt:</label>
    <select name="distrikt_id" required>
        <?php
        $res = $suelect_conn->query("SELECT distrikt_id, naam FROM distrikt");
        while ($row = $res->fetch_assoc()) {
            echo "<option value='{$row['distrikt_id']}'>{$row['naam']}</option>";
        }
        ?>
    </select>
    <label for="type">Type:</label>
    <input type="number" name="type" required>
    <label for="bio">Biografie (optioneel):</label>
    <textarea name="bio"></textarea>
    <label for="foto_url">Foto URL (optioneel):</label>
    <input type="url" name="foto_url">
    <button type="submit">Voeg Kandidaat Toe</button>
</form>

<!-- Lijst -->
<h3>Huidige Kandidaten</h3>
<table>
    <tr>
        <th>ID</th><th>Naam</th><th>Partij</th><th>Distrikt</th><th>Type</th><th>Bewerk/Verwijder</th>
    </tr>
    <?php
    $result = $suelect_conn->query("SELECT k.kandidaat_id, k.naam, p.naam AS partij, d.naam AS distrikt, k.type 
                            FROM kandidaat k
                            JOIN partij p ON k.partij_id = p.partij_id
                            JOIN distrikt d ON k.distrikt_id = d.distrikt_id");
    while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['kandidaat_id'] ?></td>
            <td><?= $row['naam'] ?></td>
            <td><?= $row['partij'] ?></td>
            <td><?= $row['distrikt'] ?></td>
            <td><?= $row['type'] ?></td>
            <td>
                <!-- Bewerk Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="actie" value="bewerken">
                    <input type="hidden" name="kandidaat_id" value="<?= $row['kandidaat_id'] ?>">
                    <input type="text" name="naam" value="<?= $row['naam'] ?>" required>
                    <select name="partij_id" required>
                        <?php
                        $parts = $suelect_conn->query("SELECT partij_id, naam FROM partij");
                        while ($p = $parts->fetch_assoc()) {
                            $sel = ($p['partij_id'] == $row['partij_id']) ? 'selected' : '';
                            echo "<option value='{$p['partij_id']}' $sel>{$p['naam']}</option>";
                        }
                        ?>
                    </select>
                    <select name="distrikt_id" required>
                        <?php
                        $dists = $suelect_conn->query("SELECT distrikt_id, naam FROM distrikt");
                        while ($d = $dists->fetch_assoc()) {
                            $sel = ($d['distrikt_id'] == $row['distrikt_id']) ? 'selected' : '';
                            echo "<option value='{$d['distrikt_id']}' $sel>{$d['naam']}</option>";
                        }
                        ?>
                    </select>
                    <input type="number" name="type" value="<?= $row['type'] ?>" required>
                    <button type="submit">Bewerk</button>
                </form>

                <!-- Verwijder Form -->
                <form method="POST" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je deze kandidaat wilt verwijderen?');">
                    <input type="hidden" name="actie" value="verwijderen">
                    <input type="hidden" name="kandidaat_id" value="<?= $row['kandidaat_id'] ?>">
                    <button type="submit">Verwijder</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin_dash_test.php">Terug naar dashboard</a></p>

</body>
</html>