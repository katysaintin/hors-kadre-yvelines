<?php
/*
 * Hors Kadre — Fiche formation Parcoursup
 * Copyright (c) 2026 Katy Saintin
 * Code: MIT License — Content: CC BY-NC 4.0
 * Legacy hosting compatible (mysql_* only, PHP 5.3)
 */

include('config.php');
include('functions.php');

connect_db();

$cod = isset($_GET['cod']) ? trim($_GET['cod']) : '';
if ($cod === '') { die('Formation introuvable.'); }
$cod = mysql_real_escape_string($cod);

$sql = "SELECT
            f26.nom_etablissement,
            f26.type_formation,
            f26.nom_long_formation,
            f26.nom_court_formation,
            f26.commune,
            f26.departement,
            f26.lien_fiche_formation,
            f26.internat,
            f26.apprentissage,
            f26.mentions_specialites,
            f26.site_internet,
            f26.cod_aff_form,

            f25.capacite,
            f25.nb_candidats_total,
            f25.nb_classes_total,
            f25.nb_admis_total,
            f25.nb_admis_neo_bg,
            f25.nb_admis_neo_bt,
            f25.nb_admis_neo_bp,
            f25.nb_admis_mention_ab,
            f25.nb_admis_mention_b,
            f25.nb_admis_mention_tb,
            f25.nb_admis_mention_tbf,
            f25.nb_admis_boursiers,
            f25.nb_admis_avant_bac,
            f25.nb_admis_ouverture,
            f25.pct_admis_neo_bg,
            f25.pct_admis_neo_bt,
            f25.pct_admis_neo_bp,
            f25.pct_admis_boursiers,
            f25.pct_admis_avant_bac,
            f25.pct_admis_ouverture,
            f25.pct_admis_f,
            f25.pct_admis_meme_academie,
            f25.rang_dernier_appele_g1,
            f25.taux_acces,
            f25.selectivite,
            ROUND(f25.nb_candidats_total / NULLIF(f25.capacite, 0), 1) AS ratio
        FROM formations_2026 f26
        LEFT JOIN formations_2025 f25 ON f26.cod_aff_form = f25.cod_aff_form
        WHERE f26.cod_aff_form = '" . $cod . "'
        LIMIT 1";

$res = mysql_query($sql);
$f = false;
if ($res) { $f = mysql_fetch_assoc($res); }
if (!$f)  { die('Formation introuvable.'); }

/* Variables */
$nb_candidats  = intval($f['nb_candidats_total']);
$nb_admis      = intval($f['nb_admis_total']);
$nb_classes    = intval($f['nb_classes_total']);
$capacite      = intval($f['capacite']);
$rang_limite   = intval($f['rang_dernier_appele_g1']);
$taux_acces    = (float)$f['taux_acces'];
$ratio         = (float)$f['ratio'];
$pct_bg        = (float)$f['pct_admis_neo_bg'];
$pct_bt        = (float)$f['pct_admis_neo_bt'];
$pct_bp        = (float)$f['pct_admis_neo_bp'];
$pct_ouverture = (float)$f['pct_admis_ouverture'];
$pct_avant_bac = (float)$f['pct_admis_avant_bac'];
$nb_tb         = intval($f['nb_admis_mention_tb']);
$nb_tbf        = intval($f['nb_admis_mention_tbf']);
$nb_b          = intval($f['nb_admis_mention_b']);
$nb_ab         = intval($f['nb_admis_mention_ab']);
$nb_non_appeles = max(0, $nb_classes - $nb_admis);

$fort_volume      = ($nb_candidats >= 2000);
$tres_fort_volume = ($nb_candidats >= 5000);
$analogy          = round($nb_candidats / 30);

if ($ratio <= 5)       $tension = 'faible';
elseif ($ratio <= 15)  $tension = 'moderee';
elseif ($ratio <= 30)  $tension = 'forte';
else                   $tension = 'tres_forte';

$tension_data = array(
    'faible'     => array('label' => 'Accessible',    'couleur' => '#2d8a4e', 'emoji' => '🟢'),
    'moderee'    => array('label' => 'Modéré',        'couleur' => '#c47f00', 'emoji' => '🟡'),
    'forte'      => array('label' => 'Tendu',         'couleur' => '#c45a00', 'emoji' => '🟠'),
    'tres_forte' => array('label' => 'Très sélectif', 'couleur' => '#b0261e', 'emoji' => '🔴'),
);
$td = $tension_data[$tension];

