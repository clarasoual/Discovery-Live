<?php require 'connexion.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Discovery Live</title>
  <link rel="stylesheet" href="index.css" />
</head>
<body>

  <!-- HEADER -->
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
    <h1>discovery live</h1>
    <p>Osez la découverte</p>
  </section>

  <div class="intro">
    Bienvenue sur DiscoveryLive, la plateforme qui vous permet de sortir des sentiers battus et de découvrir des concerts selon vos goûts musicaux. Ici, chaque style a sa place : de la pop entraînante au métal énergique, en passant par l'électro hypnotique ou le jazz intimiste. Notre objectif est de vous faire explorer de nouveaux horizons musicaux, de vous présenter des artistes émergents et des événements uniques que vous n'auriez peut-être jamais trouvés ailleurs. Parcourez notre sélection, laissez-vous guider par votre curiosité et trouvez le concert parfait pour vibrer au rythme de la musique.
  </div>

  <h2>les dates à venir</h2>

  <!-- EVENTS -->
  <div class="events-section">
    <h3>Bordeaux</h3>

    <div class="events-grid">

      <?php
      $stmt = $pdo->query("
        SELECT c.*, s.nom AS nom_salle 
        FROM concerts c
        JOIN salles s ON c.id_salle = s.id
        ORDER BY c.date_concert ASC
        LIMIT 4
      ");
      $concerts = $stmt->fetchAll();

      foreach ($concerts as $concert) {
        $date = date('d/m/Y', strtotime($concert['date_concert']));
        ?>
        <div class="event">
          <img src="<?= htmlspecialchars($concert['image']) ?>" alt="<?= htmlspecialchars($concert['artiste']) ?>">
          <div>
            <h4><?= htmlspecialchars($concert['artiste']) ?></h4>
            <p><?= htmlspecialchars(ucfirst($concert['genre'])) ?><br>
               <?= $date ?> – <?= htmlspecialchars($concert['nom_salle']) ?></p>
            <button onclick="window.location.href='artiste.php?id=<?= $concert['id'] ?>'">Plus d'infos</button>
          </div>
        </div>
        <?php
      }
      ?>

    </div>

    <div class="center-btn">
      <button onclick="window.location.href='concerts.php'">Voir plus</button>
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