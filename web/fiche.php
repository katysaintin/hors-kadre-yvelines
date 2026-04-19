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
 */

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die('Fiche introuvable.');
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
            voie,
            uai,
            fiche_ival_url,
            ival,
            taux_bac,
            taux_mentions,
            taux_acces_seconde,
            effectif_seconde,
            effectif_premiere,
            effectif_terminale,
            evolution_effectif,
            score_mentions,
            score_global,
            source_annee,
            source_type,
            source_url
        FROM lycees
        WHERE id = " . intval($id) . "
        LIMIT 1";

$result = mysql_query($sql);
$lycee = false;

if ($result) {
    $lycee = mysql_fetch_assoc($result);
}

if (!$lycee) {
    die('Fiche introuvable.');
}

$officialUrl = isset($lycee['fiche_ival_url']) ? trim($lycee['fiche_ival_url']) : '';

function fiche_value($value)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return e($value);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo e($lycee['nom']); ?> - Fiche lycee</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root {
            --navy: #1B3A6B;
            --terracotta: #C4572A;
            --offwhite: #F5F0EB;
            --gold: #B8860B;
            --gray: #555555;
            --border: #d9d1ca;
            --white: #ffffff;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            background: #fcfaf8;
            color: var(--navy);
            line-height: 1.55;
        }

        a {
            color: var(--terracotta);
        }

        .container {
            max-width: 1080px;
            margin: 0 auto;
            padding: 24px 18px 42px;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 18px;
            color: var(--terracotta);
            text-decoration: none;
            font-weight: 600;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        header {
            margin-bottom: 20px;
            border-left: 6px solid var(--gold);
            padding: 6px 0 6px 16px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 2rem;
            color: var(--navy);
            line-height: 1.2;
        }

        .subtitle {
            margin: 0;
            color: var(--gray);
            font-size: 0.98rem;
        }

        .panel {
            background: var(--offwhite);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 18px;
            box-shadow: 0 4px 18px rgba(27, 58, 107, 0.04);
        }

        .panel h2 {
            margin: 0 0 12px;
            color: var(--terracotta);
            font-size: 1.18rem;
        }

        .intro {
            color: var(--gray);
            margin: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(220px, 1fr));
            gap: 14px 18px;
        }

        .item {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 12px 14px;
        }

        .label {
            display: block;
            color: var(--gray);
            font-size: 0.88rem;
            margin-bottom: 4px;
        }

        .value {
            display: block;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--navy);
        }

        .btn-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 8px;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            border: 1px solid var(--navy);
            background: var(--navy);
            color: var(--white);
            font-weight: 600;
        }

        .btn:hover {
            text-decoration: none;
            opacity: 0.95;
        }

        .btn-secondary {
            background: var(--white);
            color: var(--navy);
        }

        .note {
            color: var(--gray);
            font-size: 0.94rem;
            margin: 0;
        }

        .source-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px;
        }

        .source-box p {
            margin: 0 0 8px;
        }

        .source-box p:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 760px) {
            .grid {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 1.6rem;
            }

            .container {
                padding: 18px 12px 30px;
            }
        }
    </style>
