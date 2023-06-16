<?php
include_once("connexio.php");
$id = $_GET["id"];
$baseDades->query("delete from TODO where id='$id'");
header("Location:crudTasques.php");