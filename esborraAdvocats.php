<?php
include_once("connexio.php");
$id = $_GET["id"];
$baseDades->query("delete from Advocats where id='$id'");
header("Location:crudAdvocats.php");