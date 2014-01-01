#!/usr/bin/env php
<?php

/* mewsh is free software available under the GPL.
 * (c) 2014 Kasper Souren
 */


function help() {
  $description = "mewsh is a MEdiaWiki SHell

http://github.com/guaka/mewsh

This is still in a proof of concept phase but it's expected to quickly
become a useful and versatile tool. It is making MediaWiki's
maintenance/ directory more accessible and also going to provide
access to Pywikipediabot.

Some useful commands:

    mewsh update             # Update MediaWiki database
    mewsh getText Main_Page  # Get the contents of the main page.

";
  print $description . "\n";

  show_maintenance_commands();
}

function find_installation() {
  $cwd = getcwd() . '/';
  $pieces = explode('/', $cwd);
  print $cwd . "\n";
  $up = '';
  $found = false;
  for ($i = 0; $i < count($pieces)-2; $i++) {
    if (file_exists($up . 'LocalSettings.php')) {
      chdir($cwd . $up);
      $found = true;
      break;
    }
    $up .= '../';
  }
  if (!$found) {
    echo "No MediaWiki installation found.\n";
  }

}

function show_maintenance_commands() {
  // show contents of maintenance/
  // look for pywiki otherwise and show those contents
  $s = scandir('maintenance');
  foreach ($s as $f) {
    if (strstr($f, '.php') == '.php') {
      print $f . "\n";
    }
  }
}


find_installation();

if (count($argv) < 2) {
  help();
  exit();
} else {

  $cmd = $argv[1];
  if (strstr($cmd, '.php') != '.php') {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, 1);
  include 'maintenance/' . $cmd;
}