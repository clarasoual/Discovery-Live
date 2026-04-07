<?php
require 'connexion.php';

$success = false;
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $artiste    = trim($_POST['artiste'] ?? '');
    $genre      = trim($_POST['genre'] ?? '');
    $date       = trim($_POST['date'] ?? '');
    $salle      = trim($_POST['salle'] ?? '');
    $lien       = trim($_POST['lien'] ?? '');
    $email      = trim($_POST['email'] ?? '');

    if (!$artiste || !$genre || !$date || !$lien || !$email) {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse email invalide.';
    } elseif (!filter_var($lien, FILTER_VALIDATE_URL)) {
        $erreur = 'Le lien de billetterie n\'est pas valide.';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO propositions (artiste, genre, date_concert, salle, lien_billetterie, email)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$artiste, $genre, $date, $salle, $lien, $email]);
        $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Proposer un concert – Discovery Live</title>
  <link rel="stylesheet" href="concerts.css" />
  <style>
    .propose-wrapper {
      max-width: 700px;
      margin: 50px auto;
      padding: 0 20px;
    }

    .propose-form {
      background-color: #1f1f1f;
      padding: 35px;
      border-radius: 16px;
    }

    .propose-form h2 {
      margin: 0 0 8px 0;
      font-size: 26px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .propose-form .subtitle {
      color: #aaaaaa;
      font-size: 14px;
      margin: 0 0 30px 0;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      margin-bottom: 20px;
    }

    .form-group label {
      font-size: 14px;
      color: #fff;
      margin-bottom: 8px;
    }

    .form-group span.required {
      color: #9a63d1;
    }

    .form-group input,
    .form-group select {
      padding: 12px;
      border-radius: 8px;
      border: none;
      font-size: 14px;
      background-color: #2e2e2e;
      color: #fff;
    }

    .form-group input:focus,
    .form-group select:focus {
      outline: 2px solid #5a1b7e;
    }

    .form-group input::placeholder {
      color: #888;
    }

    .submit-btn {
      width: 100%;
      padding: 14px;
      background-color: #5a1b7e;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 500;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
      margin-top: 10px;
    }

    .submit-btn:hover {
      background-color: #7c3eb0;
      transform: scale(1.02);
    }

    .message-success {
      background-color: #1a3a1a;
      border: 1px solid #4caf50;
      color: #4caf50;
      padding: 20px;
      border-radius: 10px;
      text-align: center;
      font-size: 16px;
    }

    .message-erreur {
      background-color: #3a1a1a;
      border: 1px solid #e53935;
      color: #e53935;
      padding: 14px;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 14px;
    }
  </style>
</head>
<body>

<header>
  <img src="IMAGES/logo.png" class="logo">
  <div class="menu-icon">
    <a href="index.php">Accueil</a>
    <a href="decouvrir.html">Découvrir</a>
    <a href="concerts.php">Concerts</a>
  </div>
</header>

<!-- HERO -->
<section class="hero">
  <h1>Proposer un concert</h1>
  <p>Un artiste passe à Bordeaux et n'est pas sur notre site ?</p>
</section>

<div class="propose-wrapper">
  <div class="propose-form">

    <?php if ($success) : ?>
      <div class="message-success">
        ✅ Merci pour votre proposition ! Nous l'examinerons et l'ajouterons au site si elle est validée.
      </div>
    <?php else : ?>

      <h2>Proposer un concert</h2>
      <p class="subtitle">Vous avez trouvé un concert qui n'est pas encore sur Discovery Live ? Signalez-le nous !</p>

      <?php if ($erreur) : ?>
        <div class="message-erreur">⚠️ <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form method="POST" action="proposer.php">

        <div class="form-group">
          <label>Nom de l'artiste <span class="required">*</span></label>
          <input type="text" name="artiste" placeholder="Ex : Myrath" value="<?= htmlspecialchars($_POST['artiste'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Genre musical <span class="required">*</span></label>
          <select name="genre" required>
            <option value="">-- Choisir un genre --</option>
            <option value="metal"   <?= ($_POST['genre'] ?? '') === 'metal'   ? 'selected' : '' ?>>Metal</option>
            <option value="rock"    <?= ($_POST['genre'] ?? '') === 'rock'    ? 'selected' : '' ?>>Rock</option>
            <option value="rap"     <?= ($_POST['genre'] ?? '') === 'rap'     ? 'selected' : '' ?>>Rap US</option>
            <option value="variete" <?= ($_POST['genre'] ?? '') === 'variete' ? 'selected' : '' ?>>Variété Française</option>
            <option value="reggae"  <?= ($_POST['genre'] ?? '') === 'reggae'  ? 'selected' : '' ?>>Reggae</option>
            <option value="electro" <?= ($_POST['genre'] ?? '') === 'electro' ? 'selected' : '' ?>>Électro</option>
          </select>
        </div>

        <div class="form-group">
          <label>Date du concert <span class="required">*</span></label>
          <input type="date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Salle / Lieu</label>
          <input type="text" name="salle" placeholder="Ex : Rock School Barbey" value="<?= htmlspecialchars($_POST['salle'] ?? '') ?>">
        </div>

        <div class="form-group">
          <label>Lien billetterie officielle <span class="required">*</span></label>
          <input type="url" name="lien" placeholder="https://www.ticketmaster.fr/..." value="<?= htmlspecialchars($_POST['lien'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Votre email <span class="required">*</span></label>
          <input type="email" name="email" placeholder="votre@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <button type="submit" class="submit-btn">Envoyer ma proposition →</button>

      </form>

    <?php endif; ?>

  </div>
</div>

<footer>
  <div class="footer-content">
    <p>© 2025 Discovery Live. Tous droits réservés.</p>
    <div class="footer-links">
      <a href="index.php">Accueil</a>
      <a href="decouvrir.html">Découvrir</a>
      <a href="concerts.php">Concerts</a>
      <a href="proposer.php">Proposer un concert</a>
    </div>
  </div>
</footer>

</body>
</html>