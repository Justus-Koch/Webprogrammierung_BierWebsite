<?php
$abs_path = __DIR__;

// Berechnet den Pfad automatisch, solange die Datei im Root liegt
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$domain = $_SERVER['HTTP_HOST'];

$dir = str_replace('\\', '/', __DIR__);
$docroot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
$folder = str_replace($docroot, '', $dir);

define('ROOT', $protocol . '://' . $domain . $folder . '/');
?>

