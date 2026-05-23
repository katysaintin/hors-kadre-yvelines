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
 * Hors Kadre — Orientation — Page carrefour
 * Compatible free.fr : mysql_* uniquement, PHP 5.3+
 * Reçoit les paramètres du test (profil, filiere, dept)
 * ou fonctionne en recherche avancée autonome
 */
include('config.php');
include('functions.php');
connect_db();

/* ----------------------------------------------------------------
 * Profils du test
 * ---------------------------------------------------------------- */
$profils_test = array(
    'sasuke'    => array('nom'=>'Sasuke Uchiha',   'emoji'=>'🔥', 'serie'=>'Naruto',         'slogan'=>"L'excellence ou rien",               'formation'=>'CPGE'),
    'eleven'    => array('nom'=>'Eleven',           'emoji'=>'⚡', 'serie'=>'Stranger Things', 'slogan'=>'La puissance dans l\'action',        'formation'=>'BUT / École d\'ingénieurs'),
    'steve'     => array('nom'=>'Steve Harrington', 'emoji'=>'🎸', 'serie'=>'Stranger Things', 'slogan'=>'Solide, fiable, meilleur qu\'il n\'y paraît', 'formation'=>'BTS'),
    'luffy'     => array('nom'=>'Monkey D. Luffy',  'emoji'=>'🏴‍☠️','serie'=>'One Piece',       'slogan'=>'Le monde est trop petit pour moi',  'formation'=>'École de Commerce'),
    'wednesday' => array('nom'=>'Wednesday Addams', 'emoji'=>'🖤', 'serie'=>'Wednesday',       'slogan'=>'Je suis là pour comprendre, pas pour plaire', 'formation'=>'Licence / Recherche'),
    'tanjiro'   => array('nom'=>'Tanjiro Kamado',   'emoji'=>'🌊', 'serie'=>'Demon Slayer',    'slogan'=>'Une vocation, une mission',          'formation'=>'PASS / Paramédical'),
);

/* Mapping profil → famille de formation pour le filtre SQL */
$profil_to_famille = array(
    'sasuke'    => 'CPGE',
    'eleven'    => 'BUT',
    'steve'     => 'BTS',
    'luffy'     => 'Commerce',
    'wednesday' => 'Licence',
    'tanjiro'   => 'Sante',
);

/* Liens thématiques par famille */
$liens_par_famille = array(
    'CPGE'     => array('doublettes'=>'doublettes.php?filiere=CPGE',     'info'=>'cpge_analyse.html',         'info_label'=>'🏛️ Grandes Écoles — tout comprendre', 'type'=>'typeformation.html#cpge'),
    'BUT'      => array('doublettes'=>'doublettes.php?filiere=BUT',      'info'=>'typeformation.html#but',    'info_label'=>'📖 Comprendre le BUT',                'type'=>'typeformation.html#but'),
    'BTS'      => array('doublettes'=>'doublettes.php?filiere=BTS',      'info'=>'typeformation.html#bts',    'info_label'=>'📖 Comprendre le BTS',                'type'=>'typeformation.html#bts'),
    'Licence'  => array('doublettes'=>'doublettes.php?filiere=Licence',  'info'=>'typeformation.html#licence','info_label'=>'📖 Comprendre la Licence',            'type'=>'typeformation.html#licence'),
    'Commerce' => array('doublettes'=>'doublettes.php?filiere=Commerce', 'info'=>'typeformation.html#commerce','info_label'=>'📖 Comprendre les Écoles de Commerce','type'=>'typeformation.html#commerce'),
    'Sante'    => array('doublettes'=>'doublettes.php?filiere=PASS',     'info'=>'typeformation.html#pass',   'info_label'=>'📖 Comprendre le PASS',               'type'=>'typeformation.html#pass'),
);

/* ----------------------------------------------------------------
 * Familles de formation (mêmes que parcoursup.php)
 * ---------------------------------------------------------------- */
$famillesOptions = array(
    'BUT'       => 'BUT — Bachelor Universitaire de Technologie',
    'BTS'       => 'BTS — Brevet de Technicien Supérieur',
    'Licence'   => 'Licence (université, 3 ans)',
    'CPGE'      => 'Prépa (CPGE) — Classes Préparatoires',
    'Sante'     => 'Santé — Infirmier, Kiné, PASS…',
    'Ingenieur' => 'École d\'ingénieurs',
    'Commerce'  => 'École de Commerce / Management',
    'Art'       => 'Art / Design / Architecture',
    'Autre'     => 'Autre',
);

