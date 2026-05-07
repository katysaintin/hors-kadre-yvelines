<?php
/*
 * Hors Kadre — Data Exploration Tool
 * Copyright (c) 2026 Katy Ho
 *
 * Code: MIT License
 * Content and analysis: CC BY-NC 4.0
 *
 * https://creativecommons.org/licenses/by-nc/4.0/
 *
 * Author: Katy Saintin Ho 
 */

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function fmt($value, $decimals)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return number_format((float)$value, (int)$decimals, ',', ' ');
}

function fmtInt($value)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return number_format((int)$value, 0, ',', ' ');
}

function fmtSigned($value)
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

function normalize($value, $min, $max)
{
    if ($value === null || $value === '') {
        return 0.0;
    }

    if ((float)$max <= (float)$min) {
        return 0.0;
    }

    return ((float)$value - (float)$min) / ((float)$max - (float)$min);
}

function buildSortUrl($column)
{
    $params = $_GET;

    $currentSort = isset($_GET['sort']) ? $_GET['sort'] : 'score_global';
    $currentOrder = isset($_GET['order']) ? strtolower($_GET['order']) : 'desc';

    $params['sort'] = $column;
    $params['order'] = ($currentSort === $column && $currentOrder === 'desc') ? 'asc' : 'desc';

    return '?' . http_build_query($params);
}

function buildPageUrl($page)
{
    $params = $_GET;
    $params['page'] = (int)$page;

    return '?' . http_build_query($params);
}

function evolutionBadgeClass($value)
{
    if ($value === null || $value === '') {
        return 'badge-neutral';
    }

    $v = (int)$value;

    if ($v > 0) {
        return 'badge-positive';
    }

    if ($v < 0) {
        return 'badge-negative';
    }

    return 'badge-neutral';
}

function scoreBadgeClass($value)
{
    if ($value === null || $value === '') {
        return 'badge-neutral';
    }

    $v = (float)$value;

    if ($v >= 0.66) {
        return 'badge-positive';
    }

    if ($v < 0.33) {
        return 'badge-negative';
    }

    return 'badge-neutral';
}

function sql_escape($value)
{
    return mysql_real_escape_string($value);
}

function fetch_all_assoc($result)
{
    $rows = array();

    if (!$result) {
        return $rows;
    }

    $row = mysql_fetch_assoc($result);

    while ($row) {
        $rows[] = $row;
        $row = mysql_fetch_assoc($result);
    }

    return $rows;
}

function build_query_string($params)
{
    $query = '';

    foreach ($params as $key => $value) {

        if ($value === '' || $value === null) {
            continue;
        }

        if ($query !== '') {
            $query .= '&';
        }

        $query .= urlencode($key) . '=' . urlencode($value);
    }

    return $query;
}

/*
 * Hors Kadre — Fonctions additionnelles Parcoursup
 * Copyright (c) 2026 Katy Saintin
 *
 * Code: MIT License
 * Content and analysis: CC BY-NC 4.0
 *
 * Author: Katy Saintin
 *
 * A AJOUTER à la fin de functions.php
 */

/*
 * Retourne la couleur CSS selon le ratio candidats/place
 */
function ratio_color($ratio)
{
    if ($ratio === null || $ratio === '') {
        return '#999999';
    }

    $v = (float)$ratio;

    if ($v <= 5)  return '#2d8a4e';
    if ($v <= 15) return '#c47f00';
    if ($v <= 30) return '#c45a00';
    return '#b0261e';
}

/*
 * Retourne le label textuel selon le ratio
 */
function ratio_label($ratio)
{
    if ($ratio === null || $ratio === '') {
        return 'N/D';
    }

    $v = (float)$ratio;

    if ($v <= 5)  return 'Accessible';
    if ($v <= 15) return 'Modéré';
    if ($v <= 30) return 'Tendu';
    return 'Très sélectif';
}

/*
 * Formate un pourcentage avec le signe %
 */
function fmt_pct($value, $decimals)
{
    if ($value === null || $value === '') {
        return '-';
    }

    return number_format((float)$value, (int)$decimals, ',', ' ') . '%';
}

/*
 * Retourne couleur CSS selon taux d'accès
 */
function taux_acces_color($value)
{
    if ($value === null || $value === '') {
        return '#999999';
    }

    $v = (float)$value;

    if ($v >= 50) return '#2d8a4e';
    if ($v >= 20) return '#c47f00';
    return '#b0261e';
}

/*
 * Barre HTML pour affichage % bac
 * usage : barre_bac('BG', $pct, '#3b6fc4')
 */
function barre_bac($label, $pct, $color)
{
    $pct = ($pct === null || $pct === '') ? 0 : (float)$pct;
    $w   = min(100, max(0, $pct));

    $html  = '<div style="display:flex;align-items:center;gap:6px;margin-bottom:3px;">';
    $html .= '<span style="width:22px;font-size:.78rem;color:#555;">' . e($label) . '</span>';
    $html .= '<div style="flex:1;background:#d9d1ca;border-radius:3px;height:8px;">';
    $html .= '<div style="width:' . $w . '%;background:' . $color . ';height:8px;border-radius:3px;"></div>';
    $html .= '</div>';
    $html .= '<span style="width:34px;text-align:right;font-size:.78rem;font-weight:700;color:#1B3A6B;">' . fmt_pct($pct, 0) . '</span>';
    $html .= '</div>';

    return $html;
}

/*
 * CORRECTION — remplacer build_parcoursup_page_url() dans functions.php
 * http_build_query() non disponible sur free.fr ancien PHP
 */
 
function build_parcoursup_page_url($page)
{
    $parts = array();
 
    if (isset($_GET['type_formation']) && $_GET['type_formation'] !== '') {
        $parts[] = 'type_formation=' . urlencode($_GET['type_formation']);
    }
    if (isset($_GET['specialite']) && $_GET['specialite'] !== '') {
        $parts[] = 'specialite=' . urlencode($_GET['specialite']);
    }
    if (isset($_GET['commune']) && $_GET['commune'] !== '') {
        $parts[] = 'commune=' . urlencode($_GET['commune']);
    }
    if (isset($_GET['departement']) && $_GET['departement'] !== '') {
        $parts[] = 'departement=' . urlencode($_GET['departement']);
    }
    if (isset($_GET['selectivite']) && $_GET['selectivite'] !== '') {
        $parts[] = 'selectivite=' . urlencode($_GET['selectivite']);
    }
    if (isset($_GET['sort']) && $_GET['sort'] !== '') {
        $parts[] = 'sort=' . urlencode($_GET['sort']);
    }
    $parts[] = 'page=' . intval($page);
 
    return '?' . implode('&', $parts);
}
