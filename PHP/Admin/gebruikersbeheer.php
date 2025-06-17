<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../login.php");
    exit();
}

// Include database connection and functions
require_once '../Includes/db.php';
require_once '../Includes/functions.php';

// Get admin information from session
$admin_id = $_SESSION['admin_id'];
$username = $_SESSION['username'];
$volledige_naam = $_SESSION['volledige_naam'];

// Determine if user is root admin based on 'type' column in Admin table
$is_root_admin = false;
try {
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT type FROM Admin WHERE admin_id = :admin_id");
    $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result && $result['type'] === 'root_admin') {
        $is_root_admin = true;
    }
} catch (Exception $e) {
    // Log error or handle as needed
}

$manage_type = 'admins'; // Only admin management now

$errors = [];
$success = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Determine action
    $action = $_POST['action'] ?? '';

    if ($action === 'add' && $is_root_admin) {
        // Add admin
        $volledige_naam = trim($_POST['volledige_naam'] ?? '');
        $wachtwoord = $_POST['wachtwoord'] ?? '';
        $is_actief = isset($_POST['is_actief']) ? (bool)$_POST['is_actief'] : true;
        $type = $_POST['type'] ?? 'normal_admin';

        // Parse volledige_naam into first name and last name
        $name_parts = explode(' ', $volledige_naam);
        $first_name = $name_parts[0] ?? '';
        $last_name = $name_parts[count($name_parts) - 1] ?? '';

        // Generate username: SuElect\RA-lastname first letter first name
        $username = 'SuElect\\RA-' . strtolower($last_name) . strtolower(substr($first_name, 0, 1));

        // Generate email: firstname.Lastlastname@suelect.sr
        $email = strtolower($first_name) . '.' . strtolower($last_name) . '@suelect.sr';

        $data = [
            'username' => $username,
            'wachtwoord' => $wachtwoord,
            'email' => $email,
            'volledige_naam' => $volledige_naam,
            'is_actief' => $is_actief,
            'type' => $type,
        ];
        $new_id = createAdmin($data);
        if ($new_id) {
            $success = "Admin added successfully.";
        } else {
            $errors[] = "Failed to add admin.";
        }
    }
        $admin_id_edit = $_POST['admin_id'] ?? 0;
        $data = [
            'username' => $_POST['username'] ?? '',
            'wachtwoord' => $_POST['wachtwoord'] ?? '',
            'email' => $_POST['email'] ?? '',
            'volledige_naam' => $_POST['volledige_naam'] ?? '',
            'is_actief' => isset($_POST['is_actief']) ? (bool)$_POST['is_actief'] : true,
            'type' => $_POST['type'] ?? 'normal_admin',
        ];
        if (updateAdmin($admin_id_edit, $data)) {
            $success = "Admin updated successfully.";
        } else {
            $errors[] = "Failed to update admin.";
        }
    } elseif ($action === 'delete' && $is_root_admin) {
        $admin_id_delete = $_POST['id'] ?? 0;
        if (deleteRecord('Admin', 'admin_id', $admin_id_delete)) {
            $success = "Admin deleted successfully.";
        } else {
            $errors[] = "Failed to delete admin.";
        }
    }