/* Même logique SQL que parcoursup.php */
function famille_where_sql($famille) {
    switch ($famille) {
        case 'BUT':       return "(f26.type_formation LIKE '%BUT%' OR f26.type_formation LIKE '%DUT%')";
        case 'BTS':       return "(f26.type_formation LIKE '%BTS%' OR f26.type_formation LIKE '%BTSA%')";
        case 'Licence':   return "f26.type_formation LIKE '%Licence%'";
        case 'CPGE':      return "f26.type_formation LIKE '%CPGE%'";
        case 'Sante':     return "(f26.type_formation LIKE '%santé%' OR f26.type_formation LIKE '%Santé%' OR f26.type_formation LIKE '%Etudes de%')";
        case 'Ingenieur': return "(f26.type_formation LIKE '%ingénieurs%' OR f26.type_formation LIKE '%ingénieur%')";
        case 'Commerce':  return "(f26.type_formation LIKE '%commerce%' OR f26.type_formation LIKE '%Commerce%' OR f26.type_formation LIKE '%management%' OR f26.type_formation LIKE '%Management%')";
        case 'Art':       return "(f26.type_formation LIKE '%art%' OR f26.type_formation LIKE '%Art%' OR f26.type_formation LIKE '%design%' OR f26.type_formation LIKE '%architecture%')";
        default: return '';
    }
}

function build_order_by_o($sort) {
    $ratio_expr = 'ROUND(f25.nb_candidats_total / NULLIF(f25.capacite, 0), 1)';
    $allowed = array(
        'ratio-desc'  => $ratio_expr . ' DESC, f26.commune ASC',
        'ratio-asc'   => $ratio_expr . ' ASC,  f26.commune ASC',
        'taux-asc'    => 'f25.taux_acces ASC,  f26.commune ASC',
        'taux-desc'   => 'f25.taux_acces DESC, f26.commune ASC',
        'cand-desc'   => 'f25.nb_candidats_total DESC, f26.commune ASC',
        'commune-asc' => 'f26.commune ASC, f26.nom_etablissement ASC',
    );
    return isset($allowed[$sort]) ? $allowed[$sort] : $allowed['ratio-desc'];
}

/* ----------------------------------------------------------------
 * Paramètres GET
 * ---------------------------------------------------------------- */
$profil_id      = isset($_GET['profil'])        ? trim($_GET['profil'])        : '';
$type_formation = isset($_GET['type_formation'])? trim($_GET['type_formation']): '';
$specialite     = isset($_GET['specialite'])    ? trim($_GET['specialite'])    : '';
$commune        = isset($_GET['commune'])        ? trim($_GET['commune'])       : '';
$departement    = isset($_GET['departement'])   ? trim($_GET['departement'])   : '';
$selectivite    = isset($_GET['selectivite'])   ? trim($_GET['selectivite'])   : '';
$internat       = isset($_GET['internat'])      ? trim($_GET['internat'])      : '';
$apprentissage  = isset($_GET['apprentissage']) ? trim($_GET['apprentissage']) : '';
$sort           = isset($_GET['sort'])          ? trim($_GET['sort'])          : 'ratio-desc';
$page           = isset($_GET['page'])          ? max(1, intval($_GET['page'])): 1;
$perPage        = 25;
$maxRows        = 200;

/* Si on vient du test, on préremplit la famille */
$profil_data = null;
if ($profil_id !== '' && isset($profils_test[$profil_id])) {
    $profil_data = $profils_test[$profil_id];
    if ($type_formation === '' && isset($profil_to_famille[$profil_id])) {
        $type_formation = $profil_to_famille[$profil_id];
    }
}

$liens = ($type_formation !== '' && isset($liens_par_famille[$type_formation]))
       ? $liens_par_famille[$type_formation] : null;

/* ----------------------------------------------------------------
 * Départements pour le select
 * ---------------------------------------------------------------- */
