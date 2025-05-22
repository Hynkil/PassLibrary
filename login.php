<?php
session_start();
include 'Database.php';

if (isset($_SESSION['user_id'])) {
    header('Location: library.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        header('Location: library.php');
        exit;
    } else {
        echo "Hibás email vagy jelszó!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bejelentkezés - PassLibrary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .login-container h2 {
            margin-bottom: 20px;
            color: #1e1e2f;
        }
        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .login-container button {
            width: 100%;
            padding: 12px;
            background-color: #1e1e2f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .login-container button:hover {
            background-color: #333c5a;
        }
        .login-container a {
            display: inline-block;
            margin-top: 10px;
            color: #1e1e2f;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .login-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    

<div class="login-container">
    <h2>Bejelentkezés</h2>
    <form method="POST">
        <input type="email" id="email" name="email" placeholder="Email cím" required>
        <input type="password" id="password" name="password" placeholder="Jelszó" required>
        <button type="submit">Bejelentkezés</button>
    </form>

    <a href="forgotpassword.php">Elfelejtetted a jelszavad?</a>
</div>

</body>
</html>
