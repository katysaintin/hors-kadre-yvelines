<?php

/*
 * Hors Kadre — Data Exploration Tool
 * Copyright (c) 2026 Katy Saintin
 *
 * Code: MIT License
 * Content and analysis: CC BY-NC 4.0
 *
 * https://creativecommons.org/licenses/by-nc/4.0/
 *
 * Author: Katy Saintin 
 */
 
include('config.php');
include('functions.php');

connect_db();

/*
 * Legacy hosting compatible version
 * - mysql_* only
 * - no PDO
 * - no modern PHP syntax
 * - light queries only
 */

$q = isset($_GET['q']) ? trim($_GET['q']) : '';
$academie = isset($_GET['academie']) ? trim($_GET['academie']) : '';
$departement = isset($_GET['departement']) ? trim($_GET['departement']) : '';
$statut = isset($_GET['statut']) ? trim($_GET['statut']) : '';
$ville = isset($_GET['ville']) ? trim($_GET['ville']) : '';
$scope = isset($_GET['scope']) ? trim($_GET['scope']) : '';
$voie  = isset($_GET['voie'])  ? trim($_GET['voie'])  : '';
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'score_global';
$order = isset($_GET['order']) ? strtolower(trim($_GET['order'])) : 'desc';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

$perPage = 20;
$maxRows = 50;

$allowedSorts = array(
    'nom',
    'ville',
    'departement',
    'academie',
    'statut',
    'ival',
    'taux_bac',
    'taux_mentions',
    'effectif_seconde',
    'effectif_terminale',
    'evolution_effectif',
    'score_mentions',
    'score_global'
);

if (!in_array($sort, $allowedSorts)) {
    $sort = 'evolution_effectif';
}

if ($order !== 'asc' && $order !== 'desc') {
    $order = 'desc';
}

/*
 * Default filter
 */
if ($q === '' && $academie === '' && $departement === '' && $statut === '' && $ville === '' && $scope !== 'all') {
    $ville = 'Montigny';
}

/*
 * Load filter values
 */
$academies = array();
$sqlAcademies = "SELECT DISTINCT academie FROM lycees WHERE academie IS NOT NULL AND academie <> '' ORDER BY academie ASC";
$resultAcademies = mysql_query($sqlAcademies);

if ($resultAcademies) {
    $rowAcademie = mysql_fetch_assoc($resultAcademies);

    while ($rowAcademie) {
        if (isset($rowAcademie['academie'])) {
            $academies[] = $rowAcademie['academie'];
        }
        $rowAcademie = mysql_fetch_assoc($resultAcademies);
    }
}

$departements = array();
$sqlDepartements = "SELECT DISTINCT departement FROM lycees WHERE departement IS NOT NULL AND departement <> '' ORDER BY departement ASC";
$resultDepartements = mysql_query($sqlDepartements);

if ($resultDepartements) {
    $rowDepartement = mysql_fetch_assoc($resultDepartements);

    while ($rowDepartement) {
        if (isset($rowDepartement['departement'])) {
            $departements[] = $rowDepartement['departement'];
        }
        $rowDepartement = mysql_fetch_assoc($resultDepartements);
    }
}

$statuts = array();
$sqlStatuts = "SELECT DISTINCT statut FROM lycees WHERE statut IS NOT NULL AND statut <> '' ORDER BY statut ASC";
$resultStatuts = mysql_query($sqlStatuts);

if ($resultStatuts) {
    $rowStatut = mysql_fetch_assoc($resultStatuts);

    while ($rowStatut) {
        if (isset($rowStatut['statut'])) {
            $statuts[] = $rowStatut['statut'];
        }
        $rowStatut = mysql_fetch_assoc($resultStatuts);
    }
}

/*
 * Build filters
 */
$whereParts = array();

if ($ville !== '') {
    $whereParts[] = "ville LIKE '%" . sql_escape($ville) . "%'";
}

if ($departement !== '') {
    $whereParts[] = "departement LIKE '%" . sql_escape($departement) . "%'";
}

if ($academie !== '') {
    $whereParts[] = "academie = '" . sql_escape($academie) . "'";
}

if ($statut !== '') {
    $whereParts[] = "statut = '" . sql_escape($statut) . "'";
}

if ($q !== '') {
    $whereParts[] = "nom LIKE '%" . sql_escape($q) . "%'";
}

