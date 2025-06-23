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
    if ($_POST['actie'] === 'toevoegen') {
        $naam = $suelect_conn->real_escape_string($_POST['naam']);
        $aantal_zetels = (int)$_POST['aantal_zetels'];

        $stmt = $suelect_conn->prepare("INSERT INTO distrikt (naam, aantal_zetels) VALUES (?, ?)");
        $stmt->bind_param("si", $naam, $aantal_zetels);
        if ($stmt->execute()) {
            $success = "Distrikt succesvol toegevoegd!";
        } else {
            $error = "Fout bij toevoegen: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($_POST['actie'] === 'bewerken') {
        $distrikt_id = (int)$_POST['distrikt_id'];
        $naam = $suelect_conn->real_escape_string($_POST['naam']);
        $aantal_zetels = (int)$_POST['aantal_zetels'];

        $stmt = $suelect_conn->prepare("UPDATE distrikt SET naam=?, aantal_zetels=? WHERE distrikt_id=?");
        $stmt->bind_param("sii", $naam, $aantal_zetels, $distrikt_id);
        if ($stmt->execute()) {
            $success = "Distrikt succesvol bijgewerkt!";
        } else {
            $error = "Fout bij bijwerken: " . $stmt->error;
        }
        $stmt->close();

    } elseif ($_POST['actie'] === 'verwijderen') {
        $distrikt_id = (int)$_POST['distrikt_id'];
        $stmt = $suelect_conn->prepare("DELETE FROM distrikt WHERE distrikt_id=?");
        $stmt->bind_param("i", $distrikt_id);
        if ($stmt->execute()) {
            $success = "Distrikt succesvol verwijderd!";
        } else {
            $error = "Fout bij verwijderen: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Distrikten Beheren</title>
    <style>
        /* Hergebruik styling zoals hierboven */
    </style>
</head>
<body>

<h2>Distrikten Beheren</h2>

<?php if ($success): ?><p class="success"><?= $success ?></p><?php elseif ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

<!-- Toevoegen -->
<h3>Voeg Nieuw Distrikt Toe</h3>
<form method="POST" action="">
    <input type="hidden" name="actie" value="toevoegen">
    <label for="naam">Naam:</label>
    <input type="text" name="naam" required>
    <label for="aantal_zetels">Aantal Zetels:</label>
    <input type="number" name="aantal_zetels" value="1" min="1" required>
    <button type="submit">Voeg Distrikt Toe</button>
</form>

<!-- Overzicht -->
<h3>Huidige Distrikten</h3>
<table>
    <tr><th>ID</th><th>Naam</th><th>Zetels</th><th>Bewerk/Verwijder</th></tr>
    <?php
    $result = $suelect_conn->query("SELECT * FROM distrikt");
    while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['distrikt_id'] ?></td>
            <td><?= $row['naam'] ?></td>
            <td><?= $row['aantal_zetels'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="actie" value="bewerken">
                    <input type="hidden" name="distrikt_id" value="<?= $row['distrikt_id'] ?>">
                    <input type="text" name="naam" value="<?= $row['naam'] ?>" required>
                    <input type="number" name="aantal_zetels" value="<?= $row['aantal_zetels'] ?>" required>
                    <button type="submit">Bewerk</button>
                </form>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Weet je zeker dat je dit distrikt wilt verwijderen?');">
                    <input type="hidden" name="actie" value="verwijderen">
                    <input type="hidden" name="distrikt_id" value="<?= $row['distrikt_id'] ?>">
                    <button type="submit">Verwijder</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="admin_dash_test.php">Terug naar dashboard</a></p>

</body>
</html>