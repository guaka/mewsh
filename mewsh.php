#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

require_once 'helpers.php';
require_once 'appSpecs.php';

$aliases = loadAliases();

$subcommands = array('maintenance','pybot', 'db', 'var'); // @todo refactor
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
  return $alias 
    ? (array_key_exists($key, $aliases[$alias]) 
       ? $aliases[$alias][$key] 
       : false) 
    : (array_key_exists($key, $args) ? $args[$key] : false);
}

// Set environment based on what we have now


if ($remoteHost = aliasOrOption('remote-host')) {
  include 'remote-host.php';
  exit();
}

$_SERVER['HTTP_HOST'] = aliasOrOption('uri'); // @todo: only get the hostname, uri might be more than that
$mewDir = aliasOrOption('root');
if ($mewDir) {
  chdir($mewDir);
}
if (!mewExists()) {
  find_installation();
}


if (end($args) == 'cd') {
  // First hacky attempt at cmd aliases
  $args[] = 'var';
  $args[] = 'mewDir';
  $cmdOptNumber++;
}


if (in_array($args[$cmdOptNumber], $subcommands)) { // @todo FIX
  require_once 'cmd.' . $args[$cmdOptNumber] . '.php';
}