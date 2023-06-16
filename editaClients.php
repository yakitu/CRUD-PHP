<!doctype html>
<html lang="ca">

<head>
  <meta charset="utf-8">
  <title>CRUD 1.0</title>
  <link rel="stylesheet" type="text/css" href="fulla.css">
</head>

<body>
  <h1>ACTUALITZAR</h1>
  <?php
  session_start(); //S'inicia o continua la sessió vigent
  include_once('connexio.php'); //S'inclou el fitxer de connexió a la base de dades
  if ($_SESSION['admin'] == 1) { //Si l'usuari vigent és administrador
    if (!isset($_POST["bot_actualitzar"])) {
      $id = $_GET["id"];
      $dni = $_GET["dni"];
      $nom = $_GET["nom"];
      $cog1 = $_GET["cog1"];
      $cog2 = $_GET["cog2"];
      $tel = $_GET["tel"];
      $ema = $_GET["ema"];
      $adr = $_GET["adr"];
      $ccpp = $_GET["ccpp"];
    } else {
      $id = $_POST["id"];
      $dni = $_POST["dni"];
      $nom = $_POST["nom"];
      $cog1 = $_POST["cog1"];
      $cog2 = $_POST["cog2"];
      $tel = $_POST["tel"];
      $ema = $_POST["ema"];
      $adr = $_POST["adr"];
      $ccpp = $_POST["ccpp"];
      $sql = "update Clients set dni=:midni, nom=:minom, cognom1=:micog1, cognom2=:micog2, telèfon=:mitel, email=:miema,
    adreça=:miadr, CCPP=:miccpp where id=:miid";
      $resultat = $baseDades->prepare($sql);
      $resultat->execute(array(
        ":miid" => $id, ":midni" => $dni, ":minom" => $nom, ":micog1" => $cog1, ":micog2" => $cog2,
        ":mitel" => $tel, ":miema" => $ema, ":miadr" => $adr, ":miccpp" => $ccpp
      ));
      $resultat->closeCursor();
      header("Location:crudClients.php");
    }
  ?>
    <p>&nbsp;</p>
    <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <table width="25%" border="0" align="center">
        <tr>
          <td></td>
          <td><label for="id"></label>
            <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
          </td>
        </tr>
        <tr>
          <td>DNI</td>
          <td><label for="dni"></label>
            <input type="text" name="dni" id="dni" value="<?php echo $dni ?>">
          </td>
        </tr>
        <tr>
          <td>Nom</td>
          <td><label for="nom"></label>
            <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
          </td>
        </tr>
        <tr>
          <td>Cognom1</td>
          <td><label for="cog1"></label>
            <input type="text" name="cog1" id="cog1" value="<?php echo $cog1 ?>">
          </td>
        </tr>
        <tr>
          <td>Cognom2</td>
          <td><label for="cog2"></label>
            <input type="text" name="cog2" id="cog2" value="<?php echo $cog2 ?>">
          </td>
        </tr>
        <tr>
          <td>Telèfon</td>
          <td><label for="tel"></label>
            <input type="text" name="tel" id="tel" value="<?php echo $tel ?>">
          </td>
        </tr>
        <tr>
          <td>email</td>
          <td><label for="ema"></label>
            <input type="text" name="ema" id="ema" value="<?php echo $ema ?>">
          </td>
        </tr>
        <tr>
          <td>Adreça</td>
          <td><label for="adr"></label>
            <input type="text" name="adr" id="adr" value="<?php echo $adr ?>">
          </td>
        </tr>
        <tr>
          <td>Codi postal</td>
          <td><label for="ccpp"></label>
            <input type="text" name="ccpp" id="ccpp" value="<?php echo $ccpp ?>">
          </td>
        </tr>
        <tr>
          <td colspan="2"><input type="submit" name="bot_actualitzar" id="bot_actualitzar" value="Actualitzar"></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
  <?php
  } else { //Si per contra l'usuari vigent no és administrador
    echo "<h4>Aquest usuari no està autoritzat per editar clients</h4>";
  }
  ?>
</body>

</html>