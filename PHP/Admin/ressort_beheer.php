<?php
global $suelect_conn;
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../Includes/db.php';
$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['actie'])) {
        if ($_POST['actie'] === 'toevoegen') {
            // Toevoegen
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $distrikt_id = (int)$_POST['distrikt_id'];

            $stmt = $suelect_conn->prepare("INSERT INTO ressort (naam, distrikt_id) VALUES (?, ?)");
            $stmt->bind_param("ss", $naam, $distrikt_id);
            if ($stmt->execute()) {
                $success = "Ressort succesvol toegevoegd!";
            } else {
                $error = "Fout bij toevoegen: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($_POST['actie'] === 'bewerken') {
            // Bewerken
            $ressort_id = (int)$_POST['ressort_id'];
            $naam = $suelect_conn->real_escape_string($_POST['naam']);
            $distrikt_id = (int)$_POST['distrikt_id'];

            $stmt = $suelect_conn->prepare("UPDATE ressort SET naam=?, distrikt_id=? WHERE ressort_id=?");
            $stmt->bind_param("ssi", $naam, $distrikt_id, $ressort_id);
            if ($stmt->execute()) {
                $success = "Ressort succesvol bijgewerkt!";
            } else {
                $error = "Fout bij bijwerken: " . $stmt->error;
            }
            $stmt->close();

        } elseif ($_POST['actie'] === 'verwijderen') {
            // Verwijderen
            $ressort_id = (int)$_POST['ressort_id'];
            $stmt = $suelect_conn->prepare("DELETE FROM ressort WHERE ressort_id=?");
            $stmt->bind_param("i", $ressort_id);
            if ($stmt->execute()) {
                $success = "Ressort succesvol verwijderd!";
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
    <title>Ressorten Beheren</title>
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

<h2>Ressorten Beheren</h2>

<?php if ($success): ?>
    <p class="success"><?= $success ?></p>
<?php elseif ($error): ?>
    <p class="error"><?= $error ?></p>
<?php endif; ?>

<!-- Toevoegen -->
<h3>Voeg Nieuw Ressort Toe</h3>
<form method="POST" action="">
    <input type="hidden" name="actie" value="toevoegen">
    <label for="naam">Naam:</label>
    <input type="text" name="naam" required>
    <label for="distrikt_id">Distrikt:</label>
    <select name="distrikt_id" required>
        <?php
        $res = $suelect_conn->query("SELECT distrikt_id, naam FROM distrikt ORDER BY naam ASC");
        while ($row = $res->fetch_assoc()) {
            echo "<option value='{$row['distrikt_id']}'>{$row['naam']}</option>";
        }
        ?>
    </select>
    <button type="submit">Voeg Ressort Toe</button>
</form>

<!-- Overzicht -->
<h3>Huidige Ressorten</h3>
<table>
    <tr>
        <th>ID</th><th>Naam</th><th>Distrikt</th><th>Bewerk/Verwijder</th>
    </tr>
    <?php
    $result = $suelect_conn->query("
        SELECT r.ressort_id, r.naam AS ressort_naam, d.naam AS distrikt_naam
        FROM ressort r
        JOIN distrikt d ON r.distrikt_id = d.distrikt_id
        ORDER BY d.naam, r.naam
    ");
    while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['ressort_id'] ?></td>
            <td><?= htmlspecialchars($row['ressort_naam']) ?></td>
            <td><?= htmlspecialchars($row['distrikt_naam']) ?></td>
            <td>
                <!-- Bewerk Form -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="actie" value="bewerken">
                    <input type="hidden" name="ressort_id" value="<?= $row['ressort_id'] ?>">
                    <input type="text" name="naam" value="<?= htmlspecialchars($row['ressort_naam']) ?>" required>
                    <select name="distrikt_id" required>
                        <?php
                        $res_dist = $suelect_conn->query("SELECT distrikt_id, naam FROM distrikt ORDER BY naam ASC");
                        while ($dist_row = $res_dist->fetch_assoc()) {
                            $selected = ($dist_row['distrikt_id'] == $row['distrikt_id']) ? 'selected' : '';
                            echo "<option value='{$dist_row['distrikt_id']}' $selected>{$dist_row['naam']}</option>";
                        }
                        ?>
                    </select>
                    <button type="submit">Bewerk</button>
                </form>

                <!-- Verwijder Form -->
                <form method="POST" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je dit ressort wilt verwijderen?');">
                    <input type="hidden" name="actie" value="verwijderen">
                    <input type="hidden" name="ressort_id" value="<?= $row['ressort_id'] ?>">
                    <button type="submit">Verwijder</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin_dash_test.php">Terug naar dashboard</a></p>

</body>
</html>