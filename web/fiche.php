<?php
/*
 * Hors Kadre — Fiche lycée
 * Copyright (c) 2026 Katy Saintin
 * Code: MIT License — Content: CC BY-NC 4.0
 */
include('config.php');
include('functions.php');
connect_db();

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) { die('Fiche introuvable.'); }

/* Main query */
$sql = "SELECT id, nom, ville, departement, academie, statut, voie, uai,
               fiche_ival_url, ival, taux_bac, taux_mentions,
               taux_acces_seconde, effectif_seconde, effectif_premiere,
               effectif_terminale, evolution_effectif, score_mentions,
               source_annee, source_type, source_url
        FROM lycees WHERE id = " . intval($id) . " LIMIT 1";

$result = mysql_query($sql);
$lycee  = $result ? mysql_fetch_assoc($result) : false;
if (!$lycee) { die('Fiche introuvable.'); }

/* Formations hébergées (CPGE, BTS) via cartographie_formations */
$formations_hosted = array();
$uai = isset($lycee['uai']) ? $lycee['uai'] : '';
if ($uai !== '') {
    $sql_form = "SELECT DISTINCT type_formation, nom_long_formation
                 FROM cartographie_formations
                 WHERE code_uai = '" . mysql_real_escape_string($uai) . "'
                 AND session = 2026
                 AND (type_formation LIKE '%CPGE%'
                      OR type_formation LIKE '%BTS%'
                      OR type_formation LIKE '%Classe préparatoire%')
                 ORDER BY type_formation, nom_long_formation
                 LIMIT 30";
    $res_form = mysql_query($sql_form);
    if ($res_form) {
        while ($rf = mysql_fetch_assoc($res_form)) {
            $formations_hosted[] = $rf;
        }
    }
}

$officialUrl = isset($lycee['fiche_ival_url']) ? trim($lycee['fiche_ival_url']) : '';
$ival_val    = isset($lycee['ival']) ? floatval($lycee['ival']) : null;
$ival_color  = ($ival_val !== null) ? ($ival_val >= 0 ? '#2d8a4e' : '#C4572A') : '#666';
$ival_label  = ($ival_val !== null) ? ($ival_val > 0 ? '+' : '') . number_format($ival_val, 1) : '—';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($lycee['nom']); ?> — Hors Kadre</title>
<style>
:root{--navy:#1B3A6B;--terra:#C4572A;--offwhite:#F5F0EB;
  --gold:#B8860B;--gray:#555;--border:#d9d1ca;--white:#fff;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Georgia,"Times New Roman",serif;background:#fcfaf8;
  color:var(--navy);line-height:1.6;}
a{color:var(--terra);text-decoration:none;}
a:hover{text-decoration:underline;}

/* HEADER */
.site-header{background:var(--offwhite);border-bottom:3px solid var(--terra);
  padding:16px;text-align:center;}
.site-header img{max-width:320px;width:50%;height:auto;}
.nav-links{margin-top:8px;font-size:.82rem;}
.nav-links a{margin:0 8px;color:var(--navy);font-weight:600;}
.nav-links a:hover{color:var(--terra);}

.container{max-width:860px;margin:0 auto;padding:24px 16px 60px;}
.back-link{display:inline-block;margin-bottom:16px;
  color:var(--terra);font-weight:600;font-size:.88rem;}

/* HERO lycée */
.lycee-hero{border-left:6px solid var(--gold);
  padding:10px 0 10px 18px;margin-bottom:20px;}
.lycee-hero h1{font-size:1.5rem;color:var(--navy);margin-bottom:4px;line-height:1.3;}
.lycee-hero .sous-titre{color:var(--gray);font-size:.9rem;}
.lycee-hero .tags{margin-top:10px;display:flex;flex-wrap:wrap;gap:8px;}
.badge{display:inline-block;padding:3px 12px;border-radius:10px;
  font-size:.78rem;font-weight:700;}
