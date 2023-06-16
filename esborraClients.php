<?php
include_once("connexio.php");
$id = $_GET["id"];
$baseDades->query("delete from Clients where id='$id'");
header("Location:crudClients.php");