// Fetch data for table
$conn = getConnection();
$stmt = $conn->query("SELECT admin_id, username, email, volledige_naam, is_actief, type FROM Admin ORDER BY username");
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Gebruikersbeheer</title>
    <link rel="stylesheet" href="../../CSS/Admin_pages.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container">
        <h1>Gebruikersbeheer</h1>

        <!-- Removed dropdown filter as only admin management is allowed -->

        <?php if ($success): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($errors): ?>
            <div class="error-message">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <button id="addBtn">Add Admin</button>

        <table class="crud-table">
            <thead>
                <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Volledige Naam</th>
                        <th>Is Actief</th>
                        <th>Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                    <tr>
                        <td><?= htmlspecialchars($record['username']) ?></td>
                        <td><?= htmlspecialchars($record['email']) ?></td>
                        <td><?= htmlspecialchars($record['volledige_naam']) ?></td>
                        <td><?= $record['is_actief'] ? 'Yes' : 'No' ?></td>
                        <td><?= htmlspecialchars($record['type']) ?></td>
                        <td>
                            <button class="editBtn" data-id="<?= $record['admin_id'] ?>">Edit</button>
                            <?php if ($is_root_admin): ?>
                                <button class="deleteBtn" data-id="<?= $record['admin_id'] ?>">Delete</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <!-- Popup overlay -->
        <div id="popupOverlay" class="popup-overlay"></div>

        <!-- Popup forms -->
        <div id="popupForm" class="popup-form">
            <form method="post" id="crudForm">
                <input type="hidden" name="action" id="formAction" value="" />
                <input type="hidden" name="gebruiker_id" id="gebruikerId" value="" />
                <input type="hidden" name="admin_id" id="adminId" value="" />

                <div id="userFields" class="form-fields">
                    <label for="voornaam">Voornaam:</label>
                    <input type="text" name="voornaam" id="voornaam" required />

                    <label for="achternaam">Achternaam:</label>
                    <input type="text" name="achternaam" id="achternaam" required />

                    <label for="id_nummer">ID Nummer:</label>
                    <input type="text" name="id_nummer" id="id_nummer" required />

                    <label for="wachtwoord">Wachtwoord:</label>
                    <input type="password" name="wachtwoord" id="wachtwoord" />

                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" required />

                    <label for="geboorte_datum">Geboorte Datum:</label>
                    <input type="date" name="geboorte_datum" id="geboorte_datum" required />
                </div>

                <div id="adminFields" class="form-fields hidden">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" readonly />

                <label for="volledige_naam">Volledige Naam:</label>
                <input type="text" name="volledige_naam" id="volledige_naam" required />

                <label for="wachtwoordAdmin">Wachtwoord:</label>
                <input type="password" name="wachtwoord" id="wachtwoordAdmin" />

                <!-- Email is auto-generated, make readonly -->
                <label for="emailAdmin">Email:</label>
                <input type="email" name="email" id="emailAdmin" readonly />

                <label for="is_actief">Is Actief:</label>
                <select name="is_actief" id="is_actief">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>

                <div class="form-buttons">
                    <button type="submit">Save</button>
                    <button type="button" id="cancelBtn">Cancel</button>
                </div>
            </form>
        </div>

        <!-- Delete confirmation popup -->
        <div id="deletePopup" class="popup-form">
            <form method="post" id="deleteForm">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="id" id="deleteId" value="" />
                <p>Are you sure you want to delete this <?= $manage_type === 'users' ? 'user' : 'admin' ?>?</p>
                <div class="form-buttons">
                    <button type="submit">Yes, Delete</button>
                    <button type="button" id="cancelDeleteBtn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const manageType = '<?= $manage_type ?>';
        const isRootAdmin = <?= $is_root_admin ? 'true' : 'false' ?>;

        const addBtn = document.getElementById('addBtn');
        const popupForm = document.getElementById('popupForm');
        const deletePopup = document.getElementById('deletePopup');
        const popupOverlay = document.getElementById('popupOverlay');
        const cancelBtn = document.getElementById('cancelBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        const crudForm = document.getElementById('crudForm');
        const deleteForm = document.getElementById('deleteForm');

        const userFields = document.getElementById('userFields');
        const adminFields = document.getElementById('adminFields');

        const formAction = document.getElementById('formAction');
        const gebruikerIdInput = document.getElementById('gebruikerId');
        const adminIdInput = document.getElementById('adminId');

        function openPopup() {
            popupForm.classList.add('active');
            popupOverlay.classList.add('active');
        }

        function closePopup() {
            popupForm.classList.remove('active');
            popupOverlay.classList.remove('active');
        }

        function openDeletePopup() {
            deletePopup.classList.add('active');
            popupOverlay.classList.add('active');
        }

        function closeDeletePopup() {
            deletePopup.classList.remove('active');
            popupOverlay.classList.remove('active');
        }

        addBtn.addEventListener('click', () => {
            formAction.value = 'add';
            gebruikerIdInput.value = '';
            adminIdInput.value = '';
            crudForm.reset();
            if (manageType === 'users') {
                userFields.classList.remove('hidden');
                adminFields.classList.add('hidden');
            } else {
                userFields.classList.add('hidden');
                adminFields.classList.remove('hidden');
            }
            openPopup();
        });

        cancelBtn.addEventListener('click', () => {
            closePopup();
        });

        cancelDeleteBtn.addEventListener('click', () => {
            closeDeletePopup();
        });

        popupOverlay.addEventListener('click', () => {
            closePopup();
            closeDeletePopup();
        });

        document.querySelectorAll('.editBtn').forEach(button => {
            button.addEventListener('click', () => {
                formAction.value = 'edit';
                crudForm.reset();
                const id = button.getAttribute('data-id');
                if (manageType === 'users') {
                    gebruikerIdInput.value = id;
                    adminIdInput.value = '';
                    // Fetch user data via AJAX or embed in data attributes (simplified here)
                    const row = button.closest('tr');
                    document.getElementById('voornaam').value = row.children[0].textContent;
                    document.getElementById('achternaam').value = row.children[1].textContent;
                    document.getElementById('email').value = row.children[2].textContent;
                    document.getElementById('geboorte_datum').value = row.children[3].textContent;
                    userFields.classList.remove('hidden');
                    adminFields.classList.add('hidden');
                } else {
                    adminIdInput.value = id;
                    gebruikerIdInput.value = '';
                    const row = button.closest('tr');
                    document.getElementById('username').value = row.children[0].textContent;
                    document.getElementById('emailAdmin').value = row.children[1].textContent;
                    document.getElementById('volledige_naam').value = row.children[2].textContent;
                    // is_actief is text, convert to value
                    document.getElementById('is_actief').value = row.children[3].textContent.toLowerCase() === 'yes' ? '1' : '0';
                    userFields.classList.add('hidden');
                    adminFields.classList.remove('hidden');
                }
                openPopup();
            });
        });

        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                document.getElementById('deleteId').value = id;
                openDeletePopup();
            });
        });
    </script>
</body>
</html>
