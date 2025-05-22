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
        'password' => $password, 
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
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>PassLibrary - Jelszótár</title>
<style>
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f4f7fa;
    margin: 0;
    padding: 0;
  }

  header {
    background-color: #1e1e2f;
    color: #fff;
    padding: 20px 40px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }

  header h1 {
    margin: 0;
    font-size: 1.8rem;
  }


  .container {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
  }


  h2 {
    margin-bottom: 20px;
    color: #333;
  }

  .logout-button {
    display: inline-block;
    background-color: #f44336;
    color: #fff;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 600;
    float: right;
    transition: background-color 0.3s;
  }
  .logout-button:hover {
    background-color: #d32f2f;
  }


  .website-card {
    display: flex;
    align-items: center;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 15px;
    margin-bottom: 15px;
    transition: box-shadow 0.2s, transform 0.2s;
  }

  .website-card:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    transform: translateY(-2px);
  }

  .logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    margin-right: 20px;
  }

  .website-info h3 {
    margin: 0 0 8px 0;
    font-size: 1.4rem;
    color: #1e1e2f;
  }

  .website-info p {
    margin: 4px 0;
    font-size: 0.95rem;
    color: #555;
  }

  /* Hozzáadás űrlap */
  .add-form {
    background-color: #fff;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-top: 30px;
  }

  .add-form h3 {
    margin-bottom: 15px;
    color: #333;
  }

  .add-form input {
    width: 100%;
    padding: 10px 12px;
    margin: 8px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1em;
    transition: border-color 0.2s;
  }

  .add-form input:focus {
    border-color: #1e1e2f;
    outline: none;
  }

  .add-form button {
    width: 100%;
    padding: 12px;
    margin-top: 12px;
    background-color: #1e1e2f;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background-color 0.3s;
  }
  .add-form button:hover {
    background-color: #343a40;
  }


  @media(max-width: 768px) {
    header {
      flex-direction: column;
      align-items: center;
    }
    .logout-button {
      float: none;
      margin-top: 10px;
    }
    .website-card {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
    .logo {
      margin-bottom: 10px;
    }
  }
</style>
</head>
<body>

<header>
  <div class="container" style="display:flex; justify-content: space-between; align-items:center;">
    <h1>PassLibrary - Jelszótár</h1>
    <a href="library.php?logout=true" class="logout-button">Kijelentkezés</a>
  </div>
</header>

<div class="container">

  <h2>Weboldalak</h2>

  <!-- Weboldalak listája -->
  <?php foreach ($websites as $website): ?>
    <div class="website-card">
      <img src="<?php echo $website['logo_url']; ?>" alt="Logo" class="logo" />
      <div class="website-info">
        <h3><?php echo htmlspecialchars($website['website_name']); ?></h3>
        <p><strong>Felhasználónév:</strong> <?php echo htmlspecialchars($website['username']); ?></p>
        <p><strong>Link:</strong> <a href="<?php echo htmlspecialchars($website['website_url']); ?>" target="_blank"><?php echo htmlspecialchars($website['website_url']); ?></a></p>
        <p><strong>Jelszó:</strong> 
        <input type="password" id="password-<?php echo $website['id']; ?>" value="<?php echo htmlspecialchars($website['password']); ?>" readonly>
        <button type="button" onclick="showPassword(<?php echo $website['id']; ?>)">👁️</button>
        </p>
      </div>
    </div>
  <?php endforeach; ?>


  <div class="add-form">
    <h3>Weboldal hozzáadása</h3>
    <form method="POST">
      <input type="text" name="website_name" placeholder="Weboldal neve" required />
      <input type="text" name="username" placeholder="Felhasználónév" required />
      <input type="password" name="password" placeholder="Jelszó" required />
      <input type="url" name="website_url" placeholder="Weboldal URL" required />
      <button type="submit" name="add_website">Hozzáadás</button>
    </form>
  </div>

</div>

<script>
  function showPassword(websiteId) {
    const passwordField = document.getElementById(`password-${websiteId}`);
    const currentType = passwordField.type;
    

    if (currentType === 'password') {
      passwordField.type = 'text';
    } else {
      passwordField.type = 'password';
    }
  }
</script>

</body>
</html>
