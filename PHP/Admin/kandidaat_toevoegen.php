<?php
global $suelect_conn;
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../Includes/db.php';
$success = $error = "";
$type = isset($_POST['type']) ? $_POST['type'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actie'])) {
        if ($_POST['actie'] === 'toevoegen') {
            // Toevoegen
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $type = (int)$_POST['type'];
            $bio = $suelect_conn->real_escape_string($_POST['bio']);
            $foto_url = $suelect_conn->real_escape_string($_POST['foto_url']);
            $partij_id = isset($_POST['partij_id']) ? (int)$_POST['partij_id'] : null;
            $ressort_id = isset($_POST['ressort_id']) ? (int)$_POST['ressort_id'] : null;

            // RR -> ressort, DNA -> partij
            if ($type == 1 && !$partij_id) {
                $error = "Selecteer een partij voor DNA-type.";
            } elseif ($type == 0 && !$ressort_id) {
                $error = "Selecteer een ressort voor RR-type.";
            }

            if (!$error) {
                // Bepaal distrikt_id via ressort als type = RR
                $distrikt_id = null;
                if ($ressort_id) {
                    $r = $suelect_conn->query("SELECT distrikt_id FROM ressort WHERE ressort_id = $ressort_id LIMIT 1");
                    $row = $r->fetch_assoc();
                    $distrikt_id = $row['distrikt_id'];
                }

                $stmt = $suelect_conn->prepare("INSERT INTO kandidaat (naam, partij_id, distrikt_id, ressort_id, type, bio, foto_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssiiisss", $naam, $partij_id, $distrikt_id, $ressort_id, $type, $bio, $foto_url);
                if ($stmt->execute()) {
                    $success = "Kandidaat succesvol toegevoegd!";
                } else {
                    $error = "Fout bij toevoegen: " . $stmt->error;
                }
                $stmt->close();
            }

        } elseif ($_POST['actie'] === 'bewerken') {
            // Bewerken
            $kandidaat_id = (int)$_POST['kandidaat_id'];
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $type = (int)$_POST['type'];
            $bio = $suelect_conn->real_escape_string($_POST['bio']);
            $foto_url = $suelect_conn->real_escape_string($_POST['foto_url']);
            $partij_id = isset($_POST['partij_id']) ? (int)$_POST['partij_id'] : null;
            $ressort_id = isset($_POST['ressort_id']) ? (int)$_POST['ressort_id'] : null;

            // Bepaal distrikt_id via ressort
            $distrikt_id = null;
            if ($ressort_id) {
                $r = $suelect_conn->query("SELECT distrikt_id FROM ressort WHERE ressort_id = $ressort_id LIMIT 1");
                $row = $r->fetch_assoc();
                $distrikt_id = $row['distrikt_id'];
            }

            $stmt = $suelect_conn->prepare("UPDATE kandidaat SET naam=?, partij_id=?, distrikt_id=?, ressort_id=?, type=?, bio=?, foto_url=? WHERE kandidaat_id=?");
            $stmt->bind_param("ssiiisssi", $naam, $partij_id, $distrikt_id, $ressort_id, $type, $bio, $foto_url, $kandidaat_id);
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
        .hidden { display: none; }
    </style>
    <script>
        function toggleFields() {
            const type = document.querySelector('select[name="type"]').value;
            document.getElementById('partijFields').classList.toggle('hidden', type != 1);
            document.getElementById('ressortFields').classList.toggle('hidden', type != 0);
        }
    </script>
</head>
<body>

<h2>Kandidaten Beheren</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php elseif ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<!-- Filter & Toevoegen -->
<h3>Nieuwe Kandidaat Toevoegen</h3>
<form method="POST" action="" onsubmit="return validateForm()">
    <input type="hidden" name="actie" value="toevoegen">

    <label for="type">Type:</label>
    <select name="type" onchange="toggleFields()" required>
        <option value="">-- Selecteer Type --</option>
        <option value="0" <?= $type == '0' ? 'selected' : '' ?>>RR (Ressortrepresentant)</option>
        <option value="1" <?= $type == '1' ? 'selected' : '' ?>>DNA</option>
    </select>

    <label for="naam">Naam:</label>
    <input type="text" name="naam" required>

    <div id="ressortFields" class="<?= $type == '0' ? '' : 'hidden' ?>">
        <label for="ressort_id">Ressort:</label>
        <select name="ressort_id" required>
            <?php
            $res = $suelect_conn->query("SELECT r.ressort_id, r.naam AS ressort_naam, d.naam AS distrikt_naam 
                                  FROM ressort r JOIN distrikt d ON r.distrikt_id = d.distrikt_id ORDER BY d.naam, r.naam");
            while ($row = $res->fetch_assoc()) {
                echo "<option value='{$row['ressort_id']}'>{$row['distrikt_naam']} - {$row['ressort_naam']}</option>";
            }
            ?>
        </select>
    </div>

    <div id="partijFields" class="<?= $type == '1' ? '' : 'hidden' ?>">
        <label for="partij_id">Partij:</label>
        <select name="partij_id" required>
            <?php
            $res = $suelect_conn->query("SELECT partij_id, naam FROM partij ORDER BY naam ASC");
            while ($row = $res->fetch_assoc()) {
                echo "<option value='{$row['partij_id']}'>{$row['naam']}</option>";
            }
            ?>
        </select>
    </div>

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
        <th>ID</th><th>Naam</th><th>Type</th><th>Partij / Ressort</th><th>Bewerk/Verwijder</th>
    </tr>
    <?php
    $result = $suelect_conn->query("
        SELECT k.kandidaat_id, k.naam, k.type, 
               COALESCE(p.naam, r.naam) AS groep_naam,
               k.partij_id, k.ressort_id
        FROM kandidaat k
        LEFT JOIN partij p ON k.partij_id = p.partij_id
        LEFT JOIN ressort r ON k.ressort_id = r.ressort_id
    ");
    while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['kandidaat_id'] ?></td>
            <td><?= htmlspecialchars($row['naam']) ?></td>
            <td><?= $row['type'] == 0 ? 'RR' : 'DNA' ?></td>
            <td><?= htmlspecialchars($row['groep_naam']) ?></td>
            <td>
                <!-- Bewerk Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="actie" value="bewerken">
                    <input type="hidden" name="kandidaat_id" value="<?= $row['kandidaat_id'] ?>">

                    <label>Naam:</label>
                    <input type="text" name="naam" value="<?= htmlspecialchars($row['naam']) ?>" required>

                    <label>Type:</label>
                    <select name="type" onchange="toggleEditFields(this.value, <?= $row['kandidaat_id'] ?>)" required>
                        <option value="0" <?= $row['type'] == 0 ? 'selected' : '' ?>>RR</option>
                        <option value="1" <?= $row['type'] == 1 ? 'selected' : '' ?>>DNA</option>
                    </select>

                    <div id="edit_ressort_<?= $row['kandidaat_id'] ?>" class="<?= $row['type'] == 0 ? '' : 'hidden' ?>">
                        <label>Ressort:</label>
                        <select name="ressort_id">
                            <?php
                            $ressorts = $suelect_conn->query("SELECT ressort_id, naam FROM ressort ORDER BY naam ASC");
                            while ($r = $ressorts->fetch_assoc()) {
                                $sel = ($r['ressort_id'] == $row['ressort_id']) ? 'selected' : '';
                                echo "<option value='{$r['ressort_id']}' $sel>{$r['naam']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div id="edit_partij_<?= $row['kandidaat_id'] ?>" class="<?= $row['type'] == 1 ? '' : 'hidden' ?>">
                        <label>Partij:</label>
                        <select name="partij_id">
                            <?php
                            $partijen = $suelect_conn->query("SELECT partij_id, naam FROM partij ORDER BY naam ASC");
                            while ($p = $partijen->fetch_assoc()) {
                                $sel = ($p['partij_id'] == $row['partij_id']) ? 'selected' : '';
                                echo "<option value='{$p['partij_id']}' $sel>{$p['naam']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <label>Biografie:</label>
                    <textarea name="bio"><?= htmlspecialchars($row['bio']) ?></textarea>

                    <label>Foto URL:</label>
                    <input type="url" name="foto_url" value="<?= htmlspecialchars($row['foto_url']) ?>">

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

<script>
    function toggleEditFields(type, id) {
        document.getElementById('edit_ressort_' + id).classList.toggle('hidden', type != 0);
        document.getElementById('edit_partij_' + id).classList.toggle('hidden', type != 1);
    }
</script>

</body>
</html>