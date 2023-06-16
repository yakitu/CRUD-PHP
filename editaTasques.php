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
  if (!isset($_POST["bot_actualitzar"])) {
    $id = $_GET["id"];
    $cre = $_GET["cre"];
    $nom = $_GET["nom"];
    $des = $_GET["des"];
    $est = $_GET["est"];
    $com = $_GET["com"];
  } else {
    $id = $_POST["id"];
    $cre = $_POST["cre"];
    $nom = $_POST["nom"];
    $des = $_POST["des"];
    $est = $_POST["est"];
    $com = $_POST["com"];
    $sql = "update TODO set creador=:cre, nom=:nom, descripció=:des, estat=:est, comentaris=:com where id=:id";
    $resultat = $baseDades->prepare($sql);
    $resultat->execute(array(":cre" => $cre, ":nom" => $nom, ":des" => $des, ":est" => $est, ":com" => $com, ":id" => $id));
    $resultat->closeCursor();
    header("Location:crudTasques.php");
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
        <td>Creador</td>
        <td><label for="cre"></label>
          <input type="text" name="cre" id="cre" value="<?php echo $cre ?>">
        </td>
      </tr>
      <tr>
        <td>Nom</td>
        <td><label for="nom"></label>
          <input type="text" name="nom" id="nom" value="<?php echo $nom ?>">
        </td>
      </tr>
      <tr>
        <td>Descripció</td>
        <td><label for="des"></label>
          <input type="text" name="des" id="des" value="<?php echo $des ?>">
        </td>
      </tr>
      <tr>
        <td>Estat</td>
        <td><label for="est"></label>
          <input type="text" name="est" id="est" value="<?php echo $est ?>">
        </td>
      </tr>
      <tr>
        <td>Comentaris</td>
        <td><label for="com"></label>
          <input type="text" name="com" id="com" value="<?php echo $com ?>">
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="bot_actualitzar" id="bot_actualitzar" value="Actualitzar"></td>
      </tr>
    </table>
  </form>
  <p>&nbsp;</p>
</body>

</html>