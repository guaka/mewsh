<?php

// @todo: refactor!

function live_output_exec($cmd) {
  
  while (@ ob_end_flush()); // end all output buffers if any
  
  $proc = popen($cmd, 'r');
  while (!feof($proc))  {
    echo fread($proc, 4096);
    @ flush();
  }
}

// Start doing something with the options
function loadAliases() {
  if (file_exists($_SERVER['HOME'] . '/.mewsh/aliases.mewshrc.php')) {
    require_once $_SERVER['HOME'] . '/.mewsh/aliases.mewshrc.php';
  } else {
    $aliases = array();
    print 'no defaults?';
  }
  return $aliases;
}


function help() {
  $description = "mewsh is a MediaWiki shell

http://github.com/guaka/mewsh

This is still in a proof of concept phase but it's expected to quickly
become a useful and versatile tool. It is making MediaWiki's
maintenance/ directory more accessible and also going to provide
access to Pywikipediabot.

Some useful commands:

    mewsh db dump
    mewsh maintenance update             # Update MediaWiki database
    mewsh maintenance getText Main_Page  # Get the contents of the main page.


";
  print $description . "\n";
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


