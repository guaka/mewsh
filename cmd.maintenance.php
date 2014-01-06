<?php

function maintenance_help() {
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


if (count($options->arguments) <= $cmdOptNumber + 1) {
  maintenance_help();

} else {

  $cmd = $options->arguments[$cmdOptNumber + 1];
  if (!fileIsPhp($cmd)) {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, $cmdOptNumber + 1);
  include 'maintenance/' . $cmd;
}