$departements = array();
$resDep = mysql_query("SELECT DISTINCT departement FROM formations_2026
                        WHERE departement IS NOT NULL AND departement <> ''
                        ORDER BY departement ASC");
if ($resDep) {
    $row = mysql_fetch_assoc($resDep);
    while ($row) { $departements[] = $row['departement']; $row = mysql_fetch_assoc($resDep); }
}

/* ----------------------------------------------------------------
 * Construction du WHERE
 * ---------------------------------------------------------------- */
$whereParts = array();
if ($type_formation !== '') {
    $sql_f = famille_where_sql($type_formation);
    if ($sql_f !== '') $whereParts[] = $sql_f;
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
if ($internat === '1') {
    $whereParts[] = "f26.internat = 1";
}
if ($apprentissage === '1') {
    $whereParts[] = "f26.apprentissage = 1";
}

$hasSearch = (count($whereParts) > 0);
$where     = $hasSearch ? 'WHERE ' . implode(' AND ', $whereParts) : '';

/* ----------------------------------------------------------------
 * Comptage + requête principale
 * ---------------------------------------------------------------- */
$totalRows = 0;
$rows = array();

if ($hasSearch) {
    $countSql = "SELECT COUNT(DISTINCT f26.cod_aff_form) AS total
                 FROM formations_2026 f26
                 LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
                 " . $where;
    $countRes = mysql_query($countSql);
    if ($countRes) {
        $countRow = mysql_fetch_assoc($countRes);
        if ($countRow) $totalRows = intval($countRow['total']);
    }

    $displayableRows = min($totalRows, $maxRows);
    $totalPages      = max(1, intval(ceil($displayableRows / $perPage)));
    if ($page > $totalPages) $page = $totalPages;
    $offset       = ($page - 1) * $perPage;
    $limitForPage = min($perPage, $maxRows - $offset);
    if ($limitForPage < 1) $limitForPage = $perPage;

    $sql = "SELECT
                MIN(f26.nom_etablissement)    AS nom_etablissement,
                MIN(f26.type_formation)       AS type_formation,
                MIN(f26.nom_long_formation)   AS nom_long_formation,
                MIN(f26.nom_court_formation)  AS nom_court_formation,
                MIN(f26.commune)              AS commune,
                MIN(f26.departement)          AS departement,
                MIN(f26.lien_fiche_formation) AS lien_fiche_formation,
                MAX(f26.internat)             AS internat,
                MAX(f26.apprentissage)        AS apprentissage,
                f26.cod_aff_form,
                f25.capacite,
                f25.nb_candidats_total,
                f25.taux_acces,
                f25.pct_admis_neo_bg,
                f25.pct_admis_neo_bt,
                f25.pct_admis_neo_bp,
                f25.rang_dernier_appele_g1,
                f25.selectivite,
                f25.pct_admis_boursiers,
                ROUND(f25.nb_candidats_total / NULLIF(f25.capacite, 0), 1) AS ratio_2025
            FROM formations_2026 f26
            LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
            " . $where . "
            GROUP BY f26.cod_aff_form, f25.capacite, f25.nb_candidats_total,
                f25.taux_acces, f25.pct_admis_neo_bg, f25.pct_admis_neo_bt,
                f25.pct_admis_neo_bp, f25.rang_dernier_appele_g1, f25.selectivite,
                f25.pct_admis_boursiers
            ORDER BY " . build_order_by_o($sort) . "
            LIMIT " . intval($offset) . ", " . intval($limitForPage);

    $res = mysql_query($sql);
    if ($res) $rows = fetch_all_assoc($res);
} else {
    $displayableRows = 0;
    $totalPages = 1;
}

/* ----------------------------------------------------------------
 * Helpers URL
 * ---------------------------------------------------------------- */
function build_orient_url($extra = array()) {
    global $profil_id, $type_formation, $specialite, $commune,
           $departement, $selectivite, $internat, $apprentissage, $sort;
    $p = array();
    if ($profil_id      !== '') $p[] = 'profil='        . urlencode($profil_id);
    if ($type_formation !== '') $p[] = 'type_formation=' . urlencode($type_formation);
    if ($specialite     !== '') $p[] = 'specialite='    . urlencode($specialite);
    if ($commune        !== '') $p[] = 'commune='       . urlencode($commune);
    if ($departement    !== '') $p[] = 'departement='   . urlencode($departement);
    if ($selectivite    !== '') $p[] = 'selectivite='   . urlencode($selectivite);
    if ($internat       !== '') $p[] = 'internat='      . urlencode($internat);
    if ($apprentissage  !== '') $p[] = 'apprentissage=' . urlencode($apprentissage);
    $p[] = 'sort=' . urlencode($sort);
    foreach ($extra as $k => $v) $p[] = urlencode($k) . '=' . urlencode($v);
    return 'orientation.php?' . implode('&amp;', $p);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Mes formations — Hors Kadre</title>
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date()); gtag('config', 'G-TTTNJ36H5D', {'anonymize_ip':true});
</script>
<style>
:root{--navy:#1B3A6B;--terra:#C4572A;--offwhite:#F5F0EB;
  --gold:#B8860B;--gray:#555;--border:#d9d1ca;--white:#fff;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Georgia,"Times New Roman",serif;background:#fcfaf8;
  color:var(--navy);line-height:1.55;}
a{color:var(--terra);text-decoration:none;}
a:hover{text-decoration:underline;}

/* HEADER */
.site-header{background:var(--offwhite);border-bottom:3px solid var(--terra);
  padding:16px;text-align:center;}
.site-header img{max-width:320px;width:55%;height:auto;}
.header-links{margin-top:8px;font-size:.82rem;display:flex;
  flex-wrap:wrap;justify-content:center;gap:6px 14px;}
.header-links a{color:var(--navy);font-weight:600;}
.header-links a:hover{color:var(--terra);}

/* BANDEAU PROFIL */
.profil-banner{border-radius:12px;padding:14px 20px;margin:16px 0;
  display:flex;align-items:center;gap:16px;color:#fff;
  background:linear-gradient(135deg,var(--navy),#2d5a9f);}
.profil-banner .pb-emoji{font-size:2.2rem;flex-shrink:0;}
.profil-banner .pb-info{flex:1;}
.profil-banner .pb-nom{font-size:1rem;font-weight:700;margin-bottom:2px;}
.profil-banner .pb-slogan{font-size:.82rem;opacity:.85;font-style:italic;}
.profil-banner .pb-formation{font-size:.78rem;margin-top:4px;opacity:.75;}
.profil-banner a{color:#fff;font-size:.78rem;opacity:.7;text-decoration:underline;
  white-space:nowrap;}

.container{max-width:1100px;margin:0 auto;padding:20px 16px 80px;}

/* FILTRES */
.panel{background:var(--offwhite);border:1px solid var(--border);
  border-radius:12px;padding:18px 20px;margin-bottom:16px;}
.panel h2{color:var(--terra);font-size:1rem;margin-bottom:12px;font-weight:700;}
.filters{display:flex;flex-wrap:wrap;gap:10px;align-items:flex-end;}
.field{display:flex;flex-direction:column;}
.field label{font-size:.8rem;color:var(--gray);margin-bottom:3px;font-weight:600;}
.field select,.field input{padding:7px 10px;border:1px solid var(--border);
  border-radius:8px;font-size:.88rem;font-family:Georgia,serif;
  color:var(--navy);background:var(--white);min-width:150px;}
.field select:focus,.field input:focus{outline:none;border-color:var(--terra);}
.check-row{display:flex;gap:14px;flex-wrap:wrap;margin-top:2px;}
.check-item{display:flex;align-items:center;gap:5px;font-size:.85rem;color:var(--gray);}
.check-item input{width:auto;}
.actions-row{display:flex;gap:8px;align-items:flex-end;flex-wrap:wrap;}
.btn{padding:8px 18px;background:var(--terra);color:#fff;
  border:none;border-radius:8px;cursor:pointer;
  font-size:.88rem;font-family:Georgia,serif;font-weight:600;
  text-decoration:none;display:inline-block;}
.btn:hover{opacity:.9;text-decoration:none;color:#fff;}
.btn-secondary{background:var(--white);color:var(--navy);border:1px solid var(--border);}
.btn-secondary:hover{background:var(--offwhite);color:var(--navy);}
.meta{font-size:.85rem;color:var(--gray);margin-top:10px;}
.warning{background:#fff8e1;border:1px solid #ffe082;border-radius:6px;
  padding:8px 12px;font-size:.85rem;color:#6d4c00;margin-top:8px;}

/* LIENS THÉMATIQUES */
.liens-grid{display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:10px;margin-bottom:16px;}
.lien-card{border-radius:10px;padding:13px 16px;
  text-decoration:none;display:block;color:#fff;transition:opacity .2s;}
.lien-card:hover{opacity:.85;text-decoration:none;}
.lien-card .lc-icon{font-size:1.3rem;margin-bottom:5px;}
.lien-card .lc-titre{font-size:.85rem;font-weight:700;margin-bottom:3px;}
.lien-card .lc-desc{font-size:.75rem;opacity:.8;line-height:1.5;}

/* LÉGENDE */
.legende{display:flex;flex-wrap:wrap;gap:12px;font-size:.82rem;
  margin-bottom:10px;align-items:center;}
.legende-titre{font-weight:700;color:var(--navy);}
.legende-item{display:flex;align-items:center;gap:5px;color:var(--gray);}
.legende-dot{width:12px;height:12px;border-radius:50%;flex-shrink:0;}

/* TABLE — pleine largeur */
.table-wrap{overflow-x:auto;border-radius:10px;
  box-shadow:0 2px 12px rgba(27,58,107,.06);}
table{width:100%;border-collapse:collapse;font-size:.87rem;
  background:var(--white);}
thead th{background:var(--navy);color:#fff;padding:10px 8px;
  text-align:left;white-space:nowrap;font-size:.8rem;
  text-transform:uppercase;letter-spacing:.04em;}
thead th.num{text-align:center;}
thead th.sortable{cursor:pointer;user-select:none;}
thead th.sortable:hover{background:#254d8f;}
tbody td{padding:10px 8px;border-bottom:1px solid var(--border);
  vertical-align:middle;}
tr:nth-child(even) td{background:#faf7f4;}
tr:hover td{background:#f0ebe4;}
.formation-name{font-weight:700;color:var(--navy);}
.etablissement-name{font-size:.78rem;color:var(--gray);margin-top:2px;}
.commune-info{font-size:.8rem;color:var(--gray);margin-top:3px;}
.tag{display:inline-block;padding:1px 7px;border-radius:10px;
  font-size:.72rem;font-weight:600;margin-right:3px;margin-top:3px;}
.tag-sel{background:#fef3c7;color:#92400e;}
.tag-open{background:#d1fae5;color:#065f46;}
.tag-int{background:#dbeafe;color:#1e40af;}
.tag-app{background:#ede9fe;color:#4c1d95;}
.ratio-val{font-size:1.05rem;font-weight:700;}
.ratio-lbl{font-size:.72rem;margin-top:2px;}
.ratio-detail{font-size:.75rem;color:var(--gray);margin-top:2px;}
.detail-btn{display:inline-block;padding:5px 11px;
  background:var(--offwhite);border:1px solid var(--border);
  border-radius:6px;font-size:.8rem;color:var(--navy);
  text-decoration:none;white-space:nowrap;}
.detail-btn:hover{background:var(--navy);color:#fff;text-decoration:none;}

/* PAGINATION */
.pagination{margin-top:16px;display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
.pagination a,.pagination span{padding:6px 12px;border:1px solid var(--border);
  border-radius:6px;font-size:.86rem;text-decoration:none;color:var(--navy);}
.pagination a:hover{background:var(--offwhite);}
.pagination span.current{background:var(--terra);color:#fff;
  border-color:var(--terra);font-weight:700;}

/* PLACEHOLDER */
.placeholder{text-align:center;padding:48px 20px;color:var(--gray);}
.placeholder .ico{font-size:3rem;margin-bottom:12px;}
.placeholder h3{color:var(--navy);font-size:1.1rem;margin-bottom:6px;}

/* MODALE DÉPARTEMENT */
.modal-overlay{display:none;position:fixed;inset:0;
  background:rgba(0,0,0,.55);z-index:1000;
  align-items:center;justify-content:center;}
.modal-overlay.active{display:flex;}
.modal{background:var(--white);border-radius:16px;padding:28px 24px;
  max-width:400px;width:90%;text-align:center;
  box-shadow:0 20px 60px rgba(0,0,0,.3);}
.modal h3{color:var(--navy);font-size:1.1rem;margin-bottom:8px;}
.modal p{font-size:.88rem;color:var(--gray);margin-bottom:16px;line-height:1.6;}
.modal select{width:100%;padding:9px 12px;border:1px solid var(--border);
  border-radius:8px;font-family:Georgia,serif;font-size:.9rem;
  color:var(--navy);margin-bottom:14px;}
.modal-btns{display:flex;gap:10px;justify-content:center;}

/* FOOTER */
.footer-note{text-align:center;color:var(--gray);font-size:.8rem;
  margin-top:32px;padding-top:16px;border-top:1px solid var(--border);line-height:1.9;}

/* RGPD */
#rgpd{position:fixed;bottom:0;left:0;right:0;background:var(--navy);
  color:#F5F0EB;padding:12px 20px;font-size:13px;
  display:flex;justify-content:space-between;align-items:center;
  z-index:9999;font-family:Georgia,serif;}
#rgpd a{color:var(--terra);}
#rgpd button{background:var(--terra);color:#fff;border:none;
  padding:8px 16px;cursor:pointer;border-radius:4px;
  margin-left:20px;white-space:nowrap;font-size:13px;}

@media(max-width:700px){
  .filters{flex-direction:column;width:100%;}
  .field{width:100%;}
  .field select,.field input{width:100%;min-width:unset;}
  .actions-row{width:100%;}
  .actions-row .btn{flex:1;text-align:center;}
  .liens-grid{grid-template-columns:1fr;}
  /* Mobile : masquer colonnes secondaires */
  thead th:nth-child(4),thead th:nth-child(6){display:none;}
  tbody td:nth-child(4),tbody td:nth-child(6){display:none;}
  .profil-banner{flex-direction:column;text-align:center;}
  #rgpd{flex-direction:column;gap:8px;text-align:center;}
}
</style>
</head>
<body>

<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="header-links">
    <a href="index.php">← Accueil</a>
    <a href="orientation_test.html">🎯 Refaire le test</a>
    <a href="parcoursup.php">🎓 Parcoursup</a>
    <a href="doublettes.php">📊 Spécialités</a>
    <a href="indexival.php">🏫 Lycées</a>
    <a href="aide.html">❓ Guide</a>
  </div>
</header>

<div class="container">

<?php if ($profil_data): ?>
<!-- BANDEAU PROFIL -->
<div class="profil-banner">
  <span class="pb-emoji"><?php echo $profil_data['emoji']; ?></span>
  <div class="pb-info">
    <div class="pb-nom"><?php echo e($profil_data['nom']); ?> — <?php echo e($profil_data['serie']); ?></div>
    <div class="pb-slogan">"<?php echo e($profil_data['slogan']); ?>"</div>
    <div class="pb-formation">Formation recommandée : <?php echo e($profil_data['formation']); ?></div>
  </div>
  <a href="resultat.html?profil=<?php echo urlencode($profil_id); ?>">← Mon résultat</a>
</div>
<?php endif; ?>

<!-- LIENS THÉMATIQUES -->
<?php if ($liens): ?>
<div class="liens-grid" style="margin-bottom:16px;">
  <a href="<?php echo e($liens['type']); ?>" class="lien-card" style="background:var(--navy);">
    <div class="lc-icon">📖</div>
    <div class="lc-titre">Comprendre cette formation</div>
    <div class="lc-desc">Durée, coût, rythme, débouchés</div>
  </a>
  <a href="<?php echo e($liens['doublettes']); ?>" class="lien-card" style="background:#2d4a1a;">
    <div class="lc-icon">📊</div>
    <div class="lc-titre">Spécialités qui y mènent</div>
    <div class="lc-desc">Doublettes et spécialités des admis 2024</div>
  </a>
  <?php if (isset($liens['info']) && $liens['info'] === 'cpge_analyse.html'): ?>
  <a href="cpge_analyse.html" class="lien-card" style="background:#7a4a00;">
    <div class="lc-icon">🏛️</div>
    <div class="lc-titre">Grandes Écoles — données & repères</div>
    <div class="lc-desc">Banques, concours, coûts, boursiers</div>
  </a>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- FILTRES -->
<div class="panel">
  <h2>🔍 Affiner ma recherche</h2>
  <form method="GET" action="orientation.php">
    <?php if ($profil_id !== ''): ?>
      <input type="hidden" name="profil" value="<?php echo e($profil_id); ?>">
    <?php endif; ?>
    <div class="filters">

      <div class="field">
        <label>Type de formation
          <a href="typeformation.html" target="_blank" style="font-weight:400;font-size:.73rem;"> C'est quoi ? →</a>
        </label>
        <select name="type_formation">
          <option value="">— Toutes —</option>
          <?php foreach ($famillesOptions as $val => $lbl):
            $sel = ($type_formation === $val) ? 'selected="selected"' : ''; ?>
          <option value="<?php echo e($val); ?>" <?php echo $sel; ?>><?php echo e($lbl); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="field">
        <label>Préciser (spécialité)</label>
        <input type="text" name="specialite"
               value="<?php echo e($specialite); ?>"
               placeholder="ex: Informatique, GEII, Infirmier…">
      </div>

      <div class="field">
        <label>Ville</label>
        <input type="text" name="commune"
               value="<?php echo e($commune); ?>"
               placeholder="ex: Vélizy, Lyon…">
      </div>

      <div class="field">
        <label>Département</label>
        <select name="departement">
          <option value="">— Tous —</option>
          <?php foreach ($departements as $d):
            $sel = ($departement === $d) ? 'selected="selected"' : ''; ?>
          <option value="<?php echo e($d); ?>" <?php echo $sel; ?>><?php echo e($d); ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="field">
        <label>Sélectivité</label>
        <select name="selectivite">
          <option value="">— Toutes —</option>
          <option value="formation sélective" <?php echo ($selectivite === 'formation sélective') ? 'selected' : ''; ?>>Sélective</option>
          <option value="formation non sélective" <?php echo ($selectivite === 'formation non sélective') ? 'selected' : ''; ?>>Non sélective</option>
        </select>
      </div>

      <div class="field">
        <label>Options</label>
        <div class="check-row">
          <label class="check-item">
            <input type="checkbox" name="internat" value="1"
              <?php echo ($internat === '1') ? 'checked' : ''; ?>>
            🛏️ Internat
          </label>
          <label class="check-item">
            <input type="checkbox" name="apprentissage" value="1"
              <?php echo ($apprentissage === '1') ? 'checked' : ''; ?>>
            🔧 Alternance
          </label>
        </div>
      </div>

      <div class="field">
        <label>Trier par</label>
        <select name="sort">
          <option value="ratio-desc" <?php echo ($sort==='ratio-desc')?'selected':''; ?>>Plus tendu en 1er</option>
          <option value="ratio-asc"  <?php echo ($sort==='ratio-asc') ?'selected':''; ?>>Plus accessible en 1er</option>
          <option value="taux-asc"   <?php echo ($sort==='taux-asc')  ?'selected':''; ?>>Plus difficile d'accès</option>
          <option value="taux-desc"  <?php echo ($sort==='taux-desc') ?'selected':''; ?>>Plus facile d'accès</option>
          <option value="commune-asc"<?php echo ($sort==='commune-asc')?'selected':''; ?>>Ville (A→Z)</option>
        </select>
      </div>

      <div class="actions-row">
        <button type="submit" class="btn">Filtrer</button>
        <a href="orientation.php<?php echo $profil_id?'?profil='.urlencode($profil_id):''; ?>"
           class="btn btn-secondary">✕ Réinit.</a>
      </div>

    </div>

    <?php if ($hasSearch && $totalRows > 0): ?>
    <p class="meta">
      <?php echo $displayableRows; ?> résultat<?php echo $displayableRows>1?'s':''; ?>
      affiché<?php echo $displayableRows>1?'s':''; ?>
      sur <?php echo $totalRows; ?> correspondant<?php echo $totalRows>1?'s':''; ?>.
      <?php if ($totalRows > $maxRows): ?>
        Seuls les <?php echo $maxRows; ?> premiers sont affichés — affinez la recherche.
      <?php endif; ?>
    </p>
    <?php endif; ?>

  </form>
</div>

<!-- RÉSULTATS -->
<?php if ($hasSearch && count($rows) > 0): ?>

  <div class="legende">
    <span class="legende-titre">Ratio candidats/place :</span>
    <span class="legende-item"><span class="legende-dot" style="background:#2d8a4e;"></span>≤ 5 Accessible</span>
    <span class="legende-item"><span class="legende-dot" style="background:#c47f00;"></span>≤ 15 Modéré</span>
    <span class="legende-item"><span class="legende-dot" style="background:#c45a00;"></span>≤ 30 Tendu</span>
    <span class="legende-item"><span class="legende-dot" style="background:#b0261e;"></span>&gt; 30 Très sélectif</span>
  </div>

  <div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>Formation</th>
        <th>Lieu</th>
        <th class="num">Candidats / place</th>
        <th class="num">Profil admis<br><small style="font-weight:400;text-transform:none;">BG / BT / BP</small></th>
        <th class="num">Taux d'accès</th>
        <th class="num">Rang dernier appelé</th>
        <th>Fiche</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach ($rows as $row):
      $ratio    = isset($row['ratio_2025'])           ? $row['ratio_2025']           : null;
      $taux     = isset($row['taux_acces'])            ? $row['taux_acces']           : null;
      $rang     = isset($row['rang_dernier_appele_g1'])? $row['rang_dernier_appele_g1']: null;
      $pct_bg   = isset($row['pct_admis_neo_bg'])     ? $row['pct_admis_neo_bg']     : null;
      $pct_bt   = isset($row['pct_admis_neo_bt'])     ? $row['pct_admis_neo_bt']     : null;
      $pct_bp   = isset($row['pct_admis_neo_bp'])     ? $row['pct_admis_neo_bp']     : null;
      $capacite = isset($row['capacite'])              ? $row['capacite']             : null;
      $candidats= isset($row['nb_candidats_total'])   ? $row['nb_candidats_total']   : null;
      $lien_fiche = 'formation.php?cod=' . urlencode($row['cod_aff_form']);
      $selectiv = isset($row['selectivite'])           ? $row['selectivite']          : '';
      $internat_r= isset($row['internat'])             ? $row['internat']             : 0;
      $apprent_r = isset($row['apprentissage'])        ? $row['apprentissage']        : 0;
      $r_color  = ratio_color($ratio);
      $r_label  = ratio_label($ratio);
      $t_color  = taux_acces_color($taux);
      $nom_formation = ($row['nom_long_formation'] !== '') ? $row['nom_long_formation'] : $row['type_formation'];
    ?>
    <tr>
      <td>
        <div class="formation-name"><?php echo e($nom_formation); ?></div>
        <div class="etablissement-name"><?php echo e($row['nom_etablissement']); ?></div>
        <div style="margin-top:4px;">
          <?php if ($selectiv === 'formation sélective'): ?>
            <span class="tag tag-sel">Sélective</span>
          <?php else: ?>
            <span class="tag tag-open">Non sélective</span>
          <?php endif; ?>
          <?php if ($internat_r): ?><span class="tag tag-int">Internat</span><?php endif; ?>
          <?php if ($apprent_r):  ?><span class="tag tag-app">Alternance</span><?php endif; ?>
        </div>
      </td>
      <td>
        <div style="font-weight:600;"><?php echo e($row['commune']); ?></div>
        <div class="commune-info"><?php echo e($row['departement']); ?></div>
      </td>
      <td style="text-align:center;">
        <?php if ($ratio !== null): ?>
          <div class="ratio-val" style="color:<?php echo $r_color; ?>;">
            <span style="display:inline-block;width:10px;height:10px;border-radius:50%;
              background:<?php echo $r_color; ?>;margin-right:4px;vertical-align:middle;"></span>
            <?php echo fmt($ratio, 1); ?> pour 1
          </div>
          <div class="ratio-lbl" style="color:<?php echo $r_color; ?>;"><?php echo e($r_label); ?></div>
          <div class="ratio-detail"><?php echo fmtInt($candidats); ?> cand. · <?php echo fmtInt($capacite); ?> places</div>
        <?php else: ?>
          <span style="color:#999;font-size:.8rem;">N/D</span>
        <?php endif; ?>
      </td>
      <td style="min-width:120px;">
        <?php echo barre_bac('BG', $pct_bg, '#1B3A6B'); ?>
        <?php echo barre_bac('BT', $pct_bt, '#C4572A'); ?>
        <?php echo barre_bac('BP', $pct_bp, '#B8860B'); ?>
      </td>
      <td style="text-align:center;">
        <?php if ($taux !== null): ?>
          <span style="font-size:1.05rem;font-weight:700;color:<?php echo $t_color; ?>;">
            <?php echo fmt_pct($taux, 0); ?>
          </span>
        <?php else: ?>
          <span style="color:#999;">N/D</span>
        <?php endif; ?>
      </td>
      <td style="text-align:center;font-weight:700;">
        <?php echo ($rang !== null) ? fmtInt($rang) : '<span style="color:#999;">N/D</span>'; ?>
      </td>
      <td>
        <a class="detail-btn" href="<?php echo e($lien_fiche); ?>">Comprendre ↗</a>
      </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>

  <!-- PAGINATION -->
  <?php if ($totalPages > 1): ?>
  <nav class="pagination">
    <?php if ($page > 1): ?>
      <a href="<?php echo build_orient_url(array('page'=>$page-1)); ?>">&larr; Préc.</a>
    <?php endif; ?>
    <?php for ($i = max(1,$page-2); $i <= min($totalPages,$page+2); $i++):
      if ($i == $page): ?>
        <span class="current"><?php echo $i; ?></span>
      <?php else: ?>
        <a href="<?php echo build_orient_url(array('page'=>$i)); ?>"><?php echo $i; ?></a>
      <?php endif; ?>
    <?php endfor; ?>
    <?php if ($page < $totalPages): ?>
      <a href="<?php echo build_orient_url(array('page'=>$page+1)); ?>">Suiv. &rarr;</a>
    <?php endif; ?>
  </nav>
  <?php endif; ?>

<?php elseif ($hasSearch): ?>
  <div class="placeholder">
    <div class="ico">🔍</div>
    <h3>Aucune formation trouvée</h3>
    <p>Essayez d'élargir — ville partielle, autre département, ou sans filtre de sélectivité.</p>
  </div>

<?php else: ?>
  <div class="placeholder">
    <div class="ico">🎯</div>
    <h3>Sélectionnez un type de formation pour commencer</h3>
    <p>Ou <a href="orientation_test.html">faites le test</a> pour une suggestion personnalisée.</p>
  </div>
<?php endif; ?>

<p class="footer-note">
  ©2026 Katy Saintin — Hors Kadre<br>
  Données Open Data Parcoursup 2025 — Licence Ouverte 2.0<br>
  <a href="legal/apropos.html">À propos</a> |
  <a href="legal/mentions-legales.html">Mentions légales</a> |
  <a href="mailto:katy.saintin@gmail.com">Contact</a>
</p>

</div>

<!-- MODALE DÉPARTEMENT (affichée si vient du test avec Q4 = rester près) -->
<div class="modal-overlay" id="modalDept">
  <div class="modal">
    <h3>📍 Tu préfères rester près de chez toi !</h3>
    <p>Dans quel département habites-tu ? On va filtrer les formations près de chez toi.</p>
    <select id="modalDeptSelect">
      <option value="">— Choisir un département —</option>
      <?php foreach ($departements as $d): ?>
      <option value="<?php echo e($d); ?>"><?php echo e($d); ?></option>
      <?php endforeach; ?>
    </select>
    <div class="modal-btns">
      <button class="btn" onclick="validerDept()">Filtrer près de moi →</button>
      <button class="btn btn-secondary" onclick="ignorer()">Ignorer</button>
    </div>
  </div>
</div>

<div id="rgpd">
  <span>Ce site utilise Google Analytics anonymement.
    <a href="legal/mentions-legales.html">En savoir plus</a></span>
  <button onclick="document.getElementById('rgpd').style.display='none';
    document.cookie='rgpd=1;max-age=31536000;path=/'">J'ai compris</button>
</div>

<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-TTTNJ36H5D', { 'anonymize_ip': true });
</script>
<script>
if (document.cookie.indexOf('rgpd=1') >= 0)
  document.getElementById('rgpd').style.display = 'none';

/* Modale département — affichée si param show_modal=1 dans l'URL */
(function() {
  var params = new URLSearchParams(window.location.search);
  if (params.get('show_modal') === '1' && params.get('departement') === '') {
    document.getElementById('modalDept').classList.add('active');
  }
})();

function validerDept() {
  var dept = document.getElementById('modalDeptSelect').value;
  if (!dept) { alert('Choisis un département d\'abord !'); return; }
  var params = new URLSearchParams(window.location.search);
  params.set('departement', dept);
  params.delete('show_modal');
  window.location.href = 'orientation.php?' + params.toString();
}

function ignorer() {
  var params = new URLSearchParams(window.location.search);
  params.delete('show_modal');
  window.location.href = 'orientation.php?' + params.toString();
  document.getElementById('modalDept').classList.remove('active');
}
</script>
</body>
</html>
