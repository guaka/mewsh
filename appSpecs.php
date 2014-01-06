<?php

use GetOptionKit\GetOptionKit;
use GetOptionKit\OptionSpecCollection;
use GetOptionKit\ContinuousOptionParser;


function appSpecs($argv, $subcommands) {

// subcommand stack

$specs = new OptionSpecCollection;
$spec_debug = $specs->add('d|debug');
$spec_verbose = $specs->add('v|verbose');
$spec_verbose->description = 'verbose flag';

$appspecs = $specs;

// different command has its own options
$subcommand_specs = array(
                          'maintenance' => $specs,
                          'pybot' => $specs,
                          'db' => $specs,
                          );

// for saved options
$subcommand_options = array();

// command arguments
$arguments = array();


// parse application options first
$parser = new ContinuousOptionParser( $appspecs );
$app_options = $parser->parse( $argv );
while( ! $parser->isEnd() ) {
  if( $parser->getCurrentArgument() == $subcommands[0] ) {
    $parser->advance();
    $subcommand = array_shift( $subcommands );
    $parser->setSpecs( $subcommand_specs[$subcommand] );
    $subcommand_options[ $subcommand ] = $parser->continueParse();
  } else {
    $arguments[] = $parser->advance();
  }
}

$getopt = new GetOptionKit;
$spec = $getopt->add( 'f|foo:' , 'option require value' );  # returns spec object.

$getopt->add( 'b|bar+' , 'option with multiple value' );
$getopt->add( 'z|zoo?' , 'option with optional value' );

$getopt->add( 'f|foo:=i' , 'option requires a integer value' );
$getopt->add( 'f|foo:=s' , 'option requires a string value' );

$getopt->add( 'v|verbose' , 'verbose flag' );
$getopt->add( 'd|debug'   , 'debug flag' );

$result = $getopt->parse( array( 'program' , '-f' , 'foo value' , '-v' , '-d' ) );
$result = $getopt->parse( $argv );

$result->verbose;
$result->debug;
var_dump($result);
return $result;
}