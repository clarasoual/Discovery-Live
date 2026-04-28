<?php
require 'vendor/autoload.php';

$success = false;
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type    = trim($_POST['type'] ?? '');
    $nom     = trim($_POST['nom'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    $artiste = trim($_POST['artiste'] ?? '');
    $date    = trim($_POST['date'] ?? '');
    $lien    = trim($_POST['lien'] ?? '');

    if (!$type || !$nom || !$email || !$message) {
        $erreur = 'Veuillez remplir tous les champs obligatoires.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = 'Adresse email invalide.';
    } else {
        try {
            $mongoHost = getenv('MONGO_HOST') ?: 'localhost';
            $mongoPort = getenv('MONGO_PORT') ?: '27017';
            $client = new MongoDB\Client("mongodb://$mongoHost:$mongoPort");
            $collection = $client->discovery_live->contacts;

            $document = [
                'type'       => $type,
                'nom'        => $nom,
                'email'      => $email,
                'message'    => $message,
                'artiste'    => $artiste ?: null,
                'date'       => $date ?: null,
                'lien'       => $lien ?: null,
                'created_at' => new MongoDB\BSON\UTCDateTime()
            ];

            $collection->insertOne($document);
            $success = true;

        } catch (Exception $e) {
            $erreur = 'Erreur lors de l\'envoi : ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact – Discovery Live</title>
  <link rel="stylesheet" href="concerts.css" />
  <style>
    .contact-wrapper {
      max-width: 700px;
      margin: 50px auto;
      padding: 0 20px;
    }

    .contact-form {
      background-color: #1f1f1f;
      padding: 35px;
      border-radius: 16px;
    }

    .contact-form h2 {
      margin: 0 0 8px 0;
      font-size: 26px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .contact-form .subtitle {
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

    .form-group input,
    .form-group select,
    .form-group textarea {
      padding: 12px;
      border-radius: 8px;
      border: none;
      font-size: 14px;
      background-color: #2e2e2e;
      color: #fff;
      font-family: 'Poppins', sans-serif;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 120px;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      outline: 2px solid #5a1b7e;
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: #888;
    }

    .champs-concert {
      display: none;
      flex-direction: column;
      gap: 20px;
    }

    .champs-concert.visible {
      display: flex;
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
      font-family: 'Poppins', sans-serif;
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

    span.required {
      color: #9a63d1;
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

<section class="hero">
  <h1>Contact</h1>
  <p>Une question, une suggestion, une erreur à signaler ?</p>
</section>

<div class="contact-wrapper">
  <div class="contact-form">

    <?php if ($success) : ?>
      <div class="message-success">
        ✅ Votre message a bien été envoyé ! Merci pour votre contribution.
      </div>
    <?php else : ?>

      <h2>Nous contacter</h2>
      <p class="subtitle">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>

      <?php if ($erreur) : ?>
        <div class="message-erreur">⚠️ <?= htmlspecialchars($erreur) ?></div>
      <?php endif; ?>

      <form method="POST" action="contact.php">

        <div class="form-group">
          <label>Type de message <span class="required">*</span></label>
          <select name="type" id="type" required onchange="toggleChampsConcert()">
            <option value="">-- Choisir --</option>
            <option value="proposition" <?= ($_POST['type'] ?? '') === 'proposition' ? 'selected' : '' ?>>🎵 Proposer un concert</option>
            <option value="signalement" <?= ($_POST['type'] ?? '') === 'signalement' ? 'selected' : '' ?>>⚠️ Signaler une erreur</option>
            <option value="suggestion"  <?= ($_POST['type'] ?? '') === 'suggestion'  ? 'selected' : '' ?>>💡 Suggestion</option>
            <option value="autre"       <?= ($_POST['type'] ?? '') === 'autre'       ? 'selected' : '' ?>>✉️ Autre</option>
          </select>
        </div>

        <div class="champs-concert" id="champs-concert">
          <div class="form-group">
            <label>Nom de l'artiste</label>
            <input type="text" name="artiste" placeholder="Ex : Myrath" value="<?= htmlspecialchars($_POST['artiste'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Date du concert</label>
            <input type="date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
          </div>
          <div class="form-group">
            <label>Lien billetterie</label>
            <input type="url" name="lien" placeholder="https://www.ticketmaster.fr/..." value="<?= htmlspecialchars($_POST['lien'] ?? '') ?>">
          </div>
        </div>

        <div class="form-group">
          <label>Votre nom <span class="required">*</span></label>
          <input type="text" name="nom" placeholder="Votre nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Votre email <span class="required">*</span></label>
          <input type="email" name="email" placeholder="votre@email.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </div>

        <div class="form-group">
          <label>Message <span class="required">*</span></label>
          <textarea name="message" placeholder="Votre message..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="submit-btn">Envoyer →</button>

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
      <a href="contact.php">Contact</a>
    </div>
  </div>
</footer>

<script>
function toggleChampsConcert() {
  const type = document.getElementById('type').value;
  const champs = document.getElementById('champs-concert');
  if (type === 'proposition') {
    champs.classList.add('visible');
  } else {
    champs.classList.remove('visible');
  }
}
</script>

</body>
</html>