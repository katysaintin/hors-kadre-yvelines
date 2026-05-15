<?php
/*
 * doublettes.php - Hors Kadre
 * Ranking of baccalaureate specialty combinations (doublettes) by admission rate
 * Data source: Open Data Parcoursup 2024 - general baccalaureate students only
 * Compatible PHP 4/5 (free.fr legacy)
 *
 * URL params:
 *   ?filiere=BUT        - main family filter (BUT, BTS, CPGE, etc.)
 *   ?detail=Informatique - sub-specialty filter (optional, free text)
 *   ?iframe=1           - embed mode (no header/footer)
 */
include('config.php');
include('functions.php');
connect_db();

/* ------------------------------------------------------------------
 * PARAMETERS
 * ------------------------------------------------------------------ */
/* stripslashes for magic_quotes_gpc on old PHP (free.fr) */
$filiere_param = isset($_GET['filiere']) ? stripslashes(trim($_GET['filiere'])) : 'BUT';
$detail_param  = isset($_GET['detail'])  ? stripslashes(trim($_GET['detail']))  : '';
$iframe        = isset($_GET['iframe'])  && $_GET['iframe'] === '1';

/* ------------------------------------------------------------------
 * AVAILABLE FAMILIES - maps URL key to display label
 * ------------------------------------------------------------------ */
$filieres = array(
    'BUT'               => '🎓 BUT',
    'BTS'               => '📋 BTS',
    'CPGE'              => '⭐ Prépa (CPGE)',
    'Licence'           => '📚 Licence',
    "Ecole d'Ingenieur" => '⚙️ Ingénieurs',
    'Ecole de Commerce' => '💼 Commerce',
    'PASS'              => '🏥 PASS / Médecine',
    'Autre formation'   => '📌 Autre',
);

/* Validate filiere param against whitelist */
$filiere = isset($filieres[$filiere_param]) ? $filiere_param : 'BUT';
$filiere_label = $filieres[$filiere];

/* ------------------------------------------------------------------
 * CPGE SUB-FAMILY DETECTION
 * When detail param matches a CPGE sub-type, filter by sous_filiere
 * S = scientific (MPSI, PCSI, PTSI, BCPST, MP2I, TSI, TB)
 * ECG = economic (ECG, ECT)
 * L = literary (Lettres, Khagne, Hypokhagne, B/L)
 * '' = no filter (show all)
 * ------------------------------------------------------------------ */
$sous_filiere = '';
if ($filiere === 'CPGE' && $detail_param !== '') {
    $d_low = strtolower($detail_param);
    if (strpos($d_low, 'mpsi') !== false
     || strpos($d_low, 'pcsi') !== false
     || strpos($d_low, 'ptsi') !== false
     || strpos($d_low, 'bcpst') !== false
     || strpos($d_low, 'mp2i') !== false
     || strpos($d_low, 'tsi') !== false
     || strpos($d_low, 'tb') !== false)      $sous_filiere = 'S';
    elseif (strpos($d_low, 'ecg') !== false
         || strpos($d_low, 'ect') !== false) $sous_filiere = 'ECG';
    elseif (strpos($d_low, 'lettre') !== false
         || strpos($d_low, 'khagne') !== false
         || strpos($d_low, 'khâgne') !== false
         || strpos($d_low, 'b/l') !== false) $sous_filiere = 'L';
    else                                     $sous_filiere = 'S'; /* default scientific */
}

/* ------------------------------------------------------------------
 * SUB-SPECIALTY LOOKUP
 * If detail param is provided, find matching cods from filiere_detail
 * table, then count how many formations match
 * ------------------------------------------------------------------ */
$detail_label   = '';
$nb_formations  = 0;
$detail_active  = false;

if ($detail_param !== '') {
    $detail_safe = mysql_real_escape_string($detail_param);
    $sql_detail  = "SELECT filiere_detaillee_bis, nb_formations
                    FROM filiere_detail
                    WHERE filiere_agregee = '" . mysql_real_escape_string($filiere) . "'
                    AND filiere_detaillee_bis LIKE '%" . $detail_safe . "%'
                    ORDER BY nb_formations DESC
                    LIMIT 1";
    $res_detail = mysql_query($sql_detail);
    if ($res_detail) {
        $row_detail = mysql_fetch_assoc($res_detail);
        if ($row_detail) {
            $detail_label  = $row_detail['filiere_detaillee_bis'];
            $nb_formations = intval($row_detail['nb_formations']);
            $detail_active = true;
        }
    }
}

