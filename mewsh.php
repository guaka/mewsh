#!/usr/bin/env php
<?php

/* mewsh is free software available under the GPL.
 * (c) 2014 Kasper Souren
 */

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

if (count($argv) < 2) {
  print $description . "\n";
  // show contents of maintenance/
  // look for pywiki otherwise and show those contents
  $s = scandir('.');
  foreach ($s as $f) {
    if (strstr($f, '.php') == '.php') {
      print $f . "\n";
    }
  }
  exit();
} else {
  // var_dump($argv);
  $cmd = $argv[1];
  if (strstr($cmd, '.php') != '.php') {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, 1);
  include $cmd;
}