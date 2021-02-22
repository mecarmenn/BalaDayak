<?php
    $ImageName = $_GET['ImageName'];
    $dir = "products/";
    $dirHandle = opendir($dir);
    while ($file = readdir($dirHandle)) {
        if ($file==$ImageName) {
            unlink($dir.'/'.$file);
        }
    }
?>