<?php


if (count($options->arguments) <= $cmdOptNumber + 1) {
  help(); // @todo this should be specific maintenance help

} else {

  $cmd = $options->arguments[$cmdOptNumber + 1];
  if (!fileIsPhp($cmd)) {
    $cmd .= '.php';
  }
  $argv = array_slice($argv, $cmdOptNumber + 1);
  include 'maintenance/' . $cmd;
}