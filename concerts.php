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

// Récupérer tous les concerts groupés par genre
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

<!-- HERO SECTION -->
<section class="hero">    
    <h1>Concerts</h1>
    <p>Découvrez les prochains concerts par catégories</p>
</section>

<!-- FORMULAIRE DE FILTRAGE -->
<section class="filter-form">
  <button class="filter-toggle">🔍 Filtrer les concerts</button>
  <div class="filter-content">
    <form id="filterForm" action="traitement.php" method="POST">
      <div class="form-group">
        <label for="date">Date</label>
        <input type="date" id="date" name="date">
      </div>
      <div class="form-group">
        <label for="genre">Genre</label>
        <select id="genre" name="genre">
          <option value="">Tous</option>
          <option value="metal">Metal</option>
          <option value="rock">Rock</option>
          <option value="rap">Rap US</option>
          <option value="variete">Variété Française</option>
          <option value="reggae">Reggae</option>
          <option value="electro">Électro</option>
        </select>
      </div>
      <div class="form-group">
        <label for="prix">Prix max</label>
        <input type="number" id="prix" name="prix" placeholder="€">
      </div>
      <div class="form-group">
        <label for="salle">Type de salle</label>
        <select id="salle" name="salle">
          <option value="">Tous</option>
          <option value="10-100">10 à 100 personnes</option>
          <option value="101-500">101 à 500 personnes</option>
          <option value="501-1000">501 à 1000 personnes</option>
          <option value="1001-5000">1001 à 5000 personnes</option>
          <option value="5001+">Plus de 5000 personnes</option>
        </select>
      </div>
      <div class="form-group submit-btn">
        <button type="submit">Filtrer</button>
      </div>
    </form>
  </div>
</section>

<main>

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