/* ------------------------------------------------------------------
 * MAIN QUERY - fetch doublettes ranked by conversion rate
 * Minimum threshold: 200 candidates (removes anecdotal combinations)
 * Note: doublettes are aggregated at filiere_agregee level (e.g. all BUT)
 * Sub-specialty filtering affects the label only, not the doublette data
 * (granular data by sub-specialty not available in current open data)
 * ------------------------------------------------------------------ */
$rows        = array();
$total_admis = 0;
$total_voeux = 0;

/* Build sous_filiere filter for CPGE — empty = no filter (all families) */
$sous_filiere_clause = ($sous_filiere !== '')
    ? "AND sous_filiere = '" . mysql_real_escape_string($sous_filiere) . "'"
    : ($filiere === 'CPGE' ? "AND sous_filiere != ''" : "AND (sous_filiere = '' OR sous_filiere IS NULL)");

$sql = "SELECT doublette, nb_voeux, nb_admis,
               ROUND(nb_admis / nb_voeux * 100, 1) AS taux
        FROM specialites_filiere
        WHERE filiere_agregee = '" . mysql_real_escape_string($filiere) . "'
        AND annee = 2024
        AND nb_voeux >= 200
        $sous_filiere_clause
        ORDER BY taux DESC";

$res = mysql_query($sql);
if ($res) {
    while ($r = mysql_fetch_assoc($res)) {
        $rows[]       = $r;
        $total_admis += intval($r['nb_admis']);
        $total_voeux += intval($r['nb_voeux']);
    }
}

/* Best conversion rate - used to scale bar widths */
$taux_max = count($rows) > 0 ? floatval($rows[0]['taux']) : 100;

/* ------------------------------------------------------------------
 * SUB-SPECIALTY SUGGESTIONS
 * Load available sub-specialties for the selected family
 * Used to populate datalist for autocomplete
 * ------------------------------------------------------------------ */
$suggestions = array();
$sql_sugg = "SELECT DISTINCT filiere_detaillee_bis, nb_formations
             FROM filiere_detail
             WHERE filiere_agregee = '" . mysql_real_escape_string($filiere) . "'
             AND filiere_detaillee_bis IS NOT NULL
             AND filiere_detaillee_bis != ''
             ORDER BY nb_formations DESC
             LIMIT 50";
