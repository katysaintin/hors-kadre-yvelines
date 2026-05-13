<?php
/*
 * Hors Kadre — Parcoursup Décodé
 * Copyright (c) 2026 Katy Saintin
 *
 * Code: MIT License
 * Content and analysis: CC BY-NC 4.0
 *
 * https://creativecommons.org/licenses/by-nc/4.0/
 *
 * Author: Katy Saintin
 *
 * Legacy hosting compatible version
 * - mysql_* only
 * - no PDO
 * - no modern PHP syntax
 * - light queries only
 */

include('config.php');
include('functions.php');

connect_db();

/*
 * Parametres de recherche
 */
$type_formation = isset($_GET['type_formation']) ? trim($_GET['type_formation']) : '';
$specialite     = isset($_GET['specialite'])     ? trim($_GET['specialite'])     : '';
$commune        = isset($_GET['commune'])        ? trim($_GET['commune'])        : '';
$departement    = isset($_GET['departement'])    ? trim($_GET['departement'])    : '';
$selectivite    = isset($_GET['selectivite'])    ? trim($_GET['selectivite'])    : '';
$sort           = isset($_GET['sort'])           ? trim($_GET['sort'])           : 'ratio-desc';
$page           = isset($_GET['page'])           ? max(1, intval($_GET['page'])) : 1;

$perPage  = 25;
$maxRows  = 200;

/*
 * Familles de formation — liste fixe (comme la page HTML)
 * + mapping famille → filtre SQL sur type_formation
 */
$famillesOptions = array(
    'BUT'       => 'BUT — Bachelor Universitaire de Technologie',
    'BTS'       => 'BTS — Brevet de Technicien Supérieur',
    'Licence'   => 'Licence (université, 3 ans)',
    'CPGE'      => 'Prépa (CPGE) — Classes Préparatoires',
    'Sante'     => 'Santé — Infirmier, Kiné, Médecine…',
    'Ingenieur' => 'École d\'ingénieurs',
    'Commerce'  => 'Commerce / Management',
    'Art'       => 'Art / Design / Architecture',
    'Autre'     => 'Autre',
);

/* Retourne la clause SQL WHERE pour une famille donnée */
function famille_where_sql($famille) {
    switch ($famille) {
        case 'BUT':       return "(f26.type_formation LIKE '%BUT%' OR f26.type_formation LIKE '%DUT%')";
        case 'BTS':       return "(f26.type_formation LIKE '%BTS%' OR f26.type_formation LIKE '%BTSA%' OR f26.type_formation LIKE '%BTSM%')";
        case 'Licence':   return "f26.type_formation LIKE '%Licence%'";
        case 'CPGE':      return "f26.type_formation LIKE '%CPGE%'";
        case 'Sante':     return "(f26.type_formation LIKE '%santé%' OR f26.type_formation LIKE '%Santé%' OR f26.type_formation LIKE '%Etudes de%')";
        case 'Ingenieur': return "(f26.type_formation LIKE '%ingénieurs%' OR f26.type_formation LIKE '%ingénieur%')";
        case 'Commerce':  return "(f26.type_formation LIKE '%commerce%' OR f26.type_formation LIKE '%Commerce%' OR f26.type_formation LIKE '%management%' OR f26.type_formation LIKE '%Management%')";
        case 'Art':       return "(f26.type_formation LIKE '%art%' OR f26.type_formation LIKE '%Art%' OR f26.type_formation LIKE '%design%' OR f26.type_formation LIKE '%architecture%' OR f26.type_formation LIKE '%Architecture%')";
        case 'Autre':
            /* Tout ce qui ne correspond à aucune famille ci-dessus */
            return "(f26.type_formation NOT LIKE '%BUT%' AND f26.type_formation NOT LIKE '%DUT%'
                 AND f26.type_formation NOT LIKE '%BTS%'
                 AND f26.type_formation NOT LIKE '%Licence%'
                 AND f26.type_formation NOT LIKE '%CPGE%'
                 AND f26.type_formation NOT LIKE '%santé%' AND f26.type_formation NOT LIKE '%Santé%' AND f26.type_formation NOT LIKE '%Etudes de%'
                 AND f26.type_formation NOT LIKE '%ingénieurs%' AND f26.type_formation NOT LIKE '%ingénieur%'
                 AND f26.type_formation NOT LIKE '%commerce%' AND f26.type_formation NOT LIKE '%Commerce%' AND f26.type_formation NOT LIKE '%management%' AND f26.type_formation NOT LIKE '%Management%'
                 AND f26.type_formation NOT LIKE '%art%' AND f26.type_formation NOT LIKE '%Art%' AND f26.type_formation NOT LIKE '%design%' AND f26.type_formation NOT LIKE '%architecture%' AND f26.type_formation NOT LIKE '%Architecture%')";
        default: return '';
    }
}

