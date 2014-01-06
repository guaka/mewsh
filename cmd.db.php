<?php

function db_help() {
  print "Try
    mewsh db dump
";

  
}


if (in_array('dump', $options->arguments)) {
  print "dump database \n";
  print getcwd() . "\n";
  
  set_include_path(get_include_path() . PATH_SEPARATOR . $mewDir);
  define('MEDIAWIKI', 'mewsh');
  $IP = $mewDir;
  $wgVersion = '1.20';
  require_once 'LocalSettings.php';
  live_output_exec("mysqldump $wgDBname -u $wgDBuser -p$wgDBpassword");
} else {
  db_help();
}