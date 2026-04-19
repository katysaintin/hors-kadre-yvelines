<?php

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