if ($voie !== '') {
    $whereParts[] = "voie = '" . sql_escape($voie) . "'";
}

$where = '';
if (count($whereParts) > 0) {
    $where = ' WHERE ' . implode(' AND ', $whereParts);
}

/*
 * Count rows
 */
$countSql = "SELECT COUNT(*) AS total FROM lycees" . $where;
$countResult = mysql_query($countSql);

$totalRows = 0;
if ($countResult) {
    $countRow = mysql_fetch_assoc($countResult);
    if ($countRow && isset($countRow['total'])) {
        $totalRows = intval($countRow['total']);
    }
}

/*
 * Load CPGE/BTS presence per lycee via cartographie_formations
 * Grouped by uai - tells us if lycee hosts a CPGE or BTS
 */
$formations_lycees = array();
$sql_form_lycees = "SELECT code_uai,
    MAX(CASE WHEN type_formation LIKE '%CPGE%' OR type_formation LIKE '%Classe préparatoire%' THEN 1 ELSE 0 END) AS has_cpge,
    MAX(CASE WHEN type_formation LIKE '%BTS%' THEN 1 ELSE 0 END) AS has_bts
FROM cartographie_formations
WHERE session = 2026
AND code_uai IS NOT NULL AND code_uai != ''
GROUP BY code_uai";
$res_fl = mysql_query($sql_form_lycees);
if ($res_fl) {
    while ($rfl = mysql_fetch_assoc($res_fl)) {
        $formations_lycees[$rfl['code_uai']] = $rfl;
    }
}

/*
 * Hard limit
 */
$displayableRows = min($totalRows, $maxRows);
$totalPages = max(1, intval(ceil($displayableRows / $perPage)));

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset = ($page - 1) * $perPage;

if ($offset >= $maxRows) {
    $offset = 0;
    $page = 1;
}

$limitForPage = min($perPage, $maxRows - $offset);
if ($limitForPage < 1) {
    $limitForPage = $perPage;
}

/*
 * Main query
 */
$sql = "SELECT
            id,
            nom,
            ville,
            departement,
            academie,
            statut,
            uai,
            fiche_ival_url,
            ival,
            taux_bac,
            taux_mentions,
            effectif_seconde,
            effectif_terminale,
            evolution_effectif,
            score_mentions,
            score_global,
            source_annee,
            voie
        FROM lycees
        " . $where . "
        ORDER BY " . $sort . " " . $order . ", nom ASC
        LIMIT " . intval($limitForPage) . "
        OFFSET " . intval($offset);

$resultRows = mysql_query($sql);
$rows = fetch_all_assoc($resultRows);

/*
 * Local helpers
 */
function safe_html($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function fmt_num($value, $decimals)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return number_format((float)$value, (int)$decimals, ',', ' ');
}

function fmt_int_local($value)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return number_format((int)$value, 0, ',', ' ');
}

function fmt_signed_local($value)
{
    if ($value === null || $value === '') {
        return '-';
    }

    $v = (int)$value;

    if ($v > 0) {
        return '+' . $v;
    }

    return (string)$v;
}

function build_page_url($pageNumber)
{
	$params = $_GET;
    $params['page'] = intval($pageNumber);

    return '?' . build_query_string($params);
}

function sort_label($sort)
{
    if ($sort === 'nom') {
        return 'Nom du lycee';
    }
    if ($sort === 'ville') {
        return 'Ville';
    }
    if ($sort === 'departement') {
        return 'Departement';
    }
    if ($sort === 'academie') {
        return 'Academie';
    }
    if ($sort === 'statut') {
        return 'Statut';
    }
    if ($sort === 'ival') {
        return 'IVAL';
    }
    if ($sort === 'taux_bac') {
        return 'Taux de reussite au bac';
    }
    if ($sort === 'taux_mentions') {
        return 'Taux de mentions';
    }
    if ($sort === 'effectif_seconde') {
        return 'Effectif de seconde';
    }
    if ($sort === 'effectif_terminale') {
        return 'Effectif de terminale';
    }
    if ($sort === 'evolution_effectif') {
        return 'Evolution des effectifs';
    }
    if ($sort === 'score_mentions') {
        return 'Mentions ponderees';
    }
    return 'Score global';
}

function order_label($order)
{
    if ($order === 'asc') {
        return 'croissant';
    }
    return 'decroissant';
}

