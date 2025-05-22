<?php
include 'Database.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        echo '<form method="POST">
                <label for="new_password">Új jelszó:</label>
                <input type="password" id="new_password" name="new_password" required>
                <button type="submit">Jelszó visszaállítása</button>
              </form>';
    } else {
        echo "Érvénytelen token!";
    }
} else {
    echo "Nincs token megadva!";
}
?>