$res_sugg = mysql_query($sql_sugg);
if ($res_sugg) {
    while ($s = mysql_fetch_assoc($res_sugg)) {
        $suggestions[] = $s['filiere_detaillee_bis'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Spécialités lycée par filière — <?php echo htmlspecialchars($filiere_label); ?> — Hors Kadre</title>
<style>
:root{
  --navy:#1B3A6B;--terra:#C4572A;--offwhite:#F5F0EB;
  --gray:#666;--border:#d9d1ca;--white:#fff;
}
*{box-sizing:border-box;margin:0;padding:0;}
body{
  font-family:Georgia,"Times New Roman",serif;
  background:<?php echo $iframe ? 'transparent' : '#fcfaf8'; ?>;
  color:var(--navy);line-height:1.6;
}
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

.container{
  max-width:<?php echo $iframe ? '100%' : '860px'; ?>;
  margin:0 auto;
  padding:<?php echo $iframe ? '12px 8px' : '28px 16px 60px'; ?>;
}

/* Page title */
.page-title{font-size:<?php echo $iframe ? '1rem' : '1.3rem'; ?>;
  color:var(--terra);margin-bottom:4px;font-weight:700;}
.page-sub{font-size:.82rem;color:var(--gray);margin-bottom:16px;line-height:1.6;}

/* Family navigation pills */
.filiere-nav{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;}
.filiere-btn{
  padding:6px 12px;border-radius:20px;border:2px solid var(--border);
  background:var(--white);color:var(--navy);font-family:Georgia,serif;
  font-size:.8rem;cursor:pointer;text-decoration:none;
  display:inline-block;transition:all .2s;white-space:nowrap;
}
.filiere-btn:hover{border-color:var(--terra);color:var(--terra);text-decoration:none;}
.filiere-btn.active{background:var(--terra);color:var(--white);border-color:var(--terra);}

/* Sub-specialty filter row */
.filtre-row{display:flex;gap:8px;align-items:center;
  flex-wrap:wrap;margin-bottom:14px;}
.filtre-label{font-size:.82rem;color:var(--gray);white-space:nowrap;}
.filtre-input{
  flex:1;min-width:180px;padding:8px 14px;
  border:2px solid var(--border);border-radius:20px;
  font-family:Georgia,serif;font-size:.85rem;color:var(--navy);
  outline:none;transition:border-color .2s;background:var(--white);
}
.filtre-input:focus{border-color:var(--terra);}
.filtre-clear{
  padding:8px 12px;border:2px solid var(--border);border-radius:20px;
  background:var(--white);font-family:Georgia,serif;font-size:.82rem;
  color:var(--gray);cursor:pointer;transition:all .2s;
}
.filtre-clear:hover{border-color:var(--terra);color:var(--terra);}

/* Active sub-specialty badge */
.detail-badge{
  display:inline-flex;align-items:center;gap:8px;
  background:#fef3c7;border:1px solid #fcd34d;border-radius:8px;
  padding:8px 14px;font-size:.83rem;color:#92400e;
  margin-bottom:14px;
}
.detail-badge strong{color:var(--navy);}

/* Global stats row */
.stats-bar{display:flex;gap:10px;flex-wrap:wrap;margin-bottom:16px;}
.stat-pill{background:var(--offwhite);border:1px solid var(--border);
  border-radius:8px;padding:7px 12px;font-size:.8rem;text-align:center;}
.stat-pill strong{display:block;font-size:1rem;color:var(--terra);}

/* Doublette cards */
.doublette-list{display:flex;flex-direction:column;gap:8px;}
.doublette-row{
  background:var(--white);border:1px solid var(--border);
  border-radius:10px;padding:12px 14px;transition:border-color .15s;
}
.doublette-row:hover{border-color:var(--terra);}
.doublette-row.top1{border-left:4px solid #B8860B;background:#fffdf5;}
.doublette-row.top2{border-left:4px solid #888;}
.doublette-row.top3{border-left:4px solid #cd7f32;}

.row-header{display:flex;justify-content:space-between;
  align-items:flex-start;gap:8px;margin-bottom:6px;}
.row-rang{font-size:.75rem;font-weight:700;color:var(--gray);
  min-width:22px;padding-top:2px;}
.row-nom{font-size:.87rem;color:var(--navy);font-weight:600;
  flex:1;line-height:1.4;}
.row-taux{font-size:1rem;font-weight:700;color:var(--terra);
  white-space:nowrap;}

.row-barre-bg{background:var(--border);border-radius:4px;
  height:5px;margin-bottom:6px;overflow:hidden;}
.row-barre-fill{background:var(--terra);height:100%;border-radius:4px;}

.row-details{font-size:.74rem;color:var(--gray);}

/* Note */
.note-bas{font-size:.74rem;color:var(--gray);margin-top:16px;
  padding-top:12px;border-top:1px solid var(--border);
  font-style:italic;line-height:1.6;}

<?php if(!$iframe): ?>
footer{text-align:center;color:var(--gray);font-size:.78rem;
  margin-top:32px;padding-top:16px;border-top:1px solid var(--border);
  line-height:1.9;}
footer a{color:var(--terra);}
<?php endif; ?>

@media(max-width:500px){
  .filiere-btn{font-size:.74rem;padding:5px 8px;}
  .row-nom{font-size:.82rem;}
  .stat-pill{padding:6px 9px;font-size:.76rem;}
  .filtre-input{font-size:.82rem;}
}
</style>
</head>
<body>

<?php if(!$iframe): ?>
<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="nav-links">
    <a href="index.php">← Accueil</a>
    <a href="parcoursup.php">Comprendre Parcoursup</a>
    <a href="typeformation.html">Types de formation</a>
  </div>
</header>
<?php endif; ?>

<div class="container">

  <?php if(!$iframe): ?>
  <h1 class="page-title">Quelles spécialités lycée mènent à chaque filière ?</h1>
  <p class="page-sub">
    Classement par taux d'admission — données nationales Parcoursup 2024, bacheliers généraux.
    Seuil minimum : 200 candidats par doublette.
  </p>
  <?php else: ?>
  <p class="page-title">📊 Spécialités lycée des admis</p>
  <p class="page-sub">Données nationales 2024 — taux d'admission par doublette de spécialités.</p>
  <?php endif; ?>

  <!-- -------------------------------------------------------
       FAMILY NAVIGATION
       One pill per filiere_agregee - reloads page with new param
       ------------------------------------------------------- -->
  <div class="filiere-nav">
    <?php foreach($filieres as $key => $label):
      $active = ($key === $filiere) ? ' active' : '';
      $url = '?filiere=' . urlencode($key)
           . ($detail_param ? '&detail=' . urlencode($detail_param) : '')
           . ($iframe ? '&iframe=1' : '');
    ?>
      <a href="<?php echo $url; ?>"
         class="filiere-btn<?php echo $active; ?>">
        <?php echo htmlspecialchars($label); ?>
      </a>
    <?php endforeach; ?>
  </div>

  <!-- -------------------------------------------------------
       SUB-SPECIALTY FILTER
       Free text input with datalist autocomplete from filiere_detail
       Submits as GET param ?detail=xxx
       JS also filters visible rows client-side for instant feedback
       ------------------------------------------------------- -->
  <form method="get" action="" style="margin:0;">
    <input type="hidden" name="filiere" value="<?php echo htmlspecialchars($filiere); ?>">
    <?php if($iframe): ?>
    <input type="hidden" name="iframe" value="1">
    <?php endif; ?>
    <div class="filtre-row">
      <span class="filtre-label" style="font-weight:600;color:var(--navy);">
        Préciser la filière :
      </span>
      <input type="text" name="detail" id="filtre-detail"
             class="filtre-input"
             value="<?php echo htmlspecialchars($detail_param); ?>"
             placeholder="ex: Informatique, MPSI, Lettres…"
             list="suggestions-list"
             autocomplete="off"
             style="<?php echo !$detail_active ? 'border-color:var(--terra);' : ''; ?>">
      <!-- Datalist fed from filiere_detail table -->
      <datalist id="suggestions-list">
        <?php foreach($suggestions as $s): ?>
          <option value="<?php echo htmlspecialchars($s); ?>">
        <?php endforeach; ?>
      </datalist>
      <button type="submit" class="filtre-clear"
              style="background:var(--terra);color:#fff;border-color:var(--terra);">
        Filtrer
      </button>
      <?php if($detail_param): ?>
      <a href="?filiere=<?php echo urlencode($filiere); ?><?php echo $iframe?'&iframe=1':''; ?>"
         class="filtre-clear">✕ Effacer</a>
      <?php endif; ?>
    </div>
  </form>
  <?php if(!$detail_active): ?>
  <p style="font-size:.78rem;color:var(--terra);margin-bottom:10px;margin-top:-6px;">
    ↑ Précisez une filière pour accéder à la liste des formations correspondantes.
  </p>
  <?php endif; ?>

  <!-- Active sub-specialty badge -->
  <?php if($detail_active): ?>
  <div class="detail-badge">
    <span>📌 Spécialité filtrée :</span>
    <strong><?php echo htmlspecialchars($detail_label); ?></strong>
    <span style="color:var(--gray);">(<?php echo $nb_formations; ?> formations)</span>
    <span style="font-size:.75rem;color:var(--gray);">
      — <?php if($sous_filiere !== ''): ?>
        CPGE <?php echo $sous_filiere; ?> uniquement
      <?php else: ?>
        doublettes agrégées sur l'ensemble des <?php echo htmlspecialchars($filiere); ?>
      <?php endif; ?>
    </span>
  </div>
  <?php elseif($detail_param && !$detail_active): ?>
  <div class="detail-badge" style="background:#fee2e2;border-color:#fca5a5;color:#991b1b;">
    ⚠️ Aucune spécialité trouvée pour "<?php echo htmlspecialchars($detail_param); ?>"
    — affichage de l'ensemble <?php echo htmlspecialchars($filiere); ?>
  </div>
  <?php endif; ?>

  <!-- -------------------------------------------------------
       GLOBAL STATS
       ------------------------------------------------------- -->
  <?php if(count($rows) > 0): ?>
  <div class="stats-bar">
    <div class="stat-pill">
      <strong><?php echo count($rows); ?></strong>
      doublettes
    </div>
    <div class="stat-pill">
      <strong><?php echo number_format($total_voeux, 0, ',', ' '); ?></strong>
      candidatures
    </div>
    <div class="stat-pill">
      <strong><?php echo number_format($total_admis, 0, ',', ' '); ?></strong>
      admis
    </div>
    <div class="stat-pill">
      <strong><?php echo $rows[0]['taux']; ?>%</strong>
      meilleur taux
    </div>
  </div>
  <?php endif; ?>

  <!-- -------------------------------------------------------
       DOUBLETTE RANKING
       Sorted by conversion rate DESC from SQL
       Top 3 get gold/silver/bronze border
       ------------------------------------------------------- -->
  <?php if(count($rows) === 0): ?>
    <p style="color:var(--gray);font-style:italic;padding:20px 0;">
      Aucune donnée disponible pour cette filière.
    </p>
  <?php else: ?>
  <div class="doublette-list" id="doublette-list">
    <?php foreach($rows as $i => $row):
      $rang      = $i + 1;
      $cls       = $rang===1 ? ' top1' : ($rang===2 ? ' top2' : ($rang===3 ? ' top3' : ''));
      $medaille  = $rang===1 ? '🥇 ' : ($rang===2 ? '🥈 ' : ($rang===3 ? '🥉 ' : ''));
      $pct_barre = $taux_max > 0
                   ? round(floatval($row['taux']) / $taux_max * 100)
                   : 0;
    ?>
    <div class="doublette-row<?php echo $cls; ?>"
         data-nom="<?php echo strtolower(htmlspecialchars($row['doublette'])); ?>">
      <div class="row-header">
        <span class="row-rang"><?php echo $rang; ?></span>
        <span class="row-nom">
          <?php echo $medaille . htmlspecialchars($row['doublette']); ?>
        </span>
        <span class="row-taux"><?php echo $row['taux']; ?>%</span>
      </div>
      <div class="row-barre-bg">
        <div class="row-barre-fill"
             style="width:<?php echo $pct_barre; ?>%;"></div>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:6px;">
        <div class="row-details">
          <?php echo number_format(intval($row['nb_voeux']), 0, ',', ' '); ?> candidats
          &nbsp;·&nbsp;
          <?php echo number_format(intval($row['nb_admis']), 0, ',', ' '); ?> admis
        </div>
        <?php if($detail_active): ?>
        <a href="doublette_detail.php?filiere=<?php echo urlencode($filiere);
          ?>&detail=<?php echo urlencode($detail_param);
          ?>&doublette=<?php echo urlencode($row['doublette']);
          ?><?php echo $iframe?'&iframe=1':''; ?>"
           style="display:inline-block;background:var(--terra);color:#fff;
                  padding:4px 12px;border-radius:6px;font-size:.75rem;
                  font-weight:600;text-decoration:none;white-space:nowrap;">
          Voir les <?php echo $nb_formations; ?> formations →
        </a>
        <?php else: ?>
        <span style="display:inline-block;background:#e5e7eb;color:#9ca3af;
                     padding:4px 12px;border-radius:6px;font-size:.75rem;
                     font-weight:600;white-space:nowrap;cursor:not-allowed;"
              title="Précisez une filière pour voir les formations">
          Précisez la filière →
        </span>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <p class="note-bas">
    Source : Open Data Parcoursup 2024 — Ministère de l'Enseignement supérieur.
    Bacheliers généraux uniquement — données agrégées au niveau national.
    <?php if($filiere === 'CPGE' && !$detail_active): ?>
    ⚠️ Les CPGE regroupent prépas scientifiques (MPSI, PCSI...), littéraires (Lettres, Khâgne)
    et économiques (ECG). Précisez une sous-filière pour un classement pertinent.
    <?php elseif($filiere === 'CPGE' && $sous_filiere !== ''): ?>
    Données filtrées sur CPGE <?php echo $sous_filiere; ?> uniquement (2024).
    <?php elseif($detail_active): ?>
    Données agrégées sur l'ensemble des <?php echo htmlspecialchars($filiere); ?>.
    <?php endif; ?>
    Ces données donnent des tendances, pas des garanties individuelles.
    Vérifiez aux Journées Portes Ouvertes.
  </p>
  <?php endif; ?>

  <?php if(!$iframe): ?>
  <footer>
    ©2026 Katy Saintin — Hors Kadre<br>
    <a href="parcoursup.php">Comprendre Parcoursup</a> |
    <a href="index.php">Accueil</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a>
  </footer>
  <?php endif; ?>

</div>
</body>
</html>