.badge-cpge{background:#fef3c7;color:#92400e;border:1px solid #fcd34d;}
.badge-bts{background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;}
.badge-pub{background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;}
.badge-pri{background:#ede9fe;color:#4c1d95;border:1px solid #c4b5fd;}

/* IVAL gros chiffre */
.ival-bloc{background:var(--white);border:2px solid var(--border);
  border-radius:14px;padding:20px;margin-bottom:16px;
  display:flex;align-items:center;gap:24px;}
.ival-val{font-size:2.8rem;font-weight:700;line-height:1;}
.ival-label{font-size:.82rem;color:var(--gray);line-height:1.5;}
.ival-label strong{color:var(--navy);display:block;font-size:.9rem;}

/* GRID indicateurs */
.panel{background:var(--offwhite);border:1px solid var(--border);
  border-radius:12px;padding:16px 18px;margin-bottom:14px;}
.panel h2{font-size:.85rem;font-weight:700;color:var(--gray);
  text-transform:uppercase;letter-spacing:.08em;
  margin-bottom:12px;padding-bottom:6px;border-bottom:1px solid var(--border);}
.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
  gap:10px;}
.item{background:var(--white);border:1px solid var(--border);
  border-radius:10px;padding:12px 14px;}
.item .label{display:block;color:var(--gray);font-size:.78rem;margin-bottom:4px;}
.item .value{display:block;font-size:1.1rem;font-weight:700;color:var(--navy);}

/* Formations hébergées */
.formation-list{display:flex;flex-direction:column;gap:6px;}
.formation-item{background:var(--white);border:1px solid var(--border);
  border-radius:8px;padding:8px 12px;font-size:.85rem;}
.formation-item .type-badge{font-size:.72rem;font-weight:700;
  margin-right:8px;padding:1px 8px;border-radius:8px;}

/* Boutons */
.btn-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
.btn{display:inline-block;padding:8px 18px;border-radius:8px;
  font-size:.85rem;font-weight:600;font-family:Georgia,serif;
  text-decoration:none;text-align:center;}
.btn-primary{background:var(--terra);color:#fff;}
.btn-primary:hover{background:#a8452a;color:#fff;text-decoration:none;}
.btn-secondary{background:var(--white);color:var(--navy);
  border:1px solid var(--border);}
.btn-secondary:hover{background:var(--offwhite);text-decoration:none;}

footer{text-align:center;color:var(--gray);font-size:.78rem;
  margin-top:28px;padding-top:14px;border-top:1px solid var(--border);
  line-height:1.9;}
footer a{color:var(--terra);}

@media(max-width:500px){
  .grid{grid-template-columns:repeat(2,1fr);}
  .ival-val{font-size:2.2rem;}
  .lycee-hero h1{font-size:1.2rem;}
}
</style>
</head>
<body>

<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="nav-links">
    <a href="index.php">← Accueil</a>
    <a href="indexival.php">Comparer les lycées</a>
    <a href="parcoursup.php">Parcoursup</a>
    <a href="aide.html" style="color:var(--terra);">❓ Guide</a>
    <a href="acronymes.html">📖 Lexique</a>
  </div>
</header>

<div class="container">

  <a class="back-link" href="indexival.php">← Retour au classement des lycées</a>

  <!-- HERO -->
  <div class="lycee-hero">
    <h1><?php echo e($lycee['nom']); ?></h1>
    <div class="sous-titre">
      <?php echo e($lycee['ville']); ?>
      <?php if(!empty($lycee['departement'])): ?>
        — <?php echo e($lycee['departement']); ?>
      <?php endif; ?>
      <?php if(!empty($lycee['academie'])): ?>
        — Académie de <?php echo e($lycee['academie']); ?>
      <?php endif; ?>
    </div>
    <div class="tags">
      <?php if(!empty($lycee['statut'])): ?>
        <span class="badge <?php echo strpos(strtolower($lycee['statut']),'priv') !== false ? 'badge-pri' : 'badge-pub'; ?>">
          <?php echo e($lycee['statut']); ?>
        </span>
      <?php endif; ?>
      <?php
      $has_cpge = false; $has_bts = false;
      foreach($formations_hosted as $fh) {
          if(strpos($fh['type_formation'],'CPGE') !== false
          || strpos($fh['type_formation'],'Classe préparatoire') !== false) $has_cpge = true;
          if(strpos($fh['type_formation'],'BTS') !== false) $has_bts = true;
      }
      if($has_cpge): ?><span class="badge badge-cpge">⭐ CPGE intégrée</span><?php endif; ?>
      <?php if($has_bts): ?><span class="badge badge-bts">📋 BTS intégré</span><?php endif; ?>
    </div>
  </div>

  <!-- IVAL -->
  <div class="ival-bloc">
    <div class="ival-val" style="color:<?php echo $ival_color; ?>;">
      <?php echo $ival_label; ?>
    </div>
    <div class="ival-label">
      <strong>Score IVAL <?php echo !empty($lycee['source_annee']) ? $lycee['source_annee'] : '2025'; ?></strong>
      Indicateur de Valeur Ajoutée —
      <?php if($ival_val !== null && $ival_val > 2): ?>
        ce lycée fait <strong>nettement mieux</strong> qu'attendu pour ses élèves.
      <?php elseif($ival_val !== null && $ival_val >= 0): ?>
        ce lycée est <strong>dans la moyenne</strong> attendue.
      <?php elseif($ival_val !== null): ?>
        ce lycée est <strong>en dessous</strong> des résultats attendus pour ses élèves.
      <?php else: ?>
        donnée non disponible.
      <?php endif; ?>
      <a href="acronymes.html#ival" style="font-size:.78rem;">Comprendre l'IVAL →</a>
    </div>
  </div>

  <!-- INDICATEURS -->
  <div class="panel">
    <h2>Indicateurs de résultats</h2>
    <div class="grid">
      <div class="item">
        <span class="label">Taux de réussite au bac</span>
        <span class="value"><?php echo $lycee['taux_bac'] ? round(floatval($lycee['taux_bac']),1).'%' : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Taux de mentions</span>
        <span class="value"><?php echo $lycee['taux_mentions'] ? round(floatval($lycee['taux_mentions']),1).'%' : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Taux d'accès Seconde → Bac</span>
        <span class="value"><?php echo $lycee['taux_acces_seconde'] ? round(floatval($lycee['taux_acces_seconde']),1).'%' : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Score mentions pondéré</span>
        <span class="value"><?php echo $lycee['score_mentions'] ? round(floatval($lycee['score_mentions']),1) : '—'; ?></span>
      </div>
    </div>
  </div>

  <!-- EFFECTIFS -->
  <div class="panel">
    <h2>Effectifs</h2>
    <div class="grid">
      <div class="item">
        <span class="label">Effectif Seconde</span>
        <span class="value"><?php echo $lycee['effectif_seconde'] ? intval($lycee['effectif_seconde']) : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Effectif Première</span>
        <span class="value"><?php echo $lycee['effectif_premiere'] ? intval($lycee['effectif_premiere']) : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Effectif Terminale</span>
        <span class="value"><?php echo $lycee['effectif_terminale'] ? intval($lycee['effectif_terminale']) : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Évolution des effectifs</span>
        <span class="value" style="color:<?php echo $lycee['evolution_effectif'] > 0 ? '#2d8a4e' : ($lycee['evolution_effectif'] < 0 ? '#C4572A' : '#666'); ?>;">
          <?php echo $lycee['evolution_effectif'] ? ($lycee['evolution_effectif'] > 0 ? '+' : '').intval($lycee['evolution_effectif']) : '—'; ?>
        </span>
      </div>
    </div>
  </div>

  <!-- FORMATIONS HÉBERGÉES -->
  <?php if(!empty($formations_hosted)): ?>
  <div class="panel">
    <h2>Formations post-bac hébergées</h2>
    <div class="formation-list">
      <?php foreach($formations_hosted as $fh):
        $is_cpge = strpos($fh['type_formation'],'CPGE') !== false
                || strpos($fh['type_formation'],'Classe préparatoire') !== false;
        $badge_cls = $is_cpge ? 'badge-cpge' : 'badge-bts';
        $badge_lbl = $is_cpge ? '⭐ CPGE' : '📋 BTS';
      ?>
        <div class="formation-item">
          <span class="type-badge badge <?php echo $badge_cls; ?>"><?php echo $badge_lbl; ?></span>
          <?php echo e($fh['nom_long_formation']); ?>
        </div>
      <?php endforeach; ?>
    </div>
    <?php if($has_cpge): ?>
    <p style="font-size:.78rem;color:var(--gray);margin-top:10px;font-style:italic;">
      ⚠️ La présence d'une CPGE peut influencer les indicateurs IVAL — les élèves de prépa
      ne sont pas comptabilisés dans les résultats au bac du lycée.
    </p>
    <?php endif; ?>
  </div>
  <?php endif; ?>

  <!-- INFOS -->
  <div class="panel">
    <h2>Informations administratives</h2>
    <div class="grid">
      <div class="item">
        <span class="label">Code UAI</span>
        <span class="value" style="font-size:.9rem;"><?php echo $lycee['uai'] ? e($lycee['uai']) : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Voie</span>
        <span class="value" style="font-size:.9rem;"><?php echo $lycee['voie'] ? e($lycee['voie']) : '—'; ?></span>
      </div>
      <div class="item">
        <span class="label">Source données</span>
        <span class="value" style="font-size:.9rem;"><?php echo $lycee['source_annee'] ? e($lycee['source_annee']) : '—'; ?></span>
      </div>
    </div>
  </div>

  <!-- BOUTONS -->
  <div class="btn-row">
    <?php if($officialUrl !== ''): ?>
    <a href="<?php echo e($officialUrl); ?>" target="_blank" rel="noopener noreferrer"
       class="btn btn-primary">Voir la fiche officielle IVAL ↗</a>
    <?php endif; ?>
    <a href="indexival.php" class="btn btn-secondary">← Retour au classement</a>
  </div>

  <footer>
    ©2026 Katy Saintin — Hors Kadre<br>
    Données Open Data Ministère de l'Éducation nationale 2025<br>
    <a href="legal/apropos.html">À propos</a> |
    <a href="legal/mentions-legales.html">Mentions légales</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a>
  </footer>

</div>
</body>
</html>