/*
 * Tri dynamique — ORDER BY sécurisé (liste blanche)
 * NB : ratio_2025 est un alias SQL, non utilisable dans ORDER BY sur MySQL 5.7
 *      → on répète l'expression complète
 */
function build_order_by($sort) {
    $ratio_expr = 'ROUND(f25.nb_candidats_total / NULLIF(f25.capacite, 0), 1)';
    $allowed = array(
        'ratio-desc'  => $ratio_expr . ' DESC, f26.commune ASC',
        'ratio-asc'   => $ratio_expr . ' ASC,  f26.commune ASC',
        'taux-asc'    => 'f25.taux_acces ASC,  f26.commune ASC',
        'taux-desc'   => 'f25.taux_acces DESC, f26.commune ASC',
        'cand-desc'   => 'f25.nb_candidats_total DESC, f26.commune ASC',
        'nom-asc'     => 'f26.nom_long_formation ASC',
        'commune-asc' => 'f26.commune ASC, f26.nom_etablissement ASC',
        'default'     => 'f26.departement ASC, f26.commune ASC, f26.nom_etablissement ASC',
    );
    return isset($allowed[$sort]) ? $allowed[$sort] : $allowed['default'];
}

/*
 * Génère l'URL de tri — compatible PHP 5.3 / free.fr (pas de http_build_query fiable)
 */
function th_sort_url($colKey, $currentField, $currentDir) {
    $maps = array(
        'nom'     => array('asc' => 'nom-asc',     'desc' => 'nom-asc'),
        'commune' => array('asc' => 'commune-asc', 'desc' => 'commune-asc'),
        'ratio'   => array('asc' => 'ratio-asc',   'desc' => 'ratio-desc'),
        'taux'    => array('asc' => 'taux-asc',    'desc' => 'taux-desc'),
        'cand'    => array('asc' => 'cand-desc',   'desc' => 'cand-desc'),
    );
    if (!isset($maps[$colKey])) return 'parcoursup.php';
    $nextDir  = ($currentField === $colKey && $currentDir === 'desc') ? 'asc' : 'desc';
    $nextSort = $maps[$colKey][$nextDir];
    $parts = array();
    if (isset($_GET['type_formation']) && $_GET['type_formation'] !== '') $parts[] = 'type_formation=' . urlencode($_GET['type_formation']);
    if (isset($_GET['specialite'])     && $_GET['specialite']     !== '') $parts[] = 'specialite='     . urlencode($_GET['specialite']);
    if (isset($_GET['commune'])        && $_GET['commune']        !== '') $parts[] = 'commune='        . urlencode($_GET['commune']);
    if (isset($_GET['departement'])    && $_GET['departement']    !== '') $parts[] = 'departement='    . urlencode($_GET['departement']);
    if (isset($_GET['selectivite'])    && $_GET['selectivite']    !== '') $parts[] = 'selectivite='    . urlencode($_GET['selectivite']);
    $parts[] = 'sort=' . urlencode($nextSort);
    $parts[] = 'page=1';
    return 'parcoursup.php?' . implode('&amp;', $parts);
}

function th_class($colKey, $currentField, $currentDir) {
    $cls = 'sortable';
    if ($currentField === $colKey) {
        $cls .= ' sorted-' . $currentDir;
    }
    return $cls;
}

$sortOptions = array(
    'ratio-desc'  => 'Plus tendu en 1er',
    'ratio-asc'   => 'Plus accessible en 1er',
    'taux-asc'    => 'Plus difficile d\'accès en 1er',
    'taux-desc'   => 'Plus facile d\'accès en 1er',
    'cand-desc'   => 'Plus demandé en 1er',
    'nom-asc'     => 'Formation (A→Z)',
    'commune-asc' => 'Ville (A→Z)',
);

$sortParts = explode('-', $sort);
$sortField = $sortParts[0];
$sortDir   = isset($sortParts[1]) ? $sortParts[1] : 'desc';

