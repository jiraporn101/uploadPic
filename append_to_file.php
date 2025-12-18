<?php
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = "jae do\n";
fwrite($myfile, $txt);
$txt = "jung do\n";
fwrite($myfile, $txt);
fclose($myfile);
?>