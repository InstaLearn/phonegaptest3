<?php

$myfile = fopen("out1.txt", "a") or die("Unable to open file!");

fwrite($myfile, "Called\n");

fclose($myfile);

?>
