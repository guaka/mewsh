#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';


require_once 'helpers.php';
require_once 'appSpecs.php';

$aliases = loadAliases();


$subcommands = array('maintenance','pybot', 'db'); // @todo refactor
$options = appSpecs($argv, $subcommands);



$cmdOptNumber = 1;
if (substr($options->arguments[1], 0, 1) == '@') {
  $alias = substr($options->arguments[1], 1);
  $cmdOptNumber++;
} else {
  $alias = false;
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


function aliasOrOption($key) {
  global $alias, $aliases, $mewOptions;
  return $alias ? $aliases[$alias][$key] : $options->arguments[$key];
}



if (in_array($options->arguments[$cmdOptNumber], $subcommands)) { // @todo FIX
  require_once 'cmd.' . $options->arguments[$cmdOptNumber] . '.php';
}