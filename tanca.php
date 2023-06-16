<?php
session_start(); //Continua la sessió vigent
session_destroy(); //Es destrueix la sessió vigent
header('Location: index.php');
