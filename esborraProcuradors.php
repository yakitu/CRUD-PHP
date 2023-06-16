<?php
include_once("connexio.php");
$id = $_GET["id"];
$baseDades->query("delete from Procuradors where id='$id'");
header("Location:crudProcuradors.php");