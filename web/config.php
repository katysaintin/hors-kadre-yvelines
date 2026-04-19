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

function connect_db()
{
    $host = 'host';
    $base = 'base';
    $user = 'user';
    $pass = 'pass';

    $link = @mysql_connect($host, $user, $pass);

    if (!$link) {
        die('Database connection error.');
    }

    $selected = @mysql_select_db($base, $link);

    if (!$selected) {
        die('Database selection error.');
    }

    @mysql_query("SET NAMES 'utf8'", $link);
    @mysql_query("SET CHARACTER SET utf8", $link);

    return $link;
}
