<?php
include 'Database.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email OR username = :username");
    $stmt->execute(['email' => $email, 'username' => $username]);
    if ($stmt->rowCount() > 0) {
        $message = "A felhasználónév vagy email már létezik!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => $password]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        header("Location: library.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció - PassLibrary</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <header>
        <nav>
            <div class="logo">PassLibrary</div>
            <div class="nav-links">
                <a href="home.html">Home</a>
                <a href="login.php">Bejelentkezés</a>
                <a href="register.php">Regisztráció</a>
            </div>
        </nav>
    </header>

    <main>
        <div class="form-container">
            <h2>Regisztráció</h2>

            <?php if (isset($message)) { echo "<p class='error'>$message</p>"; } ?>

            <form method="POST">
                <label for="username">Felhasználónév:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="password">Jelszó:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Regisztráció</button>
            </form>
        </div>
    </main>

    <footer>
        PassLibrary 2025 &copy; – Minden jog fenntartva
    </footer>

</body>
</html>
