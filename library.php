<?php
session_start();
include 'Database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_website'])) {
    $website_name = $_POST['website_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $website_url = $_POST['website_url'];

    if (!preg_match('#^https?://#', $website_url)) {
        $website_url = 'https://' . $website_url;
    }

    $domain = parse_url($website_url, PHP_URL_HOST);
    $logo_url = "https://www.google.com/s2/favicons?sz=64&domain=" . $domain;

    $stmt = $pdo->prepare("INSERT INTO passwords (user_id, website_name, username, password, website_url, logo_url) 
                           VALUES (:user_id, :website_name, :username, :password, :website_url, :logo_url)");
    $stmt->execute([
        'user_id' => $_SESSION['user_id'],
        'website_name' => $website_name,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'website_url' => $website_url,
        'logo_url' => $logo_url
    ]);

    header('Location: library.php');
    exit;
}



$stmt = $pdo->prepare("SELECT * FROM passwords WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$websites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library - PassLibrary</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e1e2f;
            color: white;
            padding: 15px 30px;
            width: 100%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .container {
            padding: 40px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .website-card {
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .website-card img {
            width: 50px;
            height: 50px;
            margin-right: 20px;
        }

        .website-card h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #1e1e2f;
        }

        .add-website-form {
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 30px;
        }

        .add-website-form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .add-website-form button {
            background-color: #1e1e2f;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-website-form button:hover {
            background-color: #333c5a;
        }

        .logout-button {
            background-color: #f44336;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
        }

        .logout-button:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>

<header>
    <div class="container">
        <h1>PassLibrary - Your Saved Websites</h1>
    </div>
</header>

<div class="container">
    <h2>Weboldalak</h2>

    <a href="library.php?logout=true" class="logout-button">Kijelentkezés</a>

    <?php foreach ($websites as $website): ?>
        <div class="website-card">
            <img src="<?php echo $website['logo_url']; ?>" alt="Logo">
            <div>
                <h3><?php echo $website['website_name']; ?></h3>
                <p><strong>Felhasználónév:</strong> <?php echo $website['username']; ?></p>
                <p><strong>Link:</strong> <a href="<?php echo $website['website_url']; ?>" target="_blank"><?php echo $website['website_url']; ?></a></p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="add-website-form">
        <h3>Weboldal hozzáadása</h3>
        <form method="POST">
            <input type="text" name="website_name" placeholder="Weboldal neve" required>
            <input type="text" name="username" placeholder="Felhasználónév" required>
            <input type="password" name="password" placeholder="Jelszó" required>
            <input type="url" name="website_url" placeholder="Weboldal URL" required>
            <button type="submit" name="add_website">Hozzáadás</button>
        </form>
    </div>
</div>

</body>
</html>