$currentSortLabel = sort_label($sort);
$currentOrderLabel = order_label($order);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Comparer les lycées — Hors Kadre</title>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-TTTNJ36H5D', { 'anonymize_ip': true });
</script>
<style>
:root{--navy:#1B3A6B;--terra:#C4572A;--offwhite:#F5F0EB;
  --gray:#555;--border:#d9d1ca;--white:#fff;}
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

.container{max-width:100%;margin:0 auto;padding:24px 16px 60px;}

/* PAGE TITLE */
.page-title{font-size:1.3rem;color:var(--terra);font-weight:700;margin-bottom:4px;}
.page-sub{font-size:.82rem;color:var(--gray);margin-bottom:16px;line-height:1.6;}

/* FILTRES */
.filtres-panel{background:var(--offwhite);border:1px solid var(--border);
  border-radius:12px;padding:16px 18px;margin-bottom:16px;}
.filtres-panel h2{font-size:.82rem;font-weight:700;color:var(--gray);
  text-transform:uppercase;letter-spacing:.08em;margin-bottom:12px;}
.filtres-grid{display:grid;
  grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
  gap:10px;align-items:end;}
.field label{display:block;font-size:.8rem;font-weight:600;
  color:var(--gray);margin-bottom:4px;}
.field input,.field select{width:100%;padding:8px 12px;
  border:1px solid var(--border);border-radius:8px;
  background:var(--white);color:var(--navy);
  font-family:Georgia,serif;font-size:.85rem;}
.field input:focus,.field select:focus{outline:none;border-color:var(--terra);}
.actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap;}
.btn{display:inline-block;padding:8px 16px;border-radius:8px;
  font-family:Georgia,serif;font-size:.85rem;font-weight:600;
  cursor:pointer;text-decoration:none;}
