<?php

set_include_path(get_include_path() . PATH_SEPARATOR . $mewDir);
define('MEDIAWIKI', 'mewsh');
$IP = $mewDir;
$wgVersion = '1.20'; // @todo: figure this out
require_once 'LocalSettings.php';
function wfProfileIn() {}
function wfProfileOut() {}
