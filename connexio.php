<?php
try {
    $baseDades = new PDO('mysql:host=localhost; dbname=valles_db', 'valles', 'valles');
    $baseDades->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $baseDades->exec("set character set utf8");
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
    echo "Línia del error" . $e->getLine();
}
