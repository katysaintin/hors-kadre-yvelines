<?php
/*
 * doublette_detail.php - Hors Kadre
 * List of formations for a given filiere + sub-specialty
 * Displays sortable table: places, candidats, ratio, taux_acces
 * Links to formation.php for full detail
 *
 * URL params:
 *   ?filiere=BUT           - main family (required)
 *   ?detail=Informatique   - sub-specialty (required)
 *   ?sort=taux|ratio|places|candidats  - sort column (default: taux ASC)
 *   ?iframe=1              - embed mode
 */
include('config.php');
include('functions.php');
connect_db();

/* ------------------------------------------------------------------
 * PARAMETERS
 * ------------------------------------------------------------------ */
/* magic_quotes_gpc active on old PHP (free.fr) adds backslashes automatically
   stripslashes() removes them to get clean values */
$filiere = isset($_GET['filiere']) ? stripslashes(trim($_GET['filiere'])) : '';
$detail  = isset($_GET['detail'])  ? stripslashes(trim($_GET['detail']))  : '';
$sort    = isset($_GET['sort'])    ? trim($_GET['sort'])    : 'taux';
$iframe  = isset($_GET['iframe'])  && $_GET['iframe'] === '1';
$doublette_display = isset($_GET['doublette'])
    ? stripslashes(trim($_GET['doublette'])) : '';

if ($filiere === '' || $detail === '') { die('Parametres manquants.'); }

/* Whitelist sort values to prevent SQL injection */
$sort_map = array(
    'taux'      => 'f25.taux_acces ASC',
    'taux_desc' => 'f25.taux_acces DESC',
    'ratio'     => 'ratio DESC',
    'places'    => 'f25.capacite DESC',
    'candidats' => 'f25.nb_candidats_phase_principale DESC',
    'commune'   => 'f26.commune ASC',
);
$order_by = isset($sort_map[$sort]) ? $sort_map[$sort] : $sort_map['taux'];

$filiere_safe = mysql_real_escape_string($filiere);
$detail_safe  = mysql_real_escape_string($detail);

/* ------------------------------------------------------------------
 * STEP 1: Get cods from filiere_detail
 * ------------------------------------------------------------------ */
$cods_str     = '';
$nb_total     = 0;
$detail_label = '';

$sql_cods = "SELECT cods, nb_formations, filiere_detaillee_bis
             FROM filiere_detail
             WHERE filiere_agregee = '$filiere_safe'
             AND filiere_detaillee_bis LIKE '%$detail_safe%'
             ORDER BY nb_formations DESC LIMIT 1";

$res_cods = mysql_query($sql_cods);
if ($res_cods) {
    $row = mysql_fetch_assoc($res_cods);
    if ($row) {
        $cods_str     = $row['cods'];
        $nb_total     = intval($row['nb_formations']);
        $detail_label = $row['filiere_detaillee_bis'];
    }
}
if ($cods_str === '') { die('Aucune formation trouvee.'); }

/* Sanitize cods */
$cods_array = explode(',', $cods_str);
$cods_clean = array();
foreach ($cods_array as $c) {
    $c = trim($c);
    if (is_numeric($c)) $cods_clean[] = intval($c);
}
if (count($cods_clean) === 0) { die('Aucun code valide.'); }
$cods_in = implode(',', $cods_clean);

/* ------------------------------------------------------------------
 * STEP 2: Fetch formations with stats - deduplicated by cod_aff_form
 * ------------------------------------------------------------------ */
$formations = array();

$sql_form = "SELECT
    f26.cod_aff_form,
    MIN(f26.nom_long_formation)  AS nom_formation,
    MIN(f26.nom_etablissement)   AS nom_etablissement,
    MIN(f26.commune)             AS commune,
    MIN(f26.departement)         AS departement,
    f25.capacite,
    f25.nb_candidats_phase_principale AS nb_candidats,
    f25.taux_acces,
    f25.selectivite,
    ROUND(f25.nb_candidats_phase_principale / NULLIF(f25.capacite,0), 1) AS ratio
FROM formations_2026 f26
LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
WHERE f26.cod_aff_form IN ($cods_in)
AND f25.nb_candidats_phase_principale > 0
GROUP BY f26.cod_aff_form, f25.capacite,
    f25.nb_candidats_phase_principale, f25.taux_acces, f25.selectivite
ORDER BY $order_by";

$res_form = mysql_query($sql_form);
if ($res_form) {
    while ($r = mysql_fetch_assoc($res_form)) {
        $formations[] = $r;
    }
}

/* Global stats */
$total_places = 0; $total_candidats = 0;
foreach ($formations as $f) {
    $total_places    += intval($f['capacite']);
    $total_candidats += intval($f['nb_candidats']);
}
$ratio_moy = $total_places > 0
           ? round($total_candidats / $total_places, 1) : 0;

