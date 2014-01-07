<?php

$command = 'ssh ' . $remoteHost . ' ' . join(' ', $argv);

// Not sure what the $pipes are about, copied from drush (its mysql stuff) and works
proc_close(proc_open($command,
                     array(0 => STDIN, 1 => STDOUT, 2 => STDERR), $pipes));
