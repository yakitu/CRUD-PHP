<?php
include_once("connexio.php");
$nom = $_GET["nom"];
$baseDades->query("delete from usuari where nom='$nom'");
header("Location:crudUsuaris.php");