<?php

// @todo: refactor!

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



function mewExists($dir = '') {
  return (file_exists($dir . 'LocalSettings.php'));
} 



function find_installation() {
  global $mewDir;
  $cwd = getcwd() . '/';
  $pieces = explode('/', $cwd);
  print $cwd . "\n";
  $up = '';
  $found = false;
  for ($i = 0; $i < count($pieces)-2; $i++) {
    if (mewExists($up)) {
      chdir($cwd . $up);
      $found = true;
      break;
    }
    $up .= '../';
  }
  if (mewExists('wiki/')) {
    chdir ($cwd . 'wiki');
    $found = true;
  }
  if (mewExists('w/')) {
    chdir ($cwd . 'w');
    $found = true;
  }

  if (!$found) {
    echo "No MediaWiki installation found. mewsh might be able to install it for you one day.\n";
    exit();
  } else {
    $mewDir = getcwd();
    return $mewDir;
  }
}

function fileIsPhp($f) {
  return substr($f, -4) == '.php';
}


function show_maintenance_commands() {
  // show contents of maintenance/
  // look for pywiki otherwise and show those contents
  $s = scandir('maintenance');
  foreach ($s as $f) {
    if (fileIsPhp($f)) {
      print str_replace('.php', '', $f) . "\t";
    }
  }
  print PHP_EOL;
}
