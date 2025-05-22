<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Regisztráció - PassLibrary</title>
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
    flex-direction: column;
    min-height: 100vh;
    color: #333;
  }

  /* Fejléc */
  header {
    background-color: #1e1e2f;
    padding: 15px 30px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }

  header nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .logo {
    color: #fff;
    font-size: 1.8rem;
    font-weight: bold;
  }

  .nav-links a {
    margin-left: 20px;
    color: #fff;
    text-decoration: none;
    font-size: 1rem;
    transition: color 0.2s;
  }

  .nav-links a:hover {
    color: #ccc;
  }

  /* Fő tartalom */
  main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
  }

  /* Űrlap doboz */
  .form-container {
    background-color: #fff;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
  }

  .form-container h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    color: #1e1e2f;
    text-align: center;
  }

  /* Ürlap elemek */
  form {
    display: flex;
    flex-direction: column;
  }

  label {
    margin-top: 10px;
    margin-bottom: 5px;
    font-weight: 600;
    font-size: 1rem;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
    transition: border-color 0.2s;
  }

  input[type="text"]:focus,
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

  /* Hibauzenet */
  .error {
    margin-top: 15px;
    color: red;
    font-size: 0.95rem;
    text-align: center;
  }

  /* Linkek */
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
    .form-container {
      padding: 25px 20px;
    }
    header nav {
      flex-direction: column;
      align-items: flex-start;
    }
    .nav-links {
      margin-top: 10px;
    }
    header h1 {
      font-size: 1.8rem;
    }
  }
</style>
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
    <form method="POST" action="">
      <label for="username">Felhasználónév:</label>
      <input type="text" id="username" name="username" placeholder="Írd be a felhasználóneved" required />

      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="Email cím" required />

      <label for="password">Jelszó:</label>
      <input type="password" id="password" name="password" placeholder="Jelszó" required />

      <button type="submit">Regisztráció</button>
    </form>
  </div>
</main>

<footer>
  PassLibrary 2025 © – Minden jog fenntartva
</footer>

</body>
</html>
