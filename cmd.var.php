<?php

require_once 'mw-init.php';

function var_help() {
  echo "Shows value of variables such as wgSitename";
}

function var_var($var) {
  static $has_run = 0;
  global $$var;

  $has_run++;
  if (isset($$var)) {
    echo $$var . "\n";
  } elseif ($has_run < 2) {
    var_var('wg' . ucfirst($var));
  } else {
    echo "$var is not set\n";
  }
}


if (in_array('var', $args)) {
  var_var($args[array_search('var', $args) + 1]);
} else {
  var_help();
}