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
      $exp = $_GET["exp"];
      $desc = $_GET["desc"];
      $estat = $_GET["estat"];
      $idCli = $_GET["idCli"];
      $idAdv = $_GET["idAdv"];
      $idPro = $_GET["idPro"];
    } else {
      $id = $_POST["id"];
      $exp = $_POST["exp"];
      $desc = $_POST["desc"];
      $estat = $_POST["estat"];
      $idCli = $_POST["idCli"];
      $idAdv = $_POST["idAdv"];
      $idPro = $_POST["idPro"];
      $sql = "update Casos set expedient=:exp, descripció=:desc, estat=:estat, 
      idClient=:idCli, idAdvocat=:idAdv, idProcurador=:idPro where id=:id";
      $resultat = $baseDades->prepare($sql);
      $resultat->execute(array(
        ":id" => $id, ":exp" => $exp, ":desc" => $desc, ":estat" => $estat,
        ":idCli" => $idCli, ":idAdv" => $idAdv, ":idPro" => $idPro
      ));
      $resultat->closeCursor();
      header("Location:crudCasos.php");
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
          <td>Expedient</td>
          <td><label for="exp"></label>
            <input type="text" name="exp" id="exp" value="<?php echo $exp ?>">
          </td>
        </tr>
        <tr>
          <td>Descripció</td>
          <td><label for="desc"></label>
            <input type="text" name="desc" id="desc" value="<?php echo $desc ?>">
          </td>
        </tr>
        <tr>
          <td>Estat</td>
          <td><label for="estat"></label>
            <input type="text" name="estat" id="estat" value="<?php echo $estat ?>">
          </td>
        </tr>
        <tr>
          <td>Id Client</td>
          <td><label for="idCli"></label>
            <input type="text" name="idCli" id="idCli" value="<?php echo $idCli ?>">
          </td>
        </tr>
        <tr>
          <td>Id Advocat</td>
          <td><label for="idAdv"></label>
            <input type="text" name="idAdv" id="idAdv" value="<?php echo $idAdv ?>">
          </td>
        </tr>
        <tr>
          <td>Id Procurador</td>
          <td><label for="idPro"></label>
            <input type="text" name="idPro" id="idPro" value="<?php echo $idPro ?>">
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
    echo "<h4>Aquest usuari no està autoritzat per editar casos</h4>";
  }
  ?>
</body>

</html>