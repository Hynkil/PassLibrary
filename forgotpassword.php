<?php
include 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(16));


        $subject = 'Jelszó visszaállítása';
        $message = 'Kattints a következő linkre a jelszó visszaállításához: <a href="reset_password.php?token=' . $token . '">Visszaállítás</a>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-Type: text/html; charset=UTF-8' . "\r\n";
        $headers .= 'From: no-reply@passlibrary.com' . "\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo 'E-mailt küldtünk a jelszó visszaállításához.';
        } else {
            echo 'Hiba történt az e-mail küldésekor.';
        }
    } else {
        echo "Nincs ilyen email cím a rendszerben!";
    }
}
?>

<form method="POST">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <button type="submit">Elfelejtett jelszó</button>
</form>
