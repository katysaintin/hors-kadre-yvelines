<?php

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
            source_annee
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
    $params['page'] = $pageNumber;

    return '?' . http_build_query($params);
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
    <title>Hors Kadre - Classement exploratoire des lycees</title>
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
            --green-soft: rgba(27, 58, 107, 0.10);
            --orange-soft: rgba(196, 87, 42, 0.10);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Georgia, "Times New Roman", serif;
            background: #fcfaf8;
            color: var(--navy);
            line-height: 1.5;
        }

        a {
            color: var(--terracotta);
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 1380px;
            margin: 0 auto;
            padding: 24px 18px 42px;
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

        .hero-image {
            width: 100%;
            max-width: 100%;
            display: block;
            border-radius: 12px;
            margin-bottom: 14px;
        }

        .info-list {
            margin: 0;
            padding-left: 18px;
        }

        .info-list li {
            margin-bottom: 6px;
        }

        .filters-form {
            display: grid;
            grid-template-columns: repeat(7, minmax(120px, 1fr));
            gap: 12px;
            align-items: end;
        }

        .field label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            font-size: 0.92rem;
        }

        .field input,
        .field select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--white);
            color: var(--navy);
            font-size: 0.95rem;
        }

        .actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
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
            cursor: pointer;
        }

        .btn:hover {
            text-decoration: none;
            opacity: 0.95;
        }

        .btn-secondary {
            background: var(--white);
            color: var(--navy);
        }

        .meta {
            color: var(--gray);
            font-size: 0.92rem;
            margin-top: 10px;
        }

        .warning {
            margin-top: 10px;
            color: var(--terracotta);
            font-size: 0.92rem;
            font-weight: 600;
        }

        .sort-box {
            margin-top: 12px;
            padding: 12px 14px;
            background: rgba(245, 240, 235, 0.7);
            border: 1px dashed var(--border);
            border-radius: 10px;
            color: var(--gray);
            font-size: 0.94rem;
        }

        .sort-box strong {
            color: var(--navy);
        }

        .method-list {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .method-list li {
            margin-bottom: 6px;
        }

        .table-wrap {
            overflow-x: auto;
            background: var(--white);
            border-radius: 14px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 18px rgba(27, 58, 107, 0.04);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1320px;
            background: var(--white);
        }

        th, td {
            padding: 12px 10px;
            border-bottom: 1px solid #ece6e1;
            text-align: left;
            vertical-align: middle;
        }

        thead th {
            background: var(--navy);
            color: var(--white);
            font-size: 0.9rem;
            white-space: nowrap;
        }

        tbody tr:nth-child(even) {
            background: #fbf8f5;
        }

        tbody tr:hover {
            background: #f3ede7;
        }

        .num {
            text-align: right;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .rank-cell {
            font-weight: 700;
            color: var(--navy);
        }

        .rank-badge {
            display: inline-block;
            min-width: 32px;
            text-align: center;
            padding: 4px 8px;
            border-radius: 999px;
            background: var(--green-soft);
            color: var(--navy);
            font-weight: 700;
        }

        .small {
            color: var(--gray);
            font-size: 0.88rem;
        }

        .lycee-link {
            color: var(--navy);
            text-decoration: none;
            font-weight: 700;
        }

        .lycee-link:hover {
            color: var(--terracotta);
        }

        .official-link {
            display: inline-block;
            margin-top: 4px;
            color: var(--terracotta);
            text-decoration: none;
            font-size: 0.86rem;
        }

        .detail-btn {
            display: inline-block;
            padding: 6px 10px;
            border: 1px solid var(--navy);
            border-radius: 8px;
            text-decoration: none;
            color: var(--navy);
            background: var(--white);
            font-size: 0.88rem;
            font-weight: 600;
        }

        .detail-btn:hover {
            background: var(--navy);
            color: var(--white);
            text-decoration: none;
        }

        .score-main {
            font-weight: 700;
            color: var(--navy);
        }

        .score-muted {
            color: var(--gray);
        }

        .pagination {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 18px;
            justify-content: center;
        }

        .pagination a,
        .pagination span {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 8px;
            text-decoration: none;
            border: 1px solid var(--border);
            background: var(--white);
            color: var(--navy);
        }

        .pagination .current {
            background: var(--navy);
            color: var(--white);
            border-color: var(--navy);
        }

        .footer-note {
            margin-top: 18px;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .accent {
            color: var(--terracotta);
            font-weight: 700;
        }

        @media (max-width: 1180px) {
            .filters-form {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 760px) {
            .filters-form {
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

    <header>
        <h1>Classement exploratoire des lycees selon les IVAL par Hors Kadre</h1>
        <p class="subtitle">
            Lecture independante de donnees publiques sur les lycees - &copy; Katy Ho
        </p>
    </header>

    <section class="panel">
        <img src="banniere.png" alt="Banniere Hors Kadre" class="hero-image">

        <ul class="info-list">
            <li><strong>Page Facebook :</strong> <a href="https://www.facebook.com/people/Hors-Kadre/61570725300507/" target="_blank">@Hors Kadre</a></li>
            <li><strong>Article Mediapart :</strong> <a href="https://blogs.mediapart.fr/katy-ho/blog/150426/parcoursup-ce-que-ni-les-classements-des-lycees-ni-les-enseignants-ne-vous-disent" target="_blank">Parcoursup : ce que ni les classements des lycees ni les enseignants ne vous disent</a></li>
        </ul>
    </section>

    <section class="panel">
        <h2>Recherche et filtres</h2>

        <form method="get" class="filters-form">
            <div class="field">
                <label for="q">Nom du lycee</label>
                <input type="text" name="q" id="q" value="<?php echo safe_html($q); ?>" placeholder="Nom du lycee">
            </div>

            <div class="field">
                <label for="ville">Ville</label>
                <input type="text" name="ville" id="ville" value="<?php echo safe_html($ville); ?>" placeholder="Ville">
            </div>

            <div class="field">
                <label for="academie">Academie</label>
                <select name="academie" id="academie">
                    <option value="">Toutes</option>
                    <?php
                    foreach ($academies as $item) {
                        $selected = ($academie === (string)$item) ? 'selected="selected"' : '';
                        echo '<option value="' . safe_html((string)$item) . '" ' . $selected . '>' . safe_html((string)$item) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="field">
                <label for="departement">Departement</label>
                <select name="departement" id="departement">
                    <option value="">Tous</option>
                    <?php
                    foreach ($departements as $item) {
                        $selected = ($departement === (string)$item) ? 'selected="selected"' : '';
                        echo '<option value="' . safe_html((string)$item) . '" ' . $selected . '>' . safe_html((string)$item) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="field">
                <label for="statut">Statut</label>
                <select name="statut" id="statut">
                    <option value="">Tous</option>
                    <?php
                    foreach ($statuts as $item) {
                        $selected = ($statut === (string)$item) ? 'selected="selected"' : '';
                        echo '<option value="' . safe_html((string)$item) . '" ' . $selected . '>' . safe_html((string)$item) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="field">
                <label for="sort">Tri par</label>
                <select name="sort" id="sort">
                    <!--<option value="score_global" <!-- if ($sort === 'score_global') { echo 'selected="selected"'; } ?>>Score global</option>-->
                    <option value="ival" <?php if ($sort === 'ival') { echo 'selected="selected"'; } ?>>IVAL</option>
                    <option value="taux_bac" <?php if ($sort === 'taux_bac') { echo 'selected="selected"'; } ?>>Taux de reussite au bac</option>
                    <option value="taux_mentions" <?php if ($sort === 'taux_mentions') { echo 'selected="selected"'; } ?>>Taux de mentions</option>
                    <option value="evolution_effectif" <?php if ($sort === 'evolution_effectif') { echo 'selected="selected"'; } ?>>Evolution des effectifs</option>
                    <option value="score_mentions" <?php if ($sort === 'score_mentions') { echo 'selected="selected"'; } ?>>Mentions ponderees</option>
                    <option value="nom" <?php if ($sort === 'nom') { echo 'selected="selected"'; } ?>>Nom du lycee</option>
                    <option value="ville" <?php if ($sort === 'ville') { echo 'selected="selected"'; } ?>>Ville</option>
                </select>
            </div>

            <div class="field">
                <label for="order">Ordre</label>
                <select name="order" id="order">
                    <option value="desc" <?php if ($order === 'desc') { echo 'selected="selected"'; } ?>>Decroissant</option>
                    <option value="asc" <?php if ($order === 'asc') { echo 'selected="selected"'; } ?>>Croissant</option>
                </select>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Filtrer</button>
                <a href="index.php" class="btn btn-secondary">Reinitialiser</a>
            </div>
        </form>

        <p class="meta">
            <?php echo fmt_int_local($displayableRows); ?> ligne<?php echo ($displayableRows > 1 ? 's' : ''); ?> affichee<?php echo ($displayableRows > 1 ? 's' : ''); ?>,
            sur <?php echo fmt_int_local($totalRows); ?> resultat<?php echo ($totalRows > 1 ? 's' : ''); ?> correspondant<?php echo ($totalRows > 1 ? 's' : ''); ?>.
        </p>

        <?php if ($totalRows > $maxRows) { ?>
            <p class="warning">
                Seules les <?php echo $maxRows; ?> premieres lignes sont affichees pour des raisons de performance.
                Merci d'affiner votre recherche.
            </p>
        <?php } ?>

        <div class="sort-box">
            <strong>Tri actuel :</strong> <?php echo safe_html($currentSortLabel); ?>, ordre <?php echo safe_html($currentOrderLabel); ?>.
        </div>
    </section>

    <section class="panel">
        <h2>Methode</h2>
        <p>
            Cette page propose une <span class="accent">lecture exploratoire</span> de donnees publiques.
            Il ne s'agit pas d'un classement officiel.
        </p>
        <ul class="method-list">
            <li><strong>Evolution des effectifs</strong> = effectif de terminale moins effectif de seconde.</li>
            <li><strong>Mentions ponderees/Score mentions</strong> = taux de mentions multiplie par la racine carree de l'effectif de terminale.</li>
            <!--<li><strong>Score global</strong> = combinaison ponderee d'indicateurs normalises.</li>-->
        </ul>
        <p class="small">
            Ponderation de reference : 40% IVAL, 25% evolution des effectifs, 15% taux de reussite au bac, 20% mentions ponderees.
        </p>
    </section>

    <section class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th class="num">Rang</th>
                    <th>Lycee</th>
                    <th>Ville</th>
                    <th>Departement</th>
                    <!--<th>Academie</th>-->
                    <th>Statut</th>
                    <th class="num">IVAL</th>
                    <th class="num">Bac</th>
                    <th class="num">Mentions</th>
                    <th class="num">Seconde</th>
                    <th class="num">Terminale</th>
                    <th class="num">Evolution</th>
                    <th class="num">Score mentions</th>
                    <!--<th class="num">Score global</th>-->
                    <th>Fiche</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if (!$rows) {
                echo '<tr><td colspan="15">Aucun resultat</td></tr>';
            } else {
                $rank = $offset + 1;

                foreach ($rows as $row) {
                    $ficheUrl = 'fiche.php?id=' . urlencode($row['id']);
                    $officialUrl = isset($row['fiche_ival_url']) ? trim((string)$row['fiche_ival_url']) : '';

                    echo '<tr>';

                    echo '<td class="num rank-cell"><span class="rank-badge">' . $rank . '</span></td>';

                    echo '<td>';
                    echo '<a class="lycee-link" href="' . safe_html($ficheUrl) . '">' . safe_html(isset($row['nom']) ? $row['nom'] : '') . '</a><br>';
                    echo '<span class="small">Source ' . safe_html(isset($row['source_annee']) ? $row['source_annee'] : '') . '</span>';
                    if (!empty($row['uai'])) {
                        echo '<br><span class="small">UAI ' . safe_html($row['uai']) . '</span>';
                    }
                    if ($officialUrl !== '') {
                        echo '<br><a class="official-link" href="' . safe_html($officialUrl) . '" target="_blank" rel="noopener noreferrer">Fiche officielle</a>';
                    }
                    echo '</td>';

                    echo '<td>' . safe_html(isset($row['ville']) ? $row['ville'] : '') . '</td>';
                    echo '<td>' . safe_html(isset($row['departement']) ? $row['departement'] : '') . '</td>';
                    //echo '<td>' . safe_html(isset($row['academie']) ? $row['academie'] : '') . '</td>';
                    echo '<td>' . safe_html(isset($row['statut']) ? $row['statut'] : '') . '</td>';
                    echo '<td class="num score-main">' . fmt_num(isset($row['ival']) ? $row['ival'] : null, 1) . '</td>';
                    echo '<td class="num">' . fmt_num(isset($row['taux_bac']) ? $row['taux_bac'] : null, 1) . '</td>';
                    echo '<td class="num">' . fmt_num(isset($row['taux_mentions']) ? $row['taux_mentions'] : null, 1) . '</td>';
                    echo '<td class="num">' . fmt_int_local(isset($row['effectif_seconde']) ? $row['effectif_seconde'] : null) . '</td>';
                    echo '<td class="num">' . fmt_int_local(isset($row['effectif_terminale']) ? $row['effectif_terminale'] : null) . '</td>';
                    echo '<td class="num">' . fmt_signed_local(isset($row['evolution_effectif']) ? $row['evolution_effectif'] : null) . '</td>';
                    echo '<td class="num">' . fmt_num(isset($row['score_mentions']) ? $row['score_mentions'] : null, 2) . '</td>';
                    //echo '<td class="num score-main">' . fmt_num(isset($row['score_global']) ? $row['score_global'] : null, 3) . '</td>';
                    echo '<td><a class="detail-btn" href="' . safe_html($ficheUrl) . '">Voir</a></td>';

                    echo '</tr>';

                    $rank++;
                }
            }
            ?>
            </tbody>
        </table>
    </section>

    <?php if ($totalPages > 1) { ?>
        <nav class="pagination" aria-label="Pagination">
            <?php if ($page > 1) { ?>
                <a href="<?php echo safe_html(build_page_url($page - 1)); ?>">&larr; Precedent</a>
            <?php } ?>

            <?php
            $start = max(1, $page - 2);
            $end = min($totalPages, $page + 2);

            for ($i = $start; $i <= $end; $i++) {
                if ($i == $page) {
                    echo '<span class="current">' . $i . '</span>';
                } else {
                    echo '<a href="' . safe_html(build_page_url($i)) . '">' . $i . '</a>';
                }
            }
            ?>

            <?php if ($page < $totalPages) { ?>
                <a href="<?php echo safe_html(build_page_url($page + 1)); ?>">Suivant &rarr;</a>
            <?php } ?>
        </nav>
    <?php } ?>

    <section class="panel" style="margin-top:20px;">
        <h2>Sources</h2>
        <p>
            Les donnees proviennent des publications publiques du ministere de l'Education nationale :
            indicateurs IVAL, taux de reussite au bac, taux de mentions, indicateurs d'acces au bac et effectifs.
        </p>
        <p class="small">
            Les champs calcules affiches sur cette page relevent d'un modele d'analyse independant.
        </p>
    </section>

    <p class="footer-note">
        Cette page ne comporte pas d'espace de commentaire et affiche uniquement des donnees publiques agregees.
    </p>

</div>
</body>
</html>