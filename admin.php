<?php
session_start();

// Mot de passe admin simple
$mot_de_passe = "admin123";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $mot_de_passe) {
        $_SESSION['admin'] = true;
    } else {
        $erreur = "Mot de passe incorrect.";
    }
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin – Discovery Live</title>
  <link rel="stylesheet" href="concerts.css" />
  <style>
    .admin-wrapper {
      max-width: 900px;
      margin: 50px auto;
      padding: 0 20px;
    }

    .login-form {
      background-color: #1f1f1f;
      padding: 35px;
      border-radius: 16px;
      max-width: 400px;
      margin: 100px auto;
    }

    .login-form h2 {
      margin: 0 0 20px 0;
      font-size: 24px;
      text-transform: uppercase;
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

    .form-group input {
      padding: 12px;
      border-radius: 8px;
      border: none;
      font-size: 14px;
      background-color: #2e2e2e;
      color: #fff;
    }

    .submit-btn {
      width: 100%;
      padding: 14px;
      background-color: #5a1b7e;
      color: #fff;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
      font-family: 'Poppins', sans-serif;
    }

    .submit-btn:hover {
      background-color: #7c3eb0;
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

    .admin-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .admin-header h2 {
      font-size: 24px;
      text-transform: uppercase;
      margin: 0;
    }

    .logout-btn {
      padding: 10px 20px;
      background-color: #3a1a1a;
      color: #e53935;
      border: 1px solid #e53935;
      border-radius: 8px;
      cursor: pointer;
      font-size: 14px;
      font-family: 'Poppins', sans-serif;
      transition: background-color 0.3s;
    }

    .logout-btn:hover {
      background-color: #e53935;
      color: #fff;
    }

    .messages-table {
      width: 100%;
      border-collapse: collapse;
      background-color: #1f1f1f;
      border-radius: 12px;
      overflow: hidden;
    }

    .messages-table th {
      background-color: #2b0e38;
      color: #fff;
      padding: 14px;
      text-align: left;
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .messages-table td {
      padding: 14px;
      border-bottom: 1px solid #2e2e2e;
      font-size: 14px;
      color: #ccc;
      vertical-align: top;
    }

    .messages-table tr:last-child td {
      border-bottom: none;
    }

    .messages-table tr:hover td {
      background-color: #2a2a2a;
    }

    .badge {
      display: inline-block;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 500;
    }

    .badge-proposition { background-color: #1a3a1a; color: #4caf50; }
    .badge-signalement  { background-color: #3a1a1a; color: #e53935; }
    .badge-suggestion   { background-color: #1a2a3a; color: #64b5f6; }
    .badge-autre        { background-color: #2e2e2e; color: #aaa; }

    .empty-message {
      text-align: center;
      color: #aaa;
      padding: 40px;
      background-color: #1f1f1f;
      border-radius: 12px;
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

<div class="admin-wrapper">

<?php if (!isset($_SESSION['admin'])) : ?>

  <!-- FORMULAIRE DE CONNEXION -->
  <div class="login-form">
    <h2>🔒 Accès Admin</h2>

    <?php if (isset($erreur)) : ?>
      <div class="message-erreur">⚠️ <?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST" action="admin.php">
      <div class="form-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <button type="submit" class="submit-btn">Se connecter</button>
    </form>
  </div>

<?php else : ?>

  <!-- TABLEAU DES MESSAGES -->
  <?php
  require 'vendor/autoload.php';

  $client = new MongoDB\Client("mongodb://localhost:27017");
  $collection = $client->discovery_live->contacts;
  $documents = $collection->find([], ['sort' => ['created_at' => -1]]);
  $messages = iterator_to_array($documents);
  ?>

  <div class="admin-header">
    <h2>📬 Messages reçus (<?= count($messages) ?>)</h2>
    <form method="POST">
      <button type="submit" name="logout" class="logout-btn">Se déconnecter</button>
    </form>
  </div>

  <?php if (empty($messages)) : ?>
    <div class="empty-message">Aucun message reçu pour le moment.</div>
  <?php else : ?>
    <table class="messages-table">
      <thead>
        <tr>
          <th>Type</th>
          <th>Nom</th>
          <th>Email</th>
          <th>Message</th>
          <th>Détails</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($messages as $doc) : ?>
          <?php
          $type = $doc['type'] ?? 'autre';
          $date = $doc['created_at'] ? date('d/m/Y H:i', $doc['created_at']->toDateTime()->getTimestamp()) : '-';
          ?>
          <tr>
            <td>
              <span class="badge badge-<?= htmlspecialchars($type) ?>">
                <?= match($type) {
                  'proposition' => '🎵 Proposition',
                  'signalement' => '⚠️ Signalement',
                  'suggestion'  => '💡 Suggestion',
                  default       => '✉️ Autre'
                } ?>
              </span>
            </td>
            <td><?= htmlspecialchars($doc['nom'] ?? '-') ?></td>
            <td><?= htmlspecialchars($doc['email'] ?? '-') ?></td>
            <td><?= htmlspecialchars($doc['message'] ?? '-') ?></td>
            <td>
              <?php if ($type === 'proposition') : ?>
                <?php if (!empty($doc['artiste'])) : ?>
                  🎤 <?= htmlspecialchars($doc['artiste']) ?><br>
                <?php endif; ?>
                <?php if (!empty($doc['date'])) : ?>
                  📅 <?= htmlspecialchars($doc['date']) ?><br>
                <?php endif; ?>
                <?php if (!empty($doc['lien'])) : ?>
                  🔗 <a href="<?= htmlspecialchars($doc['lien']) ?>" target="_blank" style="color:#9a63d1;">Voir</a>
                <?php endif; ?>
              <?php else : ?>
                -
              <?php endif; ?>
            </td>
            <td><?= $date ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

<?php endif; ?>

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

</body>
</html>