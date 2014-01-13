<?php

function db_help() {
  print "Try
    mewsh db dump
    mewsh db cli
";
}


require_once 'mw-init.php';

function mysql_params() {
  global $wgDBname, $wgDBuser, $wgDBpassword;
  return " $wgDBname -u $wgDBuser -p$wgDBpassword";
}



function db_dump() {
  live_output_exec("mysqldump " . mysql_params());
}

function db_cli() {
  // Not sure what the $pipes are about, copied from drush and works
  proc_close(proc_open('mysql ' . mysql_params(),
                       array(0 => STDIN, 1 => STDOUT, 2 => STDERR), $pipes));
}


if (in_array('dump', $args)) {
  db_dump();
} else if (in_array('cli', $args)) {
  db_cli();
} else {
  db_help();
}