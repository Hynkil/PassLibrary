<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Jelszó Visszaállítás - PassLibrary</title>
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
    text-align: center;
  }

  header h1 {
    color: #fff;
    font-size: 1.8rem;
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
    padding: 30px 40px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    max-width: 400px;
    width: 100%;
    box-sizing: border-box;
  }

  .form-container h2 {
    margin-bottom: 20px;
    font-size: 2rem;
    color: #1e1e2f;
    text-align: center;
  }

  form {
    display: flex;
    flex-direction: column;
  }

  label {
    margin-bottom: 8px;
    font-weight: 600;
    font-size: 1rem;
  }

  input[type="email"] {
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    transition: border-color 0.2s;
  }

  input[type="email"]:focus {
    border-color: #1e1e2f;
    outline: none;
  }

  button {
    padding: 15px;
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

  /* Üzenetek */
  .message {
    margin-top: 20px;
    font-size: 1.1rem;
    text-align: center;
    color: #555;
  }

  /* Lábléc */
  footer {
    background-color: #1e1e2f;
    color: #fff;
    text-align: center;
    padding: 15px;
    font-size: 0.9rem;
  }

  /* Reszponzív */
  @media(max-width: 500px) {
    .form-container {
      padding: 20px;
    }
    header h1 {
      font-size: 1.5rem;
    }
  }
</style>
</head>
<body>

<header>
  <h1>PassLibrary - Jelszó Visszaállítás</h1>
</header>

<main>
  <div class="form-container">
    <h2>Jelszó visszaállítás</h2>
    <?php if (isset($message)): ?>
      <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" required placeholder="Írd be az email címed" />

      <button type="submit">Elfelejtett jelszó</button>
    </form>
  </div>
</main>

<footer>
  PassLibrary 2025 © – Minden jog fenntartva
</footer>

</body>
</html>