.btn-primary{background:var(--terra);color:#fff;border:none;}
.btn-primary:hover{background:#a8452a;color:#fff;text-decoration:none;}
.btn-secondary{background:var(--white);color:var(--navy);
  border:1px solid var(--border);}
.btn-secondary:hover{background:var(--offwhite);text-decoration:none;}

/* STATS */
.meta{font-size:.82rem;color:var(--gray);margin-top:8px;}
.warning{color:var(--terra);font-size:.82rem;font-weight:600;margin-top:6px;}

/* TABLE */
.table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;
  border:1px solid var(--border);border-radius:10px;
  box-shadow:0 4px 18px rgba(27,58,107,.04);}
table{width:100%;border-collapse:collapse;font-size:.82rem;
  min-width:900px;}
thead th{background:var(--navy);color:#fff;padding:10px 12px;
  text-align:left;white-space:nowrap;font-weight:600;
  font-family:Georgia,serif;}
thead th a{color:#fff;text-decoration:none;}
thead th a:hover{text-decoration:underline;color:#fcd34d;}
thead th.num{text-align:right;}
tbody tr{border-bottom:1px solid var(--border);}
tbody tr:last-child{border-bottom:none;}
tbody tr:nth-child(even){background:#fbf8f5;}
tbody tr:hover{background:var(--offwhite);}
tbody td{padding:9px 12px;vertical-align:middle;}
tbody td.num{text-align:right;font-variant-numeric:tabular-nums;}

/* BADGES */
.badge{display:inline-block;padding:2px 8px;border-radius:8px;
  font-size:.7rem;font-weight:700;white-space:nowrap;}
.badge-cpge{background:#fef3c7;color:#92400e;border:1px solid #fcd34d;}
.badge-bts{background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;}
.badge-pub{background:#d1fae5;color:#065f46;}
.badge-pri{background:#ede9fe;color:#4c1d95;}

/* IVAL couleur */
.ival-pos{color:#2d8a4e;font-weight:700;}
.ival-neg{color:#C4572A;font-weight:700;}
.ival-neu{color:var(--gray);}

.rank-badge{display:inline-flex;align-items:center;justify-content:center;
  min-width:28px;padding:3px 6px;border-radius:999px;
  background:rgba(27,58,107,.08);color:var(--navy);font-weight:700;}

.lycee-link{color:var(--navy);font-weight:700;text-decoration:none;}
.lycee-link:hover{color:var(--terra);}
.detail-btn{display:inline-block;padding:4px 10px;border:1px solid var(--navy);
  border-radius:6px;font-size:.78rem;font-weight:600;
  color:var(--navy);text-decoration:none;}
.detail-btn:hover{background:var(--navy);color:#fff;text-decoration:none;}

/* PAGINATION */
.pagination{display:flex;gap:6px;flex-wrap:wrap;
  margin-top:16px;justify-content:center;}
.pagination a,.pagination span{padding:6px 12px;border-radius:6px;
  border:1px solid var(--border);font-size:.85rem;
  text-decoration:none;color:var(--navy);}
.pagination a:hover{background:var(--terra);color:#fff;border-color:var(--terra);}
.pagination span.current{background:var(--navy);color:#fff;border-color:var(--navy);}

footer{text-align:center;color:var(--gray);font-size:.78rem;
  margin-top:28px;padding-top:14px;
  border-top:1px solid var(--border);line-height:1.9;}
footer a{color:var(--terra);}

#rgpd{position:fixed;bottom:0;left:0;right:0;background:var(--navy);
  color:#F5F0EB;padding:12px 20px;font-size:13px;
  display:flex;justify-content:space-between;align-items:center;
  z-index:9999;font-family:Georgia,serif;}
#rgpd a{color:var(--terra);}
#rgpd button{background:var(--terra);color:#fff;border:none;
  padding:8px 16px;cursor:pointer;border-radius:4px;
  margin-left:20px;white-space:nowrap;font-size:13px;}

@media(max-width:600px){
  .filtres-grid{grid-template-columns:1fr 1fr;}
  #rgpd{flex-direction:column;gap:8px;text-align:center;}
}
</style>
</head>
<body>

<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="nav-links">
    <a href="index.php">← Accueil</a>
    <a href="parcoursup.php">Parcoursup</a>
    <a href="doublettes.php">Spécialités</a>
    <a href="aide.html" style="color:var(--terra);font-weight:700;">❓ Guide</a>
    <a href="acronymes.html">📖 Lexique</a>
  </div>
</header>

<div class="container">

  <h1 class="page-title">Comparer les lycées — IVAL 2025</h1>
  <p class="page-sub">
    Classement exploratoire basé sur des données publiques.
    Cliquez sur les en-têtes de colonnes pour trier.
    Cliquez sur "Voir" pour la fiche complète d'un lycée.
  </p>

  <!-- FILTRES -->
  <div class="filtres-panel">
    <h2>Filtres</h2>
    <form method="get" action="">
      <!-- Conserver sort/order dans l'URL -->
      <input type="hidden" name="sort"  value="<?php echo safe_html($sort); ?>">
      <input type="hidden" name="order" value="<?php echo safe_html($order); ?>">
      <?php if($scope !== ''): ?>
      <input type="hidden" name="scope" value="<?php echo safe_html($scope); ?>">
      <?php endif; ?>
      <div class="filtres-grid">
        <div class="field">
          <label for="q">Nom du lycée</label>
          <input type="text" name="q" id="q"
                 value="<?php echo safe_html($q); ?>"
                 placeholder="Descartes…">
        </div>
        <div class="field">
          <label for="ville">Ville</label>
          <input type="text" name="ville" id="ville"
                 value="<?php echo safe_html($ville); ?>"
                 placeholder="Montigny…">
        </div>
        <div class="field">
          <label for="departement">Département</label>
          <select name="departement" id="departement">
            <option value="">Tous</option>
            <?php foreach($departements as $item):
              $sel = ($departement === (string)$item) ? 'selected' : ''; ?>
              <option value="<?php echo safe_html($item); ?>" <?php echo $sel; ?>>
                <?php echo safe_html($item); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label for="academie">Académie</label>
          <select name="academie" id="academie">
            <option value="">Toutes</option>
            <?php foreach($academies as $item):
              $sel = ($academie === (string)$item) ? 'selected' : ''; ?>
              <option value="<?php echo safe_html($item); ?>" <?php echo $sel; ?>>
                <?php echo safe_html($item); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label for="statut">Statut</label>
          <select name="statut" id="statut">
            <option value="">Tous</option>
            <?php foreach($statuts as $item):
              $sel = ($statut === (string)$item) ? 'selected' : ''; ?>
              <option value="<?php echo safe_html($item); ?>" <?php echo $sel; ?>>
                <?php echo safe_html($item); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="field">
          <label for="voie">Voie</label>
          <select name="voie" id="voie">
            <option value="">Toutes</option>
            <option value="LGT" <?php echo $voie === 'LGT' ? 'selected' : ''; ?>>
              🎓 Général & Techno (LGT)</option>
            <option value="LP"  <?php echo $voie === 'LP'  ? 'selected' : ''; ?>>
              🔧 Professionnel (LP)</option>
          </select>
        </div>
        <div class="actions">
          <button type="submit" class="btn btn-primary">Filtrer</button>
          <a href="indexival.php" class="btn btn-secondary">✕ Réinit.</a>
          <a href="indexival.php?scope=all" class="btn btn-secondary">Tous →</a>
        </div>
      </div>
    </form>
    <p class="meta">
      <?php echo $displayableRows; ?> lycée<?php echo $displayableRows > 1 ? 's' : ''; ?>
      affiché<?php echo $displayableRows > 1 ? 's' : ''; ?>
      sur <?php echo $totalRows; ?> résultat<?php echo $totalRows > 1 ? 's' : ''; ?>.
    </p>
    <?php if($totalRows > $maxRows): ?>
    <p class="warning">Seuls les <?php echo $maxRows; ?> premiers résultats sont affichés — affinez votre recherche.</p>
    <?php endif; ?>
  </div>

  <!-- TABLEAU -->
  <div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th class="num">Rang</th>
        <th>
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'nom','order'=>$sort==='nom'&&$order==='asc'?'desc':'asc','page'=>1)))); ?>">
            Lycée<?php echo $sort==='nom'?($order==='asc'?' ↑':' ↓'):''; ?>
          </a>
        </th>
        <th>Ville</th>
        <th>Dép.</th>
        <th>Statut</th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'ival','order'=>$sort==='ival'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            IVAL<?php echo $sort==='ival'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'taux_bac','order'=>$sort==='taux_bac'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            Bac%<?php echo $sort==='taux_bac'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'taux_mentions','order'=>$sort==='taux_mentions'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            Mentions%<?php echo $sort==='taux_mentions'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'effectif_seconde','order'=>$sort==='effectif_seconde'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            Seconde<?php echo $sort==='effectif_seconde'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'effectif_terminale','order'=>$sort==='effectif_terminale'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            Terminale<?php echo $sort==='effectif_terminale'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th class="num">
          <a href="?<?php echo safe_html(build_query_string(array_merge($_GET,array('sort'=>'evolution_effectif','order'=>$sort==='evolution_effectif'&&$order==='desc'?'asc':'desc','page'=>1)))); ?>">
            Évol.<?php echo $sort==='evolution_effectif'?($order==='desc'?' ↓':' ↑'):''; ?>
          </a>
        </th>
        <th style="text-align:center;">CPGE</th>
        <th style="text-align:center;">BTS</th>
        <th>Fiche</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if (!$rows) {
        echo '<tr><td colspan="14" style="padding:20px;color:var(--gray);font-style:italic;">Aucun résultat.</td></tr>';
    } else {
        $rank = $offset + 1;
        foreach ($rows as $row) {
            $ficheUrl    = 'fiche.php?id=' . urlencode($row['id']);
            $officialUrl = isset($row['fiche_ival_url']) ? trim((string)$row['fiche_ival_url']) : '';
            $ival_val    = isset($row['ival']) && $row['ival'] !== '' ? floatval($row['ival']) : null;
            $ival_cls    = $ival_val === null ? 'ival-neu' : ($ival_val >= 0 ? 'ival-pos' : 'ival-neg');
            $ival_str    = $ival_val === null ? '—' : ($ival_val > 0 ? '+' : '') . number_format($ival_val, 1, ',', ' ');
            $uai         = isset($row['uai']) ? $row['uai'] : '';
            $fl          = isset($formations_lycees[$uai]) ? $formations_lycees[$uai] : null;
            $has_cpge    = $fl && intval($fl['has_cpge']) === 1;
            $has_bts     = $fl && intval($fl['has_bts'])  === 1;
            $is_pub      = strpos(strtolower(isset($row['statut'])?$row['statut']:''), 'priv') === false;

            echo '<tr>';
            echo '<td class="num"><span class="rank-badge">' . $rank . '</span></td>';

            echo '<td>';
            echo '<a class="lycee-link" href="' . safe_html($ficheUrl) . '">' . safe_html(isset($row['nom'])?$row['nom']:'') . '</a>';
            if ($officialUrl !== '') {
                echo '<br><a href="' . safe_html($officialUrl) . '" target="_blank" rel="noopener" style="font-size:.75rem;color:var(--terra);">Fiche officielle ↗</a>';
            }
            echo '</td>';

            echo '<td style="white-space:nowrap;">' . safe_html(isset($row['ville'])?$row['ville']:'') . '</td>';
            echo '<td style="white-space:nowrap;font-size:.78rem;">' . safe_html(isset($row['departement'])?$row['departement']:'') . '</td>';
            $voie_val = isset($row['voie']) ? $row['voie'] : '';
            $voie_badge = $voie_val === 'LP'
                ? '<span style="background:#fce7f3;color:#9d174d;border:1px solid #f9a8d4;border-radius:8px;padding:2px 7px;font-size:.68rem;font-weight:700;">🔧 LP</span>'
                : '<span style="background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7;border-radius:8px;padding:2px 7px;font-size:.68rem;font-weight:700;">🎓 LGT</span>';
            echo '<td><span class="badge ' . ($is_pub ? 'badge-pub' : 'badge-pri') . '">' . safe_html(isset($row['statut'])?$row['statut']:'') . '</span> ' . $voie_badge . '</td>';
            echo '<td class="num ' . $ival_cls . '">' . $ival_str . '</td>';
            echo '<td class="num">' . fmt_num(isset($row['taux_bac'])?$row['taux_bac']:null, 1) . '</td>';
            echo '<td class="num">' . fmt_num(isset($row['taux_mentions'])?$row['taux_mentions']:null, 1) . '</td>';
            echo '<td class="num">' . fmt_int_local(isset($row['effectif_seconde'])?$row['effectif_seconde']:null) . '</td>';
            echo '<td class="num">' . fmt_int_local(isset($row['effectif_terminale'])?$row['effectif_terminale']:null) . '</td>';
            echo '<td class="num">' . fmt_signed_local(isset($row['evolution_effectif'])?$row['evolution_effectif']:null) . '</td>';
            echo '<td style="text-align:center;">' . ($has_cpge ? '<span class="badge badge-cpge">⭐ CPGE</span>' : '<span style="color:#ccc;">—</span>') . '</td>';
            echo '<td style="text-align:center;">' . ($has_bts  ? '<span class="badge badge-bts">📋 BTS</span>'  : '<span style="color:#ccc;">—</span>') . '</td>';
            echo '<td><a class="detail-btn" href="' . safe_html($ficheUrl) . '">Voir</a></td>';
            echo '</tr>';
            $rank++;
        }
    }
    ?>
    </tbody>
  </table>
  </div>

  <!-- PAGINATION -->
  <?php if($totalPages > 1): ?>
  <nav class="pagination">
    <?php if($page > 1): ?>
      <a href="<?php echo safe_html(build_page_url($page-1)); ?>">← Préc.</a>
    <?php endif; ?>
    <?php
    $start = max(1, $page-2); $end = min($totalPages, $page+2);
    for ($i = $start; $i <= $end; $i++) {
        if ($i == $page) echo '<span class="current">'.$i.'</span>';
        else echo '<a href="'.safe_html(build_page_url($i)).'">'.$i.'</a>';
    }
    ?>
    <?php if($page < $totalPages): ?>
      <a href="<?php echo safe_html(build_page_url($page+1)); ?>">Suiv. →</a>
    <?php endif; ?>
  </nav>
  <?php endif; ?>

  <footer>
    ©2026 Katy Saintin — Hors Kadre<br>
    Données Open Data Ministère de l'Éducation nationale 2025 — IVAL<br>
    <a href="legal/apropos.html">À propos</a> |
    <a href="legal/mentions-legales.html">Mentions légales</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a>
  </footer>

</div>

<div id="rgpd">
  <span>Ce site utilise Google Analytics pour mesurer l'audience anonymement.
    <a href="legal/mentions-legales.html">En savoir plus</a></span>
  <button onclick="document.getElementById('rgpd').style.display='none';
    document.cookie='rgpd=1;max-age=31536000;path=/'">J'ai compris</button>
</div>
<script>
  if(document.cookie.indexOf('rgpd=1')>=0)
    document.getElementById('rgpd').style.display='none';
</script>
</body>
</html>
