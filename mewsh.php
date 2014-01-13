#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

require_once 'helpers.php';
require_once 'appSpecs.php';

$aliases = loadAliases();

$subcommands = array('maintenance','pybot', 'db', 'var'); // @todo refactor
$options = appSpecs($argv, $subcommands);
$args = $options->arguments;

$args = array_filter($args, function($e) {
    return !(strpos($e, 'mewsh') !== false);
  });


if (!$args) {
  help();
  exit();
}


function findAlias($args) {
  foreach ($args as $k => $a) {
    if (substr($a, 0, 1) == '@') {
      $alias = substr($a, 1);
      return $alias;
    }
  }
}


function aliasOrOption($key) {
  global $alias, $aliases, $options;

  if ($alias && $aliases[$alias]) {
    if (array_key_exists($key, $aliases[$alias])) {
      return $aliases[$alias][$key];
    }
  } else {
    if (array_key_exists($key, $options->keys)) {
      return $options[$key]->value;
    }
  }
  return false;
}


$alias = findAlias($args);
$args = array_filter($args, function($e) {
    return substr($e, 0, 1) != '@';
  });

// Set environment based on what we have at this point

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
  // Try harder
  find_installation();
}


if (end($args) == 'cd') {
  // First hacky attempt at cmd aliases
  $args[] = 'var';
  $args[] = 'mewDir';
}

$subcommand = array_shift($args);
if (in_array($subcommand, $subcommands)) { // @todo FIX
  require_once 'cmd.' . $subcommand . '.php';
  break;
}