/* Sort URL helper */
function sort_url($col, $filiere, $detail, $iframe, $current_sort) {
    /* Toggle ASC/DESC if same column */
    $next = $col;
    if ($current_sort === $col && isset($GLOBALS['sort_map'][$col.'_desc'])) {
        $next = $col.'_desc';
    } elseif ($current_sort === $col.'_desc') {
        $next = $col;
    }
    /* Preserve doublette param across sort clicks */
    $doublette_param = isset($_GET['doublette']) ? '&doublette='.urlencode($_GET['doublette']) : '';
    return '?filiere='.urlencode($filiere)
         . '&detail='.urlencode($detail)
         . '&sort='.$next
         . $doublette_param
         . ($iframe ? '&iframe=1' : '');
}

function sort_arrow($col, $current) {
    if ($current === $col)       return ' ↑';
    if ($current === $col.'_desc') return ' ↓';
    return '';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo htmlspecialchars($filiere.' — '.$detail_label); ?> — Hors Kadre</title>
<style>
:root{--navy:#1B3A6B;--terra:#C4572A;--offwhite:#F5F0EB;
  --gray:#666;--border:#d9d1ca;--white:#fff;}
*{box-sizing:border-box;margin:0;padding:0;}
body{font-family:Georgia,"Times New Roman",serif;
  background:<?php echo $iframe?'transparent':'#fcfaf8'; ?>;
  color:var(--navy);line-height:1.6;}
a{color:var(--terra);text-decoration:none;}
a:hover{text-decoration:underline;}
<?php if(!$iframe): ?>
.site-header{background:var(--offwhite);border-bottom:3px solid var(--terra);
  padding:16px;text-align:center;}
.site-header img{max-width:320px;width:50%;height:auto;}
.nav-links{margin-top:8px;font-size:.85rem;}
.nav-links a{margin:0 10px;color:var(--navy);font-weight:600;}
.nav-links a:hover{color:var(--terra);}
<?php endif; ?>
.container{max-width:<?php echo $iframe?'100%':'920px'; ?>;
  margin:0 auto;padding:<?php echo $iframe?'12px 8px':'28px 16px 60px'; ?>;}

/* Breadcrumb */
.breadcrumb{font-size:.8rem;color:var(--gray);margin-bottom:12px;}
.breadcrumb a{color:var(--terra);}

/* Title */
.page-title{font-size:1.15rem;color:var(--terra);font-weight:700;margin-bottom:2px;}
.doublette-title{font-size:.88rem;color:var(--gray);margin-bottom:14px;
  padding:8px 12px;background:var(--offwhite);border-radius:8px;
  border-left:4px solid var(--terra);}
.doublette-title strong{color:var(--navy);}

/* Stats */
.stats-bar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:14px;}
.stat-pill{background:var(--offwhite);border:1px solid var(--border);
  border-radius:8px;padding:7px 12px;font-size:.78rem;text-align:center;}
.stat-pill strong{display:block;font-size:.95rem;color:var(--terra);}

/* Filter */
.filter-row{display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
.filter-input{flex:1;min-width:160px;padding:7px 12px;
  border:2px solid var(--border);border-radius:20px;
  font-family:Georgia,serif;font-size:.82rem;color:var(--navy);outline:none;}
.filter-input:focus{border-color:var(--terra);}

/* TABLE */
.table-wrap{overflow-x:auto;-webkit-overflow-scrolling:touch;
  border:1px solid var(--border);border-radius:10px;}
table{width:100%;border-collapse:collapse;font-size:.82rem;}
thead th{
  background:var(--navy);color:#fff;padding:10px 12px;
  text-align:left;white-space:nowrap;font-weight:600;
  font-family:Georgia,serif;
}
thead th a{color:#fff;text-decoration:none;}
thead th a:hover{text-decoration:underline;color:#fcd34d;}
thead th.num{text-align:right;}

tbody tr{border-bottom:1px solid var(--border);}
tbody tr:last-child{border-bottom:none;}
tbody tr:hover{background:var(--offwhite);}
tbody td{padding:10px 12px;vertical-align:middle;}
tbody td.num{text-align:right;font-weight:600;color:var(--navy);}
tbody td.etab{font-weight:600;color:var(--navy);line-height:1.3;}
tbody td.lieu{font-size:.76rem;color:var(--gray);}

/* Taux color */
.taux-hard{color:#C4572A;font-weight:700;}
.taux-med{color:#c47f00;font-weight:700;}
.taux-easy{color:#2d8a4e;font-weight:700;}

/* Badge selectivite */
.badge{display:inline-block;padding:1px 7px;border-radius:8px;
  font-size:.7rem;font-weight:700;}
.badge-sel{background:#fef3c7;color:#92400e;border:1px solid #fcd34d;}
.badge-open{background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;}

/* Button comprendre */
.btn-comp{display:inline-block;background:var(--terra);color:#fff;
  padding:5px 12px;border-radius:6px;font-size:.76rem;font-weight:600;
  font-family:Georgia,serif;text-decoration:none;white-space:nowrap;}
.btn-comp:hover{background:#a8452a;color:#fff;text-decoration:none;}

/* Note */
.note-bas{font-size:.74rem;color:var(--gray);margin-top:14px;
  padding-top:10px;border-top:1px solid var(--border);font-style:italic;}

<?php if(!$iframe): ?>
footer{text-align:center;color:var(--gray);font-size:.78rem;
  margin-top:28px;padding-top:14px;border-top:1px solid var(--border);
  line-height:1.9;}
footer a{color:var(--terra);}
<?php endif; ?>
@media(max-width:600px){
  table{font-size:.76rem;}
  thead th,tbody td{padding:7px 8px;}
}
</style>
</head>
<body>
<?php if(!$iframe): ?>
<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="nav-links">
    <a href="index.php">← Accueil</a>
    <a href="doublettes.php?filiere=<?php echo urlencode($filiere);
      ?>&detail=<?php echo urlencode($detail); ?>">← Retour doublettes</a>
    <a href="parcoursup.php">Comprendre Parcoursup</a>
  </div>
</header>
<?php endif; ?>

<div class="container">

  <div class="breadcrumb">
    <a href="doublettes.php?filiere=<?php echo urlencode($filiere); ?>">
      Doublettes <?php echo htmlspecialchars($filiere); ?>
    </a>
    &nbsp;›&nbsp;
    <a href="doublettes.php?filiere=<?php echo urlencode($filiere);
      ?>&detail=<?php echo urlencode($detail); ?>">
      <?php echo htmlspecialchars($detail_label); ?>
    </a>
    &nbsp;›&nbsp; Formations
  </div>

  <h1 class="page-title">
    <?php echo htmlspecialchars($filiere); ?> —
    <?php echo htmlspecialchars($detail_label); ?>
  </h1>
  <p style="font-size:.82rem;color:var(--gray);margin-bottom:10px;">
    Filière : <strong style="color:var(--navy);"><?php echo htmlspecialchars($filiere); ?></strong>
    &nbsp;›&nbsp;
    Spécialité : <strong style="color:var(--navy);"><?php echo htmlspecialchars($detail_label); ?></strong>
  </p>

  <?php if($doublette_display !== ''): ?>
  <div class="doublette-title">
    📊 Doublette sélectionnée :
    <strong><?php echo htmlspecialchars($doublette_display); ?></strong>
  </div>
  <?php endif; ?>

  <!-- Stats -->
  <div class="stats-bar">
    <div class="stat-pill">
      <strong><?php echo count($formations); ?></strong> formations
    </div>
    <div class="stat-pill">
      <strong><?php echo number_format($total_places,0,',',' '); ?></strong> places
    </div>
    <div class="stat-pill">
      <strong><?php echo number_format($total_candidats,0,',',' '); ?></strong> candidatures
    </div>
    <div class="stat-pill">
      <strong><?php echo $ratio_moy; ?></strong> candidats/place (moy.)
    </div>
  </div>

  <!-- Filters: free text on city/etab + select on departement -->
  <div class="filter-row">
    <input type="text" id="filtre-ville" class="filter-input"
           placeholder="Filtrer par ville ou établissement…"
           oninput="filtrer()">
    <select id="filtre-dept" class="filter-input" style="flex:0 0 auto;min-width:160px;"
            onchange="filtrer()">
      <option value="">— Tous les départements —</option>
    </select>
    <button onclick="resetFiltres()"
      style="padding:7px 12px;border:2px solid var(--border);border-radius:20px;
             background:var(--white);font-family:Georgia,serif;font-size:.8rem;
             color:var(--gray);cursor:pointer;">✕ Effacer</button>
  </div>

  <!-- Sortable table -->
  <?php if(count($formations) === 0): ?>
    <p style="color:var(--gray);font-style:italic;padding:20px 0;">
      Aucune formation trouvée avec données disponibles.
    </p>
  <?php else: ?>
  <div class="table-wrap">
  <table id="form-table">
    <thead>
      <tr>
        <th>Établissement</th>
        <th class="num">
          <a href="<?php echo sort_url('places',$filiere,$detail,$iframe,$sort); ?>">
            Places<?php echo sort_arrow('places',$sort); ?>
          </a>
        </th>
        <th class="num">
          <a href="<?php echo sort_url('candidats',$filiere,$detail,$iframe,$sort); ?>">
            Candidats<?php echo sort_arrow('candidats',$sort); ?>
          </a>
        </th>
        <th class="num">
          <a href="<?php echo sort_url('ratio',$filiere,$detail,$iframe,$sort); ?>">
            Cand./place<?php echo sort_arrow('ratio',$sort); ?>
          </a>
        </th>
        <th class="num">
          <a href="<?php echo sort_url('taux',$filiere,$detail,$iframe,$sort); ?>">
            Accès<?php echo sort_arrow('taux',$sort); ?>
          </a>
        </th>
        <th></th>
      </tr>
    </thead>
    <tbody id="form-tbody">
    <?php foreach($formations as $f):
      $taux  = floatval($f['taux_acces']);
      $ratio = $f['ratio'] ? floatval($f['ratio']) : null;
      $is_sel = strpos($f['selectivite'], 'sélective') !== false;
      $taux_cls = $taux <= 30 ? 'taux-hard'
                : ($taux <= 60 ? 'taux-med' : 'taux-easy');
      $search = strtolower($f['commune'].' '.$f['nom_etablissement'].' '.$f['departement']);
    ?>
      <tr data-search="<?php echo htmlspecialchars($search); ?>"
          data-dept="<?php echo htmlspecialchars($f['departement']); ?>">
        <td>
          <div class="etab">
            <?php echo htmlspecialchars($f['nom_etablissement']); ?>
          </div>
          <div class="lieu">
            <?php echo htmlspecialchars($f['commune']); ?> —
            <?php echo htmlspecialchars($f['departement']); ?>
            &nbsp;
            <span class="badge badge-<?php echo $is_sel?'sel':'open'; ?>">
              <?php echo $is_sel?'Sélective':'Non sélective'; ?>
            </span>
          </div>
        </td>
        <td class="num">
          <?php echo $f['capacite'] ? intval($f['capacite']) : '—'; ?>
        </td>
        <td class="num">
          <?php echo $f['nb_candidats']
            ? number_format(intval($f['nb_candidats']),0,',',' ') : '—'; ?>
        </td>
        <td class="num">
          <?php echo $ratio ? $ratio : '—'; ?>
        </td>
        <td class="num <?php echo $taux_cls; ?>">
          <?php echo $f['taux_acces'] ? $taux.'%' : '—'; ?>
        </td>
        <td>
          <a href="formation.php?cod=<?php echo urlencode($f['cod_aff_form']); ?>"
             class="btn-comp">
            Comprendre →
          </a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
  </div>

  <p class="note-bas">
    Source : Open Data Parcoursup 2025.
    Accès en rouge = très sélectif (≤30%), orange = moyen, vert = accessible.
    Cliquez sur les en-têtes de colonnes pour trier.
    Cliquez sur "Comprendre" pour voir le profil complet des admis.
  </p>
  <?php endif; ?>

  <?php if(!$iframe): ?>
  <footer>
    ©2026 Katy Saintin — Hors Kadre<br>
    <a href="doublettes.php?filiere=<?php echo urlencode($filiere); ?>">← Retour doublettes</a> |
    <a href="parcoursup.php">Comprendre Parcoursup</a> |
    <a href="index.php">Accueil</a>
  </footer>
  <?php endif; ?>
</div>

<script>
/* Build departement dropdown from table data */
document.addEventListener('DOMContentLoaded', function() {
  var rows = document.querySelectorAll('#form-tbody tr');
  var depts = {};
  rows.forEach(function(row) {
    var d = row.getAttribute('data-dept') || '';
    if (d && !depts[d]) {
      depts[d] = true;
    }
  });
  var sel = document.getElementById('filtre-dept');
  Object.keys(depts).sort().forEach(function(d) {
    var opt = document.createElement('option');
    opt.value = d; opt.textContent = d;
    sel.appendChild(opt);
  });
});

/* Filter on ville + departement */
function filtrer() {
  var mot  = document.getElementById('filtre-ville').value.toLowerCase().trim();
  var dept = document.getElementById('filtre-dept').value;
  var rows = document.querySelectorAll('#form-tbody tr');
  rows.forEach(function(row) {
    var s = row.getAttribute('data-search') || '';
    var d = row.getAttribute('data-dept') || '';
    var okMot  = !mot  || s.indexOf(mot) >= 0;
    var okDept = !dept || d === dept;
    row.style.display = (okMot && okDept) ? '' : 'none';
  });
}

function resetFiltres() {
  document.getElementById('filtre-ville').value = '';
  document.getElementById('filtre-dept').value  = '';
  filtrer();
}
</script>
</body>
</html>