$departements = array();
$resDep = mysql_query("SELECT DISTINCT departement FROM formations_2026
                        WHERE departement IS NOT NULL AND departement <> ''
                        ORDER BY departement ASC");
if ($resDep) {
    $row = mysql_fetch_assoc($resDep);
    while ($row) {
        $departements[] = $row['departement'];
        $row = mysql_fetch_assoc($resDep);
    }
}

/*
 * Construction du WHERE
 */
$whereParts = array();

if ($type_formation !== '') {
    $sql_famille = famille_where_sql($type_formation);
    if ($sql_famille !== '') {
        $whereParts[] = $sql_famille;
    }
}
if ($specialite !== '') {
    $whereParts[] = "(f26.nom_long_formation LIKE '%" . sql_escape($specialite) . "%' OR f26.nom_court_formation LIKE '%" . sql_escape($specialite) . "%')";
}
if ($commune !== '') {
    $whereParts[] = "f26.commune LIKE '%" . sql_escape($commune) . "%'";
}
if ($departement !== '') {
    $whereParts[] = "f26.departement = '" . sql_escape($departement) . "'";
}
if ($selectivite !== '') {
    $whereParts[] = "f25.selectivite = '" . sql_escape($selectivite) . "'";
}

$hasSearch = (count($whereParts) > 0);
$where = $hasSearch ? 'WHERE ' . implode(' AND ', $whereParts) : '';

/*
 * Comptage
 */
$totalRows = 0;

if ($hasSearch) {
    $countSql = "SELECT COUNT(*) AS total
                 FROM formations_2026 f26
                 LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
                 " . $where;
    $countRes = mysql_query($countSql);
    if ($countRes) {
        $countRow = mysql_fetch_assoc($countRes);
        if ($countRow) {
            $totalRows = intval($countRow['total']);
        }
    }
}

$displayableRows = min($totalRows, $maxRows);
$totalPages      = max(1, intval(ceil($displayableRows / $perPage)));

if ($page > $totalPages) {
    $page = $totalPages;
}

$offset        = ($page - 1) * $perPage;
$limitForPage  = min($perPage, $maxRows - $offset);
if ($limitForPage < 1) { $limitForPage = $perPage; }

/*
 * Requête principale
 */
$rows = array();

if ($hasSearch) {
    $sql = "SELECT
                f26.nom_etablissement,
                f26.type_formation,
                f26.nom_long_formation,
                f26.nom_court_formation,
                f26.commune,
                f26.departement,
                f26.region,
                f26.lien_fiche_formation,
                f26.internat,
                f26.apprentissage,
                f26.cod_aff_form,

                f25.capacite,
                f25.nb_candidats_total,
                f25.nb_admis_total,
                f25.taux_acces,
                f25.pct_admis_neo_bg,
                f25.pct_admis_neo_bt,
                f25.pct_admis_neo_bp,
                f25.rang_dernier_appele_g1,
                f25.selectivite,
                f25.pct_admis_boursiers,
                f25.nb_admis_mention_tb,
                f25.nb_admis_mention_tbf,
                f25.pct_admis_f,

                ROUND(f25.nb_candidats_total / NULLIF(f25.capacite, 0), 1) AS ratio_2025

            FROM formations_2026 f26
            LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
            " . $where . "
            ORDER BY " . build_order_by($sort) . "
            LIMIT " . intval($offset) . ", " . intval($limitForPage);

    $res = mysql_query($sql);
    if ($res) {
        $rows = fetch_all_assoc($res);
    }
}

/*
 * Tri dynamique
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Parcoursup Décodé — Hors Kadre</title>
<meta name="description" content="Comprenez vraiment Parcoursup : ratio candidats/place, profil des admis, taux d'accès. Données Open Data 2025-2026.">

<!-- Google Analytics katy.ho.free.fr -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-TTTNJ36H5D', { 'anonymize_ip': true });
</script>

<style>
:root {
    --navy:      #1B3A6B;
    --terra:     #C4572A;
    --offwhite:  #F5F0EB;
    --gold:      #B8860B;
    --gray:      #555555;
    --border:    #d9d1ca;
    --white:     #ffffff;
}

* { box-sizing: border-box; }

body {
    margin: 0;
    font-family: Georgia, "Times New Roman", serif;
    background: #fcfaf8;
    color: var(--navy);
    line-height: 1.55;
}

a { color: var(--terra); }

/* HEADER */
.site-header {
    background: var(--offwhite);
    border-bottom: 3px solid var(--terra);
    padding: 20px 16px;
    margin-bottom: 0;
}
.brand-text h1 { font-size: 1.8rem; color: var(--navy); letter-spacing: .5px; margin: 0 0 4px; }
.brand-text .tagline { color: var(--gray); font-size: .9rem; font-style: italic; }
.header-links { margin-top: 10px; font-size: .88rem; }
.header-links a { margin-right: 16px; color: var(--navy); text-decoration: none; }
.header-links a:hover { color: var(--terra); }

.container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 24px 16px 80px;
}

