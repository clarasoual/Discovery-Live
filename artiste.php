<?php
require 'connexion.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("
    SELECT c.*, s.nom AS nom_salle, s.ville
    FROM concerts c
    JOIN salles s ON c.id_salle = s.id
    WHERE c.id = ?
");
$stmt->execute([$id]);
$concert = $stmt->fetch();

if (!$concert) {
    header('Location: concerts.php');
    exit;
}

$date = date('d/m/Y', strtotime($concert['date_concert']));
$heure = date('H:i', strtotime($concert['heure']));
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($concert['artiste']) ?> – Discovery Live</title>
  <link rel="stylesheet" href="novelists.css" />
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

<section class="artist-wrapper">
  <div class="artist-card">

    <!-- IMAGE À GAUCHE -->
    <div class="artist-left">
      <img src="<?= htmlspecialchars($concert['image']) ?>" alt="<?= htmlspecialchars($concert['artiste']) ?>">
    </div>

    <!-- TEXTE À DROITE -->
    <div class="artist-right">

      <h1 class="band-name"><?= htmlspecialchars($concert['artiste']) ?></h1>
      <h2 class="genre"><?= htmlspecialchars(ucfirst($concert['genre'])) ?></h2>

      <div class="date-block">
        <p>📅 <?= $date ?> - <?= $heure ?></p>
        <p>📍 <?= htmlspecialchars($concert['nom_salle']) ?> - <?= htmlspecialchars($concert['ville']) ?></p>
      </div>

      <div class="listen-wrapper">
        <p class="listen-title">Écouter sur</p>
        <div class="listen-icons">
          <?php if ($concert['lien_spotify']) : ?>
          <a href="<?= htmlspecialchars($concert['lien_spotify']) ?>" target="_blank">
            <img src="IMAGES/spotify.png" alt="Spotify">
          </a>
          <?php endif; ?>

          <?php if ($concert['lien_youtube']) : ?>
          <a href="<?= htmlspecialchars($concert['lien_youtube']) ?>" target="_blank">
            <img src="IMAGES/youtube.png" alt="YouTube">
          </a>
          <?php endif; ?>

          <?php if ($concert['lien_applemusic']) : ?>
          <a href="<?= htmlspecialchars($concert['lien_applemusic']) ?>" target="_blank">
            <img src="IMAGES/applemusic.png" alt="Apple Music">
          </a>
          <?php endif; ?>

          <?php if ($concert['lien_deezer']) : ?>
          <a href="<?= htmlspecialchars($concert['lien_deezer']) ?>" target="_blank">
            <img src="IMAGES/deezer.png" alt="Deezer">
          </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="description-wrapper">
        <p class="description">
          <?= nl2br(htmlspecialchars($concert['description'])) ?>
        </p>
      </div>

      <button class="reserve-btn">
        <a href="<?= htmlspecialchars($concert['lien_reservation']) ?>" target="_blank">Réserver</a>
      </button>

    </div>
  </div>
</section>

<footer>
  <div class="footer-content">
    <p>© 2025 Discovery Live. Tous droits réservés.</p>
    <div class="footer-links">
      <a href="index.php">Accueil</a>
      <a href="decouvrir.html">Découvrir</a>
      <a href="concerts.php">Concerts</a>
      <a href="proposer.php">Proposer</a>
    </div>
  </div>
</footer>

</body>
</html>