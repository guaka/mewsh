#!/usr/bin/env php
<?php

/* mewsh is free software available under the GPL.
 * (c) 2014 Kasper Souren
 */


require_once 'vendor/autoload.php';
require_once 'helpers.php';

$mewOptions = new Commando\Command();

$mewOptions->option()
    ->describedAs('Command');

$mewOptions->option('h')
    ->aka('uri')
    ->describedAs('URI');

$mewOptions->option('r')
    ->aka('root')
    ->describedAs('Root directory');




// Start doing something with the options

if (file_exists($_SERVER['HOME'] . '/.mewsh/aliases.mewshrc.php')) {
  require_once $_SERVER['HOME'] . '/.mewsh/aliases.mewshrc.php';
} else {
  print 'no defaults?';
}

$cmdOptNumber = 0;
if (substr($mewOptions[0], 0, 1) == '@') {
  $alias = substr($mewOptions[0], 1);
  $cmdOptNumber++;
}

$cmd = $mewOptions[$cmdOptNumber] ?: false;



function aliasOrOption($key) {
  global $alias, $aliases;
  return isset($alias) ? $aliases[$alias][$key] : $mewOptions[$key];
}


$_SERVER['HTTP_HOST'] = aliasOrOption('uri'); // @todo: only get the hostname, uri might be more than that

$mewDir = aliasOrOption('root');
chdir($mewDir);

if (!mewExists()) {
  find_installation();
}



if (!$cmd) {
  help();
  exit();
} else {

  // $cmd = $argv[1];
  if (!fileIsPhp($cmd)) {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, 1);
  include 'maintenance/' . $cmd;
}