/* INTRO PANEL */
.panel {
    background: var(--offwhite);
    border: 1px solid var(--border);
    border-radius: 12px;
    padding: 18px;
    margin-bottom: 18px;
}
.panel h2 {
    color: var(--terra);
    font-size: 1.1rem;
    margin: 0 0 10px;
}
.panel p { margin: 0 0 6px; font-size: .93rem; color: var(--gray); }
.panel p:last-child { margin-bottom: 0; }

/* METHODE */
.methode {
    background: var(--white);
    border: 1px solid var(--border);
    border-left: 5px solid var(--navy);
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 18px;
    font-size: .9rem;
    color: var(--gray);
    line-height: 1.7;
}
.methode strong { color: var(--navy); }

/* FILTRES */
.filters {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 14px;
    align-items: flex-end;
}
.field { display: flex; flex-direction: column; }
.field label {
    font-size: .82rem;
    color: var(--gray);
    margin-bottom: 3px;
    font-weight: 600;
}
.field select,
.field input[type="text"] {
    padding: 7px 10px;
    border: 1px solid var(--border);
    border-radius: 8px;
    font-size: .9rem;
    font-family: Georgia, serif;
    color: var(--navy);
    background: var(--white);
    min-width: 160px;
}
.actions { display: flex; gap: 8px; align-items: flex-end; }
.btn {
    padding: 8px 18px;
    background: var(--terra);
    color: var(--white);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: .9rem;
    font-family: Georgia, serif;
    font-weight: 600;
    text-decoration: none;
    display: inline-block;
}
.btn:hover { opacity: .9; text-decoration: none; color: var(--white); }
.btn-secondary {
    background: var(--white);
    color: var(--navy);
    border: 1px solid var(--border);
}
.btn-secondary:hover { background: var(--offwhite); color: var(--navy); }

.meta { font-size: .85rem; color: var(--gray); margin-bottom: 10px; }
.warning {
    background: #fff8e1;
    border: 1px solid #ffe082;
    border-radius: 6px;
    padding: 8px 12px;
    font-size: .85rem;
    color: #6d4c00;
    margin-bottom: 10px;
}

/* LÉGENDE */
.legende {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    font-size: .82rem;
    margin-bottom: 12px;
    align-items: center;
}
.legende-titre { font-weight: 700; color: var(--navy); }
.legende-item { display: flex; align-items: center; gap: 5px; color: var(--gray); }
.legende-dot { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; }