</head>
<body>
<div class="container">

    <a class="back-link" href="index.php">&larr; Retour au classement</a>

    <header>
        <h1><?php echo e($lycee['nom']); ?></h1>
        <p class="subtitle">
            <?php echo fiche_value(isset($lycee['ville']) ? $lycee['ville'] : ''); ?>
            <?php if (!empty($lycee['departement'])) { ?>
                - <?php echo e($lycee['departement']); ?>
            <?php } ?>
            <?php if (!empty($lycee['academie'])) { ?>
                - Academie de <?php echo e($lycee['academie']); ?>
            <?php } ?>
        </p>
    </header>

    <section class="panel">
        <h2>Presentation</h2>
        <p class="intro">
            Cette fiche presente les principaux indicateurs publics disponibles pour cet etablissement,
            ainsi que les champs analytiques complementaires affiches dans ce projet.
        </p>
    </section>

    <section class="panel">
        <h2>Informations generales</h2>
        <div class="grid">
            <div class="item">
                <span class="label">Statut</span>
                <span class="value"><?php echo fiche_value(isset($lycee['statut']) ? $lycee['statut'] : ''); ?></span>
            </div>

            <div class="item">
                <span class="label">Voie</span>
                <span class="value"><?php echo fiche_value(isset($lycee['voie']) ? $lycee['voie'] : ''); ?></span>
            </div>

            <div class="item">
                <span class="label">UAI</span>
                <span class="value"><?php echo fiche_value(isset($lycee['uai']) ? $lycee['uai'] : ''); ?></span>
            </div>

            <div class="item">
                <span class="label">Annee source</span>
                <span class="value"><?php echo fiche_value(isset($lycee['source_annee']) ? $lycee['source_annee'] : ''); ?></span>
            </div>
        </div>
    </section>

    <section class="panel">
        <h2>Indicateurs</h2>
        <div class="grid">
            <div class="item">
                <span class="label">IVAL</span>
                <span class="value"><?php echo fmt(isset($lycee['ival']) ? $lycee['ival'] : null, 1); ?></span>
            </div>

            <div class="item">
                <span class="label">Taux de reussite au bac (%)</span>
                <span class="value"><?php echo fmt(isset($lycee['taux_bac']) ? $lycee['taux_bac'] : null, 1); ?></span>
            </div>

            <div class="item">
                <span class="label">Taux de mentions (%)</span>
                <span class="value"><?php echo fmt(isset($lycee['taux_mentions']) ? $lycee['taux_mentions'] : null, 1); ?></span>
            </div>

            <div class="item">
                <span class="label">Taux d'acces seconde vers bac (%)</span>
                <span class="value"><?php echo fmt(isset($lycee['taux_acces_seconde']) ? $lycee['taux_acces_seconde'] : null, 1); ?></span>
            </div>

            <div class="item">
                <span class="label">Effectif de seconde</span>
                <span class="value"><?php echo fmtInt(isset($lycee['effectif_seconde']) ? $lycee['effectif_seconde'] : null); ?></span>
            </div>

            <div class="item">
                <span class="label">Effectif de premiere</span>
                <span class="value"><?php echo fmtInt(isset($lycee['effectif_premiere']) ? $lycee['effectif_premiere'] : null); ?></span>
            </div>

            <div class="item">
                <span class="label">Effectif de terminale</span>
                <span class="value"><?php echo fmtInt(isset($lycee['effectif_terminale']) ? $lycee['effectif_terminale'] : null); ?></span>
            </div>

            <div class="item">
                <span class="label">Evolution des effectifs</span>
                <span class="value"><?php echo fmtSigned(isset($lycee['evolution_effectif']) ? $lycee['evolution_effectif'] : null); ?></span>
            </div>

            <div class="item">
                <span class="label">Mentions ponderees</span>
                <span class="value"><?php echo fmt(isset($lycee['score_mentions']) ? $lycee['score_mentions'] : null, 2); ?></span>
            </div>

            <div class="item">
                <span class="label">Score global</span>
                <span class="value"><?php echo fmt(isset($lycee['score_global']) ? $lycee['score_global'] : null, 3); ?></span>
            </div>
        </div>
    </section>

    <section class="panel">
        <h2>Reference officielle</h2>

        <div class="btn-row">
            <?php if ($officialUrl !== '') { ?>
                <a class="btn" href="<?php echo e($officialUrl); ?>" target="_blank" rel="noopener noreferrer">
                    Voir la fiche officielle
                </a>
            <?php } ?>

            <a class="btn btn-secondary" href="index.php">
                Retour au classement
            </a>
        </div>

        <p class="note" style="margin-top:12px;">
            Cette fiche presente des donnees publiques agregees. Les calculs complementaires affiches ici
            relevent d'un modele d'analyse independant.
        </p>
    </section>

    <section class="panel">
        <h2>Source des donnees</h2>
        <div class="source-box">
            <p><strong>Type de source :</strong> <?php echo fiche_value(isset($lycee['source_type']) ? $lycee['source_type'] : ''); ?></p>
            <p><strong>Reference :</strong> <?php echo fiche_value(isset($lycee['source_annee']) ? $lycee['source_annee'] : ''); ?></p>
            <?php if (!empty($lycee['source_url'])) { ?>
                <p><strong>Lien source :</strong> <a href="<?php echo e($lycee['source_url']); ?>" target="_blank" rel="noopener noreferrer">Consulter le document source</a></p>
            <?php } ?>
        </div>
    </section>

</div>
</body>
</html>
