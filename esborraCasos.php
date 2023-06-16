<?php
include_once("connexio.php");
$id = $_GET["id"];
$baseDades->query("delete from Casos where id='$id'");
header("Location:crudCasos.php");