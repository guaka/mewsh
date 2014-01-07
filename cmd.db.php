<?php

function db_help() {
  print "Try
    mewsh db dump
    mewsh db cli
";
}


set_include_path(get_include_path() . PATH_SEPARATOR . $mewDir);
define('MEDIAWIKI', 'mewsh');
$IP = $mewDir;
$wgVersion = '1.20'; // @todo: figure this out
require_once 'LocalSettings.php';
function wfProfileIn() {}
function wfProfileOut() {}

function mysql_params() {
  global $wgDBname, $wgDBuser, $wgDBpassword;
  return " $wgDBname -u $wgDBuser -p$wgDBpassword";
}



function db_dump($cmd) {
  live_output_exec("mysqldump " . mysql_params());
}

function db_cli() {
  // Not sure what the $pipes are about, copied from drush and works
  proc_close(proc_open('mysql ' . mysql_params(),
                       array(0 => STDIN, 1 => STDOUT, 2 => STDERR), $pipes));
}


if (in_array('dump', $options->arguments)) {
  db_dump();
} else if (in_array('cli', $options->arguments)) {
  db_cli();
} else {
  db_help();
}