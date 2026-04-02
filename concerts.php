<?php 
require 'connexion.php';

$genres = ['metal', 'rock', 'rap', 'variete', 'reggae', 'electro'];
$titres = [
    'metal' => 'Metal',
    'rock' => 'Rock',
    'rap' => 'Rap US',
    'variete' => "Variet' Française",
    'reggae' => 'Reggae',
    'electro' => 'Électro'
];

// Récupérer les filtres
$filtreDate  = isset($_POST['date'])  && $_POST['date']  !== '' ? $_POST['date']  : null;
$filtreGenre = isset($_POST['genre']) && $_POST['genre'] !== '' ? $_POST['genre'] : null;
$filtrePrix  = isset($_POST['prix'])  && $_POST['prix']  !== '' ? (float)$_POST['prix'] : null;
$filtreSalle = isset($_POST['salle']) && $_POST['salle'] !== '' ? $_POST['salle'] : null;

$filtreActif = $filtreDate || $filtreGenre || $filtrePrix || $filtreSalle;

if ($filtreActif) {
    // --- MODE FILTRÉ : une seule requête avec conditions ---
    $sql = "
        SELECT c.*, s.nom AS nom_salle, s.type AS type_salle
        FROM concerts c
        JOIN salles s ON c.id_salle = s.id
        WHERE 1=1
    ";
    $params = [];

    if ($filtreDate) {
        $sql .= " AND c.date_concert >= ?";
        $params[] = $filtreDate;
    }
    if ($filtreGenre) {
        $sql .= " AND c.genre = ?";
        $params[] = $filtreGenre;
    }
    if ($filtrePrix) {
        $sql .= " AND c.prix_min <= ?";
        $params[] = $filtrePrix;
    }
    if ($filtreSalle) {
        $sql .= " AND s.type = ?";
        $params[] = $filtreSalle;
    }

    $sql .= " ORDER BY c.date_concert ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $concertsFiltres = $stmt->fetchAll();

} else {
    // --- MODE NORMAL : groupé par genre ---
    $concertsParGenre = [];
    foreach ($genres as $genre) {
        $stmt = $pdo->prepare("
            SELECT c.*, s.nom AS nom_salle 
            FROM concerts c
            JOIN salles s ON c.id_salle = s.id
            WHERE c.genre = ?
            ORDER BY c.date_concert ASC
        ");
        $stmt->execute([$genre]);
        $concertsParGenre[$genre] = $stmt->fetchAll();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concerts</title>
    <link rel="stylesheet" href="concerts.css">
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
    <h1>Concerts</h1>
    <p>Découvrez les prochains concerts par catégories</p>
</section>

<!-- FORMULAIRE DE FILTRAGE -->
<section class="filter-form">
  <button class="filter-toggle">🔍 Filtrer les concerts</button>
  <div class="filter-content">
    <form id="filterForm" action="concerts.php" method="POST">
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($_POST['date'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label for="genre">Genre</label>
        <select id="genre" name="genre">
          <option value="">Tous</option>
          <option value="metal"   <?= ($filtreGenre === 'metal')   ? 'selected' : '' ?>>Metal</option>
          <option value="rock"    <?= ($filtreGenre === 'rock')    ? 'selected' : '' ?>>Rock</option>
          <option value="rap"     <?= ($filtreGenre === 'rap')     ? 'selected' : '' ?>>Rap US</option>
          <option value="variete" <?= ($filtreGenre === 'variete') ? 'selected' : '' ?>>Variété Française</option>
          <option value="reggae"  <?= ($filtreGenre === 'reggae')  ? 'selected' : '' ?>>Reggae</option>
          <option value="electro" <?= ($filtreGenre === 'electro') ? 'selected' : '' ?>>Électro</option>
        </select>
      </div>
      <div class="form-group">
        <label for="prix">Prix max</label>
        <input type="number" id="prix" name="prix" placeholder="€" value="<?= htmlspecialchars($_POST['prix'] ?? '') ?>">
      </div>
      <div class="form-group">
        <label for="salle">Type de salle</label>
        <select id="salle" name="salle">
          <option value="">Tous</option>
          <option value="bar"   <?= ($filtreSalle === 'bar')   ? 'selected' : '' ?>>Bar / Petite salle</option>
          <option value="salle" <?= ($filtreSalle === 'salle') ? 'selected' : '' ?>>Salle de concert</option>
          <option value="arena" <?= ($filtreSalle === 'arena') ? 'selected' : '' ?>>Arena / Zénith</option>
        </select>
      </div>
      <div class="form-group submit-btn">
        <button type="submit">Filtrer</button>
      </div>
    </form>
  </div>
</section>

<main>

<?php if ($filtreActif) : ?>

  <!-- MODE FILTRÉ -->
  <div class="events-section">
    <h2 class="category-title">Résultats</h2>
    <?php if (empty($concertsFiltres)) : ?>
      <p style="text-align:center; color:rgba(255,255,255,0.6); padding: 40px;">
        Aucun concert ne correspond à vos critères.
      </p>
    <?php else : ?>
      <div class="events-grid">
        <?php foreach ($concertsFiltres as $concert) : ?>
          <?php $date = date('d/m/Y', strtotime($concert['date_concert'])); ?>
          <div class="event">
            <img src="<?= htmlspecialchars($concert['image']) ?>" alt="<?= htmlspecialchars($concert['artiste']) ?>">
            <div>
              <h4><?= htmlspecialchars($concert['artiste']) ?></h4>
              <p><?= ucfirst($concert['genre']) ?> – <?= $date ?></p>
              <p class="price">
                <?= $concert['prix_min'] == 0 
                    ? '🎉 Concert gratuit' 
                    : 'À partir de ' . number_format($concert['prix_min'], 0) . '€' 
                ?>
                </p>
              <button onclick="window.location.href='artiste.php?id=<?= $concert['id'] ?>'">Plus d'infos</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
    <div style="text-align:center; margin-top:20px;">
      <a href="concerts.php" style="color:#9a63d1;">✕ Réinitialiser les filtres</a>
    </div>
  </div>

<?php else : ?>

  <!-- MODE NORMAL PAR GENRE -->
  <?php foreach ($genres as $genre) : ?>
    <?php if (!empty($concertsParGenre[$genre])) : ?>
    <div class="events-section" id="<?= $genre ?>">
      <h2 class="category-title"><?= $titres[$genre] ?></h2>
      <div class="events-grid">
        <?php foreach ($concertsParGenre[$genre] as $index => $concert) : ?>
          <?php $date = date('d/m/Y', strtotime($concert['date_concert'])); ?>
          <div class="event <?= $index >= 3 ? 'hidden' : '' ?>">
            <img src="<?= htmlspecialchars($concert['image']) ?>" alt="<?= htmlspecialchars($concert['artiste']) ?>">
            <div>
              <h4><?= htmlspecialchars($concert['artiste']) ?></h4>
              <p><?= ucfirst($concert['genre']) ?> – <?= $date ?></p>
              <p class="price">À partir de <?= number_format($concert['prix_min'], 0) ?>€</p>
              <button onclick="window.location.href='artiste.php?id=<?= $concert['id'] ?>'">Plus d'infos</button>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="center-btn"><button class="voir-plus-btn">Voir plus</button></div>
    </div>
    <?php endif; ?>
  <?php endforeach; ?>

<?php endif; ?>

</main>

<footer>
  <div class="footer-content">
    <p>© 2025 Discovery Live. Tous droits réservés.</p>
    <div class="footer-links">
      <a href="index.php">Accueil</a>
      <a href="decouvrir.html">Découvrir</a>
      <a href="concerts.php">Concerts</a>
      <a href="contacts">Contact</a>
    </div>
  </div>
</footer>

<script>
  const toggleBtn = document.querySelector(".filter-toggle");
  const filterContent = document.querySelector(".filter-content");
  toggleBtn.addEventListener("click", () => {
    filterContent.classList.toggle("active");
  });

  document.querySelectorAll(".voir-plus-btn").forEach(btn => {
    const section = btn.closest(".events-section");
    const hiddenEvents = Array.from(section.querySelectorAll(".event.hidden"));

    if (hiddenEvents.length === 0) {
      btn.closest(".center-btn").style.display = "none";
      return;
    }

    btn.addEventListener("click", () => {
      const isExpanded = btn.getAttribute("data-expanded") === "true";
      if (!isExpanded) {
        hiddenEvents.forEach(event => {
          event.style.display = "flex";
          event.style.animation = "fadeIn 0.4s ease";
        });
        btn.textContent = "Voir moins";
        btn.setAttribute("data-expanded", "true");
      } else {
        hiddenEvents.forEach(event => {
          event.style.display = "none";
        });
        btn.textContent = "Voir plus";
        btn.setAttribute("data-expanded", "false");
        section.scrollIntoView({ behavior: "smooth", block: "start" });
      }
    });
  });
</script>

</body>
</html>