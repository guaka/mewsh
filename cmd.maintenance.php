<?php

function maintenance_help($filter = false) {
  // Show maintenance/ commands that contain $filter
  $s = scandir('maintenance');
  foreach ($s as $f) {
    if (fileIsPhp($f)) {
      if (!$filter || strpos($f, $filter) !== false) { //php is horrible
        print str_replace('.php', '', $f) . "\t";        
      }
    }
  }
  print PHP_EOL;
}


if (count($args) <= 2) {
  maintenance_help();

} else {

  $cmd = $args[3];
  if (!fileIsPhp($cmd)) {
    $cmd .= '.php';
  }
  if (file_exists('maintenance/' . $cmd)) {
    $argv = array_slice($argv, 2);
    include 'maintenance/' . $cmd;
  } else {
    maintenance_help(str_replace('.php', '', $cmd));
  }
}