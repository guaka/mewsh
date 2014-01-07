<?php

$IP = $mewDir;
set_include_path(get_include_path() . PATH_SEPARATOR . $IP);
define('MEDIAWIKI', 'mewsh');
$wgVersion = '1.20'; // @todo: figure this out

require_once 'LocalSettings.php';
function wfProfileIn() {}
function wfProfileOut() {}
