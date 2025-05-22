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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Bejelentkezés - PassLibrary</title>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fa;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    padding: 20px;
  }

  .login-container {
    background-color: #fff;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
    text-align: center;
  }

  .login-container h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    color: #1e1e2f;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
    transition: border-color 0.2s;
  }

  input[type="email"]:focus,
  input[type="password"]:focus {
    border-color: #1e1e2f;
    outline: none;
  }

  button {
    width: 100%;
    padding: 15px;
    margin-top: 20px;
    background-color: #1e1e2f;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s;
  }

  button:hover {
    background-color: #333c5a;
  }

  a {
    display: inline-block;
    margin-top: 15px;
    color: #1e1e2f;
    font-size: 0.9rem;
    text-decoration: none;
  }

  a:hover {
    text-decoration: underline;
  }

  /* Reszponzív */
  @media(max-width: 500px) {
    .login-container {
      padding: 25px 20px;
    }
    .login-container h2 {
      font-size: 1.8rem;
    }
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