/* TABLE */
.table-wrap { overflow-x: auto; }
table {
    width: 100%;
    border-collapse: collapse;
    font-size: .88rem;
    background: var(--white);
}
thead th {
    background: var(--navy);
    color: var(--white);
    padding: 10px 8px;
    text-align: left;
    white-space: nowrap;
    font-size: .82rem;
    text-transform: uppercase;
    letter-spacing: .04em;
}
thead th.num { text-align: center; }
thead th.sortable { cursor: pointer; user-select: none; }
thead th.sortable:hover { background: #254d8f; }
thead th.sorted-asc::after  { content: " ▲"; font-size: .7em; }
thead th.sorted-desc::after { content: " ▼"; font-size: .7em; }
tbody td {
    padding: 10px 8px;
    border-bottom: 1px solid var(--border);
    vertical-align: middle;
}
tr:nth-child(even) td { background: #faf7f4; }
tr:hover td { background: #f0ebe4; }

.formation-name { font-weight: 700; color: var(--navy); }
.etablissement-name { font-size: .8rem; color: var(--gray); margin-top: 2px; }
.commune-info { font-size: .82rem; color: var(--gray); margin-top: 3px; }

/* TAGS */
.tag {
    display: inline-block;
    padding: 1px 7px;
    border-radius: 10px;
    font-size: .75rem;
    font-weight: 600;
    margin-right: 3px;
    margin-top: 3px;
}
.tag-sel  { background: #fef3c7; color: #92400e; }
.tag-open { background: #d1fae5; color: #065f46; }
.tag-int  { background: #dbeafe; color: #1e40af; }
.tag-app  { background: #ede9fe; color: #4c1d95; }

/* RATIO */
.ratio-val {
    font-size: 1.1rem;
    font-weight: 700;
}
.ratio-lbl {
    font-size: .75rem;
    margin-top: 2px;
}
.ratio-detail {
    font-size: .78rem;
    color: var(--gray);
    margin-top: 3px;
}

/* LIEN FICHE */
.detail-btn {
    display: inline-block;
    padding: 4px 10px;
    background: var(--offwhite);
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: .8rem;
    color: var(--navy);
    text-decoration: none;
    white-space: nowrap;
}
.detail-btn:hover {
    background: var(--navy);
    color: var(--white);
    text-decoration: none;
}

/* PAGINATION */
.pagination {
    margin-top: 20px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}
.pagination a, .pagination span {
    padding: 6px 12px;
    border: 1px solid var(--border);
    border-radius: 6px;
    font-size: .88rem;
    text-decoration: none;
    color: var(--navy);
}
.pagination a:hover { background: var(--offwhite); }
.pagination span.current {
    background: var(--terra);
    color: var(--white);
    border-color: var(--terra);
    font-weight: 700;
}

/* PLACEHOLDER */
.placeholder {
    text-align: center;
    padding: 48px 20px;
    color: var(--gray);
}
.placeholder .ico { font-size: 3rem; margin-bottom: 12px; }
.placeholder h3 { color: var(--navy); font-size: 1.1rem; margin-bottom: 6px; }
.placeholder p { font-size: .9rem; }

/* FOOTER */
.footer-note {
    text-align: center;
    color: var(--gray);
    font-size: .82rem;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid var(--border);
    line-height: 1.8;
}
.footer-note a { color: var(--terra); }

/* RGPD */
#rgpd {
    position: fixed; bottom: 0; left: 0; right: 0;
    background: var(--navy); color: #F5F0EB;
    padding: 12px 20px; font-size: 13px;
    display: flex; justify-content: space-between; align-items: center;
    z-index: 9999; font-family: Georgia, serif;
}
#rgpd a { color: var(--terra); }
#rgpd button {
    background: var(--terra); color: #fff; border: none;
    padding: 8px 16px; cursor: pointer; border-radius: 4px;
    margin-left: 20px; white-space: nowrap; font-size: 13px;
}

@media (max-width: 700px) {
    .filters { flex-direction: column; width: 100%; }
    .field { width: 100%; }
    .field select, .field input[type="text"] { width: 100%; min-width: unset; }
    .actions { width: 100%; }
    .actions .btn { flex: 1; text-align: center; }
    thead th:nth-child(4), thead th:nth-child(5), thead th:nth-child(6) { display: none; }
    tbody td:nth-child(4), tbody td:nth-child(5), tbody td:nth-child(6) { display: none; }
    .brand-text h1 { font-size: 1.4rem; }
    #rgpd { flex-direction: column; gap: 8px; text-align: center; }
}
</style>
</head>
<body>

<header class="site-header">
  <!-- Bannière centrée -->
  <div style="text-align:center;margin-bottom:14px;">
    <img src="banniere.png" alt="Hors Kadre" style="max-width:100%;height:auto;display:inline-block;">
  </div>
  <div class="brand-text">
    <h1 style="display:none;">Parcoursup Décodé</h1>
    <div class="tagline" style="text-align:center;margin-bottom:10px;">Un outil Hors Kadre — pour comprendre vraiment ce que les chiffres signifient</div>
  </div>
  <div class="header-links" style="text-align:center;margin-bottom:10px;">
    <a href="index.php">&larr; Accueil</a>
    <a href="indexival.php">Classement IVAL</a>
    <a href="legal/apropos.html">À propos</a>
    <a href="legal/mentions-legales.html">Mentions légales</a>
  </div>
</header>

<div class="container">

  <div class="panel">
    <h2>Ce que cet outil fait que Parcoursup ne fait pas</h2>
    <p>
      La plateforme officielle affiche 2 329 vœux confirmés pour 58 places — et les parents paniquent.
      Pourtant, la même formation BUT peut n'avoir reçu que 700 dossiers sérieusement en compétition,
      et les avoir tous lus un par un. <strong>Le ratio brut est trompeur.</strong>
    </p>
    <p>
      Cet outil affiche les données réelles de 2025 (résultats complets) croisées avec les données 2026
      (vœux confirmés, places disponibles) — pour que vous puissiez évaluer la vraie tension 
      d'une formation, et comprendre quel profil d'élève y a été admis l'an dernier.
    </p>
  </div>

  <div class="methode">
    <strong>Comment lire le ratio candidats/place ?</strong>
    Ce chiffre est calculé sur les données 2025 (candidats réels ÷ capacité d'accueil).
    Il est indicatif : en pratique, une large part des candidats ne viendront jamais —
    car ils ont mis la formation en vœu de secours ou ont été admis ailleurs.
    Le <strong>taux d'accès</strong> (% de candidats ayant reçu une proposition) est un indicateur 
    plus fiable de la sélectivité réelle. Le <strong>rang du dernier appelé</strong> indique jusqu'où 
    la liste d'attente a été déroulée en 2025.
  </div>

  <section class="panel">
    <h2>Rechercher une formation</h2>

    <form method="GET" action="parcoursup.php">
      <div class="filters">

        <div class="field">
          <label for="type_formation">Famille de formation  <a href="typeformation.html" target="_blank" style="font-size:.75rem;font-weight:400;color:var(--terra)">C'est quoi ? →</a></label>
          <select name="type_formation" id="type_formation">
            <option value="">— Toutes —</option>
            <?php
            foreach ($famillesOptions as $val => $label) {
                $sel = ($type_formation === $val) ? 'selected="selected"' : '';
                echo '<option value="' . e($val) . '" ' . $sel . '>' . e($label) . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="field">
          <label for="specialite">Préciser la spécialité</label>
          <input type="text" name="specialite" id="specialite"
                 value="<?php echo e($specialite); ?>"
                 placeholder="ex: Informatique, GEII, Infirmier…">
        </div>

        <div class="field">
          <label for="commune">Ville</label>
          <input type="text" name="commune" id="commune"
                 value="<?php echo e($commune); ?>"
                 placeholder="ex: Vélizy, Paris…">
        </div>

        <div class="field">
          <label for="departement">Département</label>
          <select name="departement" id="departement">
            <option value="">— Tous —</option>
            <?php
            foreach ($departements as $d) {
                $sel = ($departement === $d) ? 'selected="selected"' : '';
                echo '<option value="' . e($d) . '" ' . $sel . '>' . e($d) . '</option>';
            }
            ?>
          </select>
        </div>

        <div class="field">
          <label for="selectivite">Sélectivité</label>
          <select name="selectivite" id="selectivite">
            <option value="">— Toutes —</option>
            <option value="formation sélective" <?php echo ($selectivite === 'formation sélective') ? 'selected="selected"' : ''; ?>>Sélective</option>
            <option value="formation non sélective" <?php echo ($selectivite === 'formation non sélective') ? 'selected="selected"' : ''; ?>>Non sélective</option>
          </select>
        </div>

        <div class="field">
          <label for="sort">Trier par</label>
          <select name="sort" id="sort">
            <?php foreach ($sortOptions as $val => $label) {
                $sel = ($sort === $val) ? 'selected="selected"' : '';
                echo '<option value="' . e($val) . '" ' . $sel . '>' . e($label) . '</option>';
            } ?>
          </select>
        </div>

        <div class="actions">
          <button type="submit" class="btn">Filtrer</button>
          <a href="parcoursup.php" class="btn btn-secondary">Réinitialiser</a>
        </div>

      </div>
    </form>

    <?php if ($hasSearch) { ?>
      <p class="meta">
        <?php echo fmtInt($displayableRows); ?> résultat<?php echo ($displayableRows > 1 ? 's' : ''); ?> affiché<?php echo ($displayableRows > 1 ? 's' : ''); ?>,
        sur <?php echo fmtInt($totalRows); ?> correspondant<?php echo ($totalRows > 1 ? 's' : ''); ?>.
      </p>
      <?php if ($totalRows > $maxRows) { ?>
        <p class="warning">
          Seuls les <?php echo $maxRows; ?> premiers résultats sont affichés. Affinez votre recherche pour de meilleurs résultats.
        </p>
      <?php } ?>
    <?php } ?>

  </section>

  <?php if ($hasSearch && count($rows) > 0) { ?>

    <div class="legende">
      <span class="legende-titre">Ratio candidats/place :</span>
      <span class="legende-item"><span class="legende-dot" style="background:#2d8a4e;"></span> ≤ 5 — Accessible</span>
      <span class="legende-item"><span class="legende-dot" style="background:#c47f00;"></span> ≤ 15 — Modéré</span>
      <span class="legende-item"><span class="legende-dot" style="background:#c45a00;"></span> ≤ 30 — Tendu</span>
      <span class="legende-item"><span class="legende-dot" style="background:#b0261e;"></span> > 30 — Très sélectif</span>
    </div>

    <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <?php
          $sf = $sortField; $sd = $sortDir;
          ?>
          <th class="<?php echo th_class('nom', $sf, $sd); ?>"
              onclick="location.href='<?php echo e(th_sort_url('nom', $sf, $sd)); ?>'">Formation</th>
          <th class="<?php echo th_class('commune', $sf, $sd); ?>"
              onclick="location.href='<?php echo e(th_sort_url('commune', $sf, $sd)); ?>'">Lieu</th>
          <th class="num <?php echo th_class('ratio', $sf, $sd); ?>"
              onclick="location.href='<?php echo e(th_sort_url('ratio', $sf, $sd)); ?>'">Candidats / place<br><small style="font-weight:400;text-transform:none;">(2025)</small></th>
          <th class="num">Profil admis 2025<br><small style="font-weight:400;text-transform:none;">BG / BT / BP</small></th>
          <th class="num <?php echo th_class('taux', $sf, $sd); ?>"
              onclick="location.href='<?php echo e(th_sort_url('taux', $sf, $sd)); ?>'">Taux d'accès<br><small style="font-weight:400;text-transform:none;">2025</small></th>
          <th class="num">Rang dernier<br>appelé 2025</th>
          <th>Fiche</th>
        </tr>
      </thead>
      <tbody>
      <?php
      foreach ($rows as $row) {

          $ratio      = isset($row['ratio_2025'])       ? $row['ratio_2025']       : null;
          $taux       = isset($row['taux_acces'])        ? $row['taux_acces']       : null;
          $rang       = isset($row['rang_dernier_appele_g1']) ? $row['rang_dernier_appele_g1'] : null;
          $pct_bg     = isset($row['pct_admis_neo_bg']) ? $row['pct_admis_neo_bg'] : null;
          $pct_bt     = isset($row['pct_admis_neo_bt']) ? $row['pct_admis_neo_bt'] : null;
          $pct_bp     = isset($row['pct_admis_neo_bp']) ? $row['pct_admis_neo_bp'] : null;
          $capacite   = isset($row['capacite'])          ? $row['capacite']          : null;
          $candidats  = isset($row['nb_candidats_total'])? $row['nb_candidats_total']: null;
          $lien       = isset($row['lien_fiche_formation']) ? trim($row['lien_fiche_formation']) : '';
          $lien_fiche = 'formation.php?cod=' . urlencode($row['cod_aff_form']);
		  $selectiv   = isset($row['selectivite'])       ? $row['selectivite']       : '';
          $internat   = isset($row['internat'])          ? $row['internat']          : 0;
          $apprent    = isset($row['apprentissage'])     ? $row['apprentissage']     : 0;

          $r_color = ratio_color($ratio);
          $r_label = ratio_label($ratio);
          $t_color = taux_acces_color($taux);

          $nom_formation = $row['nom_long_formation'] !== '' ? $row['nom_long_formation'] : $row['type_formation'];

          echo '<tr>';

          // Colonne formation
          echo '<td>';
          echo '<div class="formation-name">' . e($nom_formation) . '</div>';
          echo '<div class="etablissement-name">' . e($row['nom_etablissement']) . '</div>';
          echo '<div style="margin-top:4px;">';
          if ($selectiv === 'formation sélective') {
              echo '<span class="tag tag-sel">Sélective</span>';
          } else {
              echo '<span class="tag tag-open">Non sélective</span>';
          }
          if ($internat) { echo '<span class="tag tag-int">Internat</span>'; }
          if ($apprent)  { echo '<span class="tag tag-app">Apprentissage</span>'; }
          echo '</div>';
          echo '</td>';

          // Colonne lieu
          echo '<td>';
          echo '<div style="font-weight:600;">' . e($row['commune']) . '</div>';
          echo '<div class="commune-info">' . e($row['departement']) . '</div>';
          echo '</td>';

          // Colonne ratio
          echo '<td style="text-align:center;">';
          if ($ratio !== null) {
              echo '<div class="ratio-val" style="color:' . $r_color . ';">';
              echo '<span style="display:inline-block;width:10px;height:10px;border-radius:50%;background:' . $r_color . ';margin-right:4px;vertical-align:middle;"></span>';
              echo fmt($ratio, 1) . ' pour 1';
              echo '</div>';
              echo '<div class="ratio-lbl" style="color:' . $r_color . ';">' . e($r_label) . '</div>';
              echo '<div class="ratio-detail">';
              echo fmtInt($candidats) . ' candidats · ' . fmtInt($capacite) . ' places';
              echo '</div>';
          } else {
              echo '<span style="color:#999;">Données 2025<br>non disponibles</span>';
          }
          echo '</td>';

          // Colonne profil admis
          echo '<td style="min-width:130px;">';
          echo barre_bac('BG', $pct_bg, '#1B3A6B');
          echo barre_bac('BT', $pct_bt, '#C4572A');
          echo barre_bac('BP', $pct_bp, '#B8860B');
          echo '</td>';

          // Colonne taux d'accès
          echo '<td style="text-align:center;">';
          if ($taux !== null) {
              echo '<span style="font-size:1.1rem;font-weight:700;color:' . $t_color . ';">';
              echo fmt_pct($taux, 0);
              echo '</span>';
          } else {
              echo '<span style="color:#999;">N/D</span>';
          }
          echo '</td>';

          // Colonne rang dernier appelé
          echo '<td style="text-align:center;font-weight:700;">';
          echo ($rang !== null) ? fmtInt($rang) : '<span style="color:#999;">N/D</span>';
          echo '</td>';

          // Colonne fiche
          echo '<td>';
          if ($lien !== '') {
              echo '<a class="detail-btn" href="' . e($lien_fiche) . '">Comprendre ↗</a>';
          } else {
              echo '<span style="color:#999;font-size:.8rem;">N/D</span>';
          }
          echo '</td>';

          echo '</tr>';
      }
      ?>
      </tbody>
    </table>
    </div>

    <?php if ($totalPages > 1) { ?>
    <nav class="pagination">
      <?php if ($page > 1) { ?>
        <a href="<?php echo e(build_parcoursup_page_url($page - 1)); ?>">&larr; Précédent</a>
      <?php } ?>

      <?php
      $start = max(1, $page - 2);
      $end   = min($totalPages, $page + 2);
      for ($i = $start; $i <= $end; $i++) {
          if ($i == $page) {
              echo '<span class="current">' . $i . '</span>';
          } else {
              echo '<a href="' . e(build_parcoursup_page_url($i)) . '">' . $i . '</a>';
          }
      }
      ?>

      <?php if ($page < $totalPages) { ?>
        <a href="<?php echo e(build_parcoursup_page_url($page + 1)); ?>">Suivant &rarr;</a>
      <?php } ?>
    </nav>
    <?php } ?>

  <?php } elseif ($hasSearch) { ?>

    <div class="placeholder">
      <div class="ico">🔍</div>
      <h3>Aucune formation trouvée</h3>
      <p>Essayez d'élargir votre recherche — ville partielle, département différent, ou sans filtre de sélectivité.</p>
    </div>

  <?php } else { ?>

    <div class="placeholder">
      <div class="ico">🎓</div>
      <h3>Sélectionnez un type de formation ou une ville pour commencer</h3>
      <p>Exemples : BUT Informatique à Vélizy · Licence à Paris · BTS en Yvelines</p>
    </div>

  <?php } ?>

  <section class="panel" style="margin-top:24px;">
    <h2>Méthode et sources</h2>
    <p>
      Les données proviennent de l'Open Data du Ministère de l'Enseignement supérieur :
      <strong>Parcoursup 2025</strong> (résultats complets, mis à jour mars 2026)
      et <strong>cartographie des formations 2026</strong> (vœux confirmés, places disponibles).
    </p>
    <p>
      Le ratio candidats/place est calculé sur les données 2025 (candidats ayant confirmé au moins un vœu ÷ capacité d'accueil).
      Il ne préjuge pas du nombre de dossiers réellement lus par la formation.
      Le taux d'accès et le rang du dernier appelé sont les indicateurs les plus fiables de la sélectivité réelle.
    </p>
    <p>
      Licence Ouverte 2.0 — Réutilisation autorisée avec attribution.
    </p>
  </section>

    <!-- Lien PDF -->
  <div style="text-align:center;margin:24px 0 8px;padding:14px 20px;background:var(--offwhite);border:1px solid var(--border);border-radius:10px;font-size:.88rem;">
    📥 <a href="https://katysaintin.github.io/hors-kadre-yvelines/ParcoursupInfoHorsKadre.pdf" target="_blank" style="font-weight:600;color:var(--terra);">Télécharger le guide Parcoursup (PDF)</a>
    <span style="color:var(--gray)"> — à imprimer ou partager avec les familles</span>
  </div>

<p class="footer-note">
    ©2026 Katy Saintin — Hors Kadre<br>
    Données publiques · Traitement et analyse indépendants · Réutilisation autorisée avec attribution<br>
    <a href="legal/apropos.html">À propos / Méthodologie</a> |
    <a href="legal/mentions-legales.html">Mentions légales</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a>
  </p>

</div>

<!-- Bandeau RGPD -->
<div id="rgpd">
  <span>Ce site utilise Google Analytics pour mesurer l'audience anonymement.
    <a href="legal/mentions-legales.html">En savoir plus</a>
  </span>
  <button onclick="document.getElementById('rgpd').style.display='none';
    document.cookie='rgpd=1;max-age=31536000;path=/'">J'ai compris</button>
</div>
<script>
  if (document.cookie.indexOf('rgpd=1') >= 0)
    document.getElementById('rgpd').style.display = 'none';
</script>

</body>
</html>