$bac_dominant = 'général';
if ($pct_bt > $pct_bg && $pct_bt > $pct_bp) $bac_dominant = 'technologique';
if ($pct_bp > $pct_bg && $pct_bp > $pct_bt) $bac_dominant = 'professionnel';

function sur_10($pct) { return max(0, min(10, round($pct / 10))); }

$titre_page   = $f['nom_long_formation'] ? $f['nom_long_formation'] : $f['type_formation'];

/* Lien typeformation selon la famille */
$type_form_str = strtolower($f['type_formation'] . ' ' . $f['nom_long_formation']);
$type_anchor = '';
if (strpos($type_form_str, 'but') !== false || strpos($type_form_str, 'bachelor') !== false)
    $type_anchor = 'but';
elseif (strpos($type_form_str, 'bts') !== false)
    $type_anchor = 'bts';
elseif (strpos($type_form_str, 'cpge') !== false || strpos($type_form_str, 'classe préparatoire') !== false || strpos($type_form_str, 'mpsi') !== false || strpos($type_form_str, 'pcsi') !== false)
    $type_anchor = 'cpge';
elseif (strpos($type_form_str, 'licence') !== false)
    $type_anchor = 'licence';
elseif (strpos($type_form_str, 'ingénieur') !== false || strpos($type_form_str, 'ingenieur') !== false)
    $type_anchor = 'ingenieur';
elseif (strpos($type_form_str, 'santé') !== false || strpos($type_form_str, 'infirmier') !== false || strpos($type_form_str, 'ifsi') !== false)
    $type_anchor = 'sante';
elseif (strpos($type_form_str, 'commerce') !== false || strpos($type_form_str, 'management') !== false)
    $type_anchor = 'commerce';
$lien_officiel = 'https://dossierappel.parcoursup.fr/Candidats/public/fiches/afficherFicheFormation?g_ta_cod=' . urlencode($f['cod_aff_form']) . '&typeBac=0&originePc=0';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo e($titre_page); ?> — Hors Kadre</title>
<meta name="description" content="Comprendre cette formation Parcoursup : concurrence réelle, profil des admis, conseils selon votre profil.">

<script async src="https://www.googletagmanager.com/gtag/js?id=G-TTTNJ36H5D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-TTTNJ36H5D', { 'anonymize_ip': true });
</script>

