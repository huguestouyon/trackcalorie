<?php
    // define("DBHOST", "localhost");
    // define("DBUSER", "root");
    // define("DBPASS", "root");
    // define("DBNAME", "trackcalorie");
    $dbname = "trackcalorie";
    $dbhost = "localhost";
    $dbpass = "root";
    $dbuser = "root";
    try {
        $dsn = "mysql:dbname=".$dbname.";host=".$dbhost;
        $db = new PDO($dsn, $dbuser, $dbpass);
        $db->exec("SET NAMES utf8");
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }catch(PDOException $e) {
        die($e->getMessage());
    }
?>