#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

require_once 'helpers.php';
require_once 'appSpecs.php';

$aliases = loadAliases();

$subcommands = array('maintenance','pybot', 'db'); // @todo refactor
$options = appSpecs($argv, $subcommands);
$args = $options->arguments;

if (count($args) < 2) {
  help();
  exit();
}


$cmdOptNumber = 1;  // @todo This var sucks. Make it not suck.
if (substr($args[1], 0, 1) == '@') {
  $alias = substr($args[1], 1);
  $cmdOptNumber++;
} else {
  $alias = false;
}


function aliasOrOption($key) {
  global $alias, $aliases, $args;
  return $alias ? 
    $aliases[$alias][$key] : 
    (array_key_exists($key, $args) ? $args[$key] : false);
}

// Set environment based on what we have now

$_SERVER['HTTP_HOST'] = aliasOrOption('uri'); // @todo: only get the hostname, uri might be more than that
$mewDir = aliasOrOption('root');
if ($mewDir) {
  chdir($mewDir);
}
if (!mewExists()) {
  find_installation();
}





if (in_array($args[$cmdOptNumber], $subcommands)) { // @todo FIX
  require_once 'cmd.' . $args[$cmdOptNumber] . '.php';
}