<style>
:root {
  --navy:#1B3A6B; --terra:#C4572A; --offwhite:#F5F0EB;
  --gold:#B8860B; --gray:#555; --border:#d9d1ca; --white:#fff;
  --green:#2d8a4e; --orange:#c45a00; --red:#b0261e;
}
*{box-sizing:border-box;}
body{margin:0;font-family:Georgia,"Times New Roman",serif;background:#fcfaf8;color:var(--navy);line-height:1.6;}
a{color:var(--terra);}
a:hover{text-decoration:underline;}

.site-header{background:var(--offwhite);border-bottom:3px solid var(--terra);padding:16px;text-align:center;}
.site-header img{max-width:100%;height:auto;margin-bottom:8px;}
.header-links{font-size:.88rem;}
.header-links a{margin:0 10px;color:var(--navy);text-decoration:none;}
.header-links a:hover{color:var(--terra);}

.container{max-width:860px;margin:0 auto;padding:20px 16px 80px;}
.breadcrumb{font-size:.85rem;color:var(--gray);margin-bottom:16px;}
.breadcrumb a{color:var(--terra);}

/* EN-TÊTE FORMATION */
.formation-header{border-left:6px solid var(--gold);padding:8px 0 8px 18px;margin-bottom:20px;}
.formation-header h1{font-size:1.4rem;color:var(--navy);margin:0 0 4px;line-height:1.3;}
.formation-header .sous-titre{color:var(--gray);font-size:.92rem;}
.tags{margin-top:8px;display:flex;flex-wrap:wrap;gap:6px;}
.tag{display:inline-block;padding:3px 10px;border-radius:10px;font-size:.75rem;font-weight:600;}
.tag-sel{background:#fef3c7;color:#92400e;}
.tag-open{background:#d1fae5;color:#065f46;}
.tag-int{background:#dbeafe;color:#1e40af;}
.tag-app{background:#ede9fe;color:#4c1d95;}

/* BLOCS */
.bloc{background:var(--offwhite);border:1px solid var(--border);border-radius:12px;padding:18px 20px;margin-bottom:18px;}
.bloc h2{color:var(--terra);font-size:1rem;margin:0 0 12px;padding-bottom:8px;border-bottom:1px solid var(--border);}

/* ENCARTS */
.encart{border-radius:8px;padding:12px 14px;margin:10px 0;font-size:.88rem;line-height:1.7;}
.encart-info {background:#e8f4fd;border:1px solid #b3d9f5;border-left:5px solid var(--navy);}
.encart-warn {background:#fff8e1;border:1px solid #ffe082;border-left:5px solid #c47f00;}
.encart-alert{background:#fef2f2;border:1px solid #fecaca;border-left:5px solid var(--red);}
.encart-tip  {background:#fff8f0;border:1px solid #f5d0a9;border-left:5px solid var(--terra);}
.encart strong{color:var(--navy);}
.encart-alert strong{color:var(--red);}
.encart-warn strong{color:#92400e;}

/* CHIFFRES CLÉS */
.chiffre-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:10px;margin-bottom:14px;}
.chiffre-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:12px;text-align:center;}
.chiffre-card .val{font-size:1.7rem;font-weight:700;color:var(--terra);display:block;}
.chiffre-card .lbl{font-size:.78rem;color:var(--gray);margin-top:3px;line-height:1.4;}

/* TENSION */
.tension-badge{display:inline-flex;align-items:center;gap:8px;background:var(--white);border:2px solid;border-radius:8px;padding:10px 16px;font-size:1rem;font-weight:700;margin-bottom:12px;}

/* SUR 10 */
.sur10-bloc{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:12px 14px;margin-bottom:12px;}
.sur10-titre{font-size:.8rem;font-weight:700;color:var(--gray);text-transform:uppercase;letter-spacing:.05em;margin-bottom:8px;}
.sur10-row{display:flex;align-items:center;gap:8px;margin-bottom:7px;font-size:.88rem;}
.sur10-label{width:100px;color:var(--gray);flex-shrink:0;font-size:.82rem;}
.sur10-dots{display:flex;gap:4px;}
.dot{width:20px;height:20px;border-radius:50%;flex-shrink:0;}
.dot-empty{background:var(--border);}
.sur10-pct{margin-left:4px;font-weight:700;color:var(--navy);font-size:.85rem;}

/* BARRES MENTIONS */
.mention-row{display:flex;align-items:center;gap:8px;margin-bottom:5px;font-size:.85rem;}
.mention-label{width:160px;flex-shrink:0;color:var(--gray);font-size:.8rem;}
.mention-bar-outer{flex:1;background:var(--border);border-radius:4px;height:9px;}
.mention-bar-inner{height:9px;border-radius:4px;}
.mention-nb{width:36px;text-align:right;font-weight:700;color:var(--navy);font-size:.8rem;}

/* PROFILS */
.profil-card{background:var(--white);border:1px solid var(--border);border-radius:10px;padding:14px 16px;margin-bottom:12px;border-left:5px solid;}
.profil-card h3{font-size:.95rem;margin:0 0 8px;}
.profil-card p{font-size:.87rem;color:var(--gray);margin:0 0 7px;line-height:1.6;}
.profil-card p:last-child{margin-bottom:0;}
.profil-card strong{color:var(--navy);}

/* GUIDE */
.guide-item{background:var(--white);border:1px solid var(--border);border-radius:8px;padding:11px 13px;margin-bottom:8px;}
.guide-item strong{color:var(--navy);display:block;margin-bottom:3px;font-size:.9rem;}
.guide-item span{font-size:.85rem;color:var(--gray);line-height:1.6;}

/* BOUTONS */
.btn-row{display:flex;gap:10px;flex-wrap:wrap;margin-top:14px;}
.btn{display:inline-block;padding:10px 20px;border-radius:8px;font-size:.88rem;font-weight:600;font-family:Georgia,serif;text-decoration:none;text-align:center;}
.btn-primary{background:var(--terra);color:var(--white);}
.btn-primary:hover{background:#a8452a;color:var(--white);text-decoration:none;}
.btn-secondary{background:var(--white);color:var(--navy);border:1px solid var(--border);}
.btn-secondary:hover{background:var(--offwhite);color:var(--navy);text-decoration:none;}

.footer-note{text-align:center;color:var(--gray);font-size:.8rem;margin-top:36px;padding-top:18px;border-top:1px solid var(--border);line-height:1.8;}
.footer-note a{color:var(--terra);}

/* ONGLETS */
.tabs-nav{display:flex;overflow-x:auto;gap:8px;padding:0 0 12px;margin-bottom:20px;scrollbar-width:none;}
.tabs-nav::-webkit-scrollbar{display:none;}
.tab-btn{
  flex-shrink:0;
  padding:9px 14px;
  font-family:Georgia,serif;
  font-size:.82rem;
  font-weight:600;
  color:var(--navy);
  background:var(--white);
  border:2px solid var(--border);
  border-radius:20px;
  cursor:pointer;
  white-space:nowrap;
  transition:all .2s;
}
.tab-btn:hover{border-color:var(--terra);color:var(--terra);}
.tab-btn.active{
  background:var(--terra);
  color:var(--white);
  border-color:var(--terra);
}
.tab-panel{display:none;}
.tab-panel.active{display:block;}

#rgpd{position:fixed;bottom:0;left:0;right:0;background:var(--navy);color:#F5F0EB;padding:12px 20px;font-size:13px;display:flex;justify-content:space-between;align-items:center;z-index:9999;font-family:Georgia,serif;}
#rgpd a{color:var(--terra);}
#rgpd button{background:var(--terra);color:#fff;border:none;padding:8px 16px;cursor:pointer;border-radius:4px;margin-left:20px;white-space:nowrap;font-size:13px;}

@media(max-width:600px){
  .chiffre-grid{grid-template-columns:repeat(2,1fr);}
  .formation-header h1{font-size:1.15rem;}
  .dot{width:15px;height:15px;}
  .sur10-dots{gap:3px;flex-wrap:wrap;max-width:170px;}
  .sur10-label{width:65px;font-size:.72rem;}
  .sur10-row{flex-wrap:wrap;gap:4px;}
  .sur10-pct{margin-left:0;}
  .mention-label{width:120px;}
  .btn-row{flex-direction:column;}
  .btn{width:100%;text-align:center;}
  #rgpd{flex-direction:column;gap:8px;text-align:center;}
}
</style>
</head>
<body>

<header class="site-header">
  <img src="banniere.png" alt="Hors Kadre">
  <div class="header-links">
    <a href="index.php">&larr; Accueil</a>
    <a href="parcoursup.php">Parcoursup Décodé</a>
    <a href="indexival.php">Comparer les lycées</a>
  </div>
</header>

<div class="container">

  <div class="breadcrumb">
    <a href="parcoursup.php">&larr; Retour à la recherche</a>
  </div>

  <!-- EN-TÊTE -->
  <div class="formation-header">
    <h1><?php echo e($titre_page); ?></h1>
    <div class="sous-titre">
      <?php echo e($f['nom_etablissement']); ?> —
      <?php echo e($f['commune']); ?>, <?php echo e($f['departement']); ?>
    </div>
    <div class="tags">
      <?php if ($f['selectivite'] === 'formation sélective'): ?>
        <span class="tag tag-sel">Formation sélective</span>
      <?php else: ?>
        <span class="tag tag-open">Formation non sélective</span>
      <?php endif; ?>
      <?php if ($f['internat']): ?><span class="tag tag-int">Internat disponible</span><?php endif; ?>
      <?php if ($f['apprentissage']): ?><span class="tag tag-app">Apprentissage possible</span><?php endif; ?>
    </div>
  </div>

  <!-- BLOC 1 : LA CONCURRENCE EN CLAIR -->
  <!-- NAVIGATION ONGLETS -->
  <div class="tabs-nav">
    <button class="tab-btn active" onclick="showTab('concurrence',this)">📊 Concurrence</button>
    <button class="tab-btn" onclick="showTab('admis',this)">🎓 Qui a été admis ?</button>
    <button class="tab-btn" onclick="showTab('profil',this)">🎯 Mon profil</button>
    <button class="tab-btn" onclick="showTab('plus',this)">📖 En savoir +</button>
  </div>

  <!-- ONGLET 1 : CONCURRENCE -->
  <div class="tab-panel active" id="tab-concurrence">
  <div class="bloc">
    <h2>📊 La concurrence en clair</h2>

    <?php if ($nb_candidats > 0): ?>

    <div class="tension-badge" style="border-color:<?php echo $td['couleur']; ?>;color:<?php echo $td['couleur']; ?>;">
      <?php echo $td['emoji']; ?> Concurrence <?php echo $td['label']; ?> —
      <?php echo fmt($ratio, 1); ?> candidat<?php echo ($ratio > 1) ? 's' : ''; ?> pour 1 place
    </div>

    <div class="chiffre-grid">
      <div class="chiffre-card">
        <span class="val"><?php echo fmtInt($nb_candidats); ?></span>
        <div class="lbl">candidatures reçues en 2025</div>
      </div>
      <div class="chiffre-card">
        <span class="val"><?php echo fmtInt($capacite); ?></span>
        <div class="lbl">places disponibles</div>
      </div>
      <?php if ($taux_acces > 0): ?>
      <div class="chiffre-card">
        <span class="val"><?php echo fmt_pct($taux_acces, 0); ?></span>
        <div class="lbl">ont reçu une proposition</div>
      </div>
      <?php endif; ?>
      <?php if ($rang_limite > 0): ?>
      <div class="chiffre-card">
        <span class="val"><?php echo fmtInt($rang_limite); ?></span>
        <div class="lbl">rang du dernier appelé</div>
      </div>
      <?php endif; ?>
    </div>

    <?php if ($analogy > 0): ?>
    <p style="font-size:.88rem;color:var(--gray);">
      Pour vous donner une idée : <?php echo fmtInt($nb_candidats); ?> candidatures,
      c'est comme si <strong><?php echo fmtInt($analogy); ?> classes entières</strong>
      postulaient en même temps pour <?php echo fmtInt($capacite); ?> places.
    </p>
    <?php endif; ?>

    <?php if ($pct_ouverture > 0): ?>
    <div class="encart encart-tip" style="margin-top:10px;">
      <strong><?php echo fmt_pct($pct_ouverture, 0); ?> des admis</strong>
      ont reçu leur proposition dès le 2 juin.
      <?php if ($pct_avant_bac > 0): ?>
        <strong><?php echo fmt_pct($pct_avant_bac, 0); ?></strong>
        l'ont reçue avant même les résultats du bac.
      <?php endif; ?>
      Si votre enfant n'est pas dans ce cas, la liste d'attente bouge beaucoup — patience.
    </div>
    <?php endif; ?>

    <?php if ($fort_volume): ?>
    <div class="encart encart-warn">
      <strong>Formation à fort volume (<?php echo fmtInt($nb_candidats); ?> candidatures) :</strong>
      avec autant de dossiers, le premier critère examiné est très probablement
      la <strong>moyenne des bulletins</strong>.
      Allez aux <strong>Journées Portes Ouvertes (JPO)</strong> pour savoir exactement
      comment les dossiers sont traités — c'est la seule façon d'avoir une réponse fiable.
    </div>
    <?php endif; ?>

    <?php else: ?>
    <p style="color:var(--gray);font-style:italic;">Les données de candidature 2025 ne sont pas disponibles pour cette formation.</p>
    <?php endif; ?>
  </div>

  <!-- BLOC 2 : QUI A ÉTÉ ADMIS -->
  </div><!-- /tab-concurrence -->

  <!-- ONGLET 2 : QUI A ÉTÉ ADMIS -->
  <div class="tab-panel" id="tab-admis">
  <div class="bloc">
    <h2>🎓 Qui a été admis en 2025 ?</h2>

    <?php if ($nb_admis > 0): ?>

    <div class="encart encart-info" style="margin-bottom:12px;">
      <strong>Ce que vous voyez ici :</strong> les notes de bulletins (Première et Terminale)
      servent de base à la sélection — pas les notes du bac.
      Les mentions ci-dessous donnent une idée du niveau général des admis,
      sans en être la cause directe.
    </div>

    <p style="font-size:.9rem;margin-bottom:10px;">
      Sur <strong><?php echo fmtInt($nb_admis); ?> élèves admis</strong>, voici leur profil.
    </p>

    <!-- Sur 10 par type de bac -->
    <div class="sur10-bloc">
      <div class="sur10-titre">Sur 10 élèves admis, combien par type de bac ?</div>
      <?php
      $bacs = array(
        array('label' => 'Bac général', 'pct' => $pct_bg, 'color' => '#1B3A6B'),
        array('label' => 'Bac techno',  'pct' => $pct_bt, 'color' => '#C4572A'),
        array('label' => 'Bac pro',     'pct' => $pct_bp, 'color' => '#B8860B'),
      );
      foreach ($bacs as $bac):
          $n = sur_10($bac['pct']);
      ?>
      <div class="sur10-row">
        <span class="sur10-label"><?php echo e($bac['label']); ?></span>
        <div class="sur10-dots">
          <?php for ($i = 0; $i < 10; $i++): ?>
            <div class="dot <?php echo ($i < $n) ? '' : 'dot-empty'; ?>"
                 style="<?php echo ($i < $n) ? 'background:'.$bac['color'].';' : ''; ?>"></div>
          <?php endfor; ?>
        </div>
        <span class="sur10-pct"><?php echo $bac['pct'] > 0 ? fmt_pct($bac['pct'], 0) : '-'; ?></span>
      </div>
      <?php endforeach; ?>
      <p style="font-size:.8rem;color:var(--gray);margin-top:8px;margin-bottom:0;">
        ⚠️ <strong>Important :</strong> bac général, techno et pro sont dans des
        <strong>files séparées</strong>. Votre enfant n'est en compétition
        qu'avec les candidats du même type de bac.
      </p>
    </div>

    <!-- Mentions -->
    <?php
    $total_mentions = $nb_tb + $nb_tbf + $nb_b + $nb_ab;
    if ($total_mentions > 0):
      $max_m = max($nb_tbf, $nb_tb, $nb_b, $nb_ab, 1);
      $mentions = array(
        array('label' => 'TB + félicitations', 'nb' => $nb_tbf, 'color' => '#1B3A6B'),
        array('label' => 'Très Bien',          'nb' => $nb_tb,  'color' => '#2d8a4e'),
        array('label' => 'Bien',               'nb' => $nb_b,   'color' => '#c47f00'),
        array('label' => 'Assez Bien',         'nb' => $nb_ab,  'color' => '#c45a00'),
      );
    ?>
    <div class="sur10-bloc">
      <div class="sur10-titre">Mention au bac des élèves admis (indicatif)</div>
      <?php foreach ($mentions as $m):
          $w = round(($m['nb'] / $max_m) * 100);
      ?>
      <div class="mention-row">
        <span class="mention-label"><?php echo e($m['label']); ?></span>
        <div class="mention-bar-outer">
          <div class="mention-bar-inner" style="width:<?php echo $w; ?>%;background:<?php echo $m['color']; ?>;"></div>
        </div>
        <span class="mention-nb"><?php echo fmtInt($m['nb']); ?></span>
      </div>
      <?php endforeach; ?>
      <p style="font-size:.8rem;color:var(--gray);margin-top:8px;margin-bottom:0;">
        Ce sont les bulletins qui comptent, pas la mention. Un élève avec mention modeste
        dans un lycée exigeant peut avoir des bulletins plus solides qu'un élève mention TB
        dans un lycée plus généreux.
        <a href="http://katy.ho.free.fr/indexival.php" target="_blank">Données IVAL des lycées →</a>
      </p>
    </div>
    <?php endif; ?>

    <?php if ($f['pct_admis_boursiers'] > 0): ?>
    <p style="font-size:.85rem;color:var(--gray);margin-top:6px;">
      🎒 <strong><?php echo fmt_pct($f['pct_admis_boursiers'], 0); ?></strong> des admis
      étaient boursiers — c'est un avantage réel, garanti par la loi.
    </p>
    <?php endif; ?>

    <?php if ($f['pct_admis_meme_academie'] > 0): ?>
    <p style="font-size:.85rem;color:var(--gray);margin-top:4px;">
      📍 <strong><?php echo fmt_pct($f['pct_admis_meme_academie'], 0); ?></strong> des admis
      venaient de la même académie.
    </p>
    <?php endif; ?>

    <?php else: ?>
    <p style="color:var(--gray);font-style:italic;">Données d'admission 2025 non disponibles pour cette formation.</p>
    <?php endif; ?>
  </div>

  </div><!-- /tab-admis -->

  <!-- ONGLET 3 : MON PROFIL -->
  <div class="tab-panel" id="tab-profil">
  <div class="bloc">
    <h2>🎯 Mon enfant, où se situe-t-il ?</h2>

    <div class="encart encart-info" style="margin-bottom:14px;">
      Ces profils sont construits à partir des données 2025.
      Ils donnent des repères — pas des certitudes. <strong>C'est la formation qui décide.</strong>
    </div>

    <!-- PROFIL CONFORTABLE -->
    <div class="profil-card" style="border-left-color:var(--green);">
      <h3 style="color:var(--green);">🟢 Profil Serein</h3>
      <p>
        <strong>Qui c'est :</strong> un élève de bac <?php echo $bac_dominant; ?>
        avec de bonnes moyennes régulières en contrôle continu
        et un projet cohérent avec la formation.
      </p>
      <p>
        <strong>En 2025 :</strong>
        <?php if ($pct_ouverture > 0): ?>
          <?php echo fmt_pct($pct_ouverture, 0); ?> des admis ont reçu leur proposition dès le 2 juin.
          <?php if ($nb_tb + $nb_tbf > 0): ?>
            <?php echo fmtInt($nb_tb + $nb_tbf); ?> élèves admis avaient mention TB ou TB avec félicitations.
          <?php endif; ?>
        <?php else: ?>
          Ce profil correspond aux élèves admis en tête de liste.
        <?php endif; ?>
      </p>
      <?php if ($fort_volume): ?>
      <div class="encart encart-warn" style="margin-top:6px;font-size:.83rem;">
        Formation à fort volume — le premier critère examiné est très probablement
        la <strong>moyenne brute des bulletins</strong>.
        Allez aux <strong>Journées Portes Ouvertes</strong> pour confirmer.
      </div>
      <?php endif; ?>
      <p><strong>Ce que ça veut dire :</strong> si votre enfant correspond à ce profil,
        il a de bonnes chances d'être admis rapidement.</p>
    </div>

    <!-- PROFIL DANS LA COURSE -->
    <div class="profil-card" style="border-left-color:#c47f00;">
      <h3 style="color:#c47f00;">🟡 Profil Dans la course</h3>
      <p>
        <strong>Qui c'est :</strong> un élève avec des moyennes dans la moyenne
        ou légèrement au-dessus, avec un dossier cohérent.
      </p>
      <div class="encart encart-warn" style="margin-top:6px;font-size:.83rem;">
        <strong>La moyenne brute ne dit pas tout.</strong>
        Dans une classe à 15 de moyenne, un 13 place en bas du classement.
        Dans une classe à 11, le même 13 place en tête.
        Parcoursup transmet la moyenne <em>et</em> le rang dans la classe,
        mais <strong>la formation n'est pas tenue d'en tenir compte</strong>.
        <a href="http://katy.ho.free.fr/indexival.php" target="_blank">Données IVAL des lycées →</a>
      </div>
      <?php if ($nb_b + $nb_ab > 0): ?>
      <p>
        <strong>En 2025 :</strong> <?php echo fmtInt($nb_b + $nb_ab); ?> élèves admis
        avaient mention Bien ou Assez Bien — ce profil a des précédents d'admission.
        <?php if ($rang_limite > 0): ?>
          La liste d'attente est allée jusqu'au rang <?php echo fmtInt($rang_limite); ?>.
        <?php endif; ?>
      </p>
      <?php endif; ?>
      <?php if ($fort_volume): ?>
      <div class="encart encart-alert" style="margin-top:6px;font-size:.83rem;">
        <strong>Formation à fort volume :</strong> la lettre de motivation
        a peu de chances d'être lue au premier tri.
        <strong>Allez aux Journées Portes Ouvertes.</strong>
      </div>
      <?php else: ?>
      <div class="encart encart-tip" style="margin-top:6px;font-size:.83rem;">
        Formation à volume modéré — la lettre de motivation et les appréciations
        ont plus de chances d'être lues. Un dossier bien présenté compte.
      </div>
      <?php endif; ?>
      <p><strong>Ce que ça veut dire :</strong> l'admission est possible.
        Surveillez votre messagerie Parcoursup — la liste d'attente évolue.</p>
    </div>

    <!-- PROFIL RISQUÉ -->
    <div class="profil-card" style="border-left-color:var(--red);">
      <h3 style="color:var(--red);">🔴 Profil Risqué</h3>
      <p>
        <strong>Qui c'est :</strong> un élève avec des moyennes en dessous de la moyenne
        de sa classe dans les matières clés de cette formation.
      </p>
      <?php if ($nb_non_appeles > 0): ?>
      <p>
        <strong>En 2025 :</strong> <strong><?php echo fmtInt($nb_non_appeles); ?> candidats</strong>
        classés par la formation n'ont jamais reçu de proposition —
        la liste d'attente n'est pas allée jusqu'à eux.
        <?php if ($taux_acces > 0 && $taux_acces < 25): ?>
          Avec un taux d'accès de <?php echo fmt_pct($taux_acces, 0); ?>,
          cette formation est parmi les plus sélectives.
        <?php endif; ?>
      </p>
      <?php endif; ?>
      <p>
        <strong>Ce que ça veut dire :</strong> cette formation ne doit pas être le seul vœu.
        Avoir des formations alternatives dans son dossier est indispensable.
      </p>
    </div>

    <!-- RAPPEL -->
    <div class="encart encart-tip">
      <strong>💡 En résumé :</strong>
      Parcoursup transmet votre dossier complet. C'est la formation qui décide
      comment elle l'examine — ses critères ne sont pas publics.
      <?php if ($fort_volume): ?>
        Avec <?php echo fmtInt($nb_candidats); ?> candidatures,
        la moyenne des bulletins est très probablement le premier filtre.
        <strong>Allez aux Journées Portes Ouvertes. Posez la question directement.</strong>
      <?php else: ?>
        Les bulletins restent centraux. Les appréciations et la lettre de motivation
        peuvent faire la différence — confirmez-le aux Journées Portes Ouvertes.
      <?php endif; ?>
      <br><br>
      Ces chiffres sont des repères, pas des verdicts. Des milliers de familles
      ont navigué Parcoursup sereinement en comprenant ces mécanismes —
      vous venez de le faire.
    </div>
  </div>

  </div><!-- /tab-profil -->

  <!-- ONGLET 4 : EN SAVOIR PLUS -->
  <div class="tab-panel" id="tab-plus">
  <div class="bloc">
    <h2>🔍 Comment lire la fiche officielle Parcoursup ?</h2>

    <p style="font-size:.88rem;color:var(--gray);margin-bottom:12px;">
      4 éléments à regarder en priorité sur la fiche officielle :
    </p>

    <div class="guide-item">
      <strong>1. Le nombre de places</strong>
      <span>La capacité d'accueil. Comparez-le au nombre de vœux confirmés pour évaluer la tension cette année.</span>
    </div>
    <div class="guide-item">
      <strong>2. Le profil des admis l'an dernier</strong>
      <span>Cliquez sur "Voir leur profil". La répartition par type de bac est la donnée la plus utile —
      en gardant à l'esprit que la sélection se fait par file séparée (général, techno, pro).</span>
    </div>
    <div class="guide-item">
      <strong>3. Le rang du dernier appelé</strong>
      <span>Si votre enfant est classé au-delà de ce rang, il ne reçoit pas de proposition —
      sauf si des candidats mieux classés renoncent, ce qui arrive souvent en juillet.</span>
    </div>
    <div class="guide-item">
      <strong>4. Le taux d'accès</strong>
      <span>Le pourcentage de candidats qui ont reçu une proposition.
      30% = 7 candidats sur 10 n'ont rien reçu. 80% = presque tout le monde a eu une proposition.</span>
    </div>

    <div class="encart encart-info" style="margin-top:12px;">
      <strong>🆕 Nouveauté 2026 :</strong>
      le nombre de vœux confirmés et de places sont affichés en temps réel
      sur chaque fiche Parcoursup cette session.
    </div>

    <div class="btn-row">
      <a href="<?php echo e($lien_officiel); ?>" target="_blank" rel="noopener noreferrer"
         class="btn btn-primary">Voir la fiche officielle Parcoursup ↗</a>
      <a href="parcoursup.php" class="btn btn-secondary">&larr; Retour à la recherche</a>
    </div>
  </div>

      <div style="margin-top:16px;padding:14px 16px;background:var(--offwhite);border:1px solid var(--border);border-radius:10px;font-size:.88rem;">
        📖 <strong>Vous ne savez pas ce qu'est cette formation ?</strong><br>
        <?php if($type_anchor): ?>
          <a href="typeformation.html#<?php echo $type_anchor; ?>" style="color:var(--terra);font-weight:600;">
            → Comprendre ce qu'est un <?php echo strtoupper($type_anchor); ?> →
          </a>
        <?php else: ?>
          <a href="typeformation.html" style="color:var(--terra);font-weight:600;">
            → Comprendre les différences BUT, BTS, Licence, Prépa…
          </a>
        <?php endif; ?>
      </div>
  </div><!-- /tab-plus -->

  <!-- FIN ONGLETS -->

  <p class="footer-note">
    ©2026 Katy Saintin — Hors Kadre<br>
    Données Open Data Parcoursup 2025 — Licence Ouverte 2.0<br>
    Avec les éclairages de <a href="https://www.linkedin.com/in/virginiebusquet/" target="_blank">Virginie Busquet</a>, conseillère d'orientation.<br>
    <a href="legal/apropos.html">À propos</a> |
    <a href="legal/mentions-legales.html">Mentions légales</a> |
    <a href="mailto:katy.saintin@gmail.com">Contact</a>
  </p>

</div>

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

<script>
function showTab(id, btn) {
  // Masquer tous les panneaux
  document.querySelectorAll('.tab-panel').forEach(function(p){ p.classList.remove('active'); });
  document.querySelectorAll('.tab-btn').forEach(function(b){ b.classList.remove('active'); });
  // Afficher le bon
  document.getElementById('tab-'+id).classList.add('active');
  btn.classList.add('active');
  // Scroll en haut du panneau sur mobile
  document.getElementById('tab-'+id).scrollIntoView({behavior:'smooth', block:'start'});
}
</script>
</body>
</html>
