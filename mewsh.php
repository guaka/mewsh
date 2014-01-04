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
    ->aka('host')
    ->describedAs('Hostname');

$mewOptions->option('d')
    ->aka('dir')
    ->describedAs('Directory');


if ($mewOptions['host']) {
  $_SERVER['HTTP_HOST'] = $mewOptions['host'];
}

if ($mewOptions['dir']) {
  $mewDir = $mewOptions['dir'];
  chdir($mewDir);
  //TODO: something like... if (!file_exists('LocalSettings.php')) {
  //  find_installation();
  //}
} else {
  find_installation();
}


if ($mewOptions[0]) {
  $cmd = $mewOptions[0];
}

if (!$cmd) {
  help();
  exit();
} else {

  // $cmd = $argv[1];
  if (strstr($cmd, '.php') != '.php') {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, 1);
  include 'maintenance/' . $cmd;
}